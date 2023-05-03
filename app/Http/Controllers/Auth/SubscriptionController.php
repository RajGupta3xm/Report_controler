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
use App\Models\OrderOnAddress;
use App\Models\FleetArea;
use App\Models\UserSwapMeal;
use App\Models\UserSelectDeliveryLocation;
use App\Models\SubscriptionMealVariantDefaultMeal;
use App\Models\ReplaceEditPlanRequest;
use App\Models\UserSkipDelivery;
use App\Models\User;
use App\Models\ReferAndEarn;
use App\Models\PromoCode;
use App\Models\UserUsedPromoCode;
use App\Models\DislikeGroup;
use App\Models\UserGiftCard;
use App\Models\subscriptions;
use App\Models\SubscriptionOrder;
use App\Models\SubscriptionMealPlanVariant;
use App\Models\Order;
use App\Models\UserChangeDeliveryLocation;
use App\Models\MealRating;
use App\Models\Mealschedules;
use App\Models\UserUsedGiftCard;
use App\Models\DislikeCategory;
use App\Models\UserDislike;
use App\Models\ReferAndEarnused;
use App\Models\DislikeItem;
use App\Models\DeliverySlot;
use App\Models\MealIngredientList;
use App\Models\UserAddress;
use App\Models\UserSkipTimeSlot;
use App\Models\SelectDeliveryLocation;
use App\Models\DietPlanTypesMealCalorieMinMax;
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
        $dietPlan=DietPlanType::where('id',$user->diet_plan_type_id)->first();
           $caloriRecommended = CalorieRecommend::select('id','recommended')->get();
         foreach($caloriRecommended as $calori){
            $calori->selected=false;
            if(UserCaloriTarget::where(['user_id'=>Auth::guard('api')->id(),'recommended_result_id'=>$calori->id,'status'=>'ongoing'])->first()){
                $calori->selected=true;
            }
        }
        // $data=['recommended_colorie'=>1500];
        $data['description'] = $dietPlan->description;
        $data['recommended_colorie'] = $caloriRecommended;

        $getUserCalorie = UserCaloriTarget::where(['user_id'=>Auth::guard('api')->id(),'status'=>'ongoing'])->first();
        if($getUserCalorie){
          $caloriRecommended = CalorieRecommend::select('id','recommended')->where('id',$getUserCalorie->recommended_result_id)->first();
          $getMinMax = DietPlanTypesMealCalorieMinMax::where('diet_plan_type_id',$user->diet_plan_type_id)->where('meal_calorie',$caloriRecommended->recommended)->first();
          }
          $data['getMinMaxValue'] = $getMinMax;

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
     if(round($total_recommended_Kcal<2000,0)){
          $total_recommended_Kcal = round($total_recommended_Kcal,0);
          $recommended_result=CalorieRecommend::where('min_range','<=',$total_recommended_Kcal)->where('max_range','>=',$total_recommended_Kcal)->first();
          $getMinMax = DietPlanTypesMealCalorieMinMax::where('diet_plan_type_id',$dietPlan->id)->where('meal_calorie',$recommended_result->recommended)->first();
      }else{
        $getMinMax = DietPlanTypesMealCalorieMinMax::where('diet_plan_type_id',$dietPlan->id)->where('meal_calorie','2000')->first();
   }
    //  $protein_min = (($recommended_result['recommended']*$dietPlan->protein_default_min)/100)/$dietPlan->protein_min_divisor;
    //  $protein_max = (($recommended_result['recommended']*$dietPlan->protein_default_max)/100)/$dietPlan->protein_max_divisor;
    //  $protien = ($protein_min+$protein_max)/2;
    //   $carb_min = (($recommended_result['recommended']*$dietPlan->carb_default_min)/100)/$dietPlan->carb_min_divisor;
    //   $carb_max = (($recommended_result['recommended']*$dietPlan->carb_default_max)/100)/$dietPlan->carb_max_divisor;
    //   $carbs = ($carb_min+$carb_max)/2;
    //   $fat_min = (($recommended_result['recommended']*$dietPlan->fat_default_min)/100)/$dietPlan->fat_min_divisor;
    //   $fat_max = (($recommended_result['recommended']*$dietPlan->fat_default_max)/100)/$dietPlan->fat_max_divisor;
    //   $fat = ($fat_min+$fat_max)/2;
   
    //  $data=['protein'=>round($protien),'carbs'=>round($carbs),'fat'=>round($fat)];

     /*********End Calculation for protein carb and fat */

        
       $data['getMinMaxValue'] = $getMinMax;
        $data['recommended_colorie'] = round($total_recommended_Kcal,0);
         $data['description'] = $dietPlan->description;
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
        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
        if($language->lang == 'ar'){
        $id = $request->meal_plan_id;
        $meal_des=[];
         $userCustomCalorie = UserCaloriTarget::select('custom_result_id')->where('user_id',Auth::guard('api')->id())->first();
         $targetCalorie = CalorieRecommend::select('recommended')->where('id',$userCustomCalorie->custom_result_id)->first();
           $mealDetail=Meal::join('meal_macro_nutrients','meals.id','=','meal_macro_nutrients.meal_id')
          ->select('meals.id as meal_id','meals.name_ar as meal_name','meals.image','meals.description_ar as description','meals.image','meals.food_type','meal_macro_nutrients.meal_calorie','meal_macro_nutrients.protein','meal_macro_nutrients.carbs','meal_macro_nutrients.fat')
          ->where('meal_macro_nutrients.user_calorie',$targetCalorie->recommended)
          ->where('meals.id',$request->meal_plan_id)->first();
        //  $mealDetail = Meal::join('meal_schedules','meals.id','=','meal_schedules.id')
        // ->select('meals.id as meal_id','meals.name as meal_name','image','description','image','food_type','meal_schedules.name')
        // ->where('meals.id',$request->meal_plan_id)
        // ->get()
        
           $meal_schedule= MealSchedules::join('meal_group_schedule','meal_schedules.id','=','meal_group_schedule.meal_schedule_id')
           ->where('meal_group_schedule.meal_id', $mealDetail->meal_id)
           ->select('meal_schedules.name_ar as name')->first();
           $mealDetail->name = $meal_schedule->name;
        
      

        // $ingredient=DislikeItem::select('name')->get();
        // foreach($ingredient as $meal){
        //     array_push($meal_des,$meal->name);
        // }
        // $ing = implode(',', $meal_des);

         $dislikeItem = DislikeItem::join('meal_ingredient_list','dislike_items.id','=','meal_ingredient_list.item_id')
         ->select('dislike_items.id','dislike_items.group_id','dislike_items.name_ar as name')
         ->where('meal_ingredient_list.meal_id',$id)
         ->where('dislike_items.status','active')->get()
         ->each(function($dislikeItem){
            $dislikeItem->selected=false;
            if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$dislikeItem->group_id])->first()){
                $dislikeItem->selected=true;
            }
        });
        $dislikegroup = DislikeGroup::select('id','name_ar as name')->where('status','active')->get()->each(function($dislikegroup){
            $dislikegroup->selected=false;
            if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$dislikegroup->id])->first()){
                $dislikegroup->selected=true;
            }
        });
  
        $mealDetail->dislike_item = $dislikeItem;
        $mealDetail->dislikegroup = $dislikegroup;
        $data=$mealDetail;
    }else{
        $id = $request->meal_plan_id;
        $meal_des=[];
         $userCustomCalorie = UserCaloriTarget::select('custom_result_id')->where('user_id',Auth::guard('api')->id())->first();
         $targetCalorie = CalorieRecommend::select('recommended')->where('id',$userCustomCalorie->custom_result_id)->first();
           $mealDetail=Meal::join('meal_macro_nutrients','meals.id','=','meal_macro_nutrients.meal_id')
          ->select('meals.id as meal_id','meals.name as meal_name','meals.image','meals.description','meals.image','meals.food_type','meal_macro_nutrients.meal_calorie','meal_macro_nutrients.protein','meal_macro_nutrients.carbs','meal_macro_nutrients.fat')
          ->where('meal_macro_nutrients.user_calorie',$targetCalorie->recommended)
          ->where('meals.id',$request->meal_plan_id)->first();
        //  $mealDetail = Meal::join('meal_schedules','meals.id','=','meal_schedules.id')
        // ->select('meals.id as meal_id','meals.name as meal_name','image','description','image','food_type','meal_schedules.name')
        // ->where('meals.id',$request->meal_plan_id)
        // ->get()
        
           $meal_schedule= MealSchedules::join('meal_group_schedule','meal_schedules.id','=','meal_group_schedule.meal_schedule_id')
           ->where('meal_group_schedule.meal_id', $mealDetail->meal_id)
           ->select('meal_schedules.name')->first();
           $mealDetail->name = $meal_schedule->name;
        
      

        // $ingredient=DislikeItem::select('name')->get();
        // foreach($ingredient as $meal){
        //     array_push($meal_des,$meal->name);
        // }
        // $ing = implode(',', $meal_des);

         $dislikeItem = DislikeItem::join('meal_ingredient_list','dislike_items.id','=','meal_ingredient_list.item_id')
         ->select('dislike_items.id','dislike_items.group_id','dislike_items.name')
         ->where('meal_ingredient_list.meal_id',$id)
         ->where('dislike_items.status','active')->get()
         ->each(function($dislikeItem){
            $dislikeItem->selected=false;
            if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$dislikeItem->group_id])->first()){
                $dislikeItem->selected=true;
            }
        });
        $dislikegroup = DislikeGroup::select('id','name')->where('status','active')->get()->each(function($dislikegroup){
            $dislikegroup->selected=false;
            if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$dislikegroup->id])->first()){
                $dislikegroup->selected=true;
            }
        });
  
        $mealDetail->dislike_item = $dislikeItem;
        $mealDetail->dislikegroup = $dislikegroup;
        $data=$mealDetail;

    }
        $response = new \Lib\PopulateResponse($data);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('plan_messages.diet_plan_detail');
    
        return $this->populateResponse();
        
    }


 

    public function targetCalorie(){
      
        $caloriRecommended = CalorieRecommend::select('id','recommended')->get();
        $user=UserProfile::where('user_id',Auth::guard('api')->id())->first();
        $diet_id = $user->diet_plan_type_id;
        $description = DietPlanType::select('description')->where('id',$user->diet_plan_type_id)->first();
        foreach($caloriRecommended as $calori){
           $calori->selected=false;
           if(UserCaloriTarget::where(['user_id'=>Auth::guard('api')->id(),'recommended_result_id'=>$calori->id,'status'=>'ongoing','is_custom'=>'0'])->first()){
               $calori->selected=true;
           }
       }

       $checkCustomOrRecommend = UserCaloriTarget::where(['user_id'=>Auth::guard('api')->id(),'status'=>'ongoing'])->first();
       if($checkCustomOrRecommend->custom_result_id == $checkCustomOrRecommend->recommended_result_id ){
           $status = '1';
       }else{
           $status = '0';
       }

        // $data=['recommended_colorie'=>1500];
        $data=['description' => $description];
        $data=['diet_id'=>$diet_id];
        $data['recommended_colorie'] = $caloriRecommended;
        $data['status'] = $status;

        /*********Calorie, protein, fat, carbs addition */
   $getUserCalorie = UserCaloriTarget::where(['user_id'=>Auth::guard('api')->id(),'status'=>'ongoing'])->first();
   if($getUserCalorie){
     $caloriRecommended = CalorieRecommend::select('id','recommended')->where('id',$getUserCalorie->recommended_result_id)->first();
     $getMinMax = DietPlanTypesMealCalorieMinMax::where('diet_plan_type_id',$user->diet_plan_type_id)->where('meal_calorie',$caloriRecommended->recommended)->first();
     }
     $data['getMinMaxValue'] = $getMinMax;

   /*********end Calorie, protein, fat, carbs addition */

        $response = new \Lib\PopulateResponse($data);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('plan_messages.calorie_calculation');
        return $this->populateResponse();
    }


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
        $user=UserProfile::where('user_id',Auth::guard('api')->id())->first();
        $description = DietPlanType::select('description')->where('id',$user->diet_plan_type_id)->first();
        $diet_id = $user->diet_plan_type_id;
        foreach($caloriRecommended as $calori){
           $calori->selected=false;
           if(UserCaloriTarget::where(['user_id'=>Auth::guard('api')->id(),'custom_result_id'=>$calori->id,'status'=>'ongoing'])->first()){
               $calori->selected=true;
     
           }
       }
     

        $data=['diet_id'=>$diet_id];
        $data=['diet_id'=>$diet_id];
        $data['recommended_colorie'] = $caloriRecommended;

        $getUserCalorie = UserCaloriTarget::where(['user_id'=>Auth::guard('api')->id(),'status'=>'ongoing'])->first();
        if($getUserCalorie){
          $caloriRecommended = CalorieRecommend::select('id','recommended')->where('id',$getUserCalorie->custom_result_id)->first();
          $getMinMax = DietPlanTypesMealCalorieMinMax::where('diet_plan_type_id',$user->diet_plan_type_id)->where('meal_calorie',$caloriRecommended->recommended)->first();
          }
          $data['getMinMaxValue'] = $getMinMax;

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
        $request->variant_id;
        $request->subscription_plan_id; // this id get from my plan when user click on perticular plan then get ths detail
       

         $subscriptions=SubscriptionPlan::select('id')->where(['id'=> $request->subscription_plan_id])->first();
        if(Subscription::where(['plan_id'=>$subscriptions['id'],'variant_id'=>$request->variant_id,'user_id'=>Auth::guard('api')->id()])
        ->where(function($q){
            $q->where('delivery_status','paused')
            ->orWhere('delivery_status','upcoming')
            ->orWhere('delivery_status','active');
        })->first()){
            $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
            if($language->lang == 'ar'){
           $subscription=SubscriptionPlan::join('subscriptions','subscription_plans.id','=','subscriptions.plan_id')
         ->join('subscriptions_meal_plans_variants','subscription_plans.id','=','subscriptions_meal_plans_variants.meal_plan_id')
         ->select('subscription_plans.id','subscription_plans.name_ar','subscription_plans.image','subscriptions.start_date','subscriptions_meal_plans_variants.no_days as no_dayss','subscriptions.delivery_status','subscriptions_meal_plans_variants.variant_name','subscriptions_meal_plans_variants.option2')
         ->where(['subscriptions.plan_id'=>$subscriptions->id,'subscriptions.variant_id'=> $request->variant_id])
         ->where(['subscriptions_meal_plans_variants.id'=> $request->variant_id])
         ->where(['subscriptions.user_id'=> Auth::guard('api')->id()])
         ->where(['subscription_plans.status'=>'active','subscription_plans.id'=>$subscriptions->id])
         ->first();
            }else{
                $subscription=SubscriptionPlan::join('subscriptions','subscription_plans.id','=','subscriptions.plan_id')
                ->join('subscriptions_meal_plans_variants','subscription_plans.id','=','subscriptions_meal_plans_variants.meal_plan_id')
                ->select('subscription_plans.id','subscription_plans.name','subscription_plans.image','subscriptions.start_date','subscriptions_meal_plans_variants.no_days as no_dayss','subscriptions.delivery_status','subscriptions_meal_plans_variants.variant_name','subscriptions_meal_plans_variants.option2')
                ->where(['subscriptions.plan_id'=>$subscriptions->id,'subscriptions.variant_id'=> $request->variant_id])
                ->where(['subscriptions_meal_plans_variants.id'=> $request->variant_id])
                ->where(['subscriptions.user_id'=> Auth::guard('api')->id()])
                ->where(['subscription_plans.status'=>'active','subscription_plans.id'=>$subscriptions->id])
                ->first();

            }
      
           if($subscription){
         
            $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
            if($language->lang == 'ar'){
             $subscription->dietPlanTypeId = UserProfile::join('diet_plan_types','user_profile.diet_plan_type_id','=','diet_plan_types.id')
             ->where('user_profile.user_id',Auth::guard('api')->id())
             ->select('diet_plan_types.name_ar as name','user_profile.diet_plan_type_id')
             ->first();
            
                 $dates = Carbon::createFromFormat('Y-m-d',$subscription->start_date);
                 $date = $dates->addDays($subscription->no_dayss);
                 $diff = now()->diffInDays(Carbon::parse($date));

                 $datess = Carbon::createFromFormat('Y-m-d',$subscription->start_date);
                 if($datess->gt(now())){
                    $dates = Carbon::createFromFormat('Y-m-d',$subscription->start_date);
                   $subscription->days_remaining  = 'Your plan start from'.' '.date('d-m-Y',strtotime($dates));
                 }else{
                   if($diff == 0){
                       $subscription->days_remaining  = "Your plan is expire";
                   }else{
                       $subscription->days_remaining  = $diff .' days ';
                   }
                }
            }else{
                $subscription->dietPlanTypeId = UserProfile::join('diet_plan_types','user_profile.diet_plan_type_id','=','diet_plan_types.id')
                ->where('user_profile.user_id',Auth::guard('api')->id())
                ->select('diet_plan_types.name','user_profile.diet_plan_type_id')
                ->first();
               
                    $dates = Carbon::createFromFormat('Y-m-d',$subscription->start_date);
                    $date = $dates->addDays($subscription->no_dayss);
                    $diff = now()->diffInDays(Carbon::parse($date));
   
                    $datess = Carbon::createFromFormat('Y-m-d',$subscription->start_date);
                    if($datess->gt(now())){
                       $dates = Carbon::createFromFormat('Y-m-d',$subscription->start_date);
                      $subscription->days_remaining  = 'تبدأ خطتك من'.' '.date('d-m-Y',strtotime($dates));
                    }else{
                      if($diff == 0){
                          $subscription->days_remaining  = "خطتك انتهت";
                      }else{
                          $subscription->days_remaining  = $diff .' أيام ';
                      }
                   }
                

            }
                $subscription->end_date= date('Y-m-d',strtotime($date));
              
                
                $subscription->meal_groups=[];
                $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                if($language->lang == 'ar'){
                if(SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id,'id'=>$request->variant_id])->first()){

                        $costs=SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id,'id'=>$request->variant_id])->first();
                        $subscription->cost=$costs->plan_price;
                        $subscription->day=$costs->option1;
                        // $costs->option1 = '-';
                       

                        $meals=[];
                        $meal_des=[];
                           $subscription->meal_groups=SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$subscription->id])->get();
                        foreach($subscription->meal_groups as $meal){
                            array_push($meals,['id'=>$meal->meal_group->id,'meal_name'=>$meal->meal_group->name_ar]);
                            array_push($meal_des,$meal->meal_group->name_ar);
                        }
                        $meal_des=count($meal_des)." باقة الوجبات (".implode(',',$meal_des).")";

                        $subscription->description=[
                            "يخدم حتى $costs->serving_calorie من السعرات الحرارية $costs->calorie السعرات الحرارية الموصى بها لك.",
                            $costs->no_days." أيام أ ".$costs->option1,
                            " ".$meal_des
                        ];
                        $subscription->meal_groups=$meals;

                       
                    }
                }else{
                    if(SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id,'id'=>$request->variant_id])->first()){

                        $costs=SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id,'id'=>$request->variant_id])->first();
                        $subscription->cost=$costs->plan_price;
                        $subscription->day=$costs->option1;
                        // $costs->option1 = '-';

                        $meals=[];
                        $meal_des=[];
                           $subscription->meal_groups=SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$subscription->id])->get();
                        foreach($subscription->meal_groups as $meal){
                            array_push($meals,['id'=>$meal->meal_group->id,'meal_name'=>$meal->meal_group->name]);
                            array_push($meal_des,$meal->meal_group->name);
                        }
                        $meal_des=count($meal_des)." Meals Package (".implode(',',$meal_des).")";

                        $subscription->description=[
                            "Serves Upto $costs->serving_calorie calories out of $costs->calorie calories recommended for you.",
                            $costs->no_days." days a ".$costs->option1,
                            " ".$meal_des
                        ];
                        $subscription->meal_groups=$meals;

                       
                    }

                }
                }
               if( Subscription::where(['user_id' => Auth::guard('api')->id(),  'plan_id' =>  $request->subscription_plan_id, 'variant_id' => $request->variant_id,'delivery_status'=>'upcoming'])->exists()){
                 $PlanStatus = Subscription::select('plan_status')->where(['user_id' => Auth::guard('api')->id(),  'plan_id' =>  $request->subscription_plan_id, 'variant_id' => $request->variant_id,'delivery_status'=>'upcoming'])->first();
                if($PlanStatus->plan_status == 'plan_active'){
                     $subscription->PlanStatus = 'active';
                }else{
                    $subscription->PlanStatus = 'inactive';
                }
             }else{
                    $subscription->PlanStatus = 'inactive';
                }
                $PlanDateCheck = Subscription::select('start_date')->where(['user_id' => Auth::guard('api')->id(),  'plan_id' =>  $request->subscription_plan_id, 'variant_id' => $request->variant_id,'plan_status'=>'plan_active'])
                ->where(function($q){
                    $q->where('delivery_status','paused')
                    ->orWhere('delivery_status','upcoming')
                    ->orWhere('delivery_status','active');
                })
                ->first();
                if(now() < $PlanDateCheck->start_date){
                    $subscription->plan_status = 'upcoming';
                }else{
                    $subscription->plan_status = 'continue';
                }
                $countSkip = UserSkipDelivery::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$request->subscription_id,'variant_id'=>$request->variant_id])->count();
                $swapno_of_days =  $countSkip;
                $no_of_days_pause_plan = Subscription::select('no_of_days_pause_plan')->where(['user_id' => Auth::guard('api')->id(),  'plan_id' =>  $request->subscription_plan_id, 'variant_id' => $request->variant_id,'delivery_status'=>'active','plan_status'=>'plan_active'])->first();
                if($subscription->start_date){
                    if($subscription->option2 == 'withoutweekend'){
                        //  $date = Carbon::createFromFormat('Y-m-d',$subscription->start_date);
                        $date = Carbon::now();
                        $weekdays = 0;
                        $weekdayss = 0;
                          for ($i = 0; $i < $subscription->no_dayss; $i++) {
                               $alldate = $date->addDay()->format('y-m-d');
                               $dd = Carbon::createFromFormat('Y-m-d',$alldate);
                                $dayStr = strtolower($dd->format('l'));
                                if ($dayStr == 'friday' ) {
                                   $weekdays++;
                               }
                               if ($dayStr == 'saturday' ) {
                                   $weekdayss++;
                               }
                          }
                        $totalDays = $weekdays+$weekdayss;
                        $subscription->no_days = $subscription->no_dayss+$totalDays+$swapno_of_days+$no_of_days_pause_plan->no_of_days_pause_plan;
                        }else{
                            
                            $subscription->no_days = $subscription->no_dayss+$swapno_of_days+$no_of_days_pause_plan->no_of_days_pause_plan;
                        }
                    //    dd($increasingdays);
                 }

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
         $plan_id = $request->subscription_plan_id;
        $variant_id = $request->variant_id;

        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
        if($language->lang == 'ar'){

         $datess = Carbon::createFromFormat('Y-m-d',$dates);
          $day = strtolower($datess->format('l'));

        if($day == 'monday'){
            $var = "1";
        }elseif($day == 'tuesday'){
            $var = '2';
        }elseif($day == 'wednesday'){
           $var = '3';
       }elseif($day == 'thursday'){
           $var = '4';
       }elseif($day == 'friday'){
           $var = '5';
       }elseif($day == 'saturday'){
           $var = '6';
       }else{
           $var = '7';
       }
       $datess = Carbon::createFromFormat('Y-m-d',$dates);
       $day = strtolower($datess->format('l'));
     $getAllDays = UserAddress::where('user_id',Auth::guard('api')->id())->where('day_selection_status','active')->get();
     if($day == 'monday'){
         $var = "1";
     }elseif($day == 'tuesday'){
         $var = '2';
     }elseif($day == 'wednesday'){
        $var = '3';
    }elseif($day == 'thursday'){
        $var = '4';
    }elseif($day == 'friday'){
        $var = '5';
    }elseif($day == 'saturday'){
        $var = '6';
    }else{
        $var = '7';
    }

    // $custom_calorie = $request->custom_calorie;
    $userCustomCalorie = UserCaloriTarget::select('custom_result_id')->where('user_id',Auth::guard('api')->id())->first();
    $targetCalorie = CalorieRecommend::select('recommended')->where('id',$userCustomCalorie->custom_result_id)->first();

    //  $checkPlan = UserProfile::select('id','subscription_id','diet_plan_type_id','variant_id')->where('user_id',Auth::guard('api')->id())->first();
       $start_date = Subscription::select('start_date')->where(['plan_id'=>$plan_id,'variant_id'=>$variant_id,'plan_status'=>'plan_active','delivery_status'=>'active'])->where('user_id',Auth::guard('api')->id())->first();
     $no_of_day = SubscriptionMealPlanVariant::select('no_days','option2')->where(['meal_plan_id'=>$plan_id,'id'=>$variant_id])->first();
     if($start_date){
        if($no_of_day->option2 == 'withoutweekend'){
        $date = Carbon::createFromFormat('Y-m-d',$start_date->start_date);
        $weekdays = 0;
        $weekdayss = 0;
          for ($i = 0; $i < $no_of_day->no_days; $i++) {
               $alldate = $date->addDay()->format('y-m-d');
               $dd = Carbon::createFromFormat('Y-m-d',$alldate);
                $dayStr = strtolower($dd->format('l'));
                if ($dayStr == 'friday' ) {
                   $weekdays++;
               }
               if ($dayStr == 'saturday' ) {
                   $weekdayss++;
               }
          }
        $totalDays = $weekdays+$weekdayss;
        $increasingdays = $no_of_day->no_days+$totalDays;
        }else{
        $increasingdays = $no_of_day->no_days;
        }
        //    dd($increasingdays);
     }

    
     if(!empty($no_of_day))
     {

         $countSkip = UserSkipDelivery::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->count();
         $no_of_days = $no_of_day->no_days + $countSkip;
     }

    if(UserChangeDeliveryLocation::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('change_location_for_date',$dates)->exists()){
        $deliverie = userAddress::join('user_change_delivery_location','user_address.id','=','user_change_delivery_location.user_address_id')
        // ->join('delivery_slots','user_address.delivery_slot_id','=','delivery_slots.id')
        ->select('user_address.address_type','user_address.id')
        ->where('user_change_delivery_location.user_id',Auth::guard('api')->id())
         ->where('user_change_delivery_location.change_location_for_date',$dates)
         ->where('user_change_delivery_location.subscription_plan_id',$plan_id)
         ->where('user_change_delivery_location.variant_id',$variant_id)
        ->first();

        if(UserSkipTimeSlot::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('skip_date',$dates)->exists()){

            $deliveries_slot = UserSkipTimeSlot::join('delivery_slots','user_skip_time_slot.delivery_slot_id','=','delivery_slots.id')
           ->join('user_address','user_skip_time_slot.user_address_id','=','user_address.id')
           ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.id','delivery_slots.name_ar as name','delivery_slots.id as slot_id')
           ->where('user_skip_time_slot.skip_date',$dates)
            ->where('user_skip_time_slot.user_id',Auth::guard('api')->id())
            ->where('user_skip_time_slot.subscription_plan_id',$plan_id)
            ->where('user_skip_time_slot.variant_id',$variant_id)
           ->first();
           $deliverie->start_time = $deliveries_slot->start_time;
           $deliverie->end_time = $deliveries_slot->end_time;
           $deliverie->name = $deliveries_slot->name;
           $deliverie->slot_id = $deliveries_slot->slot_id;
        
       }else{
        $deliverieSlot = userAddress::join('user_change_delivery_location','user_address.id','=','user_change_delivery_location.user_address_id')
        ->join('delivery_slots','user_address.delivery_slot_id','=','delivery_slots.id')
        ->select('delivery_slots.start_time','delivery_slots.end_time','delivery_slots.name_ar as name','delivery_slots.id as slot_id')
        ->where('user_change_delivery_location.user_id',Auth::guard('api')->id())
         ->where('user_change_delivery_location.change_location_for_date',$dates)
         ->where('user_change_delivery_location.subscription_plan_id',$plan_id)
         ->where('user_change_delivery_location.variant_id',$variant_id)
        ->first();
     
       $deliverie->start_time = $deliverieSlot->start_time;
       $deliverie->end_time = $deliverieSlot->end_time;
       $deliverie->name = $deliverieSlot->name;
       $deliverie->slot_id = $deliverieSlot->slot_id;
    }

       $data['deliveries'] = $deliverie;

    }else{
        if(UserSkipTimeSlot::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('skip_date',$dates)->exists()){
    
             $deliverie = UserSkipTimeSlot::join('delivery_slots','user_skip_time_slot.delivery_slot_id','=','delivery_slots.id')
            // ->join('user_address','user_skip_time_slot.user_address_id','=','user_address.id')
            ->select('delivery_slots.start_time','delivery_slots.end_time','delivery_slots.name_ar as name','delivery_slots.id as slot_id')
            ->where('user_skip_time_slot.skip_date',$dates)
             ->where('user_skip_time_slot.user_id',Auth::guard('api')->id())
             ->where('user_skip_time_slot.subscription_plan_id',$plan_id)
             ->where('user_skip_time_slot.variant_id',$variant_id)
            ->first();
                $deliveries = userAddress::
                select('user_address.id','user_address.address_type')
                ->where('user_id',Auth::guard('api')->id())
                ->where('day_selection_status','active')
                ->when($var == "1", function ($q) {
                    $q->where('monday',"1");
                 })
                 ->when($var == "2", function ($q) {
                     $q->where('tuesday',"1");
                 })
                 ->when($var == "3", function ($q) {
                     $q->where('wednesday',"1");
                 })
                 ->when($var == "4", function ($q) {
                     $q->where('thursday',"1");
                 })
                 ->when($var == "5", function ($q) {
                     $q->where('friday',"1");
                 })
                 ->when($var == "6", function ($q) {
                     $q->where('saturday',"1");
                 })
                 ->when($var == "7", function ($q) {
                     $q->where('sunday',"1");
                 })
                ->first();

                $deliverie->address_type = $deliveries->address_type;
                $deliverie->id = $deliveries->id;

            $data['deliveries'] = $deliverie;
          
        }else{
            $data['deliveries'] = DeliverySlot::join('user_address','delivery_slots.id','=','user_address.delivery_slot_id')
        ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.id','delivery_slots.name_ar as name','delivery_slots.id as slot_id','user_address.address_type')
        ->where('user_id',Auth::guard('api')->id())
        ->where('day_selection_status','active')
        ->when($var == "1", function ($q) {
           $q->where('monday',"1");
        })
        ->when($var == "2", function ($q) {
            $q->where('tuesday',"1");
        })
        ->when($var == "3", function ($q) {
            $q->where('wednesday',"1");
        })
        ->when($var == "4", function ($q) {
            $q->where('thursday',"1");
        })
        ->when($var == "5", function ($q) {
            $q->where('friday',"1");
        })
        ->when($var == "6", function ($q) {
            $q->where('saturday',"1");
        })
        ->when($var == "7", function ($q) {
            $q->where('sunday',"1");
        })
        ->first();
      }
  }
      if(UserSkipDelivery::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('skip_delivery_date',$dates)->exists())
      {
        
        $category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$plan_id])
        ->get()
        ->each(function($category){
            $category->meal_group->meals = ["you skip your delivery for this date"];
            
        })->toArray();
        $data['category'] = $category;
        $data['skip_status'] = "you skip your delivery for this date";
       }else{
         $checkPlanStatus = UserProfile::select('subscription_id','variant_id')->where('user_id',Auth::guard('api')->id())->first();
         if($checkPlanStatus->subscription_id == $plan_id && $checkPlanStatus->variant_id == $variant_id){
            $data['plan_status'] = "current";
         }else{
            $data['plan_status'] = "previous";
         }
       
        //   $data['deliveries'] = DeliverySlot::join('user_address','delivery_slots.id','=','user_address.delivery_slot_id')
        //   ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.address_type')
        //   ->first();
            $category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$plan_id])
           ->get()
           ->each(function($category) use($dates,$plan_id,$targetCalorie){
            $category->meal_group->meals =Meal::
           join('subscription_meal_plan_variant_default_meal','meals.id','subscription_meal_plan_variant_default_meal.item_id')
           ->join('meal_macro_nutrients','meals.id','=','meal_macro_nutrients.meal_id')
            ->select('meals.id','meals.name_ar as name','meals.side_dish_ar as side_dish','meals.recipe_yields','meals.description_ar as description','meals.image','meals.food_type','meal_macro_nutrients.meal_calorie','meal_macro_nutrients.protein','meal_macro_nutrients.carbs','meal_macro_nutrients.fat')
            ->where('meal_macro_nutrients.user_calorie',$targetCalorie->recommended)
             ->where('subscription_meal_plan_variant_default_meal.meal_schedule_id',$category->meal_group->id)
            ->whereDate('subscription_meal_plan_variant_default_meal.date','=', date('Y-m-d', strtotime($dates)))
            ->where(['subscription_meal_plan_variant_default_meal.meal_plan_id'=> $plan_id,'meals.status'=>'active'])
             
            ->get()->each(function($meals) {
            
            //  $meals->ingredient=MealIngredientList::select('ingredients')->where(['meal_id'=>$meals->id])->get();
             $meals->rating = MealRating::select(DB::raw('avg(rating) as avg_rating'))
             ->where('meal_id', $meals->id)
             ->groupBy('meal_id')
            ->first();
            $meals->ratingcount = MealRating::where('meal_id', $meals->id)
            ->groupBy('meal_id')
           ->count();
     })->toArray();
    })->toArray();
            // ->each(function($category) use($dates){
            //            $meals = $category->meals=Meal::join('meal_ratings','meals.id','=','meal_ratings.meal_id' )
            //         //    ->where(['meal_ratings.user_id',Auth::guard('api')->id()])
            //            ->select('meals.*','meal_ratings.rating')
            //            ->whereDate('meals.created_at','=', date('Y-m-d', strtotime($dates)))
            //            ->where(['meals.meal_schedule_id'=>$category->id])->get()->each(function($meals) {
            //             $meals->ingredient=MealIngredientList::select('ingredients')->where(['meal_id'=>$meals->id])->get();
            //     })->toArray();
            //    })->toArray();
                // $category->deliveries = $deliveries;
       
       $data['category'] = $category;
       $data['skip_status'] = "";
       $data['no_days'] = $increasingdays;
       $data['withoutOrWithweekend'] = $no_of_day->option2;
       $data['skipNoDaysIncrease'] = $no_of_days;
    }
}else{
    $datess = Carbon::createFromFormat('Y-m-d',$dates);
    $day = strtolower($datess->format('l'));

  if($day == 'monday'){
      $var = "1";
  }elseif($day == 'tuesday'){
      $var = '2';
  }elseif($day == 'wednesday'){
     $var = '3';
 }elseif($day == 'thursday'){
     $var = '4';
 }elseif($day == 'friday'){
     $var = '5';
 }elseif($day == 'saturday'){
     $var = '6';
 }else{
     $var = '7';
 }
 $datess = Carbon::createFromFormat('Y-m-d',$dates);
 $day = strtolower($datess->format('l'));
$getAllDays = UserAddress::where('user_id',Auth::guard('api')->id())->where('day_selection_status','active')->get();
if($day == 'monday'){
   $var = "1";
}elseif($day == 'tuesday'){
   $var = '2';
}elseif($day == 'wednesday'){
  $var = '3';
}elseif($day == 'thursday'){
  $var = '4';
}elseif($day == 'friday'){
  $var = '5';
}elseif($day == 'saturday'){
  $var = '6';
}else{
  $var = '7';
}

// $custom_calorie = $request->custom_calorie;
$userCustomCalorie = UserCaloriTarget::select('custom_result_id')->where('user_id',Auth::guard('api')->id())->first();
$targetCalorie = CalorieRecommend::select('recommended')->where('id',$userCustomCalorie->custom_result_id)->first();

//  $checkPlan = UserProfile::select('id','subscription_id','diet_plan_type_id','variant_id')->where('user_id',Auth::guard('api')->id())->first();
 $start_date = Subscription::select('start_date')->where(['plan_id'=>$plan_id,'variant_id'=>$variant_id,'plan_status'=>'plan_active','delivery_status'=>'active'])->where('user_id',Auth::guard('api')->id())->first();
$no_of_day = SubscriptionMealPlanVariant::select('no_days','option2')->where(['meal_plan_id'=>$plan_id,'id'=>$variant_id])->first();
if($start_date){
  if($no_of_day->option2 == 'withoutweekend'){
  $date = Carbon::createFromFormat('Y-m-d',$start_date->start_date);
  $weekdays = 0;
  $weekdayss = 0;
    for ($i = 0; $i < $no_of_day->no_days; $i++) {
         $alldate = $date->addDay()->format('y-m-d');
         $dd = Carbon::createFromFormat('Y-m-d',$alldate);
          $dayStr = strtolower($dd->format('l'));
          if ($dayStr == 'friday' ) {
             $weekdays++;
         }
         if ($dayStr == 'saturday' ) {
             $weekdayss++;
         }
    }
  $totalDays = $weekdays+$weekdayss;
  $increasingdays = $no_of_day->no_days+$totalDays;
  }else{
  $increasingdays = $no_of_day->no_days;
  }
  //    dd($increasingdays);
}


if(!empty($no_of_day))
{

   $countSkip = UserSkipDelivery::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->count();
   $no_of_days = $no_of_day->no_days + $countSkip;
}

if(UserChangeDeliveryLocation::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('change_location_for_date',$dates)->exists()){
  $deliverie = userAddress::join('user_change_delivery_location','user_address.id','=','user_change_delivery_location.user_address_id')
  // ->join('delivery_slots','user_address.delivery_slot_id','=','delivery_slots.id')
  ->select('user_address.address_type','user_address.id')
  ->where('user_change_delivery_location.user_id',Auth::guard('api')->id())
   ->where('user_change_delivery_location.change_location_for_date',$dates)
   ->where('user_change_delivery_location.subscription_plan_id',$plan_id)
   ->where('user_change_delivery_location.variant_id',$variant_id)
  ->first();

  if(UserSkipTimeSlot::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('skip_date',$dates)->exists()){

      $deliveries_slot = UserSkipTimeSlot::join('delivery_slots','user_skip_time_slot.delivery_slot_id','=','delivery_slots.id')
     ->join('user_address','user_skip_time_slot.user_address_id','=','user_address.id')
     ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.id','delivery_slots.name','delivery_slots.id as slot_id')
     ->where('user_skip_time_slot.skip_date',$dates)
      ->where('user_skip_time_slot.user_id',Auth::guard('api')->id())
      ->where('user_skip_time_slot.subscription_plan_id',$plan_id)
      ->where('user_skip_time_slot.variant_id',$variant_id)
     ->first();
     $deliverie->start_time = $deliveries_slot->start_time;
     $deliverie->end_time = $deliveries_slot->end_time;
     $deliverie->name = $deliveries_slot->name;
     $deliverie->slot_id = $deliveries_slot->slot_id;
  
 }else{
  $deliverieSlot = userAddress::join('user_change_delivery_location','user_address.id','=','user_change_delivery_location.user_address_id')
  ->join('delivery_slots','user_address.delivery_slot_id','=','delivery_slots.id')
  ->select('delivery_slots.start_time','delivery_slots.end_time','delivery_slots.name','delivery_slots.id as slot_id')
  ->where('user_change_delivery_location.user_id',Auth::guard('api')->id())
   ->where('user_change_delivery_location.change_location_for_date',$dates)
   ->where('user_change_delivery_location.subscription_plan_id',$plan_id)
   ->where('user_change_delivery_location.variant_id',$variant_id)
  ->first();

 $deliverie->start_time = $deliverieSlot->start_time;
 $deliverie->end_time = $deliverieSlot->end_time;
 $deliverie->name = $deliverieSlot->name;
 $deliverie->slot_id = $deliverieSlot->slot_id;
}

 $data['deliveries'] = $deliverie;

}else{
  if(UserSkipTimeSlot::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('skip_date',$dates)->exists()){

       $deliverie = UserSkipTimeSlot::join('delivery_slots','user_skip_time_slot.delivery_slot_id','=','delivery_slots.id')
      // ->join('user_address','user_skip_time_slot.user_address_id','=','user_address.id')
      ->select('delivery_slots.start_time','delivery_slots.end_time','delivery_slots.name','delivery_slots.id as slot_id')
      ->where('user_skip_time_slot.skip_date',$dates)
       ->where('user_skip_time_slot.user_id',Auth::guard('api')->id())
       ->where('user_skip_time_slot.subscription_plan_id',$plan_id)
       ->where('user_skip_time_slot.variant_id',$variant_id)
      ->first();
          $deliveries = userAddress::
          select('user_address.id','user_address.address_type')
          ->where('user_id',Auth::guard('api')->id())
          ->where('day_selection_status','active')
          ->when($var == "1", function ($q) {
              $q->where('monday',"1");
           })
           ->when($var == "2", function ($q) {
               $q->where('tuesday',"1");
           })
           ->when($var == "3", function ($q) {
               $q->where('wednesday',"1");
           })
           ->when($var == "4", function ($q) {
               $q->where('thursday',"1");
           })
           ->when($var == "5", function ($q) {
               $q->where('friday',"1");
           })
           ->when($var == "6", function ($q) {
               $q->where('saturday',"1");
           })
           ->when($var == "7", function ($q) {
               $q->where('sunday',"1");
           })
          ->first();

          $deliverie->address_type = $deliveries->address_type;
          $deliverie->id = $deliveries->id;

      $data['deliveries'] = $deliverie;
    
  }else{
      $data['deliveries'] = DeliverySlot::join('user_address','delivery_slots.id','=','user_address.delivery_slot_id')
  ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.id','delivery_slots.name','delivery_slots.id as slot_id','user_address.address_type')
  ->where('user_id',Auth::guard('api')->id())
  ->where('day_selection_status','active')
  ->when($var == "1", function ($q) {
     $q->where('monday',"1");
  })
  ->when($var == "2", function ($q) {
      $q->where('tuesday',"1");
  })
  ->when($var == "3", function ($q) {
      $q->where('wednesday',"1");
  })
  ->when($var == "4", function ($q) {
      $q->where('thursday',"1");
  })
  ->when($var == "5", function ($q) {
      $q->where('friday',"1");
  })
  ->when($var == "6", function ($q) {
      $q->where('saturday',"1");
  })
  ->when($var == "7", function ($q) {
      $q->where('sunday',"1");
  })
  ->first();
}
}
if(UserSkipDelivery::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('skip_delivery_date',$dates)->exists())
{
  
  $category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$plan_id])
  ->get()
  ->each(function($category){
      $category->meal_group->meals = ["you skip your delivery for this date"];
      
  })->toArray();
  $data['category'] = $category;
  $data['skip_status'] = "you skip your delivery for this date";
 }else{
   $checkPlanStatus = UserProfile::select('subscription_id','variant_id')->where('user_id',Auth::guard('api')->id())->first();
   if($checkPlanStatus->subscription_id == $plan_id && $checkPlanStatus->variant_id == $variant_id){
      $data['plan_status'] = "current";
   }else{
      $data['plan_status'] = "previous";
   }
 
  //   $data['deliveries'] = DeliverySlot::join('user_address','delivery_slots.id','=','user_address.delivery_slot_id')
  //   ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.address_type')
  //   ->first();
      $category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$plan_id])
     ->get()
     ->each(function($category) use($dates,$plan_id,$targetCalorie){
      $category->meal_group->meals =Meal::
     join('subscription_meal_plan_variant_default_meal','meals.id','subscription_meal_plan_variant_default_meal.item_id')
     ->join('meal_macro_nutrients','meals.id','=','meal_macro_nutrients.meal_id')
      ->select('meals.id','meals.name','meals.name_ar','meals.side_dish','meals.side_dish_ar','meals.recipe_yields','meals.description','meals.description_ar','meals.image','meals.food_type','meal_macro_nutrients.meal_calorie','meal_macro_nutrients.protein','meal_macro_nutrients.carbs','meal_macro_nutrients.fat')
      ->where('meal_macro_nutrients.user_calorie',$targetCalorie->recommended)
       ->where('subscription_meal_plan_variant_default_meal.meal_schedule_id',$category->meal_group->id)
      ->whereDate('subscription_meal_plan_variant_default_meal.date','=', date('Y-m-d', strtotime($dates)))
      ->where(['subscription_meal_plan_variant_default_meal.meal_plan_id'=> $plan_id,'meals.status'=>'active'])
       
      ->get()->each(function($meals) {
      
      //  $meals->ingredient=MealIngredientList::select('ingredients')->where(['meal_id'=>$meals->id])->get();
       $meals->rating = MealRating::select(DB::raw('avg(rating) as avg_rating'))
       ->where('meal_id', $meals->id)
       ->groupBy('meal_id')
      ->first();
      $meals->ratingcount = MealRating::where('meal_id', $meals->id)
      ->groupBy('meal_id')
     ->count();
})->toArray();
})->toArray();
      // ->each(function($category) use($dates){
      //            $meals = $category->meals=Meal::join('meal_ratings','meals.id','=','meal_ratings.meal_id' )
      //         //    ->where(['meal_ratings.user_id',Auth::guard('api')->id()])
      //            ->select('meals.*','meal_ratings.rating')
      //            ->whereDate('meals.created_at','=', date('Y-m-d', strtotime($dates)))
      //            ->where(['meals.meal_schedule_id'=>$category->id])->get()->each(function($meals) {
      //             $meals->ingredient=MealIngredientList::select('ingredients')->where(['meal_id'=>$meals->id])->get();
      //     })->toArray();
      //    })->toArray();
          // $category->deliveries = $deliveries;
 
 $data['category'] = $category;
 $data['skip_status'] = "";
 $data['no_days'] = $increasingdays;
 $data['withoutOrWithweekend'] = $no_of_day->option2;
 $data['skipNoDaysIncrease'] = $no_of_days;
}

}
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
        $user_detail = UserProfile::select('subscription_id','variant_id')->where('user_id',Auth::guard('api')->id())->first();
        
    $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
    if($language->lang == 'ar'){
          $meal = Subscription::join('subscription_plans','subscriptions.plan_id','=','subscription_plans.id')
        ->join('subscriptions_meal_plans_variants','subscriptions.plan_id','=','subscriptions_meal_plans_variants.meal_plan_id')
       ->select('subscriptions_meal_plans_variants.id as variant_id','subscriptions_meal_plans_variants.no_days','subscriptions.start_date','subscriptions.end_date','subscription_plans.image','subscription_plans.name_ar as name','subscription_plans.id','subscriptions_meal_plans_variants.option1','subscriptions_meal_plans_variants.plan_price')
       ->where(['subscriptions.user_id'=>Auth::guard('api')->id()])->where(function($q){
        $q->where('subscriptions.delivery_status','paused')
        ->orWhere('subscriptions.delivery_status','upcoming')
        ->orWhere('subscriptions.delivery_status','active');
        })
       ->where('subscriptions.variant_id',$user_detail->variant_id)
       ->where('subscriptions_meal_plans_variants.id',$user_detail->variant_id)
    //    ->where('subscriptions.delivery_status','!=','upcoming')
       ->first();
       if($meal){
        $dates = Carbon::createFromFormat('Y-m-d',$meal->start_date);
          $date = $dates->addDays($meal->no_days);
           $diff = now()->diffInDays(Carbon::parse($meal->end_date));
           
           $datess = Carbon::createFromFormat('Y-m-d',$meal->start_date);
           if($datess->gt(now())){
             $dates = Carbon::createFromFormat('Y-m-d',$meal->start_date);
             $meal->days_remaining  = 'تبدأ خطتك من'.' '.date('d-m-Y',strtotime($dates));
           }else{
             if($diff == 0){
                 $meal->days_remaining  = "خطتك انتهت";
             }else{
                 $meal->days_remaining  = $diff .' أيام ';
             }
         
         }
        // if($diff == 0){
        //     $meal->days_remaining  = "Your plan is expire today";
        // }
        //     elseif($date< now()){
        //     $meal->days_remaining  = "Your plan is expire ";
        //     UserProfile::where('user_id',Auth::guard('api')->id())->update(['subscription_id'=>Null]);
        //     Subscription::where(['user_id'=>Auth::guard('api')->id(),'plan_id'=>$meal->id])->update(['delivery_status'=>'terminted']);
        //  }else{
        //      $meal->days_remaining  = $diff .' days left to expire ';
        //  }
     
       }
    }else{
        $meal = Subscription::join('subscription_plans','subscriptions.plan_id','=','subscription_plans.id')
        ->join('subscriptions_meal_plans_variants','subscriptions.plan_id','=','subscriptions_meal_plans_variants.meal_plan_id')
       ->select('subscriptions_meal_plans_variants.id as variant_id','subscriptions_meal_plans_variants.no_days','subscriptions.start_date','subscription_plans.image','subscription_plans.name','subscription_plans.id','subscriptions_meal_plans_variants.option1','subscriptions_meal_plans_variants.plan_price')
       ->where(['subscriptions.user_id'=>Auth::guard('api')->id()])->where(function($q){
        $q->where('subscriptions.delivery_status','paused')
        ->orWhere('subscriptions.delivery_status','upcoming')
        ->orWhere('subscriptions.delivery_status','active');
        })
       ->where('subscriptions.variant_id',$user_detail->variant_id)
       ->where('subscriptions_meal_plans_variants.id',$user_detail->variant_id)
    //    ->where('subscriptions.delivery_status','!=','upcoming')
       ->first();
       if($meal){
        $dates = Carbon::createFromFormat('Y-m-d',$meal->start_date);
          $date = $dates->addDays($meal->no_days);
           $diff = now()->diffInDays(Carbon::parse($date));
           
           $datess = Carbon::createFromFormat('Y-m-d',$meal->start_date);
           if($datess->gt(now())){
             $dates = Carbon::createFromFormat('Y-m-d',$meal->start_date);
             $meal->days_remaining  = 'Your plan start from'.' '.date('d-m-Y',strtotime($dates));
           }else{
             if($diff == 0){
                 $meal->days_remaining  = "Your plan is expire";
             }else{
                 $meal->days_remaining  = $diff .' days ';
             }
         
         }
       }

    }
  
    
    $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
    if($language->lang == 'ar'){
    $meals = Subscription::join('subscription_plans','subscriptions.plan_id','=','subscription_plans.id')
    ->join('subscriptions_meal_plans_variants','subscriptions.variant_id','=','subscriptions_meal_plans_variants.id')
   ->select('subscriptions_meal_plans_variants.id as variant_id','subscriptions_meal_plans_variants.no_days','subscription_plans.image','subscription_plans.name_ar as name','subscription_plans.id','subscriptions_meal_plans_variants.option1','subscriptions_meal_plans_variants.plan_price','subscriptions.start_date')
   ->where(['subscriptions.delivery_status'=>'terminted','subscriptions.user_id'=>Auth::guard('api')->id()])
   ->get()->each(function($meals){
    $puchase_on = $meals->start_date;
    $meals->puchase_on = date('d M', strtotime($puchase_on));
    $dates = Carbon::createFromFormat('Y-m-d',$meals->start_date);
    $expired_on = $dates->addDays($meals->no_days);
    $meals->expired_on = date('d M', strtotime($expired_on));
   });
}else{
    $meals = Subscription::join('subscription_plans','subscriptions.plan_id','=','subscription_plans.id')
    ->join('subscriptions_meal_plans_variants','subscriptions.variant_id','=','subscriptions_meal_plans_variants.id')
   ->select('subscriptions_meal_plans_variants.id as variant_id','subscriptions_meal_plans_variants.no_days','subscription_plans.image','subscription_plans.name','subscription_plans.id','subscriptions_meal_plans_variants.option1','subscriptions_meal_plans_variants.plan_price','subscriptions.start_date')
   ->where(['subscriptions.delivery_status'=>'terminted','subscriptions.user_id'=>Auth::guard('api')->id()])
   ->get()->each(function($meals){
    $puchase_on = $meals->start_date;
    $meals->puchase_on = date('d M', strtotime($puchase_on));
    $dates = Carbon::createFromFormat('Y-m-d',$meals->start_date);
    $expired_on = $dates->addDays($meals->no_days);
    $meals->expired_on = date('d M', strtotime($expired_on));
   });

}

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
    $request->start_date;
    $request->address_id;
    $request->city_id;
    $request->slected_or_not;
    $request->delivery_slot_id;
    $request->total_amount;

    $step = '';
    if($request->step=='1'){
        $user=UserSelectDeliveryLocation::updateOrCreate(
            ['user_id' =>  Auth::guard('api')->id()],
            [
                'user_id' =>  Auth::guard('api')->id(),
                'city_id' => $request->city_id,
                'selected_or_not'=> $request->selected_or_not,
            ]
        );
    }elseif($request->step=='2'){
         $getAllDayDetail =UserAddress::where(['status'=>'active','user_id'=>Auth::guard('api')->id()])->get();
        if(count($getAllDayDetail) > 0)
        {
         foreach($getAllDayDetail as $getAllDayDetails)
         {
             if(UserAddress::where(['day_selection_status'=>'active','user_id'=>Auth::guard('api')->id()])->exists()){
                $checkDaySelect =UserAddress::where(['day_selection_status'=>'active','user_id'=>Auth::guard('api')->id()])->get();
                // $checkWeekend =UserProfile::where(['user_id'=>Auth::guard('api')->id()])->first();
                  $checkWeekendOrNot =SubscriptionMealPlanVariant::where(['meal_plan_id'=>$request->plan_id,'id'=>$request->variant_id])->first();

                foreach($checkDaySelect as $checkDaySelects){
                  if($checkDaySelects->monday == '1' || $checkDaySelects->tuesday == '1' || $checkDaySelects->wednesday == '1' || $checkDaySelects->thursday == '1' || $checkDaySelects->friday == '1' || $checkDaySelects->saturday == '1' || $checkDaySelects->sunday == '1'){

                   }else{
                    $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                    if($language->lang == 'ar'){
                      return response()->json([
                     'status' => true,
                     'error'=> 'الرجاء تحديد يوم التسليم '
                     ]);
                    }else{
                      return response()->json([
                         'status' => true,
                        'error'=> 'Please select a delivery day '
                     ]);

                    }

                   }

                    $monday = [];
                   if($checkWeekendOrNot->option2 == "withweekend"){
                    // $var = "1";
                    // array_push($monday, $checkDaySelects->monday);
                     $checkDaySelect =UserAddress::where(['day_selection_status'=>'active','user_id'=>Auth::guard('api')->id()])
                    ->where('monday',"1")
                    ->get();
                    if(sizeof($checkDaySelect) == 0){
                        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                        if($language->lang == 'ar'){
                        return response()->json([
                            'status' => true,
                            'error'=> 'يرجى تحديد 7 أيام '
                        ]);
                    }else{
                        return response()->json([
                            'status' => true,
                            'error'=> 'Please select 7 day '
                        ]);

                    }
                    }
                    $checkDaySelect =UserAddress::where(['day_selection_status'=>'active','user_id'=>Auth::guard('api')->id()])
                    ->where('tuesday',"1")
                    ->get();
                    if(sizeof($checkDaySelect) == 0){
                        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                        if($language->lang == 'ar'){
                        return response()->json([
                            'status' => true,
                            'error'=> 'يرجى تحديد 7 أيام'
                        ]);
                    }else{
                        return response()->json([
                            'status' => true,
                            'error'=> 'Please select 7 day '
                        ]);

                    }
                    }
                    $checkDaySelect =UserAddress::where(['day_selection_status'=>'active','user_id'=>Auth::guard('api')->id()])
                    ->where('wednesday',"1")
                    ->get();
                    if(sizeof($checkDaySelect) == 0){
                        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                        if($language->lang == 'ar'){
                        return response()->json([
                            'status' => true,
                            'error'=> 'يرجى تحديد 7 أيام '
                        ]);
                    }else{
                        return response()->json([
                            'status' => true,
                            'error'=> 'Please select 7 day '
                        ]);

                    }
                    }
                    $checkDaySelect =UserAddress::where(['day_selection_status'=>'active','user_id'=>Auth::guard('api')->id()])
                    ->where('thursday',"1")
                    ->get();
                    if(sizeof($checkDaySelect) == 0){
                        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                     if($language->lang == 'ar'){
                        return response()->json([
                            'status' => true,
                            'error'=> 'يرجى تحديد 7 أيام '
                        ]);
                     }else{
                        return response()->json([
                            'status' => true,
                            'error'=> 'Please select 7 day '
                        ]);

                     }
                    }
                    $checkDaySelect =UserAddress::where(['day_selection_status'=>'active','user_id'=>Auth::guard('api')->id()])
                    ->where('friday',"1")
                    ->get();
                    if(sizeof($checkDaySelect) == 0){
                        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                        if($language->lang == 'ar'){
                        return response()->json([
                            'status' => true,
                            'error'=> 'يرجى تحديد 7 أيام '
                        ]);
                    }else{
                        return response()->json([
                            'status' => true,
                            'error'=> 'Please select 7 day '
                        ]);

                    }
                    }
                    $checkDaySelect =UserAddress::where(['day_selection_status'=>'active','user_id'=>Auth::guard('api')->id()])
                    ->where('saturday',"1")
                    ->get();
                    if(sizeof($checkDaySelect) == 0){
                        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                        if($language->lang == 'ar'){
                        return response()->json([
                            'status' => true,
                            'error'=> 'يرجى تحديد 7 أيام '
                        ]);
                    }else{
                        return response()->json([
                            'status' => true,
                            'error'=> 'Please select 7 day '
                        ]);

                    }
                    }
                    $checkDaySelect =UserAddress::where(['day_selection_status'=>'active','user_id'=>Auth::guard('api')->id()])
                    ->where('sunday',"1")
                    ->get();
                    if(sizeof($checkDaySelect) == 0){
                        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                        if($language->lang == 'ar'){
                        return response()->json([
                            'status' => true,
                            'error'=> 'Please select 7 day '
                        ]);
                    }else{
                        return response()->json([
                            'status' => true,
                            'error'=> 'Please select 7 day '
                        ]);

                    }
                    }
                    
                   }
                   if($checkWeekendOrNot->option2 == "withoutweekend"){
                    if(UserAddress::where(['day_selection_status'=>'active','user_id'=>Auth::guard('api')->id()])
                    ->where('friday',"1")
                    ->exists()){
                        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                        if($language->lang == 'ar'){
                        return response()->json([
                            'status' => true,
                            'error'=> 'الرجاء إلغاء تحديد الجمعة'
                        ]);
                    }else{
                        return response()->json([
                            'status' => true,
                            'error'=> 'Please Unselect friday'
                        ]);

                    }
                    }
                    if(UserAddress::where(['day_selection_status'=>'active','user_id'=>Auth::guard('api')->id()])
                    ->where('saturday',"1")
                    ->exists()){
                        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                        if($language->lang == 'ar'){
                        return response()->json([
                            'status' => true,
                            'error'=> 'الرجاء إلغاء تحديد السبت'
                        ]);
                    }else{
                        return response()->json([
                            'status' => true,
                            'error'=> 'Please Unselect saturday'
                        ]);

                    }
                    }
                    $checkDaySelect =UserAddress::where(['day_selection_status'=>'active','user_id'=>Auth::guard('api')->id()])
                    ->where('monday',"1")
                    ->get();
                    if(sizeof($checkDaySelect) == 0){
                        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                        if($language->lang == 'ar'){
                        return response()->json([
                            'status' => true,
                            'error'=> 'الرجاء تحديد 5 أيام '
                        ]);
                    }else{
                        return response()->json([
                            'status' => true,
                            'error'=> 'Please select 5 day '
                        ]);

                    }
                    }
                    $checkDaySelect =UserAddress::where(['day_selection_status'=>'active','user_id'=>Auth::guard('api')->id()])
                    ->where('tuesday',"1")
                    ->get();
                    if(sizeof($checkDaySelect) == 0){
                        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                        if($language->lang == 'ar'){
                        return response()->json([
                            'status' => true,
                            'error'=> 'الرجاء تحديد 5 أيام'
                        ]);
                    }else{
                        return response()->json([
                            'status' => true,
                            'error'=> 'Please select 5 day '
                        ]);

                    }
                    }
                    $checkDaySelect =UserAddress::where(['day_selection_status'=>'active','user_id'=>Auth::guard('api')->id()])
                    ->where('wednesday',"1")
                    ->get();
                    $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                    if($language->lang == 'ar'){
                    if(sizeof($checkDaySelect) == 0){
                        return response()->json([
                            'status' => true,
                            'error'=> 'الرجاء تحديد 5 أيام '
                        ]);
                    }else{
                        return response()->json([
                            'status' => true,
                            'error'=> 'Please select 5 day '
                        ]);

                    }
                    }
                    $checkDaySelect =UserAddress::where(['day_selection_status'=>'active','user_id'=>Auth::guard('api')->id()])
                    ->where('thursday',"1")
                    ->get();
                    if(sizeof($checkDaySelect) == 0){
                        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                        if($language->lang == 'ar'){
                        return response()->json([
                            'status' => true,
                            'error'=> 'الرجاء تحديد 5 أيام '
                        ]);
                    }else{
                        return response()->json([
                            'status' => true,
                            'error'=> 'Please select 5 day '
                        ]);

                    }
                    }
                    $checkDaySelect =UserAddress::where(['day_selection_status'=>'active','user_id'=>Auth::guard('api')->id()])
                    ->where('sunday',"1")
                    ->get();
                    if(sizeof($checkDaySelect) == 0){
                        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                        if($language->lang == 'ar'){
                        return response()->json([
                            'status' => true,
                            'error'=> 'الرجاء تحديد 5 أيام '
                        ]);
                    }else{
                        return response()->json([
                            'status' => true,
                            'error'=> 'Please select 5 day '
                        ]);

                    }
                    }

                   }
               }
             
            }else{
                $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                if($language->lang == 'ar'){
                return response()->json([
                    'status' => true,
                     'error'=> 'الرجاء تحديد عنوان أولا'
                ]);
            }else{
                return response()->json([
                    'status' => true,
                     'error'=> 'Please select an address first'
                ]);

            }
            }
         }
        }else{
            $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
            if($language->lang == 'ar'){
            return response()->json([
                'status' => true,
                'error'=> 'الرجاء إضافة عنوان أولا'
            ]);
        }else{
            return response()->json([
                'status' => true,
                'error'=> 'Please add an address first'
            ]);

        }
        }
       

    }elseif($request->step=='3'){

          
    $update_status = Order::where(['user_id'=> Auth::guard('api')->id(), 'plan_id' => $request->plan_id,  'variant_id' => $request->variant_id,])->update(['plan_status'=>'plan_inactive']);
        $user1=Order::Create(
            // ['user_id' =>  Auth::guard('api')->id()],
            [
                'user_id'=> Auth::guard('api')->id(),
                'card_type' => $request->card_type,
                'payment_method' => $request->payment_method,
                'total_amount' => $request->total_amount,
                // 'address_id' => $addressId,
                // 'delivery_slot_id' => $delivery_slot_id,
                'plan_id' => $request->plan_id,
                'variant_id' => $request->variant_id,
                'plan_status' => 'plan_active',
                
            ]
        );
        if($user1)
        {
           $meal_des =[];
          $delivery_slot =[];
          $areas =[];
          $streets =[];
          $address_types =[];
         $getAddressDeliveryId =UserAddress::where(['day_selection_status'=>'active','user_id'=>Auth::guard('api')->id()])->get();
           if($getAddressDeliveryId){
             foreach($getAddressDeliveryId as $getAddressDeliveryIds){
            //       array_push($meal_des,$getAddressDeliveryIds['id']); 
            //       array_push($delivery_slot,$getAddressDeliveryIds['delivery_slot_id']); 
            //       array_push($areas,$getAddressDeliveryIds['area']);
            //       array_push($streets,$getAddressDeliveryIds['street']);
            //       array_push($address_types,$getAddressDeliveryIds['address_type']);
              
            //    $addressId = implode(',', $meal_des);
            //    $addressIdd = explode(',', $addressId);
            //    dd($addressIdd);
            //    die;
            //    $delivery_slot_id = explode(',', $delivery_slot);
            //    $area = explode(',', $areas);  
            //    $street = explode(',', $streets);
            //    $address_type = explode(',', $address_types);
            //}
            OrderOnAddress::Create(
                [
                    'user_id'=> Auth::guard('api')->id(),
                    'order_id' => $user1->id,
                    'address_id' => $getAddressDeliveryIds->id,
                    'delivery_slot_id' => $getAddressDeliveryIds->delivery_slot_id,
                    'area' => $getAddressDeliveryIds->area,
                    'street' => $getAddressDeliveryIds->street,
                    'house_number' => $getAddressDeliveryIds->house_number,
                    'address_type' => $getAddressDeliveryIds->address_type,
                    
                ]
            );
        }
    }

        }

      
        // $updatePlanStatus = Subscription::where(['user_id' => Auth::guard('api')->id(), 'plan_id' => $request->plan_id, 'variant_id' => $request->variant_id])->update(['plan_status'=>'plan_inactive']);
         $is_weekend = SubscriptionMealPlanVariant::select('option2','plan_price')->where(['meal_plan_id'=>$request->plan_id,'id'=>$request->variant_id])->first();
         if(Subscription::where(['user_id' => Auth::guard('api')->id(),  'plan_id' => $request->plan_id, 'variant_id' => $request->variant_id,'delivery_status'=>'upcoming'])->exists()){
            $updatePlanStatus = Subscription::where(['user_id' => Auth::guard('api')->id(),  'plan_id' => $request->plan_id, 'variant_id' => $request->variant_id,'delivery_status'=>'upcoming'])->update(['status'=>'active', 'price' => $is_weekend->plan_price,  'total_amount' => $request->total_amount, 'plan_status' => 'plan_active',]);
            $credit = UserProfile::where('user_id',Auth::guard('api')->id())->first();
            if(!empty($credit->available_credit)){
                 $totalCredit = $credit->available_credit += $request->total_amount;
                $user3=UserProfile::updateOrCreate(
                    ['user_id' =>  Auth::guard('api')->id()],
                    [
                        'available_credit' => $totalCredit,
                        'subscription_id' => $request->plan_id,
                        'variant_id' => $request->variant_id,
                       
                    ]
                   
                );
    
            }
        }else{
        if($request->buy_status != 'switch'){ 
     $noOfDays = SubscriptionMealPlanVariant::select('no_days','plan_price')->where(['meal_plan_id'=>$request->plan_id, 'id' => $request->variant_id,])->first();
     $dates = Carbon::createFromFormat('Y-m-d',$request->start_date);
       $date = $dates->addDays($noOfDays->no_days);
       $endDate = date('Y-m-d',strtotime($date));
        $user2=Subscription::updateOrCreate(
            ['user_id' =>  Auth::guard('api')->id(),'plan_id' => $request->plan_id,'variant_id' => $request->variant_id,'delivery_status'=>'active'],
            [
                'user_id'=> Auth::guard('api')->id(),
                'plan_id' => $request->plan_id,
                'variant_id' => $request->variant_id,
                'start_date' => $request->start_date,
                'end_date' => $endDate,
                'is_weekend' => $is_weekend->option2,
                'price' => $is_weekend->plan_price,
                'total_amount' => $request->total_amount,
                'delivery_status' => 'active',
                'status' => 'active',
                'plan_status' => 'plan_active',
               
            ]
           
        );
        $user3=SubscriptionOrder::Create(
            // ['user_id' =>  Auth::guard('api')->id()],
            [
                'user_id'=> Auth::guard('api')->id(),
                'subscription_id' => $user2->id,
                'amount' => $request->total_amount,
                // 'payment_status' => 'completed'
               
            ]
           
        );
        $credit = UserProfile::where('user_id',Auth::guard('api')->id())->first();
        if(!empty($credit->available_credit)){
             $totalCredit = $credit->available_credit += $request->total_amount;
            $user3=UserProfile::updateOrCreate(
                ['user_id' =>  Auth::guard('api')->id()],
                [
                    'available_credit' => $totalCredit,
                    'subscription_id' => $request->plan_id,
                    'variant_id' => $request->variant_id,
                   
                ]
               
            );

        }else{
            $user3=UserProfile::updateOrCreate(
                ['user_id' =>  Auth::guard('api')->id()],
                [
                    'available_credit' => $request->total_amount,
                    'subscription_id' => $request->plan_id,
                    'variant_id' => $request->variant_id,
                   
                ]
               
            );

        }
    }else{
        $credit = UserProfile::where('user_id',Auth::guard('api')->id())->first();
        if(!empty($credit->available_credit)){
             $totalCredit = $credit->available_credit += $request->total_amount;
            $user3=UserProfile::updateOrCreate(
                ['user_id' =>  Auth::guard('api')->id()],
                [
                    'available_credit' => $totalCredit,
                   
                ]
               
            );
        }
        

    }
        

        if($request->gift_card_status == '1'){
            $giftCardTicket_id = UserGiftCard::where('voucher_code', $request['voucher_code'])->where('voucher_pin', $request['voucher_pin'])->first();
        UserUsedGiftCard::create([
            'user_id' => Auth::guard('api')->id(),
            'gift_card_id' => $giftCardTicket_id->gift_card_id,
            'voucher_code' => $request['voucher_code'],
            'voucher_pin' => $request['voucher_pin'],
          ]);
          
        }else{

        }


        if($request->promo_status == '1'){
            $promoCodeTicket_id = PromoCode::where('promo_code_ticket_id', $request['ticket_id'])->first();
         UserUsedPromoCode::create([
            'user_id' => Auth::guard('api')->id(),
            'promocode_id' => $promoCodeTicket_id->id,
            'promo_code_ticket_id' => $request->input('ticket_id'),
          ]);
          $countUsers = UserUsedPromoCode::where('promo_code_ticket_id',$promoCodeTicket_id->promo_code_ticket_id)->count();
          if($countUsers == $promoCodeTicket_id->maximum_discount_uses){
            PromoCode::where('promo_code_ticket_id',$request['ticket_id'])->update(['status'=>'expired']);
          }
        }
        


        //  $select_id = ReferAndEarnUsed::join('refer_and_earn_used','refer_and_earn.id','=','refer_and_earn_used.refer_and_earn_id')
        //  ->select('refer_and_earn.id')
        //  ->where('refer_and_earn_used.used_for','registration')
        //  ->where('refer_and_earn.status','active')
        //  ->where('refer_and_earn_used.referral_id',Auth::guard('api')->id())
        //  ->first();
         $select = User::select('id')->where('referral_code',$request['referral_code'])->first();
         if(!empty($select)){
           if($request->checkStatusReferral == '0'){
             $user_referral_add = UserProfile::select('available_referral')->where('user_id',Auth::guard('api')->id())->first();
             $user3=UserProfile::updateOrCreate(
                 ['user_id' =>  Auth::guard('api')->id()],
                 [
                    'available_referral' => $user_referral_add->available_referral
                   
                 ]
               );
           }else{
             $user3=UserProfile::updateOrCreate(
               ['user_id' =>  Auth::guard('api')->id()],
               [
                  'available_referral' => '0',
                 
               ]
             
             );
             $user_referral_add = ReferAndEarn::select('plan_purchase_referee')->where('status','active')->first();
             $totalReferral = UserProfile::select('available_referral')->where('user_id',$select->id)->first();
             $sum = $totalReferral->available_referral+$user_referral_add->plan_purchase_referee;
             $user3=UserProfile::updateOrCreate(
                ['user_id' => $select->id],
                [
                   'available_referral' => $sum,
                  
                ]
              
              );
             ReferAndEarnUsed::create([
                'referee_id'  => $select->id,
                'referral_id'  => Auth::guard('api')->id(),
                'used_for'  => 'plan_purchase',
              ]);
            }
        }

        $response = new \Lib\PopulateResponse($user3);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('messages.sample_daily_meal');


    }
}
    // elseif($request->step=='4'){
    //     $is_weekend = SubscriptionMealPlanVariant::select('option2','plan_price')->where('meal_plan_id',$request->plan_id)->first();
    //     $user=Subscription::updateOrCreate(
    //         ['user_id' =>  Auth::guard('api')->id()],
    //         [
    //             'user_id'=> Auth::guard('api')->id(),
    //             'plan_id' => $request->plan_id,
    //             'start_date' => $request->start_date,
    //             'is_weekend' => $is_weekend->option2,
    //             'price' => $is_weekend->plan_price,
    //             'total_amount' => $request->total_amount,
    //             'delivery_status' => 'active'
               
    //         ]
           
    //     );

    // }
    $this->status = true;
    $this->message = trans('messages.buy_plan');
    return $this->populateResponse();

}



