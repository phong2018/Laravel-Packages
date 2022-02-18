<?php

namespace Phonglg\LaravelVeso\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Routing\Controller; 
use Phonglg\LaravelVeso\Models\Vesoproduct;
use Illuminate\Support\Facades\Gate; 
use Illuminate\Support\Str;  
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Phonglg\LaravelVeso\Helpers\Province;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelLayout\Helpers\InputForm;
use Phonglg\LaravelVeso\Helpers\TraditionalTicket;
use Phonglg\LaravelVeso\Helpers\Vietlott;
use Phonglg\LaravelVeso\Services\StatisticalServices;
use Illuminate\Validation\ValidationException;
use Phonglg\LaravelUserRole\Models\Customer;
use Phonglg\LaravelVeso\Services\VesoProductServices;

class VesoproductController extends Controller 
{
    use AuthorizesRequests;

    public function __construct()
    {
        // Authorizing Resource Controllers
        $this->authorizeResource(Vesoproduct::class, 'vesoproduct');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, StatisticalServices $services)
    {
        $data=array(); 
        $data['invoiceStatistics']=$services->getInvoiceStatisticsData($request);
        $data['actionInvoiceStatistics']=route('vesoproducts.index');

        

        $vesoproducts = Vesoproduct::orderByDesc('id')->with('user')
        ->where('prize_date','>=',$data['invoiceStatistics']['fromDate'])
        ->where('prize_date','<=',$data['invoiceStatistics']['toDate']);

        if(isset($request->agency))  $data['agency']=$request->agency;
        else $data['agency']='';

        if($data['agency']) $vesoproducts= $vesoproducts->where('user_create_id',$data['agency']);
        
        if(Auth::user()->role_id<config('laraveluserrole.defaultRoleId')) // admin
            $vesoproducts=$vesoproducts->get();
        else 
            if(Auth::user()->role_id>config('laraveluserrole.defaultRoleId')) // agency
            $vesoproducts=$vesoproducts->where('user_create_id',Auth::id())->get(); 
        
        $data['reports']=(new VesoProductServices())->getReportSaleTicket($vesoproducts);
        $data['agencies']=Customer::where('role_id',config('laraveluserrole.defaultAgencyRoleId'))->get();

        
        $template=Vietlott::getLayoutForUser(); 
        return view('laravelveso::vesoproducts.index', ['vesoproducts' => $vesoproducts,'template'=>$template,'data'=>$data]);    
    }

    // agencyReport
    public function agencyReport($fromDate=false,$toDate=false)
    { 
        if (! Gate::allows('admin-updatePointAgency')){ 
            abort(403);    
        } 
        
        $services=new StatisticalServices();
        $data=array(); 
 
        $data['invoiceStatistics']=$services->getFilerReportDateData($fromDate,$toDate); 
   
        $data['actionAgencyReport']=route('vesoproducts.agencyReport');
 
        $vesoproducts = Vesoproduct::orderByDesc('user_create_id')  
        ->where('prize_date','>=',$data['invoiceStatistics']['fromDate'])
        ->where('prize_date','<=',$data['invoiceStatistics']['toDate'])
        ->where('veso_products.status',1)
        ->groupBy('user_create_id','game_type')  
        ->selectRaw('sum(quantity_sold) as totalQuantitySold,sum(quantity_reward) as totalQuantityReward,sum(quantity_paid) as totalQuantityPaid, user_create_id, game_type')
        ->get(); 
         
        return view('laravelveso::vesoproducts.agencyReport', ['vesoproducts' => $vesoproducts,'data'=>$data]);    
    }

    // sale
    public function sale()
    {
        $data=array();
        $data['urlFetchTickets']=route('vesoproducts.fetchTickets');
        $data['urlSaleTicket']=route('vesoproducts.saleTicket');
        return view('laravelveso::vesoproducts.saleTraditional', ['data'=>$data]);    
    }

    // urlFetchTickets
    public function fetchTickets(Request $request){
        $dateFilter='';$numFilter='';
        $dateFilter=$request->dataFilter[0];   
        $numFilter=$request->dataFilter[1];   
        $tickets=TraditionalTicket::getCurrentTicketsCanSale($numFilter,$dateFilter);
        return $tickets;
    } 

