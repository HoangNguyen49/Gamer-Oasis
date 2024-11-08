<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OrderHistoryController;

// Trang chính
Route::get('/', [ProductController::class, 'index'])->name('web.pages.index'); 
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






Route::post('/login', [UserController::class, 'login'])->name('login');





// Route cho trang Login-Register
Route::get('/login-register', function () {
    return view('web.pages.login-register');
})->name('login.register');

// Route cho đăng ký
Route::post('/register', [UserController::class, 'store'])->name('users.store');


//Route Prefix Admin
Route::prefix('admin')->middleware('auth')->group(
    function () {
        // Route cho trang chủ admin
        Route::get('/', function () {
            return view('admin.pages.admin-index');
        })->name('admin.pages.admin-index');

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

        // Route cho trang quản lý khách hàng
        Route::get('/quanlikhachhang', [UserController::class, 'index'])->name('users.index');

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
        Route::get('/products', [ProductController::class, 'indexAdmin'])->name('products.index');
    });
//end Route Prefix Admin


//Route show chi tiết sản phẩm bên web
Route::get('/products/{id}', [ProductController::class, 'indexshowProduct'])->name('products.show');

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




// //send mail
// Route::get('sendMail', [MailController::class, 'sendMail']);

// web.php
Route::post('password/reset', [UserController::class, 'sendPasswordResetLink'])->name('password.email');

Route::post('password/update', [UserController::class, 'resetPassword'])->name('password.update');

Route::get('/password/reset/{email}', [UserController::class, 'showResetForm'])->name('password.reset');

// Route để hiển thị chi tiết đơn hàng
Route::get('/order-history', [OrderHistoryController::class, 'show']);

// Route để đăng xuất
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

