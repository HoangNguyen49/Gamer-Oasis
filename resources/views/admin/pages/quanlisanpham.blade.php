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
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
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
                                </div>
                                <div class="col-sm-4 d-flex justify-content-end"> <!-- Chiếm 4 cột -->
                                    <form action="{{ route('products.indexAdmin') }}" method="GET"
                                        class="form-inline mb-3">
                                        <input style="height:32px" type="text" name="search"
                                            class="form-control mr-2" placeholder="Search by product name"
                                            value="{{ $search ?? '' }}">
                                        <button type="submit" class="btn btn-primary"
                                            style="height:32px;">Search</button>
                                    </form>
                                </div>
                            </div>
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                    <tr>
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
                                                <form action="{{ route('products.deleteProduct', $product->Product_id) }}" method="POST">
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

                            <!-- Phân trang -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p>There are {{ $products->total() }} products currently
                                            </p>
                                            <!-- Hiển thị tổng số đơn hàng -->
                                        </div>
                                        <div>
                                            <nav>
                                                <ul class="pagination">
                                                    {{-- Nút đến trang đầu tiên --}}
                                                    @if ($products->currentPage() > 1)
                                                        <li><a href="{{ $products->url(1) }}">&laquo;</a></li>
                                                    @endif

                                                    {{-- Nút quay lại --}}
                                                    @if ($products->onFirstPage())
                                                        <li class="disabled"><span>&lt;</span></li>
                                                    @else
                                                        <li><a href="{{ $products->previousPageUrl() }}">&lt;</a>
                                                        </li>
                                                    @endif

                                                    {{-- Các nút phân trang --}}
                                                    @php
                                                        $currentPage = $products->currentPage();
                                                        $lastPage = $products->lastPage();
                                                        $startPage = max(1, $currentPage - 1); // Bắt đầu từ trang 1 hoặc một trang trước trang hiện tại
                                                        $endPage = min($lastPage, $startPage + 2); // Kết thúc ở trang cuối cùng hoặc trang 3 sau trang bắt đầu

                                                        // Điều chỉnh startPage nếu endPage là trang cuối
                                                        if ($endPage - $startPage < 2) {
                                                            $startPage = max(1, $endPage - 2); // Đảm bảo hiển thị đúng 3 trang nếu có đủ
                                                        }
                                                    @endphp

                                                    @for ($page = $startPage; $page <= $endPage; $page++)
                                                        @if ($page == $currentPage)
                                                            <li class="active"><span>{{ $page }}</span></li>
                                                        @else
                                                            <li><a
                                                                    href="{{ $products->url($page) }}">{{ $page }}</a>
                                                            </li>
                                                        @endif
                                                    @endfor

                                                    {{-- Nút tiếp theo --}}
                                                    @if ($products->hasMorePages())
                                                        <li><a href="{{ $products->nextPageUrl() }}">&gt;</a></li>
                                                    @else
                                                        <li class="disabled"><span>&gt;</span></li>
                                                    @endif

                                                    {{-- Nút đến trang cuối cùng --}}
                                                    @if ($products->currentPage() < $lastPage)
                                                        <li><a href="{{ $products->url($lastPage) }}">&raquo;</a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>

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

    <!-- Script handle  -->
    <script>
        $(document).ready(function() {
            $('.view-product').on('click', function() {
                var productId = $(this).data('id');
                $.ajax({
                    url: '/admin/admin/products/' +
                        productId, // Match this URL with the route definition
                    method: 'GET',
                    success: function(data) {
                        $('#productDetailsContent').html(data);
                        $('#productDetailModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error); // Log error details
                        alert('Error loading product details: ' + xhr.status + ' ' + xhr
                            .statusText);
                    }
                });
            });
        });
    </script>


</body>

</html>
