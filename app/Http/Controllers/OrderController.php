<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{

    public function show()
    {
        // Lấy email của người dùng đã đăng nhập
        $email = Auth::user()->Email; // Giữ nguyên trường 'Email' từ model User
        
        // Lấy tất cả đơn hàng theo email_address
        $orders = Order::where('email_address', $email)->get(); // Lấy tất cả đơn hàng
        
        // Trả về view 'order-history' với danh sách đơn hàng
        return view('web.pages.order-history', compact('orders')); // Cập nhật biến 'orders'
    }

}
