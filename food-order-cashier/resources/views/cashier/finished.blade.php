<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Pesanan Selesai</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Import Google Fonts Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-[#6B3F22] min-h-screen">

  <!-- Header -->
  <div class="flex justify-between items-center bg-[#FBBF24] px-6 py-3 shadow-md">
    <img src="{{ asset('images/logo (1).png') }}" alt="RotiO" class="h-12">
    <h1 class="text-lg font-semibold text-right">Dashboard Kasir</h1>
  </div>

  <!-- Content -->
  <div class="p-10">
    <h2 class="text-center text-white font-bold text-2xl leading-relaxed">
      Data Pesanan Selesai Telah Melakukan Pembayaran <br>
      <span class="text-lg font-medium">Tanggal: {{ now()->format('d/m/Y') }}</span>
    </h2>

    <!-- Stats -->
    <div class="flex justify-center gap-6 mt-6 flex-wrap">
      <div class="bg-[#F3E5D8] w-48 h-28 rounded-xl shadow-md flex flex-col justify-center items-center">
        <p class="font-semibold text-base text-center">Total Pemesanan</p>
        <p class="text-2xl font-bold text-[#6B3F22] mt-1">{{ $totalOrders }}</p>
      </div>
      <div class="bg-[#F3E5D8] w-48 h-28 rounded-xl shadow-md flex flex-col justify-center items-center">
        <p class="font-semibold text-base text-center">Belum Bayar</p>
        <p class="text-2xl font-bold text-[#6B3F22] mt-1">{{ $pendingOrders }}</p>
      </div>
      <div class="bg-[#F3E5D8] w-48 h-28 rounded-xl shadow-md flex flex-col justify-center items-center">
        <p class="font-semibold text-base text-center">Pesanan Selesai</p>
        <p class="text-2xl font-bold text-[#6B3F22] mt-1">{{ $finishedOrders }}</p>
      </div>
    </div>


    <!-- Tabs -->
    <div class="flex justify-center mt-8 gap-4">
      <a href="{{ route('cashier.pending') }}" class="bg-[#D1D5DB] px-6 py-2 rounded-md shadow hover:bg-[#c9cdd4] transition">Belum Bayar</a>
      <a href="{{ route('cashier.finished') }}" class="bg-black text-white px-6 py-2 rounded-md shadow hover:opacity-90 transition">Pesanan Selesai</a>
    </div>

    <!-- Table -->
    <div class="bg-[#F3E5D8] rounded-xl mt-10 p-6 shadow-lg overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="border-b border-gray-300 text-sm font-medium text-[#6B3F22]">
            <th class="py-3 px-2">Nomor Antrian</th>
            <th class="py-3 px-2">Nama Customer</th>
            <th class="py-3 px-2">Total Pesanan</th>
            <th class="py-3 px-2">Status</th>
            <th class="py-3 px-2">Aksi</th>
          </tr>
        </thead>
        <tbody class="text-sm">
          @forelse ($orders as $order)
          <tr class="border-b hover:bg-[#ecdacc] transition">
            <td class="py-4 px-2">
              <span class="bg-[#E6B89C] px-3 py-1 rounded-md font-semibold">
                {{ str_pad($order->queue_number, 2, '0', STR_PAD_LEFT) }}
              </span>
            </td>
            <td class="py-4 px-2">{{ $order->customer->name }}</td>
            <td class="py-4 px-2 font-medium">
              Rp {{ number_format($order->orderDetails->sum(function($detail) {
                  return $detail->quantity * $detail->menu->price;
              }), 0, ',', '.') }}
            </td>
            <td class="py-4 px-2">
              <span class="bg-[#E6B89C] px-3 py-1 rounded-md font-medium">
                {{ $order->payment->payment_status }}
              </span>
            </td>
            <td class="py-4 px-2">
              <a href="{{ route('cashier.orders.detail', $order->id) }}" class="bg-[#E6B89C] px-4 py-1 rounded-md font-medium hover:bg-[#d9a583] transition">
                Detail
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center py-6 text-gray-600">Belum ada pesanan</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </div>
</body>
</html>
