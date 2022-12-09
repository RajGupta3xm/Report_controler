<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SubscriptionMealPlan extends Model
{
    use HasApiTokens;
    protected $table='subscription_plans';
    protected $fillable = [
        "id",
        "title",
        'title_ar',
        "image",
        "status",

    ];

    public function mealplan_variant(){
        return $this->hasMany(SubscriptionMealPlanVariant::class,'meal_plan_id','id');
    }

    public function meal_schedule(){
        return $this->hasMany(SubscriptionMealGroup::class,'meal_plan_id','id');
    }

    public function meal_plan_variant_default(){
        return $this->hasMany(SubscriptionMealVariantDefaultMeal::class,'meal_plan_id','id');
    }
}
