<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealGroupSchedule extends Model
{
    protected $table='meal_group_schedule';
    protected $fillable = [
        "meal_id",
        "meal_schedule_id",
        "status",
    
    ];
    
}