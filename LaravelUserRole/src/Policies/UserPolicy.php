<?php

namespace Phonglg\LaravelUserRole\Policies;
use Phonglg\LaravelUserRole\Models\User as RoleUser; //models User in my Package
use App\Models\User;  
use Illuminate\Support\Facades\Auth;

class UserPolicy
{ 
    
    private $currUser;

    public function __construct()
    {
       $this->currUser=RoleUser::find(Auth::id());
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Phonglg\LaravelUserRole\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {  
        if(in_array('User:viewAny',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, RoleUser $model)
    {
        if(in_array('User:view',json_decode($this->currUser->role->permissions))) return true;
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
        if(in_array('User:create',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, RoleUser $model)
    {
        //
         //
         if(in_array('User:update',json_decode($this->currUser->role->permissions))
        // || ($this->currUser->id == $model->id)
         ) return true;
         else return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, RoleUser $model)
    {
        // dont allow delete superUser admin
        if(in_array('User:delete',json_decode($this->currUser->role->permissions)) && $model->id!=1) return true;
        else return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, RoleUser $model)
    {
        // 
         if(in_array('User:restore',json_decode($this->currUser->role->permissions))) return true;
         else return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, RoleUser $model)
    {
        //
        if(in_array('User:forceDelete',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    
    
}