<?php

namespace Phonglg\LaravelVnPay\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelAuth\Models\UserLog;
use Phonglg\LaravelVeso\Events\PaidOrderSuccess; 
use Phonglg\LaravelVeso\Models\Order;
use Phonglg\LaravelVeso\Models\Orderdetail;

class VnpayinpController extends Controller
{ 
    // vnpay_ipn
    public function vnpay_ipn(){
        // http://127.0.0.1/vnpay_ipn?vnp_Amount=1210000&vnp_BankCode=NCB&vnp_BankTranNo=20211102132653&vnp_CardType=ATM&vnp_OrderInfo=le+phong3+thanh+to%C3%A1n+mua+v%C3%A9+s%E1%BB%91+12100.00%C4%90&vnp_PayDate=20211102132648&vnp_ResponseCode=00&vnp_TmnCode=KRQQ6XRU&vnp_TransactionNo=13617620&vnp_TransactionStatus=00&vnp_TxnRef=26&vnp_SecureHash=85bf19e3a03d531dec185de6d2bd45a4ecc99395a5910566bffa426cf21158217517da3e5b222ece63bda74040e2fbf35458b1a8c101cdf3ef4cd50ec308dcf5
        // Log::debug('VnpayController: update Order form VNPay1'); 

        date_default_timezone_set('Asia/Ho_Chi_Minh'); 
        $vnp_TmnCode = config('laravelvnpay.vnp_TmnCode'); //Website ID in VNPAY System
        $vnp_HashSecret = config('laravelvnpay.vnp_HashSecret'); //Secret key
        $vnp_Url = config('laravelvnpay.vnp_Url'); 
        $vnp_Returnurl = config('laravelvnpay.vnp_Returnurl');  
        $vnp_apiUrl = config('laravelvnpay.vnp_apiUrl');  
        $startTime = date("YmdHis");
        $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));
        
        // handle vnpay_ipn
        $inputData = array();
        $returnData = array();
        foreach ($_GET as $key => $value) {
                    if (substr($key, 0, 4) == "vnp_") {
                        $inputData[$key] = $value;
                    }
                }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $vnp_Amount = $inputData['vnp_Amount']/100; // Số tiền thanh toán VNPAY phản hồi
        $vnp_ResponseCode=$inputData['vnp_ResponseCode'];
        $vnp_TransactionStatus=$inputData['vnp_TransactionStatus'];
        
        $orderStatus=config('laravelveso.orderStatus'); 
        $status = $orderStatus['pendding']['key']; // pendding Là trạng thái thanh toán của giao dịch chưa có IPN lưu tại hệ thống của merchant chiều khởi tạo URL thanh toán.
        $orderId = $inputData['vnp_TxnRef'];

        try {
            //Check Orderid    
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId            
                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
                //Giả sử: $order = mysqli_fetch_assoc($result);   

                $order = Order::find($orderId);
                
                if ($order != NULL) {
                    // Log::debug('VnpayController: update Order form VNPay2');

                    if($order->total == $vnp_Amount) //Kiểm tra số tiền thanh toán của giao dịch: giả sử số tiền kiểm tra là đúng. //$order["Amount"] == $vnp_Amount
                    {
                        //Log::debug('VnpayController: update Order form VNPay3',$orderStatus); 

                        if ($order->status == $orderStatus['pendding']['key']) { // pendding  
                            
                            if ($vnp_ResponseCode == '00' || $vnp_TransactionStatus == '00') {
                                // Trạng thái thanh toán thành công (đã thanh toán)
                                $status=$orderStatus['paid']['key'];// successs: payment success
                                
                            } else {
                                // Trạng thái thanh toán thất bại / lỗi
                                $status=$orderStatus['failure']['key']; //failure payment failure
                            }

                            //Cài đặt Code cập nhật kết quả thanh toán, tình trạng đơn hàng vào DB
                            // Log::debug('VnpayController: update Order form VNPay4');
                            if($status==$orderStatus['paid']['key']){ // if success -> call event PaidOrderSuccess
                                $log=config('laravelauth.userLogAction.payByVnPaySuccess').': '. number_format($order->total).'Đ';
                                UserLog::create(['userId'=>$order->userId,'log'=>$log]);
                                
                                event(new PaidOrderSuccess($orderId));
                            }
                            else $order->update(['status'=>$status]);// failure 
                            //dd('2:',$orderStatus,$status, $vnp_ResponseCode, $vnp_TransactionStatus);

                            //Trả kết quả về cho VNPAY: Website/APP TMĐT ghi nhận yêu cầu thành công                
                            $returnData['RspCode'] = '00';
                            $returnData['Message'] = 'Confirm Success';
                        } else { 
                            $returnData['RspCode'] = '02';
                            $returnData['Message'] = 'Order already confirmed';
                        }
                    }
                    else {
                        $returnData['RspCode'] = '04';
                        $returnData['Message'] = 'invalid amount';
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Invalid signature';
            }
        } catch (Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
 
        // Trả lại VNPAY theo định dạng JSON
        // Log::debug('VnpayController: update Order form VNPay5',$returnData);
        echo json_encode($returnData);

    }

   
}
