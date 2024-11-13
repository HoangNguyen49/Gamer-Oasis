<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class CategoryController extends Controller
{
    public function index()
    {
        // Hiển thị danh sách các danh mục
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function index2()
    {
        $categories = Category::all();
        return view('admin.pages.category', compact('categories'));
    }

    public function deleteCategory($id)
{
    // Tìm category theo ID
    $category = Category::find($id);

    // Kiểm tra nếu category tồn tại
    if ($category) {
        // Kiểm tra xem có sản phẩm nào liên quan đến category này không
        $productCount = Product::where('category_id', $id)->count();

        if ($productCount > 0) {
            // Nếu có sản phẩm liên quan đến category, trả về thông báo lỗi
            return redirect()->route('category.management')->with('error', 'Can not delete this Brand because there is still Products and Orders instock.');
        }

        // Kiểm tra xem category_id có tồn tại trong bảng orders không
        $orderCount = Order::whereHas('products', function($query) use ($id) {
            $query->where('category_id', $id); // Kiểm tra sản phẩm trong order có category_id trùng với ID của category
        })->count();

        if ($orderCount > 0) {
            // Nếu có đơn hàng liên quan đến category này, trả về thông báo lỗi
            return redirect()->route('category.management')->with('error', 'Không thể xóa category vì đã có trong các đơn hàng.');
        }

        // Xóa category nếu không có sản phẩm hay đơn hàng liên quan
        $category->delete();

        // Redirect hoặc trả về thông báo thành công
        return redirect()->route('category.management')->with('success', 'Category deleted successfully.');
    }

    // Nếu không tìm thấy category, có thể redirect hoặc thông báo lỗi
    return redirect()->route('category.management')->with('error', 'Category not found.');
}


    public function store(Request $request)
{
    $request->validate([
        'Category_name' => 'required|string|max:255',
    ]);

    // Check if the category name already exists
    if (Category::where('Category_name', $request->input('Category_name'))->exists()) {
        // Use dd() to confirm this block is executing as expected
        return response()->json(['success' => false, 'error' => 'Category name already exists.'], 409);
    }

    $category = Category::create([
        'Category_name' => $request->input('Category_name'),
        'CreatedAt' => now()
    ]);

    return response()->json(['success' => true, 'category_id' => $category->Category_id]);
}




    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Kiểm tra xem từ khóa tìm kiếm có hợp lệ không
        if (empty($keyword)) {
            return redirect()->route('category.management')->with('error', 'Please enter a keyword to search.');
        }

        // Lấy tất cả category khớp với từ khóa tìm kiếm
        $categories = Category::where('Category_name', 'LIKE', '%' . $keyword . '%')->get();

        // Kiểm tra nếu không tìm thấy category nào
        if ($categories->isEmpty()) {
            return redirect()->route('category.management')->with('error', 'No categories found matching your search.');
        }

        // Nếu có category, trả về view với dữ liệu
        return view('admin.pages.category', compact('categories'));
    }
}
