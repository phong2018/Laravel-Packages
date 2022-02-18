<?php

namespace Phonglg\LaravelVeso\Controllers\Admin;

use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request; 
use Phonglg\LaravelVeso\Helpers\ArrayHelper;
use Phonglg\LaravelVeso\Helpers\Vietlott;
use Illuminate\Support\Facades\Gate;
use Phonglg\LaravelVeso\Models\Order;
use Phonglg\LaravelVeso\Models\Orderdetail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelAuth\Models\UserLog;
use Phonglg\LaravelVeso\Helpers\Province;
use Phonglg\LaravelVeso\Models\Ticket;
use Phonglg\LaravelVeso\Models\Vesoproduct;
use Phonglg\LaravelVeso\Services\OrderServices;
use Phonglg\LaravelVeso\Services\StatisticalServices;
use Illuminate\Support\Facades\Notification;
use Phonglg\LaravelLayout\Helpers\InputForm;
use Phonglg\LaravelLayout\Helpers\NumberHelper;
use Phonglg\LaravelUserRole\Models\Customer;
use Phonglg\LaravelVeso\Helpers\LockPoint;
use Phonglg\LaravelVeso\Helpers\TraditionalTicket;
use Phonglg\LaravelVeso\Models\WinPrize;
use Phonglg\LaravelVeso\Notifications\WinPrizeNotifications;
use Phonglg\LaravelVeso\Services\WinPrizeServices;

class AdminOrderController extends Controller
{   
    use AuthorizesRequests;

    public function __construct()
    {
        // Authorizing Resource Controllers
        $this->authorizeResource(Order::class, 'order');
    }

    // list point of Order
    public function index(Request $request, StatisticalServices $services, OrderServices $orderService){    
        $data=array(); 
        $data['invoiceStatistics']=$services->getInvoiceStatisticsData($request);
        $data['actionInvoiceStatistics']=route('admin.order');
        $data['orderType']=config('laravelveso.orderTypes.buyLottery.key');
        // get orders
        $orders=$orderService->filter($data); 
        // dd($orders);
        $tempStatisticsOrders=$orderService->statisticsOrdersData($orders); ;
        $data['totalSaleOrder']=$tempStatisticsOrders[0]; 
        $data['countOrderRefund']=$tempStatisticsOrders[1];
        $data['totalOrderRefund']=$tempStatisticsOrders[2]; 
        
        return view('laravelveso::adminOrder.list',['orders'=>$orders,'data'=>$data]);      
    } 

    // listOrdersSaleVietlott
    public function listOrdersSaleVietlott(){ 
        $orders = Orderdetail::where('category','<>',config('laravelveso.ticketTypes.traditionallottery.key')) 
        ->join('veso_orders', 'veso_orders.id', '=', 'order_id')
        ->selectRaw('veso_orders.id,veso_orders.status,veso_orders.type,veso_orders.bank_transfer_fee,veso_orders.total,veso_orders.created_at')
        ->orderBy('veso_orders.id','DESC')
        ->distinct('veso_orders.id')
        // ->groupBy('order_id')   
        ->paginate(20);

        // dd($orders);
        $template=Vietlott::getLayoutForUser(); 
        return view('laravelveso::customerOrder.list',['orders'=>$orders,'template'=>$template]);      
    }
    
    // list point of Customer
    public function show(Order $order){           
        
        $data=Vietlott::prepareDataShowOrder($order); 

        $orderDetails=Orderdetail::where('order_id',$order->id)->get();
        // dd($orderDetails);
        $items=[]; 
        foreach($orderDetails as $row){ 
            $item=Vietlott::prepareDataShowOrderdetail($row);  
            $items[]=$item;
            // caculate totalRefund
            $data['tempRefundTotal']+=Vietlott::caculateToRefundForDetail($row); 
        }    
        
        $data['provinces']=Province::getProvincesByKey();
        $data['customerId']=$order->userId;

        // dd($data);
        // dd($items);
        return view('laravelveso::adminOrder.show',['cart'=>$items,'data'=>$data]); 
    }  

