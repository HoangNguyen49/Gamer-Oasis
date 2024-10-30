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

    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'Category_name' => 'required|string|max:255',
        ]);

        // Tạo mới category và lưu vào cơ sở dữ liệu
        $category = Category::create([
            'Category_name' => $request->input('Category_name'),
            'CreatedAt' => now()
        ]);

        // Trả về phản hồi JSON với Category_id
        return response()->json(['success' => true, 'category_id' => $category->Category_id]);
    }
}
