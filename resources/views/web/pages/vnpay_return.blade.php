<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VNPAY RESPONSE</title>
    <link href="/vnpay_php/assets/bootstrap.min.css" rel="stylesheet"/>
    <link href="/vnpay_php/assets/jumbotron-narrow.css" rel="stylesheet">         
    <script src="/vnpay_php/assets/jquery-1.11.3.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 600px;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px 5px 0 0;
            margin-bottom: 20px;
        }
        .header h3 {
            margin: 0;
            font-size: 20px;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border-radius: 0 0 5px 5px;
            margin-top: 20px;
        }
        .footer p {
            margin: 0;
            font-size: 14px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group span {
            font-size: 18px;
        }
        .status-success {
            color: #28a745;
        }
        .status-failed {
            color: #dc3545;
        }
        .btn-back {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h3 class="text-muted">VNPAY RESPONSE</h3>
        </div>
        <div class="table-responsive">
            <div class="form-group">
                <label>VNPAY Order ID:</label>
                <span>{{ $vnp_TxnRef }}</span>
            </div>
            <div class="form-group">
                <label>Amount:</label>
                <span>
                    {{ $vnp_Amount }} 
                </span>
            </div>
            <div class="form-group">
                <label>Payment Description:</label>
                <span>{{ $vnp_OrderInfo }}</span>
            </div>
            <div class="form-group">
                <label>Response Code (vnp_ResponseCode):</label>
                <span>{{ $vnp_ResponseCode }}</span>
            </div>
            <div class="form-group">
                <label>Transaction Code at VNPAY:</label>
                <span>{{ $vnp_TransactionNo }}</span>
            </div>
            <div class="form-group">
                <label>Bank Code:</label>
                <span>{{ $vnp_BankCode }}</span>
            </div>
            <div class="form-group">
                <label>Payment Time:</label>
                <span>{{ $vnp_PayDate }}</span>
            </div>
            <div class="form-group">
                <label>Result:</label>
                <span class="@if ($secureHash == $vnp_SecureHash && $vnp_ResponseCode == '00') status-success @else status-failed @endif">
                    @if ($secureHash == $vnp_SecureHash)
                        @if ($vnp_ResponseCode == '00')
                            Transaction Successful
                        @else
                            Transaction Unsuccessful
                        @endif
                    @else
                        Invalid Signature
                    @endif
                </span>
            </div>
        </div>
        <div class="text-center">
            <a href="/web/pages/cart.blade.php" class="btn btn-primary btn-back">Back to Cart</a>
        </div>
        <footer class="footer">
            <p>&copy; VNPAY {{ date('Y') }}</p>
        </footer>
    </div>  
</body>
</html>
