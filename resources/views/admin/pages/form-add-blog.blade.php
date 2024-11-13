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
                    <li class="breadcrumb-item">Danh sách blog</li>
                    <li class="breadcrumb-item"><a href="#">Thêm blog</a></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <div class="row element-button">
                            <div class="col-sm-2">
                                <a class="btn btn-add btn-sm" href="{{ route('index') }}" title="Quay lại danh sách bài viết"><i class="fas fa-arrow-left"></i> Quay lại</a>
                            </div>
                        </div>
                        <h3 class="tile-title">Tạo mới blog</h3>
                        <div class="tile-body">
                            <form class="row" action="{{ route('post') }}" method="POST">
                                @csrf <!-- Thêm token CSRF để bảo vệ form -->
                                <div class="form-group col-md-12">
                                    <label class="control-label">Tiêu đề</label>
                                    <input class="form-control-blog" type="text" name="title" required>
                                    @error('title')
                                        @if ($message === 'The title has already been taken.')
                                            <div class="text-danger">Tiêu đề đã tồn tại, vui lòng chọn tiêu đề khác</div>
                                        @else
                                            <div class="text-danger">Tiêu đề không được để trống</div>
                                        @endif
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="control-label">Nội dung</label>
                                    <div id="description" style="height: 300px;"></div>
                                    <input type="hidden" name="description" id="content" required>
                                </div>
                            </form>
                            <button class="btn btn-save" type="button" onclick="saveContent()">Lưu lại</button>
                            <a class="btn btn-cancel" href="/admin/quanliblog/taobai">Hủy bỏ</a>

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
                    [{'size': ['small', false, 'large', 'huge']}],
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
            const url = prompt('Nhập URL video YouTube');
            if (url) {
                const videoId = extractYouTubeID(url);
                if (videoId) {
                    const videoEmbed =
                        `<iframe width="560" height="315" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;
                    const range = quill.getSelection();
                    quill.clipboard.dangerouslyPasteHTML(range.index, videoEmbed);
                } else {
                    alert('Vui lòng nhập một URL video YouTube hợp lệ.');
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
            var content = quill.root.innerHTML;
            document.getElementById('content').value = content;
            document.querySelector('form').submit();
        }
    </script>

</body>

</html>
