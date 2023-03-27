<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealLabel extends Model
{
    protected $table='meal_label';
    protected $fillable = [
        "meal_id",
        "instruction",
        "instruction_ar",
        "ingredients",
        "ingredients_ar",
        "status",
       
    ];
}