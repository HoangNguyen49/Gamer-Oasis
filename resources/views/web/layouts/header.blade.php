<!doctype html>
<html class="no-js" lang="zxx">

<!-- index-431:41-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Gamer Oasis</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('asset/images/favicon.png') }}">
    <!-- Material Design Iconic Font-V2.2.0 -->
    <link rel="stylesheet" href="{{ asset('asset/css/material-design-iconic-font.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('asset/css/font-awesome.min.css') }}">
    <!-- Font Awesome Stars-->
    <link rel="stylesheet" href="{{ asset('asset/css/fontawesome-stars.css') }}">
    <!-- Meanmenu CSS -->
    <link rel="stylesheet" href="{{ asset('asset/css/meanmenu.css') }}">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="{{ asset('asset/css/owl.carousel.min.css') }}">
    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" href="{{ asset('asset/css/slick.css') }}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('asset/css/animate.css') }}">
    <!-- Jquery-ui CSS -->
    <link rel="stylesheet" href="{{ asset('asset/css/jquery-ui.min.css') }}">
    <!-- Venobox CSS -->
    <link rel="stylesheet" href="{{ asset('asset/css/venobox.css') }}">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="{{ asset('asset/css/nice-select.css') }}">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{ asset('asset/css/magnific-popup.css') }}">
    <!-- Bootstrap V4.1.3 Fremwork CSS -->
    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap.min.css') }}">
    <!-- Helper CSS -->
    <link rel="stylesheet" href="{{ asset('asset/css/helper.css') }}">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    {{-- Vendor CSS --}}

    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('asset/css/responsive.css') }}">
    <!-- Modernizr js -->
    <script src="{{ asset('asset/js/vendor/modernizr-2.8.3.min.js') }}"></script>

