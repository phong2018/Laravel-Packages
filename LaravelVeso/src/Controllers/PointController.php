<?php

namespace Phonglg\LaravelVeso\Controllers; 
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Phonglg\LaravelAuth\Models\UserLog;
use Phonglg\LaravelLayout\Helpers\NumberHelper;
use Phonglg\LaravelSetting\Helpers\SettingHelper;
use Phonglg\LaravelVeso\Helpers\TraditionalTicket;
use Phonglg\LaravelVnPay\Helpers\Banks;
use Phonglg\LaravelVeso\Models\Order;
use Phonglg\LaravelVeso\Models\Orderdetail;

class PointController extends Controller
{  
    // add Point
    public function index(){           
        // get list addPoint
        $data['ordersAddPoint']=Order::orderBy('id','DESC')
        ->where('type',config('laravelveso.orderTypes.buyPoint.key'))
        ->where('userId',Auth::id())
        ->paginate(20);

        $data['ordersWithdrawPoint']=Order::orderBy('id','DESC')
        ->where('type',config('laravelveso.orderTypes.withdrawPoint.key'))
        ->where('userId',Auth::id())
        ->paginate(20);

        // dd($banks);
        return view('laravelveso::point.list',['data'=>$data]);
    }

    // add Point
    public function add(){            

        $data['banks']=[];
        $tempNanks=config('laravelvnpay.banks');  
        foreach($tempNanks as $key=>$val) 
        if($key!=config('laravelvnpay.banks.THANTAI39.id')) $data['banks'][]=(object)$val; 

        $data['banksFee']=config('laravelvnpay.banksFee'); 

        // dd($banks);
        return view('laravelveso::point.add',['data'=>$data]);
    }
    // store order
    public function store(Request $request){ 
       
        $this->validateOrder($request); 
        $request->point=NumberHelper::toNum($request->point);
        // dd($request);
        $cart= Cart::content();  
        // add order
        $bankTransferFee=Banks::caculateBankFee($request->point,$request->bank_code);
        $fields=array(
            'userId'=>Auth::id(),
            'fullname'=>Auth::user()->name,
            'phone_number'=>Auth::user()->username,
            'bank_code'=>$request->bank_code,
            'bank_transfer_fee'=>$bankTransferFee,
            'notes'=>$request->notes,
            'currency'=>'Đ',
            'status'=>config('laravelveso.orderStatus.pendding.key'),// pendding 
            'type'=>config('laravelveso.orderTypes.buyPoint.key'),// buyPoint
            'total'=>$request->point+$bankTransferFee
        );           
        // dd($fields);
        $order=Order::create($fields);    
        // redirect to vnpay_payOrder
        if($order->bank_code!=config('laravelvnpay.banks.COD.id')) // COD
            return redirect()->route('order.vnpay_payOrder',['order'=>$order]);
        else // show page list add Point 
            {
                $messageBankTranfer=SettingHelper::getKey('receivePaymentBankAccount');
                return redirect()->route('point.list')->with(['message'=>'Tạo yêu cầu nạp tiền thành công.','bankMessage'=>$messageBankTranfer,'orderId'=> $order->id]);
            }

        // return redirect()->route('customer.order'); 

    }  

    // withdraw Point
    public function withdraw(){            
   
        return view('laravelveso::point.withdraw');
    } 

    // withdrawStore
    public function withdrawStore(Request $request){ 
        $this->validateOrderWithdraw($request); 
        $request->point=NumberHelper::toNum($request->point);
        // check Point withdraw
        if($request->point>Auth::user()->point)
            return back()->withErrors(['point'=>'Not enought Money to with draw']);
        // save order
        $fields=array(
            'userId'=>Auth::id(),
            'fullname'=>Auth::user()->name,
            'phone_number'=>Auth::user()->username,
            'bank_code'=>config('laravelvnpay.banks.COD.id'),
            'bank_transfer_fee'=>0,
            'notes'=>$request->notes,
            'currency'=>'Đ',
            'status'=>config('laravelveso.orderStatus.pendding.key'),// pendding 
            'type'=>config('laravelveso.orderTypes.withdrawPoint.key'),// withdrawPoint
            'total'=>$request->point
        );            
        $order=Order::create($fields);  
        return redirect()->route('point.list')->with(['messageWithdrawStore'=>'Tạo yêu cầu rút tiền thành công. Yêu cầu của bạn sẽ được xử lý trong vòng 24h.']);
    }

