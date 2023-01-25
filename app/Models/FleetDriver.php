<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FleetDriver extends Model
{
    protected $table='fleet_driver';

    protected $fillable = [
    	'id',
    	'order_id',
    	'staff_member_id',
    	'delivery_slot_id',
   	];

	   public function orders(){
        return $this->belongsTo(Order::class,'order_id','id');
    }
    public function deliverySlot(){
        return $this->belongsTo(DeliverySlot::class,'delivery_slot_id','id');
    }
}
