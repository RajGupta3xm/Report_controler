<?php

namespace App\Http\Controllers\Admin;

use App\Models\SubscriptionPlan;
use App\Models\SubscriptionMealGroup;
use App\Models\SubscriptionMealPlanVariant;
use App\Models\SubscriptionMealVariantDefaultMeal;
use Auth;
use Carbon\CarbonPeriod;
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
use App\Models\DislikeItem;
use App\Models\DietPlanType;
use App\Models\MealRating;
use App\Models\WeekDays;
use App\Models\MealWeekDay;
use App\Models\MealDepartment;
use App\Models\MealDietPlan;
use App\Models\MealGroupSchedule;
use App\Models\MealMacroNutrients;
use App\Models\MealIngredientList;
use App\Models\MealSchedules;
use App\Models\MealItemOrganization;
use App\Models\Meal;
use App\Models\UserCaloriTarget;
use App\Models\StaffGroup;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class MealPlanController extends Controller {

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
              $data['fitness_goal'] = SubscriptionPlan::select('*')->get();
            return view('admin.MealPlan.meal_list')->with($data);
        }
    }

    public function change_status(Request $request){
        $id = $request->input('id');
         $status = $request->input('action');
        $update = SubscriptionPlan::find($id)->update(['status' => $status]);
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
        }
    }

    public function add_meal() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
            return view('admin.MealPlan.add_meal');
        }
    }

    public function add_variants(Request $request){

                $dates = [];
                $date = Carbon::now();
                for ($i = 0; $i < $request->no_of_days; $i++) {
                    $dates[] = $date->addDay()->format('y-m-d');
                }
                $meal_groups=$request->meal_groups_hidden;
                $returnHTML = view('admin.MealPlan.default',compact('dates','meal_groups'))->render();
                return response()->json(['html' => $returnHTML]);
    }

    public function meal_plan_submit(Request $request){
        if(isset($request->images)){
            $filename = $request->images->getClientOriginalName();
            $imageName = time().'.'.$filename;
            if(env('APP_ENV') == 'local'){
                $return = $request->images->move(
                    base_path() . '/public/uploads/meal_image/', $imageName);
            }
            $url = url('/uploads/meal_image/');
            $images = $url.'/'. $imageName;
        }
        $meal_plan=SubscriptionPlan::create([
             'name'=>$request->title,
             'name_ar'=>$request->title_ar,
             'image'=>$images,

        ]);
        if(isset($request->variant_name_hidden)){
            foreach ($request->variant_name_hidden as $key=>$value){
                $meal_variant=SubscriptionMealPlanVariant::create([
                    'meal_plan_id'=>isset($request->meal_plan_id)?$request->meal_plan_id:$meal_plan->id,
                    'variant_name'=>$value,
                    'meal_group_name'=>$request->meal_groups_hidden_name[$key],
                    'diet_plan_id'=>$request->diet_plan_hidden[$key],
                    'option1'=>$request->option1_hidden[$key],
                    'option2'=>$request->option2_hidden[$key],
                    'no_days'=>$request->no_of_days_hidden[$key],
                    'calorie'=>$request->calorie_hidden[$key],
                    'serving_calorie'=>$request->serving_calorie_hidden[$key],
                    'delivery_price'=>$request->delivery_price_hidden[$key],
                    'plan_price'=>$request->plan_price_hidden[$key],
                    'compare_price'=>$request->compare_price_hidden[$key],
                    'is_charge_vat'=>$request->is_charge_vat_hidden[$key],
                    'custom_text'=>$request->description_value_hidden[$key],
                ]);
            }

        }
        if(count($request->meal_group_name) > 0){
            foreach (array_unique($request->meal_group_name) as $value){
                SubscriptionMealGroup::create([
                    'plan_id'=>$meal_plan->id,
                    'meal_schedule_id'=>$value,
                ]);
            }
        }



        if(count($request->plan_date) > 0){
            foreach ($request->plan_date as $key=>$value){


                SubscriptionMealVariantDefaultMeal::create([
                    'date'=>Carbon::parse($value)->format('Y-m-d'),
                    'meal_schedule_id'=>$request->meals_schedule_id[$key],
                    'meal_plan_id'=>$meal_plan->id,
                    'item_id'=>$request->meals[$key]
                ]);
            }
        }

        if(isset($request->selectionvariant) && count($request->selectionvariant) > 0){
            foreach ($request->selectionvariant as $key=> $variant){
                foreach ($variant as $key1=>$varian){
                    foreach ($varian as $key2=> $value){

                        $meal_schedule_id=MealSchedules::where('name',$key1)->first();
                        $is_exists=SubscriptionMealVariantDefaultMeal::where('meal_plan_id',$meal_plan->id)->where('date',$key)->where('meal_schedule_id',$meal_schedule_id->id)->where('item_id',$key2)->first();

                        if(isset($is_exists)){
                            $is_exists->is_default=1;
                            $is_exists->save();
                        }
                    }

                }
            }
        }
        return redirect('admin/meal-plan-management')->with('success', ' Insert successfully.');
    }

    public function editMealPlan($id,Request $request){
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
            $id = base64_decode($id);
            $data['edit_mealPlan'] = SubscriptionPlan::where('id',$id)->first();
            return view('admin.MealPlan.edit_meal')->with($data);
        }
    }

    public function edit_update($id,Request $request){

        $id = base64_decode($id);
        $meal_plan=SubscriptionPlan::find($id);
if(isset($request->images)){
    $filename = $request->images->getClientOriginalName();
    $imageName = time().'.'.$filename;
    if(env('APP_ENV') == 'local'){
        $return = $request->images->move(
            base_path() . '/public/uploads/meal_image/', $imageName);
    }
    $url = url('/uploads/meal_image/');
    $images = $url.'/'. $imageName;
    $meal_plan->image=$images;
}

$meal_plan->name=$request->title;
$meal_plan->name_ar=$request->title_ar;

$meal_plan->save();

        if(isset($request->variant_name_hidden)){
            foreach ($request->variant_name_hidden as $key=>$value){
                $meal_variant=SubscriptionMealPlanVariant::create([
                    'meal_plan_id'=>$id,
                    'variant_name'=>$value,
                    'meal_group_name'=>$request->meal_groups_hidden_name[$key],
                    'diet_plan_id'=>$request->diet_plan_hidden[$key],
                    'option1'=>$request->option1_hidden[$key],
                    'option2'=>$request->option2_hidden[$key],
                    'no_days'=>$request->no_of_days_hidden[$key],
                    'calorie'=>$request->calorie_hidden[$key],
                    'serving_calorie'=>$request->serving_calorie_hidden[$key],
                    'delivery_price'=>$request->delivery_price_hidden[$key],
                    'plan_price'=>$request->plan_price_hidden[$key],
                    'compare_price'=>$request->compare_price_hidden[$key],
                    'is_charge_vat'=>$request->is_charge_vat_hidden[$key],
                    'custom_text'=>$request->description_value_hidden[$key],
                ]);
            }

        }
        $is_exists=SubscriptionMealVariantDefaultMeal::where('meal_plan_id',$meal_plan->id)->get();
        foreach ($is_exists as $value){
            $value->is_default=0;
            $value->save();
        }


        if(isset($request->selectionvariant) && count($request->selectionvariant) > 0){
            foreach ($request->selectionvariant as $key=> $variant){

                foreach ($variant as $key1=>$varian){
                    foreach ($varian as $key2=> $value){

                        $meal_schedule_id=MealSchedules::where('name',$key1)->first();
                        $is_exists=SubscriptionMealVariantDefaultMeal::where('meal_plan_id',$meal_plan->id)->where('date',$key)->where('meal_schedule_id',$meal_schedule_id->id)->where('item_id',$key2)->first();

                        if(isset($is_exists)){
                            $is_exists->is_default=1;
                            $is_exists->save();
                        }
                    }
                }
            }
        }
        return redirect('admin/meal-plan-management')->with('success', ' Update successfully.');
    }

}