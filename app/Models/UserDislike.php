<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDislike extends Model
{
    protected $table="user_dilikes";
    protected $fillable=[
        'user_id',
        'item_id',
        'status',
      
    ];

   
}
