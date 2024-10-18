<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});


Route::get('/admin', action: function () {
    return view('admin.layout.master');
});




