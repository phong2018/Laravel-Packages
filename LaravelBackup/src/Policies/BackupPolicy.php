<?php

namespace Phonglg\LaravelBackup\Policies;
 
use Phonglg\LaravelUserRole\Models\User as RoleUser; //models User in my Package
use App\Models\User; 
use Illuminate\Support\Facades\Auth;

class BackupPolicy
{ 
    private $currUser;

    public function __construct()
    {
       $this->currUser=RoleUser::find(Auth::id());
    }

    public function backup()
    {
        if($this->currUser->role->id==1)//admin
            return true;
        else return false;
    }
}
