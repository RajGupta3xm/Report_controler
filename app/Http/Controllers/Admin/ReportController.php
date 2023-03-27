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
use App\Models\Admin;
use App\Models\StaffMembers;
use App\Models\UserProfile;
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
