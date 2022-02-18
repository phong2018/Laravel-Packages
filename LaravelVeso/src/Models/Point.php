<?php

namespace Phonglg\LaravelVeso\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;  

class Point extends Model
{
    use HasFactory;
    protected $table = 'veso_orders';
    protected $guarded = [];
  
}