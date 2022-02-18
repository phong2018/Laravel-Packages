<?php

namespace Phonglg\LaravelPost\Policies;

use Phonglg\LaravelPost\Models\Post;
use Phonglg\LaravelUserRole\Models\User as RoleUser; //models User in my Package
use App\Models\User; 
use Illuminate\Support\Facades\Auth;

class PostPolicy
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
        
        if(in_array('Post:viewAny',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AppPhonglg\LaravelVeso\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Post $post)
    {
        //
        if(in_array('Post:view',json_decode($this->currUser->role->permissions))) return true;
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
        if(in_array('Post:create',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AppPhonglg\LaravelVeso\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Post $post)
    {
        //
        if(in_array('Post:update',json_decode($this->currUser->role->permissions))
        && ($post->user_create_id==Auth::id() || Auth::user()->role_id<config('laraveluserrole.defaultRoleId')) 
        ) return true;
        else return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AppPhonglg\LaravelVeso\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Post $post)
    {
        //
        if(in_array('Post:delete',json_decode($this->currUser->role->permissions))
        && ($post->user_create_id==Auth::id() || Auth::user()->role_id<config('laraveluserrole.defaultRoleId'))    
        ) return true;
        else return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AppPhonglg\LaravelVeso\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Post $post)
    {
        //
        if(in_array('Post:restore',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AppPhonglg\LaravelVeso\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Post $post)
    {
        //
        if(in_array('Post:foreDelete',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }
}
