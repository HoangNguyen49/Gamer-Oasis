<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Coupon;

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
        // Lấy mã giảm giá từ yêu cầu
        $couponCode = $request->input('coupon_code');
        // Lấy giỏ hàng từ session
        $cart = Session::get('cart', []);

        // Kiểm tra xem giỏ hàng có sản phẩm không
        if (empty($cart)) {
            return redirect()->back()->with('error', "Cannot apply coupon, cart is empty !!!");
        }

        // Tính tổng giá trị giỏ hàng
        $subtotal = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity']; // Tính toán subtotal với số lượng
        }, $cart));

        // Truy vấn mã giảm giá từ cơ sở dữ liệu
        $coupon = Coupon::where('code', $couponCode)
            ->where('expiration_date', '>=', now())
            ->first();

        // Kiểm tra mã giảm giá hợp lệ
        if ($coupon) {
            // Kiểm tra loại giảm giá
            if ($coupon->discount_type === 'percentage') {
                // Tính toán giảm giá theo phần trăm
                $discount = ($coupon->discount_value / 100) * $subtotal;
            } else {
                // Nếu là giảm giá cố định
                $discount = $coupon->discount_value;
            }

            // Tính tổng giá trị sau khi giảm giá
            $totalAfterDiscount = $subtotal - $discount;

            // Lưu thông tin mã giảm giá vào session
            Session::put('coupon', [
                'code' => $couponCode,
                'discount' => $discount,
                'totalAfterDiscount' => $totalAfterDiscount
            ]);

            return redirect()->back()->with('success', "Coupon applied successfully !!!");
        } else {
            return redirect()->back()->with('error', "Invalid coupon code or expired !!!");
        }
    }
}
