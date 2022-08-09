<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\DeliveryDay;
use App\Models\UserProfile;
use App\Models\DietPlanType;
use App\Models\CalorieRecommend;
use App\Models\SubscriptionPlan;
use App\Models\UserCaloriTarget;
use App\Models\SubscriptionCosts;
use App\Models\SubscriptionDietPlan;
use App\Models\SubscriptionMealGroup;

use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SubscriptionController extends Controller {

    public function __construct() {
        DB::enableQueryLog();
    }

    public function planListing(Request $request){
        $request->diet_plan_type_id;
        $request->plan_type;
        $request->is_weekend;
        $user_recommended_calorie=2200;
        $subscriptions=SubscriptionPlan::select('id','name','description','image')->where(['status'=>'active'])->get();
        if($subscriptions){
            foreach($subscriptions as $subscription){
                $subscription->cost="0";
                $subscription->delivery_day_type="N/A";
                
                $subscription->meal_groups=[];

                if(SubscriptionDietPlan::where(['plan_id'=>$subscription->id,'diet_plan_type_id'=>$request->diet_plan_type_id])->first()){
                        if($request->plan_type == 1 || $request->plan_type == 2){
                            $subscription->delivery_day_type="Week";
                        }else{
                            $subscription->delivery_day_type="Month";
                        }
                        $deliveryDay=DeliveryDay::find($request->plan_type);

                        if(SubscriptionCosts::where(['plan_id'=>$subscription->id,'delivery_day_type_id'=>$request->plan_type])->first()){
                        $costs=SubscriptionCosts::where(['plan_id'=>$subscription->id,'delivery_day_type_id'=>$request->plan_type])->first();
                        $subscription->cost=$costs->cost;

                        $meals=[];
                        $meal_des=[];
                        $subscription->meal_groups=SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$subscription->id])->get();
                        foreach($subscription->meal_groups as $meal){
                            array_push($meals,['id'=>$meal->meal_group->id,'meal_name'=>$meal->meal_group->name]);
                            array_push($meal_des,$meal->meal_group->name);
                        }
                        $meal_des=count($meal_des)." Meals Package (".implode(',',$meal_des).")";

                        $subscription->description=[
                            "Serves Upto 2000 calories out of $user_recommended_calorie calories recommended for you.",
                            $deliveryDay->number_of_days." days a ".$subscription->delivery_day_type,
                            " ".$meal_des
                        ];
                        $subscription->meal_groups=$meals;

                        
                    }
                }
                
                
                
            }
        }
        $response = new \Lib\PopulateResponse($subscriptions);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('messages.plan_list');
        return $this->populateResponse();
    }

    public function calculateCalorie(){
        $user=UserProfile::where('user_id',Auth::guard('api')->id())->first();
        $data=['recommended_colorie'=>1500];
        $response = new \Lib\PopulateResponse($data);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('plan_messages.calorie_calculation');
        return $this->populateResponse();
    }

    public function macrosCalculator(Request $request) {
        $user=UserProfile::where('user_id',Auth::guard('api')->id())->first();
        $dietPlan=DietPlanType::where('id',$user->diet_plan_type_id)->first();
        
        ///// Calculation /////

        $protien=(($request->total_calorie*$dietPlan->protein_actual)/100)/$dietPlan->protein_actual_divisor;
        $carbs=(($request->total_calorie*$dietPlan->carbs_actual)/100)/$dietPlan->carbs_actual_divisor;
        $fat=(($request->total_calorie*$dietPlan->fat_actual)/100)/$dietPlan->fat_actual_divisor;
        $data=['protein'=>round($protien),'carbs'=>round($carbs),'fat'=>round($fat)];

        ///// Calculation /////

        $recommended_result=CalorieRecommend::where('recommended',$request->total_calorie)->first();
        $update=[
            'user_id'=>Auth::guard('api')->id(),
            'recommended_result_id'=>$recommended_result->id,
            'calori_per_day'=>$request->total_calorie,
            'protein_per_day'=>$protien,
            'carbs_per_day'=>$carbs,
            'fat_per_day'=>$fat,
            'is_custom'=>$request->is_custom
        ];
        UserCaloriTarget::updateOrCreate(['user_id'=>Auth::guard('api')->id()],$update);

        $response = new \Lib\PopulateResponse($data);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('plan_messages.macro_calculation');
        return $this->populateResponse();
    }


    public function dietPlanDetails(Request $request){
        $dietPlan=DietPlanType::select('id','name','protein','carbs','fat')->where('id',$request->diet_plan_type_id)->first();
        $dietPlan->meals=[];
        $data=$dietPlan;
        $response = new \Lib\PopulateResponse($data);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('plan_messages.diet_plan_detail');
        return $this->populateResponse();
    }

    public function buySubscriptionPlan(Request $request){

    }
}
