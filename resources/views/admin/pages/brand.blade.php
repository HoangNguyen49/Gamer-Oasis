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
                    <li class="breadcrumb-item active"><a href=""><b>Brand List</b></a></li>
                </ul>
                <div id="clock"></div>
            </div>
            @if (session('error'))
                <div class="alert alert-danger mt-2" style="background-color: #f7c3c2; color: red ; font-weight: bold">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success mt-2">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <div class="tile-body">
                            <div class="row element-button d-flex align-items-center justify-content-between">
                                <div class="col-sm-8 d-flex"> <!-- Chiếm 8 cột -->
                                    <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#addBrandModal"
                                        title="Thêm Brand">
                                        <i class="fas fa-plus"></i> Create New Brand
                                    </a>
                                </div>
                                <div class="col-sm-4 d-flex justify-content-end"> <!-- Chiếm 4 cột -->
                                    <form action="{{ route('brands.search') }}" method="GET" class="form-inline mb-3">
                                        <input style="height:32px;" type="text" name="keyword"
                                            class="form-control mr-2" placeholder="Search by brand name"
                                            value="{{ request('keyword') }}">
                                        <button type="submit" class="btn btn-primary"
                                            style="height:32px;">Search</button>
                                    </form>
                                </div>

                            </div>


                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Brand</th>
                                        <th>Function</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brands as $brand)
                                        <tr>
                                            <td>{{ $brand->Brand_id }}</td>
                                            <td>{{ $brand->Brand_name }}</td>
                                            <td>
                                                <form action="{{ route('brands.delete', $brand->Brand_id) }}"
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

        {{-- Modal for Create Brand --}}
<div class="modal fade" id="addBrandModal" tabindex="-1" role="dialog" aria-labelledby="addBrandModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addBrandModalLabel">Add New Brand</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- Thông báo lỗi (ẩn mặc định) -->
            <div id="error-message" class="alert alert-danger" style="display: none; background-color: #f7c3c2; color: red ; font-weight: bold">Brand name can not be blank</div>

            <form id="brandForm">
                @csrf
                <div class="form-group">
                    <label for="brand_name">Brand Name</label>
                    <input type="text" class="form-control" id="brand_name" name="Brand_name" required>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="saveBrandBtn">Save Brand</button>
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

    {{-- Script for Create Brand --}}
    <script>
        $(document).ready(function() {
            // Xử lý sự kiện khi bấm nút Save Brand
            $('#saveBrandBtn').click(function() {
                var formData = $('#brandForm').serialize(); // Lấy dữ liệu từ form
    
                $.ajax({
                    url: '{{ route('brands.store') }}', // Đường dẫn tới route store cho Brand
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#addBrandModal').modal('hide'); // Đóng modal sau khi lưu thành công
                            alert('Brand added successfully!');
                            location.reload(); // Tải lại trang để cập nhật danh sách nếu cần
                        } else {
                            // Hiển thị thông báo lỗi trong modal
                            $('#error-message').text(response.message).show();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                        $('#error-message').text('Brand name can not be blank.').show();
                    }
                });
            });
        });
    </script>
    
</body>

</html>
