<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReplaceEditPlanRequest extends Model
{
    protected $table = 'replace_edit_plan_requests';
    protected $fillable = [
    	'user_id',
    	'subscription_id',
    	'new_subscription_id',
    	'type',
    
   	];
	 

}
