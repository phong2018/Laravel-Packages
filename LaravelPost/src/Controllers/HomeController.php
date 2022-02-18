<?php

namespace Phonglg\LaravelPost\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Routing\Controller;  
use Illuminate\Support\Str;  
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Phonglg\LaravelLayout\Helpers\InputForm;
use Phonglg\LaravelPost\Models\Post;
use Phonglg\LaravelPost\Models\Thread;

class HomeController extends Controller 
{ 

    public function index()
    {     
        $data['post']=Post::find(1); 
        return view('laravelpost::home.index',['data'=>$data]);
    }

    public function aboutUs()
    { 
        $data['post']=Post::find(2); 
        return view('laravelpost::home.index',['data'=>$data]);
    }

    public function search()
    { 
        if(isset($_GET['title']) && $_GET['title']!=''){
            $data['posts']=Post::where('title','like','%'.$_GET['title'].'%')->take(100)->get();
            $data['title']=$_GET['title'];
        }
        else{
            $data['posts']=[];
            $data['title']='';
        }
        return view('laravelpost::home.search',['data'=>$data]);
    }

     
}