<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subDays(6)->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        // Query orders within the date range
        $ordersQuery = Order::whereBetween(DB::raw('DATE(order_date)'), [$startDate, $endDate]);

        // Clone the query to avoid issues with multiple aggregations
        $totalOrders = $ordersQuery->clone()->count();
        $totalRevenue = $ordersQuery->clone()->sum('total_price');

        // Data for Line Chart (Sales count per day)
        $lineChartData = Order::query()
            ->select(DB::raw('DATE(order_date) as date'), DB::raw('COUNT(order_id) as sales_count'))
            ->whereBetween(DB::raw('DATE(order_date)'), [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
            
        // Data for Pie Chart (Sold items per category)
        $pieChartData = OrderDetail::query()
            ->join('menu', 'orderdetail.menu_id', '=', 'menu.menu_id')
            ->join('orders', 'orderdetail.order_id', '=', 'orders.order_id')
            ->select('menu.category', DB::raw('SUM(orderdetail.quantity) as total_sold'))
            ->whereBetween(DB::raw('DATE(orders.order_date)'), [$startDate, $endDate])
            ->groupBy('menu.category')
            ->get();

        return view('admin.reports.index', compact('totalOrders', 'totalRevenue', 'lineChartData', 'pieChartData', 'startDate', 'endDate'));
    }
}