@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-12">
    <div class="bg-white rounded-2xl shadow-2xl p-10 mb-8 border border-[#f9b233]/40">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
            <div>
                <span class="text-xs text-gray-500">Nomor Antrian</span>
                <div class="text-4xl font-extrabold text-yellow-600 tracking-widest drop-shadow">#{{ $order->order_id }}</div>
            </div>
            <div>
                @php $status = strtolower($order->status ?? '-'); @endphp
                <span class="inline-block px-6 py-2 rounded-full font-extrabold text-lg shadow
                    @if($status == 'paid') bg-green-500 text-white @elseif($status == 'pending') bg-yellow-400 text-gray-800 @else bg-red-500 text-white @endif">
                    {{ strtoupper($order->status) }}
                </span>
            </div>
        </div>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <div class="text-2xl font-bold text-[#a05a2c]">{{ $order->customer->name ?? '-' }}</div>
                <div class="text-base text-gray-500 font-semibold">Tanggal: {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y H:i') }}</div>
            </div>
            <div class="text-right mt-2 md:mt-0">
                <div class="text-base text-gray-500 font-semibold">Total</div>
                <div class="text-3xl font-extrabold text-yellow-700 drop-shadow">Rp{{ number_format($order->total_price, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="mb-8">
            <div class="text-xl font-extrabold mb-4 text-[#a05a2c] tracking-wide">Detail Item</div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-[#f8f5f2] rounded-lg border border-[#f9b233] shadow-md">
                    <thead>
                        <tr class="bg-[#f9b233] text-white">
                            <th class="py-3 px-4 text-left rounded-tl-lg">Menu</th>
                            <th class="py-3 px-4 text-left">Deskripsi</th>
                            <th class="py-3 px-4 text-center">Qty</th>
                            <th class="py-3 px-4 text-right">Harga</th>
                            <th class="py-3 px-4 text-right rounded-tr-lg">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f9b233]">
                        @foreach($order->details as $detail)
                        <tr class="hover:bg-[#fff7e6] transition">
                            <td class="py-3 px-4 flex items-center gap-3">
                                <img src="{{ asset('images/' . $detail->menu->image) }}" alt="{{ $detail->menu->name }}" class="w-12 h-12 object-cover rounded-lg border">
                                <span class="font-semibold text-lg">{{ $detail->menu->name }}</span>
                            </td>
                            <td class="py-3 px-4 text-gray-600">{{ $detail->menu->description }}</td>
                            <td class="py-3 px-4 text-center font-bold text-[#a05a2c]">x{{ $detail->quantity }}</td>
                            <td class="py-3 px-4 text-right font-semibold">Rp{{ number_format($detail->menu->price, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-right font-semibold text-yellow-700">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <form method="POST" action="{{ route('cashier.order.updateStatus', $order->order_id) }}" class="mt-8">
            @csrf
            <div class="flex flex-col md:flex-row items-center gap-4">
                <label for="status" class="font-bold text-lg">Update Status:</label>
                <select name="status" id="status" class="border-2 border-[#f9b233] rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-lg font-semibold">
                    <option value="pending" @if($order->status=='pending') selected @endif>Pending</option>
                    <option value="paid" @if($order->status=='paid') selected @endif>Paid</option>
                    <option value="cancel" @if($order->status=='cancel') selected @endif>Cancel</option>
                </select>
                <button type="submit" class="ml-auto bg-[#f9b233] hover:bg-yellow-600 text-white font-extrabold px-8 py-2 rounded-lg shadow-lg transition text-lg">Update</button>
            </div>
        </form>
    </div>
    <a href="{{ route('cashier.dashboard') }}" class="block text-center text-yellow-700 hover:underline font-extrabold text-lg mt-6">&larr; Kembali ke Dashboard</a>
</div>
@endsection
