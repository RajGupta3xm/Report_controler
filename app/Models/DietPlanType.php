<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DietPlanType extends Model
{
    protected $fillable = [
        'id',
        'name',
        'name_ar',
        'image',
        'image_ar',
        'description',
        'description_ar',
        'protein',
        'status',
        'carbs',
        'fat',
        'protein_default_min',
        'protein_min_divisor',
        'protein_default_max',
        'protein_max_divisor',
        'carb_default_min',
        'carb_min_divisor',
        'carb_default_max',
        'carb_max_divisor',
        'fat_default_min',
        'fat_min_divisor',
        'fat_default_max',
        'fat_max_divisor',
        'protein_actual',
        'carbs_actual',
        'fat_actual',
        'protein_actual_divisor',
        'carbs_actual_divisor',
        'fat_actual_divisor'
    ];

    public function user_profile(){
        return $this->belongsTo(UserProfile::class);
    }
}
