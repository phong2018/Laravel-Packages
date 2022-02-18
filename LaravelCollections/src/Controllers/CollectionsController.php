<?php
namespace Phonglg\LaravelCollections\Controllers;
 
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CollectionsController extends Controller
{
    private $posts;

    public function __construct()
    {
        $json=Http::get('https://www.reddit.com/r/mechanicalKeyboards.json')->json();
        //$json=Http::get('https://www.reddit.com/r/AskReddit.json')->json();
        $this->posts=collect($json['data']['children']);      
       
    }

    public function index()
    {          
        //dd($this->posts);

        return view('laravelcollections::index',['posts'=>  $this->posts]);
    }

    public function filter()
    {          
        //dd($this->posts);

        $posts=$this->posts->filter(function($post,$key){ 
            if(isset($post['data']['post_hint']) && $post['data']['post_hint']!=='image')
            return false;
            else return Str::contains($post['data']['url'],'i.redd.it');
        });

        return view('laravelcollections::filter',['posts'=>  $posts]);
    }

    //https://laravel.com/docs/8.x/collections#method-pluck
    public function pluck()
    {          
        $posts=$this->posts->filter(function($post,$key){
            if(isset($post['data']['post_hint']) && $post['data']['post_hint']!=='image')
            return false;
            else return Str::contains($post['data']['url'],'i.redd.it');
        })
        ->pluck('data.url')
        ->all(); 

        //dd($posts);

        return view('laravelcollections::pluck',['posts'=>  $posts]);
    }


    public function contains()
    {          
        if(!$this->posts->contains('data.post_hint','image')){
            return view('laravelcollections::contains-empty');
        }

        $posts=$this->posts->filter(function($post,$key){
            if(isset($post['data']['post_hint']) && $post['data']['post_hint']!=='image')
            return false;
            else return Str::contains($post['data']['url'],'i.redd.it');
        })
        ->pluck('data.url')
        ->all();

        // dd($posts);

        return view('laravelcollections::contains',['posts'=>  $posts]);
    }

    public function groupby()
    {          
        //dd($this->posts);

        $posts=$this->posts->filter(function($post,$key){
            return isset($post['data']['post_hint']) && in_array($post['data']['post_hint'],['self','image']);
        })
        ->groupBy('data.post_hint')
        ->toArray();

        return view('laravelcollections::groupby',['posts'=>  $posts]);
    }
    
    public function sortby()
    {          
        //dd($this->posts);

        $posts=$this->posts->filter(function($post,$key){
            return isset($post['data']['post_hint']) && $post['data']['post_hint']==='image';
        })
        ->sortBy('data.title')
        //->sortByDesc('data.title')
        ->values()
        ->all();

        //dd($posts);

        return view('laravelcollections::sortby',['posts'=>  $posts]);
    }

    //https://laravel.com/docs/8.x/collections#method-partition
    public function partition(){
        list($popularPosts,$regularPosts)=$this->posts->partition(function($post){
            return $post['data']['ups']>1000;
        });
        
        return view('laravelcollections::partition',['popularPosts'=>$popularPosts->sortByDesc('data.ups'),'regularPosts'=>$regularPosts->sortByDesc('data.ups'),]);
    }
    
    public function reject(){
        $posts=$this->posts->reject(function($post){
            return $post['data']['ups']<1000;
        });
        return view('laravelcollections::reject',['posts'=>$posts->sortByDesc('data.ups')]);
    }

    public function wherein(){
        $posts=$this->posts->whereIn('data.post_hint',['self','image'])
        ->groupBy('data.post_hint')
        ->toArray();

        return view('laravelcollections::wherein',['posts'=>  $posts]);
    }

    // https://laravel.com/docs/8.x/collections#method-chunk
    public function chunk(){
        $posts=$this->posts->chunk(2);

        return view('laravelcollections::chunk',['posts'=>  $posts]);
    }

    public function count(){
        $posts=$this->posts->reject(function($post){
            return $post['data']['ups']<1000;
        });
        return view('laravelcollections::count',['posts'=>$posts->sortByDesc('data.ups')]);
    }

    public function first(){
        // $firstPosts=$this->posts->first(function($post){
        //     return $post['data']['ups']>1000;
        // });
        // or use
        $firstPosts=$this->posts->firstWhere('data.ups','>',1000);
        return view('laravelcollections::first',['post'=>$firstPosts]);
    }

    // https://laravel.com/docs/8.x/collections#method-tap
    public function tap()
    {          
        //dd($this->posts);

        $posts=$this->posts->filter(function($post,$key){
            return isset($post['data']['post_hint']) && $post['data']['post_hint']==='image';
        })
        ->sortByDesc('data.title')
        ->tap(function ($collection) { 
            Log::info('Ids from '.$collection->count().' posts: ', $collection->pluck('data.id')->toArray());
        })
        ->values()
        ->all();
 

        return view('laravelcollections::tap',['posts'=>  $posts]);
    }

}