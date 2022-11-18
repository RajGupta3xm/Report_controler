<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionCosts extends Model
{
    protected $table='subscription_costs';
    protected $fillable = [
    	'plan_id',
    	'delivery_day_type_id',
    	'calorie_range_id',
    	'cost',
    	'status',

   	];

	public $timestamps = true;

	
	public function delivery_day_type(){
        return $this->belongsTo(DeliveryDay::class,'delivery_day_type_id','id')->select(['id','type']);
    }
	
}
