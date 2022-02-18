<?php

namespace Phonglg\LaravelVeso\Controllers\Agency;

use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Phonglg\LaravelVeso\Helpers\Province;
use Phonglg\LaravelVeso\Models\Order;
use Phonglg\LaravelVeso\Models\Orderdetail; 
use Illuminate\Support\Facades\Gate;
use Phonglg\LaravelVeso\Helpers\Vietlott;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

use Phonglg\LaravelAuth\Models\UserLog;
use Phonglg\LaravelVeso\Models\Vesoproduct; 
use Phonglg\LaravelVeso\Services\WinPrizeServices;

class AgencyOrderController extends Controller
{   
    // editOrderDetail to submit winPrize
    public function editOrderDetail(Orderdetail $orderDetail){    
        
        if (! Gate::allows('agency-updateOrderDetail',$orderDetail)) abort(403);

        $order=Order::find($orderDetail->order_id);
        $data=[
            'orderStatusValue'=>$order->status, 
            'provinces'=>Province::getProvincesByKey(),
            'updateWinPrize'=>route('agency.updateWinPrize'),
            'getTicketToReturn'=>route('agency.getTicketToReturn'),
            'returnTicketForCustomer'=>route('agency.returnTicketForCustomer'),
            'updateOrderDetail'=>route('admin.updateOrderDetail'),
            'updateWinPrizeVietlott'=>route('admin.updateWinPrizeVietlott'),
        ]; 
        // customerInfo
        $customer=User::find($order->userId);
        $data['customer']=[
            'info'=>$order->fullname.' - SĐT: '.$order->phone_number,
            'bank_info'=>$customer->bank_info,
        ];  
        $item=Vietlott::prepareDataShowOrderdetail($orderDetail); 
        return view('laravelveso::agencyOrder.editOrderDetailTraditional',['orderDetail'=>$item,'data'=>$data]);
    }
 

    // updateWinPrize just for traditional ticket of agency, agency implement this action
    public function updateWinPrize(Request $request){  
        $request->validate([
            'orderDetailId'=>'required',   
            'winPrizeStatus'=>'required',
            'idMsg'=>'required',
        ]);  

        $orderDetail=Orderdetail::find($request->orderDetailId);
        if (! Gate::allows('agency-updateOrderDetail',$orderDetail)){     
            return ['idMsg'=>$request->idMsg,'winPrizeStatus'=>$request->winPrizeStatus,'error'=>'Không có quyền cập nhật trúng thưởng!'];
        }
        return (new WinPrizeServices())->updateWinPrizeTraditional($request, $orderDetail);
    }

    // getTicketToReturn
    public function getTicketToReturn(Request $request){
        $tickets=[];
        $data=[
            'orderDetailId'=>$request->orderDetailId,
            'numberTickets'=>$request->numberTickets, 
            'noWinPrize'=>$request->noWinPrize,
        ];
        
        $tickets=Vesoproduct::orderByDesc('id')
                //->where('quantity','>=',$request->numberTickets)
                ->get();  

        $ticketsView=view('laravelveso::adminOrder.componentOrder.selectTicketToReturnView',['tickets'=>$tickets,'data'=>$data]);

        return $ticketsView;
    }

    // returnTicketForCustomer traditional ticket
    public function returnTicketForCustomer(Request $request){ 
        $request->validate([
            'orderDetailId'=>'required',  
            'numberTickets'=>'required',
            'ticketId'=>'required',  
            'noWinPrize'=>'required', 
        ]);  
        $orderDetail=Orderdetail::find($request->orderDetailId);
        if (! Gate::allows('agency-updateOrderDetail',$orderDetail)) abort(403); 
        
        $details=json_decode($orderDetail->details);
        if($details->winPrizes[$request->noWinPrize][3]==1)
            throw ValidationException::withMessages(['message' => 'Hóa đơn này đã được hoàn vé!']);

        $ticket=Vesoproduct::find($request->ticketId);
        if($ticket->quantity<$request->numberTickets) 
            throw ValidationException::withMessages(['message' => 'Vé số này không đủ số lượng để hoàn vé!']);
        else{
            // minus quantity for this ticket
            $newQuantity=$ticket->quantity-$request->numberTickets;
            $ticket->update(['quantity'=>$newQuantity]);
            // create new OrderDetail form these tickets
            $tempDetails=[
                'product_id'=>$ticket->id,
                'image'=>$ticket->image,
                'name'=>$ticket->number.'|'.$ticket->province,
                'prize_date'=>$ticket->prize_date,
                'category'=>$orderDetail->category,
            ];
            $fields=array(
                'order_id'=>$orderDetail->order_id,
                'details'=>json_encode($tempDetails),
                'category'=>$orderDetail->category,
                'quantity'=>$request->numberTickets, //ticks had return
                'status'=>config('laravelveso.orderDetailStatus.pendding.key'),
                'quantity_refund'=>-1,
                'price'=>0, // free money
            );  
            Orderdetail::create($fields); 
            // update had return ticket for customer 
            $details->winPrizes[$request->noWinPrize][3]=1;
            $orderDetail->update(['details'=>json_encode($details)]);
            // alert for customer & create log
            $order=Order::find($orderDetail->order_id);
            $orderTitle='(HĐ: <a href="'.route('customer.order.show',['order'=>$order]).'">#'. $order->id.'</a>)';
            $customer=User::find($order->userId); 
            $title='Khách hàng '.$customer->username.' '.config('laravelauth.userLogAction.receivedWinPrizeByTicket').' '.$request->numberTickets.' vé, số '.$ticket->number.' '.$orderTitle;
            Vietlott::sendNotificationWinPrize($title,$order,$orderDetail,$sendFor=[1,1,0]);
            $log=config('laravelauth.userLogAction.getTicketToReward').' '.$customer->username.', '.$request->numberTickets.' vé, số '.$ticket->number.' trong hóa đơn: #'.$order->id;
            UserLog::create(['userId'=>Auth::id(),'log'=>$log]); 
        }    
        
        return ['message'=>'Hoàn vé thành công.'];
    } 

    public function listOrdersSale(){ 
        $orders = Orderdetail::where('category',config('laravelveso.ticketTypes.traditionallottery.key')) 
        ->where('agency_id',Auth::id())
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
}
?>