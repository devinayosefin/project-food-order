<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;

class CashierController extends Controller
{
    // Menampilkan pesanan Pending
    public function pending()
    {
        $orders = Order::with(['customer', 'payment', 'orderDetails'])
            ->whereHas('payment', fn($q) => $q->where('payment_status', 'Pending'))
            ->orderBy('queue_number')
            ->get();

        $totalOrders    = Order::count();
        $pendingOrders  = Order::whereHas('payment', fn($q)=>$q->where('payment_status','Pending'))->count();
        $finishedOrders = Order::whereHas('payment', fn($q)=>$q->whereIn('payment_status',['Paid','Cancel']))->count();

        return view('cashier.pending', compact('orders','totalOrders','pendingOrders','finishedOrders'));
    }

    // Menampilkan pesanan Selesai (Paid / Cancel)
    public function finished()
    {
        $orders = Order::with(['customer', 'payment', 'orderDetails'])
            ->whereHas('payment', fn($q) => $q->whereIn('payment_status', ['Paid','Cancel']))
            ->orderBy('queue_number')
            ->get();

        $totalOrders    = Order::count();
        $pendingOrders  = Order::whereHas('payment', fn($q)=>$q->where('payment_status','Pending'))->count();
        $finishedOrders = Order::whereHas('payment', fn($q)=>$q->whereIn('payment_status',['Paid','Cancel']))->count();

        return view('cashier.finished', compact('orders','totalOrders','pendingOrders','finishedOrders'));
    }

    // Detail pesanan
    public function detail($id)
    {
        $order = Order::with(['customer', 'orderDetails.menu', 'payment'])
            ->findOrFail($id);

        // Hitung total dari orderDetails
        $total = $order->orderDetails->sum('subtotal');
        $queue = $order->queue_number;
        $status = $order->payment->payment_status ?? 'Pending';

        return view('cashier.detail', compact('order','total','queue','status'));
    }

    // Update status pembayaran
    public function updatePayment(Request $request, $id)
    {
        $payment = Payment::where('order_id', $id)->first();

        if (! $payment) {
            return redirect()->back()->with('error', 'Payment record not found.');
        }

        $status = $request->input('status', 'Paid');
        $payment->payment_status = $status;

        if ($status === 'Paid') {
            $payment->payment_date = now();
        } else {
            $payment->payment_date = null; // reset kalau bukan Paid
        }

        $payment->save();

        // Redirect sesuai status
        if ($status === 'Pending') {
            return redirect()->route('cashier.pending')->with('success', 'Pesanan dipindahkan ke Pending.');
        }

        return redirect()->route('cashier.finished')->with('success', 'Pesanan dipindahkan ke Finished.');
    }
}
