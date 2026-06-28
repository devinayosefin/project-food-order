<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data yang dibutuhkan untuk laporan
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        // Pastikan format filter tanggal sesuai dengan datetime di database
        if ($startDate) {
            $startDate = \Carbon\Carbon::parse($startDate)->startOfDay()->format('Y-m-d H:i:s');
        }
        if ($endDate) {
            $endDate = \Carbon\Carbon::parse($endDate)->endOfDay()->format('Y-m-d H:i:s');
        }

        // Query total pesanan dan pendapatan
        $ordersQuery = \App\Models\Order::query()->where('status', 'Paid');
        if ($startDate) $ordersQuery->where('order_date', '>=', $startDate);
        if ($endDate) $ordersQuery->where('order_date', '<=', $endDate);
        $totalOrders = $ordersQuery->count();
        $totalRevenue = $ordersQuery->sum('total_price');

        // Statistik penjualan per hari (line chart)
        $lineChartData = $ordersQuery
            ->selectRaw('DATE(order_date) as date, COUNT(*) as sales_count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Statistik jumlah penjualan per kategori (pie chart)
        $pieChartQuery = \App\Models\OrderDetail::join('menu', 'orderdetail.menu_id', '=', 'menu.menu_id')
            ->join('orders', 'orderdetail.order_id', '=', 'orders.order_id')
            ->where('orders.status', 'Paid');
        if ($startDate) $pieChartQuery->where('orders.order_date', '>=', $startDate);
        if ($endDate) $pieChartQuery->where('orders.order_date', '<=', $endDate);
        $pieChartData = $pieChartQuery
            ->selectRaw('menu.category as category, SUM(orderdetail.quantity) as total_sold')
            ->groupBy('menu.category')
            ->get();

        return view('admin.report', compact(
            'startDate',
            'endDate',
            'totalOrders',
            'totalRevenue',
            'lineChartData',
            'pieChartData'
        ));
    } // <- tambahkan ini
} // <- tambahkan ini