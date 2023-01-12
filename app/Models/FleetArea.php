<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FleetArea extends Model
{
    protected $table='fleet_area';

    protected $fillable = [
    	'id',
    	'area',
    	'area_ar',
    	'delivery_slot_ids',
    	'staff_ids',
    	'status',

   	];
}
