<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SubscriptionMealPlanVariant extends Model
{
    use HasApiTokens;
    protected $table='subscriptions_meal_plans_variants';
    protected $fillable = [
        "id",
        "meal_plan_id",
        'meal_group_name',
        'variant_name',
        "diet_plan_id",
        "option1",
        "option2",
        "no_days",
        "calorie",
        "serving_calorie",
        "delivery_price",
        "plan_price",
        "compare_price",
        "is_charge_vat",
        "custom_text",
    ];

    public function subscription_plan(){
        
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function dietPlan(){
        return $this->belongsTo(DietPlanType::class,'diet_plan_id','id');
    }

    public function plan(){
        return $this->belongsTo(SubscriptionPlan::class,'meal_plan_id','id')->select(['id','name']);
    }

    public function dietPlans(){
        return $this->belongsTo(DietPlanType::class,'diet_plan_id','id')->select(['id','name']);
    } 
}
