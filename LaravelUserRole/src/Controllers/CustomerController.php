<?php

namespace Phonglg\LaravelUserRole\Controllers;

use App\Http\Controllers\Controller;
use Phonglg\LaravelUserRole\Models\Role;
use Phonglg\LaravelUserRole\Models\Customer; 
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Phonglg\LaravelAuth\Models\UserLog;
use Phonglg\LaravelLayout\Helpers\InputForm;
use Phonglg\LaravelVeso\Helpers\Vietlott;

class CustomerController extends Controller 
{
    use AuthorizesRequests;

    public function __construct()
    {
        // Authorizing Resource Controllers
        $this->authorizeResource(Customer::class, 'customer');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $this->authorize('viewAny', Customer::class); 
        $users = Customer::with('role')->where('role_id',config('laraveluserrole.defaultRoleId'))->get();
        return view('laraveluserrole::customers.index', ['users' => $users]);
    }

    //customerLog
    public function customerLog(Customer $customer)
    { 
        $logs=UserLog::with('user')->where('userId',$customer->id)->orderBy('id','DESC')->paginate(20); 

        $data['template']='laravellayout::layouts.admin';

        return view('laravelauth::auth.logsList',['logs'=>$logs,'data'=>$data]);      
    }

    public function agencyList()
    { 
        // $this->authorize('viewAny', Customer::class); 
        $users = Customer::with('role')->where('role_id',config('laraveluserrole.defaultAgencyRoleId'))->get();
        return view('laraveluserrole::customers.agencyList', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize(['create'], User::class);
        $roles=Role::where('id','>=',config('laraveluserrole.defaultRoleId'))->get();
        return view('laraveluserrole::customers.create',['roles'=>$roles]);
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // $this->authorize('create', User::class); 

        $fields=$this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed',
            'role_id' => 'required|numeric|min:3',
        ]);

        $fields['password'] = Hash::make($fields['password']);

        //store user
        Customer::create($fields);
        

        return redirect()->route('customers.index')->with('message', 'Customer create success');
       
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    { 
       // $this->authorize('update', User::class); 

       $status=InputForm::getStatusUser();

       $roles=Role::where('id','>=',config('laraveluserrole.defaultRoleId'))->get();
        return view('laraveluserrole::customers.edit', ['user' => $customer,'roles'=>$roles,'status'=>$status]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        // $this->authorize('update', User::class);
 

        $fields = $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'status' => 'required',
            'email' => 'required|email|max:255|unique:users,email,' . $customer['id'],
            'password' => 'confirmed',
            'role_id' => 'required|numeric|min:3',
        ]);

        if (!empty($fields['password'])) {
            $fields['password'] = Hash::make($fields['password']);
        } else {
            $fields = Arr::except($fields, array('password'));
        }

        $customer->update($fields);

        return redirect()->route('customers.index')->with('message', 'User update success');
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
         // $this->authorize('delete', User::class);
         $customer->delete();
         return back();
        
    } 
}