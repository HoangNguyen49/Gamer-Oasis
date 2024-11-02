<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    // Hiển thị danh sách tất cả các đơn hàng
    public function index(Request $request)
    {
        // Lấy dữ liệu tìm kiếm
        $search = $request->get('search');

        // Lấy các đơn hàng dựa trên dữ liệu tìm kiếm hoặc tất cả nếu không có tìm kiếm
        $orders = Order::with('product') // Sử dụng quan hệ product
            ->when($search, function ($query, $search) {
                return $query->where('full_name', 'LIKE', "%{$search}%")
                    ->orWhereHas('product', function ($query) use ($search) {
                        $query->where('product_name', 'LIKE', "%{$search}%");
                    });
            }, function ($query) {
                return $query->orderBy('order_id', 'asc'); // Sắp xếp theo order_id tăng dần nếu không có tìm kiếm
            })->paginate(10); // Sử dụng phân trang để giao diện tốt hơn

        // Trả về view với các đơn hàng đã lấy và giá trị tìm kiếm
        return view('admin.pages.orders', compact('orders', 'search'));
    }

    public function show($id)
    {
        // Lấy thông tin chi tiết của đơn hàng theo order_id
        $order = Order::with('product') // sử dụng quan hệ 'product'
            ->where('order_id', $id)
            ->firstOrFail();

        // Khởi tạo mảng productIds để lưu các Product_id tương ứng
        $productIds = [];

        // Duyệt qua từng tên sản phẩm trong đơn hàng
        foreach (explode(', ', $order->product_name) as $productName) {
            $product = Product::where('product_name', $productName)->first();
            if ($product) {
                $productIds[] = $product->Product_id; // Thêm Product_id vào mảng
            }
        }

        // Trả về view với dữ liệu đơn hàng và productIds
        return view('admin.pages.order_details', [
            'order' => $order,
            'productIds' => implode(', ', $productIds), // Nối các Product_id thành chuỗi nếu cần
        ]);
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $product = Product::find($order->Product_id); // Lấy sản phẩm dựa trên Product_id
        $stockQuantity = $product ? $product->Stock_Quantity : 0; // Lấy Stock_Quantity

        return view('admin.pages.edit_order', compact('order', 'stockQuantity')); // Điều hướng đến trang chỉnh sửa
    }

    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'address' => 'required|string|max:255',
            'email_address' => 'required|email|max:50',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1', // Thêm xác thực cho số lượng
            'subtotal' => 'required|numeric|min:0', // Đảm bảo subtotal không âm
            'status' => 'required|in:pending,processed,shipped,delivered,canceled',
        ]);

        // Cập nhật đơn hàng
        $order = Order::findOrFail($id);
        $order->full_name = $request->full_name;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->email_address = $request->email_address;
        $order->product_id = $request->product_id; // Lấy Product ID mới từ request
        $order->quantity = $request->quantity;
        $order->subtotal = $request->subtotal; // Đảm bảo chỉ có một dòng cho subtotal, xóa dòng trùng lặp
        $order->status = $request->status;
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order updated successfully');
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->delete();
            return response()->json(['success' => 'Order deleted successfully!']);
        }

        return response()->json(['error' => 'Order not found'], 404);
    }

    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'address' => 'required|string|max:255',
            'email_address' => 'required|email|max:50',
            'product_id' => 'required|array',
            'payment_method' => 'required|string|in:COD,VNPay',
        ]);

        // Lấy thông tin từ session giỏ hàng
        $cartItems = session('cart');

        if (empty($cartItems)) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        // Khởi tạo mảng để lưu tên sản phẩm và tổng giá trị đơn hàng
        $productNames = [];
        $totalPrice = 0;

        // Duyệt qua từng item trong giỏ hàng để lấy tên sản phẩm và tính toán tổng
        foreach ($cartItems as $item) {
            if (!isset($item['product_id']) || !isset($item['product_name']) || !isset($item['quantity']) || !isset($item['price'])) {
                return redirect()->back()->with('error', 'Invalid product data in cart.');
            }

            $productNames[] = $item['product_name'];
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Kiểm tra xem có mã giảm giá và totalAfterDiscount trong session không
        $totalAfterDiscount = session()->has('coupon.totalAfterDiscount')
            ? session('coupon.totalAfterDiscount')
            : $totalPrice;

        // Tạo một đơn hàng duy nhất cho toàn bộ giỏ hàng
        $order = new Order();
        $order->full_name = $request->full_name;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->email_address = $request->email_address;
        $order->product_name = implode(', ', $productNames);
        $order->quantity = count($request->product_id);
        $order->subtotal = $totalAfterDiscount; // Tổng giá trị đơn hàng sau giảm giá
        $order->status = 'pending';
        $order->user_id = null;
        $order->created_at = now();
        $order->payment_method = $request->payment_method;

        // Lưu đơn hàng
        $order->save();

        // Xóa giỏ hàng và thông tin giảm giá sau khi đặt hàng
        session()->forget('cart');
        session()->forget('coupon');
        session()->forget('totalAfterDiscount');

        return redirect()->route('checkout')->with('success', 'Your order has been placed successfully!');
    }
}
