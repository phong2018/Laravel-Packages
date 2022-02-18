<?php

namespace Phonglg\LaravelVeso\Controllers\Admin;

use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Gate; 
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelVeso\Helpers\Vietlott;
use Phonglg\LaravelVeso\Models\Point;
use Phonglg\LaravelVeso\Models\Order;
use Phonglg\LaravelVeso\Services\OrderServices;
use Phonglg\LaravelVeso\Services\StatisticalServices;
use Illuminate\Support\Facades\Auth;
use Phonglg\LaravelAuth\Models\UserLog;
use Phonglg\LaravelLayout\Helpers\InputForm;
use Phonglg\LaravelSetting\Helpers\SettingHelper;
use Phonglg\LaravelUserRole\Models\Customer;
use Phonglg\LaravelVeso\Helpers\LockPoint;
use Phonglg\LaravelVeso\Helpers\TraditionalTicket;
use Phonglg\LaravelVeso\Models\Vesoproduct;

class AdminPointController extends Controller
{   
    use AuthorizesRequests;

    public function __construct()
    {
        // Authorizing Resource Controllers
       $this->authorizeResource(Point::class, 'order');
    }

    // list point of Order
    public function index(Request $request, StatisticalServices $services, OrderServices $orderService){    

        $data=array(); 
        $data['invoiceStatistics']=$services->getInvoiceStatisticsData($request);
        $data['payments']=InputForm::getPayments();
        $data['orderTypes']=InputForm::getOrderTypes();
        // get order
        $orders=$orderService->filterOnlyDate($data);  
        // filter buyPoint & withdrawPoint
        $temp='';

        $orders=$orders->where(function($q)use ($temp){
            $q->where('type',config('laravelveso.orderTypes.buyPoint.key'));
            $q->orwhere('type',config('laravelveso.orderTypes.withdrawPoint.key')); 
        }); 

        // fileter payment
        if(isset($request->payment))  $data['payment']=$request->payment;
        else $data['payment']=''; 

        if($data['payment']){ 
            if($data['payment']==config('laravelvnpay.banks.COD.id'))
            $orders=$orders->where('bank_code',$data['payment']);
            else $orders=$orders->where('bank_code','!=',config('laravelvnpay.banks.COD.id'));
        }

        // fileter orderTypes
        if(isset($request->orderType))  $data['orderType']=$request->orderType;
        else $data['orderType']=''; 
        if($data['orderType']) $orders=$orders->where('type',$data['orderType']); 

        $orders=$orders->get();
        // handle statisticsOrder
        $data['statisticsOrders']=$orderService->statisticsOrdersPointData($orders);  

        $data['actionInvoiceStatistics']=route('admin.point'); 
        // dd($orders);
        return view('laravelveso::adminPoint.list',['orders'=>$orders,'data'=>$data]);      
    }
    
    // list point of Customer
    public function show(Point $order){     
        
        $data=[
            'blocks'=>config('laravelhtmldomparser.blocks'),
            'methodsToPlay'=> config('laravelhtmldomparser.methodsToPlay'),
            'methodsToPlayKeno'=>config('laravelhtmldomparser.methodsToPlayKeno'),
            'total'=>$order->total ,
            'orderId'=>$order->id ,
            'dateAdded'=>$order->created_at,
            'orderType'=>$order->type,
            'bank_transfer_fee'=> $order->bank_transfer_fee,
            'orderStatusLabel'=> config('laravelveso.orderStatus.'.$order->status.'.label'),
            'orderStatus'=>$order->status,
            'customerInfo'=>$order->fullname.' - SĐT: '.$order->phone_number,
            'bankInfo'=>User::find($order->userId)->bank_info,
            'tempRefundTotal'=>0,
            'updateOrderAddPoint'=>route('admin.updateOrderAddPoint'),
            'updateOrderWithdrawPoint'=>route('admin.updateOrderWithdrawPoint')
        ];   
        
        if($order->type==config('laravelveso.orderTypes.buyPoint.key'))  
            return view('laravelveso::adminPoint.show',['data'=>$data]); 
        else return view('laravelveso::adminPoint.showWithdraw',['data'=>$data]);  
        
    } 

    // updateOrderWithdrawPoint use Axios
    public function updateOrderWithdrawPoint(Request $request)
    { 
        if (! Gate::allows('admin-updateOrderAddPoint')) abort(403);

        $request->validate([
            'orderId'=>'required',  
            'status'=>'required',  
        ]);  

        $order=Order::find($request->orderId);

        $order->update(['status'=>$request->status]);  
    
        // submit withdraw point success 
        if($request->status==config('laravelveso.orderStatus.paid.key')){    
            $pointWithdraw=$order->total;
            $newPoint=$order->user->point - $pointWithdraw; 
            $log=config('laravelauth.userLogAction.withdrawPointsSuccess').': '.number_format($pointWithdraw).'Đ. Số tiền hiện tại trong Ví:  '.number_format($newPoint).'Đ';
            Vietlott::updatePointForCustomer($order->user,$newPoint,$log);
            Vietlott::updatePointInfoForCustomer($order->user,$pointWithdraw,config('laravelveso.pointInfo.pointWithdraw.key')); 
        }
            
        // cancel withdraw point
        if($request->status==config('laravelveso.orderStatus.pendding.key')){ 
            $pointWithdraw=$order->total;
            $newPoint=$order->user->point + $pointWithdraw; 
            $log=config('laravelauth.userLogAction.cancelWithdrawPoints').': '.number_format($pointWithdraw).'Đ. Số tiền hiện tại trong Ví:  '.number_format($newPoint).'Đ';
            Vietlott::updatePointForCustomer($order->user,$newPoint,$log);
            Vietlott::updatePointInfoForCustomer($order->user,-$pointWithdraw,config('laravelveso.pointInfo.pointWithdraw.key')); 
        }   
          
        return [$order->user->point];
    }  

