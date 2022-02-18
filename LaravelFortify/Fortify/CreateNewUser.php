<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        //dd(config('laraveluserrole.defaultRoleId'));
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'digits_between:1,11', 
                Rule::unique(User::class)
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        // dd(config('laraveluserrole.defaultRoleId'));
        // dd($input);
        return User::create([
            'name' => $input['name'],
            'username' => $input['username'],
            'email' => $input['email'],
            'role_id'=>config('laraveluserrole.defaultRoleId'),
            'password' => Hash::make($input['password']),
        ]);
    }
}
