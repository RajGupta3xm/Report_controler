<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferEarnContent extends Model
{
    protected $table = 'refer_and_earn_content';
    protected $fillable = [
    	'id',
    	'type',
    	'content',
    	'status',
    
   	];
	 

}
