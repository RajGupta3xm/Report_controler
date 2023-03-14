<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSelectDeliveryLocation extends Model
{
    protected $table="user_select_delivery_locations";
    protected $fillable = [
        "user_id",
        "city_id",
        "selected_or_not",
    ];
}
