<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderOnAddress extends Model
{
    protected $table='order_on_address';
    protected $fillable = [
    	'user_id',
    	'order_id',
    	'address_id',
    	'delivery_slot_id',
        "area",
        "house_number",
        "street",
        "address_type",
    	'status',

   	];

	public $timestamps = true;

}
