@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6 p-6">
    <main class="bg-white rounded-2xl shadow-2xl border border-[#f9b233]/40 p-10">
        <!-- Judul dan Tanggal -->
        <div class="text-center mb-6">
            <h2 class="font-extrabold text-3xl text-[#a05a2c] mb-2 drop-shadow">Data Pesanan Masuk</h2>
            <span class="text-lg text-gray-700 font-semibold">
                Tanggal: {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
            </span>
        </div>

        <!-- Summary Box -->
        <div class="flex flex-wrap justify-center gap-6 mb-6">
            <div class="bg-[#f9b233] text-white rounded-xl px-10 py-6 text-center shadow-lg border-2 border-[#f9b233]/60">
                <div class="font-extrabold text-xl tracking-wide">Total Pesanan</div>
                <div class="text-3xl font-extrabold drop-shadow">{{ $pendingOrders + $paidOrders }}</div>
            </div>
            <div class="bg-white border-2 border-[#a05a2c] text-[#a05a2c] rounded-xl px-10 py-6 text-center shadow-lg">
                <div class="font-extrabold text-xl tracking-wide">Belum Bayar</div>
                <div class="text-3xl font-extrabold drop-shadow">{{ $pendingOrders }}</div>
            </div>
            <div class="bg-white border-2 border-green-600 text-green-600 rounded-xl px-10 py-6 text-center shadow-lg">
                <div class="font-extrabold text-xl tracking-wide">Pesanan Selesai</div>
                <div class="text-3xl font-extrabold drop-shadow">{{ $paidOrders }}</div>
            </div>
        </div>

        <!-- Filter Button -->
        <div class="flex justify-center flex-wrap gap-4 mb-6">
            <form method="GET" action="" class="inline">
                <input type="hidden" name="filter" value="pending">
                <button type="submit" class="px-8 py-2 rounded-lg font-extrabold shadow transition text-lg tracking-wide {{ request('filter', 'pending') == 'pending' ? 'bg-[#a05a2c] text-white' : 'bg-gray-200 text-[#a05a2c]' }}">
                    Belum Bayar
                </button>
            </form>
            <form method="GET" action="" class="inline">
                <input type="hidden" name="filter" value="selesai">
                <button type="submit" class="px-8 py-2 rounded-lg font-extrabold shadow transition text-lg tracking-wide {{ request('filter') == 'selesai' ? 'bg-[#f9b233] text-white' : 'bg-gray-200 text-[#a05a2c]' }}">
                    Pesanan Selesai
                </button>
            </form>
        </div>

        <!-- Tabel Pesanan -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-[#f8f5f2] rounded-lg border border-[#f9b233] shadow-md">
                <thead>
                    <tr class="bg-[#f9b233] text-white">
                        <th class="py-4 px-5 text-left rounded-tl-lg font-semibold tracking-wide border-b border-[#f9b233]">Nomor Antrian</th>
                        <th class="py-4 px-5 text-left font-semibold tracking-wide border-b border-[#f9b233]">Nama Customer</th>
                        <th class="py-4 px-5 text-left font-semibold tracking-wide border-b border-[#f9b233]">Total Pesanan</th>
                        <th class="py-4 px-5 text-left font-semibold tracking-wide border-b border-[#f9b233]">Status</th>
                        <th class="py-4 px-5 text-left font-semibold tracking-wide border-b border-[#f9b233]">Rekap Menu</th>
                        <th class="py-4 px-5 text-left rounded-tr-lg font-semibold tracking-wide border-b border-[#f9b233]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f9b233]">
                    @php
                        $filter = request('filter', 'pending');
                        $filteredOrders = $orders->filter(function($order) use ($filter) {
                            if ($filter == 'pending') {
                                return strtolower($order->status) == 'pending';
                            } elseif ($filter == 'selesai') {
                                return in_array(strtolower($order->status), ['paid', 'cancel']);
                            }
                            return false;
                        });
                    @endphp
                    @forelse($filteredOrders as $order)
                        <tr class="hover:bg-[#fff7e6] transition">
                            <td class="py-4 px-5 font-bold text-[#a05a2c]">{{ sprintf('%02d', $loop->iteration) }}</td>
                            <td class="py-4 px-5">{{ $order->customer->name ?? '-' }}</td>
                            <td class="py-4 px-5">Rp {{ isset($order->total_price) ? number_format($order->total_price, 0, ',', '.') : '-' }}</td>
                            <td class="py-4 px-5">
                                @php $status = strtolower($order->status ?? '-'); @endphp
                                <span class="inline-block px-4 py-1 rounded-full font-bold text-xs
                                    @if($status == 'paid') bg-green-500 text-white
                                    @elseif($status == 'pending') bg-yellow-400 text-white
                                    @else bg-red-500 text-white @endif">
                                    {{ ucfirst($order->status ?? '-') }}
                                </span>
                            </td>
                            <td class="py-4 px-5">
                                @if(isset($order->details) && count($order->details) > 0)
                                    <span class="text-sm text-gray-700">
                                        @foreach($order->details as $d)
                                            <span class="inline-block bg-[#f9b233]/20 rounded px-2 py-1 mr-1 mb-1">{{ ($d->menu->name ?? '-') . ' x' . ($d->quantity ?? '-') }}</span>
                                        @endforeach
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-4 px-5">
                                <a href="{{ route('cashier.order.show', $order->order_id) }}" class="text-white bg-[#a05a2c] hover:bg-[#7a3e1a] px-4 py-2 rounded shadow font-bold transition">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4">Belum ada pesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection
