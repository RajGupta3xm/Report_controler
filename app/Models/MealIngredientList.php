<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealIngredientList extends Model
{
    protected $table='meal_ingredient_list';
    protected $fillable = [
        "meal_id",
        "ingredients",
        "quantity",
        "unit",
        "status",
    
    ];
}