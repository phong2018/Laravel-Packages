<?php

namespace Phonglg\LaravelVeso\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;  

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'veso_monitor_print_tickets';
    protected $guarded = [];
  
}