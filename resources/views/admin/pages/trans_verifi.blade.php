<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include necessary head elements -->
    @include('admin.layout.head')
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
                <li class="breadcrumb-item active"><a href="{{ route('trans_verifi.index') }}"><b>Transaction
                            Verification</b></a></li>
            </ul>
            <div id="clock"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="row element-button">
                            <div class="col-sm-12 d-flex justify-content-end"> <!-- Chiếm 4 cột -->
                                <form action="{{ route('trans_verifi.index') }}" method="GET"
                                    class="form-inline mb-3">
                                    <input style="height:32px" type="text" name="search" class="form-control mr-2"
                                        placeholder="Order ID, Transaction Code"
                                        value="{{ request()->query('search') }}">
                                    <button type="submit" class="btn btn-primary" style="height:32px;">Search</button>
                                </form>
                            </div>
                        </div>
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>VNPay ID</th>
                                    <th>Order ID</th>
                                    <th>Transaction Code</th>
                                    <th>Payment Amount</th>
                                    <th>Status</th>
                                    <th>Bank Code</th>
                                    <th>Payment Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vnpayOrders as $order)
                                    @php
                                        // Tỷ giá 1 USD = 25.000 VND
                                        $usdAmount = $order->amount / 25000;
                                    @endphp
                                    <tr>
                                        <td>{{ $order->vnpay_id }}</td>
                                        <td>{{ $order->vnpay_orders_id }}</td>
                                        <td>{{ $order->transaction_code }}</td>
                                        <!-- Hiển thị số tiền với đơn vị USD -->
                                        <td>
                                            {{ number_format($order->amount, 0, ',', '.') }} VND
                                            ({{ number_format($usdAmount, 2, '.', '.') }} $)
                                        </td>
                                        <td>
                                            @if ($order->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($order->status == 'success')
                                                <span class="badge bg-success">Success</span>
                                            @elseif($order->status == 'failed')
                                                <span class="badge bg-danger">Failed</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->bank_code }}</td>
                                        <td>{{ $order->pay_date }}</td>
                                        <td>
                                            <a href="{{ route('trans_verifi_details', ['vnpay_id' => $order->vnpay_id]) }}"
                                                class="btn btn-primary btn-sm view" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Phân trang -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p>There are {{ $vnpayOrders->total() }} transaction verification currently</p>
                                        <!-- Hiển thị tổng số đơn hàng -->
                                    </div>
                                    <div>
                                        <nav>
                                            <ul class="pagination">
                                                {{-- Nút đến trang đầu tiên --}}
                                                @if ($vnpayOrders->currentPage() > 1)
                                                    <li><a href="{{ $vnpayOrders->url(1) }}">&laquo;</a></li>
                                                @endif

                                                {{-- Nút quay lại --}}
                                                @if ($vnpayOrders->onFirstPage())
                                                    <li class="disabled"><span>&lt;</span></li>
                                                @else
                                                    <li><a href="{{ $vnpayOrders->previousPageUrl() }}">&lt;</a></li>
                                                @endif

                                                {{-- Các nút phân trang --}}
                                                @php
                                                    $currentPage = $vnpayOrders->currentPage();
                                                    $lastPage = $vnpayOrders->lastPage();
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
                                                                href="{{ $vnpayOrders->url($page) }}">{{ $page }}</a>
                                                        </li>
                                                    @endif
                                                @endfor

                                                {{-- Nút tiếp theo --}}
                                                @if ($vnpayOrders->hasMorePages())
                                                    <li><a href="{{ $vnpayOrders->nextPageUrl() }}">&gt;</a></li>
                                                @else
                                                    <li class="disabled"><span>&gt;</span></li>
                                                @endif

                                                {{-- Nút đến trang cuối cùng --}}
                                                @if ($vnpayOrders->currentPage() < $lastPage)
                                                    <li><a
                                                            href="{{ $vnpayOrders->url($lastPage) }}">&raquo;</a>
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
