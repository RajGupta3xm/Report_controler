<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\DeliveryDay;
use App\Models\UserProfile;
use App\Models\DietPlanType;
use App\Models\CalorieRecommend;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\UserCaloriTarget;
use App\Models\SubscriptionCosts;
use App\Models\SubscriptionDietPlan;
use App\Models\SubscriptionMealGroup;
use App\Models\Meal;
use App\Models\Order;
use App\Models\Mealschedules;
use App\Models\DislikeCategory;
use App\Models\UserDislike;
use App\Models\DislikeItem;
use App\Models\DeliverySlot;
use App\Models\MealIngredientList;
use App\Models\UserAddress;
use App\Models\SelectDeliveryLocation;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Str;

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
           $caloriRecommended = CalorieRecommend::select('id','recommended')->get();
         foreach($caloriRecommended as $calori){
            $calori->selected=false;
            if(UserCaloriTarget::where(['user_id'=>Auth::guard('api')->id(),'recommended_result_id'=>$calori->id,'status'=>'ongoing'])->first()){
                $calori->selected=true;
            }
        }
        // $data=['recommended_colorie'=>1500];
        $data['recommended_colorie'] = $caloriRecommended;
        $response = new \Lib\PopulateResponse($data);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('plan_messages.calorie_calculation');
        return $this->populateResponse();
    }

    public function calculateKcal(){
        $user=UserProfile::where('user_id',Auth::guard('api')->id())->first();
        $dietPlan=DietPlanType::where('id',$user->diet_plan_type_id)->first();

        if($user->gender == 'female'){
        
              ///// Calculation /////
            $forWomen = ((10*$user->initial_body_weight)+(6.253*$user->height)-(5*$user->age)-161);
            if($user->activity_scale == '1'){
                $total_calorie = $forWomen*1.2;
            }elseif($user->activity_scale == '2'){
                $total_calorie = $forWomen*1.375;
            }else{
                $total_calorie = $forWomen*1.55; 
            }

            if($user->fitness_scale_id == '1'){
                $total_recommended_Kcal = $total_calorie-500;
            }else{
                $total_recommended_Kcal = $total_calorie ;
            }
           
              ///// Calculation /////

        }else{

              ///// Calculation /////
            $forMen = ((10*$user->initial_body_weight)+(6.253*$user->height)-(5*$user->age)+5);
            if($user->activity_scale == '1'){
                $total_calorie = $forMen*1.2;
            }elseif($user->activity_scale == '2'){
                $total_calorie = $forMen*1.375;
            }else{
                $total_calorie = $forMen*1.55; 
            }

            if($user->fitness_scale_id == '1'){
                $total_recommended_Kcal = $total_calorie-500;
            }else{
                $total_recommended_Kcal = $total_calorie ;
            }
              ///// Calculation /////

        }
         //return $total_recommended_Kcal;
         if(round($total_recommended_Kcal<2000,0)){
             $recommended_result=CalorieRecommend::where('min_range','<=',$total_recommended_Kcal)->where('max_range','>=',$total_recommended_Kcal)->first();
            $update=[
    
                'user_id'=>Auth::guard('api')->id(),
                'recommended_result_id'=>$recommended_result->id,
                'custom_result_id'=>$recommended_result->id,
               
            ];
         }else{
             $recommended_result['recommended'] = '2000';
            $update=[

                'user_id'=>Auth::guard('api')->id(),
                'custom_result_id'=>'5',
                'recommended_result_id'=>'5',
               
            ];

         }
        
        UserCaloriTarget::updateOrCreate(['user_id'=>Auth::guard('api')->id()],$update);


     /*********Calculation for protein carb and fat */
     $protein_min = (($recommended_result['recommended']*$dietPlan->protein_default_min)/100)/$dietPlan->protein_min_divisor;
     $protein_max = (($recommended_result['recommended']*$dietPlan->protein_default_max)/100)/$dietPlan->protein_max_divisor;
     $protien = ($protein_min+$protein_max)/2;
      $carb_min = (($recommended_result['recommended']*$dietPlan->carb_default_min)/100)/$dietPlan->carb_min_divisor;
      $carb_max = (($recommended_result['recommended']*$dietPlan->carb_default_max)/100)/$dietPlan->carb_max_divisor;
      $carbs = ($carb_min+$carb_max)/2;
      $fat_min = (($recommended_result['recommended']*$dietPlan->fat_default_min)/100)/$dietPlan->fat_min_divisor;
      $fat_max = (($recommended_result['recommended']*$dietPlan->fat_default_max)/100)/$dietPlan->fat_max_divisor;
      $fat = ($fat_min+$fat_max)/2;
   
     $data=['protein'=>round($protien),'carbs'=>round($carbs),'fat'=>round($fat)];

     /*********End Calculation for protein carb and fat */

        
        
        $data['recommended_colorie'] = round($total_recommended_Kcal,0);
        $response = new \Lib\PopulateResponse($data);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('plan_messages.kcal_calculation');
        return $this->populateResponse();
    }

    public function macrosCalculator(Request $request) {
          $user=UserProfile::where('user_id',Auth::guard('api')->id())->first();
         $dietPlan=DietPlanType::where('id',$user->diet_plan_type_id)->first();

           ///// Calculation /////
         $protein_min = (($request->total_calorie*$dietPlan->protein_default_min)/100)/$dietPlan->protein_min_divisor;
         $protein_max = (($request->total_calorie*$dietPlan->protein_default_max)/100)/$dietPlan->protein_max_divisor;
         $protien = ($protein_min+$protein_max)/2;
          $carb_min = (($request->total_calorie*$dietPlan->carb_default_min)/100)/$dietPlan->carb_min_divisor;
          $carb_max = (($request->total_calorie*$dietPlan->carb_default_max)/100)/$dietPlan->carb_max_divisor;
          $carbs = ($carb_min+$carb_max)/2;
          $fat_min = (($request->total_calorie*$dietPlan->fat_default_min)/100)/$dietPlan->fat_min_divisor;
          $fat_max = (($request->total_calorie*$dietPlan->fat_default_max)/100)/$dietPlan->fat_max_divisor;
          $fat = ($fat_min+$fat_max)/2;
       
         $data=['protein'=>round($protien),'carbs'=>round($carbs),'fat'=>round($fat),'description' => $dietPlan->description];

        ///// Calculation /////
        
        ///// Old Calculation /////

        // $protien=(($request->total_calorie*$dietPlan->protein_actual)/100)/$dietPlan->protein_actual_divisor;
        // $carbs=(($request->total_calorie*$dietPlan->carbs_actual)/100)/$dietPlan->carbs_actual_divisor;
        // $fat=(($request->total_calorie*$dietPlan->fat_actual)/100)/$dietPlan->fat_actual_divisor;
        // $data=['protein'=>round($protien),'carbs'=>round($carbs),'fat'=>round($fat),'description' => $dietPlan->description];

        /////Old  Calculation /////

        $recommended_result=CalorieRecommend::where('recommended',$request->total_calorie)->first();
        $update=[
            'user_id'=>Auth::guard('api')->id(),
            'custom_result_id'=>$recommended_result->id,
            'calori_per_day'=>$request->total_calorie,
            'protein_per_day'=>$protien,
            'carbs_per_day'=>$carbs,
            'fat_per_day'=>$fat,
            // 'custom'=>$request->is_custom
        ];
        if($request->is_custom==0){
           $update['is_custom'] = $request->is_custom;
        }else{
            $update['custom'] = $request->is_custom;
        }
        UserCaloriTarget::updateOrCreate(['user_id'=>Auth::guard('api')->id()],$update);

        $response = new \Lib\PopulateResponse($data);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('plan_messages.macro_calculation');
        return $this->populateResponse();
    }


    public function dietPlanDetails(Request $request){
        $dietPlan=DietPlanType::select('id','name','protein','carbs','fat','description')->where('id',$request->diet_plan_type_id)->first();
        // return $meal = Meal::select('name','image')->with('meal_schedule')->get();
         $meal = Meal::join('meal_schedules','meals.id','=','meal_schedules.id')
        ->select('meals.id as meal_id','meals.name as meal_name','image','meal_schedules.name','meals.created_at as date')
        ->whereDate('meals.created_at','=', date('Y-m-d', strtotime($request->date)))
        ->orderBy('meals.created_at', 'Asc')
        ->get();
        $dietPlan->meals=$meal;
        $data=$dietPlan;
        $response = new \Lib\PopulateResponse($data);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('plan_messages.diet_plan_detail');
        return $this->populateResponse();
    }

    public function mealDetails(Request $request){
         $mealDetail=Meal::select('*')->where('id',$request->meal_plan_id)->first();
        // return $meal = Meal::select('name','image')->with('meal_schedule')->get();
         $mealDetail = Meal::join('meal_schedules','meals.id','=','meal_schedules.id')
        ->select('meals.id as meal_id','meals.name as meal_name','image','description','meal_schedules.name')
        ->where('meals.id',$request->meal_plan_id)
        ->first();

         $dislikeItem = DislikeItem::select('id','category_id','name')->where('status','active')->get()->each(function($dislikeItem){
            $dislikeItem->selected=false;
            if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$dislikeItem->id])->first()){
                $dislikeItem->selected=true;
            }
        });
        $mealDetail->dislike_item = $dislikeItem;
        $data=$mealDetail;
        $response = new \Lib\PopulateResponse($data);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('plan_messages.diet_plan_detail');
        return $this->populateResponse();
    }


 

    // public function targetCalorie(){
      
    //     $caloriRecommended = CalorieRecommend::select('id','recommended')->get();
    //     foreach($caloriRecommended as $calori){
    //        $calori->selected=false;
    //        if(UserCaloriTarget::where(['user_id'=>Auth::guard('api')->id(),'recommended_result_id'=>$calori->id,'status'=>'ongoing','is_custom'=>'0'])->first()){
    //            $calori->selected=true;
    //        }
    //    }

    //     // $data=['recommended_colorie'=>1500];
    //     $data['recommended_colorie'] = $caloriRecommended;
    //     $response = new \Lib\PopulateResponse($data);
    //     $this->status = true;
    //     $this->data = $response->apiResponse();
    //     $this->message = trans('plan_messages.calorie_calculation');
    //     return $this->populateResponse();
    // }


    // public function target_custom_calorie_save(Request $request){
        
    //     $user=UserProfile::where('user_id',Auth::guard('api')->id())->first();
    //     $dietPlan=DietPlanType::where('id',$user->diet_plan_type_id)->first();

    //       ///// Calculation /////
    //     $protein_min = (($request->total_calorie*$dietPlan->protein_default_min)/100)/$dietPlan->protein_min_divisor;
    //     $protein_max = (($request->total_calorie*$dietPlan->protein_default_max)/100)/$dietPlan->protein_max_divisor;
    //     $protien = ($protein_min+$protein_max)/2;
    //      $carb_min = (($request->total_calorie*$dietPlan->carb_default_min)/100)/$dietPlan->carb_min_divisor;
    //      $carb_max = (($request->total_calorie*$dietPlan->carb_default_max)/100)/$dietPlan->carb_max_divisor;
    //      $carbs = ($carb_min+$carb_max)/2;
    //      $fat_min = (($request->total_calorie*$dietPlan->fat_default_min)/100)/$dietPlan->fat_min_divisor;
    //      $fat_max = (($request->total_calorie*$dietPlan->fat_default_max)/100)/$dietPlan->fat_max_divisor;
    //      $fat = ($fat_min+$fat_max)/2;
      
    //     $data=['protein'=>round($protien),'carbs'=>round($carbs),'fat'=>round($fat),'description' => $dietPlan->description];

    //    $recommended_result=CalorieRecommend::where('recommended',$request->total_calorie)->first();
    //    $update=[
    //        'user_id'=>Auth::guard('api')->id(),
    //        'custom_result_id'=>$recommended_result->id,
    //        'calori_per_day'=>$request->total_calorie,
    //        'protein_per_day'=>$protien,
    //        'carbs_per_day'=>$carbs,
    //        'fat_per_day'=>$fat,
    //        'custom'=>$request->is_custom
    //    ];
    //    UserCaloriTarget::updateOrCreate(['user_id'=>Auth::guard('api')->id()],$update);
    //     // $data['recommended_colorie'] = $caloriRecommended;
    //     $response = new \Lib\PopulateResponse($data);
    //     $this->status = true;
    //     $this->data = $response->apiResponse();
    //     $this->message = trans('plan_messages.calorie_calculation');
    //     return $this->populateResponse();
    // }


    public function targetCustomCalorieBar(){
      
        $caloriRecommended = CalorieRecommend::select('id','recommended')->get();
        foreach($caloriRecommended as $calori){
           $calori->selected=false;
           if(UserCaloriTarget::where(['user_id'=>Auth::guard('api')->id(),'custom_result_id'=>$calori->id,'status'=>'ongoing'])->first()){
               $calori->selected=true;
           }
       }

        // $data=['recommended_colorie'=>1500];
        $data['recommended_colorie'] = $caloriRecommended;
        $response = new \Lib\PopulateResponse($data);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('plan_messages.calorie_calculation');
        return $this->populateResponse();
    }


    public function viewPlan(Request $request){
        // $request->diet_plan_type_id;
        // $request->plan_type;
        // $request->is_weekend;
        $request->subscription_plan_id; // this id get from my plan when user click on perticular plan then get ths detail
        $user_recommended_calorie=2200;
       
        $subscriptions=SubscriptionPlan::select('id')->where(['id'=> $request->subscription_plan_id])->first();
        if(Subscription::where(['delivery_status'=>'active','plan_id'=>$subscriptions->id])->orWhere(['delivery_status'=>'terminated','plan_id'=>$subscriptions->id])->first()){
         $subscription=SubscriptionPlan::select('id','name','description','image')->where(['status'=>'active','id'=>$subscriptions->id])->first();
        if($subscription){
            // foreach($subscriptions as $subscription){
                $subscription->cost="0";
                $subscription->delivery_day_type="N/A";
                
                $subscription->meal_groups=[];

                if(SubscriptionDietPlan::where(['plan_id'=>$subscription->id])->first()){
                      $plan_type=SubscriptionCosts::with('delivery_day_type')->where(['plan_id'=>$subscription->id])->first();
                        if($plan_type->delivery_day_type->id == 1 || $plan_type->delivery_day_type->id == 2){
                            $subscription->delivery_day_type="Week";
                        }else{
                            $subscription->delivery_day_type="Month";
                        }
                        $deliveryDay=DeliveryDay::find($plan_type->delivery_day_type->id);

                        if(SubscriptionCosts::where(['plan_id'=>$subscription->id,'delivery_day_type_id'=>$plan_type->delivery_day_type->id])->first()){
                        $costs=SubscriptionCosts::where(['plan_id'=>$subscription->id,'delivery_day_type_id'=>$plan_type->delivery_day_type->id])->first();
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
                
            // }
            $response = new \Lib\PopulateResponse($subscription);
            $this->status = true;
            $this->data = $response->apiResponse();
            $this->message = trans('messages.plan_list');
            return $this->populateResponse();
        }
      $subscription=[];
      $response = new \Lib\PopulateResponse($subscription);
     $this->status = true;
     $this->data = $response->apiResponse();
     $this->message = trans('messages.plan_list');
     return $this->populateResponse();
      
     }

     public function viewPlanDeliveries(Request $request) {
        $dates = $request->date;
          $data['deliveries'] = DeliverySlot::with('user_address')->first();
           $category = MealSchedules::select('id','name')
           ->get()
            ->each(function($category) use($dates){
                       $meals = $category->meals=Meal::join('meal_ratings','meals.id','=','meal_ratings.meal_id' )
                    //    ->where(['meal_ratings.user_id',Auth::guard('api')->id()])
                       ->select('meals.*','meal_ratings.rating')
                       ->whereDate('meals.created_at','=', date('Y-m-d', strtotime($dates)))
                       ->where(['meals.meal_schedule_id'=>$category->id])->get()->each(function($meals) {
                        $meals->ingredient=MealIngredientList::select('ingredients')->where(['meal_id'=>$meals->id])->get();
                })->toArray();
               })->toArray();
                // $category->deliveries = $deliveries;
       
       $data['category'] = $category;
       if($data){
        $response = new \Lib\PopulateResponse($data);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('messages.sample_daily_meal');
    
    
          }else{
           $data =[];
            $response = new \Lib\PopulateResponse($data);
            $this->status = true;
            $this->data = $response->apiResponse();
            $this->message = trans('messages.sample_daily_meal_not');
    
          }
    return $this->populateResponse();
    }


    public function myPlan(Request $request){
        $meal = Subscription::join('subscription_plans','subscriptions.plan_id','=','subscription_plans.id')
       ->select('subscription_plans.image','subscription_plans.name','subscription_plans.id')
       ->where(['subscriptions.delivery_status'=>'active','subscriptions.user_id'=>Auth::guard('api')->id()])
       ->get()->each(function($meal){
           $costs=SubscriptionCosts::with('delivery_day_type')->where(['plan_id'=>$meal->id])->first();
           $meal->cost=$costs->cost;
           $meal->delivery_day_type=$costs->delivery_day_type->type;
       });
       $meals = Subscription::join('subscription_plans','subscriptions.plan_id','=','subscription_plans.id')
       ->select('subscription_plans.image','subscription_plans.name','subscription_plans.id')
       ->where(['subscriptions.delivery_status'=>'terminted','subscriptions.user_id'=>Auth::guard('api')->id()])
       ->get()->each(function($meals){
           $costs=SubscriptionCosts::with('delivery_day_type')->where(['plan_id'=>$meals->id])->first();
           $meals->cost=$costs->cost;
           $meals->delivery_day_type=$costs->delivery_day_type->type;
       });

      
       $data['current_plan'] = $meal;
       $data['previous_plan'] = $meals;
      $response = new \Lib\PopulateResponse($data);
      $this->status = true;
      $this->data = $response->apiResponse();
      $this->message = trans('plan_messages.diet_plan_detail');
      return $this->populateResponse();
  }


  public function buySubscriptionPlan(Request $request){
    $request->plan_id;
    $request->address_id;
    $request->city_id;
    $request->slected_or_not;
    $request->delivery_slot_id;

    $step = '';
    if($request->step=='1'){
        $user=SelectDeliveryLocation::updateOrCreate(
            ['user_id' =>  Auth::guard('api')->id()],
            [
                'user_id' =>  Auth::guard('api')->id(),
                'city_id' => $request->city_id,
                'selected_or_not'=> $request->slected_or_not,
            ]
        );
    }elseif($request->step=='2'){
  
        if($request->vaccination){
            if(is_array($request->vaccination)){
                 $vaccinations= $request->vaccination;
            }else{
                   $vaccinations=json_decode($request->vaccination);
                
            }
        if($vaccinations){
            foreach($vaccinations as $vaccination){
                if($vaccination){
                    $update=[
                        'monday' =>$vaccination['monday'],
                        'tuesday' => $vaccination['tuesday'],
                        'wednesday' => $vaccination['wednesday'],
                        'thursday' => $vaccination['thursday'],
                        'friday' => $vaccination['friday'],
                        'saturday' => $vaccination['saturday'],
                        'sunday' => $vaccination['sunday'],
                        'delivery_slot_id' => $vaccination['delivery_slot_id'],
 
                    ];
                    $updateVaccine=UserAddress::where(['id'=>$vaccination['address_id'],'user_id'=>Auth::guard('api')->id()])->update($update);
                   
                }
               
            }
        }
        }

    }elseif($request->step=='3'){
        
        $user=Order::updateOrCreate(
            ['user_id' =>  Auth::guard('api')->id()],
            [
                'user_id'=> Auth::guard('api')->id(),
                'card_type' => $request->card_type,
                'total_amount' => $request->total_amount,
                
            ]
        );

    }
    $this->status = true;
    $this->message = trans('messages.buy_plan');
    return $this->populateResponse();

}

    
}
