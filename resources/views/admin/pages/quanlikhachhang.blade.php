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
                                    <!-- Loop through users to display each customer's information -->
                                    @foreach ($users as $user)
                                        <!-- Start of the loop -->
                                        <tr
                                            onclick="showCustomerDetails({{ $user->User_id }}, '{{ $user->Name }}', '{{ $user->Email }}', '{{ $user->Phone }}', '{{ $user->Address }}', '{{ $user->created_at }}')">
                                            <!-- Thêm sự kiện click vào hàng -->
                                            <td width="10"><input type="checkbox" name="check1"
                                                    value="{{ $user->User_id }}"></td> <!-- Checkbox for selection -->
                                            <td>{{ $user->User_id }}</td> <!-- Display customer code -->
                                            <td>{{ $user->Name }}</td> <!-- Display customer name -->
                                            <td>{{ $user->Email }}</td> <!-- Display email -->
                                            <td>{{ $user->Phone }}</td> <!-- Display phone number -->
                                            <td>{{ $user->Address }}</td> <!-- Display address -->
                                            <td>
                                                {{-- Button to view customer details --}}
                                                <button class="btn btn-primary" type="button" title="ViewAll"
                                                    onclick="showCustomerDetails({{ $user->User_id }}, '{{ $user->Name }}', '{{ $user->Email }}', '{{ $user->Phone }}', '{{ $user->Address }}', '{{ $user->created_at }}')"><i
                                                        class="fas fa-eye"></i></button>
                                                <div id="myModal" class="modal">
                                                    <!-- Modal content -->
                                                    <div class="modal-content">
                                                        <span class="close">&times;</span>
                                                        <h2 id="modalTitle">Thông tin khách hàng</h2>
                                                        <p><strong>Mã khách hàng:</strong> <span
                                                                id="customerID">{{ $user->User_id }}</span></p>
                                                        <p><strong>Tên khách hàng:</strong> <span
                                                                id="customerName">{{ $user->Name }}</span></p>
                                                        <p><strong>Email:</strong> <span
                                                                id="customerEmail">{{ $user->Email }}</span></p>
                                                        <p><strong>Số điện thoại:</strong> <span
                                                                id="customerPhone">{{ $user->Phone }}</span></p>
                                                        <p><strong>Địa chỉ:</strong> <span
                                                                id="customerAddress">{{ $user->Address }}</span></p>
                                                        <p><strong>Ngày đăng ký:</strong> <span
                                                                id="registerDate">{{ $user->created_at }}</span></p>
                                                        <p><strong>Mật khẩu:</strong> <span
                                                                id="customerPassword">********</span></p>
                                                    </div>
                                                </div>
                                                
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

    </div>
    </div>
    @include('admin.layout.footer')
    </div>

</html>
