<?php

namespace Phonglg\LaravelAuth\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function index()
    {
        if (Auth::check()) return redirect()->route('dashboard'); 

        return view('laravelauth::auth.login');
        
    }
    public function store(Request $request)
    {
       
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        
        if (!auth()->attempt($request->only('username', 'password'), $request->remember)) {
            return back()->with('error', 'Sai thông tin đăng nhập!');
        }


        if(Auth::user()->status==config('laraveluserrole.userStatus.disable.key')){
            auth()->logout();
            return back()->with('error', 'Tài khoản đang bị khóa!');
        }
        

        if(Auth::user()->role_id<3) return redirect()->route('dashboard'); // admin page
        else{// customer page
            // check if return back to Cart
            if(session()->get('backToCheckout')){
                session(['backToCheckout' => false]);
                return redirect()->route('cart.checkout');
            }
            return redirect()->route('account.edit'); 
        }
    }
}