<!doctype html>
<html class="no-js" lang="zxx">

<!-- single-product31:30-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Product Detail</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('asset/images/favicon.png') }}">

</head>
<style>
    .product-description {
        width: 80%;
        /* Set width to 80% */
        margin: 0 auto;
        /* Center the description */
    }

    .single-add-to-cart button {
        display: inline-block;
        padding: 10px 20px;
        font-size: 10px;
        font-weight: 600;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        transition: all 0.3s ease;
    }

    .add-to-cart-btn {
        background-color: #007bff;
        color: white;
    }

    .add-to-wishlist-btn {
        background-color: #6c757d;
        color: white;
    }

    .single-add-to-cart button:hover {
        opacity: 0.8;
    }

    .single-add-to-cart button:focus {
        outline: none;
    }

    .product-details-images .lg-image {
        position: relative;
    }

    .product-details-images .sticker {
        position: absolute;
        top: 20px;
        /* Bạn có thể điều chỉnh vị trí này để sticker không bị che khuất */
        right: 20px;
        /* Đưa sticker sang bên phải */
        z-index: 99;
        height: auto;
        width: auto;
        line-height: 20px;
        /* Điều chỉnh chiều cao của dòng chữ */
        padding: 5px 10px;
        /* Thêm khoảng cách xung quanh chữ */
        text-align: center;
        text-transform: uppercase;
        font-size: 12px;
        /* Điều chỉnh kích thước chữ */
        font-weight: bold;
        border-radius: 50px;
        /* Vẫn giữ dạng tròn */
    }

    /* Khi sản phẩm hết hàng */
    .out-of-stock {
        background-color: #808080;
        /* Màu nền xám */
        color: #fff;
        /* Màu chữ trắng */
    }

    /* Khi sản phẩm là "New" */
    .new {
        background-color: #0363cd;
        /* Màu nền mặc định */
        color: #fff;
        /* Màu chữ trắng */
    }
</style>

