<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealWeekDay extends Model
{
    protected $table='meal_week_days';
    protected $fillable = [
        "meal_id",
        "week_days_id",
        "status",

    ];
}