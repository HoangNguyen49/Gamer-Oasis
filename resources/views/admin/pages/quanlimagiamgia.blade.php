<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layout.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @include('admin.layout.navbar')

    <div class="app-wrapper">
        @include('admin.layout.sidebar')
        <main class="app-content">
            <div class="app-title">
                <ul class="app-breadcrumb breadcrumb side">
                    <li class="breadcrumb-item active"><a href="{{ route('quanlimagiamgia') }}"><b>Coupon List</b></a>
                    </li>
                </ul>
                <div id="clock"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <div class="tile-body">
                            <div class="row element-button">
                                <div class="col-sm-2">
                                    <a class="btn btn-add btn-sm" href="{{ route('coupons.create') }}" title="Create"><i
                                            class="fas fa-plus"></i> Create New Coupon</a>
                                </div>
                                <div class="col-sm-4 d-flex justify-content-end"> <!-- Chiếm 4 cột -->
                                    <form action="{{ route('coupons.index') }}" method="GET" class="form-inline mb-3">
                                        <input style="height:32px" type="text" name="search"
                                            class="form-control mr-2" placeholder="Search by coupon code"
                                            value="{{ $search ?? '' }}">
                                        <button type="submit" class="btn btn-primary"
                                            style="height:32px;">Search</button>
                                    </form>
                                </div>
                            </div>
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                    <tr>
                                        <th width="10"><input type="checkbox" id="all"></th>
                                        <th>ID</th>
                                        <th>Coupon Code</th>
                                        <th>Discount Type</th>
                                        <th>Discount Value</th>
                                        <th>Expiration Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($coupons->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center"
                                                style="color: red; font-weight: bold; font-size: 16px;">NO COUPON FOUND
                                                !!!</td>
                                        </tr>
                                    @else
                                        @foreach ($coupons as $coupon)
                                            <tr data-id="coupon-{{ $coupon->coupon_id }}">
                                                <td><input type="checkbox" name="check{{ $coupon->coupon_id }}"
                                                        value="{{ $coupon->coupon_id }}"></td>
                                                <td>{{ $coupon->coupon_id }}</td>
                                                <td>{{ $coupon->code }}</td>
                                                <td>{{ ucfirst($coupon->discount_type) }}</td>
                                                <td>{{ number_format($coupon->discount_value, 2) }}</td>
                                                <td>{{ $coupon->expiration_date }}</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm edit" type="button"
                                                        title="Edit"
                                                        onclick="window.location='{{ route('coupons.edit', $coupon->coupon_id) }}'">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-primary btn-sm trash" type="button"
                                                        title="Delete"
                                                        onclick="deleteCoupon({{ $coupon->coupon_id }})">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        @include('admin.layout.footer')

    </div>

    <!-- Notification HTML -->
    <div id="notification"
        style="display: none; position: fixed; top: 70px; right: 20px; z-index: 1000; background-color: #4CAF50; color: white; padding: 15px; border-radius: 5px;">
        <span id="notification-icon" style="margin-right: 10px;">
            <i class="fa fa-check-circle" style="border: 2px solid white; border-radius: 50%; padding: 5px;"></i>
        </span>
        <span id="notification-message"></span>
    </div>

    <!-- Overlay -->
    <div id="overlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000;">
    </div>

    <!-- Custom Confirm Dialog -->
    <div id="confirmDialog"
        style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2000; background-color: white; border: 1px solid #ccc; border-radius: 5px; padding: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <h5 style="margin-bottom: 15px;">Are you sure you want to delete this coupon?</h5>
        <div style="display: flex; justify-content: space-evenly;">
            <button id="confirmYes" class="btn btn-danger" style="width: 80px;">Yes</button>
            <button id="confirmNo" class="btn btn-secondary" style="width: 80px;">No</button>
        </div>
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

    <script>
        function deleteCoupon(couponId) {
            const confirmDialog = document.getElementById("confirmDialog");
            const overlay = document.getElementById("overlay");

            // Hiển thị overlay và hộp thoại xác nhận
            overlay.style.display = "block";
            confirmDialog.style.display = "block";

            // Xử lý sự kiện khi nhấn "Yes"
            document.getElementById("confirmYes").onclick = function() {
                fetch(`/admin/coupons/${couponId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Network response was not ok: ${response.statusText}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Hiển thị thông báo thành công
                        const notification = document.getElementById("notification");
                        const notificationIcon = document.getElementById("notification-icon");
                        const notificationMessage = document.getElementById("notification-message");

                        notificationIcon.innerHTML =
                            '<i class="fa fa-check-circle" style="border: 2px solid white; border-radius: 50%;"></i>';
                        notificationMessage.innerText = 'Coupon deleted successfully!'; // Corrected typo
                        notification.style.display = "flex"; // Hiển thị thông báo

                        setTimeout(() => {
                            notification.style.display = "none"; // Ẩn thông báo sau 3 giây
                        }, 2000);

                        // Xóa dòng đơn hàng khỏi bảng
                        const row = document.querySelector(`tr[data-id="coupon-${couponId}"]`);
                        if (row) {
                            row.remove();
                        }
                    })
                    .catch(error => {
                        console.error('There was a problem with the delete operation:', error);
                    })
                    .finally(() => {
                        // Ẩn overlay và hộp thoại xác nhận
                        overlay.style.display = "none";
                        confirmDialog.style.display = "none";
                    });
            };

            // Xử lý sự kiện khi nhấn "No"
            document.getElementById("confirmNo").onclick = function() {
                // Ẩn overlay và hộp thoại xác nhận
                overlay.style.display = "none";
                confirmDialog.style.display = "none";
            };
        }
    </script>

</body>

</html>
