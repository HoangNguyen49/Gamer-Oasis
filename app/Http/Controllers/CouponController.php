<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponController extends Controller
{
    // Hiển thị danh sách tất cả các coupon
    public function index()
    {
        $coupons = Coupon::all();
        return view('admin.pages.quanlimagiamgia', compact('coupons'));
    }

    // Hiển thị form tạo coupon mới
    public function create()
    {
        return view('admin.pages.create_coupon');
    }

    // Lưu coupon mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:coupons',
            'discount_type' => 'required|string',
            'discount_value' => 'required|numeric',
            'expiration_date' => 'required|date',
        ]);

        // Kiểm tra nếu coupon code đã tồn tại
        $existingCoupon = Coupon::where('code', $request->code)->first();
        if ($existingCoupon) {
            return response()->json(['error' => 'Coupon code already exists!'], 400);
        }

        // Tạo coupon mới
        Coupon::create($request->all());
        return response()->json(['message' => 'Coupon created successfully.']);
    }

    // Hiển thị form chỉnh sửa coupon
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.pages.edit_coupon', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'discount_type' => 'required|string',
            'discount_value' => 'required|numeric',
            'expiration_date' => 'required|date',
        ]);

        $coupon = Coupon::findOrFail($id);

        // Kiểm tra nếu coupon code đã tồn tại, ngoại trừ coupon hiện tại
        $existingCoupon = Coupon::where('code', $request->code)
            ->where('coupon_id', '!=', $id) // Đảm bảo không kiểm tra coupon hiện tại
            ->first();

        if ($existingCoupon) {
            return response()->json(['error' => 'Coupon code already exists!'], 400);
        }

        // Cập nhật coupon
        $coupon->update([
            'code' => $request->input('code'),
            'discount_type' => $request->input('discount_type'),
            'discount_value' => $request->input('discount_value'),
            'expiration_date' => $request->input('expiration_date'),
        ]);

        return response()->json(['message' => 'Coupon updated successfully']);
    }

    // Xóa coupon
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return response()->json(['message' => 'Coupon deleted successfully']);
    }
}
