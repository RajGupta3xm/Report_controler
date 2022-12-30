<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSkipTimeSlot extends Model
{
    protected $table="user_skip_time_slot";
    protected $fillable = [
        "user_id",
        "user_address_id",
        "delivery_slot_id",
        "subscription_plan_id",
        "skip_date",

    ];
}
