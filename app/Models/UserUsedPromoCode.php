<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserUsedPromoCode extends Model
{
    protected $table="user_used_promo_code";
    protected $fillable = [
        "user_id",
        "promocode_id",
        "promo_code_ticket_id",


    ];

   
}
