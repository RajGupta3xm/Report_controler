<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChangeDeliveryLocation extends Model
{
    protected $table="user_change_delivery_location";
    protected $fillable = [
        "user_id",
        "user_address_id",
        "subscription_plan_id",
        "change_location_for_date",

    ];
}
