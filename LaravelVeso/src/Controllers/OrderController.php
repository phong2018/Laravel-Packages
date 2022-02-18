<?php

namespace Phonglg\LaravelVeso\Controllers; 
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Phonglg\LaravelVeso\Events\PaidOrderSuccess;
use Phonglg\LaravelVeso\Helpers\TraditionalTicket;
use Phonglg\LaravelVeso\Helpers\Vietlott;
use Phonglg\LaravelVeso\Models\Order;
use Phonglg\LaravelVeso\Models\Orderdetail;
use Phonglg\LaravelVeso\Models\Vesoproduct;
use Phonglg\LaravelVeso\Rules\CheckTicket;
use Phonglg\LaravelVeso\Rules\ValidBank;
use Illuminate\Support\Facades\Gate;
use Phonglg\LaravelVeso\Services\VesoProductServices;
use Phonglg\LaravelVnPay\Helpers\Banks;

class OrderController extends Controller
{ 
    // store order
    public function store(Request $request){ 
        $refundTicktes=TraditionalTicket::getCartRefundTicket();

        $cartTotal=str_replace(',','',Cart::total())-$refundTicktes[0];
        $this->validateOrder($request,$cartTotal); 

        $cart= Cart::content();  
        $bank_code=$request->bank_code;
        
        if($cartTotal>0)
            $bankTransferFee=Banks::caculateBankFee($cartTotal,$bank_code);
        else{// cartTotal==0
            $bankTransferFee=0;
            $bank_code=config('laravelvnpay.banks.THANTAI39.id');
        }
        // add order
        
        $fields=array(
            'userId'=>Auth::id(),
            'fullname'=>$request->name,
            'notes'=>$request->notes,
            'bank_code'=>$bank_code,
            'bank_transfer_fee'=>$bankTransferFee,
            'phone_number'=>$request->phone_number,
            'currency'=>'Đ',
            'status'=>config('laravelveso.orderStatus.pendding.key'),// pendding 
            'type'=>config('laravelveso.orderTypes.buyLottery.key'), // buyLottery
            'total'=>$cartTotal+$bankTransferFee, 
        );    
        // dd($fields);
        $order=Order::create($fields); 
        Auth::user()->update(['temp_data'=>json_encode($refundTicktes[3])]);
        // add orderDetail
        foreach($cart as $row) {
            $fields=array(
                'order_id'=>$order->id,
                'details'=>$row->options->toJson(),
                'category'=>$row->options['category'],
                'agency_id'=>(isset($row->options['agency_id']))?$row->options['agency_id']:0,
                'quantity'=>$row->qty, 
                'status'=>config('laravelveso.orderDetailStatus.pendding.key'),
                'quantity_refund'=>-1,
                'price'=>$row->price, 
            );  
            Orderdetail::create($fields); 
        }  
        // destroy cart
        Cart::destroy(); 
        
        // handle payment: have 2 type: use Point || Vnpay
        if($order->bank_code==config('laravelvnpay.banks.THANTAI39.id')){ //banks.0: THANTAI39 
            // update point for user
            $newPoints=$order->user->point - $order->total; 
            $log=config('laravelauth.userLogAction.minusPointsToBuyTicket').': '.number_format($order->total).'Đ. Số tiền hiện tại trong Ví:  '.number_format($newPoints).'Đ';
            Vietlott::updatePointForCustomer($order->user,$newPoints,$log);
            Vietlott::updatePointInfoForCustomer($order->user,$order->total,config('laravelveso.pointInfo.pointBuyTicket.key')); 
            // call event PaidOrderSuccess 
            
            event(new PaidOrderSuccess($order->id)); 
            
            return redirect()->route('customer.order.show',['order'=>$order])->with('message','Thanh toán hóa đơn thành công.');
        }
        else // redirect to vnpay_payOrder 
            return redirect()->route('order.vnpay_payOrder',['order'=>$order]);

        // return redirect()->route('customer.order');

    } 

