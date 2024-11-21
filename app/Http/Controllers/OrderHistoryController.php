<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderHistory;
use App\Models\VnpayOrder;
use App\Models\User;

class OrderHistoryController extends Controller
{

    public function show()
{
    $email = Auth::user()->Email;
    $orders = OrderHistory::where('email_address', $email)->get();

    // Lấy trạng thái VNPAY tương ứng với từng đơn hàng
    $vnpayOrders = VnpayOrder::whereIn('vnpay_orders_id', $orders->pluck('order_id'))
                              ->pluck('status', 'vnpay_orders_id');

    return view('web.pages.order-history', compact('orders', 'vnpayOrders'));
}


}
