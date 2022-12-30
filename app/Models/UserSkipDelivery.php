<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSkipDelivery extends Model
{
    protected $table="user_skip_delivery";
    protected $fillable = [
        "user_id",
        "user_address_id",
        "subscription_plan_id",
        "skip_delivery_date",

    ];
}
