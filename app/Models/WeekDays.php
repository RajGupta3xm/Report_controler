<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeekDays extends Model
{
    protected $table="week_days";
    protected $fillable = [
        "name",
        "name_ar",
        "status",

    ];
}
