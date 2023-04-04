<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDeliverByDriver extends Model
{
    protected $table='order_delivers_by_driver';
    protected $fillable = [
    	'user_id',
    	'driver_id',
    	'order_id',
    	'address_id',
    	'status',
    	'delivery_slot_id',
    	'plan_id',
    	'variant_id',
        "cancel_or_delivery_date",
        "cancel_or_delivery_day",
        "cancel_reason",
        "delivery_reason",
        "is_delivery",

   	];

	public $timestamps = true;

	public function delivery_slot(){
		return $this->belongsTo(DeliverySlot::class,'delivery_slot_id','id');
	}

}