<body>


    </head>
    <!--[if lt IE 8]>
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
 <![endif]-->
    <!-- Begin Body Wrapper -->
    <div class="body-wrapper">
        <!-- Begin Header Area -->
        <header class="li-header-4">
            <!-- Begin Header Top Area -->
            <div class="header-top">
                <div class="container">
                    <div class="row">
                        <!-- Begin Header Top Left Area -->
                        <div class="col-lg-3 col-md-4">
                            <div class="header-top-left">
                                <ul class="phone-wrap">
                                    <li><span>Telephone Enquiry:</span><a href="#">(+123) 123 321 345</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Header Top Left Area End Here -->
                        <!-- Begin Header Top Right Area -->
                        <div class="col-lg-9 col-md-8">
                            <div class="header-top-right">
                                <ul class="ht-menu">
                                    <!-- Begin Setting Area -->
                                    <li class="setting-area">
                                        <div class="ht-setting-trigger">
                                            <span style="font-size: 18px; font-weight: bold;">{{ Auth::check() ? Auth::user()->Name : 'setting' }}</span>
                                        </div>
                                        <div class="setting ht-setting">
                                            <ul class="ht-setting-list">
                                                @if(Auth::check())
                                                    <li><a href="{{ route('user.account') }}" class="account-link">My Account</a></li>
                                                    <li><a href="{{ url('/order-history') }}" class="order-link">Order History</a></li>
                                                    <li><a href="{{ url('/checkout') }}" class="checkout-link">Checkout</a></li>
                                                    <li>
                                                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-link logout-link" style="padding: 0; text-decoration: none; color: #007bff;">Logout</button>
                                                        </form>
                                                    </li>
                                                @else
                                                    <li><a href="{{ url('/login-register') }}" class="login-link">Sign In</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Header Top Right Area End Here -->
                    </div>
                </div>
            </div>
            <!-- Header Top Area End Here -->
            <!-- Begin Header Middle Area -->
            <div class="header-middle pl-sm-0 pr-sm-0 pl-xs-0 pr-xs-0">
                <div class="container">
                    <div class="row">
                        <!-- Begin Header Logo Area -->
                        <div class="col-lg-3">
                            <div class="logo pb-sm-30 pb-xs-30">
                                <a href="{{ url('/') }}">
                                    <img class="logonav" src="{{ asset('asset/images/menu/logo/logo.png') }}"
                                        alt="">
                                </a>
                            </div>
                        </div>
                        <!-- Header Logo Area End Here -->
                        <!-- Begin Header Middle Right Area -->
                        <div class="col-lg-9 pl-0 ml-sm-15 ml-xs-15">
                            <!-- Begin Header Middle Searchbox Area -->
                            <form action="#" class="hm-searchbox">
                                <select class="nice-select select-search-category">
                                    <option value="0">All</option>
                                    <option value="1">Laptop Gaming</option>
                                    <option value="2">Console</option>
                                    <option value="3">Nintendo Switch</option>
                                    <option value="4">Assesories</option>
                                    <option value="5">Blog</option>
                                </select>
                                <input type="text" placeholder="Enter your search ...">
                                <button class="li-btn" type="submit"><i class="fa fa-search"></i></button>
                            </form>
                            <!-- Header Middle Searchbox Area End Here -->
                            <!-- Begin Header Middle Right Area -->
                            <div class="header-middle-right">
                                <ul class="hm-menu">
                                    <!-- Begin Header Middle Wishlist Area -->
                                    <li class="hm-wishlist">
                                        <a href="{{ url('/wishlist') }}">
                                            <span
                                                class="cart-item-count wishlist-item-count">{{ count(Session::get('wishlist', [])) }}</span>
                                            <i class="fa fa-heart-o"></i>
                                        </a>
                                    </li>
                                    <!-- Header Middle Wishlist Area End Here -->
                                    <!-- Begin Header Mini Cart Area -->
                                    <li class="hm-minicart">
                                        <div class="hm-minicart-trigger">
                                            <span class="item-icon"></span>
                                            <span class="item-text">
                                                <span class="cart-item-count">{{ count(session('cart', [])) }}</span>
                                                <!-- Hiển thị số lượng sản phẩm -->
                                            </span>
                                        </div>
                                        <span></span>
                                        <div class="minicart">
                                            @php
                                                $subtotal = 0; // Khởi tạo biến subtotal
                                                if (session('cart')) {
                                                    foreach (session('cart') as $item) {
                                                        $subtotal += $item['price'] * $item['quantity']; // Tính tổng giá trị giỏ hàng
                                                    }
                                                }
                                            @endphp
                                            <p class="minicart-total">SUBTOTAL:
                                                <span>${{ number_format($subtotal, 2) }}</span>
                                            </p>
                                            <!-- Hiển thị tổng giá trị -->
                                            <div class="minicart-button">
                                                <a href="{{ url('/cart') }}"
                                                    class="li-button li-button-dark li-button-fullwidth li-button-sm">
                                                    <span>View Full Cart</span>
                                                </a>
                                                <a href="{{ url('/checkout') }}"
                                                    class="li-button li-button-dark li-button-fullwidth li-button-sm">
                                                    <span>Checkout</span>
                                                </a>
                                            </div>
                                        </div>
                                    </li>

                                    <!-- Header Mini Cart Area End Here -->
                                </ul>
                            </div>
                            <!-- Header Middle Right Area End Here -->
                        </div>
                        <!-- Header Middle Right Area End Here -->
                    </div>
                </div>
            </div>
            <!-- Header Middle Area End Here -->
            <!-- Begin Header Bottom Area -->
            <div class="header-bottom header-sticky stick d-none d-lg-block d-xl-block">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Begin Header Bottom Menu Area -->
                            <div class="hb-menu">
                                <nav>
                                    <ul>
                                        <li><a href="{{ url('/') }}">Home</a></li>
                                        <li class="megamenu-holder"><a href="shop-left-sidebar.html">Product</a>
                                            <ul class="megamenu hb-megamenu">
                                                <li><a href="#">PLAYSTATION</a>
                                                    <ul>
                                                        <li><a
                                                                href="{{ route('products.category', ['categoryId' => 1]) }}">PS5
                                                                Console</a></li>
                                                        <li><a href="{{ route('products.category', 3) }}">PS5 Game</a>
                                                        </li>
                                                        <li><a href="{{ route('products.category', 2) }}">PS5
                                                                Accessories</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="single-product-gallery-left.html">NINTENDO SWITCH</a>
                                                    <ul>
                                                        <li><a
                                                                href="{{ route('products.category', ['categoryId' => 4]) }}">Nintendo
                                                                Switch</a>
                                                        </li>
                                                        <li><a href="{{ route('products.category', 6) }}">Nintendo
                                                                Switch
                                                                Game</a></li>
                                                        <li><a href="{{ route('products.category', 5) }}">Nintendo
                                                                Switch
                                                                Accessories</a></li>
                                                    </ul>
                                                </li>
                                                <li class="dropdown-holder"><a href="#">LAPTOP
                                                        GAMING</a>
                                                    <ul>
                                                        <li><a href="{{ route('products.brand', 3) }}">DELL</a></li>
                                                        <li><a href="{{ route('products.brand', 4) }}">ACER</a></li>
                                                        <li><a href="{{ route('products.brand', 5) }}">LENOVO</a></li>
                                                        <li><a href="{{ route('products.brand', 6) }}">MSI</a></li>
                                                        <li><a href="{{ route('products.category', 8) }}">Laptop Accessories</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a href="{{ url('/blog') }}">Blog</a></li>
                                        <li><a href="{{ url('/about-us') }}">About Us</a></li>
                                        <li><a href="{{ url('/contact') }}">Contact</a></li>

                                        <li class="megamenu-static-holder"><a href="">Guide</a>
                                            <ul class="hb-dropdown">
                                                <li><a href="/buying-guide">Purchase instructions</a></li>
                                                <li><a href="/payment-guide">Payment instructions</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <!-- Header Bottom Menu Area End Here -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header Bottom Area End Here -->
            <!-- Begin Mobile Menu Area -->
            <div class="mobile-menu-area mobile-menu-area-4 d-lg-none d-xl-none col-12">
                <div class="container">
                    <div class="row">
                        <div class="mobile-menu">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu Area End Here -->
        </header>
</body>
