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
            <div class="app-title">
                <ul class="app-breadcrumb breadcrumb side">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}"><b>Blog</b></a></li>
                    <li class="breadcrumb-item active"><a href="#"><b>Comment on the Article:
                                {{ $blog->title }}</b></a></li>
                </ul>
                <div id="clock"></div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <div class="tile-body">
                            <div class="row element-button">
                                <div class="col-sm-2">
                                    <a class="btn btn-add btn-sm" href="{{ route('index') }}"
                                        title="Quay lại danh sách bài viết"><i class="fas fa-arrow-left"></i>Return</a>
                                </div>
                            </div>
                            <h3 class="tile-title">List of comments for the article: {{ $blog->title }}</h3>
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Rating</th>
                                        <th>Content</th>
                                        <th>Date</th>
                                        <th>Function</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @php
                                        $comments = $comments->sortByDesc('created_at');
                                    @endphp --}}
                                    @foreach ($comments as $comment)
                                        <tr>
                                            <td>{{ $comment->id }}</td>
                                            <td>{{ $comment->user_name }}</td>
                                            <td>{{ $comment->user_email }}</td>
                                            <td>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $comment->rating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </td>
                                            <td>{{ $comment->comment }}</td>
                                            <td>{{ $comment->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d-m-Y H:i') }}
                                            </td>
                                            <td>
                                                <button class="btn btn-danger btn-sm trash" type="button"
                                                    title="Xóa bình luận" onclick="deleteComment({{ $comment->id }})">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Hiển thị phản hồi nếu có -->
                                        @foreach ($comment->replies as $reply)
                                            <tr>
                                                <td></td> <!-- Có thể để trống hoặc hiện ID nếu cần -->
                                                <td><strong>{{ $reply->user_name }}</strong> (Reply)</td>
                                                <td>{{ $reply->user_email }}</td>
                                                <td>
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $reply->rating)
                                                            <i class="fas fa-star"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </td>
                                                <td>{{ $reply->comment }}</td>
                                                <td>{{ $reply->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d-m-Y H:i') }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm trash" type="button"
                                                        title="Xóa phản hồi"
                                                        onclick="deleteComment({{ $reply->id }})">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        @include('admin.layout.footer')
    </div>

    <script>
        function deleteComment(commentId) {
            // Hàm này sẽ sử dụng AJAX để xóa bình luận
            if (confirm("Bạn có chắc chắn muốn xóa bình luận này không?")) {
                // Thực hiện xóa bình luận qua AJAX
                fetch(`/admin/comments/${commentId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            // Tải lại trang để cập nhật danh sách bình luận
                            location.reload();
                        } else {
                            alert("Có lỗi xảy ra khi xóa bình luận.");
                        }
                    })
                    .catch(error => {
                        console.error('Có lỗi xảy ra:', error);
                    });
            }
        }
    </script>
</body>

</html>
