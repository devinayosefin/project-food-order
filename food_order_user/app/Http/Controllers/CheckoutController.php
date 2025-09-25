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

        // Perbaikan di sini: Menggunakan $menuItem->menu_id
        if(isset($cart[$menuItem->menu_id])) {
            $cart[$menuItem->menu_id]['quantity'] += $quantity;
        } else {
            $cart[$menuItem->menu_id] = [
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
        if (isset($cart[$request->menu_id])) {
            unset($cart[$request->menu_id]);
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect('/')->with('error', 'Keranjang kosong!');
        }
        DB::beginTransaction();
        try {
            $totalPrice = array_sum(array_map(fn($item) => $item['quantity'] * $item['price'], $cart));
            $order = Order::create([
                'customer_id' => 1,
                'total_price' => $totalPrice,
                'order_date' => Carbon::now(),
                'status' => 'Pending',
            ]);
            foreach ($cart as $id => $item) {
                OrderDetail::create([
                    'order_id' => $order->order_id,
                    'menu_id' => $id,
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['quantity'] * $item['price'],
                ]);
            }
            DB::commit();
            session()->forget('cart');
            return redirect()->route('receipt', ['order_id' => $order->order_id]);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Checkout gagal. Silakan coba lagi.');
        }
    }

    public function showReceipt($order_id)
    {
        $order = Order::with('orderDetails.menu')->find($order_id);
        if (!$order) {
            abort(404);
        }
        return view('receipt', compact('order'));
    }
}