<?php

namespace Phonglg\LaravelVeso\Controllers;

use App\Models\User;
use Illuminate\Http\Request; 
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Phonglg\LaravelHtmlDomParser\Models\Prize;
use Phonglg\LaravelVeso\Helpers\Vietlott;
use Phonglg\LaravelVeso\Models\Orderdetail;
use Phonglg\LaravelVeso\Notifications\WinPrizeNotifications;
use Phonglg\LaravelVeso\Services\WinPrizeServices;

class WinPrizeController extends Controller 
{ 
    // list
    public function list(){  
        $notifications=Auth::user()->notifications()->paginate(20); 
        $template=Vietlott::getLayoutForUser();  
        return view('laravelveso::notification.list', ['template'=>$template,'notifications'=>$notifications]);           
    }  
    public function show(Request $request){ 
   
        $notification = Auth::user()->notifications()->find($request->notification);
        //dd($notification->data['message']['orderId']);
        if($notification) {
            $notification->markAsRead();
            $userRoleId=Auth::user()->role_id;
            // redirect
            if($userRoleId<config('laraveluserrole.defaultRoleId')){ // for admin & employee
                if(isset($notification->data['message']['orderId']))
                return redirect()->route('admin.order.show',['order'=>$notification->data['message']['orderId']]); 
            }
            else
                if(isset($notification->data['message']['orderId']))
                return redirect()->route('customer.order.show',['order'=>$notification->data['message']['orderId']]); 

            return back();
        }
    }
    // send
    public function send(){ 
        $message=[
            'body'=>'You receive Notification ViaDatabase',
            'enrollmentText'=>'you are allow enroll',
            'url'=>url('/'),
            'thankyou'=>'Thank you urrlll',
        ]; 
        $user=User::find(11); 
        Notification::send($user, new WinPrizeNotifications($user,$message)); 
        dd('gui ghi chus');
    } 
} 