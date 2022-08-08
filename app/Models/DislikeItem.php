<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DislikeItem extends Model
{
   protected $fillable = [
        'id',
        'name',
        'name_ar',
        'status'
    ];

   //protected $visible = ['id', 'name'];

}
