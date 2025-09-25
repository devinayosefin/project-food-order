@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-2xl px-4 py-12">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800">ROTI'O</h1>
        <p class="text-sm text-gray-500 mt-2">masuk GKB belok kiri samping lift</p>
    </div>

    <div class="bg-gray-100 p-8 rounded-xl shadow-md border border-gray-200 text-center mb-8">
        <h2 class="text-3xl font-bold text-red-600 mb-2">MENUNGGU PEMBAYARAN</h2>
        <p class="text-gray-600">Tunjukkan struk ini kepada kasir untuk memproses pembayaran</p>
        
        <div class="mt-6">
            <h4 class="text-xl font-semibold text-gray-700">Nomor Antrian</h4>
            <div class="text-7xl font-extrabold text-blue-700 mt-2">{{ $order->order_id }}</div>
            
            <div class="mt-4 flex justify-center">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Order-{{ $order->order_id }}" alt="QR Code">
            </div>
            <p class="text-xs text-gray-400 mt-2">Scan QR ini untuk konfirmasi</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200 mb-8">
        <div class="flex justify-between items-center mb-2">
            <span class="text-gray-600 font-medium">Tanggal & Waktu:</span>
            <span class="font-semibold">{{ \Carbon\Carbon::parse($order->order_date)->format('d F Y H:i') }}</span>
        </div>
        <div class="flex justify-between items-center">
            <span class="text-gray-600 font-medium">Metode Pembayaran:</span>
            <span class="font-semibold">Belum ditentukan</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
        <h3 class="text-2xl font-semibold mb-4 text-gray-800">Detail Pesanan</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-50">
                    <tr class="text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Menu</th>
                        <th class="py-3 px-6 text-center">Jumlah</th>
                        <th class="py-3 px-6 text-right">Harga</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm font-light">
                    @foreach($order->orderDetails as $detail)
                    <tr class="border-b border-gray-200 last:border-0 hover:bg-gray-50">
                        <td class="py-3 px-6 text-left font-medium">{{ $detail->menu->name }}</td>
                        <td class="py-3 px-6 text-center">{{ $detail->quantity }}</td>
                        <td class="py-3 px-6 text-right">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 text-right font-bold text-xl border-t-2 border-dashed pt-4 text-gray-800">
            Total Pesanan: Rp{{ number_format($order->total_price, 0, ',', '.') }}
        </div>
    </div>
    
    <div class="mt-8 text-center">
        <p class="text-gray-500 text-sm">Terima kasih atas pesanan Anda. Selamat Menikmati!</p>
    </div>
</div>
@endsection