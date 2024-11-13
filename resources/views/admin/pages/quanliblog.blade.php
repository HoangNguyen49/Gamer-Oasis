<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include necessary head elements -->
    @include('admin.layout.head')
</head>

<body>
    <!-- Include Navbar -->
    @include('admin.layout.navbar')

    <div class="app-wrapper">
        <!-- Include Sidebar -->
        @include('admin.layout.sidebar')

        <main class="app-content">

            <div class="row">
                <div class="col-md-12">
                    <div class="app-title">
                        <ul class="app-breadcrumb breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><b>Blog Management</b></a></li>
                        </ul>
                        <div id="clock"></div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-5">
                        <div class="widget-small primary coloured-icon">
                            <i class='icon bx bxs-book-content fa-3x'></i>
                            <div class="info">
                                <h4>Total Blogs</h4>
                                <p><b>{{ \App\Models\Blog::totalBlogs() }} Blog</b></p>
                                <p class="info-tong">Total number of articles published</p>
                            </div>
                        </div>
                        <div class="widget-small info coloured-icon">
                            <i class='icon bx bx-comment fa-3x'></i>
                            <div class="info">
                                <h4>Total Comments</h4>
                                <p><b>{{ \App\Models\BlogComment::totalComments() }} Comments</b></p>
                                <p class="info-tong">The total number of interactive comments</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bảng Top 5 bài viết có lượt đánh giá cao nhất -->
                    <div class="col-md-7">
                        <div class="tile">
                            <h3 class="tile-title">Top 5 highest-rated articles</h3>
                            <div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Rating</th>
                                            <th>Function</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topBlogs as $index => $blog)
                                            <tr class="blog-row" data-index="{{ $index }}">
                                                <td>{{ $blog->id }}</td>
                                                <td>{{ $blog->title }}</td>
                                                <td>{{ $blog->totalRatingScore() }}</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm edit" type="button"
                                                        title="Sửa"
                                                        onclick="window.location='{{ route('edit', $blog->id) }}'">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm trash" type="button"
                                                        title="Xóa" onclick="deleteBlog({{ $blog->id }})">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                    <button class="btn btn-info btn-sm view-comments" type="button"
                                                        title="Xem bình luận" style="padding: 4px 8px;"
                                                        onclick="window.location='{{ route('comments.view', $blog->id) }}'">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- Nút "Xem thêm" -->
                                <div class="text-center">
                                    <button id="showMoreBtn" class="btn btn-secondary btn-sm"
                                        onclick="toggleExtraBlogs()">...</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-title">
                <ul class="app-breadcrumb breadcrumb side">
                    <li class="breadcrumb-item active"><a href="#"><b>Blog</b></a></li>
                </ul>
                <div id="clock"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <div class="tile-body">
                            <div class="row element-button">
                                <div class="col-sm-2">
                                    <!-- Nút Tạo bài viết mới nằm bên trái -->
                                    <a class="btn btn-add btn-sm" href="{{ route('create') }}" title="Thêm bài viết">
                                        <i class="fas fa-plus"></i> Create New Blog
                                    </a>
                                </div>

                                <div class="col-sm-4 ml-auto d-flex justify-content-end">
                                    <!-- Form tìm kiếm nằm bên phải -->
                                    <form action="{{ route('index') }}" method="GET" class="form-inline mb-3">
                                        <input type="text" name="search" class="form-control mr-2"
                                            placeholder="Search for blog" value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-warning"> <i class="fas fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Comment</th>
                                        <th>Date</th>
                                        <th>Function</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($blogs as $blog)
                                        <tr>
                                            <td>{{ $blog->id }}</td>
                                            <td>{{ $blog->title }}</td>
                                            <td>{{ $blog->comments->count() }}</td>
                                            <td>{{ $blog->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d-m-Y H:i') }}
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-sm edit" type="button"
                                                    title="Sửa"
                                                    onclick="window.location='{{ route('edit', $blog->id) }}'">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm trash" type="button"
                                                    title="Xóa" onclick="deleteBlog({{ $blog->id }})">
                                                    <i class="fas fa-trash-alt"></i></button>
                                                <button class="btn btn-info btn-sm view-comments" type="button"
                                                    title="Xem bình luận" style="padding: 4px 8px;"
                                                    onclick="window.location='{{ route('comments.view', $blog->id) }}'">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $blogs->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        @include('admin.layout.footer')
    </div>
    <script>
        function deleteBlog(id) {
            if (confirm('Bạn có chắc chắn muốn xóa blog này không?')) {
                $.ajax({
                    url: '{{ url('/admin/quanliblog/destroy') }}/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Check if the response contains 'success'
                        if (response.success) {
                            // Remove the row and show success message
                            $('tr:has(td:contains("' + id + '"))').remove();
                            alert(response.success); // Display success message from server
                        } else {
                            alert('Có lỗi xảy ra: ' + (response.error || 'Không xác định'));
                        }
                    },
                    error: function(xhr) {
                        // Check if error response has JSON and 'error' message
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            alert('Có lỗi xảy ra: ' + xhr.responseJSON.error);
                        } else {
                            alert('Có lỗi xảy ra trong quá trình xóa. Vui lòng thử lại.');
                        }
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const blogRows = document.querySelectorAll('.blog-row');
            const showMoreBtn = document.getElementById('showMoreBtn');

            blogRows.forEach((row, index) => {
                if (index >= 1) {
                    row.style.display = 'none';
                }
            });

            function toggleExtraBlogs() {
                const isExpanded = blogRows[1].style.display === 'table-row';

                blogRows.forEach((row, index) => {
                    if (index >= 1) {
                        row.style.display = isExpanded ? 'none' : 'table-row';
                    }
                });
            }

            showMoreBtn.onclick = toggleExtraBlogs;
        });
    </script>
</body>

</html>