public function sample_daily_meals_with_schedule(Request $request) {
  
    $dates = $request->date;
    $custom_calorie = $request->custom_calorie;
    // $plan_id = $request->subscription_plan_id;
        $checkPlan = UserProfile::select('id','user_id','subscription_id','variant_id')->where('user_id',Auth::guard('api')->id())->first();
        $startDate= Subscription::select('start_date','end_date')->where(['plan_id'=>$checkPlan->subscription_id,'variant_id'=>$checkPlan->variant_id,'user_id'=>$checkPlan->user_id])->where('delivery_status','active')->first();
         $no_of_day = SubscriptionMealPlanVariant::select('no_days','option2')->where(['meal_plan_id'=>$checkPlan->subscription_id,'id'=>$checkPlan->variant_id])->first();
         if($no_of_day){
            if($no_of_day->option2 == 'withoutweekend'){
                   $fourtyHourDate= date('Y-m-d H:i:s',strtotime(' +2day '));
                   $date = Carbon::createFromFormat('Y-m-d',$startDate->start_date);
                    $dadte = Carbon::parse($fourtyHourDate);
                     $diff = $dadte->diffInDays($date);
                     $weekdays = 0;
                     $weekdayss = 0;
                     $f=[];
                  for ($i = 0; $i < $no_of_day->no_days; $i++) {
                       $alldate = $date->addDay()->format('y-m-d');
                    //   array_push($f,$alldate);
                       $dd = Carbon::createFromFormat('Y-m-d',$alldate);
                        $dayStr = strtolower($dd->format('l'));
                        if ($dayStr == 'friday' ) {
                           $weekdays++;
                       }
                       if ($dayStr == 'saturday' ) {
                           $weekdayss++;
                       }
                  }
                //  dd($f);

                  $leftDays = 0;
                  $leftDayss = 0;
                  $k =[];
                  for ($i = 0; $i < $diff; $i++) {
                    $getDate = $dadte->addDay()->format('y-m-d');
                    // array_push($k,$getDate);
                    $ddd = Carbon::createFromFormat('Y-m-d',$getDate);
                     $dayStrr = strtolower($ddd->format('l'));
                     if ($dayStrr == 'friday' ) {
                        $leftDays++;
                    }
                    if ($dayStrr == 'saturday' ) {
                        $leftDayss++;
                    }
                }
                // dd($k);
                 $totalDays = $weekdays+$weekdayss;
                 $totalBeforeDays = $leftDays+$leftDayss;
                  $noOfDays = $no_of_day->no_days+$diff;
                $no_dayss = $noOfDays+$totalDays;
                }else{
                   $fourtyHourDate= date('Y-m-d H:i:s',strtotime(' +2day '));
                 $date = Carbon::createFromFormat('Y-m-d',$startDate->start_date);
                 $dadte = Carbon::parse($fourtyHourDate);
                 $diff = $dadte->diffInDays($date);
                $no_dayss = $no_of_day->no_days+$diff;
                }
            //    dd($increasingdays);
         }
        $category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$checkPlan->subscription_id])
       ->get()
       ->each(function($category) use($dates,$checkPlan,$custom_calorie){
        $category->meal_group->meals =Meal::
        join('subscription_meal_plan_variant_default_meal','meals.id','subscription_meal_plan_variant_default_meal.item_id')
        ->join('meal_macro_nutrients','meals.id','=','meal_macro_nutrients.meal_id')
        ->select('meals.name','meals.name_ar','meals.side_dish','meals.side_dish_ar','meals.image','meals.id','meals.food_type','meal_macro_nutrients.meal_calorie','meal_macro_nutrients.protein','meal_macro_nutrients.carbs','meal_macro_nutrients.fat')
         ->where('subscription_meal_plan_variant_default_meal.meal_schedule_id',$category->meal_group->id)
        // ->whereDate('meals.created_at','=', date('Y-m-d', strtotime($dates)))
        ->whereDate('subscription_meal_plan_variant_default_meal.date','=', date('Y-m-d', strtotime($dates)))
        ->where(['subscription_meal_plan_variant_default_meal.meal_plan_id'=> $checkPlan->subscription_id,'meals.status'=>'active'])
         ->where('subscription_meal_plan_variant_default_meal.is_default','1')
         ->where('meal_macro_nutrients.user_calorie',$custom_calorie)
        ->get()
      
        ->each(function($meals) {
       
        $meals->dislikeItem = DislikeItem::join('meal_ingredient_list','dislike_items.id','=','meal_ingredient_list.item_id')
        ->select('dislike_items.id','dislike_items.group_id','dislike_items.name')
        ->where('meal_ingredient_list.meal_id',$meals->id)
        ->where('dislike_items.status','active')->get()
        ->each(function($dislikeItem){
           $dislikeItem->selected=false;
           if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$dislikeItem->group_id])->first()){
               $dislikeItem->selected=true;
           }
       });
    //    $meals->dislikegroup = DislikeGroup::select('id','name')->where('status','active')->get()->each(function($dislikegroup){
    //        $dislikegroup->selected=false;
    //        if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$dislikegroup->id])->first()){
    //            $dislikegroup->selected=true;
    //        }
    //    });
         $meals->rating = MealRating::select(DB::raw('avg(rating) as avg_rating'))
         ->where('meal_id', $meals->id)
         ->groupBy('meal_id')
        ->first();
        $meals->ratingcount = MealRating::where('meal_id', $meals->id)
        ->groupBy('meal_id')
       ->count(); 
 })->toArray();
})->toArray();
$calorieAddition[] = '0';
$proteinAddition[] = '0';
$carbsAddition[] ='0';
$fatAddition[] = '0';
foreach($category as $key=>$calories){
   
    // if($key==1){
    //     dd($calories['meal_group']);
    // }
    // $dd =[];
    foreach($calories['meal_group']['meals'] as $group){
      
        $calorieAddition[] = $group['meal_calorie'];
        $proteinAddition[] = $group['protein'];
        $carbsAddition[] = $group['carbs'];
        $fatAddition[] = $group['fat'];
  
    }
    $data['calorieAdditional'] = array_sum($calorieAddition);
    $data['protein'] = array_sum($proteinAddition);
    $data['carbs'] = array_sum($carbsAddition);
    $data['fat'] = array_sum($fatAddition);
    // $addCalorie = array_sum();
   
}
// dd($proteinAddition);


   $data['category'] = $category;
   $data['no_days'] = $no_dayss;
   $data['diet_plan_type_id'] = $checkPlan->diet_plan_type_id;
  $data['subscription_id'] = $checkPlan->subscription_id;
  $data['withoutOrWithweekend'] = $no_of_day->option2;
  $data['start_date'] = $startDate->start_date;

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



