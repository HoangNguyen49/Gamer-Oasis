<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.layout.head')
</head>

<body>
    @include('admin.layout.navbar')

    <div class="app-wrapper">
        @include('admin.layout.sidebar')
        <main class="app-content">
            <div class="app-title">
                <ul class="app-breadcrumb breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('quanlimagiamgia') }}">Coupon Management</a></li>
                    <li class="breadcrumb-item">Edit Coupon</li>
                </ul>
                <div id="clock"></div>
            </div>
            <form id="editCouponForm">
                <div class="row">
                    <div class="col-md-12">
                        <div class="tile">
                            <h3 class="tile-title">EDIT COUPON</h3>
                            <div class="tile-body" style="display:flex;flex-wrap:wrap;">
                                <div class="form-group col-md-6">
                                    <label class="control-label">ID</label>
                                    <input class="form-control" type="text" readonly id="coupon_id"
                                        value="{{ $coupon->coupon_id }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Coupon Code</label>
                                    <input class="form-control" type="text" required id="code" maxlength="50"
                                        value="{{ $coupon->code }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Discount Type</label>
                                    <input class="form-control" type="text" readonly id="discount_type"
                                        value="{{ $coupon->discount_type }}">
                                    @if ($coupon->discount_type === 'percentage')
                                        <small>* Percentage discount on total order value</small>
                                    @elseif ($coupon->discount_type === 'fixed')
                                        <small>* Fixed discount, directly deducted from total order value</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Discount Value</label>
                                    <input class="form-control" type="number" required id="discount_value"
                                        min="0.01" step="0.01" value="{{ $coupon->discount_value }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Expiration Date</label>
                                    <input class="form-control" type="date" required id="expiration_date"
                                        value="{{ \Carbon\Carbon::parse($coupon->expiration_date)->format('Y-m-d') }}"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                </div>

                            </div>
                            <div class="button-group" style="display:flex;justify-content:flex-end;padding-right:15px">
                                <button class="btn btn-save" type="button" onclick="updateCoupon()"
                                    style="width:80px;margin-right:5px;">Save</button>
                                <a class="btn btn-cancel" href="{{ route('quanlimagiamgia') }}"
                                    style="width:80px;">Cancel</a>
                            </div>
                        </div>
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
            updated successfully !!!
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

    <div id="stillNotEdit"
        style="display: none; position: fixed; top: 70px; right: 20px; z-index: 1000; background-color: orange; color: white; padding: 15px; border-radius: 5px;">
        <span id="stillNotEdit-icon" style="margin-right: 10px;">
            <i class="fa fa-times" style="border: 2px solid white; border-radius: 50%; padding: 5px;"></i> No
            information has been changed yet !!!
            <span id="stillNotEdit-message"></span>
    </div>

    <!-- Popup thông báo lỗi khi discount value không hợp lệ -->
    <div id="discountValueError"
        style="display: none; position: fixed; top: 70px; right: 20px; z-index: 1000; background-color: #f44336; color: white; padding: 15px; border-radius: 5px;">
        <span id="discountValueError-icon" style="margin-right: 10px;">
            <i class="fa fa-times" style="border: 2px solid white; border-radius: 50%; padding: 5px;"></i> Discount
            Value must be greater than 0 !!!
        </span>
    </div>

    <script>
        function validateDiscountValue() {
            const discountValue = document.getElementById("discount_value");
            if (parseFloat(discountValue.value) <= 0) {
                discountValue.setCustomValidity("Discount Value must be greater than 0");
            } else {
                discountValue.setCustomValidity("");
            }
        }

        function updateCoupon() {
            const id = document.getElementById("coupon_id").value;
            const code = document.getElementById("code").value;
            const discountType = document.getElementById("discount_type").value;
            const discountValue = document.getElementById("discount_value").value;
            const expirationDate = document.getElementById("expiration_date").value;

            // Kiểm tra discount value phải lớn hơn 0
            if (discountValue <= 0) {
                const discountValueError = document.getElementById("discountValueError");
                discountValueError.style.display = "flex"; // Hiển thị popup lỗi
                setTimeout(() => {
                    discountValueError.style.display = "none"; // Ẩn popup sau 3 giây
                }, 2000);
                return; // Dừng hàm nếu discountValue không hợp lệ
            }

            // Lưu trữ các giá trị ban đầu
            const initialCode = document.querySelector("#code").defaultValue;
            const initialDiscountType = document.querySelector("#discount_type").defaultValue;
            const initialDiscountValue = document.querySelector("#discount_value").defaultValue;
            const initialExpirationDate = document.querySelector("#expiration_date").defaultValue;

            // Kiểm tra sự thay đổi
            if (code === initialCode && discountType === initialDiscountType &&
                discountValue == initialDiscountValue && expirationDate === initialExpirationDate) {
                const stillNotEdit = document.getElementById("stillNotEdit");
                stillNotEdit.style.display = "flex"; // Hiển thị thông báo nếu không có sự thay đổi
                setTimeout(() => {
                    stillNotEdit.style.display = "none"; // Ẩn thông báo sau 3 giây
                }, 2000);
                return; // Dừng hàm nếu không có thay đổi
            }

            fetch(`/admin/coupons/${id}`, {
                    method: 'PUT',
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
                        return response.json().then(data => {
                            throw new Error(data.error);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Hiển thị thông báo thành công
                    const notification = document.getElementById("notification");
                    notification.style.display = "flex"; // Hiển thị thông báo
                    setTimeout(() => {
                        notification.style.display = "none"; // Ẩn thông báo sau 3 giây
                    }, 2000);

                    window.location.href = "/admin/quanlimagiamgia"; // Redirect back to coupon list
                })
                .catch(error => {
                    const errorMessage = document.getElementById("errorMessage");
                    errorMessage.style.display = "flex"; // Hiển thị thông báo lỗi
                    errorMessage.childNodes[0].innerText = error.message; // Hiển thị thông báo lỗi cụ thể
                    setTimeout(() => {
                        errorMessage.style.display = "none"; // Ẩn thông báo sau 3 giây
                    }, 2000);
                    console.error('There was a problem with your fetch operation:', error);
                });
        }
    </script>

</body>

</html>
