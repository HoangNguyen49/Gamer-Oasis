<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Shopping Cart</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('asset/images/favicon.png') }}">
</head>

<body>
<!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
    <div class="body-wrapper">
        @include('web.layouts.header')

        <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li class="active">Shopping Cart</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="Shopping-cart-area pt-60 pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <form action="#">
                            <div class="table-content table-responsive">
                                @php
                                    $cart = Session::get('cart', []);
                                    $subtotal = 0; // Khởi tạo subtotal
                                @endphp

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="li-product-remove">remove</th>
                                            <th class="li-product-thumbnail">images</th>
                                            <th class="cart-product-name">Product</th>
                                            <th class="li-product-price">Unit Price</th>
                                            <th class="li-product-quantity">Quantity</th>
                                            <th class="li-product-subtotal">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (empty($cart))
                                            <tr>
                                                <td colspan="6" class="text-center" style="color: red; font-weight: bold; font-size: 16px;">CART IS EMPTY, PLEASE ADD NEW PRODUCTS !!!</td>
                                            </tr>
                                        @else
                                            @foreach ($cart as $item)
                                                <tr>
                                                    <td class="li-product-remove"><a href="#"><i class="fa fa-times"></i></a></td>
                                                    <td class="li-product-thumbnail"><img src="{{ asset('storage/' . $item['image']) }}" alt="Product Image" style="width: 100px"></td>
                                                    <td class="li-product-name"><a href="#">{{ $item['product_name'] }}</a></td>
                                                    <td class="li-product-price"><span class="amount">${{ number_format($item['price'], 2) }}</span></td>
                                                    <td class="quantity">
                                                        <label>Quantity</label>
                                                        <div class="cart-plus-minus">
                                                            <input class="cart-plus-minus-box" value="{{ $item['quantity'] }}" type="text" readonly>
                                                        </div>
                                                    </td>
                                                    <td class="product-subtotal">
                                                        @php
                                                            $total = $item['price'] * $item['quantity'];
                                                            $subtotal += $total; // Cộng dồn vào subtotal
                                                        @endphp
                                                        <span class="amount">${{ number_format($total, 2) }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="coupon-all">
                                        <div class="coupon2">
                                            <input class="button" name="update_cart" value="CONTINUE SHOPPING" type="button" onclick="window.location.href='{{ url('/') }}'">
                                        </div>                                                                                
                                    </div>
                                </div>
                            </div>

                            @if (!empty($cart))
                                <div class="row">
                                    <div class="col-md-5 ml-auto">
                                        <div class="cart-page-total">
                                            <h2>Cart totals</h2>
                                            <ul>
                                                <li>Subtotal <span>${{ number_format($subtotal, 2) }}</span></li>
                                                <li>Total <span>${{ number_format($subtotal, 2) }}</span></li>
                                            </ul>
                                            <a href="{{ url('/checkout') }}">Proceed to checkout</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('web.layouts.footer')
    </div>
    @include('web.layouts.css-script')
</body>

</html>
