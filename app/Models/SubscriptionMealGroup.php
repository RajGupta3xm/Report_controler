<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionMealGroup extends Model
{
    // use HasApiTokens;
    
        protected $table='subscription_meal_groups';
    
        protected $fillable = [
            "id",
            "plan_id",
            'meal_schedule_id',
            'status',
        ];

    public function meal_group(){
        return $this->belongsTo(MealSchedules::class,'meal_schedule_id','id')->select(['id','name','name_ar']);
    }
}
