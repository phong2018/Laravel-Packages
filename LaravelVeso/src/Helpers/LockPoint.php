<?php

namespace Phonglg\LaravelVeso\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\File;
use Phonglg\LaravelLayout\Helpers\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LockPoint
{
    // check getCheckLockPointUsers
    public static function checkLockPointUsers($users)
    {
        Log::debug('checkLockPointUsers');Log::debug($users);
        $countNotBlockPoint=0;// not LockPoint
        $allUser=[];
        $tempUser=User::where('id',11)->first();  
        Log::debug('tempUserxxxxx:');
        Log::debug( $tempUser);

        DB::beginTransaction();
            // check all is not lock_point
            foreach($users as $user){ 
                Log::debug('checkLockPointUsers------:'.$user->id);
                $tempUser=User::where('id',$user->id)->where('lock_point','<>',1)->lockForUpdate()->first();  
                Log::debug('$tempUser---:'.$tempUser);

                if($tempUser){
                    $countNotBlockPoint++;
                    $allUser[]=$tempUser;
                }
            }
            // if all not lock_point
            if($countNotBlockPoint==count($users))
                foreach($allUser as $user)  $user->update(['lock_point'=>1]);

        DB::commit();  

        Log::debug('checkLockPointUsers: '.$countNotBlockPoint);

        return !($countNotBlockPoint==count($users));
    }
    
    public static function unLockPointUsers($users)
    {
        Log::debug('unLockPointUsers'); 
        DB::beginTransaction();
            foreach($users as $user){ 
                $tempUser=User::where('id',$user->id)->lockForUpdate()->first();  
                $tempUser->update(['lock_point'=>0]);
            } 
        DB::commit();  
    }
    
 
}