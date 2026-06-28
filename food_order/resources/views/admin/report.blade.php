<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-[#e7d6c6] font-sans">


    <!-- Header -->
    <header class="bg-yellow-500 text-gray-800 p-4 flex justify-end items-center shadow-lg">
        <nav class="flex gap-4 items-center">
            <a href="{{ route('admin.menu.index') }}" class="hover:underline font-semibold">Dashboard Admin</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="hover:underline ml-4 font-semibold">Logout</button>
            </form>
        </nav>
    </header>
    <!-- Navbar -->
    <nav class="bg-[#8B4513] text-white flex gap-4 px-8 py-3 font-semibold">
        <a href="{{ route('admin.menu.index') }}" class="hover:underline">Kelola Menu dan Stok</a>
        <a href="{{ route('admin.menu.create') }}" class="hover:underline">Tambah Menu</a>
        <a href="{{ route('admin.report') }}" class="hover:underline bg-[#f9b233] px-4 py-2 rounded">Laporan Penjualan</a>
    </nav>

    <main class="max-w-4xl mx-auto mt-8 p-6 bg-white rounded-lg shadow">
        <h2 class="font-bold text-2xl text-[#a05a2c] mb-6 text-center">Laporan Penjualan</h2>
        <div class="mb-8 flex flex-col md:flex-row gap-6 justify-center items-center">
            <form method="GET" action="{{ route('admin.report') }}" class="flex gap-4 items-end">
                <div>
                    <label for="start_date" class="block font-semibold mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" class="px-4 py-2 border border-gray-300 rounded" value="{{ request('start_date') ?? $startDate }}">
                </div>
                <div>
                    <label for="end_date" class="block font-semibold mb-1">Tanggal Akhir</label>
                    <input type="date" name="end_date" id="end_date" class="px-4 py-2 border border-gray-300 rounded" value="{{ request('end_date') ?? $endDate }}">
                </div>
                <button type="submit" class="bg-[#8B4513] text-white px-4 py-2 rounded font-bold hover:bg-[#a05a2c] transition">Filter</button>
            </form>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="bg-yellow-100 border border-yellow-300 rounded-lg p-6 text-center">
                <p class="font-semibold text-lg mb-2">Total Pesanan Masuk</p>
                <span class="text-3xl font-bold text-[#a05a2c]">{{ $totalOrders }}</span>
            </div>
            <div class="bg-yellow-100 border border-yellow-300 rounded-lg p-6 text-center">
                <p class="font-semibold text-lg mb-2">Jumlah Pendapatan</p>
                <span class="text-3xl font-bold text-[#a05a2c]">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white border border-gray-200 rounded-lg p-6" style="max-height:400px;overflow:hidden;">
                <h3 class="font-bold text-xl mb-4 text-[#8B4513]">Line Chart Penjualan</h3>
                <canvas id="lineChart" class="w-full h-64"></canvas>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="font-bold text-xl mb-4 text-[#8B4513]">Pie Chart Menu Terjual</h3>
                <canvas id="pieChart" class="w-full h-64 mb-4"></canvas>
                <div class="mt-4">
                    <h4 class="font-semibold text-lg mb-2 text-[#a05a2c]">Kategori Penjualan</h4>
                    <ul>
                        @foreach($pieChartData as $row)
                        <li class="flex justify-between py-1 border-b text-gray-700">
                            <span>{{ $row->category }}</span>
                            <span>{{ $row->total_sold }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </main>
<!-- scripts are included directly below -->
    </body>
</html>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Data from Controller
    const lineLabels = {!! json_encode($lineChartData->pluck('date')) !!};
    const lineData = {!! json_encode($lineChartData->pluck('sales_count')) !!};
    const pieLabels = {!! json_encode($pieChartData->pluck('category')) !!};
    const pieData = {!! json_encode($pieChartData->pluck('total_sold')) !!};

    // Line Chart
    const ctxLine = document.getElementById('lineChart');
    if (ctxLine) {
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: lineLabels,
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: lineData,
                    borderColor: '#8E5535',
                    backgroundColor: 'rgba(142, 85, 53, 0.1)',
                    fill: true,
                    tension: 0.2
                }]
            },
            options: { responsive: true, maintainAspectRatio: true }
        });
    }

    // Pie Chart
    const ctxPie = document.getElementById('pieChart');
    if (ctxPie) {
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    label: 'Menu Terjual',
                    data: pieData,
                    backgroundColor: ['#593826', '#F3B23B', '#8E5535', '#A88365'],
                    hoverOffset: 3
                }]
            },
            options: { responsive: true, maintainAspectRatio: true }
        });
    }
});
</script>