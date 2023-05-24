<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCodeDietPlan extends Model
{
    protected $table='promo_code_diet_plan';
    protected $fillable=['promo_code_id','meal_plan_id','variant_id','status'];

    public function plan(){
        return $this->belongsTo(SubscriptionPlan::class,'meal_plan_id','id');
    }
}