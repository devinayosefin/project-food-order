<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Belum Bayar</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#6B3F22] min-h-screen">

  <!-- Header -->
  <div class="flex justify-between items-center bg-[#FBBF24] px-6 py-3">
    <img src="{{ asset('images/logo (1).png') }}" alt="RotiO" class="h-12">
    <h1 class="text-lg font-semibold text-right">Dashboard Kasir</h1>
  </div>

  <!-- Content -->
  <div class="p-10">
    <h2 class="text-center text-white font-bold text-2xl">
      Data Pesanan Masuk Belum Melakukan Pembayaran <br>
      Tanggal: {{ now()->format('d/m/Y') }}
    </h2>

    <!-- Stats -->
    <div class="flex justify-center gap-6 mt-6">
      <div class="bg-[#F3E5D8] px-6 py-2 rounded-md">
        <p class="text-center font-bold">Total Pemesanan</p>
        <p class="text-center text-2xl font-bold">{{ $totalOrders }}</p>
      </div>
      <div class="bg-[#F3E5D8] px-6 py-2 rounded-md">
        <p class="text-center font-bold">Belum Bayar</p>
        <p class="text-center text-2xl font-bold">{{ $pendingOrders }}</p>
      </div>
      <div class="bg-[#F3E5D8] px-6 py-2 rounded-md">
        <p class="text-center font-bold">Pesanan Selesai</p>
        <p class="text-center text-2xl font-bold">{{ $finishedOrders }}</p>
      </div>
    </div>

    <!-- Tabs -->
    <div class="flex justify-center mt-6 gap-4">
      <a href="{{ route('cashier.pending') }}" class="bg-black text-white px-6 py-2 rounded-md">Belum Bayar</a>
      <a href="{{ route('cashier.finished') }}" class="bg-[#D1D5DB] px-6 py-2 rounded-md">Pesanan Selesai</a>
    </div>

    <!-- Table -->
    <div class="bg-[#F3E5D8] rounded-md mt-8 p-4">
    <table class="w-full text-left">
        <thead>
        <tr class="border-b border-gray-300">
            <th class="py-3">Nomor Antrian</th>
            <th class="py-3">Nama Customer</th>
            <th class="py-3">Total Pesanan</th>
            <th class="py-3">Status</th>
            <th class="py-3">Aksi</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($orders as $order)
        <tr class="border-b">
            <td class="py-4">
            <span class="bg-[#E6B89C] px-3 py-1 rounded-md">
                {{ str_pad($order->queue_number, 2, '0', STR_PAD_LEFT) }}
            </span>
            </td>
            <td class="py-4">{{ $order->customer->name }}</td>

            <!-- total_price dihitung dari orderDetails -->
            <td class="py-4">
                Rp {{ number_format($order->orderDetails->sum(function($detail) {
                    return $detail->quantity * $detail->menu->price;
                }), 0, ',', '.') }}
            </td>

            <td class="py-4">
            <span class="bg-[#E6B89C] px-3 py-1 rounded-md">
                {{ $order->payment->payment_status }}
            </span>
            </td>
            <td class="py-4">
            <a href="{{ route('cashier.orders.detail', $order->id) }}" class="bg-[#E6B89C] px-4 py-1 rounded-md">
                Detail
            </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center py-6">Belum ada pesanan</td>
        </tr>
        @endforelse
        </tbody>
    </table>
    </div>

  </div>
</body>
</html>
