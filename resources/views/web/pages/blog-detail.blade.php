<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Blog Details</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('web.layouts.css-script') <!-- Bao gồm Bootstrap CSS -->

    <style>
        .btn-light {
            background: #f8f8f8;
            /* Màu nền giống với các trường nhập liệu */
            border: none;
            /* Không có viền */
            color: #666666;
            /* Màu chữ */
            padding: 8px 10px;
            /* Padding giống như các trường */
            width: 100%;
            /* Đảm bảo chiều rộng 100% */
            height: 45px;
            /* Chiều cao tương tự với trường nhập liệu */
            font-size: 14px;
            /* Kích thước chữ giống nhau */
        }

        .dropdown-menu {
            background-color: #f8f8f8;
            /* Màu nền của dropdown */
        }

        .btn-light:hover {
            background-color: #e2e6ea;
            /* Màu nền khi hover */
        }

        #top-reviews {
            position: sticky;
            top: 20px;
            /* Khoảng cách từ đầu trang khi cố định */
            z-index: 1000;
            /* Đảm bảo nằm trên các phần tử khác */
        }
    </style>
</head>

<body>
    <!-- Begin Body Wrapper -->
    <div class="body-wrapper">
        <!-- Header Area -->
        @include('web.layouts.header')

        <!-- Breadcrumb Area -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/blogs') }}">Blogs</a></li>
                        <li class="active">Detail</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Blog Page Area -->
        <div class="li-main-blog-page pt-60 pb-55">
            <div class="container">
                <div class="row d-flex align-items-start">
                    <!-- Cột mô tả bài viết -->
                    <div class="col-lg-8 col-md-7">
                        <div class="li-main-content">
                            <div class="li-blog-single-item pb-30">
                                <div class="li-blog-content">
                                    <div class="li-blog-details text-start">
                                        <h3 class="li-blog-heading pt-25">{{ $blog->title }}</h3>
                                        <div class="li-blog-meta">
                                            <a class="author" href="#"><i class="fa fa-user"></i>Admin</a>
                                            <a class="comment" href="#"><i class="fa fa-comment-o"></i>
                                                {{ $blog->comments_count }} comments</a>
                                            <a class="post-time" href="#"><i class="fa fa-calendar"></i>
                                                {{ $blog->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d M Y \a\t H:i') }}</a>
                                        </div>
                                        <p>{!! $blog->description !!}</p>
                                        <div class="li-blog-sharing text-center pt-30">
                                            <h4>Share this blog:</h4>
                                            <a href="#"><i class="fa fa-facebook"></i></a>
                                            <a href="#"><i class="fa fa-twitter"></i></a>
                                            <a href="#"><i class="fa fa-pinterest"></i></a>
                                            <a href="#"><i class="fa fa-google-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Cột Blog Banner Area Top 5 đánh giá -->
                    <div class="col-lg-4 col-md-5" id="top-reviews">
                        <h5 class="font-weight-bold mb-4">Trending Now</h5>
                        @foreach ($topBlogs as $topBlog)
                            <div class="card bg-dark text-white mb-3 border-0">
                                <div class="row no-gutters">
                                    <!-- Image Column -->
                                    <div class="col-4">
                                        <a href="{{ route('show', $topBlog->slug) }}">
                                            @php
                                                $firstImage = $topBlog->images->first();
                                            @endphp
                                            @if ($firstImage)
                                                <img src="{{ asset($firstImage->img) }}" alt="Ảnh đầu tiên hiển thị"
                                                    class="img-fluid" style="height: 100%; object-fit: cover;">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center bg-secondary"
                                                    style="height: 100px;">
                                                    <p class="text-white m-0">Không có hình ảnh</p>
                                                </div>
                                            @endif
                                        </a>
                                    </div>
                                    <!-- Content Column -->
                                    <div class="col-8 d-flex align-items-center">
                                        <div class="card-body p-2">
                                            <h5 class="card-title mb-2" style="font-size: 1em;">
                                                <a href="{{ route('show', $topBlog->slug) }}"
                                                    class="text-white">{{ $topBlog->title }}</a>
                                            </h5>
                                            <p class="card-text text-muted" style="font-size: 0.85em;">
                                                {!! Str::limit(strip_tags($topBlog->description), 100, '...') !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Blog Comment Section -->
                <div class="li-comment-section">
                    <h3>{{ $blog->comments->count() }} Comments</h3>
                    @php
                        $currentCommentPage = request()->get('comment_page', 1); // Lấy số trang hiện tại từ query string cho bình luận
                        $commentsPerPage = 5; // Số bình luận mỗi trang
                        $commentsPaginated = $blog->comments
                            ->where('parent_id', null)
                            ->slice(($currentCommentPage - 1) * $commentsPerPage, $commentsPerPage);
                        $totalCommentPages = ceil(
                            $blog->comments->where('parent_id', null)->count() / $commentsPerPage,
                        );
                    @endphp
                    <ul>
                        @foreach ($commentsPaginated as $comment)
                            <li style="display: block">
                                <!-- Bình luận cha -->
                                <div class="comment-body pl-15">
                                    <span class="reply-btn pt-15 pt-xs-5">
                                        <a href="#" class="reply-link"
                                            data-comment-id="{{ $comment->id }}">Reply</a>
                                    </span>
                                    <h5 class="comment-author pt-15">{{ $comment->user_name }}</h5>
                                    <div class="comment-post-date">
                                        {{ $comment->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d M, Y \a\t H:i') }}
                                    </div>
                                    <div class="comment-rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span class="fa fa-star{{ $i <= $comment->rating ? '' : '-o' }}"></span>
                                        @endfor
                                    </div>
                                    <p>{{ $comment->comment }}</p>
                                </div>

                                <!-- Bình luận con (phản hồi) -->
                                @if ($comment->replies)
                                    <ul style="margin-left: 30px;">
                                        @foreach ($comment->replies as $reply)
                                            <li>
                                                <div class="comment-body pl-15">
                                                    <h5 class="comment-author pt-15">{{ $reply->user_name }}</h5>
                                                    <div class="comment-post-date">
                                                        {{ $reply->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d M, Y \a\t H:i') }}
                                                    </div>
                                                    <p>{{ $reply->comment }}</p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <!-- Phân trang bình luận -->
                    <div class="col-lg-12">
                        <div class="li-paginatoin-area text-center pt-25">
                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="li-pagination-box" style="padding: 0; margin: 0; list-style: none;">
                                        @if ($currentCommentPage > 1)
                                            <li style="border: none; display: inline; margin-right: -10px;">
                                                <a
                                                    href="?page={{ request()->get('page', 1) }}&comment_page={{ $currentCommentPage - 1 }}">Previous</a>
                                            </li>
                                        @endif
                                        @for ($i = 1; $i <= $totalCommentPages; $i++)
                                            <li class="{{ $i == $currentCommentPage ? 'active' : '' }}"
                                                style="border: none; display: inline; margin-right: -10px;">
                                                <a
                                                    href="?page={{ request()->get('page', 1) }}&comment_page={{ $i }}">{{ $i }}</a>
                                            </li>
                                        @endfor
                                        @if ($currentCommentPage < $totalCommentPages)
                                            <li style="border: none; display: inline; margin-right: -10px;">
                                                <a
                                                    href="?page={{ request()->get('page', 1) }}&comment_page={{ $currentCommentPage + 1 }}">Next</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Kết thúc phân trang bình luận -->
                </div>

                <!-- Form Phản Hồi Ẩn -->
                <div id="replyFormContainer" style="display: none;">
                    <form id="replyForm" action="{{ route('comments.reply') }}" method="POST"
                        style="background-color: white; padding: 15px; border-radius: 5px;">
                        @csrf
                        <input type="hidden" name="parent_id" id="reply_parent_id" value="">

                        <div class="form-group">
                            <label style="font-weight: bold;">Name</label>
                            <input type="text" name="user_name" placeholder="Name" required>
                        </div>

                        <div class="form-group">
                            <label style="font-weight: bold;">Email</label>
                            <input type="email" name="user_email" placeholder="Email" required>
                        </div>

                        <div class="form-group">
                            <label style="font-weight: bold;">Comment</label>
                            <textarea name="comment" placeholder="Write a reply" required></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Post Reply</button>
                        </div>
                    </form>
                </div>


                <!-- Blog Comment Box Area -->
                <div class="li-blog-comment-wrapper">
                    <h3></h3>
                    <form id="commentForm" action="{{ route('comments.store', $blog->slug) }}" method="POST">
                        @csrf <!-- Thêm token CSRF -->
                        <div class="comment-post-box">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label>Comment</label>
                                    <textarea name="comment" placeholder="Write a comment" required></textarea>
                                </div>
                                <div class="col-lg-4">
                                    <label>Name</label>
                                    <input type="text" class="coment-field" name="user_name" placeholder="Name"
                                        required>
                                </div>
                                <div class="col-lg-4 position-relative">
                                    <label>Email</label>
                                    <input type="email" class="coment-field" name="user_email" placeholder="Email"
                                        required>
                                    <span id="emailError" class="text-danger"
                                        style="display: none; position: absolute; width: 100%; text-align: center; bottom: -20px; left: 0;">Vui
                                        lòng nhập địa chỉ email hợp lệ</span>
                                </div>
                                <div class="col-lg-4 position-relative">
                                    <label>Rating</label>
                                    <div class="dropdown">
                                        <button class="btn btn-light dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <span id="selected-rating">Select Rating</span>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <button class="dropdown-item" type="button" data-value="1">
                                                <span class="fa fa-star"></span>
                                            </button>
                                            <button class="dropdown-item" type="button" data-value="2">
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                            </button>
                                            <button class="dropdown-item" type="button" data-value="3">
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                            </button>
                                            <button class="dropdown-item" type="button" data-value="4">
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                            </button>
                                            <button class="dropdown-item" type="button" data-value="5">
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="rating" id="rating" required>
                                    <span id="ratingError" class="text-danger"
                                        style="display: none; position: absolute; width: 100%; text-align: center; bottom: -20px; left: 0;">Vui
                                        lòng chọn đánh giá</span>
                                </div>
                                <div class="col-lg-12">
                                    <div class="coment-btn pt-30 pb-xs-30 pb-sm-30 f-left">
                                        <input class="li-btn-2" type="submit" name="submit" value="Post Comment">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer Area -->
        @include('web.layouts.footer')
        <link rel="stylesheet" href="{{ asset('asset/css/font-awesome.min.css') }}">
        <script src="{{ asset('asset/js/jquery.meanmenu.min.js') }}"></script>
        <script src="{{ asset('asset/js/main.js') }}"></script>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Thêm class 'img-fluid' cho tất cả hình ảnh
            const imgs = document.querySelectorAll('.li-blog-details img');
            imgs.forEach(img => {
                img.classList.add('img-fluid');
            });

            // Xử lý xác thực email và đánh giá
            document.getElementById('commentForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Ngăn chặn gửi form mặc định

                const emailInput = this.user_email;
                const emailError = document.getElementById('emailError');
                const ratingInput = this.rating; // Lấy giá trị đánh giá
                const ratingError = document.getElementById(
                    'ratingError'); // ID của thông báo lỗi cho rating
                const emailPattern =
                    /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Biểu thức chính quy kiểm tra định dạng email

                // Kiểm tra email
                if (!emailPattern.test(emailInput.value)) {
                    emailError.style.display = 'block'; // Hiện thông báo lỗi email
                    emailInput.focus(); // Đưa con trỏ vào trường email
                    return; // Dừng việc gửi form
                } else {
                    emailError.style.display = 'none'; // Ẩn thông báo lỗi nếu email hợp lệ
                }

                // Kiểm tra đánh giá
                if (ratingInput.value === "") {
                    ratingError.style.display = 'block'; // Hiện thông báo lỗi cho rating
                    return; // Dừng việc gửi form nếu không chọn rating
                } else {
                    ratingError.style.display = 'none'; // Ẩn thông báo lỗi nếu đã chọn rating
                }

                // Gửi dữ liệu form bằng AJAX
                const formData = new FormData(this);

                fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest' // Để Laravel biết rằng đây là yêu cầu AJAX
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text(); // Hoặc response.json() nếu bạn trả về JSON
                    })
                    .then(data => {
                        // Xóa giá trị trong các trường nhập liệu
                        this.reset(); // Đặt lại form về trạng thái ban đầu

                        // Cập nhật giá trị cho dropdown rating
                        const dropdownButton = document.querySelector('#dropdownMenuButton');
                        dropdownButton.innerHTML =
                            '<span class="fa fa-star" data-value="0"></span> Select Rating'; // Reset lại hiển thị cho nút dropdown
                        ratingInput.value = ""; // Reset giá trị rating ẩn về trống

                        // Tự động tải lại trang sau 0,5 giây
                        setTimeout(function() {
                            location.reload(); // Tải lại trang
                        }, 500); // 500ms = 0,5 giây
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            });


            // Xử lý sự kiện cho dropdown Rating
            const ratingInput = document.getElementById('rating');
            const dropdownItems = document.querySelectorAll('.dropdown-item');

            dropdownItems.forEach(item => {
                item.addEventListener('click', function(event) {
                    event.preventDefault(); // Ngăn chặn hành vi mặc định
                    const value = this.getAttribute('data-value');
                    ratingInput.value = value; // Cập nhật giá trị rating vào input ẩn

                    // Cập nhật hiển thị trên nút dropdown
                    const stars = this.innerHTML; // Lấy sao từ item được chọn
                    document.querySelector('#dropdownMenuButton').innerHTML = stars +
                        ' <span id="selected-rating"></span>'; // Cập nhật với giá trị đã chọn

                    // Xóa thông báo lỗi cho rating nếu có
                    const existingRatingError = document.getElementById('ratingError');
                    if (existingRatingError) {
                        existingRatingError.style.display =
                            'none'; // Ẩn thông báo lỗi nếu đã chọn rating
                    }
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            // Thêm sự kiện cho tất cả các nút "Reply"
            document.querySelectorAll('.reply-link').forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault(); // Ngăn chặn chuyển trang
                    const commentId = this.getAttribute('data-comment-id');
                    openReplyForm(commentId);
                });
            });

            function openReplyForm(commentId) {
                // Gán parent_id cho form
                document.getElementById('reply_parent_id').value = commentId;

                // Lấy form và container của nó
                const replyFormContainer = document.getElementById('replyFormContainer');

                // Hiển thị form tại vị trí mong muốn (dưới bình luận)
                const commentBody = document.querySelector(`.reply-link[data-comment-id="${commentId}"]`).closest(
                    '.comment-body');
                commentBody.appendChild(replyFormContainer);

                // Hiển thị form nếu đang bị ẩn
                replyFormContainer.style.display = 'block';

                // Cuộn tới form để dễ dàng nhập liệu
                replyFormContainer.scrollIntoView({
                    behavior: 'smooth'
                });
            }

            // Xử lý gửi form reply bằng AJAX
            document.getElementById('replyForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Ngăn chặn hành vi gửi form mặc định

                const formData = new FormData(this);

                fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest' // Để Laravel biết rằng đây là yêu cầu AJAX
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text(); // Hoặc response.json() nếu trả về JSON
                    })
                    .then(data => {
                        // Reset form về trạng thái ban đầu
                        this.reset();

                        // Ẩn form reply
                        document.getElementById('replyFormContainer').style.display = 'none';

                        // tải lại trang sau khi reply
                        // Tự động tải lại trang sau 0,5 giây
                        setTimeout(function() {
                            location.reload(); // Tải lại trang
                        }, 500); // 500ms = 0,5 giây
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            });
        });
    </script>

</body>

</html>
