<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VnpayOrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogController;

// Trang chính
Route::get('/', [ProductController::class, 'index'])->name('web.pages.index'); 
// Route cho các trang thông tin
Route::view('/about-us', 'web.pages.about-us');
Route::view('/contact', 'web.pages.contact');
Route::view('/payment-guide', 'web.pages.payment-guide');
Route::view('/buying-guide', 'web.pages.buying-guide');

// Route cho trang Checkout
Route::view('/checkout', 'web.pages.checkout');

// Route cho giỏ hàng và danh sách yêu thích
Route::view('/cart', 'web.pages.cart');
Route::view('/wishlist', 'web.pages.wishlist');

//Route show chi tiết sản phẩm bên web
Route::get('/products/{Slug}', [ProductController::class, 'indexshowProduct'])->name('products.show');

//Route show sản phẩm theo Category trên navbar
Route::get('/products/category/{categoryId}', [ProductController::class, 'showByCategory'])->name('products.category');

//Route show sản phẩm theo Brand trên navbar
Route::get('/products/brand/{brandId}', [ProductController::class, 'showByBrand'])->name('products.brand');

// Route để thêm sản phẩm vào giỏ hàng
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');

// Route để hiển thị sản phẩm từ giỏ hàng khi checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/payment', [CheckoutController::class, 'processPayment'])->name('checkout.payment');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

// Route để thêm mã giảm giá vào đơn hàng
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('apply.coupon');

// Route để checkout
Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

// Route để thêm sản phẩm vào wishlist
Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');

// Route để hiển thị sản phẩm trong wishlist
Route::get('/wishlist', [WishlistController::class, 'showWishlist'])->name('wishlist.show');

