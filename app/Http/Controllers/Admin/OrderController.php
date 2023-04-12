<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Response;
use Session;
use Mail;
//use App\Http\Requests\UsersRequest as StoreRequest;
//use App\Http\Requests\UsersRequest as UpdateRequest;
//use App\Http\Controllers\CrudOverrideController;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserDislike;
use App\Models\UserChangeDeliveryLocation;
use App\Models\MealRating;
use App\Models\SubscriptionMealVariantDefaultMeal;
use App\Models\UserSkipDelivery;
use App\Models\Meal;
use App\Models\DeliverySlot;
use App\Models\UserSkipTimeSlot;
use App\Models\DislikeItem;
use App\Models\userAddress;
use App\Models\DietPlanType;
use App\Models\SubscriptionOrder;
use App\Models\SubscriptionMealPlanVariant;
use App\Models\Subscription;
use App\Models\OrderDeliverByDriver;
use App\Models\SubscriptionMealGroup;
use App\Models\MealAllocationDepartment;
use App\Models\MealWeekDay;
use App\Models\MealDepartment;
use App\Models\MealDietPlan;
use App\Models\DislikeUnit;
use App\Models\MealGroupSchedule;
use App\Models\MealMacroNutrients;
use App\Models\MealIngredientList;
use App\Models\MealSchedules;
use App\Models\MealItemOrganization;
use App\Models\Order;
use App\Models\CalorieRecommend;
use App\Models\DietPlanTypesMealCalorieMinMax;
use App\Models\SubscriptionPlan;
use App\Models\UserCaloriTarget;
use App\Models\StaffGroup;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class OrderController extends Controller {

    private $URI_PLACEHOLDER;
    private $jsondata;
    private $redirect;
    protected $message;
    protected $status;
    private $prefix;

    public function __construct() {
        // dd('aaaa');
        $this->middleware('admin');
        $this->jsondata = [];
        $this->message = false;
        $this->redirect = false;
        $this->status = false;
        $this->prefix = \DB::getTablePrefix();
        $this->URI_PLACEHOLDER = \Config::get('constants.URI_PLACEHOLDER');
    }

    public function index() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
             $user = Order::join('user_profile','orders.user_id','=','user_profile.user_id')
            ->join('users','orders.user_id','=','users.id')
            ->select('users.id','users.name','user_profile.subscription_id','user_profile.variant_id','orders.id as order_id','orders.created_at')
            ->where('orders.plan_status','plan_active')
           ->get()
           ->each(function($user){
                       $user->plans = SubscriptionMealPlanVariant::with('plan','dietPlans')
                      ->where('meal_plan_id',$user->subscription_id)
                      ->where('id',$user->variant_id)
                      ->get();
                      
                    });
                $data['orders'] = $user;
            return view('admin.order.order_list')->with($data);
        }
    }
    public function draft_order() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
             $driverDeliverOrNot = OrderDeliverByDriver::with('delivery_slot')
              ->join('users','order_delivers_by_driver.user_id','=','users.id')
              ->join('subscription_plans','order_delivers_by_driver.plan_id','=','subscription_plans.id')
              ->join('subscriptions_meal_plans_variants','order_delivers_by_driver.variant_id','=','subscriptions_meal_plans_variants.id')
            ->select('order_delivers_by_driver.*','users.name','users.id as user_id','subscription_plans.name as plan_name')
            ->where('order_delivers_by_driver.is_deliver','no')
           ->get()
           ->each(function($driverDeliverOrNot){
                       $driverDeliverOrNot->dietPlans = DietPlanType::join('subscriptions_meal_plans_variants','diet_plan_types.id','=','subscriptions_meal_plans_variants.diet_plan_id')
                       ->select('diet_plan_types.name')
                      ->where('subscriptions_meal_plans_variants.id',$driverDeliverOrNot->variant_id)
                      ->get();
                      
                    });
                   $data['cancel_orders'] = $driverDeliverOrNot;
             
            return view('admin.order.draft_order')->with($data);
        }
    }
    

    public function change_status(Request $request){
         $id = $request->input('id');
         $status = $request->input('action');
        $update = Subscription::find($id)->update(['status' => $status]);
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
        }
    }

    public function change_previousPlan_status(Request $request){
        $id = $request->input('id');
        $status = $request->input('action');
       $update = Subscription::find($id)->update(['status' => $status]);
       if ($update) {
           return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
       } else {
           return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
       }
   }
   

   public function show(Request $request, $id = null) {
     if (Auth::guard('admin')->check()) {
             $id = base64_decode($id);     
           $user = User::where('id',$id)->first();   
          if($user){
            $user_detail = UserProfile::with('fitness','dietplan')->where('user_id',$user->id)->first();
            $userCalorieTarget = UserCaloriTarget::where('user_id',$user->id)->first(); 
            $calorie = CalorieRecommend::select('recommended')->where('id',$userCalorieTarget->custom_result_id)->first(); 
            if(!empty($calorie)){
               $UserGainCalorie = DietPlanTypesMealCalorieMinMax::where('meal_calorie',$calorie->recommended)->where('diet_plan_type_id',$user_detail->diet_plan_type_id)->first();
            }
              $item_id = UserDislike::where('user_id',$user->id)->get();
            if($item_id){
             foreach($item_id as $item_ids){
                   $user_dislikes = DislikeItem::where('id',$item_ids['item_id'])->get();
                   if($user_dislikes){
                      $data['user_dislike'] = $user_dislikes;
                   }else{
                     $data['user_dislike'] = '';
                   }
                     // array_push($user_dislikes,$user_dislike);
             }
            }
     }else{
         
     } 
     
      $getUserSubscriptionId = UserProfile::select('subscription_id','variant_id')->where('user_id',$id)->first();
     if($getUserSubscriptionId){
         $subscription = SubscriptionPlan::select('id','name','image')->where('id',$getUserSubscriptionId->subscription_id)->where('status','active')->first();
         if($subscription){
             $subscription->start_date = Subscription::where('user_id',$id)->where(['plan_id'=> $getUserSubscriptionId->subscription_id,'variant_id'=> $getUserSubscriptionId->variant_id,'plan_status'=>'plan_active'])->first();
            if(SubscriptionMealPlanVariant::where(['meal_plan_id'=>$getUserSubscriptionId->subscription_id,'id'=>$getUserSubscriptionId->variant_id])->first()){

                 $costs=SubscriptionMealPlanVariant::where(['meal_plan_id'=>$getUserSubscriptionId->subscription_id,'id'=>$getUserSubscriptionId->variant_id])->first();
                $subscription->cost=$costs->plan_price;
                $subscription->day=$costs->option1;
                $subscription->no_days=$costs->no_days;

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
         $data['subscription'] = $subscription;
          $data['user'] = $user;
           $data['user_details'] = $user_detail;
            $data['userCalorieTargets'] = $UserGainCalorie;

          $date = Carbon::createFromFormat('Y-m-d', $subscription->start_date->start_date);
         //  $date = Carbon::now();
        //   for ($i = 0; $i < $costs->no_days; $i++) {
        //        $alldate = $date->addDay()->format('y-m-d');
        //        array_push($dates, $alldate);
        //   }
     
        //  $datess = array_unique($dates);
                // dd($datess);
        // $data['datee'] = $datess;
 
        // $dates = '2023-02-21';
        $dates = [];
        for ($i = 0; $i < $costs->no_days; $i++) {
             $datess = $date->addDay()->format('Y-m-d');
            $dates[] = DB::table('subscription_meal_plan_variant_default_meal')->select('date')->where('is_default','1')->where(['meal_plan_id'=>$getUserSubscriptionId->subscription_id])->where('date',$datess)->groupBy('date')->get()
            ->each(function($dates)use($id){
               
            $day = \Carbon\Carbon::parse($dates->date)->format('l');
           
            $getAllDays = UserAddress::where('user_id',$id)->where('day_selection_status','active')->get();
         if($day == 'Monday'){
             $var = "1";
         }elseif($day == 'Tuesday'){
             $var = '2';
         }elseif($day == 'Wednesday'){
            $var = '3';
        }elseif($day == 'Thursday'){
            $var = '4';
        }elseif($day == 'Friday'){
            $var = '5';
        }elseif($day == 'Saturday'){
            $var = '6';
        }else{
            $var = '7';
        }
    
    //    return  $custom_calorie = $request->custom_calorie;
          $checkPlan = UserProfile::select('id','subscription_id','diet_plan_type_id','variant_id')->where('user_id',$id)->first();
           $start_date = Subscription::select('start_date','end_date','delivery_status','user_id')->where(['plan_id'=>$checkPlan->subscription_id,'variant_id'=>$checkPlan->variant_id,'delivery_status'=>'active','plan_status'=>'plan_active','user_id'=>$id])->orWhere('delivery_status','paused')->first();
          $option22 = SubscriptionMealPlanVariant::select('no_days','option2','calorie')->where(['meal_plan_id'=>$checkPlan->subscription_id,'id'=>$checkPlan->variant_id])->first();
           $custom_calorie = $option22->calorie;
           $getStartDate = Carbon::createFromFormat('Y-m-d',$start_date->start_date);
          $getEndDate = Carbon::createFromFormat('Y-m-d',$start_date->end_date);
           $no_of_day = $getStartDate->diffInDays($getEndDate); 
         
         if(!empty($no_of_day))
         {
    
             $countSkip = UserSkipDelivery::where('user_id',Auth::guard('api')->id())->where(['subscription_plan_id'=>$checkPlan->subscription_id,'variant_id'=>$checkPlan->variant_id])->count();
              $no_of_days = $no_of_day + $countSkip;
         }
    
        if(UserChangeDeliveryLocation::where('user_id',$id)->where(['subscription_plan_id'=>$checkPlan->subscription_id,'variant_id'=>$checkPlan->variant_id])->where('change_location_for_date',$dates->date)->exists()){
             $deliverie = userAddress::join('user_change_delivery_location','user_address.id','=','user_change_delivery_location.user_address_id')
            // ->join('delivery_slots','user_address.delivery_slot_id','=','delivery_slots.id')
            ->select('user_address.address_type','user_address.id')
            ->where('user_change_delivery_location.user_id',$id)
             ->where('user_change_delivery_location.change_location_for_date',$dates->date)
             ->where('user_change_delivery_location.subscription_plan_id',$checkPlan->subscription_id)
             ->where('user_change_delivery_location.variant_id',$checkPlan->variant_id)
            ->first();
    
            if(UserSkipTimeSlot::where('user_id',$id)->where(['subscription_plan_id'=>$checkPlan->subscription_id,'variant_id'=>$checkPlan->variant_id])->where('skip_date',$dates->date)->exists()){
    
                $deliveries_slot = UserSkipTimeSlot::join('delivery_slots','user_skip_time_slot.delivery_slot_id','=','delivery_slots.id')
               ->join('user_address','user_skip_time_slot.user_address_id','=','user_address.id')
               ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.id','delivery_slots.name','delivery_slots.id as slot_id')
               ->where('user_skip_time_slot.skip_date',$dates->date)
                ->where('user_skip_time_slot.user_id',$id)
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
            ->where('user_change_delivery_location.user_id',$id)
             ->where('user_change_delivery_location.change_location_for_date',$dates->date)
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
            if(UserSkipTimeSlot::where('user_id',$id)->where(['subscription_plan_id'=>$checkPlan->subscription_id,'variant_id'=>$checkPlan->variant_id])->where('skip_date',$dates->date)->exists()){
        
                  $deliverie = UserSkipTimeSlot::join('delivery_slots','user_skip_time_slot.delivery_slot_id','=','delivery_slots.id')
                // ->join('user_address','user_skip_time_slot.user_address_id','=','user_address.id')
                ->select('delivery_slots.start_time','delivery_slots.end_time','delivery_slots.name','delivery_slots.id as slot_id')
                ->where('user_skip_time_slot.skip_date',$dates->date)
                 ->where('user_skip_time_slot.user_id',$id)
                 ->where('user_skip_time_slot.subscription_plan_id',$checkPlan->subscription_id)
                 ->where('user_skip_time_slot.variant_id',$checkPlan->variant_id)
                ->first();
                    $deliveries = userAddress::
                    select('user_address.id','user_address.address_type')
                    ->where('user_id',$id)
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
                 $dates->deliveries = DeliverySlot::join('user_address','delivery_slots.id','=','user_address.delivery_slot_id')
            ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.id','delivery_slots.name','delivery_slots.id as slot_id','user_address.address_type')
            ->where('user_id',$id)
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
          if(UserSkipDelivery::where('user_id',$id)->where(['subscription_plan_id'=>$checkPlan->subscription_id,'variant_id'=>$checkPlan->variant_id])->where('skip_delivery_date',$dates->date)->exists())
          {
            $dates->category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$checkPlan->subscription_id])
            ->get()
            ->each(function($category){
                $category->meal_group->meals = ["you skip your delivery for this date"];
                
            })->toArray();
            $data['category'] = $category;
            $data['skip_status'] = "you skip your delivery for this date";
           }else{
             $dates->category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$checkPlan->subscription_id])
           ->get()
           ->each(function($category) use($dates,$checkPlan,$custom_calorie,$id){
            
            $category->meal_group->meals =Meal::
            join('subscription_meal_plan_variant_default_meal','meals.id','subscription_meal_plan_variant_default_meal.item_id')
            ->join('meal_macro_nutrients','meals.id','=','meal_macro_nutrients.meal_id')
            // ->select('meals.*')
            ->select('meals.name','meals.name_ar','meals.side_dish','meals.side_dish_ar','meals.image','meals.id','meals.food_type','meal_macro_nutrients.meal_calorie','meal_macro_nutrients.protein','meal_macro_nutrients.carbs','meal_macro_nutrients.fat')
             ->where('subscription_meal_plan_variant_default_meal.meal_schedule_id',$category->meal_group->id)
            // ->whereDate('meals.created_at','=', date('Y-m-d', strtotime($dates)))
            ->whereDate('subscription_meal_plan_variant_default_meal.date','=', date('Y-m-d', strtotime($dates->date)))
            ->where(['subscription_meal_plan_variant_default_meal.meal_plan_id'=> $checkPlan->subscription_id,'meals.status'=>'active'])
             ->where('subscription_meal_plan_variant_default_meal.is_default','1')
             ->where('meal_macro_nutrients.user_calorie',$custom_calorie)
            ->get()->each(function($meals) use($id){
            
                // $meals->ingredient= ['onion','tomato','carrot', 'chilli'];
        
            $meals->dislikeItem = DislikeItem::join('meal_ingredient_list','dislike_items.id','=','meal_ingredient_list.item_id')
            ->select('dislike_items.id','dislike_items.group_id','dislike_items.name')
            ->where('meal_ingredient_list.meal_id',$meals->id)
            ->where('dislike_items.status','active')->get()
            ->each(function($dislikeItem) use($id){
               $dislikeItem->selected=false;
               if(UserDislike::where(['user_id'=>$id,'item_id'=>$dislikeItem->group_id])->first()){
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
    })->toArray();
   
    // dd($proteinAddition);
    $data['skip_status'] = "";
    // return $data['category'] = $category;

      }
      $data['diet_plan_type_id'] = $checkPlan->diet_plan_type_id;
      $data['subscription_id'] = $checkPlan->subscription_id;
      $data['start_date'] = $start_date;
      $data['withoutOrWithweekend'] = $option22->option2;
      $data['no_of_days'] = $no_of_days;
    })->toArray();
}
$data['getDatess'] = $dates;

// foreach($dates as $datesss){
//     foreach($datesss as $f){
//         foreach($f->category as $f){
//    $dd[] = $f->date;
//     }
//     }
// }
// dd($dates);
// die;

 
       return view('admin.order.order_detail')->with($data);
         
     } else {
         return redirect()->intended('admin/login');
     }
 }



 
 public function previousPlanShow(Request $request, $id = null,$plan_id = null) {
    if (Auth::guard('admin')->check()) {
          $id = $request->id;  
          $plan_id = $request->plan_id; 
          $variant_id = $request->variant_id;  
          $user = User::where('id',$id)->first();   
         if($user){
            $user_detail = UserProfile::with('fitness','dietplan')->where('user_id',$user->id)->first();
            $userCalorieTarget = UserCaloriTarget::where('user_id',$user->id)->first(); 
            $calorie = CalorieRecommend::select('recommended')->where('id',$userCalorieTarget->custom_result_id)->first(); 
            if(!empty($calorie)){
                $UserGainCalorie = DietPlanTypesMealCalorieMinMax::where('meal_calorie',$calorie->recommended)->where('diet_plan_type_id',$user_detail->diet_plan_type_id)->first();
            }
            $item_id = UserDislike::where('user_id',$user->id)->get();
           if($item_id){
               foreach($item_id as $item_ids){
                  $user_dislikes = DislikeItem::where('id',$item_ids['item_id'])->get();
                  if($user_dislikes){
                      $data['user_dislike'] = $user_dislikes;
                    }else{
                      $data['user_dislike'] = '';
                    }
                    // array_push($user_dislikes,$user_dislike);
               }
            }
        }else{
        
         } 
    
        $subscription = SubscriptionPlan::select('id','name','image')->where('id',$plan_id)->where('status','active')->first();
        if($subscription){
            $subscription->start_date = Subscription::where('user_id',$id)->where('plan_id',$plan_id)->first();
           if(SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id,'id'=>$variant_id])->first()){
             $costs=SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id,'id'=>$variant_id])->first();
               $subscription->cost=$costs->plan_price;
               $subscription->day=$costs->option1;
               $subscription->no_days=$costs->no_days;
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


        $date = Carbon::createFromFormat('Y-m-d', $subscription->start_date->start_date);
        //  $date = Carbon::now();
       //   for ($i = 0; $i < $costs->no_days; $i++) {
       //        $alldate = $date->addDay()->format('y-m-d');
       //        array_push($dates, $alldate);
       //   }
    
       //  $datess = array_unique($dates);
               // dd($datess);
       // $data['datee'] = $datess;

       // $dates = '2023-02-21';
       $dates = [];
       for ($i = 0; $i < $costs->no_days; $i++) {
           $datess = $date->addDay()->format('y-m-d');
           $dates[] = DB::table('subscription_meal_plan_variant_default_meal')->select('date')->where('is_default','1')->where(['meal_plan_id'=>$plan_id])->where('date',$datess)->groupBy('date')->get()
           ->each(function($dates)use($id,$plan_id,$variant_id){
              $dates->dd = "gfgd";
       
           $day = \Carbon\Carbon::parse($dates->date)->format('l');
          $getAllDays = UserAddress::where('user_id',$id)->where('day_selection_status','active')->get();
        if($day == 'Monday'){
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
   
   //    return  $custom_calorie = $request->custom_calorie;
        //  $checkPlan = UserProfile::select('id','subscription_id','diet_plan_type_id','variant_id')->where('user_id',$id)->first();
          $start_date = Subscription::select('start_date','end_date','delivery_status')->where(['plan_id'=>$plan_id,'variant_id'=>$variant_id,'delivery_status'=>'terminted','plan_status'=>'plan_inactive','user_id'=>$id])->first();
         $option22 = SubscriptionMealPlanVariant::select('no_days','option2','calorie')->where(['meal_plan_id'=>$plan_id,'id'=>$variant_id])->first();
          $custom_calorie = $option22->calorie;
          $getStartDate = Carbon::createFromFormat('Y-m-d',$start_date->start_date);
         $getEndDate = Carbon::createFromFormat('Y-m-d',$start_date->end_date);
          $no_of_day = $getStartDate->diffInDays($getEndDate); 
        if(!empty($no_of_day))
        {
   
            $countSkip = UserSkipDelivery::where('user_id',$id)->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->count();
             $no_of_days = $no_of_day + $countSkip;
        }
   
       if(UserChangeDeliveryLocation::where('user_id',$id)->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('change_location_for_date',$dates->date)->exists()){
            $deliverie = userAddress::join('user_change_delivery_location','user_address.id','=','user_change_delivery_location.user_address_id')
           // ->join('delivery_slots','user_address.delivery_slot_id','=','delivery_slots.id')
           ->select('user_address.address_type','user_address.id')
           ->where('user_change_delivery_location.user_id',$id)
            ->where('user_change_delivery_location.change_location_for_date',$dates->date)
            ->where('user_change_delivery_location.subscription_plan_id',$plan_id)
            ->where('user_change_delivery_location.variant_id',$variant_id)
           ->first();
   
           if(UserSkipTimeSlot::where('user_id',$id)->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('skip_date',$dates->date)->exists()){
   
               $deliveries_slot = UserSkipTimeSlot::join('delivery_slots','user_skip_time_slot.delivery_slot_id','=','delivery_slots.id')
              ->join('user_address','user_skip_time_slot.user_address_id','=','user_address.id')
              ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.id','delivery_slots.name','delivery_slots.id as slot_id')
              ->where('user_skip_time_slot.skip_date',$dates->date)
               ->where('user_skip_time_slot.user_id',$id)
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
           ->where('user_change_delivery_location.user_id',$id)
            ->where('user_change_delivery_location.change_location_for_date',$dates->date)
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
           if(UserSkipTimeSlot::where('user_id',$id)->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('skip_date',$dates->date)->exists()){
       
                 $deliverie = UserSkipTimeSlot::join('delivery_slots','user_skip_time_slot.delivery_slot_id','=','delivery_slots.id')
               // ->join('user_address','user_skip_time_slot.user_address_id','=','user_address.id')
               ->select('delivery_slots.start_time','delivery_slots.end_time','delivery_slots.name','delivery_slots.id as slot_id')
               ->where('user_skip_time_slot.skip_date',$dates->date)
                ->where('user_skip_time_slot.user_id',$id)
                ->where('user_skip_time_slot.subscription_plan_id',$plan_id)
                ->where('user_skip_time_slot.variant_id',$variant_id)
               ->first();
                   $deliveries = userAddress::
                   select('user_address.id','user_address.address_type')
                   ->where('user_id',$id)
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
           ->where('user_id',$id)
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
         if(UserSkipDelivery::where('user_id',$id)->where(['subscription_plan_id'=>$plan_id,'variant_id'=>$variant_id])->where('skip_delivery_date',$dates->date)->exists())
         {
           $dates->category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$plan_id])
           ->get()
           ->each(function($category)use($plan_id,$variant_id){
               $category->meal_group->meals = ["you skip your delivery for this date"];
               
           })->toArray();
           $data['category'] = $category;
           $data['skip_status'] = "you skip your delivery for this date";
          }else{
           $dates->category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$plan_id])
          ->get()
          ->each(function($category) use($dates,$plan_id,$custom_calorie,$id,$variant_id){
           
           $category->meal_group->meals =Meal::
           join('subscription_meal_plan_variant_default_meal','meals.id','subscription_meal_plan_variant_default_meal.item_id')
           ->join('meal_macro_nutrients','meals.id','=','meal_macro_nutrients.meal_id')
           // ->select('meals.*')
           ->select('meals.name','meals.name_ar','meals.side_dish','meals.side_dish_ar','meals.image','meals.id','meals.food_type','meal_macro_nutrients.meal_calorie','meal_macro_nutrients.protein','meal_macro_nutrients.carbs','meal_macro_nutrients.fat')
            ->where('subscription_meal_plan_variant_default_meal.meal_schedule_id',$category->meal_group->id)
           // ->whereDate('meals.created_at','=', date('Y-m-d', strtotime($dates)))
           ->whereDate('subscription_meal_plan_variant_default_meal.date','=', date('Y-m-d', strtotime($dates->date)))
           ->where(['subscription_meal_plan_variant_default_meal.meal_plan_id'=> $plan_id,'meals.status'=>'active'])
            ->where('subscription_meal_plan_variant_default_meal.is_default','1')
            ->where('meal_macro_nutrients.user_calorie',$custom_calorie)
           ->get()->each(function($meals) use($id){
           
               // $meals->ingredient= ['onion','tomato','carrot', 'chilli'];
       
           $meals->dislikeItem = DislikeItem::join('meal_ingredient_list','dislike_items.id','=','meal_ingredient_list.item_id')
           ->select('dislike_items.id','dislike_items.group_id','dislike_items.name')
           ->where('meal_ingredient_list.meal_id',$meals->id)
           ->where('dislike_items.status','active')->get()
           ->each(function($dislikeItem) use($id){
              $dislikeItem->selected=false;
              if(UserDislike::where(['user_id'=>$id,'item_id'=>$dislikeItem->group_id])->first()){
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
   })->toArray();
  
   // dd($proteinAddition);
   $data['skip_status'] = "";
   // return $data['category'] = $category;

     }
     $data['subscription_id'] = $plan_id;
     $data['start_date'] = $start_date;
     $data['withoutOrWithweekend'] = $option22->option2;
     $data['no_of_days'] = $no_of_days;
   })->toArray();
}

$data['getDatess'] = $dates;
// dd($dates);
// die;
   
     $data['subscription'] = $subscription;
     $data['user'] = $user;
     $data['user_details'] = $user_detail;
     $data['userCalorieTargets'] = $UserGainCalorie;
      return view('admin.order.order_detail1')->with($data);
        
    } else {
        return redirect()->intended('admin/login');
    }
}



public function updateDeliveryStatus(Request $request, $id = NULL){
    $id = $request->input('id');
   $update = Order::find($id)->update(['status' => 'delivered']);
   if ($update) {
       return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
   } else {
       return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
   }
}


public function filter_list(Request $request) {
    $start_date = date('Y-m-d', strtotime($request->input('start_date')));
    $end_date = date('Y-m-d', strtotime($request->input('end_date')));
    if ($request->input('start_date') && $request->input('end_date')) {
                $driverDeliverOrNot = OrderDeliverByDriver::with('delivery_slot')
                ->join('users','order_delivers_by_driver.user_id','=','users.id')
                ->join('subscription_plans','order_delivers_by_driver.plan_id','=','subscription_plans.id')
                ->join('subscriptions_meal_plans_variants','order_delivers_by_driver.variant_id','=','subscriptions_meal_plans_variants.id')
              ->select('order_delivers_by_driver.*','users.name','users.id as user_id','subscription_plans.name as plan_name')
              ->where('order_delivers_by_driver.is_deliver','no')
              ->whereBetween('cancel_or_delivery_date', [$start_date, $end_date])
             ->get()
             ->each(function($driverDeliverOrNot){
                         $driverDeliverOrNot->dietPlans = DietPlanType::join('subscriptions_meal_plans_variants','diet_plan_types.id','=','subscriptions_meal_plans_variants.diet_plan_id')
                         ->select('diet_plan_types.name')
                        ->where('subscriptions_meal_plans_variants.id',$driverDeliverOrNot->variant_id)
                        ->get();
                        
                      });
    } else {
        $driverDeliverOrNot = OrderDeliverByDriver::with('delivery_slot')
              ->join('users','order_delivers_by_driver.user_id','=','users.id')
              ->join('subscription_plans','order_delivers_by_driver.plan_id','=','subscription_plans.id')
              ->join('subscriptions_meal_plans_variants','order_delivers_by_driver.variant_id','=','subscriptions_meal_plans_variants.id')
            ->select('order_delivers_by_driver.*','users.name','users.id as user_id','subscription_plans.name as plan_name')
            ->where('order_delivers_by_driver.is_deliver','no')
           ->get()
           ->each(function($driverDeliverOrNot){
                       $driverDeliverOrNot->dietPlans = DietPlanType::join('subscriptions_meal_plans_variants','diet_plan_types.id','=','subscriptions_meal_plans_variants.diet_plan_id')
                       ->select('diet_plan_types.name')
                      ->where('subscriptions_meal_plans_variants.id',$driverDeliverOrNot->variant_id)
                      ->get();
                      
                    });
              
    }

    $data['cancel_orders'] = $driverDeliverOrNot;
    return view('admin.order.draft_order')->with($data);
}

public function get_draftData(Request $request, $id=NULL)
    {
        
        
        if($request->ajax()){
             $clients = OrderDeliverByDriver::with('delivery_slot')
            ->join('users','order_delivers_by_driver.user_id','=','users.id')
            ->join('subscription_plans','order_delivers_by_driver.plan_id','=','subscription_plans.id')
            ->join('subscriptions_meal_plans_variants','order_delivers_by_driver.variant_id','=','subscriptions_meal_plans_variants.id')
          ->select('order_delivers_by_driver.*','users.name','users.id as user_id','subscription_plans.name as plan_name','subscription_plans.id as plan_id','subscriptions_meal_plans_variants.id as variant_id')
          ->where('order_delivers_by_driver.is_deliver','no')
          ->where('order_delivers_by_driver.id',$request->id)
         ->first();
         if($clients){
              $dietPlans = DietPlanType::join('subscriptions_meal_plans_variants','diet_plan_types.id','=','subscriptions_meal_plans_variants.diet_plan_id')
            ->select('diet_plan_types.name')
           ->where('subscriptions_meal_plans_variants.id',$clients->variant_id)
           ->first();
         }
        $returnHTML =view('admin.order.update_draft_order', compact('clients','dietPlans'))->render();
        return response()->json(['html'=>$returnHTML]);

             
        }
     }

     public function edit_update($id,Request $request){
         $plan_id = $request->plan_id;
          $variant_id = $request->variant_id;
          $user_id = $request->user_id;

        $get_end_date = Subscription::select('end_date')->where(['variant_id'=>$variant_id,'plan_id'=>$plan_id,'user_id'=>$user_id,'delivery_status'=>'active','plan_status'=>'plan_active'])->first();
         $check_plan_weekend = SubscriptionMealPlanVariant::select('option2')->where(['id'=>$variant_id,'meal_plan_id'=>$plan_id])->first();
          if(!empty($check_plan_weekend->option2 == 'withoutweekend')){
              $datess = Carbon::createFromFormat('Y-m-d',$get_end_date->end_date);
               $nextDayDate = $datess->addDays('+1');
              $day = strtolower($nextDayDate->format('l'));
               if($day == 'friday' || $day == 'saturady'){
                   if($day == 'friday'){
                      $end_date = $datess->addDays('+2');
                   }else{
                      $end_date = $datess->addDays('+1');
                    }
                }else{
                        $end_date = $nextDayDate; 
                    }
            }else{
                $end_date = $request->addOn_date;
            }

            Subscription::where(['variant_id'=>$variant_id,'plan_id'=>$plan_id,'user_id'=>$user_id,'delivery_status'=>'active','plan_status'=>'plan_active'])
            ->update(['end_date'=>$end_date]);
       
        return redirect()->back()->with('success','date update successfully');
    }

    public function edit_draft_order(Request $request, $id=NULL) {
      
             $id = base64_decode($request->id); 
              $clients = OrderDeliverByDriver::with('delivery_slot')
            ->join('users','order_delivers_by_driver.user_id','=','users.id')
            ->join('subscription_plans','order_delivers_by_driver.plan_id','=','subscription_plans.id')
            ->join('subscriptions_meal_plans_variants','order_delivers_by_driver.variant_id','=','subscriptions_meal_plans_variants.id')
          ->select('order_delivers_by_driver.*','users.name','users.id as user_id','subscription_plans.name as plan_name','subscription_plans.id as plan_id','subscriptions_meal_plans_variants.id as variant_id','subscriptions_meal_plans_variants.option2','subscriptions_meal_plans_variants.calorie')
          ->where('order_delivers_by_driver.is_deliver','no')
          ->where('order_delivers_by_driver.id',$id)
         ->first();
         if($clients){
               $dietPlans = DietPlanType::join('subscriptions_meal_plans_variants','diet_plan_types.id','=','subscriptions_meal_plans_variants.diet_plan_id')
            ->select('diet_plan_types.name')
           ->where('subscriptions_meal_plans_variants.id',$clients->variant_id)
           ->first();

            $subscription_detail = Subscription::where(['user_id'=>$clients->user_id,'plan_id'=>$clients->plan_id,'variant_id'=>$clients->variant_id])->where(['delivery_status'=>'active','plan_status'=>'plan_active'])->first();
            
              $category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$clients->plan_id])
            ->get()
            ->each(function($category) use($clients){
             $category->meal_group->meals =Meal::
             join('subscription_meal_plan_variant_default_meal','meals.id','subscription_meal_plan_variant_default_meal.item_id')
             ->join('meal_macro_nutrients','meals.id','=','meal_macro_nutrients.meal_id')
             // ->select('meals.*')
             ->select('meals.name','meals.name_ar','meals.side_dish','meals.side_dish_ar','meals.image','meals.id','meals.food_type','meal_macro_nutrients.meal_calorie','meal_macro_nutrients.protein','meal_macro_nutrients.carbs','meal_macro_nutrients.fat')
              ->where('subscription_meal_plan_variant_default_meal.meal_schedule_id',$category->meal_group->id)
             // ->whereDate('meals.created_at','=', date('Y-m-d', strtotime($dates)))
             ->whereDate('subscription_meal_plan_variant_default_meal.date','=', date('Y-m-d', strtotime($clients->cancel_or_delivery_date)))
             ->where(['subscription_meal_plan_variant_default_meal.meal_plan_id'=> $clients->plan_id,'meals.status'=>'active'])
              ->where('subscription_meal_plan_variant_default_meal.is_default','1')
              ->where('meal_macro_nutrients.user_calorie',$clients->calorie)
             ->get();
            });
         }      
       
            return view('admin.order.draft_order_edit',compact('clients','dietPlans','subscription_detail','category'));
        }
    

public function export(Request $request)
{
    //  $users = User::all();
     $users = Order::join('user_profile','orders.user_id','=','user_profile.user_id')
    ->join('users','orders.user_id','=','users.id')
    ->select('users.id','users.name','user_profile.subscription_id','user_profile.variant_id','orders.id as order_id','orders.created_at')
    ->where('orders.plan_status','plan_active')
   ->get()
   ->each(function($users){
               $users->plans = SubscriptionMealPlanVariant::with('plan','dietPlans')
              ->where('meal_plan_id',$users->subscription_id)
              ->where('id',$users->variant_id)
              ->get();
              
            });

    return Excel::download(new OrdersExport($users), 'orders.xlsx');
}

public function print()
{
    // retrieve the user data that you want to print
     $users = Order::join('user_profile','orders.user_id','=','user_profile.user_id')
    ->join('users','orders.user_id','=','users.id')
    ->select('users.id','users.name','user_profile.subscription_id','user_profile.variant_id','orders.id as order_id','orders.created_at')
    ->where('orders.plan_status','plan_active')
   ->get()
   ->each(function($users){
               $users->plans = SubscriptionMealPlanVariant::with('plan','dietPlans')
              ->where('meal_plan_id',$users->subscription_id)
              ->where('id',$users->variant_id)
              ->get();
              
            });
    
    // return a view that displays the user data in a printable format
    return view('admin.order.print', compact('users'));
}

}
