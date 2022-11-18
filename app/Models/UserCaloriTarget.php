<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCaloriTarget extends Model
{
    protected $fillable=['user_id','recommended_result_id','custom_result_id','calori_per_day','protein_per_day','carbs_per_day','fat_per_day','is_custom','custom'];
}
