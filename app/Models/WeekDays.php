<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeekDays extends Model
{
    protected $table="week_days";
    protected $fillable = [
        "week_days_id",
        "week_days_id_ar",
        "status",

    ];
}
