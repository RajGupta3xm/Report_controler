<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionMealGroup extends Model
{
    public function meal_group(){
        return $this->belongsTo(MealSchedules::class,'meal_schedule_id','id')->select(['id','name']);
    }
}
