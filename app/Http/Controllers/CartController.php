<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Coupon;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        // Lấy sản phẩm kèm theo số lượng tồn kho
        $product = Product::with('images')->find($productId);
        if (!$product) {
            return response()->json(['error' => 'Product does not exist !!!'], 404);
        }

        // Lấy giỏ hàng từ session
        $cart = Session::get('cart', []);
        $currentQuantity = isset($cart[$productId]) ? $cart[$productId]['quantity'] : 0;

        if ($currentQuantity + $quantity > $product->Stock_Quantity) {
            return response()->json(['error' => 'Insufficient inventory !!!'], 400);
        }

        $cart[$productId] = [
            'product_id' => $productId,
            'product_name' => $product->Product_name,
            'price' => $product->Price,
            'quantity' => $currentQuantity + $quantity,
            'stock_quantity' => $product->Stock_Quantity, // Thêm số lượng tồn kho vào giỏ hàng
            'image' => $product->images->isNotEmpty() ? $product->images->first()->Image_path : 'path/to/default-image.jpg',
        ];

        Session::put('cart', $cart);

        return response()->json(['success' => 'Product added to cart successfully !!!', 'cart' => $cart]);
    }

    public function updateQuantity(Request $request)
    {
        $productId = $request->input('product_id');
        $newQuantity = $request->input('quantity');

        // Lấy giỏ hàng từ session
        $cart = Session::get('cart', []);
        if (!isset($cart[$productId])) {
            return response()->json(['error' => 'Product not in cart !!!'], 404);
        }

        // Tìm sản phẩm trong cơ sở dữ liệu
        $product = Product::find($productId);
        if (!$product || $newQuantity > $product->Stock_Quantity) {
            return response()->json(['error' => 'Insufficient inventory !!!', 'currentQuantity' => $cart[$productId]['quantity']], 400);
        }

        // Cập nhật số lượng sản phẩm
        $cart[$productId]['quantity'] = $newQuantity;
        Session::put('cart', $cart);

        // Xóa mã giảm giá khỏi session
        Session::forget('coupon');

        return response()->json(['success' => 'Update quantity successfully !!!', 'cart' => $cart]);
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
