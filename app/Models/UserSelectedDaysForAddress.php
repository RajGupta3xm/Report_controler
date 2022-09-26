<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSelectedDaysForAddress extends Model
{
    protected $table="user_selected_days_for_address";
    protected $fillable = [
        "user_id",
        "address_id",
        "selected_days",
    ];
}
