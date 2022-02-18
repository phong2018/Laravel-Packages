<?php

namespace Phonglg\LaravelSetting\Controllers;

use App\Models\User;
use Illuminate\Http\Request; 
use Illuminate\Routing\Controller;
use Phonglg\LaravelSetting\Models\Setting; 
use Illuminate\Support\Str; 
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SettingController extends Controller 
{
    use AuthorizesRequests;

    public function __construct()
    {
        // Authorizing Resource Controllers
        $this->authorizeResource(Setting::class, 'setting');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::orderByDesc('category')->get();

        return view('laravelsetting::settings.index', ['settings' => $settings]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('laravelsetting::settings.create');
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
        $request->validate([
            'name'=>'required|max:256',
            'category'=>'required',
            'key'=>'required',
            'value'=>'required',
            'serialized'=>'required',
        ]); 

        $fields=array(
            'name'=>$request->name, 
            'category'=>$request->category,
            'key'=>$request->key,
            'value'=>$request->value,
            'serialized'=>$request->serialized
        );
    
        Setting::create($fields);
        
        return redirect()->route('settings.index')->with('message','Setting create success');

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
    public function edit(Setting $Setting)
    {
        //
        return view('laravelsetting::settings.edit',['setting'=>$Setting]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $Setting)
    {
        // 
        $request->validate([
            'name'=>'required|max:256',
            'category'=>'required', 
            'value'=>'required',
            'serialized'=>'required',
        ]); 

        $fields=array(
            'name'=>$request->name, 
            'category'=>$request->category, 
            'value'=>$request->value,
            'serialized'=>$request->serialized
        );
        
        $Setting->update($fields);
        
        return redirect()->route('settings.index')->with('message','Setting update success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $Setting)
    {
        //
        $Setting->delete();
        return back();
    } 

    public function resetPointCustomer()
    { 
        $this->authorize('create', Setting::class);
        
        $users=User::all();
        foreach($users as $user){
            $point_info=['pointAdd'=> $user->point];
            $user->update(['point_info'=>json_encode($point_info)]);
        }
        return back()->with('message','Reset Point Info success');
    }

     
}