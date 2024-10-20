<!DOCTYPE html>
<html lang="en">
<head>
  @include('admin.layout.head')
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('admin-asset/css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css') }}">
  <!-- or -->
  <link rel="stylesheet" href="{{ asset('https://unpkg.com/boxicons@latest/css/boxicons.min.css') }}">

  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css"
    href="{{ asset('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css') }}">
  <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('https://use.fontawesome.com/releases/v5.8.2/css/all.css') }}">
  <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css') }}">

</head>

<body onload="time()" class="app sidebar-mini rtl">
  <!-- Navbar-->
  @include('admin.layout.navbar')
  <!-- Sidebar menu-->
  @include('admin.layout.sidebar')
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  <main class="app-content">
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title">Thông tin đơn hàng</h3>
          <div class="tile-body">
            <form method="POST" action="{{ route('form-add-don-hang') }}">
              @csrf
              <!-- Display validation errors -->
              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <div class="form-group">
                <label for="customer_name">Tên khách hàng</label>
                <input class="form-control" type="text" id="customer_name" name="customer_name" required>
              </div>
              <div class="form-group">
                <label for="total_amount">Tổng tiền</label>
                <input class="form-control" type="text" id="total_amount" name="total_amount" required>
              </div>
              <div class="form-group">
                <label for="status">Trạng thái</label>
                <select class="form-control" id="status" name="status">
                  <option value="pending">Chờ xử lý</option>
                  <option value="shipping">Đang vận chuyển</option>
                  <option value="completed">Đã hoàn thành</option>
                  <option value="canceled">Đã hủy</option>
                </select>
              </div>
              <button class="btn btn-primary" type="submit">Thêm đơn hàng</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- Essential javascripts for application to work-->
 
  <!-- The javascript plugin to display page loading on top-->
  <script src="{{asset('admin-assets/js/plugins/pace.min.js')}}"></script>
  </body>
</html>
