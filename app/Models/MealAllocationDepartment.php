<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealAllocationDepartment extends Model
{
    protected $table='meal_allocation_department';
    protected $fillable = [
        "id",
        "name",
        "name_ar",
        "status",

    ];
}