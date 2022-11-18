<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $table='subscription_plans';
    protected $fillable = [
    	'diet_plan_type_id',
    	'name',
    	'name_ar',
    	'description',
    	'description_ar',
    	'status',

   	];

  
	
}
