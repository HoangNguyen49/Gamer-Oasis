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
                    <li class="breadcrumb-item active"><a href=""><b>Category List</b></a></li>
                </ul>
                <div id="clock"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <div class="tile-body">
                            <div class="row element-button d-flex align-items-center justify-content-between">
                                <div class="col-sm-8 d-flex"> <!-- Chiếm 8 cột -->
                                    <a class="btn btn-add btn-sm mr-2" data-toggle="modal"
                                        data-target="#addCategoryModal" title="Thêm Category">
                                        <i class="fas fa-plus"></i> Create New Category
                                    </a>
                                </div>
                                <div class="col-sm-4 d-flex justify-content-end"> <!-- Chiếm 4 cột -->
                                    <form action="{{ route('categories.search') }}" method="GET"
                                        class="form-inline mb-3">
                                        <input style="height:32px;" type="text" name="keyword"
                                            class="form-control mr-2" placeholder="Search by category name"
                                            value="{{ request('keyword') }}">
                                        <button type="submit" class="btn btn-primary"
                                            style="height:32px;">Search</button>
                                    </form>

                                    @if (session('error'))
                                        <div class="alert alert-danger mt-2">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                </div>

                            </div>


                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category</th>
                                        <th>Function</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $category->Category_id }}</td>
                                            <td>{{ $category->Category_name }}</td>
                                            <td>
                                                {{-- <button class="btn btn-primary btn-sm edit" type="button"
                                                    title="Sửa" data-toggle="modal" data-target="#ModalUP"
                                                    onclick="window.location.href='{{ route('edit-product', $product->Product_id) }}'">
                                                    <i class="fas fa-edit"></i>
                                                </button> --}}
                                                <form action="{{ route('categories.delete', $category->Category_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm trash" type="submit"
                                                        onclick="return confirm('Are you sure you want to delete this category?');">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </main>

        {{-- Modal for Create Category --}}
        <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog"
            aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="categoryForm">
                            @csrf
                            <div class="form-group">
                                <label for="category_name">Category Name</label>
                                <input type="text" class="form-control" id="category_name" name="Category_name"
                                    required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="saveCategoryBtn">Save Category</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.layout.footer')
    </div>

    <script>
        // Hàm cập nhật đồng hồ
        function updateClock() {
            const now = new Date();
            const time = now.toLocaleTimeString();
            document.getElementById('clock').innerHTML = time;
        }

        // Gọi hàm updateClock khi trang tải
        window.onload = function() {
            updateClock();
            setInterval(updateClock, 1000);
        };
    </script>

    {{-- Script for Create Category --}}
    <script>
        $(document).ready(function() {
            // Xử lý sự kiện khi bấm nút Save Category
            $('#saveCategoryBtn').click(function() {
                var formData = $('#categoryForm').serialize(); // Lấy dữ liệu từ form

                $.ajax({
                    url: '{{ route('categories.store') }}', // Đường dẫn tới route store
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#addCategoryModal').modal(
                                'hide'); // Đóng modal sau khi lưu thành công
                            alert('Category added successfully!');
                            location.reload(); // Tải lại trang để cập nhật danh sách nếu cần
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        alert('An error occurred while adding the category.');
                    }
                });
            });
        });
    </script>

<script>
    $(document).ready(function() {
    $('#saveCategoryBtn').click(function() {
        var formData = $('#categoryForm').serialize();

        $.ajax({
            url: '{{ route('categories.store') }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#addCategoryModal').modal('hide'); 
                    alert('Category added successfully!');
                    location.reload(); 
                } else if (response.error) {
                    alert('Category name already exists. Please enter a different name.');
                }
            },
        });
    });
});

</script>


</body>

</html>
