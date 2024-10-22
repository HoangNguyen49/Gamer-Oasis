<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Route cho trang Home
Route::get('/', function () {
    return view('web.pages.index');
});

// Route cho trang About Us
Route::get('/about-us', function () {
    return view('web.pages.about-us');  
});

// Route cho trang Contact
Route::get('/contact', function () {
    return view('web.pages.contact');  
});

// Route cho trang Hướng dẫn thanh toán
Route::get('/payment-guide', function () {
    return view('web.pages.payment-guide');
});

// Route cho trang Hướng dẫn mua hàng
Route::get('/buying-guide', function () {
    return view('web.pages.buying-guide');
});

// Route cho trang Blog
Route::get('/blog', function(){
    return view('web.pages.blog');
});

// Route cho trang Blog-Detail
Route::get('/blog-detail', function(){
    return view('web.pages.blog-detail');
});

// Route cho trang Checkout
Route::get('/checkout', function(){
    return view('web.pages.checkout');
});

//Route cho trang Cart
Route::get('/cart', function(){
    return view('web.pages.cart');
});

//Route cho trang Wishlist
Route::get('/wishlist', function(){
    return view('web.pages.wishlist');
});

//Route cho trang Login-Register
Route::get('/login-register', function(){
    return view('web.pages.login-register');
});

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


Route::get('/admin/quanlisanpham', [ProductController::class, 'index'])->name('products.index');