@extends('layouts.admin')

@section('content')
<div class="content-card">
    <h2 class="content-title">Laporan Penjualan</h2>

    <div class="report-filters">
        <form method="GET" action="{{ route('admin.reports.index') }}" class="date-filter-form">
            <div class="form-group">
                <label for="start_date" class="form-label">Pilih Rentang</label>
                <div class="date-inputs">
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                    <span>-</span>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>
            </div>
            <button type="submit" class="btn btn-submit-small">Filter</button>
        </form>
    </div>

    <div class="report-summary">
        <div class="summary-box">
            <p>Total Pesanan Masuk</p>
            <span>{{ $totalOrders }}</span>
        </div>
        <div class="summary-box">
            <p>Jumlah Pendapatan</p>
            <span>Rp{{ number_format($totalRevenue, 0, ',', '.') }}</span>
        </div>
    </div>
</div>

<div class="report-charts">
    <div class="chart-container content-card">
        <h3>Line Chart Penjualan</h3>
        <canvas id="lineChart"></canvas>
    </div>
    <div class="chart-container content-card">
        <h3>Pie Chart Menu Terjual</h3>
        <canvas id="pieChart"></canvas>
    </div>
</div>
@endsection

@push('scripts')
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
            options: { responsive: true, maintainAspectRatio: false }
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
                    hoverOffset: 4
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    }
});
</script>
@endpush