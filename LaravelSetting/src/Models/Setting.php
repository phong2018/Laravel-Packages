<?php
namespace Phonglg\LaravelSetting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class Setting extends Model
{
    use HasFactory;
    protected $table = 'settings';
    protected $guarded = [];
    
    // protected static function NewFactory()
    // {
    //     return \Phonglg\LaravelSetting\Database\Factories\CategoryFactory::new();   
    // }
  
}