<?php

namespace Phonglg\LaravelAuth\Policies;
use App\Models\User;  
use Illuminate\Support\Facades\Auth;

class AccountPolicy
{ 
    function update(User $user, User $model) {
        return $user->id === $model->id;
    }
}