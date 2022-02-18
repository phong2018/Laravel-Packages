<?php

namespace Phonglg\LaravelVnPay\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Log;

// this from demo
class VnpayController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 
    // form index to click Payment
    public function index()
    {  
        return view('laravelvnpay::index');
    }

    // vnpay_create_payment sent to VNPay
    public function vnpay_create_payment(Request $request){
        // read more: https://sandbox.vnpayment.vn/apis/docs/huong-dan-tich-hop/
        // config
        date_default_timezone_set('Asia/Ho_Chi_Minh'); 
        $vnp_TmnCode = config('laravelvnpay.vnp_TmnCode'); //Website ID in VNPAY System
        $vnp_HashSecret = config('laravelvnpay.vnp_HashSecret'); //Secret key
        $vnp_Url = config('laravelvnpay.vnp_Url'); 
        $vnp_Returnurl = config('laravelvnpay.vnp_Returnurl');  
        $vnp_apiUrl = config('laravelvnpay.vnp_apiUrl');  
        $startTime = date("YmdHis");
        $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

        // handle vnpay_create_payment
        $vnp_TxnRef = $_POST['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = $_POST['order_desc'];
        $vnp_OrderType = $_POST['order_type'];
        $vnp_Amount = $_POST['amount'] * 100;
        $vnp_Locale = $_POST['language'];
        $vnp_BankCode = $_POST['bank_code'];
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        $vnp_ExpireDate = $_POST['txtexpire'];
        //Billing
        $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
        $vnp_Bill_Email = $_POST['txt_billing_email'];
        $fullName = trim($_POST['txt_billing_fullname']);
        if (isset($fullName) && trim($fullName) != '') {
            $name = explode(' ', $fullName);
            $vnp_Bill_FirstName = array_shift($name);
            $vnp_Bill_LastName = array_pop($name);
        }
        $vnp_Bill_Address=$_POST['txt_inv_addr1'];
        $vnp_Bill_City=$_POST['txt_bill_city'];
        $vnp_Bill_Country=$_POST['txt_bill_country'];
        $vnp_Bill_State=$_POST['txt_bill_state'];
        // Invoice
        $vnp_Inv_Phone=$_POST['txt_inv_mobile'];
        $vnp_Inv_Email=$_POST['txt_inv_email'];
        $vnp_Inv_Customer=$_POST['txt_inv_customer'];
        $vnp_Inv_Address=$_POST['txt_inv_addr1'];
        $vnp_Inv_Company=$_POST['txt_inv_company'];
        $vnp_Inv_Taxcode=$_POST['txt_inv_taxcode'];
        $vnp_Inv_Type=$_POST['cbo_inv_type'];
        $inputData = array(
            // require
            "vnp_Version" => "2.1.0",
            "vnp_Command" => "pay",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef, // Mã tham chiếu của giao dịch tại hệ thống của merchant. Mã này là duy nhất dùng để phân biệt các đơn hàng gửi sang VNPAY. Không được trùng lặp trong ngày. Ví dụ: 23554
            // Not require
            "vnp_Bill_Fullname"=> $fullName,
            "vnp_Bill_Mobile"=>$vnp_Bill_Mobile,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ExpireDate"=>$vnp_ExpireDate,

            // "vnp_Inv_Phone"=>$vnp_Inv_Phone,
            // "vnp_Bill_Email"=>$vnp_Bill_Email,
            // "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
            // "vnp_Bill_LastName"=>$vnp_Bill_LastName,
            // "vnp_Bill_Address"=>$vnp_Bill_Address,
            // "vnp_Bill_City"=>$vnp_Bill_City,
            // "vnp_Bill_Country"=>$vnp_Bill_Country,
            // "vnp_Inv_Email"=>$vnp_Inv_Email,
            // "vnp_Inv_Customer"=>$vnp_Inv_Customer,
            // "vnp_Inv_Address"=>$vnp_Inv_Address,
            // "vnp_Inv_Company"=>$vnp_Inv_Company,
            // "vnp_Inv_Taxcode"=>$vnp_Inv_Taxcode,
            // "vnp_Inv_Type"=>$vnp_Inv_Type 
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
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            } 
    }

    // vnpay_return
    public function vnpay_return(){ 
        return view('laravelvnpay::vnpay_return'); 
    }

    // vnpay_ipn
    public function vnpay_ipn(){
        Log::debug('VnpayController: update Order form VNPay1');
        /* Payment Notify
        * IPN URL: Ghi nhận kết quả thanh toán từ VNPAY
        * Các bước thực hiện:
        * Kiểm tra checksum 
        * Tìm giao dịch trong database
        * Kiểm tra số tiền giữa hai hệ thống
        * Kiểm tra tình trạng của giao dịch trước khi cập nhật
        * Cập nhật kết quả vào Database
        * Trả kết quả ghi nhận lại cho VNPAY
        */

        // config
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
        

        $Status = 0; // Là trạng thái thanh toán của giao dịch chưa có IPN lưu tại hệ thống của merchant chiều khởi tạo URL thanh toán.
        $orderId = $inputData['vnp_TxnRef'];

        try {
            //Check Orderid    
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId            
                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
                //Giả sử: $order = mysqli_fetch_assoc($result);   

                $order = [
                    'Amount' => $vnp_Amount,
                    'status' => 0
                ];
                
                if ($order != NULL) {
                    Log::debug('VnpayController: update Order form VNPay2');

                    if($order["Amount"] == $vnp_Amount) //Kiểm tra số tiền thanh toán của giao dịch: giả sử số tiền kiểm tra là đúng. //$order["Amount"] == $vnp_Amount
                    {
                        Log::debug('VnpayController: update Order form VNPay3'); 

                        if ($order["status"] !== NULL && $order["status"] == 0) {
                            
                            if ($vnp_ResponseCode == '00' || $vnp_TransactionStatus == '00') {
                                $Status = 1; // Trạng thái thanh toán thành công
                            } else {
                                $Status = 2; // Trạng thái thanh toán thất bại / lỗi
                            }
                            //Cài đặt Code cập nhật kết quả thanh toán, tình trạng đơn hàng vào DB
                            //
                            Log::debug('VnpayController: update Order form VNPay4');
                            //
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
        //Trả lại VNPAY theo định dạng JSON
        Log::debug('VnpayController: update Order form VNPay5',$returnData);
        echo json_encode($returnData);

    }

    // vnpay_query
    public function vnpay_query(){ 
        /*
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */
        // get config
        date_default_timezone_set('Asia/Ho_Chi_Minh'); 
        $vnp_TmnCode = config('laravelvnpay.vnp_TmnCode'); //Website ID in VNPAY System
        $vnp_HashSecret = config('laravelvnpay.vnp_HashSecret'); //Secret key
        $vnp_Url = config('laravelvnpay.vnp_Url'); 
        $vnp_Returnurl = config('laravelvnpay.vnp_Returnurl');  
        $vnp_apiUrl = config('laravelvnpay.vnp_apiUrl');  
        $startTime = date("YmdHis");
        $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

        // handle vnpay_return 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $orderid = $_POST["orderid"];
            $hashSecret = $vnp_HashSecret;
            $ipaddr = $_SERVER['REMOTE_ADDR'];
            $inputData = array(
                "vnp_Version" => '2.1.0',
                "vnp_Command" => "querydr",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_TxnRef" => $orderid,
                "vnp_OrderInfo" => 'Noi dung thanh toan',
                "vnp_TransDate" => $_POST['paymentdate'],
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_IpAddr" => $ipaddr
            );
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

            $vnp_apiUrl = $vnp_apiUrl . "?" . $query;
            if (isset($hashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                $vnp_apiUrl .= 'vnp_SecureHash=' . $vnpSecureHash;
            } 
            
            $ch = curl_init($vnp_apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $data = curl_exec($ch);
            curl_close($ch);
            dd($data);
        }
        return view('laravelvnpay::vnpay_query');
    }

    // vnpay_query_form
    public function vnpay_query_form(){
        return view('laravelvnpay::vnpay_query');
    }

    // vnpay_refund
    public function vnpay_refund(){
        // get config
        date_default_timezone_set('Asia/Ho_Chi_Minh'); 
        $vnp_TmnCode = config('laravelvnpay.vnp_TmnCode'); //Website ID in VNPAY System
        $vnp_HashSecret = config('laravelvnpay.vnp_HashSecret'); //Secret key
        $vnp_Url = config('laravelvnpay.vnp_Url'); 
        $vnp_Returnurl = config('laravelvnpay.vnp_Returnurl');  
        $vnp_apiUrl = config('laravelvnpay.vnp_apiUrl');  
        $startTime = date("YmdHis");
        $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

        // handle vnpay_return
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $amount = ($_POST["amount"]) * 100;
            $ipaddr = $_SERVER['REMOTE_ADDR'];
            $inputData = array(
                "vnp_Version" => '2.1.0',
                "vnp_TransactionType" => $_POST["trantype"],
                "vnp_Command" => "refund",
                "vnp_CreateBy" => $_POST["mail"],
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_TxnRef" => $_POST["orderid"],
                "vnp_Amount" => $amount,
                "vnp_OrderInfo" => 'Noi dung thanh toan',
                "vnp_TransDate" => $_POST['paymentdate'],
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_IpAddr" => $ipaddr
            );
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

            $vnp_apiUrl = $vnp_apiUrl . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                $vnp_apiUrl .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $ch = curl_init($vnp_apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $data = curl_exec($ch);
            curl_close($ch);
            echo $data; 
        }
        return view('laravelvnpay::vnpay_refund');
    } 

    // vnpay_refund_form
    public function vnpay_refund_form(){
        return view('laravelvnpay::vnpay_refund');
    }   
 
}
