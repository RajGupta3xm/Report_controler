<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = "notification";
    protected $fillable = [
        "user_id",
        "plan_id",
        "plan_id",
        "variant_id",
        "title_en",
        "title_ar",
        "body_en",
        "body_ar",
        "read_status",
        "status",

    ];
}
