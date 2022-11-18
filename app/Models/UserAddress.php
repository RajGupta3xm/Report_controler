<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table="user_address";
    protected $fillable = [
        "delivery_slot_id",
        "user_id",
        "area",
        "latitude",
        "longitude",
        "building",
        "street",
        "postal_code",
        "mobile_number",
        "instruction",
        "address_type",
        "monday",
        "tuesday",
        "wednesday",
        "thursday",
        "friday",
        "saturday",
        "sunday",



    ];

    // public function delivery_slot(){
    //     return $this->hasOne(DeliverySlot::class,'id','delivery_slot_id');
    // }
  
}
