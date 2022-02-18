<?php

namespace Phonglg\LaravelVeso\Controllers;

use Illuminate\Http\Request; 
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Routing\Controller;
use Phonglg\LaravelUserRole\Models\Customer;
use Phonglg\LaravelVeso\Helpers\Province;
use Phonglg\LaravelVeso\Helpers\TraditionalTicket;
use Phonglg\LaravelVeso\Helpers\Vietlott;
use Phonglg\LaravelVeso\Models\Vesoproduct; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelSetting\Helpers\SettingHelper;

class BuyLotteryController extends Controller 
{
    // __construct
    public function __construct()
    {
         
    }
    // buyTraditionalLottery
    public function buyTraditionalLottery_old(Request $request){
        $numFilter='';
        if(isset($request->numFilter))  $numFilter=$request->numFilter;  
        
        // dd('buyTraditionalLottery'); 
        $products=TraditionalTicket::getCurrentTicketsCanBuy($numFilter);
        $products=$products->paginate(20)->appends(request()->query());

        $cart= Cart::content();  
        
        $provinces=Province::getProvincesByKey();

        //dd($provinces);
        return view('laravelveso::buylottery.buyTraditionalLottery',['products'=>$products,'cart'=>$cart,'provinces'=>$provinces,'numFilter'=>$numFilter]);
    } 

    // getAgenciesAndReward
    public function getAgenciesAndReward(){
        // customer
        $customer=Auth::user(); 
        if(isset($customer['refund_tickets']))
        $refundTickets=json_decode($customer['refund_tickets']);
        else $refundTickets=[]; 
        // agency
        $agencies=Customer::where('role_id',config('laraveluserrole.defaultAgencyRoleId'))->get();
        $agenciesData=[];
        foreach($agencies as $agency){
            $agencyInfo=json_decode($agency->agency_info);
            $agenciesData[$agency->id]=[
                'rewardTicket'=>'',
                'capnguyen'=>'',
                'vethuong'=>'',
                'id'=>$agency->id,
                'name'=>isset($agencyInfo->AgencyName)?$agencyInfo->AgencyName:$agency->name,
                
            ];
        }
        // handle refund ticket
        if($refundTickets)
        foreach($refundTickets as $refundTicket)
        if(isset($agenciesData[$refundTicket[0]])){ // $refundTicket[0] is id agency reward for customer
            $agenciesData[$refundTicket[0]]['vethuong']=$refundTicket[1];
            $agenciesData[$refundTicket[0]]['capnguyen']=$refundTicket[2];
            $agenciesData[$refundTicket[0]]['rewardTicket']=$refundTicket[1]+$refundTicket[2]*110;
        } 

        // sort
        rsort($agenciesData);
        // dd($agenciesData);

        return $agenciesData;


    }

    // buyTraditionalLottery use React
    public function buyTraditionalLottery(Request $request){
        
        $numFilter=''; 
        $products=TraditionalTicket::getCurrentTicketsCanBuy($numFilter); 
        
        
        $data=[
            'tickets'=>$products,
            'traditionallottery'=>config('laravelhtmldomparser.categoryType.traditionallottery'),
            'miennam'=>config('laravelhtmldomparser.categoryType.miennam'),
            'mienbac'=>config('laravelhtmldomparser.categoryType.mienbac'),
            'mientrung'=>config('laravelhtmldomparser.categoryType.mientrung'),
        ];
 

        $data['agencies']=$this->getAgenciesAndReward();
        $data['addToCart']=route('cart.storeTraditional'); 
        $data['checkout']=route('cart.checkout');
        $data['url_chinh_sach_trung_thuong']=SettingHelper::getKey('url_chinh_sach_trung_thuong_traditional');

        return view('laravelveso::buylottery.buyTraditionalLottery',['data'=>$data]);
    }

    // buyMega45
    public function buyMega645(){
        // common data for vietlott
        $data['addToCart']=route('cart.storevietlott'); 
        $data['checkout']=route('cart.checkout');
        $data['methodsToPlay']=config('laravelhtmldomparser.methodsToPlay');
        // option data for mega645
        $data['vietlottType']=config('laravelhtmldomparser.categoryType.mega645'); 
        $data['buyingPeriods']=Vietlott::getBuyingPeriodByOrder(6);
        // $data['buyingPeriods']=Vietlott::getBuyingPeriodsNext(config('laravelhtmldomparser.categoryType.mega645.key'),6);
        // dd($data['buyingPeriods']);
        $data['url_chinh_sach_trung_thuong']=SettingHelper::getKey('url_chinh_sach_trung_thuong_vietlott');
        return view('laravelveso::buylottery.buyMega645',['data'=>$data]);
    }

    // buyPower655
    public function buyPower655(){
        // common data for vietlott
        $data['addToCart']=route('cart.storevietlott'); 
        $data['checkout']=route('cart.checkout');
        $data['methodsToPlay']=config('laravelhtmldomparser.methodsToPlay');
        // option data for buyPower655
        $data['vietlottType']=config('laravelhtmldomparser.categoryType.power655');
        $data['buyingPeriods']=Vietlott::getBuyingPeriodByOrder(6);
        $data['url_chinh_sach_trung_thuong']=SettingHelper::getKey('url_chinh_sach_trung_thuong_vietlott');
        // $data['buyingPeriods']=Vietlott::getBuyingPeriodsNext(config('laravelhtmldomparser.categoryType.power655.key'),6);
        return view('laravelveso::buylottery.buyPower655',['data'=>$data]);
    }

