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
use App\Models\UserCaloriTarget;
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
use PDF;

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
             

              //  dd($data);
               
              $currentDate  = date('Y-m-d');
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
                             $countUserCalorieMedium = UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
                                ->where('calorie_recommend.recommended','1500')
                               ->count();
                               $countUserCaloriexs= UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
                               ->where('calorie_recommend.recommended','1000')
                              ->count();
                              $countUserCalorieS= UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
                              ->where('calorie_recommend.recommended','1200')
                             ->count();
                             $countUserCaloriel= UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
                             ->where('calorie_recommend.recommended','1800')
                            ->count();
                            $countUserCaloriexl= UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
                            ->where('calorie_recommend.recommended','2000')
                           ->count();

                          $getSubscription = Meal::join('subscription_meal_plan_variant_default_meal','meals.id','=','subscription_meal_plan_variant_default_meal.item_id')
                          ->select('meals.id as meal_id','meals.name')
                          ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                          // ->where('subscription_meal_plan_variant_default_meal.meal_plan_id',$getSubscriptionDetail->plan_id)
                          ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                          ->groupBy(['meal_id', 'name'])
                          ->get()->each(function($getSubscription)use($mealCountCurrentDate){
                            $getSubscription->medium = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
                            ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                            ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
                            ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                            ->where('meal_macro_nutrients.size_pcs','m')
                            ->where('meal_macro_nutrients.user_calorie','1500')
                            ->count();
                            $getSubscription->xs = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
                            ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                            ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
                            ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                            ->where('meal_macro_nutrients.size_pcs','xs')
                            ->where('meal_macro_nutrients.user_calorie','1000')
                            ->count();
                            $getSubscription->s = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
                            ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                            ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
                            ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                            ->where('meal_macro_nutrients.size_pcs','s')
                            ->where('meal_macro_nutrients.user_calorie','1200')
                            ->count();
                            $getSubscription->l = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
                            ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                            ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
                            ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                            ->where('meal_macro_nutrients.size_pcs','l')
                            ->where('meal_macro_nutrients.user_calorie','1800')
                            ->count();
                            $getSubscription->xl = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
                            ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                            ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
                            ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                            ->where('meal_macro_nutrients.size_pcs','xl')
                            ->where('meal_macro_nutrients.user_calorie','2000')
                            ->count();
                               $getSubscription->add =  $getSubscription->medium+$getSubscription->s+$getSubscription->xs+$getSubscription->l+$getSubscription->xl;


                             })
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

                        // $mealCountCurrentDate = date('Y-m-d');
                        //        $user_calorie = UserCaloriTarget::join('user_profile','user_calori_targets.user_id','=','user_profile.user_id')
                        //   ->join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
                        //   ->select('calorie_recommend.recommended')
                        //   ->get()->each(function($user_calorie)use($mealCountCurrentDate){
                        //     $user_calorie->mealcount = Meal::join('subscription_meal_plan_variant_default_meal','meals.id','=','subscription_meal_plan_variant_default_meal.item_id')
                        //     ->join('meal_macro_nutrients','meals.id','=','meal_macro_nutrients.meal_id')
                        //     ->select('meals.id as meal_id','meals.name','meal_macro_nutrients.size_pcs')
                        //     ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                        //     ->where('meal_macro_nutrients.user_calorie',$user_calorie->recommended)
                        //     ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                        //       ->get();

                        //   });

                        //   $a=[];
                        // foreach($getSubscription as $getSubscriptions){
                        // foreach($user_calorie as $mealId){
                        //  foreach($mealId->mealcount as $Id){

                        //   $a[] = count($Id->meal_id);
                        // if($getSubscriptions->meal_id == $Id->meal_id){
                         
                        //  if($mealId->size_pcs == 'l'){
                         
                        
                        // $data['calorieAdditional'] = array_sum($calorieAddition);
                      //     //  $countmeal = MealMacroNutrients::where('meal_id',$getSubscriptions->meal_id)->where('user_calorie',$user_calories->recommended)->get();
                      //   }
                      // }
                    
                      //  }
                      //  dd($a);
                      //  die;
                      // }
                      //  dd($calorieAddition);
                      //  die;
                      //  }
                       

                      // });
                      $data['countUserCaloriexl'] = $countUserCaloriexl;
                      $data['countUserCaloriexs'] = $countUserCaloriexs;
                      $data['countUserCaloriel'] = $countUserCaloriel;
                      $data['countUserCalorieS'] = $countUserCalorieS;
                      $data['countUserCalorieMedium'] = $countUserCalorieMedium;
                        $data['getSubscription'] = $getSubscription;
                       $data['mealCountCurrentDate'] = $mealCountCurrentDate;
                    
                         

             return view('admin.report.report_list')->with($data);
        }
    }
    public function search_packing_list(Request $request){
   
        $user_name = $request->user_name;
         $user_id = $request->user_id;
        $diet_plan_id = $request->diet_plan_id;
         $userNumber = $request->userNumber;
          $planDate = $request->planDate;
            $timeSlot = $request->timeSlot;
            $selectArea = $request->selectArea;
            $driver = $request->driver;
           
    
          $condition = [];

          if($user_id) {
            $condition['users.id'] = $user_id;
          }

          if ($user_name) {
            $condition[] = ['users.name', 'like', '%' . $user_name . '%'];
        }
          
        if ($diet_plan_id && $diet_plan_id !== 'Select Plan Type') {
          $condition['subscriptions_meal_plans_variants.diet_plan_id'] = $diet_plan_id;
        }

          if ($userNumber) {
            $condition[] = ['users.mobile', 'like', '%' . $userNumber . '%'];
        }
          if($selectArea && $selectArea !== 'Select Area'){
            $condition['user_address.area'] = $selectArea;
          }
          if ($planDate) {
           $condition['subscriptions.switch_plan_start_date'] = $planDate;
        }
           if($timeSlot && $timeSlot !== 'Select Time Slot'){
           $condition['user_address.delivery_slot_id'] = $timeSlot;
           }
           

             $getDetail = UserProfile::join('users','user_profile.user_id','=','users.id')
          ->join('user_address','user_profile.user_id','=','user_address.user_id')
          ->join('subscriptions','user_profile.user_id','=','subscriptions.user_id')
          ->join('subscriptions_meal_plans_variants','subscriptions.variant_id','=','subscriptions_meal_plans_variants.id')
          ->join('user_calori_targets','user_profile.user_id','=','user_calori_targets.user_id')
            ->select ('users.name','users.image','users.id as user_id','users.mobile','users.id','user_profile.subscription_id','user_address.area','user_address.delivery_slot_id','user_calori_targets.custom_result_id','subscriptions.switch_plan_start_date','subscriptions.end_date')
            ->where('users.status','1')
            ->where($condition)
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
           
        //   dd($getDetail);
          
          
         
  
        $calorieAddition[] ='0';
        $proteinAddition[] ='0';
        $carbsAddition[] ='0';
        $fatAddition[] ='0';
        $calories[]='0';
        $proteins[]='0';
        $carbss[]='0';
        $fats[]='0';
      
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


public function upcomingMealCount(Request $request) {
  if (!Auth::guard('admin')->check()) {
      return redirect()->intended('admin/login');
      } else {
        $selectDate = $request->date;

      $condition = [];
      if ($selectDate)
      {
        $condition['subscriptions.switch_plan_start_date'] = $selectDate;
      }

//  dd($condition);
//  dd($selectDate);
    $data['dietPlanType'] = DietPlanType::select('id','name')->get();
    $data['timeSlot'] = DeliverySlot::select('id','name','start_time','end_time')->get();
      $data['driver'] = StaffMembers::join('staff_group','staff_members.id','=','staff_group.id')
    ->select('staff_members.id','staff_members.name')
    ->where('staff_group.name','=','driver')
    ->orwhere('staff_group.name','=','drivers')
    ->get();
    $data['area'] = FleetArea::select('id','area')->where('status','active')->get();


    
     $datess = Carbon::createFromFormat('Y-m-d',$selectDate);
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

    // $activeUser1 = Subscription::whereRaw("DATE_FORMAT(subscriptions.switch_plan_start_date, '%Y-%m-%d') = ?", ['2023-05-24'])->get();
    // dd($activeUser1);
    $activeUser = Subscription::
       where('subscriptions.start_date', '<=', $selectDate)
     ->where('subscriptions.end_date', '>=', $selectDate)
     ->where('subscriptions.delivery_status', '=', 'active')
     ->where('subscriptions.plan_status', '=', 'plan_active')
     ->select('subscriptions.user_id')
     ->whereRaw("DATE_FORMAT(subscriptions.switch_plan_start_date, '%Y-%m-%d') = ?", [$selectDate])
     ->get()
     ->each(function($activeUser){
      $activeUser->userDetail = UserProfile::join('users','user_profile.user_id','=','users.id')
    ->join('diet_plan_types','user_profile.diet_plan_type_id','=','diet_plan_types.id')
    ->join('subscription_plans','user_profile.subscription_id','=','subscription_plans.id')
    ->join('subscriptions_meal_plans_variants','user_profile.variant_id','=','subscriptions_meal_plans_variants.id')
    ->select('users.name as user_name','users.id as user_id','users.country_code','users.mobile','subscription_plans.name as plan_name','subscriptions_meal_plans_variants.variant_name','diet_plan_types.name as diet_plan')
    ->where('user_profile.user_id',$activeUser->user_id)
    //->where('$condition')
   // ->whereRaw("DATE_FORMAT(subscriptions.switch_plan_start_date, '%Y-%m-%d') = ?", ['2023-05-24'])

    
     ->first();
   
    

     })
      // echo "<pre>";
    //  dd($activeUser)
    //  die();
     ->each(function($activeUser){
      $activeUser->orderDetail= Order::join('user_address','orders.address_id','=','user_address.id')
      ->join('users','orders.user_id','=','users.id')
      ->join('subscriptions','orders.user_id','=','subscriptions.user_id')
      ->select('orders.id as order_id','orders.user_id','orders.status','user_address.area','user_address.street','users.name as user_name','subscriptions.plan_id','subscriptions.start_date','users.image')
      ->where('subscriptions.delivery_status','active')
      ->where('subscriptions.start_date',$activeUser->id)
      ->where(['user_address.delivery_slot_id'=>$$activeUser->id,'user_address.status'=>'active'])
      ->get();

     });
      // dd($activeUser)
    //  $delivery_slot->address = Order::join('user_address','orders.address_id','=','user_address.id')
    //  ->join('users','orders.user_id','=','users.id')
    //  ->join('subscriptions','orders.user_id','=','subscriptions.user_id')
    //  ->select('orders.id as order_id','orders.user_id','orders.status','user_address.area','user_address.street','users.name as user_name','subscriptions.plan_id','subscriptions.start_date','users.image')
    //  ->where('subscriptions.delivery_status','active')
    //  ->where('subscriptions.start_date',$date)
    //  ->where(['user_address.delivery_slot_id'=>$delivery_slot->id,'user_address.status'=>'active'])
    //  ->get()
   
     ->each(function($activeUser)use($var){
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
       $data['activeUserCurrentDate'] = $selectDate;
         $data['activeUser'] = $activeUser;

          dd($activeUser);


           $procurementCurrentDate = date('Y-m-d');
           $fourtyHourDate = \Carbon\Carbon::parse($selectDate)->format('Y-m-d');
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

            $mealCountCurrentDate = $request->start_date;

                   $countUserCalorieMedium = UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
                      ->where('calorie_recommend.recommended','1500')
                     ->count();
                     $countUserCaloriexs= UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
                     ->where('calorie_recommend.recommended','1000')
                    ->count();
                    $countUserCalorieS= UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
                    ->where('calorie_recommend.recommended','1200')
                   ->count();
                   $countUserCaloriel= UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
                   ->where('calorie_recommend.recommended','1800')
                  ->count();
                  $countUserCaloriexl= UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
                  ->where('calorie_recommend.recommended','2000')
                 ->count();

                $getSubscription = Meal::join('subscription_meal_plan_variant_default_meal','meals.id','=','subscription_meal_plan_variant_default_meal.item_id')
                ->select('meals.id as meal_id','meals.name')
                ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                // ->where('subscription_meal_plan_variant_default_meal.meal_plan_id',$getSubscriptionDetail->plan_id)
                ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                ->groupBy(['meal_id', 'name'])
                ->get()->each(function($getSubscription)use($mealCountCurrentDate){
                  $getSubscription->medium = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
                  ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                  ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
                  ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                  ->where('meal_macro_nutrients.size_pcs','m')
                  ->where('meal_macro_nutrients.user_calorie','1500')
                  ->count();
                  $getSubscription->xs = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
                  ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                  ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
                  ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                  ->where('meal_macro_nutrients.size_pcs','xs')
                  ->where('meal_macro_nutrients.user_calorie','1000')
                  ->count();
                  $getSubscription->s = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
                  ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                  ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
                  ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                  ->where('meal_macro_nutrients.size_pcs','s')
                  ->where('meal_macro_nutrients.user_calorie','1200')
                  ->count();
                  $getSubscription->l = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
                  ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                  ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
                  ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                  ->where('meal_macro_nutrients.size_pcs','l')
                  ->where('meal_macro_nutrients.user_calorie','1800')
                  ->count();
                  $getSubscription->xl = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
                  ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                  ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
                  ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                  ->where('meal_macro_nutrients.size_pcs','xl')
                  ->where('meal_macro_nutrients.user_calorie','2000')
                  ->count();
                     $getSubscription->add =  $getSubscription->medium+$getSubscription->s+$getSubscription->xs+$getSubscription->l+$getSubscription->xl;


                   })
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

            $data['countUserCaloriexl'] = $countUserCaloriexl;
            $data['countUserCaloriexs'] = $countUserCaloriexs;
            $data['countUserCaloriel'] = $countUserCaloriel;
            $data['countUserCalorieS'] = $countUserCalorieS;
            $data['countUserCalorieMedium'] = $countUserCalorieMedium;
              $data['getSubscription'] = $getSubscription;
             $data['mealCountCurrentDate'] = $mealCountCurrentDate;
          
//dd($data);
   return view('admin.report.report_list')->with($data);
  }
}

public function upcomingProcurementMealCount(Request $request) {
  if (!Auth::guard('admin')->check()) {
      return redirect()->intended('admin/login');
  } 
  else {
    $data['dietPlanType'] = DietPlanType::select('id','name')->get();
    $data['timeSlot'] = DeliverySlot::select('id','name','start_time','end_time')->get();
      $data['driver'] = StaffMembers::join('staff_group','staff_members.group_id','=','staff_group.id')
    ->select('staff_members.id','staff_members.name')
    ->where('staff_group.name','=','driver')
    ->orwhere('staff_group.name','=','drivers')
    ->get();
    $data['area'] = FleetArea::select('id','area')->where('status','active')->get();
    //dd($data);


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
     ->get()

     ->each(function($activeUser){
      $activeUser->userDetail = UserProfile::join('users','user_profile.user_id','=','users.id')
    ->join('diet_plan_types','user_profile.diet_plan_type_id','=','diet_plan_types.id')
    ->join('subscription_plans','user_profile.subscription_id','=','subscription_plans.id')
    ->join('subscriptions_meal_plans_variants','user_profile.variant_id','=','subscriptions_meal_plans_variants.id')
    ->select('users.name as user_name','users.id as user_id','users.country_code','users.mobile','subscription_plans.name as plan_name','subscriptions_meal_plans_variants.variant_name','diet_plan_types.name as diet_plan')
    ->where('user_profile.user_id',$activeUser->user_id )
    ->orderBy('user_profile.user_id','DESC')
     ->first();
     })

    //  ->each(function($activeUser){
    //  $activeUser->orderDetail = FleetDriver::join('usersid','fleet_driver.id','=','usersid.id')
    // //->join('orders','fleet_driver.order_id','=','orders.id')
    // //  ->join('staff_members','fleet_driver.staff_member_id','=','staff_members.id')
    //  //->where(['orders.plan_status'=>'plan_active','payment_status'=>'paid'])
    //  //->where('orders.user_id',$activeUser->user_id)
    //  ->select('staff_members.name')
    //  ->first();

     

    //  })
     
     ->each(function($activeUser)use($var){
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
         

           $procurementCurrentDate = $request->procurement_start_date;
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

                   $countUserCalorieMedium = UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
                      ->where('calorie_recommend.recommended','1500')
                     ->count();
                     $countUserCaloriexs= UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
                     ->where('calorie_recommend.recommended','1000')
                    ->count();
                    $countUserCalorieS= UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
                    ->where('calorie_recommend.recommended','1200')
                   ->count();
                   $countUserCaloriel= UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
                   ->where('calorie_recommend.recommended','1800')
                  ->count();
                  $countUserCaloriexl= UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
                  ->where('calorie_recommend.recommended','2000')
                 ->count();

                $getSubscription = Meal::join('subscription_meal_plan_variant_default_meal','meals.id','=','subscription_meal_plan_variant_default_meal.item_id')
                ->select('meals.id as meal_id','meals.name')
                ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                // ->where('subscription_meal_plan_variant_default_meal.meal_plan_id',$getSubscriptionDetail->plan_id)
                ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                ->groupBy(['meal_id', 'name'])
                ->get()->each(function($getSubscription)use($mealCountCurrentDate){
                  $getSubscription->medium = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
                  ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                  ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
                  ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                  ->where('meal_macro_nutrients.size_pcs','m')
                  ->where('meal_macro_nutrients.user_calorie','1500')
                  ->count();
                  $getSubscription->xs = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
                  ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                  ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
                  ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                  ->where('meal_macro_nutrients.size_pcs','xs')
                  ->where('meal_macro_nutrients.user_calorie','1000')
                  ->count();
                  $getSubscription->s = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
                  ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                  ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
                  ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                  ->where('meal_macro_nutrients.size_pcs','s')
                  ->where('meal_macro_nutrients.user_calorie','1200')
                  ->count();
                  $getSubscription->l = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
                  ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                  ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
                  ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                  ->where('meal_macro_nutrients.size_pcs','l')
                  ->where('meal_macro_nutrients.user_calorie','1800')
                  ->count();
                  $getSubscription->xl = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
                  ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
                  ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
                  ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                  ->where('meal_macro_nutrients.size_pcs','xl')
                  ->where('meal_macro_nutrients.user_calorie','2000')
                  ->count();
                     $getSubscription->add =  $getSubscription->medium+$getSubscription->s+$getSubscription->xs+$getSubscription->l+$getSubscription->xl;


                   })
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

            $data['countUserCaloriexl'] = $countUserCaloriexl;
            $data['countUserCaloriexs'] = $countUserCaloriexs;
            $data['countUserCaloriel'] = $countUserCaloriel;
            $data['countUserCalorieS'] = $countUserCalorieS;
            $data['countUserCalorieMedium'] = $countUserCalorieMedium;
              $data['getSubscription'] = $getSubscription;
             $data['mealCountCurrentDate'] = $mealCountCurrentDate;
          
               

   return view('admin.report.report_list')->with($data);
  }
}

public function downloadPDF()
{
    $data = ['page_content' => 'This is the page content'];
    $pdf = PDF::loadView('admin.report.pdf_template', $data)->setOptions(['defaultFont' => 'sans-serif']);
    return $pdf->download('document.pdf');
}

public function print_meal_count()
{
    // retrieve the user data that you want to print
    $mealCountCurrentDate = date('Y-m-d');

           $countUserCalorieMedium = UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
              ->where('calorie_recommend.recommended','1500')
             ->count();
             $countUserCaloriexs= UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
             ->where('calorie_recommend.recommended','1000')
            ->count();
            $countUserCalorieS= UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
            ->where('calorie_recommend.recommended','1200')
           ->count();
           $countUserCaloriel= UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
           ->where('calorie_recommend.recommended','1800')
          ->count();
          $countUserCaloriexl= UserCaloriTarget::join('calorie_recommend','user_calori_targets.custom_result_id','=','calorie_recommend.id')
          ->where('calorie_recommend.recommended','2000')
         ->count();

        $getSubscription = Meal::join('subscription_meal_plan_variant_default_meal','meals.id','=','subscription_meal_plan_variant_default_meal.item_id')
        ->select('meals.id as meal_id','meals.name')
        ->where('subscription_meal_plan_variant_default_meal.is_default','1')
        // ->where('subscription_meal_plan_variant_default_meal.meal_plan_id',$getSubscriptionDetail->plan_id)
        ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
        ->groupBy(['meal_id', 'name'])
        ->get()->each(function($getSubscription)use($mealCountCurrentDate){
          $getSubscription->medium = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
          ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
          ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
          ->where('subscription_meal_plan_variant_default_meal.is_default','1')
          ->where('meal_macro_nutrients.size_pcs','m')
          ->where('meal_macro_nutrients.user_calorie','1500')
          ->count();
          $getSubscription->xs = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
          ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
          ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
          ->where('subscription_meal_plan_variant_default_meal.is_default','1')
          ->where('meal_macro_nutrients.size_pcs','xs')
          ->where('meal_macro_nutrients.user_calorie','1000')
          ->count();
          $getSubscription->s = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
          ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
          ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
          ->where('subscription_meal_plan_variant_default_meal.is_default','1')
          ->where('meal_macro_nutrients.size_pcs','s')
          ->where('meal_macro_nutrients.user_calorie','1200')
          ->count();
          $getSubscription->l = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
          ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
          ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
          ->where('subscription_meal_plan_variant_default_meal.is_default','1')
          ->where('meal_macro_nutrients.size_pcs','l')
          ->where('meal_macro_nutrients.user_calorie','1800')
          ->count();
          $getSubscription->xl = MealMacroNutrients::join('subscription_meal_plan_variant_default_meal','meal_macro_nutrients.meal_id','=','subscription_meal_plan_variant_default_meal.item_id')
          ->whereDate('subscription_meal_plan_variant_default_meal.date','=', $mealCountCurrentDate)
          ->where('meal_macro_nutrients.meal_id',$getSubscription->meal_id)
          ->where('subscription_meal_plan_variant_default_meal.is_default','1')
          ->where('meal_macro_nutrients.size_pcs','xl')
          ->where('meal_macro_nutrients.user_calorie','2000')
          ->count();
             $getSubscription->add =  $getSubscription->medium+$getSubscription->s+$getSubscription->xs+$getSubscription->l+$getSubscription->xl;


           })
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

    $data['countUserCaloriexl'] = $countUserCaloriexl;
    $data['countUserCaloriexs'] = $countUserCaloriexs;
    $data['countUserCaloriel'] = $countUserCaloriel;
    $data['countUserCalorieS'] = $countUserCalorieS;
    $data['countUserCalorieMedium'] = $countUserCalorieMedium;
    $data['getSubscription'] = $getSubscription;
     $data['mealCountCurrentDate'] = $mealCountCurrentDate;
  
    
    // return a view that displays the user data in a printable format
    return view('admin.report.print_mealCount')->with($data);
}

public function print_procurement()
{
    // retrieve the user data that you want to print
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
  
    
    // return a view that displays the user data in a printable format
    return view('admin.report.print_procurement')->with($data);
}
public function print_activeUser(){

  $activeUserCurrentDate = date('Y-m-d');
 // dd($ActiveUsersCurrentDate);
  
      $userDetail = UserProfile::join('users','user_profile.user_id','=','users.id')
    ->join('diet_plan_types','user_profile.diet_plan_type_id','=','diet_plan_types.id')
    ->join('subscription_plans','user_profile.subscription_id','=','subscription_plans.id')
    ->join('subscriptions_meal_plans_variants','user_profile.variant_id','=','subscriptions_meal_plans_variants.id')
    ->select('users.name as user_name','users.id as user_id','users.country_code','users.mobile','subscription_plans.name as plan_name','subscriptions_meal_plans_variants.variant_name','diet_plan_types.name as diet_plan')
    ->first();
  //dd($userDetail);
 
 $deliveries= DeliverySlot::join('user_address','delivery_slots.id','=','user_address.delivery_slot_id')
      ->select('delivery_slots.start_time','delivery_slots.end_time','user_address.id','delivery_slots.name','delivery_slots.id as slot_id','user_address.address_type','user_address.area')
      
      ->where('day_selection_status','active')
      ->first();
    // dd($deliveries);

//     $driver = staff_members:: join('staff_members_driver','staff_members.id','=','staff_members.id')
//     ->SELECT (`id`);
// //      ->WHERE( 'id')
//  ->first()
 
 


}
// dd($driver);

}