public function selectStartDayCircle(){
    $users=UserProfile::where('user_id',Auth::guard('api')->id())->first();
      $meal = Subscription::join('subscription_plans','subscriptions.plan_id','=','subscription_plans.id')
    ->join('subscriptions_meal_plans_variants','subscriptions.plan_id','=','subscriptions_meal_plans_variants.meal_plan_id')
   ->select('subscriptions_meal_plans_variants.no_days','subscriptions.start_date','subscriptions.plan_id','subscriptions_meal_plans_variants.id as variant_id')
   ->where(['subscriptions.user_id'=>Auth::guard('api')->id()])
   ->where(['subscriptions.variant_id'=>$users->variant_id])
   ->where(['subscriptions_meal_plans_variants.id'=>$users->variant_id])
 ->where(function($q){
    $q->where('delivery_status','paused')
    ->orWhere('delivery_status','upcoming')
    ->orWhere('delivery_status','active');
})
  
   ->first();
   if($meal){
    $dates = Carbon::createFromFormat('Y-m-d',$meal->start_date);
     $date = $dates->addDays($meal->no_days);
     $diff = now()->diffInDays(Carbon::parse($date));

       $datess = Carbon::createFromFormat('Y-m-d',$meal->start_date);
          if($datess->gt(now())){
            $dates = Carbon::createFromFormat('Y-m-d',$meal->start_date);
            $days_remaining  = 'Your plan start from'.' '.date('d-m-Y',strtotime($dates));
          }else{
            if($diff == 0){
                $days_remaining  = "Your plan is expire";
            }else{
                $days_remaining  = $diff .' days ';
            }
        
        }
 
   }
    
    $dietPlan=DietPlanType::where('id',$users->diet_plan_type_id)->first();

    $caloriRecommended = CalorieRecommend::select('id','recommended')->get();
    foreach($caloriRecommended as $calori){
       $calori->selected=false;
       if(UserCaloriTarget::where(['user_id'=>Auth::guard('api')->id(),'custom_result_id'=>$calori->id,'status'=>'ongoing'])->first()){
           $calori->selected=true;
       }
   }
   
     $checkCustomOrRecommend = UserCaloriTarget::where(['user_id'=>Auth::guard('api')->id(),'status'=>'ongoing'])->first();
    if($checkCustomOrRecommend->custom_result_id == $checkCustomOrRecommend->recommended_result_id ){
        $text = 'recommended';
    }else{
        $text = 'custom';
    }
     
 $data=['protein'=>'21','carbs'=>'34','fat'=>'28'];

    $data['caloriRecommended'] = $caloriRecommended;
    $data['diet_plan_type_id'] = $users->diet_plan_type_id;
    $data['remaining_day'] = $meal;
    $data['text'] = $text;

    /*********Calorie, protein, fat, carbs addition */
   $getUserCalorie = UserCaloriTarget::where(['user_id'=>Auth::guard('api')->id(),'status'=>'ongoing'])->first();
   if($getUserCalorie){
     $caloriRecommended = CalorieRecommend::select('id','recommended')->where('id',$getUserCalorie->custom_result_id)->first();
     $getMinMax = DietPlanTypesMealCalorieMinMax::where('diet_plan_type_id',$users->diet_plan_type_id)->where('meal_calorie',$caloriRecommended->recommended)->first();
     }
     $data['getMinMaxValue'] = $getMinMax;

   /*********end Calorie, protein, fat, carbs addition */
   $PlanDateCheck = Subscription::select('start_date')->where(['user_id' => Auth::guard('api')->id(),  'plan_id' =>  $users->subscription_id, 'variant_id' => $users->variant_id,'delivery_status'=>'active','plan_status'=>'plan_active'])->first();
       if(now() < $PlanDateCheck->start_date){
          $plan_status = 'upcoming';
        }else{
             $plan_status = 'continue';
         }

$data['plan_status'] = $plan_status;

    $response = new \Lib\PopulateResponse($data);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('plan_messages.custom_calorie');
    return $this->populateResponse();
}


