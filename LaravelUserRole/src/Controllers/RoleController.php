<?php

namespace Phonglg\LaravelUserRole\Controllers;

use Phonglg\LaravelUserRole\Helpers\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Phonglg\LaravelUserRole\Models\Role;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoleController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        // Authorizing Resource Controllers
        // method authorizeResource() use App\Models\User;
        $this->authorizeResource(Role::class, 'role');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('laraveluserrole::roles.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $permissionsForRole=config('laraveluserrole.permissionsForRole');
        return view('laraveluserrole::roles.create', ['permissionsForRole' => $permissionsForRole]);
 
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
        $fields = $this->validate($request, [
            'name' => 'required|max:256',
        ]); 

        Role::create([
            'name' => $fields['name'],
            'slug' => Str::slug($fields['name']),
            'permissions' => ($request['permissions']!=null)?json_encode($request['permissions']):'[]',
        ]);
 
        return redirect()->route('roles.index')->with('message', 'Role create success');
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
    public function edit(Role $role)
    {
        //
        $permissionsForRole=config('laraveluserrole.permissionsForRole');
        return view('laraveluserrole::roles.edit', ['role' => $role,'permissionsForRole' => $permissionsForRole]);
 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
        $fields = $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $fields['slug']=Str::slug($fields['name']);
        $fields['permissions']=($request['permissions']!=null)?json_encode($request['permissions']):'[]';

        $role->update($fields);

        return redirect()->route('roles.index')->with('message', 'Role update success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
        $role->delete();
        return back();
    }

    public function optionFunction(Role $role)
    {
        //$this->authorize('viewAny', Role::class); //ok
        //$this->authorize('update',$role); //ok
        dd('optionFunction');
    }
}