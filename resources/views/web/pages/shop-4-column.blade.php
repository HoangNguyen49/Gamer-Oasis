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
        <div class="content-wraper pt-60 pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Begin Li's Banner Area -->
                        <div class="single-banner shop-page-banner">
                            <a href="#">
                                <img src="images/bg-banner/2.jpg" alt="Li's Static Banner">
                            </a>
                        </div>
                        <!-- Li's Banner Area End Here -->
                        <!-- shop-top-bar start -->
                        <div class="shop-top-bar mt-30">
                            <div class="shop-bar-inner">
                                <div class="product-view-mode">
                                    <!-- shop-item-filter-list start -->
                                    <ul class="nav shop-item-filter-list" role="tablist">
                                        <li class="active" role="presentation"><a aria-selected="true"
                                                class="active show" data-toggle="tab" role="tab"
                                                aria-controls="grid-view" href="#grid-view"><i class="fa fa-th"></i></a>
                                        </li>
                                        <li role="presentation"><a data-toggle="tab" role="tab"
                                                aria-controls="list-view" href="#list-view"><i
                                                    class="fa fa-th-list"></i></a></li>
                                    </ul>
                                    <!-- shop-item-filter-list end -->
                                </div>
                                <div class="toolbar-amount">
                                    <span>Showing 1 to 9 of 15</span>
                                </div>
                            </div>
                            <!-- product-select-box start -->
                            <div class="product-select-box">
                                <div class="product-short">
                                    <p>Sort By:</p>
                                    <select class="nice-select">
                                        <option value="trending">Relevance</option>
                                        <option value="sales">Name (A - Z)</option>
                                        <option value="sales">Name (Z - A)</option>
                                        <option value="rating">Price (Low &gt; High)</option>
                                        <option value="date">Rating (Lowest)</option>
                                        <option value="price-asc">Model (A - Z)</option>
                                        <option value="price-asc">Model (Z - A)</option>
                                    </select>
                                </div>
                            </div>
                            <!-- product-select-box end -->
                        </div>
                        <!-- shop-top-bar end -->
                        <!-- shop-products-wrapper start -->
                        <div class="shop-products-wrapper">
                            <div class="tab-content">
                                <div id="grid-view" class="tab-pane fade active show" role="tabpanel">
                                    <div class="product-area shop-product-area">
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
                                                            <span class="sticker">New</span>
                                                            <!-- Bạn có thể thêm điều kiện để hiển thị "New" nếu sản phẩm là mới -->
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
                                                                    <span class="new-price">${{ number_format($product->Price, 2) }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="add-actions">
                                                                <ul class="add-actions-link">
                                                                    <li class="add-cart active"><a href="#" class="add-to-cart-btn" data-product-id="{{ $product->Product_id }}">ADD TO CART</a></li>
                                                    <li><a href="#" class="add-to-wishlist-btn" data-product-id="{{ $product->Product_id }}"><i class="fa fa-heart-o"></i></a></li>
                                                    
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
                                            <p>Showing 1-12 of 13 item(s)</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <ul class="pagination-box">
                                                <li><a href="#" class="Previous"><i
                                                            class="fa fa-chevron-left"></i> Previous</a>
                                                </li>
                                                <li class="active"><a href="#">1</a></li>
                                                <li><a href="#">2</a></li>
                                                <li><a href="#">3</a></li>
                                                <li>
                                                    <a href="#" class="Next"> Next <i
                                                            class="fa fa-chevron-right"></i></a>
                                                </li>
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
        <!-- Begin Footer Area -->
        @include('web.layouts.footer')

        <!-- Footer Area End Here -->
        <!-- Begin Quick View | Modal Area -->
        <div class="modal fade modal-wrapper" id="exampleModalCenter">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="modal-inner-area row">
                            <div class="col-lg-5 col-md-6 col-sm-6">
                                <!-- Product Details Left -->
                                <div class="product-details-left">
                                    <div class="product-details-images slider-navigation-1">
                                        <div class="lg-image">
                                            <img src="images/product/large-size/1.jpg" alt="product image">
                                        </div>
                                        <div class="lg-image">
                                            <img src="images/product/large-size/2.jpg" alt="product image">
                                        </div>
                                        <div class="lg-image">
                                            <img src="images/product/large-size/3.jpg" alt="product image">
                                        </div>
                                        <div class="lg-image">
                                            <img src="images/product/large-size/4.jpg" alt="product image">
                                        </div>
                                        <div class="lg-image">
                                            <img src="images/product/large-size/5.jpg" alt="product image">
                                        </div>
                                        <div class="lg-image">
                                            <img src="images/product/large-size/6.jpg" alt="product image">
                                        </div>
                                    </div>
                                    <div class="product-details-thumbs slider-thumbs-1">
                                        <div class="sm-image"><img src="images/product/small-size/1.jpg"
                                                alt="product image thumb"></div>
                                        <div class="sm-image"><img src="images/product/small-size/2.jpg"
                                                alt="product image thumb"></div>
                                        <div class="sm-image"><img src="images/product/small-size/3.jpg"
                                                alt="product image thumb"></div>
                                        <div class="sm-image"><img src="images/product/small-size/4.jpg"
                                                alt="product image thumb"></div>
                                        <div class="sm-image"><img src="images/product/small-size/5.jpg"
                                                alt="product image thumb"></div>
                                        <div class="sm-image"><img src="images/product/small-size/6.jpg"
                                                alt="product image thumb"></div>
                                    </div>
                                </div>
                                <!--// Product Details Left -->
                            </div>

                            <div class="col-lg-7 col-md-6 col-sm-6">
                                <div class="product-details-view-content pt-60">
                                    <div class="product-info">
                                        <h2>Today is a good day Framed poster</h2>
                                        <span class="product-details-ref">Reference: demo_15</span>
                                        <div class="rating-box pt-20">
                                            <ul class="rating rating-with-review-item">
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="review-item"><a href="#">Read Review</a></li>
                                                <li class="review-item"><a href="#">Write Review</a></li>
                                            </ul>
                                        </div>
                                        <div class="price-box pt-20">
                                            <span class="new-price new-price-2">$57.98</span>
                                        </div>
                                        <div class="product-desc">
                                            <p>
                                                <span>100% cotton double printed dress. Black and white striped top and
                                                    orange high waisted skater skirt bottom. Lorem ipsum dolor sit amet,
                                                    consectetur adipisicing elit. quibusdam corporis, earum facilis et
                                                    nostrum dolorum accusamus similique eveniet quia pariatur.
                                                </span>
                                            </p>
                                        </div>
                                        <div class="product-variants">
                                            <div class="produt-variants-size">
                                                <label>Dimension</label>
                                                <select class="nice-select">
                                                    <option value="1" title="S" selected="selected">
                                                        40x60cm</option>
                                                    <option value="2" title="M">60x90cm</option>
                                                    <option value="3" title="L">80x120cm</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="single-add-to-cart">
                                            <form action="#" class="cart-quantity">
                                                <div class="quantity">
                                                    <label>Quantity</label>
                                                    <div class="cart-plus-minus">
                                                        <input class="cart-plus-minus-box" value="1"
                                                            type="text">
                                                        <div class="dec qtybutton"><i class="fa fa-angle-down"></i>
                                                        </div>
                                                        <div class="inc qtybutton"><i class="fa fa-angle-up"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="add-cart active"><a href="#" class="add-to-cart-btn" data-product-id="{{ $product->Product_id }}" type="submit">Add to cart</button>
                                            </form>
                                        </div>
                                        <div class="product-additional-info pt-25">
                                            <a href="#" class="add-to-wishlist-btn" data-product-id="{{ $product->Product_id }}"><i
                                                    class="fa fa-heart-o"></i>Add to wishlist</a>
                                            <div class="product-social-sharing pt-25">
                                                <ul>
                                                    <li class="facebook"><a href="#"><i
                                                                class="fa fa-facebook"></i>Facebook</a></li>
                                                    <li class="twitter"><a href="#"><i
                                                                class="fa fa-twitter"></i>Twitter</a></li>
                                                    <li class="google-plus"><a href="#"><i
                                                                class="fa fa-google-plus"></i>Google +</a></li>
                                                    <li class="instagram"><a href="#"><i
                                                                class="fa fa-instagram"></i>Instagram</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Quick View | Modal Area End Here -->
    </div>
    <!-- Body Wrapper End Here -->
    @include('web.layouts.css-script')

    <!-- Notification HTML -->
    <div id="notification" style="display: none; position: fixed; top: 70px; right: 20px; z-index: 1000; background-color: #4CAF50; color: white; padding: 15px; border-radius: 5px;">
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

                            // Tải lại trang sau 1.2 giây khi thành công
                            setTimeout(() => {
                                notification.style.display = 'none'; // Ẩn thông báo
                                location.reload(); // Tải lại trang
                            }, 1200);
                        } else {
                            message.textContent = data.error || 'Cannot add to wishlist'; // Thiết lập thông điệp lỗi
                            notification.style.backgroundColor = '#f44336'; // Màu đỏ cho lỗi
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