    // refund all quantity for TraditionalTicket
    public function cancalTicketTraditional($orderDetail){
        $details=json_decode($orderDetail->details);// dd($detail->product_id);
        $vesoProduct=Vesoproduct::find($details->product_id);// dd($vesoProduct); 
        
        // caculate $quantity_refund_rest  for refund
        $quantity_refund_rest=$orderDetail->quantity - $orderDetail->quantity_refund;

        // update quantity_refund for orderDetail (update cancel ticket for orderDetail)    
        $orderDetail->update(['quantity_refund'=>$orderDetail->quantity]);
        
        // update point for Customer, - qty ticket free was reward
        if(isset($details->qtyRefund)){// in this detail has tickets winPrize
            $qtyRefund=$details->qtyRefund;
        } else $qtyRefund=0;

        // update quantity, quantity_sold (online) for productVeso
        $newProductQuantity=$vesoProduct->quantity+$quantity_refund_rest;
        $newQuantitySold=$vesoProduct->quantity_sold-$quantity_refund_rest;
        $newQuantityReward=$vesoProduct->quantity_reward-$qtyRefund;
        $vesoProduct->update(['quantity'=>$newProductQuantity,'quantity_sold'=>$newQuantitySold,'quantity_reward'=>$newQuantityReward]);
        //update add point Refund & ticket refund for customer
        Log::debug('cancalTicketTraditional');
        $pointRefund=$orderDetail->price * ($quantity_refund_rest-$qtyRefund);
        Vietlott::refundPointForCustomer($orderDetail,$pointRefund); 
        Vietlott::refundTicketRewardForCustomer($orderDetail,$vesoProduct,$qtyRefund); 
        // subtract point of agency && presenter
        $totalTicketsBuyTraditional=($quantity_refund_rest-$qtyRefund);
        $order=Order::find($orderDetail->order_id);
        TraditionalTicket::payMoneyForAgency_Presendter($order->user,$orderDetail,$totalTicketsBuyTraditional,-1);
    } 

    // cancelOrderDetail
    public function cancelOrderDetail($orderDetailId){
        // get orderDetail  //192#0
        
        $arrOrderDetailId=(explode("#",$orderDetailId));
        $orderDetailId=$arrOrderDetailId[0];
        $orderDetail=Orderdetail::find($orderDetailId);

        $usersLockPoint=(new OrderServices())->getUsersLockPointByOrderDetail($orderDetail);

        if($usersLockPoint[0]==1){
            Log::debug('Server đang bận thử lại sau 1 phút');
            return ['error'=>'Server đang bận thử lại sau 1 phút'];
        }
        else{ 
            $traditionallottery=config('laravelhtmldomparser.categoryType.traditionallottery.key');

            // handle refund point for traditionallottery
            if($orderDetail->category==$traditionallottery){
                Log::debug('cancelOrderDetail');
                if($orderDetail->quantity_refund<$orderDetail->quantity) 
                $this->cancalTicketTraditional($orderDetail);
            }else{ // handle refund point for vietlott 
                Log::debug('admin cancelOrderDetail:');
                $indexPeridod=$arrOrderDetailId[1];
                $ticketId=$orderDetailId."#".$indexPeridod;
                // if refund -> delete ticket waiting handle in 
                Ticket::where('ticketId', $ticketId)->delete();
                // call cancelTicketVietlott
                Vietlott::cancelTicketVietlott($ticketId);
            } 
            
            LockPoint::unLockPointUsers($usersLockPoint[1]);    
        } 
    }

    // successOrderDetail // dont need using
    public function successOrderDetail($orderDetailId){
        // get orderDetail 
        $orderDetail=Orderdetail::find($orderDetailId);
        $traditionallottery=config('laravelhtmldomparser.categoryType.traditionallottery.key');
        // update quantity_refund
        if($orderDetail->quantity_refund!=0){//not yet success 
            $orderDetail->update(['quantity_refund'=>0]);
        }
        // handle refund point for traditionallottery
        if($orderDetail->category==$traditionallottery){

        }else{ // handle refund point for vietlott
            $details=json_decode($orderDetail->details); 
            
            for($i=0;$i<count($details->periodStatus);$i++) // refund all period
            if($details->periodStatus[$i]!=0){
                $details->periodStatus[$i]=0;
            }
            $orderDetail->update(['details'=>json_encode($details)]); 
        } 
    }

