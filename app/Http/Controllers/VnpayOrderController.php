<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VnpayOrder; // Đảm bảo đã tạo model cho bảng vnpay_orders
use Carbon\Carbon; // Nếu bạn cần xử lý ngày tháng
use Illuminate\Support\Facades\Session;
use App\Models\Order;


class VnpayOrderController extends Controller
{
    public function index(Request $request)
    {
        // Kiểm tra nếu có từ khóa tìm kiếm trong URL
        $search = $request->input('search');

        // Lọc các đơn hàng VNPay theo từ khóa tìm kiếm và phân trang
        $vnpayOrders = VnpayOrder::when($search, function ($query, $search) {
            return $query->where('vnpay_orders_id', 'like', "%{$search}%")
                ->orWhere('transaction_code', 'like', "%{$search}%");
        })->paginate(10); // 10 là số lượng đơn hàng mỗi trang

        // Trả về view với dữ liệu đã phân trang
        return view('admin.pages.trans_verifi', compact('vnpayOrders'));
    }


    public function showDetails($vnpay_id)
    {
        // Lấy thông tin chi tiết của đơn hàng VNPay theo vnpay_id
        $vnpayOrder = VnpayOrder::where('vnpay_id', $vnpay_id)->first();

        // Kiểm tra xem có dữ liệu không
        if (!$vnpayOrder) {
            return redirect()->route('vnpay.index')->with('error', 'Transaction not found!');
        }

        // Trả về view với dữ liệu đơn hàng VNPay
        return view('admin.pages.trans_verifi_details', compact('vnpayOrder'));
    }



    public function vnpay_payment($order_id)
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

        // Tạo mã đơn hàng ngẫu nhiên
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.return');
        $vnp_TmnCode = "DII1D8KA"; // Mã website tại VNPAY 
        $vnp_HashSecret = "QI3W2HVVADMKGLKCKRS7KT2T5I1PBJXP"; // Chuỗi bí mật

        $vnp_TxnRef = $order_id;
        $vnp_OrderInfo = 'Order payment for Gamer Oasis';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = round($totalInUSD * 100);
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = request()->ip();

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
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect()->away($vnp_Url);
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

        // Lấy order_id từ VNPAY trả về
        $order_id = $request->input('vnp_TxnRef'); // Lấy order_id trả về từ VNPAY

        // Lưu thông tin vào bảng vnpay_orders
        $vnpayOrder = new VnpayOrder();
        $vnpayOrder->vnpay_id = $request->input('vnp_TransactionNo'); // Mã giao dịch từ VNPAY
        $vnpayOrder->vnpay_orders_id = $order_id; // Lưu order_id trả về từ VNPAY
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

        // Cập nhật bảng orders với vnpay_orders_id
        $order = Order::where('order_id', $request->input('vnp_TxnRef'))->first();
        if ($order) {
            $order->vnpay_orders_id = $vnpayOrder->vnpay_orders_id; // Gán vnpay_orders_id vào đơn hàng
            $order->save(); // Lưu lại vào bảng orders
        }

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
        $vnpayOrder->vnpay_orders_id = $request->input('order_id');
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
