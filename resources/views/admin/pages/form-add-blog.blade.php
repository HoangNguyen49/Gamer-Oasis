<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include necessary head elements -->
    @include('admin.layout.head')

    <!-- Include jQuery (chỉ nạp một lần) -->
    <script src="{{ asset('admin-asset/js/jquery-3.2.1.min.js') }}"></script>

    <!-- https://quilljs.com/ -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <style>
        .form-control-blog {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 15px;
            line-height: 1.5;
            color: black;
            background-clip: padding-box;
            height: 45px;
            border: 1px solid #dadada;
        }
    </style>
</head>

<body>
    <!-- Include Navbar -->
    @include('admin.layout.navbar')

    <div class="app-wrapper">
        <!-- Include Sidebar -->
        @include('admin.layout.sidebar')
        <main class="app-content">
            <div class="app-title">
                <ul class="app-breadcrumb breadcrumb">
                    <li class="breadcrumb-item">Blog</li>
                    <li class="breadcrumb-item"><a href="?reload">Add blog</a></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <div class="row element-button">
                            <div class="col-sm-2">
                                <a class="btn btn-add btn-sm" href="{{ route('index') }}"
                                    title="Quay lại danh sách bài viết"><i class="fas fa-arrow-left"></i> Quay lại</a>
                            </div>
                        </div>
                        <h3 class="tile-title">Add new blog</h3>
                        <div class="tile-body">
                            <form class="row" action="{{ route('post') }}" method="POST">
                                @csrf <!-- Thêm token CSRF để bảo vệ form -->
                                <div class="form-group col-md-12">
                                    <label class="control-label">Title</label>
                                    <input class="form-control-blog" type="text" name="title" required>
                                    @error('title')
                                        @if ($message === 'The title has already been taken.')
                                            <div class="text-danger">The title already exists, please choose a different
                                                title.</div>
                                        @else
                                            <div class="text-danger">The title cannot be empty.</div>
                                        @endif
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="control-label">Content</label>
                                    <div id="description" style="height: 300px;"></div>
                                    <input type="hidden" name="description" id="content" required>
                                </div>
                            </form>
                            <button class="btn btn-save" type="button" onclick="saveContent()">Save</button>
                            <a class="btn btn-cancel" href="?reload">Cancel</a>

                        </div>
                    </div>
                </div>
            </div>
        </main>

        @include('admin.layout.footer')
    </div>

    <script>
        // Khởi tạo Quill
        var quill = new Quill('#description', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'size': ['small', false, 'large', 'huge']
                    }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'image', 'video'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                ]
            }
        });

        // Thêm sự kiện cho nút video
        const toolbar = quill.getModule('toolbar');
        toolbar.addHandler('video', function() {
            const url = prompt('Enter YouTube video URL:');
            if (url) {
                const videoId = extractYouTubeID(url);
                if (videoId) {
                    const videoEmbed =
                        `<iframe width="560" height="315" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;
                    const range = quill.getSelection();
                    quill.clipboard.dangerouslyPasteHTML(range.index, videoEmbed);
                } else {
                    alert('Please enter a valid YouTube video URL.');
                }
            }
        });

        // Hàm để trích xuất ID video từ URL YouTube
        function extractYouTubeID(url) {
            const regex =
                /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^&\n]{11})/;
            const match = url.match(regex);
            return match ? match[1] : null;
        }

        // Hàm xử lý tạo blog
        function saveContent() {
            // Lấy nội dung từ Quill Editor
            var content = quill.root.innerHTML;
            document.getElementById('content').value = content; // Đặt giá trị vào input ẩn

            // Gửi dữ liệu bằng AJAX
            $.ajax({
                url: $('form').attr('action'), // Lấy URL từ thuộc tính action của form
                type: $('form').attr('method'), // Lấy method từ form (POST)
                data: $('form').serialize(), // Serialize toàn bộ dữ liệu form
                success: function(response) {
                    // Hiển thị thông báo thành công
                    alert('The blog has been added successfully!');
                    window.location.href = '{{ route('index') }}'; // Điều hướng về danh sách blog
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Lấy lỗi xác thực và hiển thị dưới dạng thông báo
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = 'Validation errors occurred:\n';
                        for (let field in errors) {
                            errorMessage += `- ${errors[field].join(', ')}\n`;
                        }
                        alert(errorMessage);
                    } else {
                        // Hiển thị lỗi không xác định
                        alert('An unexpected error occurred. Please try again.');
                    }
                }
            });
        }
    </script>

</body>

</html>
