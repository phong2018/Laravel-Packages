<?php

namespace Phonglg\LaravelVeso\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Phonglg\LaravelVeso\Helpers\ArrayHelper;
use Phonglg\LaravelVeso\Helpers\Province;
use Phonglg\LaravelVeso\Helpers\Vietlott;
use Phonglg\LaravelVnPay\Helpers\Banks;
use Phonglg\LaravelVeso\Models\Order;
use Phonglg\LaravelVeso\Models\Orderdetail;

class CustomerOrderController extends Controller
{   
    // list point of Customer
    public function index(){    

        $orders=Order::where('userId',Auth::id())
        ->where('type',config('laravelveso.orderTypes.buyLottery.key'))
        ->orderBy('id','DESC')
        ->paginate(20);
        // dd($orders); 

        return view('laravelveso::customerOrder.list',['orders'=>$orders]);      
    }
    
    // list point of Customer
    public function show(Order $order){    

        //if($order->userId!=Auth::id()) abort(403);

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

        return view('laravelveso::customerOrder.show',['cart'=>$items,'data'=>$data]); 
    } 

 
}