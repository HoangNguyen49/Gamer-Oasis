<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');
        $coupons = [
            'SAVE10' => 0.10, // Giảm 10%
            'SAVE20' => 0.20, // Giảm 20%
            'SAVE30' => 0.30, // Giảm 30%
        ];

        // Kiểm tra nếu mã giảm giá hợp lệ
        if (array_key_exists($couponCode, $coupons)) {
            // Tính tổng giá trị giảm giá
            $cartItems = session('cart');
            $subtotal = $cartItems ? array_sum(array_column($cartItems, 'price')) : 0;
            $discount = $subtotal * $coupons[$couponCode];

            // Lưu thông tin mã giảm giá vào session
            Session::put('coupon', [
                'code' => $couponCode,
                'discount' => $discount,
                'totalAfterDiscount' => $subtotal - $discount // Tính tổng sau khi giảm
            ]);

            return back()->with('success', 'Coupon applied successfully!');
        }

        return back()->withErrors(['coupon_code' => 'Invalid coupon code.']);
    }
}
