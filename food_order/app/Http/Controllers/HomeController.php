<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $customerName = null;
        if (auth()->check()) {
            $userId = auth()->user()->user_id;
            $customer = \App\Models\Customer::where('user_id', $userId)->first();
            if ($customer) {
                $customerName = $customer->name;
            }
        }
        return view('home', compact('customerName'));
    }

    // History pembelian user
    public function history()
    {
        if (!auth()->check() || auth()->user()->role_id != 3) {
            return redirect()->route('login')->withErrors(['email' => 'Silakan login sebagai customer untuk melihat history pembelian.']);
        }
        $customer = \App\Models\Customer::where('user_id', auth()->user()->user_id)->first();
        if (!$customer) {
            return view('history', ['orders' => collect()]);
        }
        $orders = \App\Models\Order::with('orderDetails.menu')
            ->where('customer_id', $customer->customer_id)
            ->orderByDesc('order_date')
            ->get();
        return view('history', compact('orders'));
    }
}