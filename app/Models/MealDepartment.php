<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealDepartment extends Model
{
    protected $table='meal_department';
    protected $fillable = [
        "meal_id",
        "department_id",
        "status",

    ];
}