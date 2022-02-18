<?php

namespace Phonglg\LaravelLayout\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    //
    public function index()
    {
        return view('laravellayout::dashboard');
    }

    public function getMethod()
    {
        return ['success getMethod'];
    }

    public function postMethod()
    {
        return ['success postMethod'];
    }
    public function postInputsMethod(Request $request)
    { 
        $request->validate([
            'name'=>'required', 
            'age'=>'required|numeric|min:5', 
        ]);  
    }
     
}