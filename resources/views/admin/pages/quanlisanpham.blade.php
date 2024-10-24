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
                <li class="breadcrumb-item active"><a href="#"><b>Product List</b></a></li>
            </ul>
            <div id="clock"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="row element-button">
                            <div class="col-sm-2">            
                              <a class="btn btn-add btn-sm" href="{{ route('form-add-san-pham') }}" title="Thêm"><i class="fas fa-plus"></i>
                                Create New Product</a>
                            </div>
                            <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm nhap-tu-file" type="button" title="Nhập" onclick="myFunction(this)"><i
                                  class="fas fa-file-upload"></i> Tải từ file</a>
                            </div>
              
                            <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm print-file" type="button" title="In" onclick="myApp.printTable()"><i
                                  class="fas fa-print"></i> In dữ liệu</a>
                            </div>
                            <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm print-file js-textareacopybtn" type="button" title="Sao chép"><i
                                  class="fas fa-copy"></i> Sao chép</a>
                            </div>
              
                            <div class="col-sm-2">
                              <a class="btn btn-excel btn-sm" href="" title="In"><i class="fas fa-file-excel"></i> Xuất Excel</a>
                            </div>
                            <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm pdf-file" type="button" title="In" onclick="myFunction(this)"><i
                                  class="fas fa-file-pdf"></i> Xuất PDF</a>
                            </div>
                            <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm" type="button" title="Xóa" onclick="myFunction(this)"><i
                                  class="fas fa-trash-alt"></i> Delete Product </a>
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
                                @foreach($products as $product)
                                <tr>
                                    <td><input type="checkbox" name="product_ids[]" value="{{ $product->Product_id }}"></td>
                                    <td>{{ $product->Product_id }}</td>
                                    <td>{{ $product->category->Category_name }}</td>
                                    <td>{{ $product->brand->Brand_name }}</td>
                                    <td>{{ $product->Product_name }}</td>
                                    <td>
                                      @if($product->images->count() > 0)
                                          <img src="{{ asset('storage/' . $product->images->first()->Image_path) }}" alt="{{ $product->Product_name }}" width="50">
                                      @else
                                          No image
                                      @endif
                                  </td>
                                    <td>{{ $product->Stock_Quantity }}</td>
                                    <td class="badge bg-success">{{ $product->Stock_Quantity > 0 ? 'Available' : 'Unavailable' }}</td>
                                    <td>{{ number_format($product->Price, 2) }}</td>
                                    
                                    <td>
                                      <button id="myBtn" class="btn btn-primary" type="button" title="ViewAll">
                                          <i class="fas fa-eye"></i>
                                      </button>
                                      <button class="btn btn-primary btn-sm edit" type="button" title="Sửa" 
                                          data-toggle="modal" data-target="#ModalUP" 
                                          onclick="window.location.href='{{ route('edit-product', $product->Product_id) }}'">
                                          <i class="fas fa-edit"></i>
                                      </button>
                                      
                                      <form action="" method="POST" style="display:inline;">
                                          @csrf
                                          @method('DELETE')
                                          <button class="btn btn-primary btn-sm trash" type="button" title="Xóa"
                                              onclick="myFunction(this)">
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
@include('admin.layout.footer')
</div>
</html>

