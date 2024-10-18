<?php

use Illuminate\Support\Facades\Route;
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

//Route cho trang Blog
Route::get('/blog', function(){
    return view('web.pages.blog');
});

//Route cho trang Blog-Detail
Route::get('/blog-detail', function(){
    return view('web.pages.blog-detail');
});

//Route cho trang Checkout
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