    // buyMax3D
    public function buyMax3D(){
        // common data for vietlott
        $data['addToCart']=route('cart.storevietlott'); 
        $data['checkout']=route('cart.checkout');
        $data['methodsToPlay']=[['name'=>'Max3D','numberBallSelected'=>3]];
        $data['priceBlocks']=config('laravelhtmldomparser.priceBlocks'); 
        // option data for buyMax3D
        $data['vietlottType']=config('laravelhtmldomparser.categoryType.max3d'); 
        $data['buyingPeriods']=Vietlott::getBuyingPeriodByOrder(6);
        $data['url_chinh_sach_trung_thuong']=SettingHelper::getKey('url_chinh_sach_trung_thuong_vietlott');
        //$data['buyingPeriods']=Vietlott::getBuyingPeriodsNext(config('laravelhtmldomparser.categoryType.max3d.key'),6);
  
        return view('laravelveso::buylottery.buyMax3D',['data'=>$data]);
    }

    // buyMax3DPro
    public function buyMax3DPro(){
        // common data for vietlott
        $data['addToCart']=route('cart.storevietlott'); 
        $data['checkout']=route('cart.checkout');
        $data['methodsToPlay']=[['name'=>'Max3D Pro','numberBallSelected'=>6]];
        $data['priceBlocks']=config('laravelhtmldomparser.priceBlocks'); 
        // option data for buyMax3D
        $data['vietlottType']=config('laravelhtmldomparser.categoryType.max3dpro'); 
        $data['buyingPeriods']=Vietlott::getBuyingPeriodByOrder(6);
        $data['url_chinh_sach_trung_thuong']=SettingHelper::getKey('url_chinh_sach_trung_thuong_vietlott');
        // $data['buyingPeriods']=Vietlott::getBuyingPeriodsNext(config('laravelhtmldomparser.categoryType.max3dpro.key'),6);
  
        return view('laravelveso::buylottery.buyMax3DPro',['data'=>$data]);
    }

    // buyMax3DPro
    public function buyMax3DPlus(){
        // common data for vietlott
        $data['addToCart']=route('cart.storevietlott'); 
        $data['checkout']=route('cart.checkout');
        $data['methodsToPlay']=[['name'=>'Max3D Plus','numberBallSelected'=>6]];
        $data['priceBlocks']=config('laravelhtmldomparser.priceBlocks'); 
        // option data for buyMax3D
        $data['vietlottType']=config('laravelhtmldomparser.categoryType.max3dplus'); 
        $data['buyingPeriods']=Vietlott::getBuyingPeriodByOrder(6);
        $data['url_chinh_sach_trung_thuong']=SettingHelper::getKey('url_chinh_sach_trung_thuong_vietlott');
        //$data['buyingPeriods']=Vietlott::getBuyingPeriodsNext(config('laravelhtmldomparser.categoryType.max3d.key'),6);
        //dd($data['buyingPeriods']);
        return view('laravelveso::buylottery.buyMax3DPlus',['data'=>$data]);
    }

    // check dontAllowBuy
    public function checkDontAllowBuy($keyType){
        
        
        $latestPrize=SettingHelper::getKey($keyType); 
        $timelatestPrize=strtotime($latestPrize[1]); 
        $timeCurrent=date('Y-m-d H:i:s');
        $currDateTime = strtotime($timeCurrent);  
        // dump($latestPrize[1],$timelatestPrize,$currDateTime,($currDateTime-$timelatestPrize)/60);
        $minutesBetween=($currDateTime-$timelatestPrize)/60;
        Log::debug('checkDontAllowBuy ',[$keyType,$latestPrize[1],$timeCurrent,$minutesBetween]);
        if($keyType==config('laravelhtmldomparser.categoryType.keno.keyLatestResult') && ($minutesBetween>10)) return true;

        return false;
    }

    // buyKeno
    public function buyKeno(){
        //------------------------- 
        if($this->checkDontAllowBuy(config('laravelhtmldomparser.categoryType.keno.keyLatestResult')))
        return redirect()->route('notFound')->with('error','Hệ thống bán vé đang bảo trì hãy quay lại sau!'); 
        // common data for vietlott
        $data['addToCart']=route('cart.storevietlott'); 
        $data['checkout']=route('cart.checkout');
        $data['methodsToPlay']=config('laravelhtmldomparser.methodsToPlayKeno');
        $data['priceBlocks']=config('laravelhtmldomparser.priceBlocks'); 
        // option data for mega645
        $data['vietlottType']=config('laravelhtmldomparser.categoryType.keno'); 
        $data['buyingPeriods']=Vietlott::getBuyingPeriodByOrder(15);
        $data['url_chinh_sach_trung_thuong']=SettingHelper::getKey('url_chinh_sach_trung_thuong_vietlott');
        // $data['buyingPeriods']=Vietlott::getBuyingPeriodsNextForKeno(10);
        // dd($data['buyingPeriods']);
        return view('laravelveso::buylottery.buyKeno',['data'=>$data]);
    }

    // notFound
    public function notFound(){     
        return view('laravelveso::buylottery.notFound'); 
    }

}