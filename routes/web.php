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

// Trang chính
Route::get('/', [ProductController::class, 'index']);

// Route cho các trang thông tin
Route::view('/about-us', 'web.pages.about-us');
Route::view('/contact', 'web.pages.contact');
Route::view('/payment-guide', 'web.pages.payment-guide');
Route::view('/buying-guide', 'web.pages.buying-guide');

// Route cho trang Blog
Route::view('/blog', 'web.pages.blog');
Route::view('/blog-detail', 'web.pages.blog-detail');

// Route cho giỏ hàng và danh sách yêu thích
Route::view('/cart', 'web.pages.cart');
Route::view('/wishlist', 'web.pages.wishlist');

// Route cho trang Đăng nhập và Đăng ký
Route::view('/login-register', 'web.pages.login-register');

// Route chi tiết sản phẩm
Route::get('/products/{slug}', [ProductController::class, 'indexshowProduct'])->name('products.show');

// Route theo Category
Route::get('/products/category/{categoryId}', [ProductController::class, 'showByCategory'])->name('products.category');

// Route theo Brand
Route::get('/products/brand/{brandId}', [ProductController::class, 'showByBrand'])->name('products.brand');

// Route cho giỏ hàng
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

// Route cho mã giảm giá
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('apply.coupon');

// Route cho Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/payment', [CheckoutController::class, 'processPayment'])->name('checkout.payment');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

// Route cho Wishlist
Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
Route::get('/wishlist', [WishlistController::class, 'showWishlist'])->name('wishlist.show');
Route::post('/wishlist/remove', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');

// Route Prefix Admin
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.pages.index-admin');
    });

    // Quản lý đơn hàng
    Route::get('/quanlidonhang', function () {
        return view('admin.pages.quanlidonhang');
    });
    Route::get('/quanlidonhang/taomoidonhang', function () {
        return view('admin.pages.form-add-don-hang');
    })->name('form-add-don-hang');

    // Quản lý sản phẩm
    Route::get('/quanlisanpham', [ProductController::class, 'indexAdmin'])->name('products.indexAdmin');
    Route::get('/quanlisanpham/taomoisanpham', function () {
        return view('admin.pages.form-add-san-pham');
    })->name('form-add-san-pham');

    // Quản lý khách hàng
    Route::get('/quanlikhachhang', function () {
        return view('admin.pages.quanlikhachhang');
    });
    Route::get('/quanlikhachhang/khachhangmoi', function () {
        return view('admin.pages.form-add-khach-hang');
    })->name('khachhangmoi');

    // Quản lý blog
    Route::get('/quanliblog', function () {
        return view('admin.pages.quanliblog');
    });
    Route::get('/quanliblog/taobai', function () {
        return view('admin.pages.form-add-blog');
    })->name('taobai');

    // Quản lý coupon
    Route::get('/quanlimagiamgia', [CouponController::class, 'index'])->name('quanlimagiamgia');
    Route::resource('coupons', CouponController::class)->except(['index']);
    Route::get('/coupons/{id}/edit', [CouponController::class, 'edit'])->name('coupons.edit');
    Route::put('/coupons/{id}', [CouponController::class, 'update'])->name('coupons.update');
    Route::delete('/coupons/{id}', [CouponController::class, 'destroy'])->name('coupons.destroy');
    Route::get('/admin/coupons/create', [CouponController::class, 'create'])->name('coupons.create');
    Route::post('/admin/coupons', [CouponController::class, 'store'])->name('coupons.store');

    // Quản lý đơn hàng
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');

    // Quản lý Category và Brand
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');

    // Quản lý sản phẩm
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products', [ProductController::class, 'index']); // Xem danh sách sản phẩm
    Route::get('/products/create', [ProductController::class, 'create'])->name('form-add-san-pham');
    Route::get('/products/edit/{id}', [ProductController::class, 'editProduct'])->name('edit-product');
    Route::put('/products/update/{id}', [ProductController::class, 'updateProduct'])->name('products.update');
    Route::get('/products/{id}', [ProductController::class, 'showProduct'])->name('admin.product.show');
    Route::delete('/products/{id}', [ProductController::class, 'deleteProduct'])->name('products.deleteProduct');
});

// End Prefix Admin


// Category Management
Route::get('/categories', [CategoryController::class, 'index2'])->name('category.management');
Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategory'])->name('categories.delete');
Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');


// Brand Management
Route::get('/brands', [BrandController::class, 'indexBrand'])->name('brand.management');
Route::delete('/brands/{id}', [BrandController::class, 'deleteBrand'])->name('brands.delete');
Route::get('/brands/search', [BrandController::class, 'search'])->name('brands.search');

    
