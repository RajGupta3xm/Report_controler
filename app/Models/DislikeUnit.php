<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DislikeUnit extends Model
{

    protected $table="dislike_units";
   protected $fillable = [
        'unit',
        'unit_ar',
        'status'
    ];
 

}
