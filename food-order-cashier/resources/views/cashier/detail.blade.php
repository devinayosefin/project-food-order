@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8 bg-[#804A2A] min-h-screen text-white">

    <!-- Judul -->
    <h2 class="text-center text-2xl font-bold mb-6">DETAIL PEMESANAN</h2>

    <!-- Nomor Antrian -->
    <div class="flex justify-center mb-6">
        <div class="bg-white text-black rounded-lg px-10 py-6 text-center">
            <p class="text-lg font-semibold">Nomor Antrian</p>
            <p class="text-5xl font-bold">{{ str_pad($order->queue_number, 2, '0', STR_PAD_LEFT) }}</p>
        </div>
    </div>

    <!-- Status Bayar -->
    <div class="flex justify-center mb-10">
        @if($order->payment && $order->payment->payment_status === 'Paid')
            <span class="bg-[#E6D3C1] text-black px-6 py-2 rounded-md font-semibold">Sudah Bayar</span>
        @else
            <span class="bg-[#E6D3C1] text-black px-6 py-2 rounded-md font-semibold">Belum Bayar</span>
        @endif
    </div>

    <!-- Table Pesanan -->
    <div class="space-y-4 mb-6">
        <div class="grid grid-cols-4 font-bold text-center border-b border-gray-400 pb-2">
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
            <div class="grid grid-cols-4 bg-white text-black rounded-xl p-4 items-center">
                <div class="flex items-center gap-3">
                    <img src="{{ asset($detail->menu->foto) }}" class="h-12 w-12 object-cover rounded-md">
                    <span>{{ $detail->menu->name }}</span>
                </div>
                <span class="text-center">{{ $detail->quantity }}</span>
                <span class="text-center">Rp {{ number_format($detail->menu->price, 0, ',', '.') }}</span>
                <span class="text-center">Rp {{ number_format($itemTotal, 0, ',', '.') }}</span>
            </div>
        @endforeach
    </div>

    <!-- Total & Update Button -->
    <div class="flex justify-between items-center mt-8">
        <form action="{{ route('cashier.payment.update', $order->id) }}" method="POST" class="flex items-center gap-2">
            @csrf
            @method('PUT')
            <select name="status" class="text-black rounded-md px-3 py-2">
                <option value="Pending" {{ $order->payment->payment_status === 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Paid" {{ $order->payment->payment_status === 'Paid' ? 'selected' : '' }}>Paid</option>
                <option value="Cancel" {{ $order->payment->payment_status === 'Cancel' ? 'selected' : '' }}>Cancel</option>
            </select>
            <button type="submit" class="bg-[#D6A989] text-black px-6 py-2 rounded-md font-semibold">
                Update
            </button>
        </form>

        <div class="bg-white text-black px-6 py-2 rounded-md font-bold">
            Total Pesanan : Rp {{ number_format($grandTotal, 0, ',', '.') }}
        </div>
    </div>
</div>
@endsection
