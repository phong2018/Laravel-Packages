<?php

namespace Phonglg\LaravelHtmlDomParser\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Helpers\GetTraditionalPrizeHelper;
use Phonglg\LaravelHtmlDomParser\Models\Prize;
use Phonglg\LaravelLayout\Helpers\Date;
use Phonglg\LaravelSetting\Helpers\SettingHelper;
use Phonglg\LaravelVeso\Helpers\Vietlott;

class PrizeController extends Controller
{ 
    // show prizes
    public function index()
    {
         dd('hello');
    } 

    // GetDataToShowTraditionalPrize
    public function GetDataToShowTraditionalPrize($request, $categoryType){
          if(isset($request->prize_period)) $prize_period=$request->prize_period;
          else $prize_period=false;

          $prizesResult=[]; 

          if($prize_period){
               $checkGetLatestPrize=false;
               $dateLastestToGetPrize=$prize_period;
          }else {
               // if exist result -> not need call Ajax
               if(SettingHelper::getKey(config('laravelhtmldomparser.categoryType.'.$categoryType.'.keyLatestResult'))==date('Y-m-d'))
                    $checkGetLatestPrize=false; 
               else $checkGetLatestPrize=true; 
               
               $dateLastestToGetPrize=date("Y-m-d");
          }
          // get result
          for($i=0;$i<5;$i++){
               $dateMinusI=strtotime("-".$i." day", strtotime($dateLastestToGetPrize)); 
               $tempPrize=Vietlott::getPrizesFromDB($categoryType,$dateMinusI,false);
               $prizesResult[]=Vietlott::PrepareDataXoSo($tempPrize);
          }  

          $prizesTempLast=$dateMinusI=date('Y-m-d',strtotime("+1 day", strtotime($dateLastestToGetPrize)));
          
          $urlGetResultLottery=route('prizes.getResultLottery');     
          
          return [$checkGetLatestPrize,$prizesResult,$urlGetResultLottery,$prizesTempLast];
    }

    // showXosoMienNam
    public function showXosoMienNam(Request $request)
    {     
         
         $categoryType=config('laravelhtmldomparser.categoryType.miennam.key');
         $tempData=$this->GetDataToShowTraditionalPrize($request,$categoryType);
     
         $data['checkGetLatestPrize']=$tempData[0];
         $data['routeShowPrizeResult']='prizes.showXosoMienNam';
         $prizesResult=$tempData[1];
         $urlGetResultLottery=$tempData[2]; 
         $data['prizesTempLast']=$tempData[3];
         
         return view('laravelhtmldomparser::prizes.showXosoMienNam',['prizesResult'=>$prizesResult,'categoryType'=>$categoryType,'urlGetResultLottery'=>$urlGetResultLottery,'data'=>$data]);
    } 

    // showXosoMienTrung
    public function showXosoMienTrung(Request $request)
    {  
          $categoryType=config('laravelhtmldomparser.categoryType.mientrung.key');
          $tempData=$this->GetDataToShowTraditionalPrize($request,$categoryType);
     
          $data['checkGetLatestPrize']=$tempData[0];
          $data['routeShowPrizeResult']='prizes.showXosoMienTrung';
          $prizesResult=$tempData[1];
          $urlGetResultLottery=$tempData[2]; 
          $data['prizesTempLast']=$tempData[3];

          return view('laravelhtmldomparser::prizes.showXosoMienTrung',['prizesResult'=>$prizesResult,'categoryType'=>$categoryType,'urlGetResultLottery'=>$urlGetResultLottery,'data'=>$data]);   
    }

    // showXosoMienBac
    public function showXosoMienBac(Request $request)
    {  
          $categoryType=config('laravelhtmldomparser.categoryType.mienbac.key');
          $tempData=$this->GetDataToShowTraditionalPrize($request,$categoryType);

          $data['checkGetLatestPrize']=$tempData[0];
          $data['routeShowPrizeResult']='prizes.showXosoMienBac';
          $prizesResult=$tempData[1];
          $urlGetResultLottery=$tempData[2]; 
          $data['prizesTempLast']=$tempData[3];

          return view('laravelhtmldomparser::prizes.showXosoMienBac',['prizesResult'=>$prizesResult,'categoryType'=>$categoryType,'urlGetResultLottery'=>$urlGetResultLottery,'data'=>$data]);  
    }


    // GetDataToShowVietlottPrize
    public function GetDataToShowVietlottPrize($request, $categoryType){

          if($categoryType==config('laravelhtmldomparser.categoryType.keno.key')){
               $numberResults=30;
          }else $numberResults=5;

          if(isset($request->prize_period)) $prize_period=$request->prize_period;
          else $prize_period=false; 

          $prizesTempLast=[];

          if($prize_period){
               $prizesTemp=[];
               $checkGetLatestPrize=false; 
               $prizesTemp=Prize::where('category',$categoryType)->where('prize_period','<=',"#".($prize_period))->orderBy('id','DESC')->take($numberResults)->get();

               $prizesTempLast=Prize::where('category',$categoryType)->where('prize_period','>',"#".($prize_period))->orderBy('id','ASC')->take(1)->get();
          }else {
               $checkGetLatestPrize=true; 
               $prizesTemp=Prize::where('category',$categoryType)->orderBy('id','DESC')->take($numberResults)->get();
          }
                      
          $prizes=Vietlott::PrepareDataXoSo($prizesTemp);  

          $urlGetResultLottery=route('prizes.getResultLottery');
           
          return [$checkGetLatestPrize,$prizes,$urlGetResultLottery,$prizesTempLast];
     }

