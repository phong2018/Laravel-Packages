<?php

namespace Phonglg\LaravelPost\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Routing\Controller;  
use Illuminate\Support\Str;  
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Phonglg\LaravelLayout\Helpers\InputForm;
use Phonglg\LaravelPost\Models\Post;
use Phonglg\LaravelPost\Models\Thread;

class PostController extends Controller 
{
    use AuthorizesRequests;

    public function __construct()
    {
        // Authorizing Resource Controllers
        $this->authorizeResource(Post::class, 'post');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if(isset($_GET['title'])){
            $data['posts'] = Post::orderByDesc('id')->where('title','like','%'.$_GET['title'].'%')->paginate(10)->appends(['title'=>$_GET['title']]);      
            $data['title']=$_GET['title'];
        }
        else{
            $data['posts'] = Post::orderByDesc('id')->paginate(10); 
            $data['title']='';
        }

        return view('laravelpost::post.index',['data'=>$data]);
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
        return view('laravelpost::post.create',['data'=>$data]);
    }



    public function getData_store3(){
        $posts=Post::all();
        foreach($posts as $post){ 
            $img=str_replace('Posts/Phongthuy/','Phongthuy/',$post->image);
            $post->update(['image'=>$img]);
        }
    }

    public function getData_Store(){
        $threads=DB::table('oc_thread')->get();
        
        foreach($threads as $thread){
            $parent= DB::table('oc_thread')->where('oc_thread.thread_id',$thread->parent_id)->first();
            if($parent){
                $newthread=Thread::where('title',$thread->name)->first();
                $parentThread=Thread::where('title',$parent->name)->first();
                //if($newthread && $parentThread)  
                $newthread->update(['parent_id'=>$parentThread->id]);
                //echo $newthread->title.'------'.$parentThread->title.'<br>';
                //dd($newthread,$parentThread);
            }
        }
    }

    public function getData_Store2(){
        
        Thread::query()->delete();
        Post::query()->delete(); 
        DB::table('plg_post_thread')->delete(); 

        $threads=DB::table('oc_thread')->get();
        
        foreach($threads as $thread){
            //dd(gettype($thread),$thread);
            $fields=array(
                'title'=>$thread->name,
                'description'=>html_entity_decode($thread->description),  
                'user_create_id'=>Auth::id(), 
                'status'=>1,
            );
            $newsthread=Thread::create($fields);  
            $newsthread->update(['slug'=>Str::slug($newsthread->id.'-'.$newsthread->title)]);
            //--------
            $posts=DB::table('oc_post')
                ->join('oc_post_to_thread', 'oc_post.post_id', '=', 'oc_post_to_thread.post_id')
                ->join('oc_thread', 'oc_thread.thread_id', '=', 'oc_post_to_thread.thread_id')
                ->where('oc_thread.thread_id',$thread->thread_id)
                ->select('oc_post.title','oc_post.description','oc_post.short_description','oc_post.image','oc_post.status','oc_post.id','oc_post.tag')
                ->get();
            
            foreach($posts as $post){ 
 
                
                $img=str_replace('catalog/Post/','/storage/photos/1/Posts/',$post->image);
                $img=str_replace('catalog/','/storage/photos/1/Posts/',$post->image);
                $img=str_replace('07-03-2021/phong/','',$img);
                $img=str_replace('c++.png','cplusplus.png',$img);
                $img=str_replace('Posts/Post/','Posts/',$img);
                
                $fields=array(
                    'title'=>$post->title,
                    'description'=>$post->title,
                    'tag'=>$post->tag,
                    'content'=>html_entity_decode($post->short_description.$post->description),
                    'publish_date'=>date('Y-m-d'), 
                    'image'=>$img,
                    'user_create_id'=>Auth::id(),
                    'status'=>$post->status, 
                ); 
                $newPost=Post::where('title',$post->title)->first();
                if(!$newPost)  $newPost=Post::create($fields);  

                $newPost->update(['slug'=>Str::slug($newPost->id.'-'.$post->title)]);
                
                DB::table('plg_post_thread')->insert([
                    'post_id' => $newPost->id,
                    'thread_id' => $newsthread->id
                ]);

                
            } 
        }
    }
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields=$this->validPost($request);   

        $post=Post::create($fields);  
        
        $post->threads()->attach(Thread::find($request->threads));

        $post->update(['slug'=>Str::slug($post->id.'-'.$post->title)]);
      
        return redirect()->route('post.index')->with('message','Tạo Post thành công'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    public function showSlug(Request $request){ 
        $post=Post::where('slug',$request->slug)->first();
        $data['thread']=$post->threadsFirst(); 
        if($data['thread']) $data['relatedPosts']=$data['thread']->posts;
        else $data['relatedPosts']=[];
        return view('laravelpost::post.showSlug',['post'=>$post,'data'=>$data]);  
    }

    public function validPost($request){ 
        $request->validate([ 
            'publish_date'=>'date', 
        ]);
        return $fields=array(
            'title'=>$request->title,
            'description'=>$request->description,
            'content'=>$request->content,  
            'publish_date'=>$request->publish_date, 
            'image'=>$request->image,
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
    public function edit(Post $post)
    {
        $data['threads']=Thread::all()->sortBy("title");
        $data['status']=InputForm::getStatus(); 
        return view('laravelpost::post.edit',['post'=>$post,'data'=>$data]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    { 
        $fields=$this->validPost($request);   

        $post->update($fields);  
        
        $post->threads()->detach();
        $post->threads()->attach(Thread::find($request->threads));

        $post->update(['slug'=>Str::slug($post->id.'-'.$post->title)]);
      
        return redirect()->route('post.index')->with('message','Sửa Post thành công'); 
        
    }

    

    public function copy(Post $post)
    { 
        $fields=array(
            'title'=>$post->title.'(1)',
            'description'=>$post->description,
            'content'=>$post->content,  
            'publish_date'=>$post->publish_date, 
            'image'=>$post->image,
            'user_create_id'=>Auth::id(),
            'status'=>'',
        );  

        $newPost=Post::create($fields);  
        
        $newPost->threads()->attach($post->threads);

        $newPost->update(['slug'=>Str::slug($newPost->id.'-'.$newPost->title)]);
        return redirect()->route('post.index')->with('message','Sao chép Post thành công');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return back();
    } 
}