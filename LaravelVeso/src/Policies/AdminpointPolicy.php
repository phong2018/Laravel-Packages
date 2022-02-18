<?php

namespace Phonglg\LaravelVeso\Policies;

use Phonglg\LaravelVeso\Models\Point;
use Phonglg\LaravelUserRole\Models\User as RoleUser; //models User in my Package
use App\Models\User; 
use Illuminate\Support\Facades\Auth;

class AdminpointPolicy
{ 

    private $currUser;

    public function __construct()
    {
       $this->currUser=RoleUser::find(Auth::id());
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        
        if(in_array('Point:viewAny',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $point
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Point $point)
    {
        //
        if(in_array('Point:view',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
        if(in_array('Point:create',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $point
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Point $point)
    {
        //
        if(in_array('Point:update',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    public function updateOrderAddPoint(User $user)
    {
        // 
        if(in_array('Point:updateOrderAddPoint',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    public function updatePointAgency(User $user){
        // 
        if(in_array('Point:updatePointAgency',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $point
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Point $point)
    {
        //
        if(in_array('Point:delete',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $point
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Point $point)
    {
        //
        if(in_array('Point:restore',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $point
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Point $point)
    {
        //
        if(in_array('Point:foreDelete',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }
}