    // showXosoMega645
    public function showXosoMega645(Request $request)
    {  
          $categoryType=config('laravelhtmldomparser.categoryType.mega645.key');
          $tempData=$this->GetDataToShowVietlottPrize($request,$categoryType);

          $data['checkGetLatestPrize']=$tempData[0];
          $data['routeShowPrizeResult']='prizes.showXosoMega645';
          $prizes=$tempData[1];
          $urlGetResultLottery=$tempData[2];  
          $data['prizesTempLast']=$tempData[3];

          return view('laravelhtmldomparser::prizes.showXosoMega645',['prizes'=>$prizes,'categoryType'=>$categoryType,'urlGetResultLottery'=>$urlGetResultLottery,'data'=>$data]);
    }

    // showXosoPower655
    public function showXosoPower655(Request $request)
    {  
          $categoryType=config('laravelhtmldomparser.categoryType.power655.key');
          $tempData=$this->GetDataToShowVietlottPrize($request,$categoryType);

          $data['checkGetLatestPrize']=$tempData[0];
          $data['routeShowPrizeResult']='prizes.showXosoPower655';
          $prizes=$tempData[1];
          $urlGetResultLottery=$tempData[2];  
          $data['prizesTempLast']=$tempData[3];

          return view('laravelhtmldomparser::prizes.showXosoPower655',['prizes'=>$prizes,'categoryType'=>$categoryType,'urlGetResultLottery'=>$urlGetResultLottery,'data'=>$data]);
          
    }
    public function showXosoMax3D(Request $request)
    {  
          $categoryType=config('laravelhtmldomparser.categoryType.max3d.key');
          $tempData=$this->GetDataToShowVietlottPrize($request,$categoryType);

          $data['checkGetLatestPrize']=$tempData[0];
          $data['routeShowPrizeResult']='prizes.showXosoMax3D';
          $prizes=$tempData[1];
          $urlGetResultLottery=$tempData[2]; 
          $data['prizesTempLast']=$tempData[3];
          
         return view('laravelhtmldomparser::prizes.showXosoMax3D',['prizes'=>$prizes,'categoryType'=>$categoryType,'urlGetResultLottery'=>$urlGetResultLottery,'data'=>$data]);
    }
    public function showXosoMax3DPro(Request $request)
    {  
          $categoryType=config('laravelhtmldomparser.categoryType.max3dpro.key');
          $tempData=$this->GetDataToShowVietlottPrize($request,$categoryType);

          $data['checkGetLatestPrize']=$tempData[0];
          $data['routeShowPrizeResult']='prizes.showXosoMax3DPro';
          $prizes=$tempData[1];
          $urlGetResultLottery=$tempData[2]; 
          $data['prizesTempLast']=$tempData[3];

         return view('laravelhtmldomparser::prizes.showXosoMax3DPro',['prizes'=>$prizes,'categoryType'=>$categoryType,'urlGetResultLottery'=>$urlGetResultLottery,'data'=>$data]);
    }

    public function showXosoKeno(Request $request)
    {   
         $categoryType=config('laravelhtmldomparser.categoryType.keno.key');
         $tempData=$this->GetDataToShowVietlottPrize($request,$categoryType);

         $data['checkGetLatestPrize']=$tempData[0];
         $data['routeShowPrizeResult']='prizes.showXosoKeno';
         $prizes=$tempData[1];
         $urlGetResultLottery=$tempData[2]; 

         return view('laravelhtmldomparser::prizes.showXosoKeno',['prizes'=>$prizes,'urlGetResultLottery'=>$urlGetResultLottery,'data'=>$data]);
    }
     
