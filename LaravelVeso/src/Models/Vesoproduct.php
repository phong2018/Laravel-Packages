<?php

namespace Phonglg\LaravelVeso\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Phonglg\LaravelAuth\Models\User;

class Vesoproduct extends Model
{
    use HasFactory;
    protected $table = 'veso_products';
    protected $guarded = [];

    public function showProvince(){ 

        if(config('laravelhtmldomparser.categoryType.miennam.provinces.'.$this->province))
        return config('laravelhtmldomparser.categoryType.miennam.provinces.'.$this->province);

        if(config('laravelhtmldomparser.categoryType.mientrung.provinces.'.$this->province))
        return config('laravelhtmldomparser.categoryType.mientrung.provinces.'.$this->province);

        if(config('laravelhtmldomparser.categoryType.mienbac.provinces.'.$this->province))
        return config('laravelhtmldomparser.categoryType.mienbac.provinces.'.$this->province);
    } 

    public function user(){
        return $this->belongsTo(User::class, 'user_create_id');
    }

    public function showLotteryDate(){ 
        return Carbon::parse($this->prize_date)->format('d-m-Y');
    }
  
}