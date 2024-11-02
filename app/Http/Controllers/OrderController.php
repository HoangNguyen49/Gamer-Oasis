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
            })->paginate(20); // Sử dụng phân trang để giao diện tốt hơn

        // Trả về view với các đơn hàng đã lấy và giá trị tìm kiếm
        return view('admin.pages.orders', compact('orders', 'search'));
    }

    public function show($id)
    {
        // Lấy thông tin chi tiết của đơn hàng theo order_id
        $order = Order::with('product') // sử dụng quan hệ 'product'
            ->where('order_id', $id)
            ->firstOrFail();

        // Trả về view với dữ liệu đơn hàng
        return view('admin.pages.order_details', compact('order'));
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
            'product_id' => 'required|array', // Nếu bạn lưu nhiều sản phẩm, hãy xác định rõ hơn
            'payment_method' => 'required|string|in:COD,VNPay',
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
            $order->payment_method = $request->payment_method;

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
