<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeScreenBanner extends Model
{
    protected $table='home_screen_banners';
    protected $fillable = [
    	'image',
    	

   	];

	public $timestamps = true;
}
