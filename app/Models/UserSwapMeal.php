<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSwapMeal extends Model
{
    protected $table="user_swap_meal";
    protected $fillable = [
        "id",
        "user_id",
        "meal_plan_id",
        'meal_schedule_id',
        'meal_id',
        'old_meal_id',
        'item_id',
        "date",
        "is_default",

    ];
}
