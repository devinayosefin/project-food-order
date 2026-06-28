@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-3xl px-4 py-10">
    <h2 class="text-3xl font-extrabold text-[#a05a2c] mb-8 text-center">History Pembelian</h2>
    @if($orders->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
            Belum ada history pembelian.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-md">
                <thead class="bg-[#f9b233] text-white">
                    <tr>
                        <th class="py-3 px-6 text-left">Tanggal</th>
                        <th class="py-3 px-6 text-left">Nomor Pesanan</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-left">Total</th>
                        <th class="py-3 px-6 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="border-b hover:bg-[#fff7e6]">
                        <td class="py-3 px-6">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</td>
                        <td class="py-3 px-6 font-bold">#{{ $order->order_id }}</td>
                        <td class="py-3 px-6">
                            @php $status = strtolower($order->status); @endphp
                            <span class="inline-block px-4 py-1 rounded-full font-bold text-xs
                                @if($status == 'paid') bg-green-500 text-white
                                @elseif($status == 'pending') bg-yellow-400 text-white
                                @else bg-red-500 text-white @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-6 font-semibold">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="py-3 px-6">
                            <a href="{{ route('receipt', ['order_id' => $order->order_id]) }}" class="block w-full text-center bg-[#a05a2c] text-white px-4 py-2 rounded shadow hover:bg-[#7a3e1a] font-bold transition">Lihat Struk</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
