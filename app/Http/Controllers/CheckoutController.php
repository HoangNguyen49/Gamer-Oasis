<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        // Hiển thị trang thanh toán
        return view('web.pages.checkout'); // Đảm bảo view tồn tại
    }

    public function processPayment(Request $request)
    {
        // Xử lý thanh toán
        // Bạn có thể thêm logic thanh toán tại đây

        // Thông báo thành công và chuyển hướng
        return redirect()->route('checkout.success');
    }

    public function success()
    {
        // Hiển thị trang thành công
        return view('web.pages.success'); // Đảm bảo view tồn tại
    }
}
