<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function indexAdmin()
    {
        // Lấy sản phẩm với hình ảnh đầu tiên
        $products = Product::with(['category', 'brand', 'images' => function ($query) {
            $query->limit(1); // Chỉ lấy một hình ảnh
        }])->get();

        return view('admin.pages.quanlisanpham', compact('products'));
    }


    public function index()
    {
        // Lấy sản phẩm với tất cả các hình ảnh
        $products = Product::with(['category', 'brand', 'images'])->get();

        return view('web.pages.product', compact('products'));
    }

    public function createProduct() {}

    public function store(Request $request) {}


    public function show(string $id) {}


    public function edit(string $id) {}


    public function update(Request $request, string $id) {}


    public function delete(string $id) {}
}
