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

    public function success()
    {
        // Hiển thị trang thành công
        return view('web.pages.success'); // Đảm bảo view tồn tại
    }

    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', "Cannot apply coupon, cart is empty !!!");
        }

        $subtotal = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        $coupon = Coupon::where('code', $couponCode)
            ->where('expiration_date', '>=', now())
            ->first();

        if ($coupon) {
            $discount = $coupon->discount_type === 'percentage'
                ? ($coupon->discount_value / 100) * $subtotal
                : $coupon->discount_value;

            $totalAfterDiscount = $subtotal - $discount;

            // Lưu thông tin mã giảm giá vào session để có thể truy xuất trực tiếp
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
