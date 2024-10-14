<?php

use Illuminate\Support\Facades\Route;

// Route cho trang chính
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


