<?php
namespace Phonglg\LaravelUserRole\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;  

class Customer extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $guarded = [];

      public function role(){
        return $this->belongsTo(Role::class);
    }
}