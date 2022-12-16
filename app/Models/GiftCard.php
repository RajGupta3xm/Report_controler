<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model
{
    protected $table='gift_cards';
    protected $fillable = [
        "title",
        "title_ar",
        "description",
        "description_ar",
        "discount",
        "amount",
        "gift_card_amount",
        "image",
        "status",

    ];
}