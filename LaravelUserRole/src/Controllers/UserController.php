<?php

namespace Phonglg\LaravelUserRole\Controllers;

use App\Http\Controllers\Controller;
use Phonglg\LaravelUserRole\Models\Role;
use Phonglg\LaravelUserRole\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Phonglg\LaravelLayout\Helpers\InputForm;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        // Authorizing Resource Controllers
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(json_decode(auth()->user()->role->permissions));

        //
        // $this->authorize('viewAny', User::class); 
        $users = User::with('role')->get();
         
        return view('laraveluserrole::users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize(['create'], User::class);
        $roles=Role::All();
        $status=InputForm::getStatusUser();
        return view('laraveluserrole::users.create',['roles'=>$roles,'status'=>$status]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->authorize('create', User::class);
        //validation
        $fields=$this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'status' => 'required',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed',
            'role_id' => 'required|numeric|min:1',
        ]);
        

        $fields['password'] = Hash::make($fields['password']);

        //store user
        User::create($fields);
        

        return redirect()->route('users.index')->with('message', 'User create success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        // $this->authorize('view', User::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // $this->authorize('update', User::class);

        //return view('users.edit', ['user' => $user]);

        $status=InputForm::getStatusUser();

        $roles=Role::All();

        return view('laraveluserrole::users.edit', ['user' => $user,'roles'=>$roles,'status'=>$status]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        // $this->authorize('update', User::class);

        $fields = $this->validate($request, [
            'name' => 'required|max:255',
            'status' => 'required',
            'username' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user['id'],
            'password' => 'confirmed',
            'role_id' => 'required|numeric|min:1',
        ]);

        if (!empty($fields['password'])) {
            $fields['password'] = Hash::make($fields['password']);
        } else {
            $fields = Arr::except($fields, array('password'));
        }

        $user->update($fields);

        return redirect()->route('users.index')->with('message', 'User update success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(User $user)
    {
        // $this->authorize('delete', User::class);
        $user->delete();
        return back();
    }
}