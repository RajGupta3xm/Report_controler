<?php

namespace App\Http\Controllers\Admin;
use Carbon\CarbonPeriod;
use Response;
use Session;
use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\DeliverySlot;
use App\Models\DietPlanType;
use App\Models\Subscription;
use App\Models\DislikeItem;
use App\Models\Admin;
use App\Models\UserAddress;
use App\Models\FleetDriver;
use App\Models\Meal;
use App\Models\MealSchedules;
use App\Models\MealAllocationDepartment;
use App\Models\MealMacroNutrients;
use App\Models\MealDepartment;
use App\Models\Order;
use App\Models\MealIngredientList;
use App\Models\StaffMembers;
use App\Models\UserProfile;
use App\Models\MealWeekDay;
use App\Models\SubscriptionMealVariantDefaultMeal;
use App\Models\CalorieRecommend;
use App\Models\FleetArea;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use DB;

class ReportController extends Controller
{
    public function index() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
           
             $data['dietPlanType'] = DietPlanType::select('id','name')->get();
              $data['timeSlot'] = DeliverySlot::select('id','name','start_time','end_time')->get();
                $data['driver'] = StaffMembers::join('staff_group','staff_members.group_id','=','staff_group.id')
              ->select('staff_members.id','staff_members.name')
              ->where('staff_group.name','=','driver')
              ->orwhere('staff_group.name','=','drivers')
              ->get();
              $data['area'] = FleetArea::select('id','area')->where('status','active')->get();


               $currentDate = date('Y-m-d');
               $datess = Carbon::createFromFormat('Y-m-d',$currentDate);
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

               $activeUser = Subscription::
                 where('subscriptions.start_date', '<=', $currentDate)
               ->where('subscriptions.end_date', '>=', $currentDate)
               ->where('subscriptions.delivery_status', '=', 'active')
               ->where('subscriptions.plan_status', '=', 'plan_active')
               ->select('subscriptions.user_id')
               ->get()->each(function($activeUser){
                $activeUser->userDetail = UserProfile::join('users','user_profile.user_id','=','users.id')
              ->join('diet_plan_types','user_profile.diet_plan_type_id','=','diet_plan_types.id')
              ->join('subscription_plans','user_profile.subscription_id','=','subscription_plans.id')
              ->join('subscriptions_meal_plans_variants','user_profile.variant_id','=','subscriptions_meal_plans_variants.id')
              ->select('users.name as user_name','users.id as user_id','users.country_code','users.mobile','subscription_plans.name as plan_name','subscriptions_meal_plans_variants.variant_name','diet_plan_types.name as diet_plan')
              ->where('user_profile.user_id',$activeUser->user_id )
              ->orderBy('user_profile.user_id','DESC')
               ->first();
               })
               ->each(function($activeUser){
               $activeUser->orderDetail = FleetDriver::join('orders','fleet_driver.order_id','=','orders.id')
               ->join('staff_members','fleet_driver.staff_member_id','=','staff_members.id')
               ->where(['orders.plan_status'=>'plan_active','payment_status'=>'paid'])
               ->where('orders.user_id',$activeUser->user_id)
               ->select('fleet_driver.staff_member_id','orders.id as order_id','staff_members.name')
               ->first();
 
               })->each(function($activeUser)use($var){
                 $activeUser->deliveries= DeliverySlot::join('user_address','delivery_slots.id','=','user_address.delivery_slot_id')
                ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.id','delivery_slots.name','delivery_slots.id as slot_id','user_address.address_type','user_address.area')
                ->where('user_id',$activeUser->user_id)
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

               });
                 $data['activeUserCurrentDate'] = $currentDate;
                   $data['activeUser'] = $activeUser;



