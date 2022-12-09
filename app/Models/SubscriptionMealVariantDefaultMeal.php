<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SubscriptionMealVariantDefaultMeal extends Model
{
    use HasApiTokens;
    protected $table='subscription_meal_plan_variant_default_meal';
    protected $fillable = [
        "id",
        "meal_plan_id",
        'meal_schedule_id',
        'item_id',
        "date",
        "is_default",
    ];

    public function subscription_plan(){
        return $this->belongsTo(SubscriptionPlan::class);
    }
}
