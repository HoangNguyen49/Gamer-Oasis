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
                    <li class="breadcrumb-item active"><a href=""><b>Product List</b></a></li>
                </ul>
                <div id="clock"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <div class="tile-body">
                            <div class="row element-button d-flex align-items-center justify-content-between">
                                <div class="col-sm-8 d-flex"> <!-- Chiếm 8 cột -->
                                    <a class="btn btn-add btn-sm mr-2" href="{{ route('form-add-san-pham') }}"
                                        title="Thêm">
                                        <i class="fas fa-plus"></i> Create New Product
                                    </a>
                                    <a class="btn btn-add btn-sm mr-2" data-toggle="modal"
                                        data-target="#addCategoryModal" title="Thêm Category">
                                        <i class="fas fa-plus"></i> Create New Category
                                    </a>
                                    <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#addBrandModal"
                                        title="Thêm Brand">
                                        <i class="fas fa-plus"></i> Create New Brand
                                    </a>
                                </div>
                                <div class="col-sm-4 d-flex justify-content-end"> <!-- Chiếm 4 cột -->
                                    <form action="{{ route('products.indexAdmin') }}" method="GET"
                                        class="form-inline mb-3">
                                        <input type="text" name="search" class="form-control mr-2"
                                            placeholder="Search by product name" value="{{ $search ?? '' }}">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </form>
                                </div>
                            </div>


                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                    <tr>
                                        <th width="10"><input type="checkbox" id="all"></th>
                                        <th>ID</th>
                                        <th>Category</th>
                                        <th>Brand</th>
                                        <th>Product Name</th>
                                        <th>Image</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Price $</th>
                                        <th>Function</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td><input type="checkbox" name="product_ids[]"
                                                    value="{{ $product->Product_id }}"></td>
                                            <td>{{ $product->Product_id }}</td>
                                            <td>{{ $product->category->Category_name }}</td>
                                            <td>{{ $product->brand->Brand_name }}</td>
                                            <td>{{ $product->Product_name }}</td>
                                            <td>
                                                @if ($product->images->count() > 0)
                                                    <img src="{{ asset('storage/' . $product->images->first()->Image_path) }}"
                                                        alt="{{ $product->Product_name }}" width="50">
                                                @else
                                                    No image
                                                @endif
                                            </td>
                                            <td>{{ $product->Stock_Quantity }}</td>
                                            <td class="badge bg-success">
                                                {{ $product->Stock_Quantity > 0 ? 'Available' : 'Unavailable' }}</td>
                                            <td>{{ number_format($product->Price, 2) }}</td>

                                            <td>
                                                <button class="btn btn-sm btn-primary view-product"
                                                    data-id="{{ $product->Product_id }}" title="View All">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-primary btn-sm edit" type="button"
                                                    title="Sửa" data-toggle="modal" data-target="#ModalUP"
                                                    onclick="window.location.href='{{ route('edit-product', $product->Product_id) }}'">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <form
                                                    action="{{ route('products.deleteProduct', $product->Product_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-primary btn-sm trash" type="submit"
                                                        onclick="return confirm('Are you sure you want to delete this product?');">
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

        <!-- Modal Product Details -->
        <div class="modal fade" id="productDetailModal" tabindex="-1" role="dialog"
            aria-labelledby="productDetailModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productDetailModalLabel">Product Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="productDetailsContent">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

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

        {{-- Modal for Create Brand --}}
        <div class="modal fade" id="addBrandModal" tabindex="-1" role="dialog"
            aria-labelledby="addBrandModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBrandModalLabel">Add New Brand</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="brandForm">
                            @csrf
                            <div class="form-group">
                                <label for="brand_name">Brand Name</label>
                                <input type="text" class="form-control" id="brand_name" name="Brand_name"
                                    required>
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

    <!-- Script handle  -->
    <script>
        $(document).ready(function() {
            $('.view-product').on('click', function() {
                var productId = $(this).data('id');

                $.ajax({
                    url: '/admin/products/' +
                        productId, // Đường dẫn tới route hiển thị chi tiết sản phẩm
                    method: 'GET',
                    success: function(data) {
                        // Thay thế nội dung trong modal với thông tin sản phẩm
                        $('#productDetailsContent').html(data);
                        $('#productDetailModal').modal('show'); // Hiển thị modal
                    },
                    error: function() {
                        alert('Error loading product details.');
                    }
                });
            });
        });
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
                            $('#addBrandModal').modal(
                            'hide'); // Đóng modal sau khi lưu thành công
                            alert('Brand added successfully!');
                            location.reload(); // Tải lại trang để cập nhật danh sách nếu cần
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        alert('An error occurred while adding the brand.');
                    }
                });
            });
        });
    </script>
</html>