                     $procurementCurrentDate = date('Y-m-d');
                    // $fourtyHourDate = \Carbon\Carbon::parse($current_date)->format('Y-m-d');
                   $procurement = DislikeItem::with('units','categorys')
                   ->where('status','active')->get()
                  ->each(function($procurement)use($procurementCurrentDate){
                    $procurement->itemProcurement = MealIngredientList::join('meal_week_days','meal_ingredient_list.meal_id','=','meal_week_days.meal_id')
                    ->selectRaw('SUM(meal_ingredient_list.quantity) AS qtyTotal')
                     ->where('meal_ingredient_list.item_id',$procurement->id)
                      ->where('meal_week_days.week_days_id',$procurementCurrentDate)
                      ->get();

                  })->each(function($procurement)use($procurementCurrentDate){
                      $procurement->getDepartment = MealDepartment::join('meal_week_days','meal_department.meal_id','=','meal_week_days.meal_id')
                      ->join('meal_allocation_department','meal_department.department_id','=','meal_allocation_department.id')
                      ->select('meal_allocation_department.name','meal_allocation_department.id')
                      ->where('meal_week_days.week_days_id',$procurementCurrentDate)
                      ->get();
                  });
      

                       $data['procurements'] = $procurement;
                     $data['fourtyHourDates'] = $procurementCurrentDate;

                      $mealCountCurrentDate = date('Y-m-d');
                       
                      //  $getSubscriptionDetail = Subscription::select('user_id','plan_id','variant_id')
                      // ->where('subscriptions.start_date', '<=', $mealCountCurrentDate)
                      // ->where('subscriptions.end_date', '>=', $mealCountCurrentDate)
                      // ->where('subscriptions.delivery_status', '=', 'active')
                      // ->where('subscriptions.plan_status', '=', 'plan_active')
                      // ->get()->each(function($getSubscriptionDetail)use($mealCountCurrentDate){
                        $getSubscription = Meal::join('subscription_meal_plan_variant_default_meal','meals.id','=','subscription_meal_plan_variant_default_meal.item_id')
                          ->select('meals.id as meal_id','meals.name')
                          ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                          // ->where('subscription_meal_plan_variant_default_meal.meal_plan_id',$getSubscriptionDetail->plan_id)
                          ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                          ->groupBy(['meal_id', 'name'])
                          ->get()
                        ->each(function($getSubscription){
                           $getSubscription->dietPlan = DietPlanType::join('meal_diet_plan','diet_plan_types.id','=','meal_diet_plan.diet_plan_type_id')
                          ->select('diet_plan_types.name','diet_plan_types.id as diet_plan_id')
                          ->where('meal_diet_plan.meal_id',$getSubscription->meal_id)
                          ->first();
                        })
                        ->each(function($getSubscription){
                         $getSubscription->MealSchedule = MealSchedules::join('meal_group_schedule','meal_schedules.id','=','meal_group_schedule.meal_schedule_id')
                         ->select('meal_schedules.name','meal_schedules.id as meal_schedule_id')
                         ->where('meal_group_schedule.meal_id',$getSubscription->meal_id)
                         ->first();
                        })
                        ->each(function($getSubscription){
                           $getSubscription->department = MealAllocationDepartment::join('meal_department','meal_allocation_department.id','=','meal_department.department_id')
                           ->select('meal_allocation_department.name','meal_allocation_department.id as department_id')
                           ->where('meal_department.meal_id',$getSubscription->meal_id)
                           ->first();
                        });

                      // });
                       $data['getSubscription'] = $getSubscription;
                       $data['mealCountCurrentDate'] = $mealCountCurrentDate;
                    
                         

