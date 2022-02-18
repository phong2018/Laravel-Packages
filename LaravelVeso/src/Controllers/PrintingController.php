<?php

namespace Phonglg\LaravelVeso\Controllers;

use Illuminate\Http\Request;  
use Illuminate\Routing\Controller; 
use Phonglg\LaravelVeso\Helpers\Vietlott; 
use Illuminate\Support\Facades\Auth;

class PrintingController extends Controller 
{
    // __construct
    public function __construct()
    {
         
    }  

    // printingMienNam
    public function printingMienNam(Request $request){ 
        $categoryType=config('laravelhtmldomparser.categoryType.miennam.key');   
        if(isset($request->prize_period)) $prize_period=$request->prize_period;
        else $prize_period='';

        if(isset($request->numberPrint)) $numberPrint=$request->numberPrint;
        else $numberPrint=6; 

        $prizes=Vietlott::prepareDataTraditionalPrint($categoryType,$prize_period);

        // agencyInfo
        $data['agencyInfo']=[];
        if (Auth::check()){
            $data['agencyInfo']=(array)json_decode(Auth::user()->agency_info); 
        }

        return view('laravelveso::printing.miennam',['prizes'=>$prizes,'numberPrint'=>$numberPrint,'data'=>$data]);
    } 

    // printingMienTrung
    public function printingMienTrung(Request $request){ 

        $categoryType=config('laravelhtmldomparser.categoryType.mientrung.key');   
        if(isset($request->prize_period)) $prize_period=$request->prize_period;
        else $prize_period='';
        
        if(isset($request->numberPrint)) $numberPrint=$request->numberPrint;
        else $numberPrint=6; 

        $prizes=Vietlott::prepareDataTraditionalPrint($categoryType,$prize_period);
        // dd($prizes);
        // agencyInfo
        $data['agencyInfo']=[];
        if (Auth::check()){
            $data['agencyInfo']=(array)json_decode(Auth::user()->agency_info); 
        }

        return view('laravelveso::printing.mientrung',['prizes'=>$prizes,'numberPrint'=>$numberPrint,'data'=>$data]);
    }

    // printingMienBac
    public function printingMienBac(Request $request){
        $categoryType=config('laravelhtmldomparser.categoryType.mienbac.key');   
        if(isset($request->prize_period)) $prize_period=$request->prize_period;
        else $prize_period='';
        if(isset($request->numberPrint)) $numberPrint=$request->numberPrint;
        else $numberPrint=6; 

        $prizes=Vietlott::prepareDataTraditionalPrint($categoryType,$prize_period);

        // agencyInfo
        $data['agencyInfo']=[];
        if (Auth::check()){
            $data['agencyInfo']=(array)json_decode(Auth::user()->agency_info); 
        } 

        return view('laravelveso::printing.mienbac',['prizes'=>$prizes,'numberPrint'=>$numberPrint,'data'=>$data]);
    }

    // printingMega45
    public function printingMega645(Request $request){
        $categoryType=config('laravelhtmldomparser.categoryType.mega645.key');   
        if(isset($request->prize_period)) $prize_period="#".$request->prize_period;
        else $prize_period='';
        if(isset($request->numberPrint)) $numberPrint=$request->numberPrint;
        else $numberPrint=6; 
        $prizes=Vietlott::prepareDataVietlottPrint($categoryType,$prize_period);
        // dd($prizes[0]);

        // agencyInfo 
        $data['agencyInfo']=[];
        if (Auth::check()){
            $data['agencyInfo']=(array)json_decode(Auth::user()->agency_info); 
        }

        return view('laravelveso::printing.mega645',['prizes'=>$prizes[0],'numberPrint'=>$numberPrint,'data'=>$data]);
    }

    // printingPower655
    public function printingPower655(Request $request){
        $categoryType=config('laravelhtmldomparser.categoryType.power655.key');   
        if(isset($request->prize_period)) $prize_period="#".$request->prize_period;
        else $prize_period='';
        if(isset($request->numberPrint)) $numberPrint=$request->numberPrint;
        else $numberPrint=6; 
        $prizes=Vietlott::prepareDataVietlottPrint($categoryType,$prize_period);
        // dd($prizes[0]);

        // agencyInfo
        $data['agencyInfo']=[];
        if (Auth::check()){
            $data['agencyInfo']=(array)json_decode(Auth::user()->agency_info); 
        }

        return view('laravelveso::printing.power655',['prizes'=>$prizes[0],'numberPrint'=>$numberPrint,'data'=>$data]);
    }

    // printingMax3D
    public function printingMax3D(Request $request){
        $categoryType=config('laravelhtmldomparser.categoryType.max3d.key');   
        if(isset($request->prize_period)) $prize_period="#".$request->prize_period;
        else $prize_period='';
        if(isset($request->numberPrint)) $numberPrint=$request->numberPrint;
        else $numberPrint=6; 
        $prizes=Vietlott::prepareDataVietlottPrint($categoryType,$prize_period);
        // dd($prizes);

        // agencyInfo
        $data['agencyInfo']=[];
        if (Auth::check()){
            $data['agencyInfo']=(array)json_decode(Auth::user()->agency_info); 
        }

        return view('laravelveso::printing.max3d',['prizes'=>$prizes[0],'numberPrint'=>$numberPrint,'data'=>$data]);
    }

    // printingMax3DPro
    public function printingMax3DPro(Request $request){
        $categoryType=config('laravelhtmldomparser.categoryType.max3dpro.key');   
        if(isset($request->prize_period)) $prize_period="#".$request->prize_period;
        else $prize_period='';
        if(isset($request->numberPrint)) $numberPrint=$request->numberPrint;
        else $numberPrint=6; 
        $prizes=Vietlott::prepareDataVietlottPrint($categoryType,$prize_period);

        // agencyInfo
        $data['agencyInfo']=[];
        if (Auth::check()){
            $data['agencyInfo']=(array)json_decode(Auth::user()->agency_info); 
        }
        
        return view('laravelveso::printing.max3dpro',['prizes'=>$prizes[0],'numberPrint'=>$numberPrint,'data'=>$data]);
    } 
}