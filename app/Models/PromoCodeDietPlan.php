<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCodeDietPlan extends Model
{
    protected $table='promo_code_diet_plan';
    protected $fillable=['promo_code_id','diet_plan_type_id','status'];

    
}