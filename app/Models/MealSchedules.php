<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MealSchedules extends Model
{
    use HasApiTokens;
    protected $table='meal_schedules';
    protected $fillable = [
        "id",
        "name",
        "name_ar",
        "status",

    ];
   

  
}
