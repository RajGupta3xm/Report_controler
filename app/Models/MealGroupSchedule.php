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

    public function meal_items(){
        return $this->belongsTo(Meal::class,'meal_id','id');
    }
    
}