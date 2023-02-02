<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table="user_profile";
    protected $fillable=[
            'user_id',
            'available_credit',
            'subscription_id',
            'variant_id',
            'height',
            'initial_body_weight',
            'dob',
            'age',
            'gender',
            'activity_scale',
            'available_referral',
            'fitness_scale_id',
            'diet_plan_type_id'
        ];

        public function fitness(){
            return $this->hasOne(FitnessGoal::class,'id','fitness_scale_id');
        }

        public function dietplan(){
            return $this->hasOne(DietPlanType::class,'id','diet_plan_type_id');
        }

}
