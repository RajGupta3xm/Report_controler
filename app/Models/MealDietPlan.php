<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealDietPlan extends Model
{
    protected $table='meal_diet_plan';
    protected $fillable = [
        "meal_id",
        "diet_plan_type_id",
        "status",
    ];

    public function meal_items(){
        return $this->belongsTo(Meal::class,'meal_id','id');
    }
    
}