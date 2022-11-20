<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealMacroNutrients extends Model
{
    protected $table='meal_macro_nutrients';
    protected $fillable = [
        "meal_id",
        "user_calorie",
        "size_pcs",
        "recipe_yields",
        "meal_calorie",
        "protein",
        "carbs",
        "fat",
        "status",
       
    ];
}