public function paymentPlan_detail(Request $request) {
    $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
    if($language->lang == 'ar'){
    $plan_detail=SubscriptionPlan::join('subscriptions_meal_plans_variants','subscription_plans.id','=','subscriptions_meal_plans_variants.meal_plan_id')
    ->select('subscription_plans.id','subscription_plans.name_ar as name','subscription_plans.image','subscriptions_meal_plans_variants.plan_price','subscriptions_meal_plans_variants.option1','subscriptions_meal_plans_variants.variant_name')
    ->where('subscription_plans.id',$request->plan_id)
    ->where('subscriptions_meal_plans_variants.id',$request->variant_id)
    ->where(['subscription_plans.status'=>'active'])
    ->first();
    }else{
        $plan_detail=SubscriptionPlan::join('subscriptions_meal_plans_variants','subscription_plans.id','=','subscriptions_meal_plans_variants.meal_plan_id')
    ->select('subscription_plans.id','subscription_plans.name','subscription_plans.image','subscriptions_meal_plans_variants.plan_price','subscriptions_meal_plans_variants.option1','subscriptions_meal_plans_variants.variant_name')
    ->where('subscription_plans.id',$request->plan_id)
    ->where('subscriptions_meal_plans_variants.id',$request->variant_id)
    ->where(['subscription_plans.status'=>'active'])
    ->first();

    }
   
   
    $data['plan_detail'] = $plan_detail;
    $response = new \Lib\PopulateResponse($data);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.plan_detail');
    return $this->populateResponse();
}

