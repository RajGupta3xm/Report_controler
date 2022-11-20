<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table='orders';
    protected $fillable = [
    	'user_id',
    	'address_id',
    	'delivery_slot_id',
    	'meals_count',
    	'item_total',
    	'discount',
    	'tax',
    	'delivery_charge',
    	'total_amount',
    	'payment_method',
    	'card_type',
    	'payment_status',
    	'cancel_reason',
    	'status',

   	];

	public $timestamps = true;
}
