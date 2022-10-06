<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table='subscriptions';
    protected $fillable = [
    	'user_id',
    	'plan_id',
    	'start_date',
    	'is_weekend',
    	'price',
    	'discount',
    	'tax',
    	'total_amount',
    	'delivery_status',
    	'status',

   	];

	public $timestamps = true;
}