    // vnpay_payOrder: vnpay_create_payment url to sent to VNPay
    public function vnpay_payOrder(Order $order ){ 
        
        date_default_timezone_set('Asia/Ho_Chi_Minh'); 
        $vnp_TmnCode = config('laravelvnpay.vnp_TmnCode'); //Website ID in VNPAY System
        $vnp_HashSecret = config('laravelvnpay.vnp_HashSecret'); //Secret key
        $vnp_Url = config('laravelvnpay.vnp_Url'); 
        $vnp_Returnurl = config('laravelvnpay.vnp_Returnurl');  
        $vnp_apiUrl = config('laravelvnpay.vnp_apiUrl');  
        $startTime = date("YmdHis");
        $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

        // handle vnpay_create_payment
        $vnp_TxnRef = $order->id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $orderTypes=config('laravelveso.orderTypes'); 
        // get OrderInfo buyLottery/buyLottery
        if($order->type==$orderTypes['buyLottery']['key']) //buyLottery
        $vnp_OrderInfo = $order->fullname.' thanh toán mua vé số '.$order->total.$order->currency;
        if($order->type==$orderTypes['buyPoint']['key']) //buyPoint
        $vnp_OrderInfo = $order->fullname.' thanh toán nạp tiền '.$order->total.$order->currency;

        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $order->total * 100;
        $languages=config('laravelvnpay.languages');
        $vnp_Locale =$languages[0][0];
        $vnp_BankCode = $order->bank_code;
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        $vnp_ExpireDate = $expire;
        //Billing
        $vnp_Bill_Mobile = $order->phone_number;
        $fullName = $order->fullname;
        $vnp_Bill_State='';
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
        ); 
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
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

        header('Location: ' . $vnp_Url);
        die();
 
    } 
     
    // checkout succes
    public function success()
    {
        return view('laravelveso::order.success');
    }

    public function vnpay_return(){
        $order=Order::find($_GET['vnp_TxnRef']);
        
        // dump($_GET);
        // dump($order);
        // die('hello');

        if(!$order) 
            return redirect()->route('notFound')->with('error','Không tìm thấy giao dịch!'); 
        else
            if($order->type==config('laravelveso.orderTypes.buyLottery.key'))
                if($_GET['vnp_ResponseCode']== '00')
                    return redirect()->route('customer.order.show',['order'=>$order])->with('message','Thanh toán hóa đơn thành công.');
                else 
                    return redirect()->route('customer.order.show',['order'=>$order])->with('error','Thanh toán hóa đơn Không thành công.'); 
            else 
                if($_GET['vnp_ResponseCode']== '00')
                    return redirect()->route('point.show',['order'=>$order])->with('message','Thanh toán hóa đơn thành công.');
                else 
                    return redirect()->route('point.show',['order'=>$order])->with('error','Thanh toán hóa đơn Không thành công.'); 

        // dump($order);
        // dump($_GET);
        // dd($_GET['vnp_TxnRef']);
        // return view('laravelveso::order.vnpay_return');
    }  

    // validateOrder
    public function validateOrder($request,$cartTotal){  
        $request->validate([
            'name'=> 'required|min:5|max:256', 
            'bank_code'=>[new ValidBank(['cartTotal'=>$cartTotal])],
            'notes'=> 'min:0|max:50',
            'phone_number' => 'required|digits_between:1,11',
            'errForTickets'=>[new CheckTicket]
        ]);

    }

    // uploadFileOrderDetail
    public function uploadFileOrderDetail(Request $request){

        $orderDetail=Orderdetail::find($request->orderDetailId);
        // right admin-updateOrderDetail || (agency-updateOrderDetail for traditional ticket create)
        if ( (!Gate::allows('admin-updateOrderDetail')) && (!Gate::allows('agency-updateOrderDetail',$orderDetail))){
            abort(403);    
        } 
        
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:8048'
        ]); 
 
         if($request->file()) {
            // delete old image
            $images=json_decode($orderDetail->images);
            if(isset($images[0])) unlink(storage_path('app/public/'.$images[0]));
            // add new image
            $fileName = $orderDetail->id.'-'.time();
            $dirPath = 'photos/'.Auth::id().'/'.$orderDetail->order_id; 
            // upload file
            $filePath = $request->file('file')->storeAs($dirPath, $fileName, 'public');
            $images=[$filePath];
            // update images for orderDetails
            $orderDetail->update(['images'=>json_encode($images)]);  
            
            return [$filePath];
         }
    }

}