public function getSwapMeal(Request $request) {
    $date = $request->date;
    $subscription_plan_id = $request->subscription_plan_id;
    $schedule_id = $request->schedule_id;
    $custom_calorie = $request->custom_calorie;

    $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
    if($language->lang == 'ar'){
     $meals =Meal::
     join('subscription_meal_plan_variant_default_meal','meals.id','subscription_meal_plan_variant_default_meal.item_id')
     ->join('meal_macro_nutrients','meals.id','=','meal_macro_nutrients.meal_id')
     ->select('meals.name_ar as name','meals.side_dish_ar as side_dish','meals.image','meals.id','meals.food_type','meal_macro_nutrients.meal_calorie','meal_macro_nutrients.protein','meal_macro_nutrients.carbs','meal_macro_nutrients.fat')
    //  ->whereDate('subscription_meal_plan_variant_default_meal.date','=', date('Y-m-d', strtotime($dates)))
     ->where(['subscription_meal_plan_variant_default_meal.meal_plan_id'=> $subscription_plan_id,'meals.status'=>'active'])
      ->where('subscription_meal_plan_variant_default_meal.date',$date)
      ->where('subscription_meal_plan_variant_default_meal.meal_schedule_id',$schedule_id)
      ->where('meal_macro_nutrients.user_calorie',$custom_calorie)
      ->distinct()
     ->get()->each(function($meals) {
       
     $meals->dislikeItem = DislikeItem::join('meal_ingredient_list','dislike_items.id','=','meal_ingredient_list.item_id')
     ->select('dislike_items.id','dislike_items.group_id','dislike_items.name_ar')
     ->where('meal_ingredient_list.meal_id',$meals->id)
     ->where('dislike_items.status','active')->get()
     ->each(function($dislikeItem){
        $dislikeItem->selected=false;
        if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$dislikeItem->group_id])->first()){
            $dislikeItem->selected=true;
        }
    });
    $meals->dislikegroup = DislikeGroup::select('id','name')->where('status','active')->get()->each(function($dislikegroup){
        $dislikegroup->selected=false;
        if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$dislikegroup->id])->first()){
            $dislikegroup->selected=true;
        }
    });
      $meals->rating = MealRating::select(DB::raw('avg(rating) as avg_rating'))
      ->where('meal_id', $meals->id)
      ->groupBy('meal_id')
     ->first();
     $meals->ratingcount = MealRating::where('meal_id', $meals->id)
     ->groupBy('meal_id')
    ->count();
})->toArray();

    }else{
        $meals =Meal::
        join('subscription_meal_plan_variant_default_meal','meals.id','subscription_meal_plan_variant_default_meal.item_id')
        ->join('meal_macro_nutrients','meals.id','=','meal_macro_nutrients.meal_id')
        ->select('meals.name','meals.side_dish','meals.image','meals.id','meals.food_type','meal_macro_nutrients.meal_calorie','meal_macro_nutrients.protein','meal_macro_nutrients.carbs','meal_macro_nutrients.fat')
       //  ->whereDate('subscription_meal_plan_variant_default_meal.date','=', date('Y-m-d', strtotime($dates)))
        ->where(['subscription_meal_plan_variant_default_meal.meal_plan_id'=> $subscription_plan_id,'meals.status'=>'active'])
         ->where('subscription_meal_plan_variant_default_meal.date',$date)
         ->where('subscription_meal_plan_variant_default_meal.meal_schedule_id',$schedule_id)
         ->where('meal_macro_nutrients.user_calorie',$custom_calorie)
         ->distinct()
        ->get()->each(function($meals) {
          
        $meals->dislikeItem = DislikeItem::join('meal_ingredient_list','dislike_items.id','=','meal_ingredient_list.item_id')
        ->select('dislike_items.id','dislike_items.group_id','dislike_items.name')
        ->where('meal_ingredient_list.meal_id',$meals->id)
        ->where('dislike_items.status','active')->get()
        ->each(function($dislikeItem){
           $dislikeItem->selected=false;
           if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$dislikeItem->group_id])->first()){
               $dislikeItem->selected=true;
           }
       });
       $meals->dislikegroup = DislikeGroup::select('id','name')->where('status','active')->get()->each(function($dislikegroup){
           $dislikegroup->selected=false;
           if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$dislikegroup->id])->first()){
               $dislikegroup->selected=true;
           }
       });
         $meals->rating = MealRating::select(DB::raw('avg(rating) as avg_rating'))
         ->where('meal_id', $meals->id)
         ->groupBy('meal_id')
        ->first();
        $meals->ratingcount = MealRating::where('meal_id', $meals->id)
        ->groupBy('meal_id')
       ->count();
   })->toArray();

    }

    $data['meals'] = $meals;
    $response = new \Lib\PopulateResponse($data);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.swap_meal_listing');
    return $this->populateResponse();
}
    

public function apply_gift_card(Request $request){
    $validate = Validator::make($request->all(), [
        'voucher_code' => 'required',
        'voucher_pin' => 'required',
       
    ], [
        'voucher_code.required' => trans('validation.required', ['attribute' => 'voucher code  ']),
        'voucher_pin.required' => trans('validation.required', ['attribute' => 'voucher pin  ']),
      
    ]);
    $validate->after(function ($validate) use ($request) {
        if ($request['voucher_code'] &&  $request['voucher_pin']) {
            $getBooking = UserGiftCard::where('voucher_code', $request['voucher_code'])->where('voucher_pin', $request['voucher_pin'])->first();
            if (!$getBooking) {
                $this->error_code = 201;
                $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                if($language->lang == 'ar'){
                $validate->errors()->add('gift card', "بطاقة الهدايا هذه غير صالحة");
                }else{
                    $validate->errors()->add('gift card', "This gift card is not valid");

                }
            }
        }

        if ($request['voucher_code'] &&  $request['voucher_pin']) {
            if($user_used = UserUsedGiftCard::where('voucher_code', $request['voucher_code'])->where('voucher_pin', $request['voucher_pin'])->exists()){
             $this->error_code = 201;
             $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
             if($language->lang == 'ar'){
             $validate->errors()->add('gift card used', "بطاقة الهدايا هذه مستخدمة بالفعل");
             }else{
                $validate->errors()->add('gift card used', "This gift card is already used");
             }
           }
        }
    });
    if ($validate->fails()) {
        $this->status_code = 201;
        $this->message = $validate->errors();
    } else {
        
         $giftCard = UserGiftCard::join('gift_cards','user_gift_cards.gift_card_id','=','gift_cards.id')
            ->select('gift_cards.id','gift_cards.discount','gift_cards.amount','gift_cards.gift_card_amount','user_gift_cards.purchase_amount')
            // ->where('user_gift_cards.user_id',Auth::guard('api')->id())
            ->where(['user_gift_cards.voucher_code'=>$request['voucher_code'],'user_gift_cards.voucher_pin'=>$request['voucher_pin']])
            ->first();
            if(!empty($giftCard->discount)){
               $giftCard->deducted_amount = ($giftCard->discount/100)*$request->meal_amount;

            }elseif(!empty($giftCard->amount)){
                $giftCard->deducted_amount = $giftCard->amount;
            }
          
        if($giftCard){
         $response = new \Lib\PopulateResponse($giftCard);
         $this->data = $response->apiResponse();
         $this->message = trans('messages.purchase_gift_card_used');
        } else {
            $this->message = trans('messages.server_error');
            $this->status_code = 202;
        }
        $this->status = true;
    }
    return $this->populateResponse();
}


public function apply_referral_code(Request $request){
    $validate = Validator::make($request->all(), [
        'referral_code' => 'required',
       
    ], [
        'referral_code.required' => trans('validation.required', ['attribute' => 'referral code']),
      
    ]);
    $validate->after(function ($validate) use ($request) {
        if ($request['referral_code']) {
            $getBooking = User::where('referral_code', $request['referral_code'])->first();
            if (!$getBooking) {
                $this->error_code = 201;
                $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                if($language->lang == 'ar'){
                $validate->errors()->add('gift card', "رمز الإحالة هذا غير صالح");
                }else{
                    $validate->errors()->add('gift card', "This referral code is not valid");
                }
            }
        }

       
    });
    if ($validate->fails()) {
        $this->status_code = 201;
        $this->message = $validate->errors();
    } else {
        if ($request['referral_code']) {
            $getReferralId = User::where('referral_code',$request['referral_code'])->whereNotIn('status',['0'])->first();
            if($checkForPlan = ReferAndEarnUsed::where(['referee_id'=>$getReferralId->id, 'referral_id'=>Auth::guard('api')->id()])->where('used_for','plan_purchase')->exists())
            {
                $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                if($language->lang == 'ar'){
                return response()->json([
                    'status' => true,
                     'error'=> 'لقد استخدمت بالفعل رمز الإحالة هذا لشراء خطة'
                   ]);
                }else{
                    return response()->json([
                        'status' => true,
                         'error'=> 'You already used this referral code for plan purchase'
                       ]);

                }
            }

        }

        if ($request['referral_code']) {
            $getReferralId = User::where('referral_code',$request['referral_code'])->whereNotIn('status',['0'])->first();
            if($getReferralId->id == Auth::guard('api')->id()){
             
               {
                $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                if($language->lang == 'ar'){
                   return response()->json([
                    'status' => true,
                     'error'=> 'استخدم كود مستخدم آخر'
                   ]);
                }else{
                    return response()->json([
                        'status' => true,
                         'error'=> 'Use other user code '
                       ]);

                }
               }
            }
        }

        if ($request['referral_code']) {
            $getReferralId = User::where('referral_code',$request['referral_code'])->whereNotIn('status',['0'])->first();
            $referralPerUser = ReferAndEarn::select('referral_per_user')->where('status','active')->first();
            $countForPlan = ReferAndEarnUsed::where(['referee_id'=>$getReferralId->id])->where('used_for','plan_purchase')->count();
            if($countForPlan == $referralPerUser->referral_per_user){
            {
                $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                if($language->lang == 'ar'){
                return response()->json([
                    'status' => true,
                     'error'=> 'هذا الرمز منتهي الصلاحية'
                   ]);
                }else{
                    return response()->json([
                        'status' => true,
                         'error'=> 'This code is expire'
                       ]);

                }
           }
         }
        }
      
        $getReferral = ReferAndEarn::select('id','plan_purchase_referral')->first();
            if(!empty($getReferral->plan_purchase_referral)){
               $getReferral->gain_referral = $getReferral->plan_purchase_referral;

            }
          
        if($getReferral){
         $response = new \Lib\PopulateResponse($getReferral);
         $this->data = $response->apiResponse();
         $this->message = trans('messages.purchase_gift_card_used');
        } else {
            $this->message = trans('messages.server_error');
            $this->status_code = 202;
        }
        $this->status = true;
    
}
    return $this->populateResponse();
}

public function apply_promo_code(Request $request){
    $validate = Validator::make($request->all(), [
        'ticket_id' => 'required',

    ], [
        'ticket_id.required' => trans('validation.required', ['attribute' => 'ticket_id  ']),
      
    ]);
    $validate->after(function ($validate) use ($request) {
        if ($request['ticket_id'] ) {
            $getBooking = PromoCode::where('promo_code_ticket_id', $request['ticket_id'])->first();
            if (!$getBooking) {
                $this->error_code = 201;
                $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                if($language->lang == 'ar'){
                $validate->errors()->add('promo code', "هذا الرمز الترويجي غير صالح");
                }else{
                    $validate->errors()->add('promo code', "This promo code is not valid");
                }
            }
        }

    
    });
    if ($validate->fails()) {
        $this->status_code = 201;
        $this->message = $validate->errors();
    } else {
        if ($request['ticket_id'] ) {
            $count_used = PromoCode::where('promo_code_ticket_id', $request['ticket_id'])->first();
            if ($count_used->limit_to_one_use == '1' ) {
                if($count_used->maximum_discount_uses == null){
                    $countUser = UserUsedPromoCode::where('user_id',Auth::guard('api')->id())->where('promo_code_ticket_id',$count_used->promo_code_ticket_id)->first();
                    if ($countUser) {
                        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                        if($language->lang == 'ar'){
                        return response()->json([
                            'status' => true,
                            'error_code' => 201,
                             'error'=> 'هذا الرمز مستخدم بالفعل'
                           ]);
                        }else{
                            return response()->json([
                                'status' => true,
                                'error_code' => 201,
                                 'error'=> 'This Code  is already used'
                               ]);

                        }
                    }
                }else{
                    $countUsers = UserUsedPromoCode::where('user_id',Auth::guard('api')->id())->where('promo_code_ticket_id',$count_used->promo_code_ticket_id)->count();
                    if($countUsers == $count_used->maximum_discount_uses){
                        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                        if($language->lang == 'ar'){
                        return response()->json([
                            'status' => true,
                            'error_code' => 201,
                             'error'=> 'لقد استخدمت الحد الأقصى الخاص بك'
                           ]);
                        }else{
                            return response()->json([
                                'status' => true,
                                'error_code' => 201,
                                 'error'=> 'You used your max limit'
                               ]);

                        }
                    }
                }
           }else{
             $countTicket = UserUsedPromoCode::where('promo_code_ticket_id',$count_used->promo_code_ticket_id)->count();
             if($countTicket == $count_used->maximum_discount_uses){
                $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                if($language->lang == 'ar'){
                 return response()->json([
                    'status' => true,
                    'error_code' => 201,
                     'error'=> 'هذا الرمز منتهي الصلاحية'
                   ]);
                }else{
                    return response()->json([
                        'status' => true,
                        'error_code' => 201,
                         'error'=> 'This code is expired '
                       ]);

                }
              }
            }

           $promoCodeTicket_id = PromoCode::where('promo_code_ticket_id', $request['ticket_id'])->first();
          
        //   $insert=[
        //     'user_id' => Auth::guard('api')->id(),
        //     'promocode_id' => $promoCodeTicket_id->id,
        //     'promo_code_ticket_id' => $request->input('ticket_id'),

        //   ];
        //   $promo = UserUsedPromoCode::create($insert);
          if(!empty($promoCodeTicket_id->discount)){
             $amount_discount = ($promoCodeTicket_id->discount/100)*$request->total_amount;
            }else{
             $amount_discount = $promoCodeTicket_id->price;
            }
            if($amount_discount > $request->total_amount){
                $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                if($language->lang == 'ar'){
                return response()->json([
                    'status'=>true,
                    'error_code' => 201,
                    'error' => 'المبلغ أكبر من حزمة الوجبة'
                ]);
            }else{
                return response()->json([
                    'status'=>true,
                    'error_code' => 201,
                    'error' => 'Amount is greater than meal package'
                ]);

            }
            }else{
                $promoCodeTicket_id->amount_discount = $amount_discount;
            }
        if($promoCodeTicket_id){
         $response = new \Lib\PopulateResponse($promoCodeTicket_id);
         $this->data = $response->apiResponse();
         $this->message = trans('messages.promo_code_used');
        } else {
            $this->message = trans('messages.server_error');
            $this->status_code = 202;
        }
        $this->status = true;
    }
}
    return $this->populateResponse();
} 


public function getArea(Request $request) {
    $getArea=[];
    $area = FleetArea::select('area')->where('status','active')->get();
    // $dataa = json_decode($area, true);
    foreach($area as $i => $v)
    {
        // echo $v['area'].'<br/>';
        array_push($getArea,json_decode($v->area, true));
      
    }
    $data = $getArea;

    $response = new \Lib\PopulateResponse($data);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.city_list');
    return $this->populateResponse();
}

