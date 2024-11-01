<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'address' => 'required|string|max:255',
            'email_address' => 'required|email|max:50',
            'product_id' => 'required|array',
        ]);

        // Lấy thông tin từ session giỏ hàng
        $cartItems = session('cart');

        if (empty($cartItems)) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        // Khởi tạo mảng để lưu tên sản phẩm
        $productNames = [];
        $totalPrice = 0;

        // Duyệt qua từng item trong giỏ hàng để lấy tên sản phẩm và tính toán tổng
        foreach ($cartItems as $item) {
            // Kiểm tra xem khóa 'product_id' có tồn tại trong mảng item hay không
            if (!isset($item['product_id']) || !isset($item['product_name']) || !isset($item['quantity']) || !isset($item['price'])) {
                return redirect()->back()->with('error', 'Invalid product data in cart.');
            }

            $productNames[] = $item['product_name']; // Lưu tên sản phẩm vào mảng
            $totalPrice += $item['price'] * $item['quantity']; // Tính tổng giá trị đơn hàng
        }

        // Tạo đơn hàng mới
        foreach ($cartItems as $item) {
            // Tạo đơn hàng cho từng sản phẩm trong giỏ hàng
            $order = new Order();
            $order->full_name = $request->full_name; // Lưu tên khách hàng
            $order->phone = $request->phone; // Lưu số điện thoại
            $order->address = $request->address; // Lưu địa chỉ
            $order->email_address = $request->email_address; // Lưu email
            $order->product_id = $item['product_id']; // Lưu product_id từ giỏ hàng (dưới dạng số nguyên)
            $order->product_name = $item['product_name']; // Lưu tên sản phẩm
            $order->quantity = $item['quantity']; // Lưu số lượng sản phẩm
            $order->subtotal = $item['price'] * $item['quantity']; // Tính tổng giá trị đơn hàng cho sản phẩm
            $order->status = 'pending'; // Trạng thái mặc định
            $order->user_id = null; // Vì đây là cho người dùng chưa đăng nhập
            $order->created_at = now(); // Thời gian hiện tại

            // Lưu đơn hàng
            $order->save();
        }

        // Xóa giỏ hàng trong session sau khi đặt hàng
        session()->forget('cart');
        session()->forget('coupon');
        session()->forget('totalAfterDiscount');

        // Chuyển hướng đến route thích hợp hoặc trả về một view
        return redirect()->route('checkout')->with('success', 'Your order has been placed successfully!');
    }
}
