<!doctype html>
<html class="no-js" lang="zxx">

<!-- blog-list31:56-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Blog List</title>
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
                        <li class="active">Blog List</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Li's Breadcrumb Area End Here -->
        <!-- Begin Li's Main Blog Page Area -->
        <div class="li-main-blog-page pt-60 pb-55">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row li-main-content">
                            @php
                                $currentDate = request()->get('date');
                                if ($currentDate) {
                                    // Lọc các bài viết theo ngày đã chọn
                                    $blogs = $blogs->filter(function ($blog) use ($currentDate) {
                                        // Đảm bảo sử dụng múi giờ Asia/Ho_Chi_Minh
                                        $blogDate = $blog->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d-M-Y');
                                        return $blogDate == $currentDate;
                                    });
                                }

                                // Phân trang lại sau khi lọc
                                $currentPage = request()->get('page', 1);
                                $perPage = 5;
                                $sortedBlogs = $blogs->sortByDesc('created_at'); // Sắp xếp bài viết theo ngày mới nhất
                                $blogsPaginated = $sortedBlogs->slice(($currentPage - 1) * $perPage, $perPage); // Áp dụng phân trang
                                $totalPages = ceil($blogs->count() / $perPage); // Tổng số trang
                            @endphp

                            @foreach ($blogsPaginated as $blog)
                                <div class="col-lg-12">
                                    <div class="li-blog-single-item pb-30">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="li-blog-banner">
                                                    <a href="{{ route('show', $blog->slug) }}">
                                                        @php
                                                            $firstImage = $blog->images->first();
                                                        @endphp
                                                        @if ($firstImage)
                                                            <img class="img-full" src="{{ asset($firstImage->img) }}"
                                                                alt="Ảnh đầu tiên hiển thị">
                                                        @else
                                                            <p>Không hiển thị được hình ảnh</p>
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="li-blog-content">
                                                    <div class="li-blog-details">
                                                        <h3 class="li-blog-heading pt-xs-25 pt-sm-25">
                                                            <a
                                                                href="{{ route('show', $blog->slug) }}">{{ $blog->title }}</a>
                                                        </h3>
                                                        <div class="li-blog-meta">
                                                            <a class="author"><i class="fa fa-user"></i>Admin</a>
                                                            <a class="author"><i class="fa fa-star"></i>
                                                                @php
                                                                    $totalRating = $blog->comments->sum('rating'); // Tổng điểm
                                                                    $commentCount = $blog->comments->count(); // Số lượng bình luận
                                                                    $averageRating =
                                                                        $commentCount > 0
                                                                            ? $totalRating / $commentCount
                                                                            : 0;
                                                                    $averageRating = round($averageRating, 1); // Làm tròn điểm trung bình đến 1 chữ số sau dấu phẩy
                                                                @endphp
                                                                {{ $averageRating }}</td> Rating</a>
                                                            <a class="comment"
                                                                href="{{ route('show', $blog->slug) }}#comments">
                                                                <i class="fa fa-comment-o"></i>
                                                                {{ $blog->comments->count() }} comments
                                                            </a>
                                                            <a class="post-time" href="javascript:void(0);"
                                                                onclick="filterByDate('{{ $blog->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d-M-Y') }}')">
                                                                <i class="fa fa-calendar"></i>
                                                                {{ $blog->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d-M-Y') }}
                                                            </a>
                                                        </div>
                                                        <p>{!! Str::limit(strip_tags($blog->description), 300, '...') !!}</p>
                                                        <a class="read-more"
                                                            href="{{ route('show', $blog->slug) }}">Read More...</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Phân trang -->
                            <div class="col-lg-12">
                                <div class="li-paginatoin-area text-center pt-25">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <ul class="li-pagination-box">
                                                @if ($currentPage > 1)
                                                    <li><a
                                                            href="?page={{ $currentPage - 1 }}&date={{ $currentDate }}">Previous</a>
                                                    </li>
                                                @endif
                                                @for ($i = 1; $i <= $totalPages; $i++)
                                                    <li class="{{ $i == $currentPage ? 'active' : '' }}">
                                                        <a
                                                            href="?page={{ $i }}&date={{ $currentDate }}">{{ $i }}</a>
                                                    </li>
                                                @endfor
                                                @if ($currentPage < $totalPages)
                                                    <li><a
                                                            href="?page={{ $currentPage + 1 }}&date={{ $currentDate }}">Next</a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Kết thúc phân trang -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Li's Main Blog Page Area End Here -->
        <!-- Begin Footer Area -->
        @include('web.layouts.footer')
        <!-- Footer Area End Here -->
    </div>
    <!-- Body Wrapper End Here -->
    @include('web.layouts.css-script')
    <script>
        function filterByDate(date) {
            const currentUrl = new URL(window.location.href); // Lấy URL hiện tại
            currentUrl.searchParams.set('date', date); // Thêm tham số 'date' vào URL
            window.location.href = currentUrl.toString(); // Chuyển hướng đến URL mới
        }
    </script>
</body>

<!-- blog-list31:56-->

</html>