    //getResultLottery use axios
    public function getResultLottery(Request $request){
          $prizes=[];
          $resultLottery='';
          
          // typePrize is Vietllot: 1
          if($request->isVietlottType==1){
               $prizes=Vietlott::getPrizesFromDB($request->typeResultLottery,false,1); 
               if($prizes  && count($prizes)>0){
                    $prizes=Vietlott::PrepareDataXoSo($prizes); 
                    if($request->typeResultLottery==config('laravelhtmldomparser.categoryType.mega645.key')) 
                    $resultLottery=view('laravelhtmldomparser::prizes.component.mega645',['prize'=>$prizes[0]]);
                    
                    if($request->typeResultLottery==config('laravelhtmldomparser.categoryType.power655.key')) 
                    $resultLottery=view('laravelhtmldomparser::prizes.component.power655',['prize'=>$prizes[0]]);
                    
                    if($request->typeResultLottery==config('laravelhtmldomparser.categoryType.max3d.key')) 
                    $resultLottery=view('laravelhtmldomparser::prizes.component.max3d',['prize'=>$prizes[0]]);

                    if($request->typeResultLottery==config('laravelhtmldomparser.categoryType.max3dpro.key')) 
                    $resultLottery=view('laravelhtmldomparser::prizes.component.max3dpro',['prize'=>$prizes[0]]);
                    
                    //$resultLottery=view('laravelhtmldomparser::prizes.resultComp.resultVietlottMegaPower',['prize'=>$prizes[0]]);

                    // $request->typeResultLottery==config('laravelhtmldomparser.categoryType.power655.key'))
                    // $resultLottery=view('laravelhtmldomparser::prizes.resultComp.resultVietlottMegaPower',['prize'=>$prizes[0]]);
                    // else $resultLottery=view('laravelhtmldomparser::prizes.resultComp.resultXosoMax3D',['prize'=>$prizes[0]]);     
               }
          }
          else{ // typePrize is traditionalTicket
               $prize_period=strtotime(date("Y-m-d"));//strtotime("-1 day", strtotime(date('Y-m-d')));
               $prizes=Vietlott::getPrizesFromDB($request->typeResultLottery,$prize_period,false); 
               if($prizes && count($prizes)>0){
                    $prizes=Vietlott::PrepareDataXoSo($prizes); 
                    if($request->typeResultLottery==config('laravelhtmldomparser.categoryType.miennam.key'))
                    $resultLottery=view('laravelhtmldomparser::prizes.component.miennam',['prizes'=>$prizes]);
                    if($request->typeResultLottery==config('laravelhtmldomparser.categoryType.mientrung.key'))
                    $resultLottery=view('laravelhtmldomparser::prizes.component.mientrung',['prizes'=>$prizes]);
                    if($request->typeResultLottery==config('laravelhtmldomparser.categoryType.mienbac.key'))
                    $resultLottery=view('laravelhtmldomparser::prizes.component.mienbac',['prizes'=>$prizes]);
               }
          }  
          
          return  $resultLottery;
          
    } 

    public function showAllPrizeByDate(Request $request)
    {    
          if(isset($request->datePrize)){
               $arr=explode("_",$request->datePrize);
               // dd($arr);
               switch($arr[1]){
                    case config('laravelhtmldomparser.categoryType.miennam.key'):
                         return redirect()->route('prizes.showXosoMienNam',['prize_period'=>$arr[0]]); 
                    case config('laravelhtmldomparser.categoryType.mientrung.key'):
                         return redirect()->route('prizes.showXosoMienTrung',['prize_period'=>$arr[0]]); 
                    case config('laravelhtmldomparser.categoryType.mienbac.key'):
                         return redirect()->route('prizes.showXosoMienBac',['prize_period'=>$arr[0]]);
                    case config('laravelhtmldomparser.categoryType.mega645.key'):
                         $prize=Prize::where('prize_date',$arr[0])->where('category',config('laravelhtmldomparser.categoryType.mega645.key'))->first(); 
                         if($prize) return redirect()->route('prizes.showXosoMega645',['prize_period'=>str_replace("#","",$prize->prize_period)]); 
                         else return redirect()->route('prizes.showXosoMega645');
                    case config('laravelhtmldomparser.categoryType.power655.key'):
                         $prize=Prize::where('prize_date',$arr[0])->where('category',config('laravelhtmldomparser.categoryType.power655.key'))->first(); 
                         if($prize) return redirect()->route('prizes.showXosoPower655',['prize_period'=>str_replace("#","",$prize->prize_period)]); 
                         else return redirect()->route('prizes.showXosoPower655');
                    case config('laravelhtmldomparser.categoryType.max3d.key'):
                         $prize=Prize::where('prize_date',$arr[0])->where('category',config('laravelhtmldomparser.categoryType.max3d.key'))->first(); 
                         if($prize) return redirect()->route('prizes.showXosoMax3D',['prize_period'=>str_replace("#","",$prize->prize_period)]); 
                         else return redirect()->route('prizes.showXosoMax3D');

                    case config('laravelhtmldomparser.categoryType.max3dpro.key'):
                         $prize=Prize::where('prize_date',$arr[0])->where('category',config('laravelhtmldomparser.categoryType.max3dpro.key'))->first(); 
                         if($prize) return redirect()->route('prizes.showXosoMax3DPro',['prize_period'=>str_replace("#","",$prize->prize_period)]); 
                         else return redirect()->route('prizes.showXosoMax3DPro');

                    case config('laravelhtmldomparser.categoryType.keno.key'):
                         $prize=Prize::where('prize_date',$arr[0])->where('category',config('laravelhtmldomparser.categoryType.keno.key'))->first(); 
                         if($prize) return redirect()->route('prizes.showXosoKeno',['prize_period'=>str_replace("#","",$prize->prize_period)]); 
                         else return redirect()->route('prizes.showXosoKeno');
                         

                }
  
          }
          
    }
}

