<?php

namespace Phonglg\LaravelAuth\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Phonglg\LaravelAuth\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Phonglg\LaravelUserRole\Models\Role;

class RegisterController extends Controller
{
    public function index()
    {
        if (Auth::check()) return redirect()->route('dashboard'); 
        $roles=Role::where('id','>=',3)->get();

        if(isset($_GET['p']))session(['presenter_id' => $_GET['p']]);

        // if(session()->get('presenter_id')) echo session()->get('presenter_id');
        
        return view('laravelauth::auth.register',['roles'=>$roles]);
    }

    public function store(Request $request)
    {
        //dd(session()->get('presenter_id'));
        //validation
        $this->validate($request, [
            'name' => 'required|max:255',
            'username' => [
                'digits_between:1,11', 
                Rule::unique(User::class)
            ],
            'email' => [   
                'max:255',
                Rule::unique(User::class),
            ], 
            'identity_card_number'=>[
                'max:255',
            ],
            'password' => 'required|confirmed',
            'captcha' => 'required|captcha'
        ]); 

        // get presenter
        $presenter=null;
        if(session()->get('presenter_id')) $presenter=User::where('username',session()->get('presenter_id'))->first();
        if($presenter) $presenter_id=$presenter->id; else $presenter_id=0;

        //---------
        if($request->email=='')$email='temp_email-'.$request->username.'-'.time().'@gmail.com';
        else $email=$request->email;

        //store user
        $fields=[
            'name' => $request->name,
            'username' => $request->username,
            'role_id'=>config('laraveluserrole.defaultRoleId'),
            'email' =>$email,
            'identity_card_number'=>$request->identity_card_number,
            'status' => config('laraveluserrole.userStatus.enable.key'),
            // 'presenter_id'=> $presenter_id,
            'password' => Hash::make($request->password),
        ];
        // dd($fields);
        
        $user=User::create($fields);
        // dd($user,session()->get('presenter_id'));

        //sign the user in
        Auth::attempt([
            'email' => $email,
            'password' => $request->password,
        ]);

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