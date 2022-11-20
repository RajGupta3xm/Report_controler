<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Meal extends Model
{
    use HasApiTokens;
    protected $table='meals';
    protected $fillable = [
        "id",
        "meal_schedule_id",
        'diet_plan_type_id',
        "name",
        "name_ar",
        "side_dish",
        "side_dish_ar",
        "recipe_yields",
        "description",
        "description_ar",
        "image",
        "protien",
        "carbs",
        "fat",
        "food_type",
        "calories",
        "price",
        "status",

    ];

    public function meal_schedule(){
        return $this->hasOne(MealSchedules::class,'id','meal_schedule_id');
    }
}