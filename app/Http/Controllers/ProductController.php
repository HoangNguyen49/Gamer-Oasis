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
            ->paginate(10); // Phân trang 10 sản phẩm trên mỗi trang

        return view('admin.pages.quanlisanpham', compact('products', 'search'));
    }

    public function index()
    {
        // Lấy sản phẩm theo danh mục có ID là 1, 2 và 3
        $productsCategory123 = Product::with(['brand', 'images', 'category'])
            ->whereIn('Category_id', [1, 2, 3]) // Lọc theo Category ID 1, 2, 3
            ->get();

        // Lấy sản phẩm theo danh mục có ID là 4, 5 và 6
        $productsCategory456 = Product::with(['brand', 'images', 'category'])
            ->whereIn('Category_id', [4, 5, 6]) // Lọc theo Category ID 4, 5, 6
            ->get();

        // Lấy sản phẩm theo danh mục có ID là 7 và 8
        $productsCategory78 = Product::with(['brand', 'images', 'category'])
            ->whereIn('Category_id', [7, 8]) // Lọc theo Category ID 4, 5, 6
            ->get();

        return view('web.pages.index', compact('productsCategory123', 'productsCategory456', 'productsCategory78'));
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
        $product = Product::with('specifications')->findOrFail($id);

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
            foreach ($request->file('images') as $image) {
                $path = $image->store('asset/images/product', 'public');
                $product->images()->create(['Image_path' => $path]);
            }
        }

        // Xóa các bản ghi specifications cũ trong cơ sở dữ liệu
        $product->specifications()->delete();

        // Thêm thông số kỹ thuật mới
        if ($request->specifications) {
            foreach ($request->specifications as $spec) {
                $product->specifications()->create(['Spec_name' => $spec]);
            }
        }

        // Chuyển hướng với thông báo thành công
        return redirect()->route('products.indexAdmin')->with('success', 'Product updated successfully.');
    }


    //show chi tiết sản phẩm trong admin
    public function showProduct($id)
    {
        $product = Product::with('category', 'brand', 'images')->findOrFail($id);

        return view('admin.pages.admin-product-detail', compact('product'));
    }

    public function indexshowProduct($slug)
    {
        // Tìm sản phẩm theo ID, bao gồm các mối quan hệ cần thiết
        $product = Product::where('Slug', $slug)->firstOrFail();

        // Trả về view với dữ liệu sản phẩm
        return view('web.pages.single-product', compact('product'));
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

    // Show Product by Category in Navbar with Sort By
    public function showByCategory(Request $request, $categoryId)
    {
        $sortBy = $request->input('sortBy'); // Get sorting option from request

        // Set sorting criteria based on user selection
        $products = Product::where('Category_id', $categoryId)
            ->when($sortBy, function ($query, $sortBy) {
                if ($sortBy == 'name_asc') {
                    $query->orderBy('Product_name', 'asc');
                } elseif ($sortBy == 'name_desc') {
                    $query->orderBy('Product_name', 'desc');
                } elseif ($sortBy == 'price_high_low') {
                    $query->orderBy('Price', 'desc');
                } elseif ($sortBy == 'price_low_high') {
                    $query->orderBy('Price', 'asc');
                }
            })
            ->paginate(8);

        return view('web.pages.shop-4-column', compact('products', 'categoryId', 'sortBy'));
    }

    // Show Product by Brand in Navbar with Sort By
    public function showByBrand(Request $request, $brandId)
    {
        $sortBy = $request->input('sortBy'); // Get sorting option from request

        // Set sorting criteria based on user selection
        $products = Product::where('Brand_id', $brandId)
            ->when($sortBy, function ($query, $sortBy) {
                if ($sortBy == 'name_asc') {
                    $query->orderBy('Product_name', 'asc');
                } elseif ($sortBy == 'name_desc') {
                    $query->orderBy('Product_name', 'desc');
                } elseif ($sortBy == 'price_high_low') {
                    $query->orderBy('Price', 'desc');
                } elseif ($sortBy == 'price_low_high') {
                    $query->orderBy('Price', 'asc');
                }
            })
            ->paginate(8);

        return view('web.pages.shop-4-column', compact('products', 'brandId', 'sortBy'));
    }

    public function searchProducts(Request $request)
    {
        $query = $request->input('query');

        // Fetch products based on the search query
        $products = Product::where('Product_name', 'like', '%' . $query . '%')
            ->limit(5)
            ->get();

        // Return results as JSON
        return response()->json($products);
    }
}