public function myMeals(Request $request) {
    $dates = $request->date;
    $datess = Carbon::createFromFormat('Y-m-d',$dates);
       $day = strtolower($datess->format('l'));
     $getAllDays = UserAddress::where('user_id',Auth::guard('api')->id())->where('day_selection_status','active')->get();
     if($day == 'monday'){
         $var = "1";
     }elseif($day == 'tuesday'){
         $var = '2';
     }elseif($day == 'wednesday'){
        $var = '3';
    }elseif($day == 'thursday'){
        $var = '4';
    }elseif($day == 'friday'){
        $var = '5';
    }elseif($day == 'saturday'){
        $var = '6';
    }else{
        $var = '7';
    }

    $custom_calorie = $request->custom_calorie;
     $checkPlan = UserProfile::select('id','subscription_id','diet_plan_type_id','variant_id')->where('user_id',Auth::guard('api')->id())->first();
  
     $start_date = Subscription::select('start_date','end_date','delivery_status','no_of_days_pause_plan')->where(['plan_id'=>$checkPlan->subscription_id,'variant_id'=>$checkPlan->variant_id])->where('delivery_status','!=','terminted')->where('plan_status','!=','plan_inactive')->where('user_id',Auth::guard('api')->id())->first();
     $option22 = SubscriptionMealPlanVariant::select('no_days','option2')->where(['meal_plan_id'=>$checkPlan->subscription_id,'id'=>$checkPlan->variant_id])->first();
    $getStartDate = Carbon::createFromFormat('Y-m-d',$start_date->start_date);
   $getEndDate = Carbon::createFromFormat('Y-m-d',$start_date->end_date);
      $no_of_day = $getStartDate->diffInDays($getEndDate); 
     if(!empty($no_of_day))
     {

         $countSkip = UserSkipDelivery::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$checkPlan->subscription_id,'variant_id'=>$checkPlan->variant_id])->count();
          $swapno_of_days =  $countSkip;
     }
    if($option22->option2 == 'withoutweekend'){
            //   $date = Carbon::createFromFormat('Y-m-d',$start_date->start_date);
              $date = Carbon::now();
            $weekdays = 0;
            $weekdayss = 0;
            $f=[];
              for ($i = 0; $i < $option22->no_days; $i++) {
                   $alldate = $date->addDay()->format('y-m-d');
                 
                   $dd = Carbon::createFromFormat('Y-m-d',$alldate);
                //    array_push($f,$dd);
                    $dayStr = strtolower($dd->format('l'));
                    if ($dayStr == 'friday' ) {
                       $weekdays++;
                   }
                   if ($dayStr == 'saturday' ) {
                       $weekdayss++;
                   }
              }
            //   dd($f);
            //   die;
             $totalDays = $weekdays+$weekdayss;
             $no_of_days = $option22->no_days+$totalDays+$swapno_of_days+$start_date->no_of_days_pause_plan;
            }else{
            $no_of_days = $option22->no_days+$swapno_of_days+$start_date->no_of_days_pause_plan;
       }

    if(UserChangeDeliveryLocation::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$checkPlan->subscription_id,'variant_id'=>$checkPlan->variant_id])->where('change_location_for_date',$dates)->exists()){
        $deliverie = userAddress::join('user_change_delivery_location','user_address.id','=','user_change_delivery_location.user_address_id')
        // ->join('delivery_slots','user_address.delivery_slot_id','=','delivery_slots.id')
        ->select('user_address.address_type','user_address.id')
        ->where('user_change_delivery_location.user_id',Auth::guard('api')->id())
         ->where('user_change_delivery_location.change_location_for_date',$dates)
         ->where('user_change_delivery_location.subscription_plan_id',$checkPlan->subscription_id)
         ->where('user_change_delivery_location.variant_id',$checkPlan->variant_id)
        ->first();

        if(UserSkipTimeSlot::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$checkPlan->subscription_id,'variant_id'=>$checkPlan->variant_id])->where('skip_date',$dates)->exists()){

            $deliveries_slot = UserSkipTimeSlot::join('delivery_slots','user_skip_time_slot.delivery_slot_id','=','delivery_slots.id')
           ->join('user_address','user_skip_time_slot.user_address_id','=','user_address.id')
           ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.id','delivery_slots.name','delivery_slots.id as slot_id')
           ->where('user_skip_time_slot.skip_date',$dates)
            ->where('user_skip_time_slot.user_id',Auth::guard('api')->id())
            ->where('user_skip_time_slot.subscription_plan_id',$checkPlan->subscription_id)
            ->where('user_skip_time_slot.variant_id',$checkPlan->variant_id)
           ->first();
           $deliverie->start_time = $deliveries_slot->start_time;
           $deliverie->end_time = $deliveries_slot->end_time;
           $deliverie->name = $deliveries_slot->name;
           $deliverie->slot_id = $deliveries_slot->slot_id;
        
       }else{
        $deliverieSlot = userAddress::join('user_change_delivery_location','user_address.id','=','user_change_delivery_location.user_address_id')
        ->join('delivery_slots','user_address.delivery_slot_id','=','delivery_slots.id')
        ->select('delivery_slots.start_time','delivery_slots.end_time','delivery_slots.name','delivery_slots.id as slot_id')
        ->where('user_change_delivery_location.user_id',Auth::guard('api')->id())
         ->where('user_change_delivery_location.change_location_for_date',$dates)
         ->where('user_change_delivery_location.subscription_plan_id',$checkPlan->subscription_id)
         ->where('user_change_delivery_location.variant_id',$checkPlan->variant_id)
        ->first();
     
       $deliverie->start_time = $deliverieSlot->start_time;
       $deliverie->end_time = $deliverieSlot->end_time;
       $deliverie->name = $deliverieSlot->name;
       $deliverie->slot_id = $deliverieSlot->slot_id;
    }

       $data['deliveries'] = $deliverie;

    }else{
        if(UserSkipTimeSlot::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$checkPlan->subscription_id,'variant_id'=>$checkPlan->variant_id])->where('skip_date',$dates)->exists()){
    
             $deliverie = UserSkipTimeSlot::join('delivery_slots','user_skip_time_slot.delivery_slot_id','=','delivery_slots.id')
            // ->join('user_address','user_skip_time_slot.user_address_id','=','user_address.id')
            ->select('delivery_slots.start_time','delivery_slots.end_time','delivery_slots.name','delivery_slots.id as slot_id')
            ->where('user_skip_time_slot.skip_date',$dates)
             ->where('user_skip_time_slot.user_id',Auth::guard('api')->id())
             ->where('user_skip_time_slot.subscription_plan_id',$checkPlan->subscription_id)
             ->where('user_skip_time_slot.variant_id',$checkPlan->variant_id)
            ->first();
                $deliveries = userAddress::
                select('user_address.id','user_address.address_type')
                ->where('user_id',Auth::guard('api')->id())
                ->where('day_selection_status','active')
                ->when($var == "1", function ($q) {
                    $q->where('monday',"1");
                 })
                 ->when($var == "2", function ($q) {
                     $q->where('tuesday',"1");
                 })
                 ->when($var == "3", function ($q) {
                     $q->where('wednesday',"1");
                 })
                 ->when($var == "4", function ($q) {
                     $q->where('thursday',"1");
                 })
                 ->when($var == "5", function ($q) {
                     $q->where('friday',"1");
                 })
                 ->when($var == "6", function ($q) {
                     $q->where('saturday',"1");
                 })
                 ->when($var == "7", function ($q) {
                     $q->where('sunday',"1");
                 })
                ->first();

                $deliverie->address_type = $deliveries->address_type;
                $deliverie->id = $deliveries->id;

            $data['deliveries'] = $deliverie;
          
        }else{
            $data['deliveries'] = DeliverySlot::join('user_address','delivery_slots.id','=','user_address.delivery_slot_id')
        ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.id','delivery_slots.name','delivery_slots.id as slot_id','user_address.address_type')
        ->where('user_id',Auth::guard('api')->id())
        ->where('day_selection_status','active')
        ->when($var == "1", function ($q) {
           $q->where('monday',"1");
        })
        ->when($var == "2", function ($q) {
            $q->where('tuesday',"1");
        })
        ->when($var == "3", function ($q) {
            $q->where('wednesday',"1");
        })
        ->when($var == "4", function ($q) {
            $q->where('thursday',"1");
        })
        ->when($var == "5", function ($q) {
            $q->where('friday',"1");
        })
        ->when($var == "6", function ($q) {
            $q->where('saturday',"1");
        })
        ->when($var == "7", function ($q) {
            $q->where('sunday',"1");
        })
        ->first();
      }
  }
      if(UserSkipDelivery::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$checkPlan->subscription_id,'variant_id'=>$checkPlan->variant_id])->where('skip_delivery_date',$dates)->exists())
      {
        $category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$checkPlan->subscription_id])
        ->get()
        ->each(function($category){
            $category->meal_group->meals = ["you skip your delivery for this date"];
            
        })->toArray();
        $data['category'] = $category;
        $data['skip_status'] = "you skip your delivery for this date";
       }else{
        $category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$checkPlan->subscription_id])
       ->get()
       ->each(function($category) use($dates,$checkPlan,$custom_calorie){
    
       if(UserSwapMeal::where(['user_id'=>Auth::guard('api')->id(),'meal_schedule_id'=>$category->meal_group->id,'date'=>date('Y-m-d', strtotime($dates))])->exists()){

        $category->meal_group->meals =Meal::
        join('user_swap_meal','meals.id','user_swap_meal.meal_id')
        ->join('meal_macro_nutrients','meals.id','=','meal_macro_nutrients.meal_id')
        // ->select('meals.*')
        ->select('meals.name','meals.name_ar','meals.side_dish','meals.side_dish_ar','meals.image','meals.id','meals.food_type','meal_macro_nutrients.meal_calorie','meal_macro_nutrients.protein','meal_macro_nutrients.carbs','meal_macro_nutrients.fat')
         ->where('user_swap_meal.meal_schedule_id',$category->meal_group->id)
        // ->whereDate('meals.created_at','=', date('Y-m-d', strtotime($dates)))
        ->whereDate('user_swap_meal.date','=', date('Y-m-d', strtotime($dates)))
        ->where(['user_swap_meal.meal_plan_id'=> $checkPlan->subscription_id,'meals.status'=>'active'])
         ->where('user_swap_meal.is_default','1')
         ->where('meal_macro_nutrients.user_calorie',$custom_calorie)
        ->get()->each(function($meals) {
        
            // $meals->ingredient= ['onion','tomato','carrot', 'chilli'];
    
        $meals->dislikeItem = DislikeItem::join('meal_ingredient_list','dislike_items.id','=','meal_ingredient_list.item_id')
        ->select('dislike_items.id','dislike_items.group_id','dislike_items.name')
        ->where('meal_ingredient_list.meal_id',$meals->id)
        ->where('dislike_items.status','active')
        ->get()
        ->each(function($dislikeItem){
           $dislikeItem->selected=false;
           if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$dislikeItem->group_id])->first()){
               $dislikeItem->selected=true;
           }
       });

         $meals->rating = MealRating::select(DB::raw('avg(rating) as avg_rating'))
         ->where('meal_id', $meals->id)
         ->groupBy('meal_id')
        ->first();
        $meals->ratingcount = MealRating::where('meal_id', $meals->id)
        ->groupBy('meal_id')
       ->count();
 })->toArray();
 

       }else{
        $category->meal_group->meals =Meal::
        join('subscription_meal_plan_variant_default_meal','meals.id','subscription_meal_plan_variant_default_meal.item_id')
        ->join('meal_macro_nutrients','meals.id','=','meal_macro_nutrients.meal_id')
        // ->select('meals.*')
        ->select('meals.name','meals.name_ar','meals.side_dish','meals.side_dish_ar','meals.image','meals.id','meals.food_type','meal_macro_nutrients.meal_calorie','meal_macro_nutrients.protein','meal_macro_nutrients.carbs','meal_macro_nutrients.fat')
         ->where('subscription_meal_plan_variant_default_meal.meal_schedule_id',$category->meal_group->id)
        // ->whereDate('meals.created_at','=', date('Y-m-d', strtotime($dates)))
        ->whereDate('subscription_meal_plan_variant_default_meal.date','=', date('Y-m-d', strtotime($dates)))
        ->where(['subscription_meal_plan_variant_default_meal.meal_plan_id'=> $checkPlan->subscription_id,'meals.status'=>'active'])
         ->where('subscription_meal_plan_variant_default_meal.is_default','1')
         ->where('meal_macro_nutrients.user_calorie',$custom_calorie)
        ->get()->each(function($meals) {
        
            // $meals->ingredient= ['onion','tomato','carrot', 'chilli'];
    
        $meals->dislikeItem = DislikeItem::join('meal_ingredient_list','dislike_items.id','=','meal_ingredient_list.item_id')
        ->select('dislike_items.id','dislike_items.group_id','dislike_items.name')
        ->where('meal_ingredient_list.meal_id',$meals->id)
        ->where('dislike_items.status','active')->get()
        ->each(function($dislikeItem){
           $dislikeItem->selected=false;
           if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$dislikeItem->group_id])->first()){
               $dislikeItem->selected=true;
           }
       });
    //    $meals->dislikegroup = DislikeGroup::select('id','name')->where('status','active')->get()->each(function($dislikegroup){
    //        $dislikegroup->selected=false;
    //        if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$dislikegroup->id])->first()){
    //            $dislikegroup->selected=true;
    //        }
    //    });
         $meals->rating = MealRating::select(DB::raw('avg(rating) as avg_rating'))
         ->where('meal_id', $meals->id)
         ->groupBy('meal_id')
        ->first();
        $meals->ratingcount = MealRating::where('meal_id', $meals->id)
        ->groupBy('meal_id')
       ->count();
 })->toArray();
}
})->toArray();
   
$calorieAddition[] ='0';
$proteinAddition[] ='0';
$carbsAddition[] ='0';
$fatAddition[] ='0';
foreach($category as $key=>$calories){
   
    // if($key==1){
    //     dd($calories['meal_group']);
    // }
    // $dd =[];
    foreach($calories['meal_group']['meals'] as $group){
      
        $calorieAddition[] = $group['meal_calorie'];
        $proteinAddition[] = $group['protein'];
        $carbsAddition[] = $group['carbs'];
        $fatAddition[] = $group['fat'];
  
    }
    $data['calorieAdditional'] = array_sum($calorieAddition);
    $data['protein'] = array_sum($proteinAddition);
    $data['carbs'] = array_sum($carbsAddition);
    $data['fat'] = array_sum($fatAddition);
    // $addCalorie = array_sum();
   
}
// dd($proteinAddition);
$data['skip_status'] = "";
$data['category'] = $category;
  }
  
   $data['diet_plan_type_id'] = $checkPlan->diet_plan_type_id;
   $data['subscription_id'] = $checkPlan->subscription_id;
   $data['start_date'] = $start_date;
   $data['no_of_days'] = $no_of_days;
   $data['withoutOrWithweekend'] = $option22->option2;
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


public function changeDeliveryTime(Request $request){
    
    $fourtyHourDate= date('Y-m-d',strtotime(' +2day '));
    if($fourtyHourDate >= $request->skip_date){ 
        return response()->json([
            'status' => true,
             'error'=> 'You can not skip delivery before  48 hours '
           ]);
    }else{
    $insert=UserSkipTimeSlot::updateOrCreate(
        ['user_id' =>  Auth::guard('api')->id(),
        'skip_date' => $request->skip_date,],
        [
            'user_id' => Auth::guard('api')->id(),
            'delivery_slot_id' => $request->delivery_slot_id,
            'user_address_id' => $request->user_address_id,
            'subscription_plan_id' => $request->subscription_plan_id,
            'variant_id' => $request->variant_id,
            'skip_date' => $request->skip_date,
        ]
    );
  }
    
    $this->status = true; 
    $this->message = trans('messages.time_slot_change');
    return $this->populateResponse();
}

public function userSkipDelivery(Request $request){
     $current_time = date('H:i:s');
    $fourtyHourDate= date('Y-m-d H:i:s',strtotime(' +2day '));
    if(UserSkipDelivery::where(['user_id'=> Auth::guard('api')->id(),'user_address_id' => $request->user_address_id,  'subscription_plan_id' => $request->subscription_plan_id,'variant_id' => $request->variant_id,  'skip_delivery_date' => $request->skip_delivery_date])->exists()){
        return response()->json([
            'status' => true,
             'error'=> 'You already skip delivery for this date'
        ]);
    }else{
      if($fourtyHourDate <= $request->skip_delivery_date.' '. $current_time){   
      $insert=[];
        $insert=[
            'user_id' => Auth::guard('api')->id(),
            'user_address_id' => $request->user_address_id,
            'subscription_plan_id' => $request->subscription_plan_id,
            'variant_id' => $request->variant_id,
            'skip_delivery_date' => $request->skip_delivery_date,

        ];   
    
    if($insert){
         $user=UserSkipDelivery::create($insert);
         
    }   
  }else{
    $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
    if($language->lang == 'ar'){
    return response()->json([
        'status' => true,
         'error'=> 'لا يمكنك تخطي التسليم لهذا التاريخ'
       ]);
    }else{
        return response()->json([
            'status' => true,
             'error'=> 'You can not skip delivery for this date'
           ]);

    }
   }
     
   $response = new \Lib\PopulateResponse($user);
    $this->status = true; 
    $this->data = $response->apiResponse();
    $this->message = trans('messages.skip_delivery');
}
    return $this->populateResponse();
}

public function userUnskipDelivery(Request $request){
    $current_time = date('H:i:s');
    $fourtyHourDate= date('Y-m-d H:i:s',strtotime(' +2day '));
   if($fourtyHourDate <= $request->skip_delivery_date.' '. $current_time){   
      $unSkip =  UserSkipDelivery::where(['user_id'=> Auth::guard('api')->id(),'user_address_id' => $request->user_address_id,  'subscription_plan_id' => $request->subscription_plan_id, 'variant_id' => $request->variant_id,'skip_delivery_date' => $request->skip_delivery_date,])->delete();   
}else{
    $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
    if($language->lang == 'ar'){
 return response()->json([
     'status' => true,
      'error'=> 'لا يمكنك Unskip التسليم لهذا التاريخ'
    ]);
}else{
    return response()->json([
        'status' => true,
         'error'=> 'You can not Unskip delivery for this date'
       ]);

}
}
 
 $this->status = true; 
 $this->message = trans('messages.unskip_delivery');
 return $this->populateResponse();
}

public function userChangeDeliveryLocation(Request $request){
    $fourtyHourDate= date('Y-m-d',strtotime(' +2day '));
    if($fourtyHourDate >= $request->change_location_for_date){ 
        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
        if($language->lang == 'ar'){
        return response()->json([
            'status' => true,
            'error_code' => 201,
             'error'=> 'لا يمكنك تخطي العنوان قبل 48 ساعة '
           ]);
        }else{
            return response()->json([
                'status' => true,
                'error_code' => 201,
                 'error'=> 'You can not skip address before  48 hours '
               ]);

        }
    }else{
    $insert=UserChangeDeliveryLocation::updateOrCreate(
        ['user_id' =>  Auth::guard('api')->id(),
        'change_location_for_date' => $request->change_location_for_date,],
        [
            'user_id' => Auth::guard('api')->id(),
            'user_address_id' => $request->user_address_id,
            'subscription_plan_id' => $request->subscription_plan_id,
            'variant_id' => $request->variant_id,
            'change_location_for_date' => $request->change_location_for_date,
        ]
    );
}
    
    $this->status = true; 
    $this->message = trans('messages.change_location');
    return $this->populateResponse();
}

public function switchPlan(Request $request){

     $getOldWeekend = SubscriptionMealPlanVariant::select('no_days','plan_price','option2','option1')->where(['meal_plan_id'=>$request->subscription_plan_id,'id'=>$request->variant_id])->first();
     $getNewWeekend = SubscriptionMealPlanVariant::select('no_days','plan_price','option2','option1')->where(['meal_plan_id'=>$request->new_subscription_plan_id,'id'=>$request->new_variant_id])->first();
  if($getOldWeekend->option1 == 'monthly'  && $getNewWeekend->option1 == 'weekly')
  {
    $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
    if($language->lang == 'ar'){
    return response()->json([
        'status' => true,
        'error'  => "لا يمكنك تبديل الخطة من الشهرية إلى الأسبوعية",
    
      ]);
    }else{
        return response()->json([
            'status' => true,
            'error'  => "You can not  switch plan from monthly to weekly",
        
          ]);

    }

  }
  else{
    // Subscription::where('user_id',Auth::guard('api')->id())->where(['delivery_status'=>'upcoming'])->update(['delivery_status'=>'terminted','plan_status'=>'plan_inactive']);
    $getWeekend = SubscriptionMealPlanVariant::select('no_days','plan_price','option2')->where(['meal_plan_id'=>$request->new_subscription_plan_id,'id'=>$request->new_variant_id])->first();
    $oldDate = Subscription::select('start_date')->where(['user_id'=>Auth::guard('api')->id(),'plan_id'=>$request->subscription_plan_id,'variant_id' => $request->variant_id])->first();
   if(now()>$oldDate->start_date){
    $fourtyHourDate= date('Y-m-d',strtotime(' +2day '));
 }else{
    $fourtyHourDate= $oldDate->start_date;
 }
      $getStartDate = Subscription::where('user_id',Auth::guard('api')->id())->where(['plan_id'=>$request->subscription_plan_id,'variant_id' => $request->variant_id])->where(['delivery_status'=>'active'])->first();
    $data =Subscription::updateOrCreate(
        ['user_id' =>  Auth::guard('api')->id(),
        'plan_id' => $request->subscription_plan_id,
        'variant_id' => $request->variant_id,
         ],
        [
            'plan_id'=> $request->subscription_plan_id,
            'variant_id' => $request->variant_id,
            'switch_plan_start_date'=> $fourtyHourDate,
            'switch_plan_plan_id'=> $request->new_subscription_plan_id,
            'switch_plan_variant_id'=> $request->new_variant_id,
            'start_date'=> $getStartDate->start_date,
            'is_weekend'=> $getWeekend->option2,
            'price'=> $getWeekend->plan_price,
            'delivery_status'=> 'active',
            'plan_status'=> 'plan_active',

        ]
    );
    // Subscription::where('user_id',Auth::guard('api')->id())->where(['plan_id'=>$request->subscription_plan_id,'variant_id' => $request->variant_id])->update(['delivery_status'=>'terminted']);
    
    if(!empty($request->subscription_plan_id)){
        $getAvailableCredit = UserProfile::select('available_credit')->where('user_id',Auth::guard('api')->id())->first();
       if($getAvailableCredit){
                $newPlanPrice = SubscriptionMealPlanVariant::select('no_days','plan_price')->where(['meal_plan_id'=>$request->new_subscription_plan_id, 'id' => $request->new_variant_id,])->first();
                  $oldNumberOfDays = SubscriptionMealPlanVariant::select('no_days','plan_price')->where(['meal_plan_id'=>$request->subscription_plan_id,'id'=>$request->variant_id])->first();
                   $perDayRequiredCredit = $newPlanPrice->plan_price/$newPlanPrice->no_days;
                    $perDayRequiredCreditForOldPlan = $oldNumberOfDays->plan_price/$oldNumberOfDays->no_days;
              if($perDayRequiredCreditForOldPlan <= $perDayRequiredCredit){ 
               $oldDate = Subscription::select('start_date')->where(['user_id'=>Auth::guard('api')->id(),'plan_id'=>$request->subscription_plan_id,'variant_id' => $request->variant_id])->first();
               if(now()>$oldDate->start_date){
                $fourtyHourDate= date('Y-m-d',strtotime(' +2day '));
             }else{
                $fourtyHourDate= $oldDate->start_date;
             }
                   $used_plan = carbon::parse($oldDate->start_date)->diffInDays($fourtyHourDate);

                   $remainingDayFromOldPlan =  $oldNumberOfDays->no_days-$used_plan;

                    $totalRequiredAmountForRemainingOldDay = $perDayRequiredCreditForOldPlan*$remainingDayFromOldPlan;
                     $totalRequiredAmountForRemainingDayNewPlan = $perDayRequiredCredit*$remainingDayFromOldPlan;
                   $UserPay = $totalRequiredAmountForRemainingDayNewPlan-$totalRequiredAmountForRemainingOldDay;
                  if($UserPay > 0){
                   $data['pay'] = $UserPay;
                  }else{
                    $data['pay'] = '';
                  }
              }else{
                   $data['pay'] = '';
              }
              
       }
     }
    /*****************Its done through chrome*********** */
    // if($data){
    //     UserProfile::updateOrCreate(
    //         ['user_id' =>  Auth::guard('api')->id(),
    //         // 'subscription_id' => $request->subscription_plan_id,
    //         ],
    //         [
    //             'diet_plan_type_id'=> $request->diet_plan_type_id,
    //             'subscription_id'=> $request->subscription_plan_id,
    //             'variant_id' => $request->variant_id,

    //         ]
    //     );     
    // }
     /*****************Its done through chrome*********** */
}
if($data){
    $response = new \Lib\PopulateResponse($data);
    $this->data = $response->apiResponse();
    $this->message = trans('messages.switch_plan');
    }else {
        $this->message = trans('messages.server_error');
        $this->status_code = 202;
    }
    $this->status = true;
    return $this->populateResponse();
}

