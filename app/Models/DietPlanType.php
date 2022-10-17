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
