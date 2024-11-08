<!doctype html>
<html class="no-js" lang="zxx">

<!-- checkout31:27-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Checkout</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('asset/images/favicon.png') }}">

</head>

<body>
    <!--[if lt IE 8]>
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
 <![endif]-->
    <!-- Begin Body Wrapper -->
    <div class="body-wrapper">
        <!-- Begin Header Area -->
        @include('web.layouts.header')
        <!-- Header Area End Here -->
        <!-- Begin Li's Breadcrumb Area -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/cart') }}">Shopping Cart</a></li>
                        <li class="active">Checkout</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Li's Breadcrumb Area End Here -->
        <!--Checkout Area Strat-->
        <div class="checkout-area pt-60 pb-30">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="coupon-accordion">
                            <!--Accordion Start-->
                            <h3>Returning customer? <span id="showlogin">Click here to login</span></h3>
                            <div id="checkout-login" class="coupon-content">
                                <div class="coupon-info">
                                    <p class="coupon-text">Quisque gravida turpis sit amet nulla posuere lacinia. Cras
                                        sed est sit amet ipsum luctus.</p>
                                    <form action="#">
                                        <p class="form-row-first">
                                            <label>Username or email <span class="required">*</span></label>
                                            <input type="text">
                                        </p>
                                        <p class="form-row-last">
                                            <label>Password <span class="required">*</span></label>
                                            <input type="text">
                                        </p>
                                        <p class="form-row">
                                            <input value="Login" type="submit">
                                            <label>
                                                <input type="checkbox">
                                                Remember me
                                            </label>
                                        </p>
                                        <p class="lost-password"><a href="#">Lost your password?</a></p>
                                    </form>
                                </div>
                            </div>
                            <!--Accordion End-->
                            <!--Accordion Start-->
                            <h3>Have a coupon? <span id="showcoupon">Click here to enter your code</span></h3>
                            <div id="checkout_coupon" class="coupon-checkout-content" style="display: none;">
                                <div class="coupon-info">
                                    <form action="{{ route('apply.coupon') }}" method="POST">
                                        @csrf
                                        <p class="checkout-coupon">
                                            <input id="coupon_code" name="coupon_code" placeholder="Coupon code"
                                                type="text" required>
                                            <input class="button" value="APPLY COUPON" type="submit">
                                        </p>
                                    </form>
                                </div>
                            </div>
                            <!--Accordion End-->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div>
                        <form action="{{ route('order.store') }}" method="POST" style="display:flex;">
                            @csrf
                            <div class="col-lg-5 checkbox-form">
                                <h3>Customer Information</h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Full Name<span class="required">*</span></label>
                                            <input type="text" name="full_name" required placeholder="Full Name"
                                                value="{{ auth()->check() ? auth()->user()->full_name : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Phone<span class="required">*</span></label>
                                            <input type="text" name="phone" required placeholder="Phone Number"
                                                value="{{ auth()->check() ? auth()->user()->phone : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Address <span class="required">*</span></label>
                                            <input type="text" name="address" required placeholder="Address"
                                                value="{{ auth()->check() ? auth()->user()->address : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Email Address<span class="required">*</span></label>
                                            <input type="email" name="email_address" required
                                                placeholder="Email Address"
                                                value="{{ auth()->check() ? auth()->user()->email : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Nút đặt hàng -->


                            <div class="col-lg-7">
                                <div class="your-order">
                                    <h3>Your order</h3>
                                    <div class="your-order-table table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="cart-product-name">Product</th>
                                                    <th class="cart-product-total">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $subtotal = 0;
                                                @endphp
                                                @if (session('cart') && count(session('cart')) > 0)
                                                    @foreach (session('cart') as $item)
                                                        @php
                                                            $subtotal += $item['price'] * $item['quantity'];
                                                        @endphp
                                                        <tr class="cart_item">
                                                            <input type="hidden" name="product_id[]"
                                                                value="{{ $item['product_id'] }}">
                                                            <input type="hidden" name="quantity[]"
                                                                value="{{ $item['quantity'] }}">
                                                            <td class="cart-product-name">
                                                                {{ $item['product_name'] }} <strong
                                                                    class="product-quantity"> ×
                                                                    {{ $item['quantity'] }}</strong>
                                                            </td>
                                                            <td class="cart-product-total"><span
                                                                    class="amount">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="2" class="text-center"
                                                            style="color: red; font-weight: bold; font-size: 18px;">
                                                            CART IS EMPTY, PLEASE ADD NEW PRODUCTS !!!</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                            <tfoot>
                                                <tr class="cart-subtotal">
                                                    <th>Cart Subtotal</th>
                                                    <td><span class="amount">${{ number_format($subtotal, 2) }}</span>
                                                    </td>
                                                </tr>
                                                @if (Session::has('coupon'))
                                                    @php
                                                        $discount = Session::get('coupon')['discount'];
                                                        $totalAfterDiscount = Session::get('coupon')[
                                                            'totalAfterDiscount'
                                                        ];
                                                    @endphp
                                                    <tr class="discount">
                                                        <th>Discount ({{ Session::get('coupon')['code'] }})</th>
                                                        <td><span
                                                                class="amount">-${{ number_format($discount, 2) }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr class="order-total">
                                                        <th>Order Total</th>
                                                        <td><strong><span
                                                                    class="amount">${{ number_format($totalAfterDiscount, 2) }}</span></strong>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr class="order-total">
                                                        <th>Order Total</th>
                                                        <td><strong><span
                                                                    class="amount">${{ number_format($subtotal, 2) }}</span></strong>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- Payment Method Selection -->
                                    <div class="checkout-form-list">
                                        <h4>Payment Method</h4>
                                        <label style="display:flex;align-items:center;">
                                            <input type="radio" name="payment_method" value="COD" checked
                                                style="width:18px;margin-right:10px;">
                                            Cash on Delivery (COD)
                                        </label>
                                        <label style="display:flex;align-items:center;">
                                            <input type="radio" name="payment_method" value="VNPay"
                                                style="width:18px;margin-right:10px;">
                                            Payment with VNPay
                                        </label>

                                    </div>
                                </div>
                                <div class="order-button-payment">
                                    <input value="Place order" type="submit">
                                </div>
                            </div>

                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!--Checkout Area End-->
    <!-- Begin Footer Area -->
    @include('web.layouts.footer')
    <!-- Footer Area End Here -->
    </div>
    <!-- Body Wrapper End Here -->
    @include('web.layouts.css-script')

    <div id="notification"
        style="display: none; position: fixed; top: 70px; right: 20px; z-index: 1000; background-color: #4CAF50; color: white; padding: 15px; border-radius: 5px;">
        <span id="notification-icon" style="margin-right: 10px;">
            <i class="fa fa-check-circle" style="border: 2px solid white; border-radius: 50%; padding: 5px;"></i>
        </span>
        <span id="notification-message"></span>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hiển thị thông báo khi nhập coupon thành công
            @if (session('success'))
                const notification = document.getElementById('notification');
                const message = document.getElementById('notification-message');
                const icon = document.getElementById('notification-icon').querySelector('i');

                message.textContent = "{{ session('success') }}";
                notification.style.backgroundColor = '#4CAF50';
                icon.className = 'fa fa-check-circle';
                notification.style.display = 'block';

                // Tự động ẩn thông báo sau 2 giây
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 2000);
            @endif

            // Hiển thị thông báo khi nhập coupon không đúng
            @if ($errors->has('error'))
                const notification = document.getElementById('notification');
                const message = document.getElementById('notification-message');
                const icon = document.getElementById('notification-icon').querySelector('i');

                message.textContent = "{{ $errors->first('error') }}";
                notification.style.backgroundColor = '#f44336';
                icon.className = 'fa fa-times';
                notification.style.display = 'block';

                // Tự động ẩn thông báo sau 2 giây
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 2000);
            @endif
        });
    </script>

</body>

</html>
