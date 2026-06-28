@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-2xl px-4 py-12">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800">ROTI'O</h1>
        <p class="text-sm text-gray-500 mt-2">Tasty Until The Last Bite</p>
    </div>

    <!-- Status Pesanan -->
    <div class="bg-gray-100 p-8 rounded-xl shadow-md border border-gray-200 text-center mb-8">
        @php
            $status = strtolower($order->status);
            $statusText = $status == 'pending' ? 'MENUNGGU PEMBAYARAN' : ($status == 'paid' ? 'SUDAH DIBAYAR' : ($status == 'cancel' ? 'DIBATALKAN' : strtoupper($status)));
            $statusColor = $status == 'pending' ? 'text-red-600' : ($status == 'paid' ? 'text-green-600' : ($status == 'cancel' ? 'text-gray-500' : 'text-black'));
        @endphp
        <h2 class="text-3xl font-bold {{ $statusColor }} mb-2">{{ $statusText }}</h2>
        <p class="text-gray-600">
            @if($status == 'pending')
                Tunjukkan struk ini kepada kasir untuk memproses pembayaran
            @elseif($status == 'paid')
                Pesanan Anda sudah dibayar. Terima kasih!
            @elseif($status == 'cancel')
                Pesanan ini telah dibatalkan.
            @else
                Status pesanan: {{ ucfirst($status) }}
            @endif
        </p>

        <!-- Nomor Antrian & QRIS Dinamis -->
        <div class="mt-6">
            <h4 class="text-xl font-semibold text-gray-700">Nomor Antrian</h4>
            <div class="text-7xl font-extrabold text-blue-700 mt-2">{{ $order->order_id }}</div>

            @php
                use GuzzleHttp\Client;
                $payment = \App\Models\Payment::where('order_id', $order->order_id)->first();
                $totalReceipt = $payment ? $payment->payment_amount : 0;
                $qrisBase64 = null;
                if ($payment && $totalReceipt > 0) {
                    $qrisStatis = config('qris.statis');
                    $qrisApiUrl = config('qris.api_url');
                    try {
                        $client = new Client();
                        $response = $client->post($qrisApiUrl, [
                            'json' => [
                                'amount' => $totalReceipt,
                                'qris_statis' => $qrisStatis
                            ]
                        ]);
                        $qrisResponse = json_decode($response->getBody()->getContents(), true);
                        $qrisBase64 = $qrisResponse['qris_base64'] ?? null;
                    } catch (\Exception $e) {
                        $qrisBase64 = null;
                    }
                }
            @endphp

            @if($qrisBase64)
                <div class="mt-4 flex justify-center">
                    <img src="data:image/png;base64,{{ $qrisBase64 }}" alt="QRIS Dinamis">
                </div>
                <p class="text-xs text-gray-400 mt-2">Scan QR ini untuk bayar Rp{{ number_format($totalReceipt,0,',','.') }}</p>
            @else
                <div class="mt-4 flex justify-center">
                    <p class="text-red-500 text-sm">
                        QRIS tidak dapat digenerate saat ini.
                        @if(!$payment)
                            (Data pembayaran tidak ditemukan)
                        @elseif($totalReceipt == 0)
                            (Total pembayaran 0)
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Informasi Pesanan & Pembayaran -->
    @php
        $payment = \App\Models\Payment::where('order_id', $order->order_id)->first();
    @endphp
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200 mb-8">
        <div class="flex justify-between items-center mb-2">
            <span class="text-gray-600 font-medium">Tanggal & Waktu:</span>
            <span class="font-semibold">{{ \Carbon\Carbon::parse($order->order_date)->format('d F Y H:i') }}</span>
        </div>
    
        @if($payment)
        <div class="flex justify-between items-center mb-2">
            <span class="text-gray-600 font-medium">Total Bayar:</span>
            <span class="font-semibold">Rp{{ number_format($payment->payment_amount, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between items-center mb-2">
            <span class="text-gray-600 font-medium">Status Pembayaran:</span>
            <span class="font-semibold">
                @if(strtolower($order->status) == 'cancel')
                    Cancel
                @else
                    {{ ucfirst($payment->payment_status) }}
                @endif
            </span>
        </div>
        @if($payment->cashier)
        <div class="flex justify-between items-center mb-2">
            <span class="text-gray-600 font-medium">Nama Kasir:</span>
            <span class="font-semibold">{{ $payment->cashier->name }}</span>
        </div>
        <div class="flex justify-between items-center mb-2">
            <span class="text-gray-600 font-medium">No. Telepon Kasir:</span>
            <span class="font-semibold">{{ $payment->cashier->phone_number }}</span>
        </div>
        @endif
        @endif
    </div>

    <!-- Detail Pesanan -->
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
            Total Pesanan: Rp{{ number_format($totalReceipt, 0, ',', '.') }}
        </div>
    </div>
    
    <!-- Footer -->
    <div class="mt-8 text-center">
        <p class="text-gray-500 text-sm">Terima kasih atas pesanan Anda. Selamat Menikmati!</p>
    </div>
</div>
@endsection
