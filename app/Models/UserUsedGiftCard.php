<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserUsedGiftCard extends Model
{
    protected $table="user_used_gift_card";
    protected $fillable = [
        "user_id",
        "gift_card_id",
        "voucher_code",
        "voucher_pin",

    ];
}
