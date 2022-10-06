<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnboardingScreen extends Model
{
    protected $table='onboarding_screens';
    protected $fillable = [
    	'user_id',
    	'title',
    	'title_ar',
    	'image',
    	

   	];

	public $timestamps = true;
}
