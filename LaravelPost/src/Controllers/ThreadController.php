<?php

namespace Phonglg\LaravelPost\Controllers;
 
use Illuminate\Http\Request; 
use Illuminate\Routing\Controller;  
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;  
use Phonglg\LaravelLayout\Helpers\InputForm;
use Phonglg\LaravelPost\Models\Post;
use Phonglg\LaravelPost\Models\Thread;

class ThreadController extends Controller 
{
    use AuthorizesRequests;

    public function __construct()
    {
        // Authorizing Resource Controllers
        $this->authorizeResource(Thread::class, 'thread');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    { 
        if(isset($_GET['title'])){
            $data['threads'] = Thread::orderBy('title','ASC')->where('title','like','%'.$_GET['title'].'%')->paginate(10)->appends(['title'=>$_GET['title']]);  
            $data['title']=$_GET['title'];
        }
        else{
            $data['threads'] = Thread::orderBy('title','ASC')->paginate(10);  
            $data['title']='';
        }

        return view('laravelpost::thread.index',['data'=>$data]);
        
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[]; 
        $data['threads']=Thread::all()->sortBy("title");
        $data['status']=InputForm::getStatus();
        return view('laravelpost::thread.create',['data'=>$data]);
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields=$this->validThread($request);   

        $thread=Thread::create($fields);  
        $thread->update(['slug'=>Str::slug($thread->id.'-'.$thread->title)]);
      
        return redirect()->route('thread.index')->with('message','Tạo thread thành công'); 

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

    public function showSlug(Request $request){ 
        $thread=Thread::where('slug',$request->slug)->first();
     
        $data['posts']=$thread->posts;
    
        return view('laravelpost::thread.showSlug',['thread'=>$thread,'data'=> $data]);  
    }

    public function validThread($request){ 
 
        return $fields=array(
            'title'=>$request->title,
            'description'=>$request->description,  
            'parent_id'=>$request->parent_id,  
            'sort_order'=>$request->sort_order,  
            'user_create_id'=>Auth::id(),
            'status'=>$request->status,
        ); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        $data['threads']=Thread::all()->sortBy("title");
        $data['status']=InputForm::getStatus(); 
        return view('laravelpost::thread.edit',['thread'=>$thread,'data'=>$data]);  

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    { 
       
        $fields=$this->validThread($request);   

        $thread->update($fields);  
        $thread->update(['slug'=>Str::slug($thread->id.'-'.$thread->title)]);
      
        return redirect()->route('thread.index')->with('message','Sửa thread thành công'); 
        
    }

    

    public function copy(Thread $thread)
    {
        $fields=array(
            'title'=>$thread->title.'(1)',
            'description'=>$thread->description, 
            'user_create_id'=>Auth::id(),
            'status'=>'',
        );  

        $newThread=Thread::create($fields);  
        $newThread->update(['slug'=>Str::slug($newThread->id.'-'.$newThread->title)]);
        return redirect()->route('thread.index')->with('message','Sao chép thread thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        $thread->delete();
        return back();
    } 
}