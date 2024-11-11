<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = User::count();
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('Stock_Quantity', '<', 4)->count();
        $recentOrders = Order::orderBy('created_at', 'desc')->take(4)->get();
        $recentCustomers = User::orderBy('created_at', 'desc')->take(4)->get();

        // Mảng lưu số lượng đơn hàng theo trạng thái cho 6 tháng gần nhất
        $ordersPerMonth = [];
        $deliveredOrdersPerMonth = [];
        $cancelledOrdersPerMonth = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);

            // Tổng số đơn hàng trong tháng
            $ordersPerMonth[] = Order::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            // Số đơn hàng thành công (delivered) trong tháng
            $deliveredOrdersPerMonth[] = Order::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->where('status', 'delivered')
                ->count();

            // Số đơn hàng thất bại (cancelled) trong tháng
            $cancelledOrdersPerMonth[] = Order::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->where('status', 'canceled')
                ->count();
        }

        // Lấy doanh thu theo từng tháng trong 6 tháng gần đây
        $revenuePerMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $revenue = Order::whereYear('created_at', now()->subMonths($i)->year)
                ->whereMonth('created_at', now()->subMonths($i)->month)
                ->sum('subtotal');
            $revenuePerMonth[] = $revenue;
        }

        return view('admin.pages.index-admin', compact('totalCustomers', 'totalOrders', 'totalProducts', 'lowStockProducts', 'recentOrders', 'recentCustomers', 'ordersPerMonth', 'deliveredOrdersPerMonth', 'cancelledOrdersPerMonth', 'revenuePerMonth'));
    }
}
