<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;


class BrandController extends Controller
{
    public function index()
    {
        // Hiển thị danh sách các thương hiệu
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        // Thực hiện xác thực dữ liệu
        $request->validate([
            'Brand_name' => 'required|string|max:255', // Xác thực tên thương hiệu
        ]);

        // Tạo thương hiệu mới với thời gian tạo tự động
        $brand = Brand::create([
            'Brand_name' => $request->input('Brand_name'), // Sử dụng 'Brand_name' để lấy dữ liệu
            'CreatedAt' => now(), // Tự động thêm thời gian tạo
        ]);

        // Trả về phản hồi JSON
        return response()->json(['success' => true, 'brand_id' => $brand->Brand_id]);
    }
}