    // withdrawAccumulatePoints
    public function withdrawAccumulatePoint(){    
        
        $data['ordersAccumulatePoint']=Order::orderBy('id','DESC')
        ->where('type',config('laravelveso.orderTypes.withdrawAccumulatePoint.key'))
        ->where('userId',Auth::id())
        ->paginate(20);
   
        return view('laravelveso::point.withdrawAccumulatePoint',['data'=>$data]);


    }
    // withdrawAccumulatePointStore
    public function withdrawAccumulatePointStore(Request $request){ 
        $request->validate([ 
            'notes'=> 'min:1|max:50', 
        ]);

        $request->point=NumberHelper::toNum($request->point);
        // check Point withdraw
        if($request->point>Auth::user()->accumulate_point)
            return back()->withErrors(['point'=>'Not enought Point to with draw']);
        // save order
        $fields=array(
            'userId'=>Auth::id(),
            'fullname'=>Auth::user()->name,
            'phone_number'=>Auth::user()->username,
            'bank_code'=>config('laravelvnpay.banks.COD.id'),
            'bank_transfer_fee'=>0,
            'notes'=>$request->notes,
            'currency'=>'Đ',
            'status'=>config('laravelveso.orderStatus.pendding.key'),// 
            'type'=>config('laravelveso.orderTypes.withdrawAccumulatePoint.key'),// withdrawPoint
            'total'=>$request->point
        );            
        $order=Order::create($fields);   
        // customer 
        // $customer=Auth::user();
        // $newAccumulatePointCustomer=$customer->accumulate_point - $request->point;
        // $typeLog=config('laravelauth.userLogAction.withDrawAccumulatedPoint'); 
        // $log=$typeLog.' '.number_format($request->point).'Đ. Số điểm hiện tại trong Ví tích lũy:  '.number_format($newAccumulatePointCustomer).'Đ'; 
        // TraditionalTicket::updateAccumulatePoint($customer,$newAccumulatePointCustomer,$log);
        //---------
        return redirect()->route('point.withdrawAccumulatePoint')->with(['message'=>'Tạo yêu cầu đổi điểm thành công.']);
    }

    // list point of Customer
    public function show(Order $order){           
        $data=[
            'blocks'=>config('laravelhtmldomparser.blocks'),
            'methodsToPlay'=> config('laravelhtmldomparser.methodsToPlay'),
            'methodsToPlayKeno'=>config('laravelhtmldomparser.methodsToPlayKeno'),
            'total'=>$order->total ,
            'orderId'=>$order->id ,
            'dateAdded'=>$order->created_at,
            'orderType'=>$order->type,
            'bank_transfer_fee'=> $order->bank_transfer_fee,
            'orderStatus'=>config('laravelveso.orderStatus.'.$order->status.'.label'),
            'customerInfo'=>$order->fullname.' - SĐT: '.$order->phone_number,
            'tempRefundTotal'=>0,
            'updateOrderDetail'=>route('admin.updateOrderDetail')
        ];   

        if($order->type==config('laravelveso.orderTypes.buyPoint.key'))  
            return view('laravelveso::point.show',['data'=>$data]); 
        else return view('laravelveso::point.showWithdraw',['data'=>$data]); 
    } 

    // validateOrder
    public function validateOrder($request){
        $request->validate([
            'point'=> 'required', 
            'bank_code'=>'required',
            'notes'=> 'min:0|max:50', 
        ]);
    }

    // validateOrder WithDraw
    public function validateOrderWithdraw($request){
        $request->validate([
            'point'=> 'required',  
            'notes'=> 'min:0|max:50', 
        ]);
    }

     
}