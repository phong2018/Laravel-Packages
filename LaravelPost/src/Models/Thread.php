<?php

namespace Phonglg\LaravelPost\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;  
use Phonglg\LaravelPost\Models\Post;

class Thread extends Model
{
    use HasFactory;
    protected $table = 'plg_threads';
    protected $guarded = [];
    
    public function posts(){
        return $this->belongsToMany(Post::class, 'plg_post_thread','thread_id','post_id');  
    }

    public function user(){  
    } 
}