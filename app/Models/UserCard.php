<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCard extends Model
{
    protected $table="user_cards";
    protected $fillable = [
        "user_id",
        "card_holder_name",
        "expiry_date",
        "card_number",
        "card_type"
    ];
}
