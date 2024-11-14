<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;


class BrandController extends Controller
{
    public function index()
    {
        // Hiển thị danh sách các thương hiệu
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));
    }

    public function indexBrand()
    {
        $brands = Brand::all();
        return view('admin.pages.brand', compact('brands'));
    }

    public function deleteBrand($id)
    {
        // Tìm brand theo ID
        $brand = Brand::find($id);

        // Kiểm tra nếu brand tồn tại
        if ($brand) {
            // Kiểm tra xem có sản phẩm nào liên quan đến brand này không
            $productCount = Product::where('brand_id', $id)->count();

            if ($productCount > 0) {
                // Nếu có sản phẩm liên quan đến brand, trả về thông báo lỗi
                return redirect()->route('brand.management')->with('error', 'Cannot delete the brand because there are products associated with it.');
            }

            // Xóa brand nếu không có sản phẩm liên quan
            $brand->delete();

            // Redirect hoặc trả về thông báo thành công bằng tiếng Anh
            return redirect()->route('brand.management')->with('success', 'Brand deleted successfully.');
        }

        // Nếu không tìm thấy brand, có thể redirect hoặc thông báo lỗi
        return redirect()->route('brand.management')->with('error', 'Brand not found.');
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

    // Search Function
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Kiểm tra xem từ khóa tìm kiếm có hợp lệ không
        if (empty($keyword)) {
            return redirect()->route('brand.management')->with('error', 'Please enter a keyword to search.');
        }

        // Lấy tất cả category khớp với từ khóa tìm kiếm
        $brands = Brand::where('Brand_name', 'LIKE', '%' . $keyword . '%')->get();

        // Kiểm tra nếu không tìm thấy category nào
        if ($brands->isEmpty()) {
            return redirect()->route('brand.management')->with('error', 'No categories found matching your search.');
        }

        // Nếu có category, trả về view với dữ liệu
        return view('admin.pages.brand', compact('brands'));
    }
}
