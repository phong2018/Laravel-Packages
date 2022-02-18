<?php

namespace Phonglg\LaravelUserRole\Policies;

use Phonglg\LaravelUserRole\Models\Customer;
use Phonglg\LaravelUserRole\Models\User as RoleUser; //models User in my Package
use App\Models\User; 
use Illuminate\Support\Facades\Auth;

class CustomerPolicy
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
        
        if(in_array('Customer:viewAny',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Customer  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Customer $category)
    {
        //
        if(in_array('Customer:view',json_decode($this->currUser->role->permissions))) return true;
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
        if(in_array('Customer:create',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Customer  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Customer $category)
    {
        //
        if(in_array('Customer:update',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Customer  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Customer $category)
    {
        //
        if(in_array('Customer:delete',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Customer  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Customer $category)
    {
        //
        if(in_array('Customer:restore',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Customer  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Customer $category)
    {
        //
        if(in_array('Customer:foreDelete',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }
}
