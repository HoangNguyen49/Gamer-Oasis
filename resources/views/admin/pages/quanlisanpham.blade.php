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
        @include('admin.layout.footer')
    </div>
    
    <!-- Script handle  -->
    <script>
        $(document).ready(function() {
            $('.view-product').on('click', function() {
                var productId = $(this).data('id');
                $.ajax({
                    url: '/admin/products/' + productId, // Match this URL with the route definition
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
