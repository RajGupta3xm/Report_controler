<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    protected $table='socials_link';
    protected $fillable = [
    	'id',
    	'facebook_link',
    	'linkedin_link',
    	'instagram_link',
    	'twiter_link',
    	

   	];

	public $timestamps = true;
}