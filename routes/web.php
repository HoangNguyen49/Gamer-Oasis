<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('web.pages.index');
})->name('web.pages.index');

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
Route::get('/blog', function () {
    return view('web.pages.blog');
});

// Route cho trang Blog-Detail
Route::get('/blog-detail', function () {
    return view('web.pages.blog-detail');
});

// Route cho trang Checkout
Route::get('/checkout', function () {
    return view('web.pages.checkout');
});

// Route cho trang Cart
Route::get('/cart', function () {
    return view('web.pages.cart');
});

// Route cho trang Wishlist
Route::get('/wishlist', function () {
    return view('web.pages.wishlist');
});

// Route cho trang Login-Register
Route::get('/login-register', function () {
    return view('web.pages.login-register');
})->name('login.register');

// Route cho đăng ký
Route::post('/register', [UserController::class, 'store'])->name('users.store');

// Route cho đăng nhập
// Route::get('/login', function () {
//     if (Auth::user()->role === 'admin') {
//         return view('admin.pages.admin-index');
//     } else {
//         return redirect('/')->withErrors(['access' => 'Bạn không có quyền truy cập vào trang này.']);
//     }
// })->name('login.admin-index');

Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/admin', function () {
    return view('admin.pages.admin-index');
})->name('admin.pages.admin-index');

// Route cho đăng xuất
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login-register')->with('success', 'Đăng xuất thành công.');
})->name('logout');

// Route cho trang admin

    // Route::get('/admin', function () {
    //     if (Auth::user()->role === 'admin') {
    //         return view('admin.pages.admin');
    //     } else {
    //         return redirect('/')->withErrors(['access' => 'Bạn không có quyền truy cập vào trang này.']);
    //     }
    // })->name('admin.pages.admin');

    Route::get('/admin/quanlikhachhang', [UserController::class, 'index'])->name('users.index');
    Route::get('/admin/quanlisanpham', [ProductController::class, 'index'])->name('products.index');

    // Route cho trang quanlidonhang
    Route::get('/admin/quanlidonhang', function () {
        return view('admin.pages.quanlidonhang');
    })->name('admin.quanlidonhang');

    // Route cho form-add-don-hang
    Route::get('/quanlidonhang/taomoidonhang', function () {
        return view('admin.pages.form-add-don-hang');
    })->name('form-add-don-hang');

    // Route cho trang form-add-san-pham
    Route::get('/quanlisanpham/taomoisanpham', function () {
        return view('admin.pages.form-add-san-pham');
    })->name('form-add-san-pham');

    // Route cho trang blog
    Route::get('/admin/quanliblog', function () {
        return view('admin.pages.quanliblog');
    })->name('admin.quanliblog');

    // Route cho trang form-add-blog
    Route::get('/quanliblog/taobai', function () {
        return view('admin.pages.form-add-blog');
    })->name('taobai');