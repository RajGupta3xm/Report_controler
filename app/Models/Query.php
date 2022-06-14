<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    protected $table='query';
    protected $fillable=['user_id','name','email','subject','message','reply'];
}
