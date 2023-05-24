<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\User;
class SubscriptionMealGroup extends Model
{
    // use HasApiTokens;
    
        protected $table='subscription_meal_groups';
    
        protected $fillable = [
            "id",
            "plan_id",
            'meal_schedule_id',
            'status',
        ];
   

        
    // public function meal_group()
    // {
    //    $a = '1';
    //     switch($a) {
    //         case 0:
    //             $b = $this->meal_group1();
    //             break;
    //         case 1:
    
    //             $b = $this->meal_group2();
    //             break;
    //     }
    //     return $b;
    // }
    public function meal_group()
{
    $a =  DB::table('users')->first(); 

    if($a->lang == 'ar') {
        return $this->meal_group2();
    }
    return $this->meal_group1();
}

    public function meal_group1(){
      
        return $this->belongsTo(MealSchedules::class,'meal_schedule_id','id')->select(['id','name']);
    }
    public function meal_group2(){
      
        return $this->belongsTo(MealSchedules::class,'meal_schedule_id','id')->select(['id','name_ar']);
    }


    
}
