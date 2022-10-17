<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffMembers extends Model
{
    protected $table='staff_members';
    protected $fillable = [
    	'id',
    	'name',
    	'name_ar',
    	'image',
    	'group_id',
    	'email',
    	'password',
    	'user_mgmt',
    	'order_mgmt',
    	'ingredient_mgmt',
    	'fitness_goal_mgmt',
    	'diet_plan_mgmt',
    	'meal_mgmt',
    	'meal_plan_mgmt',
    	'fleet_mgmt',
    	'promo_code_mgmt',
    	'gift_card_mgmt',
    	'notification_mgmt',
    	'refer_earn_mgmt',
    	'report_mgmt',
    	'content_mgmt',
    	'status',
    	

   	];

	public $timestamps = true;

	public function group(){
		return $this->hasOne(StaffGroup::class,'id','group_id');
	}
}