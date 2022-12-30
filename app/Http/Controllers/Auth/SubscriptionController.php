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
        $id = $request->meal_plan_id;
        $meal_des=[];
         $mealDetail=Meal::select('*')->where('id',$request->meal_plan_id)->first();
        // return $meal = Meal::select('name','image')->with('meal_schedule')->get();
         $mealDetail = Meal::join('meal_schedules','meals.id','=','meal_schedules.id')
        ->select('meals.id as meal_id','meals.name as meal_name','image','description','image','food_type','meal_schedules.name')
        ->where('meals.id',$request->meal_plan_id)
        ->get()
        ->each(function($mealDetail) use($id){
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
        $response = new \Lib\PopulateResponse($data);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('plan_messages.diet_plan_detail');
    }); 
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
        $user=UserProfile::where('user_id',Auth::guard('api')->id())->first();
        $diet_id = $user->diet_plan_type_id;
        foreach($caloriRecommended as $calori){
           $calori->selected=false;
           if(UserCaloriTarget::where(['user_id'=>Auth::guard('api')->id(),'custom_result_id'=>$calori->id,'status'=>'ongoing'])->first()){
               $calori->selected=true;
     
           }
       }

        $data=['diet_id'=>$diet_id];
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
       
        $subscriptions=SubscriptionPlan::select('id')->where(['id'=> $request->subscription_plan_id])->first();
        if(Subscription::where(['delivery_status'=>'active','plan_id'=>$subscriptions['id']])->orWhere(['delivery_status'=>'terminated','plan_id'=>$subscriptions['id']])->first()){
          $subscription=SubscriptionPlan::join('subscriptions','subscription_plans.id','=','subscriptions.plan_id')
         ->join('subscriptions_meal_plans_variants','subscription_plans.id','=','subscriptions_meal_plans_variants.meal_plan_id')
         ->select('subscription_plans.id','subscription_plans.name','subscription_plans.image','subscriptions.start_date','subscriptions_meal_plans_variants.no_days')
         ->where(['subscription_plans.status'=>'active','subscription_plans.id'=>$subscriptions->id])
         ->first();
         if($subscription){

                $dates = Carbon::createFromFormat('Y-m-d',$subscription->start_date);
                 $date = $dates->addDays($subscription->no_days);
                  $diff = now()->diffInDays(Carbon::parse($date));
                 if($diff == 0){
                    $subscription->days_remaining = "Your plan is expire";
                 }else{
                    $subscription->days_remaining = $diff .' days left to expire ';
                 }
               
                
                
                $subscription->meal_groups=[];

                if(SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id])->first()){

                        $costs=SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id])->first();
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
          $data['deliveries'] = DeliverySlot::join('user_address','delivery_slots.id','=','user_address.delivery_slot_id')
          ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.address_type')
          ->first();
            $category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$plan_id])
           ->get()
           ->each(function($category) use($dates,$plan_id){
            $category->meal_group->meals =Meal::
         join('subscription_meal_plan_variant_default_meal','meals.id','subscription_meal_plan_variant_default_meal.item_id')
         //    join('meal_group_schedule','meals.id','=','meal_group_schedule.meal_id')
            ->select('meals.*')
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
      
        $meal = SubscriptionPlan::join('subscriptions','subscription_plans.id','=','subscriptions.plan_id')
        ->join('subscriptions_meal_plans_variants','subscription_plans.id','=','subscriptions_meal_plans_variants.meal_plan_id')
       ->select('subscriptions_meal_plans_variants.no_days','subscriptions.start_date','subscription_plans.image','subscription_plans.name','subscription_plans.id','subscriptions_meal_plans_variants.option1','subscriptions_meal_plans_variants.plan_price')
       ->where(['subscriptions.delivery_status'=>'active','subscriptions.user_id'=>Auth::guard('api')->id()])
       ->first();
       if($meal){
        $dates = Carbon::createFromFormat('Y-m-d',$meal->start_date);
        $date = $dates->addDays($meal->no_days);
        $diff = now()->diffInDays(Carbon::parse($date));
        if($diff == 0){
            $meal->days_remaining  = "Your plan is expire";
         }else{
            $ $meal->days_remaining  = $diff .' days left to expire ';
         }
     
       }
    //    ->each(function($meal){
    //     $dates = Carbon::createFromFormat('Y-m-d',$meal->start_date);
    //     $date = $dates->addDays($meal->no_days);
    //     $diff = now()->diffInDays(Carbon::parse($date));
    //     $meal->days_remaining = $diff .' days left to expire ';
        
    //    });
    

    $meals = SubscriptionPlan::join('subscriptions','subscription_plans.id','=','subscriptions.plan_id')
    ->join('subscriptions_meal_plans_variants','subscription_plans.id','=','subscriptions_meal_plans_variants.meal_plan_id')
   ->select('subscriptions_meal_plans_variants.no_days','subscription_plans.image','subscription_plans.name','subscription_plans.id','subscriptions_meal_plans_variants.option1','subscriptions_meal_plans_variants.plan_price','subscriptions.start_date')
   ->where(['subscriptions.delivery_status'=>'terminted','subscriptions.user_id'=>Auth::guard('api')->id()])
   ->get()->each(function($meals){
    $puchase_on = $meals->start_date;
    $meals->puchase_on = date('d M', strtotime($puchase_on));
    $dates = Carbon::createFromFormat('Y-m-d',$meals->start_date);
    $expired_on = $dates->addDays($meals->no_days);
    $meals->expired_on = date('d M', strtotime($expired_on));

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
    $request->start_date;
    $request->address_id;
    $request->city_id;
    $request->slected_or_not;
    $request->delivery_slot_id;
    $request->total_amount;

    $step = '';
    if($request->step=='1'){
        $user=SelectDeliveryLocation::updateOrCreate(
            ['user_id' =>  Auth::guard('api')->id()],
            [
                'user_id' =>  Auth::guard('api')->id(),
                'city_id' => $request->city_id,
                'selected_or_not'=> $request->selected_or_not,
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
        
        $user1=Order::updateOrCreate(
            ['user_id' =>  Auth::guard('api')->id()],
            [
                'user_id'=> Auth::guard('api')->id(),
                'card_type' => $request->card_type,
                'payment_method' => $request->payment_method,
                'total_amount' => $request->total_amount,
                
            ]
        );
        $is_weekend = SubscriptionMealPlanVariant::select('option2','plan_price')->where('meal_plan_id',$request->plan_id)->first();
        $user2=Subscription::updateOrCreate(
            ['user_id' =>  Auth::guard('api')->id(),'plan_id' => $request->plan_id],
            [
                'user_id'=> Auth::guard('api')->id(),
                'plan_id' => $request->plan_id,
                'start_date' => $request->start_date,
                'is_weekend' => $is_weekend->option2,
                'price' => $is_weekend->plan_price,
                'total_amount' => $request->total_amount,
                'delivery_status' => 'active'
               
            ]
           
        );
        $user3=SubscriptionOrder::updateOrCreate(
            ['user_id' =>  Auth::guard('api')->id()],
            [
                'user_id'=> Auth::guard('api')->id(),
                'subscription_id' => $user2->id,
                'amount' => $request->total_amount,
                // 'payment_status' => 'completed'
               
            ]
           
        );
        $user3=UserProfile::updateOrCreate(
            ['user_id' =>  Auth::guard('api')->id()],
            [
                'available_credit' => $request->total_amount,
                'subscription_id' => $request->plan_id,
               
            ]
           
        );

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
    // $plan_id = $request->subscription_plan_id;
     $checkPlan = Subscription::select('plan_id')->where('user_id',Auth::guard('api')->id())->where(['status'=>'active','delivery_status'=>'active'])->first();
   
        $category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$checkPlan->plan_id])
       ->get()
       ->each(function($category) use($dates,$checkPlan){
        $category->meal_group->meals =Meal::
        join('subscription_meal_plan_variant_default_meal','meals.id','subscription_meal_plan_variant_default_meal.item_id')
     //    join('meal_group_schedule','meals.id','=','meal_group_schedule.meal_id')
        ->select('meals.*')
         ->where('subscription_meal_plan_variant_default_meal.meal_schedule_id',$category->meal_group->id)
        // ->whereDate('meals.created_at','=', date('Y-m-d', strtotime($dates)))
        ->whereDate('subscription_meal_plan_variant_default_meal.date','=', date('Y-m-d', strtotime($dates)))
        ->where(['subscription_meal_plan_variant_default_meal.meal_plan_id'=> $checkPlan->plan_id,'meals.status'=>'active'])
         ->where('subscription_meal_plan_variant_default_meal.is_default','1')
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



public function selectStartDayCircle(){

    $meal = SubscriptionPlan::join('subscriptions','subscription_plans.id','=','subscriptions.plan_id')
    ->join('subscriptions_meal_plans_variants','subscription_plans.id','=','subscriptions_meal_plans_variants.meal_plan_id')
   ->select('subscriptions_meal_plans_variants.no_days','subscriptions.start_date')
   ->where(['subscriptions.delivery_status'=>'active','subscriptions.user_id'=>Auth::guard('api')->id()])
   ->first();
   if($meal){
    $dates = Carbon::createFromFormat('Y-m-d',$meal->start_date);
    $date = $dates->addDays($meal->no_days);
    $diff = now()->diffInDays(Carbon::parse($date));
    if($diff == 0){
        $meal->days_remaining  = "Your plan is expire";
     }else{
         $meal->days_remaining  = $diff ;
     }
 
   }
    $user=UserProfile::where('user_id',Auth::guard('api')->id())->first();
    $dietPlan=DietPlanType::where('id',$user->diet_plan_type_id)->first();

    $caloriRecommended = CalorieRecommend::select('id','recommended')->get();
    foreach($caloriRecommended as $calori){
       $calori->selected=false;
       if(UserCaloriTarget::where(['user_id'=>Auth::guard('api')->id(),'recommended_result_id'=>$calori->id,'status'=>'ongoing'])->first()){
           $calori->selected=true;
       }
   }

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
    $data['caloriRecommended'] = $caloriRecommended;
    $data['diet_plan_type_id'] = $user->diet_plan_type_id;
    $data['remaining_day'] = $meal;
    $response = new \Lib\PopulateResponse($data);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('plan_messages.kcal_calculation');
    return $this->populateResponse();
}


public function paymentPlan_detail(Request $request) {

    $plan_detail=SubscriptionPlan::join('subscriptions_meal_plans_variants','subscription_plans.id','=','subscriptions_meal_plans_variants.meal_plan_id')
    ->select('subscription_plans.id','subscription_plans.name','subscription_plans.image','subscriptions_meal_plans_variants.plan_price','subscriptions_meal_plans_variants.option1')
    ->where('subscription_plans.id',$request->plan_id)
    ->where(['subscription_plans.status'=>'active'])
    ->first();
   
   
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

     $meals =Meal::
     join('subscription_meal_plan_variant_default_meal','meals.id','subscription_meal_plan_variant_default_meal.item_id')
     ->select('meals.*')
    //  ->whereDate('subscription_meal_plan_variant_default_meal.date','=', date('Y-m-d', strtotime($dates)))
     ->where(['subscription_meal_plan_variant_default_meal.meal_plan_id'=> $subscription_plan_id,'meals.status'=>'active'])
      ->where('subscription_meal_plan_variant_default_meal.date',$date)
      ->where('subscription_meal_plan_variant_default_meal.meal_schedule_id',$schedule_id)
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
                $validate->errors()->add('gift card', "This gift card is not valid");
            }
        }

        if ($request['voucher_code'] &&  $request['voucher_pin']) {
            if($user_used = UserUsedGiftCard::where('voucher_code', $request['voucher_code'])->where('voucher_pin', $request['voucher_pin'])->exists()){
             $this->error_code = 201;
             $validate->errors()->add('gift card used', "This gift card is already used");
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
                $giftCard->deducted_amount = $giftCard->purchase_amount;
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
                $validate->errors()->add('gift card', "This referral code is not valid");
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
                return response()->json([
                    'status' => true,
                     'error'=> 'You already used this referral code for plan purchase'
                   ]);
            }

        }

        if ($request['referral_code']) {
            $getReferralId = User::where('referral_code',$request['referral_code'])->whereNotIn('status',['0'])->first();
            if($getReferralId->id == Auth::guard('api')->id()){
             
               {
                   return response()->json([
                    'status' => true,
                     'error'=> 'Use other user code '
                   ]);
               }
            }
        }

        if ($request['referral_code']) {
            $getReferralId = User::where('referral_code',$request['referral_code'])->whereNotIn('status',['0'])->first();
            $referralPerUser = ReferAndEarn::select('referral_per_user')->where('status','active')->first();
            $countForPlan = ReferAndEarnUsed::where(['referee_id'=>$getReferralId->id])->where('used_for','plan_purchase')->count();
            if($countForPlan == $referralPerUser->referral_per_user){
            {
                return response()->json([
                    'status' => true,
                     'error'=> 'This code is expire'
                   ]);
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
                $validate->errors()->add('promo code', "This promo code is not valid");
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
                        return response()->json([
                            'status' => true,
                             'message'=> 'This Code  is already used'
                           ]);
                    }
                }else{
                    $countUsers = UserUsedPromoCode::where('user_id',Auth::guard('api')->id())->where('promo_code_ticket_id',$count_used->promo_code_ticket_id)->count();
                    if($countUsers == $count_used->maximum_discount_uses){
                        return response()->json([
                            'status' => true,
                             'message'=> 'You used your max limit'
                           ]);
                    }
                }
           }else{
             $countTicket = UserUsedPromoCode::where('promo_code_ticket_id',$count_used->promo_code_ticket_id)->count();
             if($countTicket == $count_used->maximum_discount_uses){
                 return response()->json([
                    'status' => true,
                     'message'=> 'This code is expired '
                   ]);
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
            $promoCodeTicket_id->amount_discount = ($promoCodeTicket_id->discount/100)*$request->total_amount;
            }else{
             $promoCodeTicket_id->amount_discount = $promoCodeTicket_id->price;
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
$city = array(
    'Al-Haflaj',
    'Al-kharj',
    'Al-Ghat',
    'Almara',
    'Duruma',
    'Rumah',
);
   
 
    $response = new \Lib\PopulateResponse($city);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.city_list');
    return $this->populateResponse();
}

public function myMeals(Request $request) {
    $dates = $request->date;
    // $plan_id = $request->subscription_plan_id;
     $checkPlan = Subscription::select('plan_id')->where('user_id',Auth::guard('api')->id())->where(['status'=>'active','delivery_status'=>'active'])->first();
    if(UserChangeDeliveryLocation::where('user_id',Auth::guard('api')->id())->where('subscription_plan_id',$checkPlan->plan_id)->where('change_location_for_date',$dates)->exists()){
        $data['deliveries'] = userAddress::join('user_change_delivery_location','user_address.id','=','user_change_delivery_location.user_address_id')
        ->join('delivery_slots','user_address.delivery_slot_id','=','delivery_slots.id')
        ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.address_type','user_address.id')
        // ->where('user_id',Auth::guard('api')->id())
        ->first();

    }else{
    if(UserSkipTimeSlot::where('user_id',Auth::guard('api')->id())->where('subscription_plan_id',$checkPlan->plan_id)->where('skip_date',$dates)->exists()){

        $data['deliveries'] = UserSkipTimeSlot::join('delivery_slots','user_skip_time_slot.delivery_slot_id','=','delivery_slots.id')
        ->join('user_address','user_skip_time_slot.user_address_id','=','user_address.id')
        ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.address_type')
        // ->where('user_id',Auth::guard('api')->id())
        ->first();
    }else{
      $data['deliveries'] = DeliverySlot::join('user_address','delivery_slots.id','=','user_address.delivery_slot_id')
      ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.address_type','user_address.id')
      ->where('user_id',Auth::guard('api')->id())
      ->first();
    }
}
        $category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$checkPlan->plan_id])
       ->get()
       ->each(function($category) use($dates,$checkPlan){
        if(UserSkipDelivery::where('user_id',Auth::guard('api')->id())->where('subscription_plan_id',$checkPlan->plan_id)->where('skip_delivery_date',$dates)->exists())
        {
            $category->meal_group->meals = ["you skip your delivery for this date"];
        }else{
        $category->meal_group->meals =Meal::
        join('subscription_meal_plan_variant_default_meal','meals.id','subscription_meal_plan_variant_default_meal.item_id')
     //    join('meal_group_schedule','meals.id','=','meal_group_schedule.meal_id')
        ->select('meals.*')
         ->where('subscription_meal_plan_variant_default_meal.meal_schedule_id',$category->meal_group->id)
        // ->whereDate('meals.created_at','=', date('Y-m-d', strtotime($dates)))
        ->whereDate('subscription_meal_plan_variant_default_meal.date','=', date('Y-m-d', strtotime($dates)))
        ->where(['subscription_meal_plan_variant_default_meal.meal_plan_id'=> $checkPlan->plan_id,'meals.status'=>'active'])
         ->where('subscription_meal_plan_variant_default_meal.is_default','1')
        ->get()->each(function($meals) {
        
            $meals->ingredient= ['onion','tomato','carrot', 'chilli'];
        //  $meals->ingredient=MealIngredientList::select('ingredients')->where(['meal_id'=>$meals->id])->get();
    //     $meals->dislikeItem = DislikeItem::join('meal_ingredient_list','dislike_items.id','=','meal_ingredient_list.item_id')
    //     ->select('dislike_items.id','dislike_items.group_id','dislike_items.name')
    //     ->where('meal_ingredient_list.meal_id',$meals->id)
    //     ->where('dislike_items.status','active')->get()
    //     ->each(function($dislikeItem){
    //        $dislikeItem->selected=false;
    //        if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$dislikeItem->group_id])->first()){
    //            $dislikeItem->selected=true;
    //        }
    //    });
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


public function changeDeliveryTime(Request $request){
    
    $insert=UserSkipTimeSlot::updateOrCreate(
        ['user_id' =>  Auth::guard('api')->id(),
        'skip_date' => $request->skip_date,],
        [
            'user_id' => Auth::guard('api')->id(),
            'delivery_slot_id' => $request->delivery_slot_id,
            'user_address_id' => $request->user_address_id,
            'subscription_plan_id' => $request->subscription_plan_id,
            'skip_date' => $request->skip_date,
        ]
    );
   
    
    $this->status = true; 
    $this->message = trans('messages.time_slot_change');
    return $this->populateResponse();
}

public function userSkipDelivery(Request $request){
    
    $insert=[];
        $insert=[
            'user_id' => Auth::guard('api')->id(),
            'user_address_id' => $request->user_address_id,
            'subscription_plan_id' => $request->subscription_plan_id,
            'skip_delivery_date' => $request->skip_delivery_date,

        ];
        
    
    if($insert){
        $user=UserSkipDelivery::create($insert);
    }   
    
    $this->status = true; 
    $this->message = trans('messages.skip_delivery');
    return $this->populateResponse();
}

public function userChangeDeliveryLocation(Request $request){
    
    $insert=UserChangeDeliveryLocation::updateOrCreate(
        ['user_id' =>  Auth::guard('api')->id(),
        'change_location_for_date' => $request->change_location_for_date,],
        [
            'user_id' => Auth::guard('api')->id(),
            'user_address_id' => $request->user_address_id,
            'subscription_plan_id' => $request->subscription_plan_id,
            'change_location_for_date' => $request->change_location_for_date,
        ]
    );
   
    
    $this->status = true; 
    $this->message = trans('messages.change_location');
    return $this->populateResponse();
}

public function switchPlan(Request $request){
    
    $insert=ReplaceEditPlanRequest::updateOrCreate(
        ['user_id' =>  Auth::guard('api')->id(),
         ],
        [
            'user_id' => Auth::guard('api')->id(),
            'subscription_id' => $request->subscription_plan_id,
            'new_subscription_id' => $request->new_subscription_plan_id,
            'type' => 'replace',
        ]
    );
   
    
    $this->status = true; 
    $this->message = trans('messages.switch_plan');
    return $this->populateResponse();
}

public function swapMeal(Request $request){
    $date = $request->date;
    $old_meal_id = $request->old_meal_id;
    $new_meal_id = $request->new_meal_id;
    $plan_id = $request->subscription_plan_id;
    $meal_schedule_id = $request->meal_schedule_id;
    
    $updateOldMealDefault=[
        'is_default' => '0',
    ];
    $update = SubscriptionMealVariantDefaultMeal::where(['meal_plan_id'=>$plan_id,'date'=>$date,'item_id'=>$old_meal_id,'meal_schedule_id'=>$meal_schedule_id])->update($updateOldMealDefault);
    $updateNewMealDefault=[
        'is_default' => '1',
    ];
    $update = SubscriptionMealVariantDefaultMeal::where(['meal_plan_id'=>$plan_id,'date'=>$date,'item_id'=>$new_meal_id,'meal_schedule_id'=>$meal_schedule_id])->update($updateNewMealDefault);
   

    $this->status = true; 
    $this->message = trans('messages.swap_meal');
    return $this->populateResponse();
}


public function savedAddressListing(Request $request) {
   
        $savedAddress = UserAddress::select('*')->where('user_id',Auth::guard('api')->id())->get();

        $response = new \Lib\PopulateResponse($savedAddress);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('messages.city_list');
        return $this->populateResponse();
    }

}