public function swapMeal(Request $request){
    $date = $request->date;
    $old_meal_id = $request->old_meal_id;
    $new_meal_id = $request->new_meal_id;
    $plan_id = $request->subscription_plan_id;
    $meal_schedule_id = $request->meal_schedule_id;

    // $update = UserSwapMeal::where(['meal_plan_id'=>$plan_id,'date'=>$date,'meal_schedule_id'=>$meal_schedule_id])->delete();

 $getAllMeal = SubscriptionMealVariantDefaultMeal::where('date',date('Y-m-d',strtotime($date)))->where(['meal_plan_id'=>$plan_id,'meal_schedule_id'=>$meal_schedule_id,'is_default'=>'1'])->get();
 foreach($getAllMeal as $key=>$getAllMeals){
    UserSwapMeal::updateOrCreate(
        ['user_id' =>  Auth::guard('api')->id(),
        'meal_plan_id'=>$getAllMeals->meal_plan_id,
        'meal_id'=>$getAllMeals->item_id,
        'date'=>$getAllMeals->date,
        'meal_schedule_id'=>$getAllMeals->meal_schedule_id,
         ],

            [
                'user_id'=>Auth::guard('api')->id(),
                'meal_plan_id'=>$getAllMeals->meal_plan_id,
                'date'=>$getAllMeals->date,
                'meal_id'=>$getAllMeals->item_id,
                'meal_schedule_id'=>$getAllMeals->meal_schedule_id,
                'old_meal_id'=>$getAllMeals->item_id,
        
                ]
    );
}

    // $updateOldMealDefault=[
    //     'is_default' => '1'
    // ];
    // $update = UserSwapMeal::where(['meal_plan_id'=>$plan_id,'date'=>$date,'meal_id'=>$old_meal_id,'meal_schedule_id'=>$meal_schedule_id])->update($updateOldMealDefault);
    $updateOldMealDefault=[
        'is_default' => '0'
    ];
    $update = UserSwapMeal::where(['meal_plan_id'=>$plan_id,'date'=>$date,'meal_id'=>$old_meal_id,'meal_schedule_id'=>$meal_schedule_id])->update($updateOldMealDefault);
    UserSwapMeal::updateOrCreate(
        ['user_id' =>  Auth::guard('api')->id(),
        'meal_plan_id'=>$plan_id,
        'meal_id'=>$new_meal_id,
        'date'=>$date,
        'meal_schedule_id'=>$meal_schedule_id,
         ],

            [
                'user_id'=>Auth::guard('api')->id(),
                'meal_plan_id'=>$plan_id,
                'date'=>$date,
                'meal_id'=>$new_meal_id,
                'meal_schedule_id'=>$meal_schedule_id,
                'old_meal_id'=>$old_meal_id,
                'is_default' => '1'
                ]
    );

    $this->status = true; 
    $this->message = trans('messages.swap_meal');
    return $this->populateResponse();
}


