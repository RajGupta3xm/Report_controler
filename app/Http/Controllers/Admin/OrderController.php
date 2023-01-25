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
             $user = UserProfile::join('users','user_profile.user_id','=','users.id')
            ->join('orders','user_profile.user_id','=','orders.user_id')
            ->select('users.id','users.name','user_profile.subscription_id','orders.id as order_id','orders.created_at')
           ->get()
           ->each(function($user){
                       $user->plans = SubscriptionMealPlanVariant::with('plan','dietPlans')
                      ->where('meal_plan_id',$user->subscription_id)->get();
                      
                    });
            //  $user = User::select('id','name')->where('status','1')->get()
            //  ->each(function($user){
            //      $user->order = SubscriptionOrder::join('subscriptions','subscription_orders.subscription_id','=','subscriptions.id')
            //      ->select('subscription_orders.id as order_id','subscription_orders.created_at','subscription_orders.amount','subscriptions.plan_id')
            //      ->where('subscription_orders.user_id',$user->id)
            //      ->get()
            //      ->each(function($order){
            //            $order->plans = SubscriptionMealPlanVariant::with('plan','dietPlans')
            //            ->where('meal_plan_id',$order->plan_id)->get();
                      
            //         });
            //  });
              

                $data['orders'] = $user;
            return view('admin.order.order_list')->with($data);
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
     
      $getUserSubscriptionId = UserProfile::select('subscription_id')->where('user_id',$id)->first();
     if($getUserSubscriptionId){
         $subscription = SubscriptionPlan::select('id','name','image')->where('id',$getUserSubscriptionId->subscription_id)->where('status','active')->first();
         if($subscription){
             $subscription->start_date = Subscription::where('user_id',$id)->where('plan_id',$getUserSubscriptionId->subscription_id)->first();
            if(SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id])->first()){

                 $costs=SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id])->first();
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


        $dates = [];
        $date = Carbon::createFromFormat('Y-m-d', $subscription->start_date->start_date);
         //  $date = Carbon::now();
          for ($i = 0; $i < $costs->no_days; $i++) {
               $alldate = $date->addDay()->format('y-m-d');
               array_push($dates, $alldate);
          }
         //   dd($dates);
        $data['datee'] = $dates;
 
 
     // $dates = '2023-01-20';
    $getDate = DB::table('subscription_meal_plan_variant_default_meal')->select('date')->where('meal_plan_id',$getUserSubscriptionId->subscription_id)->where('is_default','1')->groupBy('date')->get()
   ->each(function($getDate)use($id){
     $customCalorie = UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
     ->select('calorie_recommend.recommended')
     ->where('user_id',$id)
     ->first();
     if(!empty($customCalorie))
    {
     $custom_calorie = $customCalorie->recommended;
    }    
    else{
     $custom_calorie = '';
    }
    $checkPlan = UserProfile::select('id','subscription_id','diet_plan_type_id')->where('user_id',$id)->first();
    $start_date = Subscription::select('start_date')->where('plan_id',$checkPlan->subscription_id)->where('user_id',$id)->first();
     $no_of_days = SubscriptionMealPlanVariant::select('no_days')->where('meal_plan_id',$checkPlan->subscription_id)->first();
     if(UserChangeDeliveryLocation::where('user_id',$id)->where('subscription_plan_id',$checkPlan->subscription_id)->where('change_location_for_date',$getDate->date)->exists()){
         $deliveries = userAddress::join('user_change_delivery_location','user_address.id','=','user_change_delivery_location.user_address_id')
        ->join('delivery_slots','user_address.delivery_slot_id','=','delivery_slots.id')
        ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.address_type','user_address.id','delivery_slots.name','delivery_slots.id as slot_id')
        ->where('user_change_delivery_location.user_id',$id)
         ->where('user_change_delivery_location.change_location_for_date',$getDate->date)
         ->where('user_change_delivery_location.subscription_plan_id',$checkPlan->subscription_id)
        ->first();
    }else{
        if(UserSkipTimeSlot::where('user_id',$id)->where('subscription_plan_id',$checkPlan->subscription_id)->where('skip_date',$getDate->date)->exists()){
    
             $deliveries = UserSkipTimeSlot::join('delivery_slots','user_skip_time_slot.delivery_slot_id','=','delivery_slots.id')
            ->join('user_address','user_skip_time_slot.user_address_id','=','user_address.id')
            ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.id','delivery_slots.name','delivery_slots.id as slot_id','user_address.address_type')
            ->where('user_skip_time_slot.skip_date',$getDate->date)
             ->where('user_skip_time_slot.user_id',$id)
             ->where('user_skip_time_slot.subscription_plan_id',$checkPlan->subscription_id)
            ->first();
        }else{
             $deliveries = DeliverySlot::join('user_address','delivery_slots.id','=','user_address.delivery_slot_id')
        ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.id','delivery_slots.name','delivery_slots.id as slot_id','user_address.address_type')
        ->where('user_id',$id)
        ->first();
      }
  }
 
  if(UserSkipDelivery::where('user_id',$id)->where('subscription_plan_id',$checkPlan->subscription_id)->where('skip_delivery_date',$getDate->date)->exists())
  {
     $getDate->category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$checkPlan->subscription_id])
    ->get()
    ->each(function($category){
        $category->meal_group->meals = ["you skip your delivery for this date"];
        
    })->toArray();
     $data['category'] = $category;
    $data['skip_status'] = "you skip your delivery for this date";
   }else{
     $getDate->category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$checkPlan->subscription_id])
    ->get()
    ->each(function($category) use($getDate,$checkPlan,$custom_calorie,$id){
    
     $category->meal_group->meals =Meal::
     join('subscription_meal_plan_variant_default_meal','meals.id','subscription_meal_plan_variant_default_meal.item_id')
     ->join('meal_macro_nutrients','meals.id','=','meal_macro_nutrients.meal_id')
     // ->select('meals.*')
     ->select('meals.name','meals.name_ar','meals.side_dish','meals.side_dish_ar','meals.image','meals.id','meals.food_type','meal_macro_nutrients.meal_calorie','meal_macro_nutrients.protein','meal_macro_nutrients.carbs','meal_macro_nutrients.fat')
      ->where('subscription_meal_plan_variant_default_meal.meal_schedule_id',$category->meal_group->id)
     // ->whereDate('meals.created_at','=', date('Y-m-d', strtotime($dates)))
     ->whereDate('subscription_meal_plan_variant_default_meal.date','=', date('Y-m-d', strtotime($getDate->date)))
     ->where(['subscription_meal_plan_variant_default_meal.meal_plan_id'=> $checkPlan->subscription_id,'meals.status'=>'active'])
      ->where('subscription_meal_plan_variant_default_meal.is_default','1')
      ->where('meal_macro_nutrients.user_calorie',$custom_calorie)
     ->get()->each(function($meals)use($id) {
     
         // $meals->ingredient= ['onion','tomato','carrot', 'chilli'];
 
     $meals->dislikeItem = DislikeItem::join('meal_ingredient_list','dislike_items.id','=','meal_ingredient_list.item_id')
     ->select('dislike_items.id','dislike_items.group_id','dislike_items.name')
     ->where('meal_ingredient_list.meal_id',$meals->id)
     ->where('dislike_items.status','active')->get()
     ->each(function($dislikeItem)use($id){
        $dislikeItem->selected=false;
        if(UserDislike::where(['user_id'=>$id,'item_id'=>$dislikeItem->group_id])->first()){
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
 
 // dd($proteinAddition);
 $data['skip_status'] = "";
  
 
 }
   })->toArray();
  //dd($getDate);
    // dd($getDate['date']);

        $data['getDatess'] = $getDate;
//   $dd =[];
//       foreach($getDate as $getDatess){
       
//         $d = $getDatess->date;
//         array_push($dd,$d);
//     }
//       dd($dd);
      }
    
     
          
     $data['subscription'] = $subscription;
      $data['user'] = $user;
      $data['user_details'] = $user_detail;
     
      $data['userCalorieTargets'] = $userCalorieTarget;
       return view('admin.order.order_detail')->with($data);
         
     } else {
         return redirect()->intended('admin/login');
     }
 }



 
 public function previousPlanShow(Request $request, $id = null,$plan_id = null) {
    if (Auth::guard('admin')->check()) {
           $id = $request->id;  
           $plan_id = $request->plan_id;  

          $user = User::where('id',$id)->first();   
         if($user){
           $user_detail = UserProfile::with('fitness','dietplan')->where('user_id',$user->id)->first();
            $userCalorieTarget = UserCaloriTarget::where('user_id',$user->id)->first(); 
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
           if(SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id])->first()){

                $costs=SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id])->first();
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

        $dates = [];
        $date = Carbon::createFromFormat('Y-m-d', $subscription->start_date->start_date);
         //  $date = Carbon::now();
          for ($i = 0; $i < $costs->no_days; $i++) {
               $alldate = $date->addDay()->format('y-m-d');
               array_push($dates, $alldate);
          }
         //   dd($dates);
         $data['datee'] = $dates;
 
 
     // $dates = '2023-01-20';
     
     $getDate = DB::table('subscription_meal_plan_variant_default_meal')->select('date')->where('meal_plan_id',$plan_id)->where('is_default','1')->groupBy('date')->get()
   ->each(function($getDate)use($id,$plan_id){
       $customCalorie = SubscriptionMealPlanVariant::select('calorie')->where('meal_plan_id',$plan_id)->first();

     if(!empty($customCalorie))
    {
     $custom_calorie = $customCalorie->calorie;
    }    
    else{
     $custom_calorie = '';
    }
    // $checkPlan = UserProfile::select('id','subscription_id','diet_plan_type_id')->where('user_id',$id)->first();
    $start_date = Subscription::select('start_date')->where('plan_id',$plan_id)->where('user_id',$id)->first();
     $no_of_days = SubscriptionMealPlanVariant::select('no_days')->where('meal_plan_id',$plan_id)->first();
     if(UserChangeDeliveryLocation::where('user_id',$id)->where('subscription_plan_id',$plan_id)->where('change_location_for_date',$getDate->date)->exists()){
         $deliveries = userAddress::join('user_change_delivery_location','user_address.id','=','user_change_delivery_location.user_address_id')
        ->join('delivery_slots','user_address.delivery_slot_id','=','delivery_slots.id')
        ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.address_type','user_address.id','delivery_slots.name','delivery_slots.id as slot_id')
        ->where('user_change_delivery_location.user_id',$id)
         ->where('user_change_delivery_location.change_location_for_date',$getDate->date)
         ->where('user_change_delivery_location.subscription_plan_id',$plan_id)
        ->first();
    }else{
        if(UserSkipTimeSlot::where('user_id',$id)->where('subscription_plan_id',$plan_id)->where('skip_date',$getDate->date)->exists()){
    
             $deliveries = UserSkipTimeSlot::join('delivery_slots','user_skip_time_slot.delivery_slot_id','=','delivery_slots.id')
            ->join('user_address','user_skip_time_slot.user_address_id','=','user_address.id')
            ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.id','delivery_slots.name','delivery_slots.id as slot_id','user_address.address_type')
            ->where('user_skip_time_slot.skip_date',$getDate->date)
             ->where('user_skip_time_slot.user_id',$id)
             ->where('user_skip_time_slot.subscription_plan_id',$plan_id)
            ->first();
        }else{
             $deliveries = DeliverySlot::join('user_address','delivery_slots.id','=','user_address.delivery_slot_id')
        ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.id','delivery_slots.name','delivery_slots.id as slot_id','user_address.address_type')
        ->where('user_id',$id)
        ->first();
      }
  }
 
  if(UserSkipDelivery::where('user_id',$id)->where('subscription_plan_id',$plan_id)->where('skip_delivery_date',$getDate->date)->exists())
  {
     $getDate->category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$plan_id])
    ->get()
    ->each(function($category){
        $category->meal_group->meals = ["you skip your delivery for this date"];
        
    })->toArray();
     $data['category'] = $category;
    $data['skip_status'] = "you skip your delivery for this date";
   }else{
     $getDate->category = SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$plan_id])
    ->get()
    ->each(function($category) use($getDate,$plan_id,$custom_calorie,$id){
    
     $category->meal_group->meals =Meal::
     join('subscription_meal_plan_variant_default_meal','meals.id','subscription_meal_plan_variant_default_meal.item_id')
     ->join('meal_macro_nutrients','meals.id','=','meal_macro_nutrients.meal_id')
     ->select('meals.name','meals.name_ar','meals.side_dish','meals.side_dish_ar','meals.image','meals.id','meals.food_type','meal_macro_nutrients.meal_calorie','meal_macro_nutrients.protein','meal_macro_nutrients.carbs','meal_macro_nutrients.fat')
      ->where('subscription_meal_plan_variant_default_meal.meal_schedule_id',$category->meal_group->id)
     ->whereDate('subscription_meal_plan_variant_default_meal.date','=', date('Y-m-d', strtotime($getDate->date)))
     ->where(['subscription_meal_plan_variant_default_meal.meal_plan_id'=> $plan_id,'meals.status'=>'active'])
      ->where('subscription_meal_plan_variant_default_meal.is_default','1')
      ->where('meal_macro_nutrients.user_calorie',$custom_calorie)
     ->get()->each(function($meals)use($id) {
     
 
     $meals->dislikeItem = DislikeItem::join('meal_ingredient_list','dislike_items.id','=','meal_ingredient_list.item_id')
     ->select('dislike_items.id','dislike_items.group_id','dislike_items.name')
     ->where('meal_ingredient_list.meal_id',$meals->id)
     ->where('dislike_items.status','active')->get()
     ->each(function($dislikeItem)use($id){
        $dislikeItem->selected=false;
        if(UserDislike::where(['user_id'=>$id,'item_id'=>$dislikeItem->group_id])->first()){
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
 
 $data['skip_status'] = "";
 }
   })->toArray();
      $data['getDatess'] = $getDate;

      
    
         
     $data['subscription'] = $subscription;
     $data['user'] = $user;
     $data['user_details'] = $user_detail;
    
     $data['userCalorieTargets'] = $userCalorieTarget;
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

}
