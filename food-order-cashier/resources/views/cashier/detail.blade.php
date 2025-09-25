@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8 bg-[#804A2A] min-h-screen text-white" style="font-family: 'Poppins', sans-serif;">

    <!-- Judul -->
    <h2 class="text-center text-3xl font-bold mb-8 tracking-wide">DETAIL PEMESANAN</h2>

    <!-- Nomor Antrian -->
    <div class="flex justify-center mb-8">
        <div class="bg-white text-black rounded-xl shadow-lg px-10 py-6 text-center w-64">
            <p class="text-lg font-semibold">Nomor Antrian</p>
            <p class="text-6xl font-extrabold text-[#6B3F22] mt-2">
                {{ str_pad($order->queue_number, 2, '0', STR_PAD_LEFT) }}
            </p>
        </div>
    </div>

    <!-- Status Bayar -->
    <div class="flex justify-center mb-10">
        @if($order->payment && $order->payment->payment_status === 'Paid')
            <span class="bg-green-200 text-green-900 px-6 py-2 rounded-lg font-semibold shadow">
                ✅ Sudah Bayar
            </span>
        @elseif($order->payment && $order->payment->payment_status === 'Cancel')
            <span class="bg-red-200 text-red-900 px-6 py-2 rounded-lg font-semibold shadow">
                ❌ Dibatalkan
            </span>
        @else
            <span class="bg-yellow-200 text-yellow-900 px-6 py-2 rounded-lg font-semibold shadow">
                ⏳ Belum Bayar
            </span>
        @endif
    </div>

    <!-- Table Pesanan -->
    <div class="space-y-4 mb-10">
        <!-- Header -->
        <div class="grid grid-cols-4 font-bold text-center border-b border-gray-400 pb-3 uppercase tracking-wide">
            <span>Info Menu</span>
            <span>Jumlah</span>
            <span>Harga Satuan</span>
            <span>Harga Total</span>
        </div>

        @php
            $grandTotal = 0;
        @endphp

        @foreach($order->orderDetails as $detail)
            @php
                $itemTotal = $detail->quantity * $detail->menu->price;
                $grandTotal += $itemTotal;
            @endphp
            <div class="grid grid-cols-4 bg-white text-black rounded-xl p-4 items-center shadow-md">
                <div class="flex items-center gap-3">
                    <img src="{{ asset($detail->menu->foto) }}" class="h-14 w-14 object-cover rounded-lg shadow">
                    <span class="font-medium">{{ $detail->menu->name }}</span>
                </div>
                <span class="text-center font-medium">{{ $detail->quantity }}</span>
                <span class="text-center">Rp {{ number_format($detail->menu->price, 0, ',', '.') }}</span>
                <span class="text-center font-semibold text-[#6B3F22]">Rp {{ number_format($itemTotal, 0, ',', '.') }}</span>
            </div>
        @endforeach
    </div>

    <!-- Total & Update Button -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-6 mt-8">
        <!-- Update Status -->
        <form action="{{ route('cashier.payment.update', $order->id) }}" method="POST" class="flex items-center gap-3 bg-white rounded-xl px-4 py-3 shadow">
            @csrf
            @method('PUT')
            <select name="status" class="text-black rounded-md px-3 py-2 border border-gray-300 focus:ring focus:ring-yellow-400">
                <option value="Pending" {{ $order->payment->payment_status === 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Paid" {{ $order->payment->payment_status === 'Paid' ? 'selected' : '' }}>Paid</option>
                <option value="Cancel" {{ $order->payment->payment_status === 'Cancel' ? 'selected' : '' }}>Cancel</option>
            </select>
            <button type="submit" class="bg-[#D6A989] text-black px-6 py-2 rounded-md font-semibold shadow hover:bg-[#c49373] transition">
                Update
            </button>
        </form>

        <!-- Grand Total -->
        <div class="bg-white text-black px-8 py-4 rounded-xl font-bold shadow-lg text-lg">
            Total Pesanan : 
            <span class="text-[#6B3F22]">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
        </div>
    </div>
</div>
@endsection
