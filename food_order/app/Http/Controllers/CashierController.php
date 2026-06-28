<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;

class CashierController extends Controller
{
    // Dashboard kasir
    public function dashboard(Request $request)
    {
        $orders = Order::with(['customer', 'details.menu'])->get();
        $pendingOrders = $orders->filter(function($order) {
            return strtolower($order->status) == 'pending';
        })->count();
        $paidOrders = $orders->filter(function($order) {
            return in_array(strtolower($order->status), ['paid', 'cancel']);
        })->count();
        $totalOrders = $pendingOrders + $paidOrders;
        $date = now()->toDateString();
        return view('cashier.dashboard', compact('orders', 'totalOrders', 'pendingOrders', 'paidOrders', 'date'));
    }

    // Detail pesanan
    public function show($id)
    {
        $order = Order::with(['customer', 'details.menu'])->findOrFail($id);
        return view('cashier.order_detail', compact('order'));
    }

    // Update status pesanan
    public function updateStatus(Request $request, $id)
    {
        $order = Order::with('details.menu')->findOrFail($id);
        $newStatus = $request->input('status');
        // Jika status diubah menjadi 'paid' dan sebelumnya bukan 'paid', kurangi stok
        if (strtolower($newStatus) === 'paid' && strtolower($order->status) !== 'paid') {
            foreach ($order->details as $detail) {
                $menu = $detail->menu;
                if ($menu) {
                    $menu->stock = max(0, $menu->stock - $detail->quantity);
                    $menu->save();
                }
            }
            $cashierId = auth()->user()->cashier->cashier_id ?? null;
            if (!$cashierId) {
                \Log::error('CASHIER_ID NULL saat update payment', [
                    'user_id' => auth()->user()->user_id ?? null,
                    'user_email' => auth()->user()->email ?? null,
                    'user' => auth()->user(),
                ]);
            }
            $paymentAmount = $order->details->sum(function($d) { return $d->subtotal; });
            $payment = \App\Models\Payment::where('order_id', $order->order_id)->first();
            if ($payment) {
                $payment->cashier_id = $cashierId;
                $payment->payment_date = now();
                $payment->payment_amount = $paymentAmount;
                $payment->payment_status = 'paid';
                $payment->save();
            } else {
                \App\Models\Payment::create([
                    'order_id' => $order->order_id,
                    'cashier_id' => $cashierId,
                    'payment_date' => now(),
                    'payment_amount' => $paymentAmount,
                    'payment_status' => 'paid',
                ]);
            }
        }
        $order->status = $newStatus;
        $order->save();
        return redirect()->route('cashier.order.show', $id)->with('success', 'Status pesanan berhasil diupdate');
    }
}
