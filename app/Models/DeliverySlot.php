<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliverySlot extends Model
{
    protected $table="delivery_slots";
    protected $fillable = [
        "name",
        "name_ar",
        "start_time",
        "end_time",
        "status",


    ];
    // public function user_address(){
    //     return $this->belongsTo(UserAddress::class);
    // }
    public function user_address(){
        return $this->belongsTo(UserAddress::class,'id','delivery_slot_id')->select(['id']);
    }
   
}
