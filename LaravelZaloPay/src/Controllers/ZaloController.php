<?php

namespace Phonglg\LaravelZaloPay\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 

class ZaloController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        return view('laravelzalopay::index2');
    }
 
}