<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        // Lấy thông tin sản phẩm từ model Product dựa trên product_id
        $product = Product::with('images')->find($productId);
        if (!$product) {
            return response()->json(['error' => 'Product does not exist'], 404);
        }

        // Lưu giỏ hàng trong session
        $cart = Session::get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'product_id' => $productId,
                'product_name' => $product->Product_name,
                'price' => $product->Price,
                'quantity' => $quantity,
                'image' => $product->images->isNotEmpty() ? $product->images->first()->Image_path : 'path/to/default-image.jpg',
            ];
        }

        Session::put('cart', $cart);

        return response()->json(['success' => 'Product added to cart successfully !!!', 'cart' => $cart]);
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
        $subtotal = array_sum(array_column($cart, 'price'));

        // Danh sách mã giảm giá hợp lệ
        $coupons = [
            'SAVE10' => 0.1,  // Giảm 10%
            'SAVE20' => 0.2,  // Giảm 20%
            'SAVE30' => 0.3,  // Giảm 30%
        ];

        // Kiểm tra mã giảm giá hợp lệ
        if (isset($coupons[$couponCode])) {
            // Tính toán giảm giá
            $discount = $coupons[$couponCode] * $subtotal;
            $totalAfterDiscount = $subtotal - $discount;

            // Lưu thông tin mã giảm giá vào session
            Session::put('coupon', [
                'code' => $couponCode,
                'discount' => $discount,
                'totalAfterDiscount' => $totalAfterDiscount
            ]);

            return redirect()->back()->with('success', "Coupon applied successfully !!!");
        } else {
            return redirect()->back()->with('error', "Invalid coupon code !!!");
        }
    }

    public function removeFromCart(Request $request)
    {
        $productId = $request->input('product_id');

        // Lấy danh sách sản phẩm trong giỏ hàng từ session
        $cart = Session::get('cart', []);

        // Kiểm tra nếu sản phẩm tồn tại trong giỏ hàng
        if (isset($cart[$productId])) {
            unset($cart[$productId]); // Xóa sản phẩm khỏi giỏ hàng
            Session::put('cart', $cart); // Cập nhật lại session

            return response()->json(['success' => 'Product removed from cart !!!']);
        } else {
            return response()->json(['error' => 'Product not found in cart !!!'], 404);
        }
    }
}
