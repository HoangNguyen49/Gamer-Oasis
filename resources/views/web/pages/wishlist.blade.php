<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Wishlist</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('asset/images/favicon.png') }}">
</head>

<body>
    <!-- Begin Body Wrapper -->
    <div class="body-wrapper">
        @include('web.layouts.header')
        <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li class="active">Wishlist</li>
                    </ul>
                </div>
            </div>
        </div>
        <!--Wishlist Area Start-->
        <div class="wishlist-area pt-60 pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <form action="#">
                            <div class="table-content table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="li-product-remove">Remove</th>
                                            <th class="li-product-thumbnail">Images</th>
                                            <th class="cart-product-name">Product</th>
                                            <th class="li-product-price">Unit Price</th>
                                            <th class="li-product-stock-status">Stock Status</th>
                                            <th class="li-product-add-cart">Add To Cart</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $wishlist = session('wishlist', []);
                                        @endphp
                                        @if (isset($wishlist) && is_array($wishlist) && count($wishlist) > 0)
                                            @foreach ($wishlist as $item)
                                                <tr>
                                                    <td class="li-product-remove">
                                                        <a href="#" class="remove-from-wishlist"
                                                            data-product-id="{{ $item['product_id'] }}">
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                    </td>
                                                    <td class="li-product-thumbnail">
                                                        <img src="{{ asset('storage/' . $item['image']) }}"
                                                            style="width: 100px" class="card-img-top"
                                                            alt="{{ $item['product_name'] }}">
                                                    </td>
                                                    <td class="li-product-name"><a
                                                            href="#">{{ $item['product_name'] }}</a></td>
                                                    <td class="li-product-price"><span
                                                            class="amount">${{ number_format($item['price'], 2, '.', ',') }}</span>
                                                    </td>
                                                    <td class="li-product-stock-status">
                                                        <span class="{{ isset($item['stock_quantity']) && $item['stock_quantity'] > 0 ? 'in-stock' : 'out-of-stock' }}">
                                                            {{ isset($item['stock_quantity']) && $item['stock_quantity'] > 0 ? 'In Stock' : 'Out of Stock'}}
                                                        </span>
                                                    </td>                                                                                                       
                                                    <td class="li-product-add-cart">
                                                        <a href="#" class="add-to-cart-btn"
                                                            data-product-id="{{ $item['product_id'] }}">ADD TO CART</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" style="text-align:center; font-size: 16px; font-weight: bold; color: red;">NO PRODUCTS IN WISHLIST</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--Wishlist Area End-->
        @include('web.layouts.footer')
    </div>
    @include('web.layouts.css-script')

    <!-- Notification HTML START -->
    <div id="notification"
        style="display: none; position: fixed; top: 70px; right: 20px; z-index: 1000; background-color: #4CAF50; color: white; padding: 15px; border-radius: 5px;">
        <span id="notification-icon" style="margin-right: 10px;">
            <i class="fa fa-check-circle" style="border: 2px solid white; border-radius: 50%; padding: 5px;"></i>
        </span>
        <span id="notification-message"></span>
    </div>
    <!-- Notification HTML END -->
    
    <!-- Add To Cart From Wishlist START -->
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
                        body: JSON.stringify({ product_id: productId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        const notification = document.getElementById('notification');
                        const message = document.getElementById('notification-message');
                        const icon = document.getElementById('notification-icon').querySelector('i');

                        if (data.success) {
                            message.textContent = data.success; // Thiết lập thông điệp thành công
                            notification.style.backgroundColor = '#4CAF50'; // Màu xanh cho thành công
                            icon.className = 'fa fa-check-circle'; // Icon thành công
                        } else {
                            message.textContent = data.error || 'Cannot add to cart'; // Thiết lập thông điệp lỗi
                            notification.style.backgroundColor = '#f44336'; // Màu đỏ cho lỗi
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
    <!-- Add To Cart From Wishlist END -->

    <!-- Remove Product Form Wishlist START -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý sự kiện xóa sản phẩm khỏi giỏ hàng
            document.querySelectorAll('.remove-from-wishlist').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.getAttribute('data-product-id');

                    fetch('{{ route('wishlist.remove') }}', {
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
                            if (data.success) {
                                // Hiện thông báo thành công
                                message.textContent = data
                                .success; // Thiết lập thông điệp thành công
                                notification.style.backgroundColor =
                                '#4CAF50'; // Màu xanh cho thông báo thành công
                            } else {
                                // Hiện thông báo lỗi
                                message.textContent = data.error; // Thiết lập thông điệp lỗi
                                notification.style.backgroundColor =
                                '#f44336'; // Màu đỏ cho thông báo lỗi
                            }

                            notification.style.display = 'block'; // Hiện thông báo

                            // Tự động ẩn thông báo sau 2 giây
                            setTimeout(() => {
                                notification.style.display = 'none';
                                location.reload(); // Tải lại trang sau khi xóa
                            }, 2000);
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
    <!-- Remove Product Form Wishlist END -->

</body>

</html>
