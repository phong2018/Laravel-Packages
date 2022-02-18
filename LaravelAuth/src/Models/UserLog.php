<?php

namespace Phonglg\LaravelAuth\Models;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserLog extends Authenticatable
{
    use HasFactory;
    protected $table = 'user_logs';
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'userId');
    } 
}