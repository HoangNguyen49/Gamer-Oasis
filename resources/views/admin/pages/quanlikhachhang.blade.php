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
                    <li class="breadcrumb-item active"><a><b>Customer List</b></a></li>
                </ul>

                <div id="clock"></div>
                <!-- Thêm ô tìm kiếm -->
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Search for customers..."
                        onkeyup="searchFunction()" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <div class="tile-body">

                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                    <tr>
                                        <th width="10"><input type="checkbox" id="all"></th>
                                        <th>Customer_Id</th>
                                        <th>Customer_Name</th>
                                        <th>Email</th>
                                        <th>Function</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($users as $user)
                                        @if ($user->Role == 'customer')
                                            <tr
                                                onclick="showCustomerDetails({{ $user->User_id }}, '{{ $user->Name }}', '{{ $user->Email }}', '{{ $user->Phone }}', '{{ $user->Address }}', '{{ $user->created_at }}')">
                                                <!-- Thêm sự kiện click vào hàng -->
                                                <td width="10"><input type="checkbox" name="check1"
                                                        value="{{ $user->User_id }}"></td>
                                                <td>{{ $user->User_id }}</td>
                                                <td>{{ $user->Name }}</td>
                                                <td>{{ $user->Email }}</td>
                                                <td>

                                                    <div class="text-center">
                                                        <button class="btn btn-primary btn-sm" type="button"
                                                            title="Detail" data-toggle="modal"
                                                            data-target="#customerModal{{ $user->User_id }}"><i
                                                                class="fas fa-eye"></i></button>
                                                        @if ($user->is_blocked)
                                                            <!-- Kiểm tra trạng thái bị chặn -->
                                                            <!-- Nút Unblock nếu tài khoản bị chặn -->
                                                            <button class="btn btn-success btn-sm" type="button"
                                                                title="Unblock"
                                                                onclick="toggleBlockUnblock({{ $user->User_id }}, false)"><i
                                                                    class="fas fa-user-check"></i> Unblock</button>
                                                        @else
                                                            <!-- Nút Block nếu tài khoản không bị chặn -->
                                                            <button class="btn btn-danger btn-sm" type="button"
                                                                title="Block"
                                                                onclick="toggleBlockUnblock({{ $user->User_id }}, true)"><i
                                                                    class="fas fa-user-slash"></i> Block</button>
                                                        @endif
                                                    </div>
                                                    <div class="modal fade" id="customerModal{{ $user->User_id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="customerModalLabel{{ $user->User_id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title"
                                                                        id="customerModalLabel{{ $user->User_id }}"
                                                                        style="font-weight: bold; color: #4CAF50;">
                                                                        Customer Details</h4>

                                                                </div>
                                                                <div class="modal-body"
                                                                    style="padding: 20px; background-color: #f9f9f9; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group mb-4">
                                                                                <label for="name"
                                                                                    class="font-bold text-dark"
                                                                                    style="font-size: 18px; margin-bottom: 10px;"><strong>Name:</strong></label>
                                                                                <p id="name" class="text-gray-800"
                                                                                    style="font-size: 16px; color: #333; margin-bottom: 20px;">
                                                                                    {{ $user->Name }}</p>
                                                                            </div>
                                                                            <div class="form-group mb-4">
                                                                                <label for="email"
                                                                                    class="font-bold text-dark"
                                                                                    style="font-size: 18px; margin-bottom: 10px;"><strong>Email:</strong></label>
                                                                                <p id="email" class="text-gray-800"
                                                                                    style="font-size: 16px; color: #333; margin-bottom: 20px;">
                                                                                    {{ $user->Email }}</p>
                                                                            </div>
                                                                            <div class="form-group mb-4">
                                                                                <label for="phone"
                                                                                    class="font-bold text-dark"
                                                                                    style="font-size: 18px; margin-bottom: 10px;"><strong>Phone:</strong></label>
                                                                                <p id="phone" class="text-gray-800"
                                                                                    style="font-size: 16px; color: #333; margin-bottom: 20px;">
                                                                                    {{ $user->Phone }}</p>
                                                                            </div>
                                                                            <div class="form-group mb-4">
                                                                                <label for="address"
                                                                                    class="font-bold text-dark"
                                                                                    style="font-size: 18px; margin-bottom: 10px;"><strong>Address:</strong></label>
                                                                                <p id="address" class="text-gray-800"
                                                                                    style="font-size: 16px; color: #333; margin-bottom: 20px;">
                                                                                    {{ $user->Address }}</p>
                                                                            </div>
                                                                            <div class="form-group mb-4">
                                                                                <label for="registeredOn"
                                                                                    class="font-bold text-dark"
                                                                                    style="font-size: 18px; margin-bottom: 10px;"><strong>Registered
                                                                                        On:</strong></label>
                                                                                <p id="registeredOn"
                                                                                    class="text-gray-800"
                                                                                    style="font-size: 16px; color: #333; margin-bottom: 20px;">
                                                                                    {{ $user->created_at }}</p>
                                                                            </div>
                                                                            <div class="form-group mb-4">
                                                                                <label for="role"
                                                                                    class="font-bold text-dark"
                                                                                    style="font-size: 18px; margin-bottom: 10px;"><strong>Role:</strong></label>
                                                                                <p id="role"
                                                                                    class="text-gray-800"
                                                                                    style="font-size: 16px; color: #333; margin-bottom: 20px;">
                                                                                    {{ $user->Role }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer"
                                                                    style="background-color: #f9f9f9; border-top: 1px solid #ddd; padding: 10px; text-align: right;">
                                                                    <button type="button" class="btn btn-primary"
                                                                        data-dismiss="modal"
                                                                        style="padding: 10px 20px; font-size: 16px; border-radius: 5px;">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
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
    <style>
        .search-container {
            margin-bottom: 20px;
            /* Khoảng cách dưới ô tìm kiếm */
        }

        .form-control {
            width: 100%;
            /* Chiều rộng 100% */
            padding: 10px;
            /* Padding cho ô tìm kiếm */
            border-radius: 5px;
            /* Bo góc cho ô tìm kiếm */
            border: 1px solid #ccc;
            /* Đường viền cho ô tìm kiếm */
        }
    </style>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function searchFunction() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toLowerCase();
            table = document.getElementById("sampleTable");
            tr = table.getElementsByTagName("tr");

            // Lặp qua tất cả các hàng trong bảng và ẩn/hiện chúng dựa trên từ khóa tìm kiếm
            for (i = 1; i < tr.length; i++) { // Bắt đầu từ 1 để bỏ qua hàng tiêu đề
                tr[i].style.display = "none"; // Ẩn hàng
                td = tr[i].getElementsByTagName("td");
                for (j = 1; j < td.length; j++) { // Bắt đầu từ 1 để bỏ qua ô checkbox
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = ""; // Hiện hàng nếu tìm thấy
                            break; // Không cần kiểm tra thêm các ô khác
                        }
                    }
                }
            }
        }

        function toggleBlockUnblock(userId, block) {
            $.ajax({
                url: block ? '/block' : '/unblock', // Đường dẫn đến API chặn hoặc không chặn tài khoản
                method: 'POST',
                data: {
                    user_id: userId
                },
                success: function(response) {
                    alert(`User with ID: ${userId} has been ${block ? 'blocked' : 'unblocked'}.`);
                    // Cập nhật trạng thái chặn/không chặn ngay lập tức
                    if (block) {
                        $(`#blockButton${userId}`).text('Unblock').removeClass('btn-danger').addClass(
                            'btn-success');
                    } else {
                        $(`#blockButton${userId}`).text('Block').removeClass('btn-success').addClass(
                            'btn-danger');
                    }
                    // Tải lại trang sau 0,5 giây
                    setTimeout(function() {
                        location.reload(); // Tải lại trang
                    }, 500); // 500ms = 0,5 giây
                },
                error: function(xhr, status, error) {
                    console.error(`Error ${block ? 'blocking' : 'unblocking'} user:`, xhr.responseText);
                    alert(`${block ? 'Block' : 'Unblock'} failed. Please try again.`);

                }
            });
        }
    </script>

</html>
