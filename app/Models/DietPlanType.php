<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DietPlanType extends Model
{
    protected $fillable = [
        'id',
        'name',
        'name_ar',
        'status'
    ];
}
