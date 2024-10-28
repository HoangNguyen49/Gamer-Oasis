<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;

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
    
});