<body>
    @include('web.layouts.header')
    <!-- Begin Li's Breadcrumb Area -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">Single Product</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Li's Breadcrumb Area End Here -->
    <!-- content-wraper start -->
    <div class="content-wraper">
        <div class="container">
            <div class="row single-product-area" style="display:flex;align-items: stretch">
                <div class="col-lg-5 col-md-6">
                    <!-- Product Details Left -->
                    <div class="product-details-left">
                        <div class="product-details-images slider-navigation-1">
                            @foreach ($product->images as $image)
                                <!-- Hiển thị hình ảnh sản phẩm -->
                                <div class="lg-image">
                                    <!-- Hiển thị sticker "Out of stock" hoặc "New" -->
                                    <span class="sticker {{ $product->Stock_Quantity == 0 ? 'out-of-stock' : 'new' }}">
                                        {{ $product->Stock_Quantity == 0 ? 'Out of stock' : 'New' }}
                                    </span>
                                    <a class="popup-img venobox vbox-item"
                                        href="{{ asset('storage/' . $image->Image_path) }}" data-gall="myGallery">
                                        <img src="{{ asset('storage/' . $image->Image_path) }}"
                                            alt="{{ $product->Product_name }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="product-details-thumbs slider-thumbs-1">
                            @foreach ($product->images as $image)
                                <!-- Hiển thị thumbnail -->
                                <div class="sm-image">
                                    <img src="{{ asset('storage/' . $image->Image_path) }}"
                                        alt="{{ $product->Product_name }} thumbnail">
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <!--// Product Details Left -->
                </div>

                <div class="col-lg-5 col-md-6">
                    <div class="product-details-view-content pt-90" style="padding-left: 60px">
                        <div class="product-info">
                            <h2>{{ $product->Product_name }}</h2> <!-- Tên sản phẩm -->
                            <span class="product-details-ref">
                                Brand: {{ $product->brand->Brand_name }}
                            </span>

                            <!-- Reference hoặc ID sản phẩm -->
                            <div class="price-box pt-20">
                                @if ($product->Price == 0)
                                    <span class="new-price">Call 0931-313-329</span>
                                @else
                                    <span class="new-price">${{ number_format($product->Price, 2) }}</span>
                                @endif
                            </div>
                            <div class="single-add-to-cart">
                                <div class="quantity" style="padding-bottom:15px; width:65px">
                                    <label for="product-quantity">Quantity:</label>
                                    <input style="padding-left:20px" type="number" id="product-quantity"
                                        name="quantity" value="1" min="1"
                                        max="{{ $product->Stock_Quantity }}">
                                </div>
                                <button class="add-to-cart-btn btn btn-primary"
                                    style="padding: 7px 10px; font-size:13px"
                                    data-product-id="{{ $product->Product_id }}">
                                    ADD TO CART
                                </button>
                                <button class="add-to-wishlist-btn btn btn-danger"
                                    style="padding: 7px 10px; font-size:13px"
                                    data-product-id="{{ $product->Product_id }}">
                                    ADD TO WISHLIST
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- content-wraper end -->
    <!-- Begin Product Area -->
    <div class="product-area pt-35">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="li-product-tab">
                        <ul class="nav li-product-menu">
                            <li><a class="active" data-toggle="tab" href="#description"><span>Description</span></a>
                            </li>
                            <li><a data-toggle="tab" href="#product-details"><span>Product Specifications</span></a>
                            </li>
                            <li><a data-toggle="tab" href="#reviews"><span>Reviews</span></a></li>
                        </ul>
                    </div>
                    <!-- Begin Li's Tab Menu Content Area -->
                </div>
            </div>
            <div class="tab-content">
                <div id="description" class="tab-pane active show" role="tabpanel">
                    <div class="product-description">
                        <!-- Kiểm tra nếu sản phẩm có description -->
                        @if ($product->Product_description)
                            <!-- Hiển thị mô tả sản phẩm với HTML -->
                            {!! $product->Product_description !!} <!-- Mô tả sản phẩm với thẻ HTML nguyên vẹn -->
                        @else
                            <!-- Thông báo nếu không có description -->
                            <p class="no-description-message">Description data has not been entered.</p>
                        @endif
                    </div>
                </div>

                <div id="product-details" class="tab-pane" role="tabpanel">
                    <div class="product-details-manufacturer">
                        <!-- Kiểm tra nếu sản phẩm có specifications -->
                        @if ($product->specifications && $product->specifications->isNotEmpty())
                            <h4 class="specifications-title">Specifications:</h4>
                            <div class="specifications-list">
                                <ul>
                                    @php
                                        // Tách chuỗi Spec_name theo dấu phân cách '|'
                                        $specifications = explode('|', $product->specifications->first()->Spec_name);
                                    @endphp
                                    @foreach ($specifications as $specification)
                                        <li class="spec-item">
                                            <!-- Hiển thị mỗi thông số trên một dòng riêng biệt -->
                                            {!! trim($specification) !!}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <!-- Thông báo nếu không có specifications -->
                            <p class="no-specs-message">Product specifications have not been entered yet.</p>
                        @endif
                    </div>

                </div>




                <div id="reviews" class="tab-pane" role="tabpanel">
                    <div class="product-reviews">
                        <div class="product-details-comment-block">
                            <div class="comment-review">
                                <span>Grade</span>
                                <ul class="rating">
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li class="no-star"><i class="fa fa-star-o"></i></li>
                                    <li class="no-star"><i class="fa fa-star-o"></i></li>
                                </ul>
                            </div>
                            <div class="comment-author-infos pt-25">
                                <span>HTML 5</span>
                                <em>01-12-18</em>
                            </div>
                            <div class="comment-details">
                                <h4 class="title-block">Demo</h4>
                                <p>Plaza</p>
                            </div>
                            <div class="review-btn">
                                <a class="review-links" href="#" data-toggle="modal"
                                    data-target="#mymodal">Write
                                    Your Review!</a>
                            </div>
                            <!-- Begin Quick View | Modal Area -->
                            <div class="modal fade modal-wrapper" id="mymodal">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <h3 class="review-page-title">Write Your Review</h3>
                                            <div class="modal-inner-area row">
                                                <div class="col-lg-6">
                                                    <div class="li-review-product">
                                                        <img src="images/product/large-size/3.jpg" alt="Li's Product">
                                                        <div class="li-review-product-desc">
                                                            <p class="li-product-name">Today is a good day Framed
                                                                poster</p>
                                                            <p>
                                                                <span>Beach Camera Exclusive Bundle - Includes Two
                                                                    Samsung Radiant 360 R3 Wi-Fi Bluetooth Speakers.
                                                                    Fill The Entire Room With Exquisite Sound via Ring
                                                                    Radiator Technology. Stream And Control R3 Speakers
                                                                    Wirelessly With Your Smartphone. Sophisticated,
                                                                    Modern Design </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="li-review-content">
                                                        <!-- Begin Feedback Area -->
                                                        <div class="feedback-area">
                                                            <div class="feedback">
                                                                <h3 class="feedback-title">Our Feedback</h3>
                                                                <form action="#">
                                                                    <p class="your-opinion">
                                                                        <label>Your Rating</label>
                                                                        <span>
                                                                            <select class="star-rating">
                                                                                <option value="1">1</option>
                                                                                <option value="2">2</option>
                                                                                <option value="3">3</option>
                                                                                <option value="4">4</option>
                                                                                <option value="5">5</option>
                                                                            </select>
                                                                        </span>
                                                                    </p>
                                                                    <p class="feedback-form">
                                                                        <label for="feedback">Your Review</label>
                                                                        <textarea id="feedback" name="comment" cols="45" rows="8" aria-required="true"></textarea>
                                                                    </p>
                                                                    <div class="feedback-input">
                                                                        <p class="feedback-form-author">
                                                                            <label for="author">Name<span
                                                                                    class="required">*</span>
                                                                            </label>
                                                                            <input id="author" name="author"
                                                                                value="" size="30"
                                                                                aria-required="true" type="text">
                                                                        </p>
                                                                        <p
                                                                            class="feedback-form-author feedback-form-email">
                                                                            <label for="email">Email<span
                                                                                    class="required">*</span>
                                                                            </label>
                                                                            <input id="email" name="email"
                                                                                value="" size="30"
                                                                                aria-required="true" type="text">
                                                                            <span class="required"><sub>*</sub>
                                                                                Required fields</span>
                                                                        </p>
                                                                        <div class="feedback-btn pb-15">
                                                                            <a href="#" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Close">Close</a>
                                                                            <a href="#">Submit</a>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <!-- Feedback Area End Here -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Quick View | Modal Area End Here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Area End Here -->
    <!-- Begin Li's Laptop Product Area -->

    <!-- Li's Laptop Product Area End Here -->
    <!-- Begin Footer Area -->
    @include('web.layouts.footer')
    <!-- Footer Area End Here -->
    </div>
    <!-- Body Wrapper End Here -->
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
                    const quantity = document.querySelector('#product-quantity') ? document
                        .querySelector('#product-quantity').value : 1;

                    fetch('{{ route('cart.add') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                quantity: quantity
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            const notification = document.getElementById('notification');
                            const message = document.getElementById('notification-message');
                            const icon = document.getElementById('notification-icon')
                                .querySelector('i');

                            if (data.success) {
                                message.textContent = data.success;
                                notification.style.backgroundColor =
                                    '#4CAF50'; // Màu xanh cho thành công
                                icon.className = 'fa fa-check-circle'; // Icon thành công
                            } else {
                                message.textContent = data.error ||
                                    'Không thể thêm vào giỏ hàng';
                                notification.style.backgroundColor =
                                    '#f44336'; // Màu đỏ cho lỗi
                                icon.className = 'fa fa-times'; // Icon lỗi
                            }

                            notification.style.display = 'block'; // Hiện thông báo

                            setTimeout(() => {
                                notification.style.display = 'none'; // Ẩn thông báo
                                location.reload(); // Tải lại trang
                            }, 1200);
                        })
                        .catch(error => console.error('Lỗi:', error));
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
