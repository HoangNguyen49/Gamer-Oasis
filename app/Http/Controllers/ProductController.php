<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function indexAdmin(Request $request)
{
    $search = $request->input('search');

    // Lấy sản phẩm theo tên tìm kiếm hoặc lấy tất cả nếu không có từ khóa
    $products = Product::with(['category', 'brand', 'images' => function ($query) {
        $query->orderBy('Image_id', 'asc')->limit(1);
    }])
    ->when($search, function ($query, $search) {
        return $query->where('Product_name', 'like', '%' . $search . '%');
    })
    ->get();

    return view('admin.pages.quanlisanpham', compact('products', 'search'));
}

    public function index()
    {
        // Lấy sản phẩm với tất cả các hình ảnh
        $products = Product::with(['category', 'brand', 'images'])->get();

        return view('web.pages.product', compact('products'));
    }

    public function create()
    {
        // Lấy danh sách các danh mục từ cơ sở dữ liệu
        $categories = Category::all();

        // Lấy danh sách các thương hiệu (brands) từ cơ sở dữ liệu
        $brands = Brand::all();

        // Truyền danh sách danh mục và thương hiệu vào view
        return view('admin.pages.form-add-san-pham', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'category_id' => 'required|exists:Category,Category_id',
            'brand_id' => 'required|exists:Brand,Brand_id',
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'colors' => 'array',
            'specifications' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Giới hạn kích thước hình ảnh
        ]);

        // Tạo sản phẩm mới
        $product = Product::create([
            'Category_id' => $request->category_id,
            'Brand_id' => $request->brand_id,
            'Product_name' => $request->product_name,
            'Product_description' => $request->product_description,
            'Price' => $request->price,
            'Stock_Quantity' => $request->stock_quantity,
            // Tự động tạo slug từ product_name
            'Slug' => Str::slug($request->product_name),
        ]);

        // Thêm màu sắc
        if ($request->has('colors') && !empty($request->colors)) {
            foreach ($request->colors as $color) {
                if (!empty($color)) {
                    $product->colors()->create(['Color_name' => $color]);
                }
            }
        }

        // Thêm đặc điểm
        if ($request->specifications) {
            foreach ($request->specifications as $spec) {
                $product->specifications()->create(['Spec_name' => $spec]);
            }
        }

        // Thêm hình ảnh
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('asset/images/product', 'public');
                $product->images()->create(['Image_path' => $path]);
            }
        }

        // Chuyển hướng với thông báo thành công
        return redirect()->route('products.indexAdmin')->with('success', 'Product added successfully.');
    }


    // Edit Product
    public function editProduct(string $id)
    {
        // Lấy thông tin sản phẩm dựa trên ID
        $product = Product::findOrFail($id);

        // Lấy danh sách danh mục và thương hiệu để hiển thị trong dropdown
        $categories = Category::all();
        $brands = Brand::all();

        // Trả về view với thông tin sản phẩm, danh mục và thương hiệu
        return view('admin.pages.edit-product', compact('product', 'categories', 'brands'));
    }

    //Function updateProduct after Edit
    public function updateProduct(Request $request, string $id)
    {
        // Xác thực dữ liệu
        $request->validate([
            'category_id' => 'required|exists:Category,Category_id',
            'brand_id' => 'required|exists:Brand,Brand_id',
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Lấy sản phẩm cần cập nhật
        $product = Product::findOrFail($id);

        // Cập nhật thông tin sản phẩm
        $product->update([
            'Category_id' => $request->category_id,
            'Brand_id' => $request->brand_id,
            'Product_name' => $request->product_name,
            'Product_description' => $request->product_description,
            'Price' => $request->price,
            'Stock_Quantity' => $request->stock_quantity,
            'Slug' => Str::slug($request->product_name),
        ]);

        // Xóa hình ảnh cũ
        foreach ($product->images as $image) {
            // Xóa tệp hình ảnh khỏi thư mục
            Storage::disk('public')->delete($image->Image_path);
        }

        // Xóa các bản ghi hình ảnh cũ trong cơ sở dữ liệu
        $product->images()->delete();

        // Thêm hình ảnh mới nếu có
        if ($request->hasFile('images')) {
            // Xóa hình ảnh cũ
            foreach ($product->images as $image) {
                // Xóa tệp hình ảnh khỏi thư mục
                Storage::disk('public')->delete($image->Image_path);
            }
            // Xóa các bản ghi hình ảnh cũ trong cơ sở dữ liệu
            $product->images()->delete();
    
            // Thêm hình ảnh mới
            foreach ($request->file('images') as $image) {
                $path = $image->store('asset/images/product', 'public');
                $product->images()->create(['Image_path' => $path]);
            }
        }

        // Chuyển hướng với thông báo thành công
        return redirect()->route('products.indexAdmin')->with('success', 'Product updated successfully.');
    }

    public function showProduct($id)
    {
        $product = Product::with('category', 'brand', 'images', 'colors')->findOrFail($id);

        return view('admin.pages.admin-product-detail', compact('product'));
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if ($product) {
            // Xóa tất cả các hình ảnh liên quan trước
            $product->images()->delete(); // Xóa các hình ảnh liên quan

            // Sau đó xóa sản phẩm
            $product->delete();
            return redirect()->route('products.indexAdmin')->with('success', 'Product deleted successfully.');
        }

        return redirect()->route('products.indexAdmin')->with('error', 'Product not found.');
    }
}
