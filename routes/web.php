<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Trang chính
Route::view('/', 'web.pages.index');

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
Route::get('/admin', function () {
    return view('admin.pages.index-admin'); 
});
//Route cho trang quanlidonhang
Route::get('/admin/quanlidonhang', function () {
    return view('admin.pages.quanlidonhang'); 
});

//Route cho  form-add-don-hang
Route::get('/quanlidonhang/taomoidonhang', function () {
    return view('admin.pages.form-add-don-hang');
})->name('form-add-don-hang');
//Route cho trang quanlisanpham
Route::get('/admin/quanlisanpham', function () {
    return view('admin.pages.quanlisanpham'); 
});
//Route cho trang form-add-san-pham
Route::get('/quanlisanpham/taomoisanpham', function () {
    return view('admin.pages.form-add-san-pham');
})->name('form-add-san-pham');
//Route cho trang quanlikhachhang
Route::get('/admin/quanlikhachhang',function () {
        return view('admin.pages.quanlikhachhang'); 
});

//Route cho trang form-add-khach-hang
Route::get('/quanlikhachhang/khachhangmoi', function () {
    return view('admin.pages.form-add-khach-hang');
})->name('khachhangmoi');

//Route cho trang blog
Route::get('/admin/quanliblog', function () {
    return view('admin.pages.quanliblog'); 
});

//Route cho trang form-add-blog
Route::get('/quanliblog/taobai', function () {
    return view('admin.pages.form-add-blog');
})->name('taobai');

// Route Product
Route::get('/admin/quanlisanpham', [ProductController::class, 'indexAdmin'])->name('products.index');