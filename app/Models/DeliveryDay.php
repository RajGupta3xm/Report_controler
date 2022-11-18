<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryDay extends Model
{
    protected $table="delivery_days";
   protected $fillable = [
        'id',
        'type',
        'included_weekend',
        'number_of_days',
        'description',
        'status'

    ];

  
   
}
