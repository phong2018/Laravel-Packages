<?php

namespace Phonglg\LaravelLayout\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Phonglg\LaravelHtmlDomParser\Models\Prize;
use Phonglg\LaravelVeso\Helpers\Vietlott;

class HomeController extends Controller
{
    // index
    public function index(Request $request)
    {   
        // miennam
        $categoryType=config('laravelhtmldomparser.categoryType.miennam.key');   
        if(isset($request->prize_period)) $prize_period=$request->prize_period;
        else $prize_period='';
        $data['miennamPrizes']=Vietlott::prepareDataTraditionalPrint($categoryType,$prize_period); 
        // mien trung
        $categoryType=config('laravelhtmldomparser.categoryType.mientrung.key');   
        if(isset($request->prize_period)) $prize_period=$request->prize_period;
        else $prize_period='';
        $data['mientrungPrizes']=Vietlott::prepareDataTraditionalPrint($categoryType,$prize_period);
        // mien bac
        $categoryType=config('laravelhtmldomparser.categoryType.mienbac.key');   
        if(isset($request->prize_period)) $prize_period=$request->prize_period;
        else $prize_period='';
        $data['mienbacPrizes']=Vietlott::prepareDataTraditionalPrint($categoryType,$prize_period);
        // max3d
        $categoryType=config('laravelhtmldomparser.categoryType.max3d.key');   
        if(isset($request->prize_period)) $prize_period="#".$request->prize_period;
        else $prize_period='';
        $data['max3dPrizes']=Vietlott::prepareDataVietlottPrint($categoryType,$prize_period);
        // max3dpro
        $categoryType=config('laravelhtmldomparser.categoryType.max3dpro.key');   
        if(isset($request->prize_period)) $prize_period="#".$request->prize_period;
        else $prize_period='';
        $data['max3dproPrizes']=Vietlott::prepareDataVietlottPrint($categoryType,$prize_period);
        // mega645
        $categoryType=config('laravelhtmldomparser.categoryType.mega645.key');   
        if(isset($request->prize_period)) $prize_period="#".$request->prize_period;
        else $prize_period='';
        $data['mega645Prizes']=Vietlott::prepareDataVietlottPrint($categoryType,$prize_period);
        // power655
        $categoryType=config('laravelhtmldomparser.categoryType.power655.key');   
        if(isset($request->prize_period)) $prize_period="#".$request->prize_period;
        else $prize_period='';
        $data['power655Prizes']=Vietlott::prepareDataVietlottPrint($categoryType,$prize_period);
        // keno
        $data['kenoPrizes']=Prize::where('category',config('laravelhtmldomparser.categoryType.keno.key'))
         ->orderBy('id','DESC')->take(1)->get();
        $data['kenoPrizes']=Vietlott::PrepareDataXoSo($data['kenoPrizes']);

        // dd($data);
        // return view
        return view('laravellayout::home',['data'=>$data]); 
    }

    public function results(Request $request)
    {  
        if($request->date) $date=$request->date;
        else $date=''; 
       

        return view('laravellayout::home'); 
    }
     
}


 