<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $table='promo_codes';
    protected $fillable = [
        "name",
        "name_ar",
        "description",
        "description_ar",
        "image",
        "duration",
        "discount",
        "price",
        "maximum_discount_uses",
        "start_date",
        "end_date",
        "is_extended",
        "extended_end_date",
        "status"



    ];
}
