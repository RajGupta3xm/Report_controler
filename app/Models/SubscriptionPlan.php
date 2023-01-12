<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;



class SubscriptionPlan extends Model
{
    protected $table='subscription_plans';
    protected $fillable = [
    	'diet_plan_type_id',
    	'name',
    	'name_ar',
    	'image',
    	'description',
    	'description_ar',
    	'status',

   	];

	   public function mealplan_variant(){
        
        return $this->hasMany(SubscriptionMealPlanVariant::class,'meal_plan_id','id');
    }

    public function meal_schedule(){
        return $this->hasMany(SubscriptionMealGroup::class,'plan_id','id');
    }

    public function meal_plan_variant_default(){
        return $this->hasMany(SubscriptionMealVariantDefaultMeal::class,'meal_plan_id','id');
    }

    
	
}
