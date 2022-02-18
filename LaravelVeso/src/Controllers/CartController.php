<?php

namespace Phonglg\LaravelVeso\Controllers;

use App\Models\User;
use Phonglg\LaravelVeso\Models\Vesoproduct;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Phonglg\LaravelLayout\Helpers\Date;
use Phonglg\LaravelVeso\Helpers\Province;
use Phonglg\LaravelVeso\Helpers\TraditionalTicket;
use Phonglg\LaravelVeso\Helpers\Vietlott;

class CartController extends Controller
{ 
    public function prepareDataCart($checkout){
        $data=[];
        $data['provinces']=Province::getProvincesByKey(); 
        $data['blocks']=config('laravelhtmldomparser.blocks'); 
        $data['methodsToPlay']=config('laravelhtmldomparser.methodsToPlay'); 
        $data['methodsToPlayKeno']=config('laravelhtmldomparser.methodsToPlayKeno');
        $data['banksFee']=config('laravelvnpay.banksFee');

        $data['banks']=[];
        $tempBanks=config('laravelvnpay.banks');
        foreach($tempBanks as $key=>$val) 
        if($key!=config('laravelvnpay.banks.COD.id')) $data['banks'][]=(object)$val;  
        
        $data['refundTicktes']=TraditionalTicket::getCartRefundTicket();
        $data['total']=str_replace(',','',Cart::total())-$data['refundTicktes'][0]; 
        return $data; 
    }
    // show carts
    public function index()
    {
        $data=$this->prepareDataCart($checkout=false);
        $cart=Cart::content(); 
        if($cart->count()==0)  return redirect()->route('home');
        $data['updateQtyCart']=route('cart.updateQtyCart');
        return view('laravelveso::cart.index',['cart'=>$cart,'data'=>$data]);
    }

    // checkout carts
    public function checkout()
    {  
        session(['backToCheckout' => true]);
        $data=$this->prepareDataCart($checkout=true);
        $cart=Cart::content();  
        if (Auth::check()) $data['customer']=Auth::user();    
        if($cart->count()==0)  return redirect()->route('home');
        $data['updateQtyCart']=route('cart.updateQtyCart');
        $data['currPeriodAllVietlott']=Vietlott::getCurrPeriodAllVietlott();
        // dd($data['currPeriodAllVietlott']);
        return view('laravelveso::cart.checkout',['cart'=>$cart,'data'=>$data]);
    }

    // store product to cart (product: tradition lottery)
    public function store(Vesoproduct $product){ 
        $nameProduct=$product->number.'|'.$product->province;
        Cart::add(['id' => $product->id, 'name' => $nameProduct, 'qty' => 1, 'price' => $product->price,'weight' => 0, 'options' => ['product_id'=>$product->id,'game_type'=>$product->game_type,'image'=>'','name' => $nameProduct,'prize_date'=>Date::showDateDMY($product->prize_date),'category'=>config('laravelhtmldomparser.categoryType.traditionallottery.key')]]);
        
        return redirect()->back()->with('message','Thêm vé số vào giỏ hàng thành công.');
    }

    // storeTraditional
    public function storeTraditional(Request $request){  
        foreach($request->tickets as $ticket){
            $product=Vesoproduct::find($ticket[0]); 
            $nameProduct=$product->number.'|'.$product->province;
            $agency=User::find($product->user_create_id);
            Cart::add(['id' => $product->id, 'name' => $nameProduct, 'qty' => $ticket[1], 'price' => $product->price,'weight' => 0, 'options' => ['product_id'=>$product->id,'game_type'=>$product->game_type,'ticket_category'=>$product->ticket_category,'agency'=>$agency->agency_name,'agency_id'=>$agency->id,'period'=>$product->period,'image'=>'','name' => $nameProduct,'prize_date'=>Date::showDateDMY($product->prize_date),'category'=>config('laravelhtmldomparser.categoryType.traditionallottery.key')]]);
        } 
        return ['success storeTraditional',$request->tickets]; 
    }

    // storevietlott
    public function storevietlott(Request $product){  
        
        $options=(array)json_decode($product->options);

        // prepare data for max3d, max3dplus, max3dpro
        if($options['category']==config('laravelhtmldomparser.categoryType.max3d.key')||$options['category']==config('laravelhtmldomparser.categoryType.max3dplus.key')||$options['category']==config('laravelhtmldomparser.categoryType.max3dpro.key')){
            $tempBlocksNumber=[];
            foreach($options['blocksNumber'] as $block){
                $tempBlocksNumber[]=Vietlott::combineBlock3D($block);
            }
            $options['blocksNumber']=$tempBlocksNumber;
        }
        // prepare data ouOfDate for everyPeriods
        $tempperiodStatus=[];$tempPeriods=[];
        for($i=0;$i<count($options['buyingPeriods']);$i++){
            $tempperiodStatus[]=-1;
            $tempPeriods[]=str_replace('#','',$options['buyingPeriods'][$i]);
        }
        sort($tempPeriods);
        $options['periodStatus']=$tempperiodStatus;
        $options['buyingPeriods']=$tempPeriods;

        // get dataProduct
        $dataProduct= ['id' =>$product->id, 'name' => $product->name, 'qty' => $product->qty, 'price' =>$product->price,'weight' => $product->weight, 'options' => $options];
        Cart::add($dataProduct);
        return ['success storevietlott',$dataProduct]; 
    }
    
    // update product in cart
    public function update(Request $request) { 
        Cart::update($request->rowId,$request->qty);
        return redirect()->back()->with('message','Cập nhật số lượng Vé mua thành công');
    }

    // update updateQtyCart product in cart
    public function updateQtyCart(Request $request) { 
        Cart::update($request->rowId,$request->qty);
        return ['success'];
    }

    // remove product from carts
    public function delete(Request $request) { 
        //dd('delete',$request,$request->rowId);
        Cart::remove($request->rowId);
        return redirect()->back()->with('message','Hủy vé mua thành công');
    }
     
}