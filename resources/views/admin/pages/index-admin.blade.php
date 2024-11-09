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
            <div class="row">
                <div class="col-md-12">
                    <div class="app-title">
                        <ul class="app-breadcrumb breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin"><b>Dashboard</b></a></li>
                        </ul>
                        <div id="clock"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!--Left-->
                <div class="col-md-12 col-lg-6">
                    <div class="row">
                        <!-- col-6 -->
                        <div class="col-md-6">
                            <div class="widget-small primary coloured-icon">
                                <i class='icon bx bxs-user-account fa-3x'></i>
                                <div class="info">
                                    <h4>Total Customers</h4>
                                    <p><b>{{ $totalCustomers }} customers</b></p>
                                    <p class="info-tong">Total number of customers managed.</p>
                                </div>
                            </div>
                        </div>
                        <!-- col-6 -->
                        <div class="col-md-6">
                            <div class="widget-small info coloured-icon">
                                <i class='icon bx bxs-data fa-3x'></i>
                                <div class="info">
                                    <h4>Total Products</h4>
                                    <p><b>{{ $totalProducts }} products</b></p>
                                    <p class="info-tong">Total number of products managed.</p>
                                </div>
                            </div>
                        </div>
                        <!-- col-6 -->
                        <div class="col-md-6">
                            <div class="widget-small warning coloured-icon">
                                <i class='icon bx bxs-shopping-bags fa-3x'></i>
                                <div class="info">
                                    <h4>Total Orders</h4>
                                    <p><b>{{ $totalOrders }} orders</b></p>
                                    <p class="info-tong">Total number of orders managed.</p>
                                </div>
                            </div>
                        </div>
                        <!-- col-6 -->
                        <div class="col-md-6">
                            <div class="widget-small danger coloured-icon">
                                <i class='icon bx bxs-error-alt fa-3x'></i>
                                <div class="info">
                                    <h4>Running Low</h4>
                                    <p><b>{{ $lowStockProducts }} product</b></p>
                                    <p class="info-tong">The product quantity is warned to be running low.</p>
                                </div>
                            </div>
                        </div>
                        <!-- col-12 -->
                        <div class="col-md-12">
                            <div class="tile">
                                <h3 class="tile-title">New Orders Status</h3>
                                <div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer Name</th>
                                                <th>Total Price</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recentOrders as $order)
                                                <tr>
                                                    <td>{{ $order->order_id }}</td>
                                                    <td>{{ $order->full_name }}</td>
                                                    <td>${{ number_format($order->subtotal, 2, '.', '.') }}</td>
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
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- / col-12 -->
                        <!-- col-12 -->
                        <div class="col-md-12">
                            <div class="tile">
                                <h3 class="tile-title">New Customers</h3>
                                <div>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Customer Name</th>
                                                <th>Created Time</th>
                                                <th>Phone Number</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recentCustomers as $user)
                                                <tr>
                                                    <td>{{ $user->User_id }}</td>
                                                    <td>{{ $user->Name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($user->dob)->format('d/m/Y') }}
                                                    </td>
                                                    <td><span
                                                            class="tag tag-success">{{ $user->Phone }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- / col-12 -->
                    </div>
                </div>
                <!--Right-->
                <div class="col-md-12 col-lg-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile">
                                <h3 class="tile-title">6 Month Order Statistics</h3>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="tile">
                                <h3 class="tile-title">6 Month Revenue Statistics</h3>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <canvas class="embed-responsive-item" id="barChartDemo"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--END right-->
            </div>
        </main>

        <!-- Include Footer -->
        @include('admin.layout.footer')
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('lineChartDemo').getContext('2d');
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    @foreach (range(5, 0) as $i)
                        "{{ \Carbon\Carbon::now()->subMonths($i)->format('M Y') }}",
                    @endforeach
                ],
                datasets: [{
                        label: 'Total orders',
                        data: @json($ordersPerMonth),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Delivered',
                        data: @json($deliveredOrdersPerMonth),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Cancelled',
                        data: @json($cancelledOrdersPerMonth),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        var ctx = document.getElementById('barChartDemo').getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach (range(5, 0) as $i)
                        "{{ \Carbon\Carbon::now()->subMonths($i)->format('M Y') }}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Revenue',
                    data: @json($revenuePerMonth),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 71, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 71, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>
