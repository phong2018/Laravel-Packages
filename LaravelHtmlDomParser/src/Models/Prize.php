<?php
namespace Phonglg\LaravelHtmlDomParser\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;  

class Prize extends Model
{
    use HasFactory;
    protected $table = 'veso_prizes';
    protected $guarded = [];
  
}