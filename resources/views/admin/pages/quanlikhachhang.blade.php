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
                    <li class="breadcrumb-item active"><a><b>Danh sách khách hàng</b></a></li>
                </ul>
                <div id="clock"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <div class="tile-body">
                            <div class="row element-button">
                                <div class="col-sm-2">
                                    <a class="btn btn-add btn-sm" href="{{ route('khachhangmoi') }}" title="Thêm"><i
                                            class="fas fa-plus"></i>
                                        khách hàng mới</a>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-delete btn-sm nhap-tu-file" type="button" title="Nhập"
                                        onclick="myFunction(this)"><i class="fas fa-file-upload"></i> Tải từ file</a>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-delete btn-sm print-file" type="button" title="In"
                                        onclick="myApp.printTable()"><i class="fas fa-print"></i> In dữ liệu</a>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-delete btn-sm" type="button" title="Xóa"
                                        onclick="myFunction(this)"><i class="fas fa-trash-alt"></i> Xóa tất cả </a>
                                </div>
                            </div>
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                    <tr>
                                        <th width="10"><input type="checkbox" id="all"></th>
                                        <th>Mã khách hàng</th>
                                        <th>Tên khách hàng</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Địa chỉ</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Example customer row -->
                                    <tr>
                                        <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                        <td>KH001</td>
                                        <td>Nguyễn Văn A</td>
                                        <td>nguyenvana@example.com</td>
                                        <td>0123456789</td>
                                        <td>Hà Nội</td>
                                        <td>
                                            {{-- ------------------- --}}
                                            <button id="myBtn" class="btn btn-primary" type="button" title="ViewAll"
                                                ><i class="fas fa-eye"></i></button>
                                            <div id="myModal" class="modal">

                                                <!-- Modal content -->
                                                <div class="modal-content">
                                                    <span class="close">&times;</span>
                                                    <h2 id="modalTitle">Thông  khách hàng</h2>
                                                    <p><strong>Mã khách hàng:</strong> <span
                                                            id="customerID">KH12345</span></p>
                                                    <p><strong>Tên khách hàng:</strong> <span id="customerName">Nguyễn
                                                            Văn A</span></p>
                                                    <p><strong>Email:</strong> <span
                                                            id="customerEmail">nguyenvana@example.com</span></p>
                                                    <p><strong>Số điện thoại:</strong> <span
                                                            id="customerPhone">0123456789</span></p>
                                                    <p><strong>Địa chỉ:</strong> <span id="customerAddress">123 Phố ABC,
                                                            Hà Nội</span></p>
                                                    <p><strong>Ngày đăng ký:</strong> <span
                                                            id="registerDate">2023-10-21</span></p>
                                                    <p><strong>Mật khẩu:</strong> <span
                                                            id="customerPassword">********</span></p>
                                                </div>

                                            </div>
                                            <button class="btn btn-primary btn-sm edit" type="button" title="Sửa"
                                                id="show-emp" data-toggle="modal" data-target="#ModalUP"><i
                                                    class="fas fa-edit"></i></button>
                                            <button class="btn btn-primary btn-sm trash" type="button" title="Xóa"
                                                onclick="myFunction(this)"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                    <!-- Add more customer rows as needed -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!--
  MODAL
-->
        <div class="modal fade" id="ModalUP" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"
            data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group  col-md-12">
                                <span class="thong-tin-thanh-toan">
                                    <h5>Chỉnh sửa thông tin khách hàng</h5>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Mã khách hàng </label>
                                <input class="form-control" type="text" value="KH001">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Tên khách hàng</label>
                                <input class="form-control" type="text" required value="Nguyễn Văn A">
                            </div>
                            <div class="form-group  col-md-6">
                                <label class="control-label">Email</label>
                                <input class="form-control" type="email" required value="nguyenvana@example.com">
                            </div>
                            <div class="form-group col-md-6 ">
                                <label class="control-label">Số điện thoại</label>
                                <input class="form-control" type="text" required value="0123456789">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Địa chỉ</label>
                                <input class="form-control" type="text" value="Hà Nội">
                            </div>
                        </div>
                        <BR>
                        <button class="btn btn-save" type="button">Lưu lại</button>
                        <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
                        <BR>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
            @include('admin.layout.footer')
        </div>

</html>
