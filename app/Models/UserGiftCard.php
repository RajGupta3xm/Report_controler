<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGiftCard extends Model
{
    protected $table="user_gift_cards";
    protected $fillable = [
        "user_id",
        "quantity",
        "purchase_type",
        "gift_from_user_id",
        "receiver_name",
        "receiver_email",
        "mobile_number",
        "message_for_receiver",
        "occassion",
        "purchase_amount",
        "purchase_status",



    ];
}
