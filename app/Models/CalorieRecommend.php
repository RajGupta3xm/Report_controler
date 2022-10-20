<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalorieRecommend extends Model
{
    protected $table='calorie_recommend';
    protected $fillable = ['id','range','min_range','max_range','recommended'];
}
