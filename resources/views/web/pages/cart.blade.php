<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Shopping Cart</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('asset/images/favicon.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
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
                        <form action="{{ route('cart.applyCoupon') }}" method="POST">
                            @csrf
                            <div class="table-content table-responsive">
                                @php
                                    $cart = Session::get('cart', []);
                                    $subtotal = 0;
                                @endphp

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="li-product-remove">Remove</th>
                                            <th class="li-product-thumbnail">Images</th>
                                            <th class="cart-product-name">Product</th>
                                            <th class="li-product-price">Unit Price</th>
                                            <th class="li-product-quantity">Quantity</th>
                                            <th class="li-product-subtotal">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (empty($cart))
                                            <tr>
                                                <td colspan="6" class="text-center" style="color: red; font-weight: bold; font-size: 16px;">
                                                    CART IS EMPTY, PLEASE ADD NEW PRODUCTS !!!
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($cart as $item)
                                                <tr>
                                                    <td class="li-product-remove">
                                                        <a href="#" class="remove-from-cart" data-product-id="{{ $item['product_id'] }}">
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                    </td>
                                                    <td class="li-product-thumbnail">
                                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="Product Image" style="width: 100px">
                                                    </td>
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
                                                            $subtotal += $total;
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
                                        <div class="coupon">
                                            <input id="coupon_code" class="input-text" name="coupon_code" value="" placeholder="Coupon code" type="text" required>
                                            <input class="button" name="apply_coupon" value="APPLY COUPON" type="submit">
                                        </div>
                                        <div class="coupon2">
                                            <input class="button" name="update_cart" value="CONTINUE SHOPPING" type="button" onclick="window.location.href='{{ url('/') }}'">
                                        </div>
                                    </div>
                                    @if (session('error') && session('error') == 'Cart is empty!')
                                        <div class="alert alert-danger" style="margin-top: 10px;">Cannot apply coupon, cart is empty!</div>
                                    @endif
                                    @if (session('coupon_error'))
                                        <div class="alert alert-danger" style="margin-top: 10px;">{{ session('coupon_error') }}</div>
                                    @endif
                                </div>
                            </div>

                    </div>

                    @if (!empty($cart))
                        <div class="row" style="width: 100%">
                            <div class="col-md-5 ml-auto">
                                <div class="cart-page-total">
                                    <h2>Cart totals</h2>
                                    <ul>
                                        <li>Subtotal <span>${{ number_format($subtotal, 2) }}</span></li>
                                        @if (Session::has('coupon'))
                                            <li>Discount ({{ Session::get('coupon')['code'] }}) <span>-${{ number_format(Session::get('coupon')['discount'], 2) }}</span></li>
                                            <li>Total <span>${{ number_format(Session::get('coupon')['totalAfterDiscount'], 2) }}</span></li>
                                        @else
                                            <li>Total <span>${{ number_format($subtotal, 2) }}</span></li>
                                        @endif
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

    <!-- Notification HTML -->
    <div id="notification" style="display: none; position: fixed; top: 70px; right: 20px; z-index: 1000; background-color: #4CAF50; color: white; padding: 15px; border-radius: 5px;">
        <span id="notification-icon" style="margin-right: 10px;">
            <i class="fa fa-check-circle" style="border: 2px solid white; border-radius: 50%; padding: 5px;"></i>
        </span>
        <span id="notification-message"></span>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý sự kiện xóa sản phẩm khỏi giỏ hàng
            document.querySelectorAll('.remove-from-cart').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.getAttribute('data-product-id');

                    fetch('{{ route('cart.remove') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ product_id: productId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        const notification = document.getElementById('notification');
                        const message = document.getElementById('notification-message');
                        const icon = document.getElementById('notification-icon').querySelector('i');

                        if (data.success) {
                            message.textContent = data.success; 
                            notification.style.backgroundColor = '#4CAF50'; 
                            icon.className = 'fa fa-check-circle'; 
                        } else {
                            message.textContent = data.error; 
                            notification.style.backgroundColor = '#f44336'; 
                            icon.className = 'fa fa-times'; 
                        }

                        notification.style.display = 'block'; 

                        // Tự động ẩn thông báo sau 2 giây
                        setTimeout(() => {
                            notification.style.display = 'none';
                            if (data.success) {
                                location.reload(); 
                            }
                        }, 2000);
                    })
                    .catch(error => console.error('Error:', error));
                });
            });

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
            @if (session('error'))
                const notification = document.getElementById('notification');
                const message = document.getElementById('notification-message');
                const icon = document.getElementById('notification-icon').querySelector('i');

                message.textContent = "{{ session('error') }}"; 
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
