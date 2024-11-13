<!doctype html>
<html class="no-js" lang="zxx">

<!-- blog-list31:56-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Blog List</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
                        <li><a href="index.html">Home</a></li>
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
                            $currentPage = request()->get('page', 1);
                            $perPage = 10;
                            $sortedBlogs = $blogs->sortByDesc('created_at');
                            $blogsPaginated = $sortedBlogs->slice(($currentPage - 1) * $perPage, $perPage);
                            $totalPages = ceil($blogs->count() / $perPage);
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
                                                            <img class="img-full" src="{{ asset($firstImage->img) }}" alt="Ảnh đầu tiên hiển thị">
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
                                                            <a href="{{ route('show', $blog->slug) }}">{{ $blog->title }}</a>
                                                        </h3>
                                                        <div class="li-blog-meta">
                                                            <a class="author" href="#"><i class="fa fa-user"></i>Admin</a>
                                                            <a class="comment" href="#"><i class="fa fa-comment-o"></i> {{ $blog->comments->count() }} comments</a>
                                                            <a class="post-time" href="#"><i class="fa fa-calendar"></i> {{ $blog->created_at->format('d M Y') }}</a>
                                                        </div>
                                                        <p>{!! Str::limit(strip_tags($blog->description), 300, '...') !!}</p>
                                                        <a class="read-more" href="{{ route('show', $blog->slug) }}">Read More...</a>
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
                                                    <li><a href="?page={{ $currentPage - 1 }}">Previous</a></li>
                                                @endif
                                                @for ($i = 1; $i <= $totalPages; $i++)
                                                    <li class="{{ $i == $currentPage ? 'active' : '' }}">
                                                        <a href="?page={{ $i }}">{{ $i }}</a>
                                                    </li>
                                                @endfor
                                                @if ($currentPage < $totalPages)
                                                    <li><a href="?page={{ $currentPage + 1 }}">Next</a></li>
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
</body>

<!-- blog-list31:56-->

</html>
