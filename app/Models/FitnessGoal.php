<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitnessGoal extends Model {

    protected $fillable = [
        'id',
        'name',
        'name_ar',
        'image',
        'image_ar',
        'status'
    ];
    public $timestamps = true;

    public function user_profile(){
        return $this->belongsTo(UserProfile::class);
    }

}
