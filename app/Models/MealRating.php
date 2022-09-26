<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealRating extends Model
{
    protected $table='meal_ratings';
    protected $fillable = [
        "user_id",
        "meal_id",
        "rating"
    ];
}