             return view('admin.report.report_list')->with($data);
        }
    }
    public function search_packing_list(Request $request){
    //    $allData=$request->all();
        $user_name = $request->user_name;
         $user_id = $request->user_id;
        $diet_plan_id = $request->diet_plan_id;
         $userNumber = $request->userNumber;
          $planDate = $request->planDate;
            $timeSlot = $request->timeSlot;
            $selectArea = $request->selectArea;
           
        if($user_id || $userNumber || $timeSlot || $selectArea || $planDate || $diet_plan_id){
             $getDetail = UserProfile::join('users','user_profile.user_id','=','users.id')
          ->join('user_address','user_profile.user_id','=','user_address.user_id')
          ->join('subscriptions','user_profile.subscription_id','=','subscriptions.plan_id')
          ->join('subscriptions_meal_plans_variants','user_profile.subscription_id','=','subscriptions_meal_plans_variants.meal_plan_id')
          ->join('user_calori_targets','user_profile.user_id','=','user_calori_targets.user_id')
            ->select('users.name','users.image','users.id as user_id','users.mobile','users.id','user_profile.subscription_id','user_address.area','user_address.delivery_slot_id','user_calori_targets.custom_result_id')
            ->where('users.status','1')
            ->where(function($query) use ($userNumber,$user_id,$timeSlot,$selectArea,$planDate,$diet_plan_id){
              $query->where('users.mobile',$userNumber)
                     ->orwhere('user_address.delivery_slot_id',$timeSlot)
                     ->orWhere('user_address.area',$selectArea)
                     ->orWhere('subscriptions.start_date',$planDate)
                     ->orWhere('subscriptions_meal_plans_variants.diet_plan_id',$diet_plan_id)
                     ->orWhere('users.id', $user_id);
            })
           
            ->get()
            ->each(function($getDetail){
                $getDetail->delieverySlot = DeliverySlot::select('name','start_time','end_time')
                ->where('id',$getDetail->delivery_slot_id)
                ->first();
            })
            ->each(function($getDetail){
              $getDetail->getCalorie = CalorieRecommend::select('recommended')->where('id',$getDetail->custom_result_id)
              ->first();
            })
            ->each(function($getDetail){
               $getDetail->getMeal = SubscriptionMealVariantDefaultMeal::join('meals','subscription_meal_plan_variant_default_meal.item_id','=','meals.id')
               ->join('meal_macro_nutrients','subscription_meal_plan_variant_default_meal.item_id','=','meal_macro_nutrients.meal_id')
               ->select('meals.name','meal_macro_nutrients.size_pcs','meal_macro_nutrients.meal_calorie','meal_macro_nutrients.protein','meal_macro_nutrients.carbs','meal_macro_nutrients.fat')
               ->where('subscription_meal_plan_variant_default_meal.meal_plan_id',$getDetail->subscription_id)
               ->where('subscription_meal_plan_variant_default_meal.is_default','1')
               ->get();
            });
          
          }
          if(!empty($user_name)){
            $getDetail = UserProfile::join('users','user_profile.user_id','=','users.id')
         ->join('user_address','user_profile.user_id','=','user_address.user_id')
         ->join('user_calori_targets','user_profile.user_id','=','user_calori_targets.user_id')
           ->select('users.name','users.image','users.id as user_id','users.mobile','users.id','user_profile.subscription_id','user_address.area','user_address.delivery_slot_id','user_calori_targets.custom_result_id')
           ->where('users.status','1')
           ->Where('users.name', 'LIKE', '%' . $user_name . '%')
           ->get()
           ->each(function($getDetail){
               $getDetail->delieverySlot = DeliverySlot::select('name','start_time','end_time')
               ->where('id',$getDetail->delivery_slot_id)
               ->first();
           })
           ->each(function($getDetail){
             $getDetail->getCalorie = CalorieRecommend::select('recommended')->where('id',$getDetail->custom_result_id)
             ->first();
           })
           ->each(function($getDetail){
              $getDetail->getMeal = SubscriptionMealVariantDefaultMeal::join('meals','subscription_meal_plan_variant_default_meal.item_id','=','meals.id')
              ->join('meal_macro_nutrients','subscription_meal_plan_variant_default_meal.item_id','=','meal_macro_nutrients.meal_id')
              ->select('meals.name','meal_macro_nutrients.size_pcs','meal_macro_nutrients.meal_calorie','meal_macro_nutrients.protein','meal_macro_nutrients.carbs','meal_macro_nutrients.fat')
              ->where('subscription_meal_plan_variant_default_meal.meal_plan_id',$getDetail->subscription_id)
              ->where('subscription_meal_plan_variant_default_meal.is_default','1')
              ->get();
           });
         
         }
  
        $calorieAddition[] ='0';
        $proteinAddition[] ='0';
        $carbsAddition[] ='0';
        $fatAddition[] ='0';
       foreach($getDetail as $key=>$calories){
          foreach($calories->getMeal as $group){
             $calorieAddition[] = $group['meal_calorie'];
              $proteinAddition[] = $group['protein'];
              $carbsAddition[] = $group['carbs'];
               $fatAddition[] = $group['fat'];
            }
           $calories = array_sum($calorieAddition);
          $proteins = array_sum($proteinAddition);
          $carbss = array_sum($carbsAddition);
         $fats = array_sum($fatAddition);
      }
      $returnHTML = view('admin.report.packing_list',compact('getDetail','calories','proteins','carbss','fats'))->render();
      return response()->json(['html' => $returnHTML]);
        
}


}
