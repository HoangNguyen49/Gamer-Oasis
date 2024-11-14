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
        // Find category by ID
        $category = Category::find($id);

        // Check if the category exists
        if ($category) {
            // Check if there are any products related to this category
            $productCount = Product::where('category_id', $id)->count();

            if ($productCount > 0) {
                // Return error if products are associated with this category
                return redirect()->route('category.management')->with('error', 'Cannot delete the category because there are products associated with it.');
            }

            // Delete the category if no products are associated
            $category->delete();

            // Return success message
            return redirect()->route('category.management')->with('success', 'Category deleted successfully.');
        }

        // If category not found, return error message
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
