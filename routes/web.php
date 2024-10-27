<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;

// Trang chính
Route::get('/', [ProductController::class, 'index']); // Thay đổi thành phương thức trong controller


// Route cho các trang thông tin
Route::view('/about-us', 'web.pages.about-us');
Route::view('/contact', 'web.pages.contact');
Route::view('/payment-guide', 'web.pages.payment-guide');
Route::view('/buying-guide', 'web.pages.buying-guide');

// Route cho trang Blog
Route::view('/blog', 'web.pages.blog');
Route::view('/blog-detail', 'web.pages.blog-detail');

// Route cho trang Checkout
Route::view('/checkout', 'web.pages.checkout');

// Route cho giỏ hàng và danh sách yêu thích
Route::view('/cart', 'web.pages.cart');
Route::view('/wishlist', 'web.pages.wishlist');

// Route cho trang Đăng nhập và Đăng ký
Route::view('/login-register', 'web.pages.login-register');

// Route cho trang Admin
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.pages.index-admin'); 
    });

    // Route cho trang quản lý đơn hàng
    Route::get('/quanlidonhang', function () {
        return view('admin.pages.quanlidonhang'); 
    });

    // Route cho form thêm đơn hàng
    Route::get('/quanlidonhang/taomoidonhang', function () {
        return view('admin.pages.form-add-don-hang');
    })->name('form-add-don-hang');

    // Route cho trang quản lý sản phẩm
    Route::get('/quanlisanpham', [ProductController::class, 'indexAdmin'])->name('products.indexAdmin');
    Route::get('/quanlisanpham/taomoisanpham', function () {
        return view('admin.pages.form-add-san-pham');
    })->name('form-add-san-pham');

    // Route cho trang quản lý khách hàng
    Route::get('/quanlikhachhang', function () {
        return view('admin.pages.quanlikhachhang'); 
    });
    Route::get('/quanlikhachhang/khachhangmoi', function () {
        return view('admin.pages.form-add-khach-hang');
    })->name('khachhangmoi');

    // Route cho trang blog
    Route::get('/quanliblog', function () {
        return view('admin.pages.quanliblog'); 
    });
    Route::get('/quanliblog/taobai', function () {
        return view('admin.pages.form-add-blog');
    })->name('taobai');

    // Route cho Category
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

    // Route cho Brand
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');

    // Route Product
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products', [ProductController::class, 'index']); // Xem danh sách sản phẩm
    Route::get('/products/create', [ProductController::class, 'create'])->name('form-add-san-pham');
    Route::get('/products/edit/{id}', [ProductController::class, 'editProduct'])->name('edit-product');
    Route::put('/products/update/{id}', [ProductController::class, 'updateProduct'])->name('products.update'); 
    Route::get('/products/{id}', [ProductController::class, 'showProduct'])->name('admin.product.show');
    Route::delete('/products/{id}', [ProductController::class, 'deleteProduct'])->name('products.deleteProduct');
    // Route cho trang danh sách sản phẩm
Route::get('/admin/products', [ProductController::class, 'indexAdmin'])->name('products.index');

});






