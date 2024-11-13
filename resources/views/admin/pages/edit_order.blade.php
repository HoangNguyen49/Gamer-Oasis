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
                                    <input type="text" class="form-control" id="full_name" name="full_name"
                                        value="{{ old('full_name', $order->full_name) }}" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ old('phone', $order->phone) }}" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Email</label>
                                    <input type="email" class="form-control" id="email_address" name="email_address"
                                        value="{{ old('email_address', $order->email_address) }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
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
                                        value="{{ old('product_id', $order->Product_id) }}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $order->quantity) }}" required oninput="updateSubtotal()">
                                    <small>
                                        Stock: {{ old('stock_quantity', $stockQuantity) }}
                                        <span id="stock-warning" class="text-danger" style="display: none;">(Not enough stock)</span>
                                    </small>
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
                                <button class="btn btn-save" type="submit"
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
        <h5 class="modal-title" style="font-size: 20px;">Update successfully !!!</h5>
        <div id="dialogMessage" style="font-size: 16px">The order has been updated successfully, please check
            carefully
            as it may affect customers if there is a mistake.</div>
        <div style="margin-top: 20px; text-align: center;">
            <button id="confirmOkButton" class="btn btn-primary" style="font-size: 20px; width: 200px;">OK</button>
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
    
        // Cập nhật Subtotal khi quantity thay đổi
        document.getElementById('quantity').addEventListener('input', function() {
            var quantity = Number(this.value); // Chuyển thành số (sử dụng Number thay vì parseInt)
            
            // Kiểm tra giá trị hợp lệ
            if (isNaN(quantity) || quantity < 1) {
                quantity = 1; // Đảm bảo số lượng phải là một số hợp lệ và lớn hơn 0
            }
    
            var totalPrice = quantity * pricePerUnit;
            document.getElementById('subtotal').value = totalPrice.toFixed(2); // Cập nhật tổng giá trị
    
            // Kiểm tra stock khi nhập quantity
            const stockQuantity = {{ $stockQuantity }};
            if (quantity > stockQuantity) {
                document.getElementById('stock-warning').style.display = 'inline';
            } else {
                document.getElementById('stock-warning').style.display = 'none';
            }
        });
    
        // Xử lý sự kiện khi biểu mẫu được gửi
        document.getElementById('order-form').onsubmit = function(e) {
            e.preventDefault(); // Ngăn chặn hành động mặc định của biểu mẫu
    
            // Lấy giá trị quantity và stockQuantity từ input
            const quantity = Number(document.getElementById('quantity').value); // Đảm bảo là số hợp lệ
            const stockQuantity = Number('{{ $stockQuantity }}'); // Chuyển sang kiểu số
    
            // Kiểm tra xem quantity có vượt quá stockQuantity hay không
            if (isNaN(quantity) || quantity < 1) {
                alert('Please enter a valid quantity.');
                return; // Ngừng thực hiện nếu quantity không hợp lệ
            }
    
            if (quantity > stockQuantity) {
                alert('Quantity cannot exceed quantity in stock (Stock: ' + stockQuantity + ').');
                return; // Ngừng thực hiện nếu vượt quá
            }
    
            // Gửi yêu cầu AJAX
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(Object.fromEntries(new FormData(this))) // Chuyển form thành JSON
            })
            .then(response => {
                if (response.ok) {
                    // Hiện overlay và dialog thành công
                    document.getElementById('overlay').style.display = 'block';
                    document.getElementById('confirmDialog').style.display = 'block';
    
                    // Chuyển hướng sau khi nhấn OK
                    document.getElementById('confirmOkButton').onclick = function() {
                        window.location.href = '{{ route('orders.index') }}'; // Chuyển hướng về trang quản lý đơn hàng
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
    
        // Cập nhật trạng thái các lựa chọn trong dropdown dựa trên trạng thái đơn hàng
        document.addEventListener("DOMContentLoaded", function() {
            const statusSelect = document.getElementById("status");
            const currentStatus = "{{ $order->status }}";
    
            function updateStatusOptions() {
                const options = statusSelect.options;
                
                // Mở khóa tất cả các tùy chọn trước
                Array.from(options).forEach(option => option.disabled = false);
    
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
                        Array.from(options).forEach(option => option.disabled = true);
                        statusSelect.querySelector('option[value="delivered"]').disabled = false;
                        break;
                    case 'canceled':
                        break;
                }
            }
    
            updateStatusOptions();
        });
    </script>
    


</body>

</html>