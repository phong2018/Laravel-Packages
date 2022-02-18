<?php

namespace Phonglg\LaravelAuth\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Phonglg\LaravelAuth\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Phonglg\LaravelUserRole\Models\Role;

class RegisterMultiRoleController extends Controller
{
    public function index()
    {
        if (Auth::check()) return redirect()->route('dashboard'); 
        $roles=Role::where('id','>=',3)->get();
        
        return view('laravelauth::auth.register',['roles'=>$roles]);
    }

    public function store(Request $request)
    {
        //validation
        $this->validate($request, [
            'name' => 'required|max:255',
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
            'role_id'=>'required',
            'password' => 'required|confirmed'
        ]);

        // prepare status for customer
        if($request->role_id==config('laraveluserrole.defaultRoleId')) // customer for buying lottery
            $userStatus=config('laraveluserrole.userStatus.enable.key');
        else $userStatus=config('laraveluserrole.userStatus.disable.key'); // this is lottery agency

        //store user
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'role_id'=>$request->role_id,
            'email' => $request->email,
            'status' => $userStatus,
            'password' => Hash::make($request->password),
        ]);

        //sign the user in
        Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // check if return back to Cart
        if(session()->get('backToCheckout')){
            session(['backToCheckout' => false]);
            return redirect()->route('cart.checkout');
        }

        if(Auth::user()->role_id<3) return redirect()->route('dashboard'); // admin page
        else return redirect()->route('account.edit'); // customer page
    }
}