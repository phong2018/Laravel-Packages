<?php

namespace Phonglg\LaravelTransaction\Controllers;

use App\Models\User;
use Illuminate\Http\Request; 
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller 
{
    public function runSession(){
        //DB::beginTransaction();
        //$user=User::where('id',9)->lockForUpdate()->first(); 
        $user=User::where('id',9)->first(); 
        dump('name:'.$user->name.'--'.$user->email);

        echo date('h:i:s') . "<br>";
        sleep(10); 
        echo date('h:i:s');   

        dump('name:'.$user->name.'--'.$user->email);
        $t=$user->name.' || '.date('h');
        dump('t:'.$t);
        $user->update(['name'=>$t]);
        //DB::commit();
    }
}