<?php

namespace Phonglg\LaravelEcommerce\Policies;

use Phonglg\LaravelEcommerce\Models\Category;
use Phonglg\LaravelUserRole\Models\User as RoleUser; //models User in my Package
use App\Models\User; 
use Illuminate\Support\Facades\Auth;

class CategoryPolicy
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
        
        if(in_array('Category:viewAny',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Category $category)
    {
        //
        if(in_array('Category:view',json_decode($this->currUser->role->permissions))) return true;
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
        if(in_array('Category:create',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Category $category)
    {
        //
        if(in_array('Category:update',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Category $category)
    {
        //
        if(in_array('Category:delete',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Category $category)
    {
        //
        if(in_array('Category:restore',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Category $category)
    {
        //
        if(in_array('Category:foreDelete',json_decode($this->currUser->role->permissions))) return true;
        else return false;
    }
}
