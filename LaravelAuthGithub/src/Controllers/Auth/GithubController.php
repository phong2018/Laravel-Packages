<?php

namespace Phonglg\LaravelAuthGithub\Controllers\Auth;

use App\Http\Controllers\Controller; 
use Laravel\Socialite\Facades\Socialite;

class GithubController extends Controller
{ 
    public function redirect(){
        return Socialite::driver('github')->redirect();
        // dd("helo");
    }
    public function callback(){
        $user = Socialite::driver('github')->user();
        dd($user); 
    }
}
