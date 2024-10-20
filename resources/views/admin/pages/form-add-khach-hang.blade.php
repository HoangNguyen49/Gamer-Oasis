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
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item">Danh sách khách hàng</li>
        <li class="breadcrumb-item"><a href="#">Thêm khách hàng</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title">Tạo mới khách hàng</h3>
          <div class="tile-body">
            <form class="row">
              <div class="form-group col-md-3">
                <label class="control-label">Họ và tên</label>
                <input class="form-control" type="text" placeholder="">
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Email</label>
                <input class="form-control" type="email" placeholder="">
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Số điện thoại</label>
                <input class="form-control" type="text" placeholder="">
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Địa chỉ</label>
                <input class="form-control" type="text" placeholder="">
              </div>
              <div class="form-group col-md-12">
                <label class="control-label">Ghi chú</label>
                <textarea class="form-control" name="ghichu" id="ghichu"></textarea>
              </div>
          </div>
          <button class="btn btn-save" type="button">Lưu lại</button>
          <a class="btn btn-cancel" href="table-data-customer.html">Hủy bỏ</a>
        </div>
  </main>

@include('admin.layout.footer')
  </div>
 
</html>