    // repport WinPrize 
    public function reportWinPrizes1(Request $request)
    {    
        $orderdetails= Orderdetail::where('category','traditionallottery')->get();
        foreach($orderdetails as $orderDetail){ 
            $details=json_decode($orderDetail->details); 
            $product=Vesoproduct::find($details->product_id);
            if($product){
                $agency=User::find($product->user_create_id);
                $details->agency=$agency->agency_name;
                $details->agency_id=$agency->id;
                $details->ticket_category=$product->category;
                $orderDetail->update(['details'=>json_encode($details)]);
            }
        }
    }
    // reportWinPrizes
    public function reportWinPrizes(Request $request){ 
       
        
        // DB::statement('START TRANSACTION');
        // $u0=User::lockForUpdate()->find(9); 
        // $u0->name='c6';
        // $u0->save();
        // DB::statement('COMMIT'); 

        $data=Vietlott::prepareDataShowWinPrize(); 
        $data['provinces']=Province::getProvincesByKey();
        $data['invoiceStatistics']=(new StatisticalServices())->getInvoiceStatisticsData($request);
        $data['ticketTypes']= InputForm::getTicketTypes();
        $data['agencies']=Customer::where('role_id',config('laraveluserrole.defaultAgencyRoleId'))->get();
        $template=Vietlott::getLayoutForUser(); 
        $data['actionReport']=route('order.reportWinPrizes');
        $data['updateAllWinPrize']=route('order.updateAllWinPrize');
        

        $winPrizes = WinPrize::orderByDesc('id')
        ->where('prize_date','>=',$data['invoiceStatistics']['fromDate'])
        ->where('prize_date','<=',$data['invoiceStatistics']['toDate']);
        // filter data
        if(isset($request->agency_id))  $data['agency_id']=$request->agency_id;
        else $data['agency_id']='';
        if(isset($request->ticketType))  $data['ticketType']=$request->ticketType;
        else $data['ticketType']=config('laravelveso.ticketTypes.traditionallottery.key');
        // dump($data['ticketType']);

        if($data['agency_id']) $winPrizes= $winPrizes->where('agency_id',$data['agency_id']);
        if($data['ticketType']){
            if($data['ticketType']==config('laravelveso.ticketTypes.traditionallottery.key'))
            $winPrizes= $winPrizes->where('ticket_type',$data['ticketType']);
            else $winPrizes= $winPrizes->where('ticket_type','<>',config('laravelveso.ticketTypes.traditionallottery.key'));
        } 
        
        if(Auth::user()->role_id>config('laraveluserrole.defaultRoleId'))// agency
            $winPrizes= $winPrizes->where('ticket_type',config('laravelveso.ticketTypes.traditionallottery.key'))
                                  ->where('agency_id',Auth::id());

        
        $winPrizes=$winPrizes->get(); 
        $data['totalPointTranfer']=0;
        foreach($winPrizes as $no=>$winPrize){
            $data['totalPointTranfer']+=$winPrize->moneyNeedAddCustomer;
            $data['orderDetais'][$no]=Vietlott::prepareDataShowOrderdetail(Orderdetail::find($winPrize->order_detail_id));
        }

        $template=Vietlott::getLayoutForUser(); 

        return view('laravelveso::adminOrder.reportWinPrizes', ['winPrizes' => $winPrizes,'template'=>$template,'data'=>$data]);    
    }
    
    //updateAllWinPrize
    public function updateAllWinPrize(Request $request){ 
        $results=[]; 
        foreach($request->winPrizes as $winPrize){
            //vietlott 
            if($winPrize[0]=='updateWinPrizeVietlott'){
                $idMsg='#msg-'.$winPrize[1].'-'.$winPrize[2];
                if ( !Gate::allows('admin-updateOrderDetail') ) 
                    $results[]=['idMsg'=>$idMsg,'winPrizeStatus'=>$request->winPrizeStatus,'error'=>'Không có quyền cập nhật trúng thưởng!'];
                else{
                    $fields=(object)[
                        'orderDetailId' =>$winPrize[1],
                        'noPeriod' =>$winPrize[2],
                        'winPrizeStatus' =>$request->winPrizeStatus,
                        'idMsg' =>$idMsg
                    ];
                    
                    $results[]=(new WinPrizeServices())->updateWinPrizeVietlott($fields);
                }
            }
            //Traditional
            if($winPrize[0]=='updateWinPrizeTraditional'){
                $idMsg='#msg-'.$winPrize[1];
                $orderDetail=Orderdetail::find($winPrize[1]); 
                if (! Gate::allows('agency-updateOrderDetail',$orderDetail))
                    $results[]=['idMsg'=>$idMsg,'winPrizeStatus'=>$request->winPrizeStatus,'error'=>'Không có quyền cập nhật trúng thưởng!'];
                else{
                    $fields=(object)[
                        'orderDetailId' =>$winPrize[1], 
                        'winPrizeStatus' =>$request->winPrizeStatus,
                        'idMsg' =>$idMsg
                    ];
                    $results[]=(new WinPrizeServices())->updateWinPrizeTraditional($fields,$orderDetail);
                }
            } 
        }


        return $results;
    }


    // updateOrderDetail about refund money, use Axios
    public function updateOrderDetail(Request $request)
    {    
        $orderDetail=Orderdetail::find($request->orderDetailId);
        // right admin-updateOrderDetail || (agency-updateOrderDetail for traditional ticket create)
        if ( (!Gate::allows('admin-updateOrderDetail')) && (!Gate::allows('agency-updateOrderDetail',$orderDetail))){
            abort(403);    
        }   

        $request->validate([
            'orderDetailId'=>'required',  
            'status'=>'required',  
        ]);  

        

        if($request->status=='canceled') $result=$this->cancelOrderDetail($request->orderDetailId);
        // Log::debug('$result');Log::debug($result);
        // dont need handle successOrderDetail
        // else $this->successOrderDetail($request->orderDetailId); 

        return $result;
    }

    //  updateWinPrizeVietlott
    public function updateWinPrizeVietlott(Request $request)
    {     
        if (! Gate::allows('admin-updateOrderDetail')) abort(403);  
        
        $request->validate([
            'orderDetailId'=>'required',  
            'noPeriod'=>'required',  
            'winPrizeStatus'=>'required',
            'idMsg'=>'required',
        ]); 
        $fields=(object)[
            'orderDetailId' =>$request->orderDetailId,
            'noPeriod' =>$request->noPeriod,
            'winPrizeStatus' =>$request->winPrizeStatus,
            'idMsg' =>$request->idMsg
        ];
        return (new WinPrizeServices())->updateWinPrizeVietlott($fields);
    }

}