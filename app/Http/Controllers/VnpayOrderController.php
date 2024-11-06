<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VnpayOrder; // Đảm bảo đã tạo model cho bảng vnpay_orders
use Carbon\Carbon; // Nếu bạn cần xử lý ngày tháng
use Illuminate\Support\Facades\Session;


class VnpayOrderController extends Controller
{
    public function vnpay_payment(Request $request)
    {
        // Lấy giỏ hàng từ session
        $cart = Session::get('cart', []);

        // Kiểm tra giỏ hàng rỗng
        if (empty($cart)) {
            return redirect()->back()->with('error', "Cart is empty!");
        }

        // Tính tổng giá trị giỏ hàng
        $subtotal = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        // Kiểm tra xem có mã giảm giá không và tính tổng tiền sau giảm
        $total = Session::has('coupon') ? Session::get('coupon')['totalAfterDiscount'] : $subtotal;

        $exchangeRate = 25000;
        $totalInUSD = $total * $exchangeRate;

        //tạo mã đơn hàng ngẫu nhiên
        $order_id = uniqid('order_'); // Tạo mã đơn hàng ngẫu nhiên


        // Logic VNPAY
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/vnpay_return";
        $vnp_TmnCode = "DII1D8KA"; //Mã website tại VNPAY 
        $vnp_HashSecret = "QI3W2HVVADMKGLKCKRS7KT2T5I1PBJXP"; //Chuỗi bí mật

        $vnp_TxnRef = $order_id;
        $vnp_OrderInfo = 'Order payment for Gamer Oasis';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = round($totalInUSD * 100);
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_HashSecret = "QI3W2HVVADMKGLKCKRS7KT2T5I1PBJXP"; // Thay thế bằng giá trị của bạn
        $vnp_SecureHash = $request->input('vnp_SecureHash');

        // Lấy tất cả các thông tin từ request, ngoại trừ vnp_SecureHash
        $inputData = $request->except(['vnp_SecureHash']);

        // Kiểm tra và xác thực chữ ký bảo mật
        ksort($inputData);
        $hashData = http_build_query($inputData);
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        // Xác định kết quả giao dịch
        $responseCode = $request->input('vnp_ResponseCode');

        // Lưu thông tin vào bảng vnpay_orders
        $vnpayOrder = new VnpayOrder();
        $vnpayOrder->vnpay_id = $request->input('vnp_TransactionNo'); // Mã giao dịch từ VNPAY
        $vnpayOrder->order_id = session('order_id'); // ID đơn hàng từ session
        $vnpayOrder->transaction_code = $request->input('vnp_TransactionNo');

        // Chia cho 100 để chuyển đổi từ đồng sang VND
        $vnpayOrder->amount = is_numeric($request->input('vnp_Amount')) ? $request->input('vnp_Amount') / 100 : 0;

        $vnpayOrder->status = ($secureHash == $vnp_SecureHash && $responseCode == '00') ? 'success' : 'failed';
        $vnpayOrder->vnpay_response_code = $responseCode;
        $vnpayOrder->bank_code = $request->input('vnp_BankCode');
        $vnpayOrder->bank_transaction_code = $request->input('vnp_BankTranNo');
        $vnpayOrder->payment_type = $request->input('vnp_CardType');

        // Kiểm tra định dạng ngày tháng
        $payDate = $request->input('vnp_PayDate');
        $vnpayOrder->pay_date = $payDate ? Carbon::createFromFormat('YmdHis', $payDate) : null;

        $vnpayOrder->vnp_secure_hash = $vnp_SecureHash;

        // Lưu vào cơ sở dữ liệu
        $vnpayOrder->save();

        // Truyền dữ liệu vào view
        return view('web.pages.vnpay_return', [
            'vnp_TxnRef' => $request->input('vnp_TxnRef'),
            'vnp_Amount' => number_format(($vnpayOrder->amount ?? 0), 0, ',', '.') . ' VND', // Định dạng số tiền
            'vnp_OrderInfo' => $request->input('vnp_OrderInfo'),
            'vnp_ResponseCode' => $responseCode,
            'vnp_TransactionNo' => $request->input('vnp_TransactionNo'),
            'vnp_BankCode' => $request->input('vnp_BankCode'),
            'vnp_PayDate' => $payDate,
            'secureHash' => $secureHash, // Truyền secure hash vào view
            'vnp_SecureHash' => $vnp_SecureHash // Truyền secure hash từ request vào view
        ]);
    }


    public function store(Request $request)
    {
        // Tạo một instance của VnpayOrder
        $vnpayOrder = new VnpayOrder();

        // Gán các giá trị cho các thuộc tính của đơn hàng
        $vnpayOrder->vnpay_id = $request->input('vnp_TxnRef'); // Mã giao dịch
        $vnpayOrder->order_id = session('order_id'); // ID đơn hàng từ session
        $vnpayOrder->transaction_code = $request->input('vnp_TransactionNo'); // Mã giao dịch tại VNPAY

        // Lấy và định dạng số tiền thanh toán
        $amount = $request->input('vnp_Amount');
        $vnpayOrder->amount = is_numeric($amount) ? $amount / 100 : 0; // Chia cho 100

        // Xác định trạng thái thanh toán
        $vnpayOrder->status = ($request->input('vnp_ResponseCode') == '00') ? 'success' : 'failed'; // Trạng thái
        $vnpayOrder->vnpay_response_code = $request->input('vnp_ResponseCode'); // Mã phản hồi từ VNPAY
        $vnpayOrder->bank_code = $request->input('vnp_BankCode'); // Mã ngân hàng
        $vnpayOrder->bank_transaction_code = $request->input('vnp_BankTranNo'); // Mã giao dịch tại ngân hàng
        $vnpayOrder->payment_type = $request->input('vnp_CardType'); // Loại thẻ thanh toán

        // Kiểm tra định dạng ngày tháng
        $payDate = $request->input('vnp_PayDate');
        $vnpayOrder->pay_date = $payDate ? Carbon::parse($payDate) : null; // Ngày và thời gian thanh toán

        $vnpayOrder->vnp_secure_hash = $request->input('vnp_SecureHash'); // Chữ ký bảo mật

        // Lưu đơn hàng vào database
        $vnpayOrder->save();

        // Trả về response hoặc redirect
        return response()->json(['message' => 'Order saved successfully.']);
    }
}