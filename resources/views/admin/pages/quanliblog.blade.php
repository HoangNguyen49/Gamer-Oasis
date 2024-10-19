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
                    <li class="breadcrumb-item active"><a href="#"><b>Blog</b></a></li>
                </ul>
                <div id="clock"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <div class="tile-body">
                            <div class="row element-button">
                                <div class="col-sm-2">
                                    <a class="btn btn-add btn-sm" href="{{ route('taobai') }}" title="Thêm bài viết"><i class="fas fa-plus"></i>
                                        Tạo mới bài viết</a>
                                </div>
                            </div>
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                    <tr>
                                        <th width="10"><input type="checkbox" id="all"></th>
                                        <th>Tiêu đề</th>
                                        <th>Tác giả</th>
                                        <th>Ngày đăng</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                        <td>Bài viết 1</td>
                                        <td>Nguyễn Văn A</td>
                                        <td>01/01/2023</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm edit" type="button" title="Sửa" data-toggle="modal" data-target="#ModalUP"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-danger btn-sm trash" type="button" title="Xóa" onclick="myFunction(this)"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                    <!-- Thêm các bài viết khác ở đây -->
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
        <div class="modal fade" id="ModalUP" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <span class="thong-tin-thanh-toan">
                                    <h5>Chỉnh sửa thông tin bài viết</h5>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label">Tiêu đề</label>
                                <input class="form-control" type="text" required value="Bài viết 1">
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label">Nội dung</label>
                                <textarea class="form-control" rows="5" required>Bài viết nội dung...</textarea>
                            </div>
                        </div>
                        <button class="btn btn-save" type="button">Lưu lại</button>
                        <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        
        @include('admin.layout.footer')
    </div>
</body>
</html>