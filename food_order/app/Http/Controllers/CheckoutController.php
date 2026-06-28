<?php
namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $menuId = $request->input('menu_id');
        $action = $request->input('action');
        foreach ($cart as &$item) {
            if ($item['menu_id'] == $menuId) {
                if ($action === 'increment') {
                    $item['quantity'] += 1;
                } elseif ($action === 'decrement' && $item['quantity'] > 1) {
                    $item['quantity'] -= 1;
                }
                break;
            }
        }
        unset($item);
        session()->put('cart', $cart);
        return back();
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|numeric',
        ]);

        $menuItem = Menu::find($request->input('menu_id'));

        if (!$menuItem) {
            return back()->with('error', 'Menu tidak ditemukan.');
        }

        $quantity = $request->input('quantity', 1);
        $cart = session()->get('cart', []);

        $found = false;
        foreach ($cart as &$item) {
            if ($item['menu_id'] == $menuItem->menu_id) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        unset($item);
        if (!$found) {
            $cart[] = [
                "menu_id" => $menuItem->menu_id,
                "name" => $menuItem->name,
                "quantity" => $quantity,
                "price" => $menuItem->price,
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function showCart()
    {
    $cart = session()->get('cart', []);
    $totalPrice = array_sum(array_map(fn($item) => $item['quantity'] * $item['price'], $cart));
    return view('cart.show', compact('cart', 'totalPrice'));
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        // Hapus hanya satu baris pertama yang menu_id-nya sama, aman jika key tidak ada
        foreach ($cart as $i => $item) {
            if (isset($item['menu_id']) && $item['menu_id'] == $request->menu_id) {
                array_splice($cart, $i, 1);
                break;
            }
        }
        session()->put('cart', $cart);
        return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect('/')->with('error', 'Keranjang kosong!');
        }
        // Ambil customer_id dari user login jika ada
        $customerId = 1;
        if (auth()->check() && auth()->user()->role_id == 3) {
            $customer = \App\Models\Customer::where('user_id', auth()->user()->user_id)->first();
            if ($customer) {
                $customerId = $customer->customer_id;
            }
        }
        DB::beginTransaction();
        try {
            // Validasi stok cukup
            foreach ($cart as $item) {
                $menu = Menu::find($item['menu_id']);
                if (!$menu || $menu->stock < $item['quantity']) {
                    throw new \Exception('Stok menu ' . ($menu ? $menu->name : 'tidak ditemukan') . ' tidak cukup!');
                }
            }
            $totalPrice = array_sum(array_map(fn($item) => $item['quantity'] * $item['price'], $cart));
            $order = Order::create([
                'customer_id' => $customerId,
                'total_price' => $totalPrice,
                'order_date' => Carbon::now(),
                'status' => 'pending',
            ]);
            if (!$order) throw new \Exception('Gagal membuat order');
            foreach ($cart as $item) {
                if (!isset($item['menu_id'])) continue;
                $detail = OrderDetail::create([
                    'order_id' => $order->order_id,
                    'menu_id' => $item['menu_id'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['quantity'] * $item['price'],
                ]);
                if (!$detail) throw new \Exception('Gagal membuat order detail');
            }
            // Buat data payment otomatis setelah order
            \App\Models\Payment::create([
                'order_id' => $order->order_id,
                'cashier_id' => null,
                'payment_date' => Carbon::now(),
                'payment_amount' => $totalPrice,
                'payment_status' => 'pending',
            ]);
            DB::commit();
            session()->forget('cart');
            return redirect()->route('receipt', ['order_id' => $order->order_id]);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }

    public function showReceipt($order_id)
    {
    $order = Order::with(['orderDetails.menu', 'cashier'])->find($order_id);
        if (!$order) {
            abort(404);
        }
        return view('receipt', compact('order'));
    }
}