    // saleTicket
    public function saleTicket(Request $request){
        $request->validate([
            'ticketId'=>'required',  
            'qtySale'=>'required',  
        ]);      

        $ticket=Vesoproduct::find($request->ticketId);
        
        if ($ticket->user_create_id !=Auth::id()) abort(403);

        if($ticket->quantity<$request->qtySale)
            throw ValidationException::withMessages(['message' => 'Ko đủ vé']);
        else{
            $newQuantity=$ticket->quantity-$request->qtySale;
            $newQuantitySoldDirect=$ticket->quantity_sold_direct+$request->qtySale;
            $ticket->update(['quantity'=>$newQuantity,'quantity_sold_direct'=>$newQuantitySoldDirect]);
            return ['message'=>'Thành công'];
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status=InputForm::getStatus();
        $provinces=Province::getProvincesForCreateEdit(); 
        $template=Vietlott::getLayoutForUser();
        $data['gameTypes']=TraditionalTicket::getGameTypes();
        $data['getHtmlProvince']=route('vesoproducts.getHtmlProvince'); 
        $data['urlValidNumber']=route('vesoproducts.urlValidNumber');  
        // dd($data['gameTypes']);
        return view('laravelveso::vesoproducts.create',['provinces'=>$provinces,'status'=>$status,'template'=>$template,'data'=>$data]); 
    }

    // getHtmlProvince
    public function getHtmlProvince(Request $request){
        $request->validate([ 
            'prize_date'=>'required',
        ]);

        $provinces=Province::getProvincesForCreateEdit($request->prize_date); 
        
        $htmlProvince=view('laravelveso::vesoproducts.components.htmlProvince',['provinces'=>$provinces]);

        return $htmlProvince;
    }

    // checkNumber
    public function checkNumberExist($game_type,$number,$prize_date,$province,$userCreateId){
        $keyVesoproduct=TraditionalTicket::getKeyTicket($number,$prize_date,$province,$userCreateId);

        if($game_type==config('laravelhtmldomparser.categoryType.traditionallottery.gameType.capnguyen.key')){
            if(substr($number,0,1)!='0')
            return [$number,0];
        } 

        if (Vesoproduct::where('key', $keyVesoproduct)->count()==0) { 
            return [$number,1];
        }else{
            return [$number,0];
        } 
    }

    // urlValidNumber
    public function urlValidNumber(Request $request){
        
        $request->validate([ 
            'prize_date'=>'date', 
            'province'=>'required'
        ]); 
 
        $data=[];

        $province=explode('|',$request->province);
        
        // handle numbers
        if($request->numbers!=''){
            $numbers=explode(";",$request->numbers);
            foreach($numbers as $number)
            if($number!='') $data[]=$this->checkNumberExist($request->game_type,$number,$request->prize_date,$province[0],Auth::id());
            return $data;

        }else{// handle number
            $request->validate([ 
                'number'=>'digits_between:6,6',
            ]); 

            if($request->game_type==config('laravelhtmldomparser.categoryType.traditionallottery.gameType.capnguyen.key')){
                if(substr($request->number,0,1)!='0')
                throw ValidationException::withMessages(['number' => 'Cặp nguyên phải bắt đầu với số 0!']);
            } 

            return $this->checkNumberExist($request->game_type,$request->number,$request->prize_date,$province[0],Auth::id());
        }
            
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validTicket($request);

        $request->validate([
            'numbers'=>'required'
        ]);

        $province=explode('|',$request->province); 

        $fields=array( 
            'prize_date'=>$request->prize_date,
            'province'=>$province[0],
            'category'=>$province[1],
            'game_type'=>$request->game_type,
            'price'=>config('laravelveso.priceTicket.'.$request->game_type),
            'period'=>$request->period,
            'quantity'=>$request->quantity, 
            'user_create_id'=>Auth::id(),
            'status'=>$request->status,
        ); 
        // dd($fields);
        $numbers=explode(";",$request->numbers);

        foreach($numbers as $number)
        if($number!=''){
            $fields['number']=$number; 
            $keyVesoproduct=TraditionalTicket::getKeyTicket($number,$request->prize_date,$province[0],Auth::id()); 
            $fields['key']=$keyVesoproduct; 

            if (Vesoproduct::where('key', $keyVesoproduct)->count()==0) 
            Vesoproduct::create($fields);  
        }
       
        return redirect()->route('vesoproducts.index')->with('message','Tạo Vé số thành công');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function validTicket($request){ 
        //
        $request->validate([ 
            'prize_date'=>'date',
            'price'=>'required|numeric|min:0',
            'quantity'=>'required|numeric|min:0',
            'status'=>'required|numeric|min:0',
            'period'=>'required', 
            'game_type'=>'required', 
            'province'=>'required'
        ]); 

        if($request->game_type==config('laravelhtmldomparser.categoryType.traditionallottery.gameType.capnguyen.key')){
            if(substr($request->number,0,1)!='0')
            throw ValidationException::withMessages(['number' => 'Cặp nguyên phải bắt đầu với số 0!']);
            if($request->quantity>1)
            throw ValidationException::withMessages(['quantity' => 'Cặp nguyên số lượng nhỏ hơn hoặc bằng 1!']);
            // if($request->quantity!=1)
            // throw ValidationException::withMessages(['quantity' => 'Cặp nguyên số lượng phải bằng 1!']);
        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Vesoproduct $vesoproduct)
    {
        
        $status=InputForm::getStatus();
        
        $template=Vietlott::getLayoutForUser();

        $provinces=Province::getProvincesForCreateEdit($vesoproduct->prize_date); 

        $data['getHtmlProvince']=route('vesoproducts.getHtmlProvince');
        $data['gameTypes']=TraditionalTicket::getGameTypes();

        // dd($vesoproduct,$provinces);
        return view('laravelveso::vesoproducts.edit',['vesoproduct'=>$vesoproduct,'provinces'=>$provinces,'status'=>$status,'template'=>$template,'data'=>$data]); 

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vesoproduct $vesoproduct)
    { 
        $this->validTicket($request);
        $request->validate([
            'number'=>'digits_between:6,6'
        ]); 

        $province=explode('|',$request->province);  

        $keyVesoproduct=TraditionalTicket::getKeyTicket($request->number,$request->prize_date,$province[0],$vesoproduct->user_create_id);

        $fields=array(
            'key'=>$keyVesoproduct,
            'number'=>$request->number,
            'prize_date'=>$request->prize_date,
            'province'=>$province[0],
            'category'=>$province[1],
            'game_type'=>$request->game_type,
            'quantity'=>$request->quantity,
            'period'=>$request->period,
            'price'=>config('laravelveso.priceTicket.'.$request->game_type),
            'status'=>$request->status,
        );  
 

        $vesosTemp=Vesoproduct::where('key', $keyVesoproduct)->get(); 
        
        if(count($vesosTemp)==0 || (count($vesosTemp)==1 && $vesosTemp[0]->id==$vesoproduct->id)){
            $vesoproduct->update($fields);
            return redirect()->route('vesoproducts.index')->with('message','Sửa Vé số thành công');
        }else return redirect()->back()->with('error','Vé số này đã có trên hệ thống'); 
        
    }
     

    public function deleteSelected(Request $request){ 
        Vesoproduct::destroy($request->selected); 
        return redirect()->back()->with('message','Xóa vé số thành công');

    }

    public function copy(Vesoproduct $vesoproduct)
    {
        
        $keyVesoproduct=Str::slug($vesoproduct->prize_date.$vesoproduct->province.time());
        $fields=array(
            'key'=>time(),
            'number'=>$vesoproduct->number.'(1)',
            'prize_date'=>$vesoproduct->prize_date,
            'province'=>$vesoproduct->province,
            'category'=>$vesoproduct->category,
            'game_type'=>$vesoproduct->game_type,
            'price'=>$vesoproduct->price,
            'quantity'=>$vesoproduct->quantity,  
            'image'=>$vesoproduct->image,
            'user_create_id'=>$vesoproduct->user_create_id,
            'status'=>0,
        );  

        Vesoproduct::create($fields);  
        return redirect()->route('vesoproducts.index')->with('message','Sao chép Vé số thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vesoproduct $vesoproduct)
    {   
        $vesoproduct->delete();
        return back();
    } 
    public function unSoldTicket(Vesoproduct $vesoproduct){
        $this->authorize('update', $vesoproduct);

        $quantity_unsold=$vesoproduct->quantity;
        if($quantity_unsold>0) $vesoproduct->update(['quantity_unsold'=>$quantity_unsold,'quantity'=>0]);
        return back();
    }

    public function unSoldAllTicket(){
        $data=array(); 
        $data['invoiceStatistics']=(new StatisticalServices())->getInvoiceStatisticsData(null); 


        $vesoproducts = Vesoproduct::orderByDesc('id')->with('user')
        ->where('prize_date','>=',$data['invoiceStatistics']['fromDate'])
        ->where('prize_date','<=',$data['invoiceStatistics']['toDate'])
        ->where('user_create_id',Auth::id())->get(); 
 
        foreach($vesoproducts as $vesoproduct){
            $quantity_unsold=$vesoproduct->quantity;
            if($quantity_unsold>0) $vesoproduct->update(['quantity_unsold'=>$quantity_unsold,'quantity'=>0]);
        } 

        return back()->with('message','Ngừng bán tất cả thành công');
    }
    

}