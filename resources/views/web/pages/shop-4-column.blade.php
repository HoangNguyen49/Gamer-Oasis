<!doctype html>
<html class="no-js" lang="zxx">

<!-- shop-4-column31:48-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Product Category</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('asset/images/favicon.png') }}">
</head>
<style>
    
</style>
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
                        <li class="active">Product Category</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Li's Breadcrumb Area End Here -->
        <!-- Begin Li's Content Wraper Area -->
        <div class="content-wraper pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- shop-top-bar start -->
                        <div class="shop-top-bar mt-30" style="display:flex; justify-content:flex-end">
                            <!-- product-select-box start -->
                            <div class="product-select-box">
                                <div class="product-short">
                                    <p>Sort By:</p>
                                    <form id="sortForm">
                                        <select class="nice-select" name="sortBy"
                                            onchange="document.getElementById('sortForm').submit();">
                                            <option value="">Relevance</option>
                                            <option value="name_asc"
                                                {{ request('sortBy') == 'name_asc' ? 'selected' : '' }}>Name (A - Z)
                                            </option>
                                            <option value="name_desc"
                                                {{ request('sortBy') == 'name_desc' ? 'selected' : '' }}>Name (Z - A)
                                            </option>
                                            <option value="price_high_low"
                                                {{ request('sortBy') == 'price_high_low' ? 'selected' : '' }}>Price
                                                (High &gt; Low)</option>
                                            <option value="price_low_high"
                                                {{ request('sortBy') == 'price_low_high' ? 'selected' : '' }}>Price (Low
                                                &gt; High)</option>
                                        </select>
                                    </form>
                                </div>
                            </div>

                            <!-- product-select-box end -->
                        </div>
                        <!-- shop-top-bar end -->
                        <!-- shop-products-wrapper start -->
                        <div class="shop-products-wrapper">
                            <div class="tab-content">
                                <div id="grid-view" class="tab-pane fade active show" role="tabpanel">
                                    <div class="product-area shop-product-area" style="padding-bottom: 60px">
                                        <div class="row">
                                            @foreach ($products as $product)
                                                <div class="col-lg-3 col-md-4 col-sm-6 mt-40">
                                                    <!-- single-product-wrap start -->
                                                    <div class="single-product-wrap">
                                                        <div class="product-image">
                                                            <a href="{{ route('products.show', $product->Slug) }}">
                                                                <img src="{{ asset('storage/' . $product->images->first()->Image_path) }}"
                                                                    alt="{{ $product->Product_name }}">
                                                            </a>
                        
                                                            <!-- Hiển thị sticker "Out of stock" hoặc "New" -->
                                                            <span class="sticker {{ $product->Stock_Quantity == 0 ? 'out-of-stock' : 'new' }}">
                                                                {{ $product->Stock_Quantity == 0 ? 'Out of stock' : 'New' }}
                                                            </span>
                                                        </div>
                                                        <div class="product_desc">
                                                            <div class="product_desc_info">
                                                                <div class="product-review">
                                                                    <h5 class="manufacturer">
                                                                        <a href="{{ route('products.show', $product->Slug) }}">
                                                                            {{ optional($product->brand)->Brand_name ?? 'No Brand' }}
                                                                        </a>
                                                                        <!-- Hiển thị tên thương hiệu nếu có -->
                                                                    </h5>
                                                                    <div class="rating-box">
                                                                        <ul class="rating">
                                                                            <li><i class="fa fa-star"></i></li>
                                                                            <li><i class="fa fa-star"></i></li>
                                                                            <li><i class="fa fa-star"></i></li>
                                                                            <li class="no-star"><i class="fa fa-star"></i></li>
                                                                            <li class="no-star"><i class="fa fa-star"></i></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <h4>
                                                                    <a class="product_name" href="{{ route('products.show', $product->Slug) }}">
                                                                        {{ $product->Product_name }}
                                                                    </a>
                                                                </h4>
                                                                <div class="price-box">
                                                                    @if ($product->Price == 0)
                                                                        <span class="new-price">Call 0931-313-329</span>
                                                                    @else
                                                                        <span class="new-price">${{ number_format($product->Price, 2) }}</span>
                                                                    @endif
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="add-actions">
                                                                <ul class="add-actions-link">
                                                                    <li class="add-cart active"><a href="#"
                                                                            class="add-to-cart-btn" data-product-id="{{ $product->Product_id }}">ADD TO CART</a></li>
                                                                    <li><a href="#" class="add-to-wishlist-btn" data-product-id="{{ $product->Product_id }}"><i
                                                                            class="fa fa-heart-o"></i></a></li>
                                                                            <li><a href="{{ route('products.show', $product->Slug) }}"><i
                                                                                class="fa fa-eye"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- single-product-wrap end -->
                                                </div>
                                            @endforeach
                                        </div>
                        
                                        <div class="paginatoin-area">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <p>Showing {{ $products->firstItem() }} - {{ $products->lastItem() }} of {{ $products->total() }} item(s)</p>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <ul class="pagination-box">
                                                        <!-- Phần này sẽ tự động tạo các liên kết phân trang -->
                                                        @if ($products->onFirstPage())
                                                            <li class="disabled"><span><i class="fa fa-chevron-left"></i> Previous</span></li>
                                                        @else
                                                            <li><a href="{{ $products->previousPageUrl() }}" class="Previous"><i class="fa fa-chevron-left"></i> Previous</a></li>
                                                        @endif
                        
                                                        @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                                            <li class="{{ $page == $products->currentPage() ? 'active' : '' }}">
                                                                <a href="{{ $url }}">{{ $page }}</a>
                                                            </li>
                                                        @endforeach
                        
                                                        @if ($products->hasMorePages())
                                                            <li><a href="{{ $products->nextPageUrl() }}" class="Next"> Next <i class="fa fa-chevron-right"></i></a></li>
                                                        @else
                                                            <li class="disabled"><span>Next <i class="fa fa-chevron-right"></i></span></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                        
                                    </div>
                                </div>
                                <!-- shop-products-wrapper end -->
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- Content Wraper Area End Here -->
            </div>
            <!-- Body Wrapper End Here -->
            @include('web.layouts.footer')

            @include('web.layouts.css-script')

            <!-- Notification HTML -->
            <div id="notification"
                style="display: none; position: fixed; top: 70px; right: 20px; z-index: 1000; background-color: #4CAF50; color: white; padding: 15px; border-radius: 5px;">
                <span id="notification-icon" style="margin-right: 10px;">
                    <i class="fa fa-check-circle"
                        style="border: 2px solid white; border-radius: 50%; padding: 5px;"></i>
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