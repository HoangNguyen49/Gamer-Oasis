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
                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders Management</a></li>
                    <li class="breadcrumb-item">Edit Order</li>
                </ul>
                <div id="clock"></div>
            </div>

            <form id="order-form" action="{{ route('orders.update', $order->order_id) }}" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <div class="tile">
                            <h3 class="tile-title">EDIT ORDER</h3>
                            <div class="tile-body" style="display:flex;flex-wrap:wrap;">
                                @csrf
                                @method('PUT') <!-- Phương thức PUT để cập nhật -->
                                <div class="form-group col-md-4">
                                    <label class="control-label">Customer Name</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name" maxlength="150"
                                        value="{{ old('full_name', $order->full_name) }}" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" maxlength="11"
                                        value="{{ old('phone', $order->phone) }}" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Email</label>
                                    <input type="email" class="form-control" id="email_address" name="email_address" maxlength="255"
                                        value="{{ old('email_address', $order->email_address) }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" maxlength="255"
                                        value="{{ old('address', $order->address) }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Product Name</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name"
                                        value="{{ old('product_name', $order->product_name) }}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Product ID</label>
                                    <input type="text" class="form-control" id="product_id" name="product_id"
                                        value="{{ $productIds ? $productIds : 'N/A' }}" readonly>
                                    <td></td>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity"
                                        value="{{ old('quantity', $order->quantity) }}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Total Price ($)</label>
                                    <input type="number" class="form-control" id="subtotal" name="subtotal"
                                        value="{{ old('subtotal', $order->subtotal) }}" required readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="processed"
                                            {{ $order->status == 'processed' ? 'selected' : '' }}>Processed
                                        </option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                            Shipped</option>
                                        <option value="delivered"
                                            {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered
                                        </option>
                                        <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>
                                            Canceled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="button-group" style="display:flex;justify-content:flex-end;padding-right:15px">
                                <button class="btn btn-save" type="submit" id="saveButton"
                                    style="width:80px;margin-right:5px;">Save</button>
                                <a class="btn btn-cancel" href="{{ route('orders.index') }}"
                                    style="width:80px;">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </main>

        @include('admin.layout.footer')
    </div>

    <!-- Overlay -->
    <div id="overlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000;">
    </div>

    <!-- Custom Confirm Dialog -->
    <div id="confirmDialog"
        style="width: 40%; display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2000; background-color: white; border: 1px solid #ccc; border-radius: 5px; padding: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <h5 class="modal-title" style="font-size: 20px; color:red;padding:20px 0 10px 0">WARNING !!!</h5>
        <div id="dialogMessage" style="font-size: 16px;">The order <b style="color: red">will be saved</b>, please check carefully as it may
            <b style="color: red">affect customer</b> if there is any mistake. Please make sure the changes have been <b style="color: red">checked carefully</b>.</div>
        <div style="margin-top: 20px; display:flex; justify-content:space-around; padding:20px;">
            <button id="confirmYesButton" class="btn btn-primary" style="font-size: 20px; width: 200px;">Yes</button>
            <button id="confirmNoButton" class="btn btn-secondary" style="font-size: 20px; width: 200px;">No</button>
        </div>
    </div>

    <div id="errorMessage"
        style="display: none; width: 40%; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2000; background-color: white; border: 1px solid #ccc; border-radius: 5px; padding: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <h5 class="modal-title" style="font-size: 20px; color: red; padding:20px 0 10px 0">ERROR !!!</h5>
        <div id="errorMessageText" style="font-size: 16px;">You <b style="color:red">cannot edit</b> this order because it <b style="color:red">has
            been delivered</b>.</div>
        <div style="margin-top: 20px; text-align: center; padding:20px">
            <button id="closeErrorButton" class="btn btn-danger"
                style="font-size: 20px; width: 200px;">Close</button>
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
        }

        // Giả định rằng giá sản phẩm đã được truyền từ Controller vào view dưới dạng biến
        var pricePerUnit = {{ $order->subtotal / $order->quantity }}; // Giá mỗi sản phẩm

        document.getElementById('quantity').addEventListener('input', function() {
            var quantity = this.value;
            var totalPrice = quantity * pricePerUnit;
            document.getElementById('subtotal').value = totalPrice.toFixed(2); // Cập nhật tổng giá trị
        });

        // Xử lý sự kiện khi biểu mẫu được gửi
        document.getElementById('order-form').onsubmit = function(e) {
            e.preventDefault(); // Ngăn chặn hành động mặc định của biểu mẫu

            const formData = new FormData(this); // Lấy toàn bộ dữ liệu từ biểu mẫu
            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        // Hiển thị thông báo thành công
                        document.getElementById('overlay').style.display = 'block';
                        document.getElementById('confirmDialog').style.display = 'block';

                        // Xử lý hành động khi người dùng nhấn Yes
                        document.getElementById('confirmYesButton').onclick = function() {
                            // Lưu đơn hàng và chuyển hướng về trang orders
                            window.location.href = '{{ route('orders.index') }}';
                        };

                        // Xử lý hành động khi người dùng nhấn No
                        document.getElementById('confirmNoButton').onclick = function() {
                            // Đóng dialog mà không thực hiện hành động gì
                            document.getElementById('confirmDialog').style.display = 'none';
                            document.getElementById('overlay').style.display = 'none';
                        };
                    } else {
                        alert('Có lỗi xảy ra khi cập nhật đơn hàng.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi cập nhật đơn hàng.');
                });
        };

        // Để đóng dialog và overlay nếu người dùng nhấn vào overlay
        document.getElementById('overlay').onclick = function() {
            this.style.display = 'none';
            document.getElementById('confirmDialog').style.display = 'none';
        };
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const statusSelect = document.getElementById("status");
            const saveButton = document.getElementById("saveButton");
            const currentStatus = "{{ $order->status }}";

            function updateStatusOptions() {
                Array.from(statusSelect.options).forEach(option => option.disabled = false);

                switch (currentStatus) {
                    case 'pending':
                        break;
                    case 'processed':
                        statusSelect.querySelector('option[value="pending"]').disabled = true;
                        break;
                    case 'shipped':
                        statusSelect.querySelector('option[value="pending"]').disabled = true;
                        statusSelect.querySelector('option[value="processed"]').disabled = true;
                        break;
                    case 'delivered':
                        Array.from(statusSelect.options).forEach(option => option.disabled = true);
                        statusSelect.querySelector('option[value="delivered"]').disabled = false;
                        break;
                    case 'canceled':
                        break;
                }
            }

            updateStatusOptions();

            // Xử lý khi nhấn nút Save
            saveButton.addEventListener("click", function(event) {
                // Kiểm tra trạng thái hiện tại khi nhấn Save
                if (currentStatus === 'delivered') {
                    // Hiển thị thông báo lỗi khi trạng thái là "delivered"
                    document.getElementById('overlay').style.display = 'block';
                    document.getElementById('errorMessage').style.display = 'block';
                    document.getElementById('closeErrorButton').onclick = function() {
                        // Đóng thông báo và không làm gì thêm
                        document.getElementById('errorMessage').style.display = 'none';
                        document.getElementById('overlay').style.display = 'none';
                    };
                    event.preventDefault(); // Ngừng hành động save nếu trạng thái là delivered
                }
            });
        });
    </script>

</body>

</html>
