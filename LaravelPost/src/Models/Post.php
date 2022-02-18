<?php

namespace Phonglg\LaravelPost\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;  

class Post extends Model
{
    use HasFactory;
    protected $table = 'plg_posts';
    protected $guarded = []; 

    public function threads(){
        return $this->belongsToMany(Thread:: class, 'plg_post_thread','post_id','thread_id'); 
    }

    public function threadsFirst(){
        return $this->belongsToMany(Thread:: class, 'plg_post_thread','post_id','thread_id')->first(); 
    }

    public function user(){  
        
    }

  
  
}