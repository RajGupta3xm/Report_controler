<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table='subscriptions';
    protected $fillable = [
    	'user_id',
    	'plan_id',
    	'variant_id',
    	'start_date',
    	'pause_date',
		'switch_plan_start_date',
    	'resume_date',
    	'end_date',
    	'no_of_days_pause_plan',
    	'no_of_days_resume_plan',
    	'is_weekend',
    	'price',
    	'discount',
    	'tax',
    	'total_amount',
    	'delivery_status',
    	'status',
    	'plan_status',

   	];

	public $timestamps = true;

	
	public function subscription_plan(){
        return $this->belongsTo(SubscriptionPlan::class,'plan_id','id')->select(['id','name']);
    }

	public function users(){
        return $this->belongsTo(User::class,'user_id','id');
    }
	
}