// Route để xóa sản phẩm trong wishlist
Route::post('/wishlist/remove', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');

// Route để xóa sản phẩm từ cart
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');

// Route để cập nhật sản phẩm trực tiếp trong cart
Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

//rout login
Route::post('/login', [UserController::class, 'login'])->name('login');

// Route cho trang Login-Register
Route::get('/login-register', function () {
    return view('web.pages.login-register');
})->name('login.register');

// Route cho đăng nhập (chỉ hỗ trợ POST)
Route::post('/login', [UserController::class, 'login'])->name('login');

// Route cho trang đăng nhập (GET)
Route::get('/login', function () {
    return redirect()->route('login.register')->with('message', 'You need to log in to access this page.');
})->name('login.form');

// Route cho đăng ký
Route::post('/register', [UserController::class, 'store'])->name('users.store');


//Route Prefix Admin
// Route cho trang Admin
Route::prefix('admin')->middleware([AdminMiddleware::class])->group(function () {
    // Route::get('/', function () {
           //     return view('admin.pages.index-admin');
           // })->name('admin.pages.index-admin');
   
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

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
        // Route cho trang quản lý sản phẩm
        Route::get('/quanlisanpham', [ProductController::class, 'indexAdmin'])->name('products.indexAdmin');

    // Route cho trang quản lý khách hàng
    Route::get('/quanlikhachhang', function () {
        return view('admin.pages.quanlikhachhang');
     
    });
    Route::get('/quanlikhachhang/khachhangmoi', function () {
        return view('admin.pages.form-add-khach-hang');
    })->name('khachhangmoi');
        // Route cho trang quản lý khách hàng
        Route::get('/quanlikhachhang', [UserController::class, 'index'])->name('users.index');

    // Route cho trang blog
    Route::get('/quanliblog', function () {
        return view('admin.pages.quanliblog');
        
    });

    // Route blog
    Route::get('/quanliblog/taobai', function () {
        return view('admin.pages.form-add-blog');
    })->name('taobai');

    Route::get('/trans.verifi', function () {
        return view('admin.pages.trans.verifi');
    });

    // Route mặc định
    Route::get('/trans_verifi', [VnpayOrderController::class, 'index'])->name('trans_verifi.index');
    Route::get('/trans_verifi_details/{vnpay_id}', [VnpayOrderController::class, 'showDetails'])->name('trans_verifi_details');

    // Route cho trang quản lý coupon
    Route::get('/quanlimagiamgia', [CouponController::class, 'index'])->name('quanlimagiamgia');

    // Định nghĩa resource routes cho Coupon, ngoại trừ index
    Route::resource('coupons', CouponController::class)->except(['index']);

    // Route để truy cập vào trang edit coupon
    Route::get('/coupons/{id}/edit', [CouponController::class, 'edit'])->name('coupons.edit');

    // Route để update edit coupon
    Route::put('/coupons/{id}', [CouponController::class, 'update'])->name('coupons.update');

    // Route để xóa coupon
    Route::delete('/admin/coupons/{id}', [CouponController::class, 'destroy'])->name('coupons.destroy');

    Route::resource('coupons', CouponController::class);

    // Route để hiển thị form tạo coupon mới
    Route::get('/admin/coupons/create', [CouponController::class, 'create'])->name('coupons.create');

    // Route để lưu coupon
    Route::post('/admin/coupons', [CouponController::class, 'store'])->name('coupons.store');

    // Route của Order Management
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::delete('/admin/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::resource('orders', OrderController::class);
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy'); // Route delete
    Route::get('/admin/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
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
    Route::get('/admin/products/{id}', [ProductController::class, 'showProduct'])->name('admin.product.show');
    
    //Route show chi tiết sản phẩm bên web
    Route::get('/products/{id}', [ProductController::class, 'indexshowProduct'])->name('products.show');
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

    Route::get('/contacts', function () {
        return view('admin.pages.contacts');
        return view('admin.pages.contacts');
    });

    Route::get('/contacts', [ContactController::class, 'show'])->name('contacts.show');
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{id}', [ContactController::class, 'showDetail'])->name('contacts.showDetail');
    Route::get('/contacts/update-status/{id}', [ContactController::class, 'updateStatus'])->name('contacts.updateStatus');
});

// End Prefix Admin

Route::get('/contact', [ContactController::class, 'showForm']);
Route::post('/contact', [ContactController::class, 'store']);

// Category Management
Route::get('/categories', [CategoryController::class, 'index2'])->name('category.management');
Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategory'])->name('categories.delete');
Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');


// Brand Management
Route::get('/brands', [BrandController::class, 'indexBrand'])->name('brand.management');
Route::delete('/brands/{id}', [BrandController::class, 'deleteBrand'])->name('brands.delete');
Route::get('/brands/search', [BrandController::class, 'search'])->name('brands.search');

Route::get('/vnpay_payment/{order_id}', [VnpayOrderController::class, 'vnpay_payment'])->name('vnpay.payment');
Route::get('/vnpay_return', [VnpayOrderController::class, 'vnpayReturn'])->name('vnpay.return');

Route::get('/search-products', [ProductController::class, 'searchProducts'])->name('products.search');


//google login
Route::get('/auth/{provider}', [UserController::class, 'redirectToGoogle']);
Route::get('/login/google/callback', [UserController::class, 'handleGoogleCallback'])->name('google.callback');
Route::get('auth/google', [UserController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [UserController::class, 'handleGoogleCallback'])->name('auth.google.callback');

//Route show thông tin tài khoản
Route::get('/my-account', [UserController::class, 'showAccount'])->name('user.account');

//Route update thông tin tài khoản
//Route::put('/users/{User_id}', [UserController::class, 'update'])->name('users.update');

// Route để cập nhật thông tin tài khoản
Route::put('/account/update', [UserController::class, 'update'])->name('user.update');

// Route::get('sendMail', [MailController::class, 'sendMail']);
//send mail
Route::post('password/reset', [UserController::class, 'sendPasswordResetLink'])->name('password.email');

Route::post('password/update', [UserController::class, 'resetPassword'])->name('password.update');

Route::get('/password/reset/{email}', [UserController::class, 'showResetForm'])->name('password.reset');

// Route để hiển thị chi tiết đơn hàng
Route::get('/order-history', [OrderHistoryController::class, 'show']);

// Route để đăng xuất
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Route để chặn tài khoản
Route::post('/block', [UserController::class, 'blockUser']);
Route::post('/unblock', [UserController::class, 'unblockUser']);


// Route cho trang Blog
Route::get('/blogs', function () {
    $blogs = \App\Models\Blog::all(); // Lấy tất cả blog từ cơ sở dữ liệu
    return view('web.pages.blog', compact('blogs')); // Trả về view danh sách blog
});

// Route cho trang blog-detail
Route::get('/web/blogs/{slug}', [BlogController::class, 'show'])->name('show');

// Route cho danh sách blog
Route::get('/admin/quanliblog', [BlogController::class, 'index'])->name('index');

// Route cho tạo blog
Route::get('/admin/quanliblog/taobai', [BlogController::class, 'create'])->name('create');

// Route cho lưu sau khi tạo blog
Route::post('/admin/quanliblog/taobai', [BlogController::class, 'store'])->name('post');

// Route cho chỉnh sửa blog
Route::get('/admin/quanliblog/edit/{id}', [BlogController::class, 'edit'])->name('edit');

// Route cho cập nhật sau khi sửa blog
Route::put('/admin/quanliblog/update/{id}', [BlogController::class, 'update'])->name('update');

// Route cho xóa blog
Route::delete('/admin/quanliblog/destroy/{id}', [BlogController::class, 'destroy'])->name('destroy');

// Route cho lưu bình luận
Route::post('/web/blogs/{slug}/comments', [BlogController::class, 'storeComment'])->name('comments.store');

// Route cho việc xem bình luận của một blog
Route::get('/admin/quanliblog/comments/{id}', [BlogController::class, 'viewComments'])->name('comments.view');

// Route cho việc xóa bình luận của một blog
Route::delete('/admin/comments/{id}', [BlogController::class, 'deleteComment'])->name('comments.delete');

//Route cho việc trả lời của một bình luận
Route::post('/comments/reply', [BlogController::class, 'reply'])->name('comments.reply');