    // updateOrderAddPoint use Axios
    public function updateOrderAddPoint(Request $request)
    { 
        if (! Gate::allows('admin-updateOrderAddPoint')) abort(403);

        $request->validate([
            'orderId'=>'required',  
            'status'=>'required',  
        ]);  

        $order=Order::find($request->orderId);

        $checkLockPoint=LockPoint::checkLockPointUsers([$order->user]);


        if($checkLockPoint) return ['error'=>'Server đang bận thử lại sau 1 phút'];

        $order->update(['status'=>$request->status]);  
        $customer=User::find($order->user->id);
    
        // submit buy point success 
        if($request->status==config('laravelveso.orderStatus.paid.key')){    
            $pointAdd=$order->total-$order->bank_transfer_fee;
            $newPoint=$customer->point + $pointAdd; 
            $log=config('laravelauth.userLogAction.addPointsSuccess').': '.number_format($pointAdd).'Đ. Số tiền hiện tại trong Ví:  '.number_format($newPoint).'Đ';
            Vietlott::updatePointForCustomer($customer,$newPoint,$log);
            Vietlott::updatePointInfoForCustomer($customer,$pointAdd,config('laravelveso.pointInfo.pointAdd.key')); 
        }
            
        // cancel buy point
        if($request->status==config('laravelveso.orderStatus.pendding.key')){ 
            $pointSubtract=$order->total-$order->bank_transfer_fee;
            $newPoint=$customer->point - $pointSubtract; 
            $log=config('laravelauth.userLogAction.cancelAddPoints').': '.number_format($pointSubtract).'Đ. Số tiền hiện tại trong Ví:  '.number_format($newPoint).'Đ';
            Vietlott::updatePointForCustomer($customer,$newPoint,$log);
            Vietlott::updatePointInfoForCustomer($customer,-$pointSubtract,config('laravelveso.pointInfo.pointAdd.key')); 
        }   
          
        LockPoint::unLockPointUsers([$customer]);
        return [$customer->point];
    }

    // indexOrderWithdrawPointAccumulate
    public function indexOrderWithdrawPointAccumulate(Request $request){
        
        if (! Gate::allows('admin-updateOrderAddPoint')) abort(403);

        $data['ordersAccumulatePoint']=Order::orderBy('id','DESC')
        ->where('type',config('laravelveso.orderTypes.withdrawAccumulatePoint.key'))
        ->paginate(20);

        $template=Vietlott::getLayoutForUser(); 
   
        return view('laravelveso::adminPoint.indexOrderWithdrawPointAccumulate',['data'=>$data,'template'=>$template]);  
    }

    // updateOrderWithdrawPointAccumulate
    public function updateOrderWithdrawPointAccumulate(Request $request)
    { 
        if (! Gate::allows('admin-updateOrderAddPoint')) abort(403);

        $request->validate([
            'orderId'=>'required',  
            'status'=>'required',  
        ]);  

        $order=Order::find($request->orderId);
    
        // submit withdraw point success 
        if($request->status==config('laravelveso.orderStatus.success.key')
            && $request->status!=$order->status){    
            $order->update(['status'=>$request->status]);  
            $customer=$order->user;
            $newAccumulatePointCustomer=$customer->accumulate_point - $order->total;
            $typeLog=config('laravelauth.userLogAction.withDrawAccumulatedPoint'); 
            $log=$typeLog.' '.number_format($order->total).'Đ. Số điểm hiện tại trong Ví tích lũy:  '.number_format($newAccumulatePointCustomer).'Đ'; 
            TraditionalTicket::updateAccumulatePoint($customer,$newAccumulatePointCustomer,$log);
        }
            
        // cancel withdraw point
        if($request->status==config('laravelveso.orderStatus.failure.key')
            && $request->status!=$order->status){ 
            if($order->status==config('laravelveso.orderStatus.success.key')){
                $customer=$order->user;
                $newAccumulatePointCustomer=$customer->accumulate_point + $order->total;
                $typeLog=config('laravelauth.userLogAction.cancelWithDrawAccumulatedPoint'); 
                $log=$typeLog.' '.number_format($order->total).'Đ. Số điểm hiện tại trong Ví tích lũy:  '.number_format($newAccumulatePointCustomer).'Đ'; 
                TraditionalTicket::updateAccumulatePoint($customer,$newAccumulatePointCustomer,$log);
            }

            $order->update(['status'=>$request->status]);  
            
        }   

        //dd($request,config('laravelveso.orderStatus.failure.key'));
           
        return redirect()->back()->with('message','Cập nhật trạng thái rút điểm thành công.');
    }  

}