<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include necessary head elements -->
    @include('admin.layout.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <!-- Include Navbar -->
    @include('admin.layout.navbar')
    <!-- Sidebar menu-->
    @include('admin.layout.sidebar')
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item active"><a href="{{ route('orders.index') }}"><b>Orders List</b></a></li>
            </ul>
            <div id="clock"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="row element-button">
                            <div class="col-sm-12 d-flex justify-content-end"> <!-- Chiếm 4 cột -->
                                <form action="{{ route('orders.index') }}" method="GET" class="form-inline mb-3">
                                    <input style="height:32px" type="text" name="search" class="form-control mr-2"
                                        placeholder="Customer, Product Name" value="{{ request()->query('search') }}">
                                    <button type="submit" class="btn btn-primary" style="height:32px;">Search</button>
                                </form>
                            </div>
                        </div>
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer Name</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Create Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($orders->isEmpty())
                                    <tr>
                                        <td colspan="9" class="text-center"
                                            style="color: red; font-weight: bold; font-size: 16px;">NO ORDER FOUND
                                            !!!</td>
                                    </tr>
                                @else
                                    @foreach ($orders as $order)
                                        <tr data-id="order-{{ $order->order_id }}">
                                            <td>{{ $order->order_id }}</td>
                                            <td>{{ $order->full_name }}</td>
                                            <td>{{ $order->product_name }}</td>
                                            <td>{{ $order->quantity }}</td>
                                            <td>${{ $order->subtotal }}</td>
                                            <td>
                                                @if ($order->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($order->status == 'processed')
                                                    <span class="badge bg-info">Processed</span>
                                                @elseif($order->status == 'shipped')
                                                    <span class="badge bg-primary">Shipped</span>
                                                @elseif($order->status == 'delivered')
                                                    <span class="badge bg-success">Delivered</span>
                                                @elseif($order->status == 'canceled')
                                                    <span class="badge bg-danger">Canceled</span>
                                                @endif
                                            </td>
                                            <td>{{ $order->created_at }}</td>
                                            <td>
                                                <a href="{{ route('orders.show', $order->order_id) }}"
                                                    class="btn btn-primary btn-sm view" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-primary btn-sm edit" type="button"
                                                    title="Edit"
                                                    onclick="window.location='{{ route('orders.edit', $order->order_id) }}'">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-primary btn-sm trash" type="button"
                                                    title="Delete" onclick="deleteOrder({{ $order->order_id }})">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <!-- Phân trang -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p>There are {{ $orders->total() }} orders currently</p>
                                        <!-- Hiển thị tổng số đơn hàng -->
                                    </div>
                                    <div>
                                        <nav>
                                            <ul class="pagination">
                                                {{-- Nút đến trang đầu tiên --}}
                                                @if ($orders->currentPage() > 1)
                                                    <li><a href="{{ $orders->url(1) }}">&laquo;</a></li>
                                                @endif

                                                {{-- Nút quay lại --}}
                                                @if ($orders->onFirstPage())
                                                    <li class="disabled"><span>&lt;</span></li>
                                                @else
                                                    <li><a href="{{ $orders->previousPageUrl() }}">&lt;</a></li>
                                                @endif

                                                {{-- Các nút phân trang --}}
                                                @php
                                                    $currentPage = $orders->currentPage();
                                                    $lastPage = $orders->lastPage();
                                                    $startPage = max(1, $currentPage - 1); // Bắt đầu từ trang 1 hoặc một trang trước trang hiện tại
                                                    $endPage = min($lastPage, $startPage + 2); // Kết thúc ở trang cuối cùng hoặc trang 3 sau trang bắt đầu

                                                    // Điều chỉnh startPage nếu endPage là trang cuối
                                                    if ($endPage - $startPage < 2) {
                                                        $startPage = max(1, $endPage - 2); // Đảm bảo hiển thị đúng 3 trang nếu có đủ
                                                    }
                                                @endphp

                                                @for ($page = $startPage; $page <= $endPage; $page++)
                                                    @if ($page == $currentPage)
                                                        <li class="active"><span>{{ $page }}</span></li>
                                                    @else
                                                        <li><a
                                                                href="{{ $orders->url($page) }}">{{ $page }}</a>
                                                        </li>
                                                    @endif
                                                @endfor

                                                {{-- Nút tiếp theo --}}
                                                @if ($orders->hasMorePages())
                                                    <li><a href="{{ $orders->nextPageUrl() }}">&gt;</a></li>
                                                @else
                                                    <li class="disabled"><span>&gt;</span></li>
                                                @endif

                                                {{-- Nút đến trang cuối cùng --}}
                                                @if ($orders->currentPage() < $lastPage)
                                                    <li><a
                                                            href="{{ $orders->url($lastPage) }}">&raquo;</a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Include Footer -->
    @include('admin.layout.footer')

    <!-- Notification HTML -->
    <div id="notification"
        style="display: none; position: fixed; top: 70px; right: 20px; z-index: 1000; background-color: #4CAF50; color: white; padding: 15px; border-radius: 5px;">
        <span id="notification-icon" style="margin-right: 10px;">

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
        <h5 style="margin-bottom: 15px;">Are you sure you want to delete this order?</h5>
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
        function deleteOrder(orderId) {
            const confirmDialog = document.getElementById("confirmDialog");
            const overlay = document.getElementById("overlay");

            // Hiển thị overlay và hộp thoại xác nhận
            overlay.style.display = "block";
            confirmDialog.style.display = "block";

            // Xử lý sự kiện khi nhấn "Yes"
            document.getElementById("confirmYes").onclick = function() {
                fetch(`/admin/orders/${orderId}`, {
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
                        notificationMessage.innerText = 'Order deleted successfully!';
                        notification.style.display = "flex"; // Hiển thị thông báo

                        setTimeout(() => {
                            notification.style.display = "none"; // Ẩn thông báo sau 3 giây
                        }, 2000);

                        // Xóa dòng đơn hàng khỏi bảng
                        const row = document.querySelector(`tr[data-id="order-${orderId}"]`);
                        if (row) {
                            row.remove();
                        }
                    })
                    .catch(error => {
                        console.error('There was a problem with the delete operation:', error);
                    });

                // Ẩn overlay và hộp thoại xác nhận
                overlay.style.display = "none";
                confirmDialog.style.display = "none";
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
