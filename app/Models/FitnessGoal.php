<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitnessGoal extends Model {

    protected $fillable = [
        'id',
        'name',
        'name_ar',
        'status'
    ];
    public $timestamps = true;

}