public function savedAddressListing(Request $request) {
   
        $savedAddress = UserAddress::select('*')->where('user_id',Auth::guard('api')->id())->where('status','active')->get();

        $response = new \Lib\PopulateResponse($savedAddress);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('messages.city_list');
        return $this->populateResponse();
    }


    public function pause_meal_plan(Request $request) {
          $now = date('Y-m-d');
           $fourtyHourDate= $request->pause_date;
           $getDiff = carbon::parse($now)->diffIndays($fourtyHourDate);
        $data =Subscription::updateOrCreate(
            ['user_id' =>  Auth::guard('api')->id(),
            'plan_id' => $request->subscription_plan_id,
            'variant_id' => $request->variant_id,
             ],
            [
                // 'plan_id'=> $request->plan_id,
                'pause_date'=>  $request->pause_date,
                // 'is_weekend'=> $request->is_weekend,
                'delivery_status'=> 'paused',
    
            ]
        );

        if($data){
             $pause_date = Carbon::createFromFormat('Y-m-d',$request->pause_date);
          $diff = $pause_date->diffInDays(Carbon::parse($data->start_date));
            Subscription::updateOrCreate(
                ['user_id' =>  Auth::guard('api')->id(),
                'plan_id' => $request->subscription_plan_id,
                'variant_id' => $request->variant_id,
                 ],
                [
                    'no_of_days_resume_plan'=>  $diff,

        
                ]
            );
        }
        if($data){
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->message = trans('messages.plan_pause');
        }else {
            $this->message = trans('messages.server_error');
            $this->status_code = 202;
        }
        $this->status = true;
        return $this->populateResponse();
    }


    public function viewPreviousPlan(Request $request){
        // $request->diet_plan_type_id;
        // $request->plan_type;
        // $request->is_weekend;
        $request->subscription_plan_id; // this id get from my plan when user click on perticular plan then get ths detail
        $request->variant_id; // this id get from my plan when user click on perticular plan then get ths detail
        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
        if($language->lang == 'ar'){   
        $dietPlan = UserProfile::join('diet_plan_types','user_profile.diet_plan_type_id','=','diet_plan_types.id')
        ->where('user_profile.user_id',Auth::guard('api')->id())
        ->select('diet_plan_types.name_ar as name')
        ->first();
        }else{
            $dietPlan = UserProfile::join('diet_plan_types','user_profile.diet_plan_type_id','=','diet_plan_types.id')
        ->where('user_profile.user_id',Auth::guard('api')->id())
        ->select('diet_plan_types.name')
        ->first();

        }

         $subscriptions=SubscriptionPlan::select('id')->where(['id'=> $request->subscription_plan_id])->first();
        if(Subscription::where(['delivery_status'=>'terminted','plan_id'=>$request->subscription_plan_id,'variant_id'=>$request->variant_id])->where('user_id',Auth::guard('api')->id())->first()){

        if($language->lang == 'ar'){    
         $subscription=Subscription::join('subscription_plans','subscriptions.plan_id','=','subscription_plans.id')
         ->join('subscriptions_meal_plans_variants','subscriptions.plan_id','=','subscriptions_meal_plans_variants.meal_plan_id')
         ->select('subscription_plans.id','subscriptions.variant_id','subscription_plans.name_ar as name','subscription_plans.image','subscriptions.start_date','subscriptions_meal_plans_variants.no_days as no_dayss','subscriptions_meal_plans_variants.option2')
         ->where(['subscription_plans.status'=>'active','subscription_plans.id'=>$subscriptions->id])
         ->where('subscriptions.user_id',Auth::guard('api')->id())
         ->where('subscriptions.variant_id',$request->variant_id)
         ->where('subscriptions_meal_plans_variants.id',$request->variant_id)
         ->where('subscriptions.delivery_status','terminted')
         ->first();
        }else{
            $subscription=Subscription::join('subscription_plans','subscriptions.plan_id','=','subscription_plans.id')
            ->join('subscriptions_meal_plans_variants','subscriptions.plan_id','=','subscriptions_meal_plans_variants.meal_plan_id')
            ->select('subscription_plans.id','subscriptions.variant_id','subscription_plans.name','subscription_plans.image','subscriptions.start_date','subscriptions_meal_plans_variants.no_days as no_dayss','subscriptions_meal_plans_variants.option2')
            ->where(['subscription_plans.status'=>'active','subscription_plans.id'=>$subscriptions->id])
            ->where('subscriptions.user_id',Auth::guard('api')->id())
            ->where('subscriptions.variant_id',$request->variant_id)
            ->where('subscriptions_meal_plans_variants.id',$request->variant_id)
            ->where('subscriptions.delivery_status','terminted')
            ->first();

         }
        
         if($subscription){
        
                 $puchase_on = $subscription->start_date;
                $subscription->puchase_on = date('d M', strtotime($puchase_on));
                $dates = Carbon::createFromFormat('Y-m-d',$subscription->start_date);
                 $expired_on = $dates->addDays($subscription->no_dayss);
                $subscription->expired_on = date('d M', strtotime($expired_on));
                $subscription->expire_date = date('Y-m-d', strtotime($expired_on));
            
               

                // $dates = Carbon::createFromFormat('Y-m-d',$subscription->start_date);
                //  $date = $dates->addDays($subscription->no_days);
                //   $diff = now()->diffInDays(Carbon::parse($date));
                //  if($diff == 0){
                //     $subscription->days_remaining = "Your plan is expire";
                //  }else{
                //     $subscription->days_remaining = $diff .' days left to expire ';
                //  }
               
                
                
                $subscription->meal_groups=[];
                if($language->lang == 'ar'){   
                if(SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id,'id'=>$subscription->variant_id])->first()){

                        $costs=SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id,'id'=>$subscription->variant_id])->first();
                        $subscription->cost=$costs->plan_price;
                        $subscription->day=$costs->option1;
                        // $costs->option1 = '-';

                        $meals=[];
                        $meal_des=[];
                           $subscription->meal_groups=SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$subscription->id])->get();
                        foreach($subscription->meal_groups as $meal){
                            array_push($meals,['id'=>$meal->meal_group->id,'meal_name'=>$meal->meal_group->name_ar]);
                            array_push($meal_des,$meal->meal_group->name_ar);
                        }
                        $meal_des=count($meal_des)." باقة الوجبات (".implode(',',$meal_des).")";

                        $subscription->description=[
                            "يخدم حتى $costs->serving_calorie من السعرات الحرارية $costs->calorie السعرات الحرارية الموصى بها لك.",
                            $costs->no_days." أيام أ ".$costs->option1,
                            " ".$meal_des
                        ];
                        $subscription->meal_groups=$meals;
                        
                    }
                }else{
                    if(SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id,'id'=>$subscription->variant_id])->first()){

                        $costs=SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id,'id'=>$subscription->variant_id])->first();
                        $subscription->cost=$costs->plan_price;
                        $subscription->day=$costs->option1;
                        // $costs->option1 = '-';

                        $meals=[];
                        $meal_des=[];
                           $subscription->meal_groups=SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$subscription->id])->get();
                        foreach($subscription->meal_groups as $meal){
                            array_push($meals,['id'=>$meal->meal_group->id,'meal_name'=>$meal->meal_group->name]);
                            array_push($meal_des,$meal->meal_group->name);
                        }
                        $meal_des=count($meal_des)." Meals Package (".implode(',',$meal_des).")";

                        $subscription->description=[
                            "Serves Upto $costs->serving_calorie calories out of $costs->calorie calories recommended for you.",
                            $costs->no_days." days a ".$costs->option1,
                            " ".$meal_des
                        ];
                        $subscription->meal_groups=$meals;
                        
                    }

                }
                    if($subscription->start_date){
                        if($subscription->option2 == 'withoutweekend'){
                             $date = Carbon::createFromFormat('Y-m-d',$subscription->start_date);
                            $weekdays = 0;
                            $weekdayss = 0;
                              for ($i = 0; $i < $subscription->no_dayss; $i++) {
                                   $alldate = $date->addDay()->format('y-m-d');
                                   $dd = Carbon::createFromFormat('Y-m-d',$alldate);
                                    $dayStr = strtolower($dd->format('l'));
                                    if ($dayStr == 'friday' ) {
                                       $weekdays++;
                                   }
                                   if ($dayStr == 'saturday' ) {
                                       $weekdayss++;
                                   }
                              }
                               //    dd($increasingdays);
                            $totalDays = $weekdays+$weekdayss;
                            $subscription->no_days = $subscription->no_dayss+$totalDays;
                            }else{
                            $subscription->no_days = $subscription->no_dayss;
                            }
                            $subscription->diet_plan = $dietPlan->name;
                        //    dd($increasingdays);
                     }
                }
                

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

     public function viewPreviousPlanDeliveries(Request $request) {
        $plan_id = $request->subscription_plan_id;
        $variant_id = $request->variant_id;
        $dates = $request->date;

        $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
        if($language->lang == 'ar'){ 

        $datess = Carbon::createFromFormat('Y-m-d',$dates);
        $day = strtolower($datess->format('l'));

        if($day == 'monday'){
            $var = "1";
        }elseif($day == 'tuesday'){
            $var = '2';
        }elseif($day == 'wednesday'){
           $var = '3';
       }elseif($day == 'thursday'){
           $var = '4';
       }elseif($day == 'friday'){
           $var = '5';
       }elseif($day == 'saturday'){
           $var = '6';
       }else{
           $var = '7';
       }
       $datess = Carbon::createFromFormat('Y-m-d',$dates);
       $day = strtolower($datess->format('l'));
     $getAllDays = UserAddress::where('user_id',Auth::guard('api')->id())->where('day_selection_status','active')->get();
     if($day == 'monday'){
         $var = "1";
     }elseif($day == 'tuesday'){
         $var = '2';
     }elseif($day == 'wednesday'){
        $var = '3';
    }elseif($day == 'thursday'){
        $var = '4';
    }elseif($day == 'friday'){
        $var = '5';
    }elseif($day == 'saturday'){
        $var = '6';
    }else{
        $var = '7';
    }

    // $custom_calorie = $request->custom_calorie;
    $userCustomCalorie = UserCaloriTarget::select('custom_result_id')->where('user_id',Auth::guard('api')->id())->first();
    $targetCalorie = CalorieRecommend::select('recommended')->where('id',$userCustomCalorie->custom_result_id)->first();

    //  $checkPlan = UserProfile::select('id','subscription_id','diet_plan_type_id','variant_id')->where('user_id',Auth::guard('api')->id())->first();
    $start_date = Subscription::select('start_date')->where(['plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('user_id',Auth::guard('api')->id())->first();
     $no_of_day = SubscriptionMealPlanVariant::select('no_days','option2')->where(['meal_plan_id'=>$plan_id,'id'=>$variant_id])->first();
     if(!empty($no_of_day))
     {

         $countSkip = UserSkipDelivery::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->count();
         $no_of_days = $no_of_day->no_days + $countSkip;
     }

    if(UserChangeDeliveryLocation::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('change_location_for_date',$dates)->exists()){
        $deliverie = userAddress::join('user_change_delivery_location','user_address.id','=','user_change_delivery_location.user_address_id')
        // ->join('delivery_slots','user_address.delivery_slot_id','=','delivery_slots.id')
        ->select('user_address.address_type','user_address.id')
        ->where('user_change_delivery_location.user_id',Auth::guard('api')->id())
         ->where('user_change_delivery_location.change_location_for_date',$dates)
         ->where('user_change_delivery_location.subscription_plan_id',$plan_id)
         ->where('user_change_delivery_location.variant_id',$variant_id)
        ->first();

        if(UserSkipTimeSlot::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('skip_date',$dates)->exists()){

            $deliveries_slot = UserSkipTimeSlot::join('delivery_slots','user_skip_time_slot.delivery_slot_id','=','delivery_slots.id')
           ->join('user_address','user_skip_time_slot.user_address_id','=','user_address.id')
           ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.id','delivery_slots.name_ar as name','delivery_slots.id as slot_id')
           ->where('user_skip_time_slot.skip_date',$dates)
            ->where('user_skip_time_slot.user_id',Auth::guard('api')->id())
            ->where('user_skip_time_slot.subscription_plan_id',$plan_id)
            ->where('user_skip_time_slot.variant_id',$variant_id)
           ->first();
           $deliverie->start_time = $deliveries_slot->start_time;
           $deliverie->end_time = $deliveries_slot->end_time;
           $deliverie->name = $deliveries_slot->name;
           $deliverie->slot_id = $deliveries_slot->slot_id;
        
       }else{
        $deliverieSlot = userAddress::join('user_change_delivery_location','user_address.id','=','user_change_delivery_location.user_address_id')
        ->join('delivery_slots','user_address.delivery_slot_id','=','delivery_slots.id')
        ->select('delivery_slots.start_time','delivery_slots.end_time','delivery_slots.name_ar as name','delivery_slots.id as slot_id')
        ->where('user_change_delivery_location.user_id',Auth::guard('api')->id())
         ->where('user_change_delivery_location.change_location_for_date',$dates)
         ->where('user_change_delivery_location.subscription_plan_id',$plan_id)
         ->where('user_change_delivery_location.variant_id',$variant_id)
        ->first();
     
       $deliverie->start_time = $deliverieSlot->start_time;
       $deliverie->end_time = $deliverieSlot->end_time;
       $deliverie->name = $deliverieSlot->name;
       $deliverie->slot_id = $deliverieSlot->slot_id;
    }

       $data['deliveries'] = $deliverie;

    }else{
        if(UserSkipTimeSlot::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('skip_date',$dates)->exists()){
    
             $deliverie = UserSkipTimeSlot::join('delivery_slots','user_skip_time_slot.delivery_slot_id','=','delivery_slots.id')
            // ->join('user_address','user_skip_time_slot.user_address_id','=','user_address.id')
            ->select('delivery_slots.start_time','delivery_slots.end_time','delivery_slots.name_ar as name','delivery_slots.id as slot_id')
            ->where('user_skip_time_slot.skip_date',$dates)
             ->where('user_skip_time_slot.user_id',Auth::guard('api')->id())
             ->where('user_skip_time_slot.subscription_plan_id',$plan_id)
             ->where('user_skip_time_slot.variant_id',$variant_id)
            ->first();
                $deliveries = userAddress::
                select('user_address.id','user_address.address_type')
                ->where('user_id',Auth::guard('api')->id())
                ->where('day_selection_status','active')
                ->when($var == "1", function ($q) {
                    $q->where('monday',"1");
                 })
                 ->when($var == "2", function ($q) {
                     $q->where('tuesday',"1");
                 })
                 ->when($var == "3", function ($q) {
                     $q->where('wednesday',"1");
                 })
                 ->when($var == "4", function ($q) {
                     $q->where('thursday',"1");
                 })
                 ->when($var == "5", function ($q) {
                     $q->where('friday',"1");
                 })
                 ->when($var == "6", function ($q) {
                     $q->where('saturday',"1");
                 })
                 ->when($var == "7", function ($q) {
                     $q->where('sunday',"1");
                 })
                ->first();

                $deliverie->address_type = $deliveries->address_type;
                $deliverie->id = $deliveries->id;

            $data['deliveries'] = $deliverie;
          
        }else{
            $data['deliveries'] = DeliverySlot::join('user_address','delivery_slots.id','=','user_address.delivery_slot_id')
        ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.id','delivery_slots.name_ar as name','delivery_slots.id as slot_id','user_address.address_type')
        ->where('user_id',Auth::guard('api')->id())
        ->where('day_selection_status','active')
        ->when($var == "1", function ($q) {
           $q->where('monday',"1");
        })
        ->when($var == "2", function ($q) {
            $q->where('tuesday',"1");
        })
        ->when($var == "3", function ($q) {
            $q->where('wednesday',"1");
        })
        ->when($var == "4", function ($q) {
            $q->where('thursday',"1");
        })
        ->when($var == "5", function ($q) {
            $q->where('friday',"1");
        })
        ->when($var == "6", function ($q) {
            $q->where('saturday',"1");
        })
        ->when($var == "7", function ($q) {
            $q->where('sunday',"1");
        })
        ->first();
      }
  }
      if(UserSkipDelivery::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('skip_delivery_date',$dates)->exists())
      {
        $category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$plan_id])
        ->get()
        ->each(function($category){
            $category->meal_group->meals = [ ];
            
        })->toArray();
        $data['category'] = $category;
        $data['skip_status'] = "you skip your delivery for this date";
       }else{

     
         $checkPlanStatus = UserProfile::select('subscription_id','variant_id')->where('user_id',Auth::guard('api')->id())->first();
         if($checkPlanStatus->subscription_id == $plan_id && $checkPlanStatus->variant_id == $variant_id){
            $data['plan_status'] = "current";
         }else{
            $data['plan_status'] = "previous";
         }
       
        //   $data['deliveries'] = DeliverySlot::join('user_address','delivery_slots.id','=','user_address.delivery_slot_id')
        //   ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.address_type')
        //   ->first();
            $category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$plan_id])
           ->get()
           ->each(function($category) use($dates,$plan_id,$targetCalorie,$variant_id){
            $category->meal_group->meals =Meal::
         join('subscription_meal_plan_variant_default_meal','meals.id','subscription_meal_plan_variant_default_meal.item_id')
         ->join('meal_macro_nutrients','meals.id','=','meal_macro_nutrients.meal_id')
         ->select('meals.name_ar as name','meals.side_dish_ar as side_dish','meals.image','meals.id','meals.food_type','meal_macro_nutrients.meal_calorie','meal_macro_nutrients.protein','meal_macro_nutrients.carbs','meal_macro_nutrients.fat')
             ->where('subscription_meal_plan_variant_default_meal.meal_schedule_id',$category->meal_group->id)
            ->whereDate('subscription_meal_plan_variant_default_meal.date','=', date('Y-m-d', strtotime($dates)))
            ->where(['subscription_meal_plan_variant_default_meal.meal_plan_id'=> $plan_id,'meals.status'=>'active'])
            ->where('meal_macro_nutrients.user_calorie',$targetCalorie->recommended)
            ->get()->each(function($meals) {
            
                $meals->dislikeItem = DislikeItem::join('meal_ingredient_list','dislike_items.id','=','meal_ingredient_list.item_id')
                ->select('dislike_items.id','dislike_items.group_id','dislike_items.name_ar as name')
                ->where('meal_ingredient_list.meal_id',$meals->id)
                 ->where('dislike_items.status','active')->get()
                  ->each(function($dislikeItem){
                      $dislikeItem->selected=false;
                   if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$dislikeItem->group_id])->first()){
                       $dislikeItem->selected=true;
                   }
              });
            //  $meals->ingredient=MealIngredientList::select('ingredients')->where(['meal_id'=>$meals->id])->get();
             $meals->rating = MealRating::select(DB::raw('avg(rating) as avg_rating'))
             ->where('meal_id', $meals->id)
             ->groupBy('meal_id')
            ->first();
            $meals->ratingcount = MealRating::where('meal_id', $meals->id)
            ->groupBy('meal_id')
           ->count();
     })->toArray();
    })->toArray(); 
       $data['category'] = $category;
       $data['skip_status'] = "";
       $data['no_of_days'] = $no_of_days;
       $data['withoutOrWithweekend'] = $no_of_day->option2;
    }
}else{
    $datess = Carbon::createFromFormat('Y-m-d',$dates);
    $day = strtolower($datess->format('l'));

    if($day == 'monday'){
        $var = "1";
    }elseif($day == 'tuesday'){
        $var = '2';
    }elseif($day == 'wednesday'){
       $var = '3';
   }elseif($day == 'thursday'){
       $var = '4';
   }elseif($day == 'friday'){
       $var = '5';
   }elseif($day == 'saturday'){
       $var = '6';
   }else{
       $var = '7';
   }
   $datess = Carbon::createFromFormat('Y-m-d',$dates);
   $day = strtolower($datess->format('l'));
 $getAllDays = UserAddress::where('user_id',Auth::guard('api')->id())->where('day_selection_status','active')->get();
 if($day == 'monday'){
     $var = "1";
 }elseif($day == 'tuesday'){
     $var = '2';
 }elseif($day == 'wednesday'){
    $var = '3';
}elseif($day == 'thursday'){
    $var = '4';
}elseif($day == 'friday'){
    $var = '5';
}elseif($day == 'saturday'){
    $var = '6';
}else{
    $var = '7';
}

// $custom_calorie = $request->custom_calorie;
$userCustomCalorie = UserCaloriTarget::select('custom_result_id')->where('user_id',Auth::guard('api')->id())->first();
$targetCalorie = CalorieRecommend::select('recommended')->where('id',$userCustomCalorie->custom_result_id)->first();

//  $checkPlan = UserProfile::select('id','subscription_id','diet_plan_type_id','variant_id')->where('user_id',Auth::guard('api')->id())->first();
$start_date = Subscription::select('start_date')->where(['plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('user_id',Auth::guard('api')->id())->first();
 $no_of_day = SubscriptionMealPlanVariant::select('no_days','option2')->where(['meal_plan_id'=>$plan_id,'id'=>$variant_id])->first();
 if(!empty($no_of_day))
 {

     $countSkip = UserSkipDelivery::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->count();
     $no_of_days = $no_of_day->no_days + $countSkip;
 }

if(UserChangeDeliveryLocation::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('change_location_for_date',$dates)->exists()){
    $deliverie = userAddress::join('user_change_delivery_location','user_address.id','=','user_change_delivery_location.user_address_id')
    // ->join('delivery_slots','user_address.delivery_slot_id','=','delivery_slots.id')
    ->select('user_address.address_type','user_address.id')
    ->where('user_change_delivery_location.user_id',Auth::guard('api')->id())
     ->where('user_change_delivery_location.change_location_for_date',$dates)
     ->where('user_change_delivery_location.subscription_plan_id',$plan_id)
     ->where('user_change_delivery_location.variant_id',$variant_id)
    ->first();

    if(UserSkipTimeSlot::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('skip_date',$dates)->exists()){

        $deliveries_slot = UserSkipTimeSlot::join('delivery_slots','user_skip_time_slot.delivery_slot_id','=','delivery_slots.id')
       ->join('user_address','user_skip_time_slot.user_address_id','=','user_address.id')
       ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.id','delivery_slots.name','delivery_slots.id as slot_id')
       ->where('user_skip_time_slot.skip_date',$dates)
        ->where('user_skip_time_slot.user_id',Auth::guard('api')->id())
        ->where('user_skip_time_slot.subscription_plan_id',$plan_id)
        ->where('user_skip_time_slot.variant_id',$variant_id)
       ->first();
       $deliverie->start_time = $deliveries_slot->start_time;
       $deliverie->end_time = $deliveries_slot->end_time;
       $deliverie->name = $deliveries_slot->name;
       $deliverie->slot_id = $deliveries_slot->slot_id;
    
   }else{
    $deliverieSlot = userAddress::join('user_change_delivery_location','user_address.id','=','user_change_delivery_location.user_address_id')
    ->join('delivery_slots','user_address.delivery_slot_id','=','delivery_slots.id')
    ->select('delivery_slots.start_time','delivery_slots.end_time','delivery_slots.name','delivery_slots.id as slot_id')
    ->where('user_change_delivery_location.user_id',Auth::guard('api')->id())
     ->where('user_change_delivery_location.change_location_for_date',$dates)
     ->where('user_change_delivery_location.subscription_plan_id',$plan_id)
     ->where('user_change_delivery_location.variant_id',$variant_id)
    ->first();
 
   $deliverie->start_time = $deliverieSlot->start_time;
   $deliverie->end_time = $deliverieSlot->end_time;
   $deliverie->name = $deliverieSlot->name;
   $deliverie->slot_id = $deliverieSlot->slot_id;
}

   $data['deliveries'] = $deliverie;

}else{
    if(UserSkipTimeSlot::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('skip_date',$dates)->exists()){

         $deliverie = UserSkipTimeSlot::join('delivery_slots','user_skip_time_slot.delivery_slot_id','=','delivery_slots.id')
        // ->join('user_address','user_skip_time_slot.user_address_id','=','user_address.id')
        ->select('delivery_slots.start_time','delivery_slots.end_time','delivery_slots.name','delivery_slots.id as slot_id')
        ->where('user_skip_time_slot.skip_date',$dates)
         ->where('user_skip_time_slot.user_id',Auth::guard('api')->id())
         ->where('user_skip_time_slot.subscription_plan_id',$plan_id)
         ->where('user_skip_time_slot.variant_id',$variant_id)
        ->first();
            $deliveries = userAddress::
            select('user_address.id','user_address.address_type')
            ->where('user_id',Auth::guard('api')->id())
            ->where('day_selection_status','active')
            ->when($var == "1", function ($q) {
                $q->where('monday',"1");
             })
             ->when($var == "2", function ($q) {
                 $q->where('tuesday',"1");
             })
             ->when($var == "3", function ($q) {
                 $q->where('wednesday',"1");
             })
             ->when($var == "4", function ($q) {
                 $q->where('thursday',"1");
             })
             ->when($var == "5", function ($q) {
                 $q->where('friday',"1");
             })
             ->when($var == "6", function ($q) {
                 $q->where('saturday',"1");
             })
             ->when($var == "7", function ($q) {
                 $q->where('sunday',"1");
             })
            ->first();

            $deliverie->address_type = $deliveries->address_type;
            $deliverie->id = $deliveries->id;

        $data['deliveries'] = $deliverie;
      
    }else{
        $data['deliveries'] = DeliverySlot::join('user_address','delivery_slots.id','=','user_address.delivery_slot_id')
    ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.id','delivery_slots.name','delivery_slots.id as slot_id','user_address.address_type')
    ->where('user_id',Auth::guard('api')->id())
    ->where('day_selection_status','active')
    ->when($var == "1", function ($q) {
       $q->where('monday',"1");
    })
    ->when($var == "2", function ($q) {
        $q->where('tuesday',"1");
    })
    ->when($var == "3", function ($q) {
        $q->where('wednesday',"1");
    })
    ->when($var == "4", function ($q) {
        $q->where('thursday',"1");
    })
    ->when($var == "5", function ($q) {
        $q->where('friday',"1");
    })
    ->when($var == "6", function ($q) {
        $q->where('saturday',"1");
    })
    ->when($var == "7", function ($q) {
        $q->where('sunday',"1");
    })
    ->first();
  }
}
  if(UserSkipDelivery::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('skip_delivery_date',$dates)->exists())
  {
    $category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$plan_id])
    ->get()
    ->each(function($category){
        $category->meal_group->meals = [ ];
        
    })->toArray();
    $data['category'] = $category;
    $data['skip_status'] = "you skip your delivery for this date";
   }else{

 
     $checkPlanStatus = UserProfile::select('subscription_id','variant_id')->where('user_id',Auth::guard('api')->id())->first();
     if($checkPlanStatus->subscription_id == $plan_id && $checkPlanStatus->variant_id == $variant_id){
        $data['plan_status'] = "current";
     }else{
        $data['plan_status'] = "previous";
     }
   
    //   $data['deliveries'] = DeliverySlot::join('user_address','delivery_slots.id','=','user_address.delivery_slot_id')
    //   ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.address_type')
    //   ->first();
        $category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$plan_id])
       ->get()
       ->each(function($category) use($dates,$plan_id,$targetCalorie,$variant_id){
        $category->meal_group->meals =Meal::
     join('subscription_meal_plan_variant_default_meal','meals.id','subscription_meal_plan_variant_default_meal.item_id')
     ->join('meal_macro_nutrients','meals.id','=','meal_macro_nutrients.meal_id')
     ->select('meals.name','meals.name_ar','meals.side_dish','meals.side_dish_ar','meals.image','meals.id','meals.food_type','meal_macro_nutrients.meal_calorie','meal_macro_nutrients.protein','meal_macro_nutrients.carbs','meal_macro_nutrients.fat')
         ->where('subscription_meal_plan_variant_default_meal.meal_schedule_id',$category->meal_group->id)
        ->whereDate('subscription_meal_plan_variant_default_meal.date','=', date('Y-m-d', strtotime($dates)))
        ->where(['subscription_meal_plan_variant_default_meal.meal_plan_id'=> $plan_id,'meals.status'=>'active'])
        ->where('meal_macro_nutrients.user_calorie',$targetCalorie->recommended)
        ->get()->each(function($meals) {
        
            $meals->dislikeItem = DislikeItem::join('meal_ingredient_list','dislike_items.id','=','meal_ingredient_list.item_id')
            ->select('dislike_items.id','dislike_items.group_id','dislike_items.name')
            ->where('meal_ingredient_list.meal_id',$meals->id)
             ->where('dislike_items.status','active')->get()
              ->each(function($dislikeItem){
                  $dislikeItem->selected=false;
               if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$dislikeItem->group_id])->first()){
                   $dislikeItem->selected=true;
               }
          });
        //  $meals->ingredient=MealIngredientList::select('ingredients')->where(['meal_id'=>$meals->id])->get();
         $meals->rating = MealRating::select(DB::raw('avg(rating) as avg_rating'))
         ->where('meal_id', $meals->id)
         ->groupBy('meal_id')
        ->first();
        $meals->ratingcount = MealRating::where('meal_id', $meals->id)
        ->groupBy('meal_id')
       ->count();
 })->toArray();
})->toArray(); 
   $data['category'] = $category;
   $data['skip_status'] = "";
   $data['no_of_days'] = $no_of_days;
   $data['withoutOrWithweekend'] = $no_of_day->option2;
}

}
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

    public function repeat_meal_plan(Request $request) {

         $getSubscriptionId = UserProfile::where('user_id',Auth::guard('api')->id())->first();
        $remainingDays = Subscription::where('user_id',Auth::guard('api')->id())->where('plan_status','plan_active')->where(['plan_id'=>$getSubscriptionId->subscription_id,'variant_id'=>$getSubscriptionId->variant_id])->first();
        if($remainingDays)
        {
         $getNoOfDays = SubscriptionMealPlanVariant::select('no_days','option2','plan_price')->where('id',$remainingDays->variant_id)->first();
          $dates = Carbon::createFromFormat('Y-m-d',$remainingDays->start_date);
           $date = $dates->addDays($getNoOfDays->no_days);
            $getTwoDayBeforeDate = $date->subDays(2);
         $getTwoDayBeforeDateExpireDate = date('Y-m-d',strtotime($getTwoDayBeforeDate)) ;
          $nowDate = date('Y-m-d',strtotime(now())) ;
        // return  $diff =  $getTwoDayBeforeDate->diffInDays(Carbon::parse($date));
        if($nowDate <= $getTwoDayBeforeDateExpireDate){
            if($request->toggle_request == '1'){
            if($getSubscriptionId->available_credit >=  $getNoOfDays->plan_price ){
                $dates = Carbon::createFromFormat('Y-m-d',$remainingDays->start_date);
                  $date = $dates->addDays($getNoOfDays->no_days);
                  $expireDateOnedayExtra = $date->addDays(2);
                $newStartDate = date('Y-m-d',strtotime($expireDateOnedayExtra));
                $dateend = $dates->addDays($getNoOfDays->no_days);
                $data =Subscription::updateOrCreate(
                    ['user_id' =>  Auth::guard('api')->id(), 'plan_id' => $getSubscriptionId->subscription_id,  'variant_id' => $getSubscriptionId->variant_id, 'delivery_status'=> 'upcoming'],
                  
                   [
                       'user_id' =>  Auth::guard('api')->id(),
                       'plan_id' => $getSubscriptionId->subscription_id,
                       'variant_id' => $getSubscriptionId->variant_id,
                       'start_date'=> $newStartDate,
                       'end_date'=> \Carbon\Carbbon::parse($dateend)->format('Y-m-d'),
                       'is_weekend'=> $getNoOfDays->option2,
                       'delivery_status'=> 'upcoming',
                       'plan_status'=> 'plan_active',
                     
           
                   ]
                );
                $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                if($language->lang == 'ar'){
                return response()->json([
                    'status' => true,
                    'error'=> 'كرر الخطة بنجاح'
                   ]);
                }else{
                    return response()->json([
                        'status' => true,
                        'error'=> 'Plan repeat successfully'
                       ]);

                }
            }else{
              $date = $dates->addDays($getNoOfDays->no_days);
             $expireDateOnedayExtra = $date->addDays(2);
             $newStartDate = date('Y-m-d',strtotime($expireDateOnedayExtra));
             $dateend = $dates->addDays($getNoOfDays->no_days);
             //  $updatePlanStatus = Subscription::where(['user_id' => Auth::guard('api')->id(),  'plan_id' => $getSubscriptionId->subscription_id, 'variant_id' => $getSubscriptionId->variant_id,])->update(['plan_status'=>'plan_inactive','delivery_status'=>'terminted']);
             $data =Subscription::Create(
               
                [
                    'user_id' =>  Auth::guard('api')->id(),
                    'plan_id' => $getSubscriptionId->subscription_id,
                    'variant_id' => $getSubscriptionId->variant_id,
                    'start_date'=> $newStartDate,
                    'end_date'=> \Carbon\Carbbon::parse($dateend)->format('Y-m-d'),
                    'is_weekend'=> $getNoOfDays->option2,
                    'delivery_status'=> 'upcoming',
                    'plan_status'=> 'plan_active',
        
                ]
             );
          }
        }else{
             Subscription::where(['user_id' => Auth::guard('api')->id(),  'plan_id' => $getSubscriptionId->subscription_id, 'variant_id' => $getSubscriptionId->variant_id,'delivery_status'=>'upcoming'])->update(['plan_status'=>'plan_inactive']);
             $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
             if($language->lang == 'ar'){
            return response()->json([
                'status' => true,
                'error'=> ' خطة غير نشطة بنجاح'
               ]);
            }else{
                return response()->json([
                    'status' => true,
                    'error'=> ' Plan inactive successfully'
                   ]);

            }
        }

        }else{
            $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
            if($language->lang == 'ar'){
            return response()->json([
             'status' => true,
             'error'=> 'كرر الخطة قبل 48 ساعة من تاريخ انتهاء الصلاحية'
            ]);
        }else{
            return response()->json([
                'status' => true,
                'error'=> 'Repeat plan before 48 hours of expire date'
               ]);

        }
        }
       
        if($data){
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->message = trans('messages.repeat_plan');
        }else {
            $this->message = trans('messages.server_error');
            $this->status_code = 202;
        }
        $this->status = true;
    }
        return $this->populateResponse();
    }

    public function updateDateForSelectStartDateAndMeal(Request $request) {
        $startDate = $request->start_date;
        $plan_id = $request->plan_id;
        $variant_id = $request->variant_id;

        $noOfDays = SubscriptionMealPlanVariant::select('no_days','plan_price','option2')->where(['meal_plan_id'=>$request->plan_id, 'id' => $request->variant_id,])->first();
        $dates = Carbon::createFromFormat('Y-m-d',$request->start_date);
        $date = $dates->addDays($noOfDays->no_days);
         $endDate = date('Y-m-d',strtotime($date));

         if($noOfDays->option2 == 'withoutweekend'){
            $date = Carbon::createFromFormat('Y-m-d',$request->start_date);
             $day = strtolower($date->format('l'));
             if ($day == 'friday' )
              {
                $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                if($language->lang == 'ar'){
                return response()->json([
                    'status' => true,
                    'error'=> 'خطتك بدون عطلة نهاية الأسبوع لا يمكنك إضافة الجمعة'
                   ]);
                }else{
                    return response()->json([
                        'status' => true,
                        'error'=> 'Your plan is without weekend you can not add friday'
                       ]);

                }
                }
                if ($day == 'saturday' ) {
                    $language = User::select('lang')->where('id',Auth::guard('api')->id())->first();
                    if($language->lang == 'ar'){
                    return response()->json([
                        'status' => true,
                        'error'=> 'Your plan is without weekend you can not add saturday'
                       ]);
                    }else{
                        return response()->json([
                            'status' => true,
                            'error'=> 'Your plan is without weekend you can not add saturday'
                           ]);
                    }
                     }
                     Subscription::where(['user_id'=>Auth::guard('api')->id(),'plan_id'=>$plan_id,'variant_id'=>$variant_id])->update(['start_date'=>$startDate, 'end_date'=>$endDate]);
           }else{

         Subscription::where(['user_id'=>Auth::guard('api')->id(),'plan_id'=>$plan_id,'variant_id'=>$variant_id,'delivery_status'=>'active'])->update(['start_date'=>$startDate, 'end_date'=>$endDate]);

           }
        $this->status = true; 
        $this->status_code = 200;
        $this->message = trans('messages.date_update');
        return $this->populateResponse();

    }

    public function saveRecommendedCalorie(Request $request) {

        if($request->recommendedCalorie == '0')
        {
            $getRecommendedCalorie = UserCaloriTarget::where(['user_id'=>Auth::guard('api')->id()])->first();
             $data = UserCaloriTarget::updateOrCreate(['user_id'=>Auth::guard('api')->id()])->update(['custom_result_id'=>$getRecommendedCalorie->recommended_result_id]);
        }else{

        }
       
      $this->status = true;
      $this->message = trans('plan_messages.update_recommended');
      return $this->populateResponse();
  }

  public function swapMeallisting(Request $request) {
    $date = $request->date;
    $subscription_plan_id = $request->subscription_plan_id;
    $schedule_id = $request->schedule_id;
    $custom_calorie = $request->custom_calorie;

     $meals =Meal::
     join('subscription_meal_plan_variant_default_meal','meals.id','subscription_meal_plan_variant_default_meal.item_id')
     ->join('meal_macro_nutrients','meals.id','=','meal_macro_nutrients.meal_id')
     ->select('meals.name','meals.name_ar','meals.side_dish','meals.side_dish_ar','meals.image','meals.id','meals.food_type','meal_macro_nutrients.meal_calorie','meal_macro_nutrients.protein','meal_macro_nutrients.carbs','meal_macro_nutrients.fat')
    //  ->whereDate('subscription_meal_plan_variant_default_meal.date','=', date('Y-m-d', strtotime($dates)))
     ->where(['subscription_meal_plan_variant_default_meal.meal_plan_id'=> $subscription_plan_id,'meals.status'=>'active'])
      ->where('subscription_meal_plan_variant_default_meal.date',$date)
      ->where('subscription_meal_plan_variant_default_meal.meal_schedule_id',$schedule_id)
      ->where('meal_macro_nutrients.user_calorie',$custom_calorie)
      ->distinct()
     ->get()
     ->each(function($meals){
       
     $meals->dislikeItem = DislikeItem::join('meal_ingredient_list','dislike_items.id','=','meal_ingredient_list.item_id')
     ->select('dislike_items.id','dislike_items.group_id','dislike_items.name')
     ->where('meal_ingredient_list.meal_id',$meals->id)
     ->where('dislike_items.status','active')->get()
     ->each(function($dislikeItem){
        $dislikeItem->selected=false;
        if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$dislikeItem->group_id])->first()){
            $dislikeItem->selected=true;
        }
    });
    $meals->dislikegroup = DislikeGroup::select('id','name')->where('status','active')->get()->each(function($dislikegroup){
        $dislikegroup->selected=false;
        if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$dislikegroup->id])->first()){
            $dislikegroup->selected=true;
        }
    });
      $meals->rating = MealRating::select(DB::raw('avg(rating) as avg_rating'))
      ->where('meal_id', $meals->id)
      ->groupBy('meal_id')
     ->first();
     $meals->ratingcount = MealRating::where('meal_id', $meals->id)
     ->groupBy('meal_id')
    ->count();
})->toArray();

    $data['meals'] = $meals;
    $response = new \Lib\PopulateResponse($data);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.swap_meal_listing');
    return $this->populateResponse();
}
}
