<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealItemOrganization extends Model
{
    protected $table='meal_item_organization';
    protected $fillable = [
        "meal_id",
        "meal_schedule_id",
        "week_days_id",
        "diet_plan_type_id",
        "department_id",
        "status",
       
    ];
}