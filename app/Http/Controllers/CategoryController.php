<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

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
            // Xóa category
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
