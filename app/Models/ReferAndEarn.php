<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferAndEarn extends Model
{
    protected $table = 'refer_and_earn';
    protected $fillable = [
    	'id',
    	'register_referee',
    	'register_referral',
    	'plan_purchase_referee',
    	'plan_purchase_referral',
    	'referral_per_user',
    	'how_it_work_en',
    	'how_it_work_ar',
    	'message_body_en',
    	'message_body_ar',
        'start_date',
        'status',



   	];
}
