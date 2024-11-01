<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Coupon</title>
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
                    <li class="breadcrumb-item"><a href="{{ route('quanlimagiamgia') }}">Coupon Management</a></li>
                    <li class="breadcrumb-item">Create Coupon</li>
                </ul>
                <div id="clock"></div>
            </div>
            <form id="createCouponForm">
                <div class="row">
                    <div class="col-md-12">
                        <div class="tile">
                            <h3 class="tile-title">CREATE COUPON</h3>
                            <div class="tile-body" style="display:flex;flex-wrap:wrap;">
                                <form class="row">
                                    <div class="form-group col-md-6">
                                        <label class="control-label" for="code">Coupon Code</label>
                                        <input class="form-control" type="text" id="code" name="code"
                                            required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label" for="discount_type">Discount Type</label>
                                        <input class="form-control" type="text" id="discount_type"
                                            name="discount_type" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label" for="discount_value">Discount Value</label>
                                        <input class="form-control" type="number" id="discount_value"
                                            name="discount_value" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label" for="expiration_date">Expiration Date</label>
                                        <input class="form-control" type="date" id="expiration_date"
                                            name="expiration_date" required>
                                    </div>
                            </div>
                            <div class="button-group" style="display:flex;justify-content:flex-end;padding-right:15px">
                                <button class="btn btn-save" type="button" onclick="createCoupon()"
                                    style="width:80px;margin-right:5px;">Save</button>
                                <a class="btn btn-cancel" href="{{ route('quanlimagiamgia') }}"
                                    style="width:80px;">Cancel</a>
                            </div>
                        </div>
            </form>
        </main>

        @include('admin.layout.footer')
    </div>

    <!-- Notification HTML -->
    <div id="notification"
        style="display: none; position: fixed; top: 70px; right: 20px; z-index: 1000; background-color: #4CAF50; color: white; padding: 15px; border-radius: 5px;">
        <span id="notification-icon" style="margin-right: 10px;">
            <i class="fa fa-check-circle" style="border: 2px solid white; border-radius: 50%; padding: 5px;"></i> Coupon
            created successfully !!!
        </span>
        <span id="notification-message"></span>
    </div>

    <div id="errorMessage"
        style="display: none; position: fixed; top: 70px; right: 20px; z-index: 1000; background-color: #f44336; color: white; padding: 15px; border-radius: 5px;">
        <span id="errorMessage-icon" style="margin-right: 10px;">
            <i class="fa fa-times" style="border: 2px solid white; border-radius: 50%; padding: 5px;"></i> Coupon
            code already exists !!!
            <span id="errorMessage-message"></span>
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
        function createCoupon() {
            const code = document.getElementById("code").value;
            const discountType = document.getElementById("discount_type").value;
            const discountValue = document.getElementById("discount_value").value;
            const expirationDate = document.getElementById("expiration_date").value;

            fetch('/admin/coupons', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        code: code,
                        discount_type: discountType,
                        discount_value: discountValue,
                        expiration_date: expirationDate
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw new Error(errorData.error || 'Something went wrong');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    const notification = document.getElementById("notification");
                    notification.style.display = "flex"; // Hiển thị thông báo thành công
                    setTimeout(() => {
                        notification.style.display = "none"; // Ẩn thông báo sau 3 giây
                    }, 2000);
                    window.location.href = "/admin/quanlimagiamgia"; // Redirect back to coupon list
                })
                .catch(error => {
                    const errorMessage = document.getElementById("errorMessage");
                    errorMessage.style.display = "flex"; // Hiển thị thông báo lỗi
                    setTimeout(() => {
                        errorMessage.style.display = "none"; // Ẩn thông báo sau 3 giây
                    }, 2000);
                    console.error('There was a problem with your fetch operation:', error);
                });
        }
    </script>
</body>

</html>
