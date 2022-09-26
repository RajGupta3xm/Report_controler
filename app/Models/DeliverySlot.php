<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliverySlot extends Model
{
    protected $table="user_address";
    protected $fillable = [
        "name",
        "name_ar",
        "start_time",
        "end_time",
        "status",


    ];
}
