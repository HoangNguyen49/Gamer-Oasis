<!doctype html>
<html class="no-js" lang="eng">

<!-- order-history -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Order History</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
</head>

<body>

    <div class="body-wrapper">

        @include('web.layouts.header')

        <div class="page-section mb-60">
            <div class="container">
                <h2 class="text-center mb-4">Order History</h2>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" class="text-center">Order ID</th>
                                        <th scope="col" class="text-center">Date</th>
                                        <th scope="col" class="text-center">Status</th>
                                        <th scope="col" class="text-center">Product Name</th>
                                        <th scope="col" class="text-center">Quantity</th>
                                        <th scope="col" class="text-center">Phone</th>
                                        <th scope="col" class="text-center">Address</th>
                                        <th scope="col" class="text-center">Total Price</th>
                                        <th scope="col" class="text-center">Buyer Name</th>
                                        <th scope="col" class="text-center">Payment Method</th>
                                        <th scope="col" class="text-center">VNPAY Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <th scope="row" class="text-center">{{ $order->order_id }}</th>
                                            <td class="text-center">{{ $order->created_at->format('d-m-Y') }}</td>
                                            <td class="text-center">{{ $order->status }}</td>
                                            <td class="text-center">{{ $order->product_name }}</td>
                                            <td class="text-center">{{ $order->quantity }}</td>
                                            <td class="text-center">{{ $order->phone }}</td>
                                            <td class="text-center">{{ $order->address }}</td>
                                            <td class="text-center">{{ $order->subtotal }}</td>
                                            <td class="text-center">{{ $order->full_name }}</td>
                                            <td class="text-center">{{ $order->payment_method}}</td>
                                            <td class="text-center">{{ $vnpayOrders[$order->order_id] ?? 'N/A' }}    
                                            </td>                                           
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('web.layouts.footer')

    </div>

    @include('web.layouts.css-script')

</body>

</html>
