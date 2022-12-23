<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferAndEarnUsed extends Model
{
    protected $table = 'refer_and_earn_used';
    protected $fillable = [
    	'id',
    	'refer_and_earn_id',
    	'referee_id',
    	'referral_id',
    	'used_for',
    	'status',
    
   	];
	   public function user(){
        return $this->belongsTo(User::class,'referral_id','id');
    }

}
