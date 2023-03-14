<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DietPlanTypesMealCalorieMinMax extends Model
{
    protected $table="diet_plan_type_calorie_min_max";
    protected $fillable = [
        'id',
        'diet_plan_type_id',
        'meal_calorie',
        'protein_min',
        'protein_max',
        'carbs_min',
        'carbs_max',
        'fat_min',
        'fat_max',
        'status',
    ];

    
}
