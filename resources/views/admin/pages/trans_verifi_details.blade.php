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
                <li class="breadcrumb-item"><a href="{{ route('trans_verifi.index') }}"><b>Transaction
                            Verification</b></a></li>
                <li class="breadcrumb-item active"><b>Transaction Verification Details</b></li>
            </ul>
            <div id="clock"></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <h3 class="tile-title">Transaction Verification Details</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>VNPay ID</th>
                                    <td>{{ $vnpayOrder->vnpay_id }}</td>
                                </tr>
                                <tr>
                                    <th>Order ID</th>
                                    <td>{{ $vnpayOrder->vnpay_orders_id }}</td>
                                </tr>
                                <tr>
                                    <th>Transaction Code</th>
                                    <td>{{ $vnpayOrder->transaction_code }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Amount</th>
                                    <td>
                                        {{ number_format($vnpayOrder->amount, 0, ',', '.') }} VND
                                        ({{ number_format($vnpayOrder->amount / 25000, 2, '.', ',') }} USD)
                                    </td>
                                </tr>
                                <tr>
                                    <th>Payment Status</th>
                                    <td>
                                        @if ($vnpayOrder->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($vnpayOrder->status == 'success')
                                            <span class="badge bg-success">Success</span>
                                        @elseif($vnpayOrder->status == 'failed')
                                            <span class="badge bg-danger">Failed</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>VNPay Response Code</th>
                                    <td>{{ $vnpayOrder->vnpay_response_code }}</td>
                                </tr>
                                <tr>
                                    <th>Bank Code</th>
                                    <td>{{ $vnpayOrder->bank_code }}</td>
                                </tr>
                                <tr>
                                    <th>Bank Transaction Code</th>
                                    <td>{{ $vnpayOrder->bank_transaction_code }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Type</th>
                                    <td>{{ $vnpayOrder->payment_type }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Date</th>
                                    <td>{{ $vnpayOrder->pay_date }}</td>
                                </tr>
                                <tr>
                                    <th>Created Time</th>
                                    <td>{{ $vnpayOrder->created_at }}</td>
                                </tr>
                                <tr>
                                    <th>Updated Time</th>
                                    <td>{{ $vnpayOrder->updated_at }}</td>
                                </tr>
                            </table>
                        </div>
                        <a href="{{ route('trans_verifi.index') }}" class="btn btn-primary mt-3"
                            style="padding: 0.500rem">Back to Transaction Verification</a>
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
