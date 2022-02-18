<?php

namespace Phonglg\LaravelPost\Policies;

use Phonglg\LaravelPost\Models\Thread;
use Phonglg\LaravelUserRole\Models\User as RoleUser; //models User in my Package
use App\Models\User; 
use Illuminate\Support\Facades\Auth;

class ThreadPolicy
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
        
        if(in_array('Thread:viewAny',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AppPhonglg\LaravelVeso\Models\Thread  $thread
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Thread $thread)
    {
        //
        if(in_array('Thread:view',json_decode($this->currUser->role->permissions))) return true;
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
        if(in_array('Thread:create',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AppPhonglg\LaravelVeso\Models\Thread  $thread
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Thread $thread)
    {
        //
        if(in_array('Thread:update',json_decode($this->currUser->role->permissions))
        && ($thread->user_create_id==Auth::id() || Auth::user()->role_id<config('laraveluserrole.defaultRoleId')) 
        ) return true;
        else return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AppPhonglg\LaravelVeso\Models\Thread  $thread
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Thread $thread)
    {
        //
        if(in_array('Thread:delete',json_decode($this->currUser->role->permissions))
        && ($thread->user_create_id==Auth::id() || Auth::user()->role_id<config('laraveluserrole.defaultRoleId'))    
        ) return true;
        else return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AppPhonglg\LaravelVeso\Models\Thread  $thread
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Thread $thread)
    {
        //
        if(in_array('Thread:restore',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AppPhonglg\LaravelVeso\Models\Thread  $thread
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Thread $thread)
    {
        //
        if(in_array('Thread:foreDelete',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }
}
