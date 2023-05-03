<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $table='cities';
    protected $fillable = ['id','city','city_ar','upcoming_cities','upcoming_cities_ar','status'];
}
