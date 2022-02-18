<?php

namespace Phonglg\LaravelUserRole\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'slug','permissions'
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }
}