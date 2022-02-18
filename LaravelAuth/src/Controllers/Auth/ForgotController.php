<?php

namespace Phonglg\LaravelAuth\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class ForgotController extends Controller
{
    // form require send password
    public function index()
    {
        Log::debug('ForgotController');
        return view('laravelauth::auth.password.forgot-password');
    }

    // send email for customer
    public function request(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password ::sendResetLink(
            $request->only('email')
        );
    
        if($status === Password::RESET_LINK_SENT) // return back()->with(['message' => __($status).' Kiểm tra email để tạo mật khẩu mới!']);
            return back()->with(['message' => ' Kiểm tra email để tạo mật khẩu mới!']);
        else return  back()->withErrors(['email' => __($status)]); 

    }

    // reset password form
    public function reset(Request $request){
        //dd($request->token);

        return view('laravelauth::auth.password.reset-password', ['token' =>$request->token]);
    }

    // reset password form
    public function store(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]); 

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );

        if($status === Password::PASSWORD_RESET){
            // dd('v1:'.$status);    
            // return redirect()->route('login')->with('message', __($status).' Thay đổi mật khẩu thành công!');
            return redirect()->route('login')->with('message','Thay đổi mật khẩu thành công!');
        }
        else{
            // dd('v2:'.$status);    
            return back()->withErrors(['email' => [__($status)]]); 
        } 
            
         
    }
}