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
                <li class="breadcrumb-item active"><b>Order Details</b></li>
            </ul>
            <div id="clock"></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <h3 class="tile-title">Order Details</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Order ID</th>
                                    <td>{{ $order->order_id ? $order->order_id : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Product ID</th>
                                    <td>{{ $productIds ? $productIds : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Product Name</th>
                                    <td>{{ $order->product_name ? $order->product_name : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Quantity</th>
                                    <td>{{ $order->quantity ? $order->quantity : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Total Price</th>
                                    <td>${{ $order->subtotal ? $order->subtotal : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
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
                                </tr>
                                <tr>
                                    <th>User ID</th>
                                    <td>{{ $order->User_id ? $order->User_id : 'Guest' }}</td>
                                </tr>
                                <tr>
                                    <th>Customer Name</th>
                                    <td>{{ $order->full_name ? $order->full_name : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $order->phone ? $order->phone : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $order->address ? $order->address : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Email Address</th>
                                    <td>{{ $order->email_address ? $order->email_address : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Created Time</th>
                                    <td>{{ $order->created_at ? $order->created_at : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Updated Time</th>
                                    <td>{{ $order->updated_at ? $order->updated_at : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Method</th>
                                    <td>{{ $order->payment_method ? $order->payment_method : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <a href="{{ route('orders.index') }}" class="btn btn-primary mt-3"
                            style="padding: 0.500rem">Back to Orders List</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Include Footer -->
    @include('admin.layout.footer')

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

</body>

</html>
