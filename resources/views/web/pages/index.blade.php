<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Gamer Oasis</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('asset/images/favicon.png') }}">
</head>

<body>
    @include('web.layouts.header')
    <!-- Header Area End Here -->
    <!-- Begin Slider With Banner Area -->
    <div class="slider-with-banner">
        <div class="container">
            <div class="row">
                <!-- Begin Slider Area -->
                <div class="col-lg-8 col-md-8">
                    <div class="slider-area pt-sm-30 pt-xs-30">
                        <div class="slider-active owl-carousel">
                            <!-- Begin Single Slide Area -->
                            <div class="single-slide align-center-left animation-style-01 bg-1">
                                <div class="slider-progress"></div>
                                <div class="slider-content">
                                    <div class="default-btn slide-btn">
                                    </div>
                                </div>
                            </div>
                            <!-- Single Slide Area End Here -->
                            <!-- Begin Single Slide Area -->
                            <div class="single-slide align-center-left animation-style-02 bg-2">
                                <div class="slider-progress"></div>
                                <div class="slider-content">
                                    <div class="default-btn slide-btn">
                                    </div>
                                </div>
                            </div>
                            <!-- Single Slide Area End Here -->
                            <!-- Begin Single Slide Area -->
                            <div class="single-slide align-center-left animation-style-01 bg-3">
                                <div class="slider-progress"></div>
                                <div class="slider-content" style="color: red">
                                    <h2>Acer Nitro 5 Tiger Super Gaming</h2>
                                    <h3>Starting at <span>$920.00</span></h3>
                                    <div class="default-btn slide-btn">
                                    </div>
                                </div>
                            </div>
                            <!-- Single Slide Area End Here -->
                        </div>
                    </div>
                </div>
                <!-- Slider Area End Here -->
                <!-- Begin Li Banner Area -->
                <div class="col-lg-4 col-md-4 text-center pt-sm-30 pt-xs-30">
                    <div class="li-banner">
                        <a>
                            <img src="{{ asset('asset/images/static-top/Nitendo.jpg') }}" alt="">
                        </a>
                    </div>
                    <div class="li-banner mt-15 mt-md-30 mt-xs-25 mb-xs-5">
                        <a>
                            <img src="{{ asset('asset/images/static-top/Nitendo-Pro.jpg') }}" alt="">
                        </a>
                    </div>
                </div>
                <!-- Li Banner Area End Here -->
            </div>
        </div>
    </div>
    <!-- Slider With Banner Area End Here -->
    <!-- Begin Static Top Area -->
    <div class="static-top-wrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="static-top-content mt-sm-30">
                        Gift Special: Gift every single day on Weekends - New Coupon code "
                        <span>LimupaSaleoff</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Static Top Area End Here -->
    <!-- product-area start -->
    <div class="product-area pt-10 pb-25 pt-xs-50">
    </div>
    </div>
    <!-- product-area end -->
    <!-- Begin Li's Static Banner Area -->
    <div class="li-static-banner li-static-banner-4 text-center pt-20">
        <div class="container">
            <div class="row">
                <!-- Begin Single Banner Area -->
                <div class="col-lg-6">
                    <div class="single-banner pb-sm-30 pb-xs-30">
                        <a>
                            <img src="{{ asset('asset/images/banner/Nitro.jpg') }}" alt="Li's Static Banner">
                        </a>
                    </div>
                </div>
                <!-- Single Banner Area End Here -->
                <!-- Begin Single Banner Area -->
                <div class="col-lg-6">
                    <div class="single-banner">
                        <a>
                            <img src="{{ asset('asset/images/banner/PS5.jpg') }}" alt="Li's Static Banner">
                        </a>
                    </div>
                </div>
                <!-- Single Banner Area End Here -->
            </div>
        </div>
    </div>
    <!-- Li's Static Banner Area End Here -->
    <!-- Begin Li's Laptop Product Area -->
    <section class="product-area li-laptop-product pt-60 pb-45 pt-sm-50 pt-xs-60">
        <div class="container">
            <div class="row">
                <!-- Begin Li's Section Area -->
                <div class="col-lg-12">
                    <div class="li-section-title">
                        <h2>
                            <span>Laptop Gaming</span>
                        </h2>

                    </div>
                    <div class="row">
                        <div class="product-active owl-carousel">
                            @foreach ($productsCategory78 as $product)
                                <div class="col-lg-12">
                                    <div class="single-product-wrap">
                                        <div class="product-image">
                                            <a href="{{ route('products.show', $product->Slug) }}">
                                                @if ($product->images->isNotEmpty())
                                                    <img src="{{ asset('storage/' . $product->images->first()->Image_path) }}"
                                                        alt="{{ $product->Product_name }}">
                                                @else
                                                    <img src="path/to/default-image.jpg" alt="No Image">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="product_desc">
                                            <div class="product_desc_info">
                                                <div class="product-review">
                                                    <h5 class="manufacturer">
                                                        <a href="product-details.html">
                                                            {{ optional($product->brand)->Brand_name ?? 'No Brand' }}
                                                        </a>
                                                    </h5>
                                                </div>
                                                <h4>
                                                    <a class="product_name"
                                                        href="{{ route('products.show', $product->Slug) }}">{{ $product->Product_name }}</a>
                                                </h4>
                                                <div class="price-box">
                                                    <span
                                                        class="new-price">${{ number_format($product->Price, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="add-actions">
                                                <ul class="add-actions-link">
                                                    <li class="add-cart active"><a href="#"
                                                            class="add-to-cart-btn"
                                                            data-product-id="{{ $product->Product_id }}">ADD TO
                                                            CART</a></li>
                                                    <li><a href="#" class="add-to-wishlist-btn"
                                                            data-product-id="{{ $product->Product_id }}"><i
                                                                class="fa fa-heart-o"></i></a></li>
                                                    <li><a class="quick-view" data-toggle="modal"
                                                            data-target="#exampleModalCenter" href="#"><i
                                                                class="fa fa-eye"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
                <!-- Li's Section Area End Here -->
            </div>
        </div>
    </section>

    <section class="product-area li-laptop-product pt-60 pb-45 pt-sm-50 pt-xs-60">
        <div class="container">
            <div class="row">
                <!-- Begin Li's Section Area -->
                <div class="col-lg-12">
                    <div class="li-section-title">
                        <h2>
                            <span>SONY</span>
                        </h2>

                    </div>
                    <div class="row">
                        <div class="product-active owl-carousel">
                            @foreach ($productsCategory123 as $product)
                                <div class="col-lg-12">
                                    <div class="single-product-wrap">
                                        <div class="product-image">
                                            <a href="{{ route('products.show', $product->Slug) }}">
                                                @if ($product->images->isNotEmpty())
                                                    <img src="{{ asset('storage/' . $product->images->first()->Image_path) }}"
                                                        alt="{{ $product->Product_name }}">
                                                @else
                                                    <img src="path/to/default-image.jpg" alt="No Image">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="product_desc">
                                            <div class="product_desc_info">
                                                <div class="product-review">
                                                    <h5 class="manufacturer">
                                                        <a href="{{ route('products.show', $product->Slug) }}">
                                                            {{ optional($product->brand)->Brand_name ?? 'No Brand' }}
                                                        </a>
                                                    </h5>
                                                </div>
                                                <h4>
                                                    <a class="product_name"
                                                        href="{{ route('products.show', $product->Slug) }}">{{ $product->Product_name }}</a>
                                                </h4>
                                                <div class="price-box">
                                                    <span
                                                        class="new-price">${{ number_format($product->Price, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="add-actions">
                                                <ul class="add-actions-link">
                                                    <li class="add-cart active"><a href="#"
                                                            class="add-to-cart-btn"
                                                            data-product-id="{{ $product->Product_id }}">ADD TO
                                                            CART</a></li>
                                                    <li><a href="#" class="add-to-wishlist-btn"
                                                            data-product-id="{{ $product->Product_id }}"><i
                                                                class="fa fa-heart-o"></i></a></li>
                                                    <li><a class="quick-view" data-toggle="modal"
                                                            data-target="#exampleModalCenter" href="#"><i
                                                                class="fa fa-eye"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Li's Section Area End Here -->
            </div>
        </div>
    </section>
    <!-- Li's Laptop Product Area End Here -->


    <!-- Section Nintendo Switch -->
    <section class="product-area li-laptop-product pt-60 pb-45 pt-sm-50 pt-xs-60">
        <div class="container">
            <div class="row">
                <!-- Begin Li's Section Area -->
                <div class="col-lg-12">
                    <div class="li-section-title">
                        <h2>
                            <span>Nintendo Switch</span>
                        </h2>

                    </div>
                    <div class="row">
                        <div class="product-active owl-carousel">
                            @foreach ($productsCategory456 as $product)
                                <div class="col-lg-12">
                                    <div class="single-product-wrap">
                                        <div class="product-image">
                                            <a href="{{ route('products.show', $product->Slug) }}">
                                                @if ($product->images->isNotEmpty())
                                                    <img src="{{ asset('storage/' . $product->images->first()->Image_path) }}"
                                                        alt="{{ $product->Product_name }}">
                                                @else
                                                    <img src="path/to/default-image.jpg" alt="No Image">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="product_desc">
                                            <div class="product_desc_info">
                                                <div class="product-review">
                                                    <h5 class="manufacturer">
                                                        <a href="product-details.html">
                                                            {{ optional($product->brand)->Brand_name ?? 'No Brand' }}
                                                        </a>
                                                    </h5>
                                                </div>
                                                <h4>
                                                    <a class="product_name"
                                                        href="{{ route('products.show', $product->Slug) }}">{{ $product->Product_name }}</a>
                                                </h4>
                                                <div class="price-box">
                                                    <span
                                                        class="new-price">${{ number_format($product->Price, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="add-actions">
                                                <ul class="add-actions-link">
                                                    <li class="add-cart active"><a href="#"
                                                            class="add-to-cart-btn"
                                                            data-product-id="{{ $product->Product_id }}">ADD TO
                                                            CART</a></li>
                                                    <li><a href="#" class="add-to-wishlist-btn"
                                                            data-product-id="{{ $product->Product_id }}"><i
                                                                class="fa fa-heart-o"></i></a></li>
                                                    <li><a class="quick-view" data-toggle="modal"
                                                            data-target="#exampleModalCenter" href="#"><i
                                                                class="fa fa-eye"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Li's Section Area End Here -->
            </div>
        </div>
    </section>
    <!-- Li's TV & Audio Product Area End Here -->
    <!-- Begin Li's Static Home Area -->
    <div class="li-static-home">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Begin Li's Static Home Image Area -->
                    <div class="li-static-home-image"></div>
                    <!-- Li's Static Home Image Area End Here -->
                    <!-- Begin Li's Static Home Content Area -->
                    <div class="li-static-home-content">
                    </div>
                    <!-- Li's Static Home Content Area End Here -->
                </div>
            </div>
        </div>
    </div>
    <!-- Li's Static Home Area End Here -->
    <!-- Begin Group Featured Product Area -->
    <div class="group-featured-product pt-20 pb-40 pb-xs-25">
    </div>
    <!-- Group Featured Product Area End Here -->
    @include('web.layouts.footer')
    <!-- Footer Area End Here -->
    </div>
    @include('web.layouts.css-script')

    <!-- Notification HTML -->
    <div id="notification"
        style="display: none; position: fixed; top: 70px; right: 20px; z-index: 1000; background-color: #4CAF50; color: white; padding: 15px; border-radius: 5px;">
        <span id="notification-icon" style="margin-right: 10px;">
            <i class="fa fa-check-circle" style="border: 2px solid white; border-radius: 50%; padding: 5px;"></i>
        </span>
        <span id="notification-message"></span>
    </div>

    <!-- Add To Cart START -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.add-to-cart-btn').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.getAttribute('data-product-id');

                    fetch('{{ route('cart.add') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                product_id: productId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            const notification = document.getElementById('notification');
                            const message = document.getElementById('notification-message');
                            const icon = document.getElementById('notification-icon')
                                .querySelector('i');

                            if (data.success) {
                                message.textContent = data
                                .success; // Thiết lập thông điệp thành công
                                notification.style.backgroundColor =
                                '#4CAF50'; // Màu xanh cho thành công
                                icon.className = 'fa fa-check-circle'; // Icon thành công
                            } else {
                                message.textContent = data.error ||
                                'Cannot add to cart'; // Thiết lập thông điệp lỗi
                                notification.style.backgroundColor =
                                '#f44336'; // Màu đỏ cho lỗi
                                icon.className = 'fa fa-times'; // Icon lỗi
                            }

                            notification.style.display = 'block'; // Hiện thông báo

                            // Tải lại trang sau 1.2 giây rồi hiển thị thông báo
                            setTimeout(() => {
                                notification.style.display = 'none'; // Ẩn thông báo
                                location.reload(); // Tải lại trang
                            }, 1200);
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
    <!-- Add To Cart END -->

    <!-- Add To Wishlist START -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.add-to-wishlist-btn').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.getAttribute('data-product-id');

                    fetch('{{ route('wishlist.add') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                product_id: productId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            const notification = document.getElementById('notification');
                            const message = document.getElementById('notification-message');
                            const icon = document.getElementById('notification-icon')
                                .querySelector('i');

                            if (data.success) {
                                message.textContent = data
                                .success; // Thiết lập thông điệp thành công
                                notification.style.backgroundColor =
                                '#4CAF50'; // Màu xanh cho thành công
                                icon.className = 'fa fa-check-circle'; // Icon thành công

                                // Tải lại trang sau 1.2 giây khi thành công
                                setTimeout(() => {
                                    notification.style.display = 'none'; // Ẩn thông báo
                                    location.reload(); // Tải lại trang
                                }, 1200);
                            } else {
                                message.textContent = data.error ||
                                'Cannot add to wishlist'; // Thiết lập thông điệp lỗi
                                notification.style.backgroundColor =
                                '#f44336'; // Màu đỏ cho lỗi
                                icon.className = 'fa fa-times'; // Icon lỗi

                                // Chỉ ẩn thông báo sau 1.2 giây nếu có lỗi
                                setTimeout(() => {
                                    notification.style.display = 'none'; // Ẩn thông báo
                                }, 1200);
                            }

                            notification.style.display = 'block'; // Hiện thông báo
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
    <!-- Add To Wishlist END -->

</body>

</html>
