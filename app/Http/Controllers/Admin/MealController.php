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
use App\Models\DislikeItem;
use App\Models\DietPlanType;
use App\Models\MealRating;
use App\Models\WeekDays;
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
use App\Models\Meal;
use App\Models\UserCaloriTarget;
use App\Models\StaffGroup;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class MealController extends Controller {

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
                 $data['mealWeekDay'] = MealWeekDay::select('id','week_days_id')->where('status','active')->take(7)->get();
                 $data['dietPlanType'] = DietPlanType::select('id','name')->where('status','active')->get();
                 $data['mealSchedule'] = MealSchedules::select('id','name')->where('status','active')->get();
                 $meal = Meal::select('id','name','image','status')->orderBy('id','desc')->get()
            ->each(function($meal){
                  $meal->meal_group = MealSchedules::join('meal_group_schedule','meal_schedules.id','=','meal_group_schedule.meal_schedule_id')
                     ->select('meal_schedules.name')
                     ->where('meal_group_schedule.meal_id',$meal->id)
                     ->get();

                     $meal->diet_plan = DietPlanType::join('meal_diet_plan','diet_plan_types.id','=','meal_diet_plan.diet_plan_type_id')
                     ->select('diet_plan_types.name')
                     ->where('meal_diet_plan.meal_id',$meal->id)
                     ->get();

                    

                // $meal_schedule = MealGroupSchedule::select('meal_schedule_id')->where('meal_id',$meal->id)->get();
                //  $id = $meal_schedule['meal_schedule_id'];

                //     $meal->meal_group = MealSchedules::where('id',$id)->first();

                    // $diet_plan_id = MealDietPlan::select('diet_plan_type_id')->where('meal_id',$meal->id)->first();
                    // $diet_id = $diet_plan_id['diet_plan_type_id'];
   
                    //    $meal->diet_plan = DietPlanType::where('id',$diet_id)->first();

                   $meal->rating = MealRating::select(DB::raw('round(AVG(rating),1) as rating'))->where('meal_id',$meal->id)->first();  
              
            });
            $data['meals'] = $meal;
            return view('admin.meal.meal_list')->with($data);
        }
    }
    

    public function change_status(Request $request){
        $id = $request->input('id');
         $status = $request->input('action');
        $update = Meal::find($id)->update(['status' => $status]);
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

             $data['meal_schedule'] = MealSchedules::select('id','name')->orderBy('id','Asc')->get();
              $data['diet_plan'] = DietPlanType::select('id','name')->orderBy('id','Asc')->get(); 
               $data['tags'] = MealWeekDay::select('id','week_days_id')->orderBy('id','Asc')->take(7)->get(); 
               $data['department'] = MealAllocationDepartment::select('id','name')->orderBy('id','Asc')->get(); 
                $data['ingredients'] = DislikeItem::select('id','name','unit_id')->orderBy('id','Asc')->get(); 
                 $data['unit'] = DislikeUnit::select('id','unit')->orderBy('id','Asc')->get(); 
            
            return view('admin.meal.add_meal')->with($data);
        }
    }


    public function meal_submit(Request $request ){
         $data=[
        "name" => $request->input('name'),
        "name_ar" => $request->input('name_ar'),
        "side_dish" => $request->input('side_dish'),
        "side_dish_ar" => $request->input('side_dish_ar'),
        "description" => $request->input('description'),
        "description_ar" => $request->input('description_ar'),
        "food_type" => $request->input('check11'),
        "recipe_yields" => $request->input('recipe_yields'),
        "status" => $request->input('status'),

     


    ];
   
    if(!empty($request->image)){
        $filename = $request->image->getClientOriginalName();
        $imageName = time().'.'.$filename;
        if(env('APP_ENV') == 'local'){
            $return = $request->image->move(
            base_path() . '/public/uploads/meal_image/', $imageName);
        }
        // else{
        //     $return = $request->banner_image->move(
        //     base_path() . '/../public/uploads/meal_image/', $imageName);
        // }
        $url = url('/uploads/meal_image/');
     $data['image'] = $url.'/'. $imageName;
     
    }

$insert = Meal::create($data);
if($insert){
    

     $data=[
        ['meal_id'=> $insert->id,  'user_calorie' => $request->input('user_calorie1'),'size_pcs' => $request->input('size1'), 'recipe_yields' => $request->input('recipe_yield1'), 'meal_calorie' => $request->input('meal_calorie1'), 'protein' => $request->input('protein1'),   'carbs' => $request->input('carb1'),  'fat' => $request->input('fat1')],
        ['meal_id'=>$insert->id,  'user_calorie' => $request->input('user_calorie2'), 'size_pcs' => $request->input('size2'), 'recipe_yields' => $request->input('recipe_yield2'), 'meal_calorie' => $request->input('meal_calorie2'), 'protein' => $request->input('protein2'),   'carbs' => $request->input('carb2'),  'fat' => $request->input('fat2')],
        ['meal_id'=>$insert->id,  'user_calorie' => $request->input('user_calorie3'), 'size_pcs' => $request->input('size3'), 'recipe_yields' => $request->input('recipe_yield3'), 'meal_calorie' => $request->input('meal_calorie3'), 'protein' => $request->input('protein3'),   'carbs' => $request->input('carb3'),  'fat' => $request->input('fat3')],
        ['meal_id'=>$insert->id,  'user_calorie' => $request->input('user_calorie4'), 'size_pcs' => $request->input('size4'), 'recipe_yields' => $request->input('recipe_yield4'), 'meal_calorie' => $request->input('meal_calorie4'), 'protein' => $request->input('protein4'),   'carbs' => $request->input('carb4'),  'fat' => $request->input('fat4')],
        ['meal_id'=>$insert->id,  'user_calorie' => $request->input('user_calorie5'), 'size_pcs' => $request->input('size5'), 'recipe_yields' => $request->input('recipe_yield5'), 'meal_calorie' => $request->input('meal_calorie5'), 'protein' => $request->input('protein5'),   'carbs' => $request->input('carb5'),  'fat' => $request->input('fat5')],
      
    ];
    
  MealMacroNutrients::insert($data);

foreach($request->meal_schedule_id  as $id)
{
    if (!intval($id)) {
       $schedule_id = MealSchedules::create([
            'name'  => $id   
        ]);
    }
    if(!empty($schedule_id))
    {
      $ids = $schedule_id->id;
      if (is_numeric($ids)) {
          MealGroupSchedule::create([
             'meal_id' => $insert->id,
              'meal_schedule_id'  => $ids   
           ]);
        } 
    }
    if (is_numeric($id)) {
        MealGroupSchedule::create([
           'meal_id' => $insert->id,
            'meal_schedule_id'  => $id   
        ]);
     } 

}

// foreach($request->meal_schedule_id  as $id)
// { 
//     // return $intstr = intval($id);
//    if (!intval($id)) {
//       MealSchedules::create([
//           'name'  => $id   
//       ]);
//     } 
// }

  

foreach($request->week_days_id  as $id)
 {

    if (!intval($id)) 
    {

        MealWeekDay::create([
             'meal_id' => $insert->id,
              'week_days_id'  => lcfirst($id) 
           ]);

    }

     if (intval($id)) {
        // $date = Carbon::parse($id);
         MealWeekDay::create([
            'meal_id' => $insert->id,
             'week_days_id'  => Carbon::createFromFormat('d/m/Y', $id)->format('Y-m-d')
         ]);
        }

//     if (!intval($id)) {
//        $schedule_id = WeekDays::create([
//             'name'  => $id   
//         ]);
   
//     if(!empty($schedule_id))
//     {
//       $ids = $schedule_id->id;
//       if (is_numeric($ids)) {
//         MealWeekDay::create([
//              'meal_id' => $insert->id,
//               'week_days_id'  => $ids   
//            ]);
//         } 
//     }
// }
   
    //  if(!empty($date_id))
    //  {
    //    $idss = $date_id->id;
    //    if (is_numeric($idss)) {
    //      MealWeekDay::create([
    //           'meal_id' => $insert->id,
    //            'week_days_id'  => $idss   
    //         ]);
    //      } 
    //  }
    // }
    
    // if (is_numeric($id)) {
    //     MealWeekDay::create([
    //        'meal_id' => $insert->id,
    //         'week_days_id'  => $id   
    //     ]);
    //  } 

}
  



 foreach($request->diet_plan_type_id  as $id)
 {
    MealDietPlan::create([
        'meal_id' => $insert->id,
         'diet_plan_type_id'  => $id   
    ]);
 }


 foreach($request->department_id  as $id)
{
    if (!intval($id)) {
       $schedule_id = MealAllocationDepartment::create([
            'name'  => $id   
        ]);
    }
    if(!empty($schedule_id))
    {
      $ids = $schedule_id->id;
      if (is_numeric($ids)) {
        MealDepartment::create([
             'meal_id' => $insert->id,
              'department_id'  => $ids   
           ]);
        } 
    }
    if (is_numeric($id)) {
        MealDepartment::create([
           'meal_id' => $insert->id,
            'department_id'  => $id   
        ]);
     } 

}

 

    foreach($request->items as $item) {
         MealIngredientList::insert([
            'meal_id' => $insert->id,
            'item_id' => $item['ingredient'],
            'quantity' => $item['qty'],
            'unit_id' => $item['unit'],
        ]);
    }

//  if($request['ingredient'] != null)
//  {
//    foreach ($request->ingredient as $key => $value) {
//     //  if($value && $_POST['ingredient'][$key]){
//       return $servicefaq=[
//           'meal_id' => $insert->id,
//           'item_id' => $value,
//           'quantity' => $request->qty[$key],
//           'unit_id' => $request->unit[$key],
        
//         ];
//         $data =MealIngredientList::create($servicefaq);
//      //}
//  }
//  }


}

if($insert){
   return redirect('admin/add-meal')->with('success', ' Insert successfully.');
}
else {
   return redirect()->back()->with('error', 'Some error occurred while update ');
}

}


public function filter_meal(Request $request) {
      $mealDay = $request->meal_day;
     $status = $request->status;
     $mealType = $request->meal_type;
     $planType = $request->plan_type;
     $data['mealWeekDay'] = MealWeekDay::select('id','week_days_id')->where('status','active')->take(7)->get();
     $data['dietPlanType'] = DietPlanType::select('id','name')->where('status','active')->get();
     $data['mealSchedule'] = MealSchedules::select('id','name')->where('status','active')->get();
     if($status == 'active'){
        $meal = Meal::join('meal_week_days','meals.id','=','meal_week_days.meal_id')
        ->select('meals.id','meals.name','meals.image','meals.status')
        ->where('meals.status','active')
        ->where('meal_week_days.week_days_id',$mealDay)
        ->orderBy('meals.id','desc')->get()
        ->each(function($meal)use($mealType,$planType){
              $meal->meal_group = MealSchedules::join('meal_group_schedule','meal_schedules.id','=','meal_group_schedule.meal_schedule_id')
                 ->select('meal_schedules.name')
                 ->where('meal_group_schedule.meal_id',$meal->id)
                 ->where('meal_schedules.id',$mealType)
                 ->get();
   
                 $meal->diet_plan = DietPlanType::join('meal_diet_plan','diet_plan_types.id','=','meal_diet_plan.diet_plan_type_id')
                 ->select('diet_plan_types.name')
                 ->where('meal_diet_plan.meal_id',$meal->id)
                 ->where('diet_plan_types.id',$planType)
                 ->get();
   
               $meal->rating = MealRating::select(DB::raw('round(AVG(rating),1) as rating'))->where('meal_id',$meal->id)->first();  
          
        });

      }
      if($status == 'draft'){
        $meal = Meal::join('meal_week_days','meals.id','=','meal_week_days.meal_id')
        ->select('meals.id','meals.name','meals.image','meals.status')
        ->where('meals.status','inactive')
        ->where('meal_week_days.week_days_id',$mealDay)
        ->orderBy('meals.id','desc')->get()
        ->each(function($meal)use($mealType,$planType){
              $meal->meal_group = MealSchedules::join('meal_group_schedule','meal_schedules.id','=','meal_group_schedule.meal_schedule_id')
                 ->select('meal_schedules.name')
                 ->where('meal_group_schedule.meal_id',$meal->id)
                 ->where('meal_schedules.id',$mealType)
                 ->get();
   
                 $meal->diet_plan = DietPlanType::join('meal_diet_plan','diet_plan_types.id','=','meal_diet_plan.diet_plan_type_id')
                 ->select('diet_plan_types.name')
                 ->where('meal_diet_plan.meal_id',$meal->id)
                 ->where('diet_plan_types.id',$planType)
                 ->get();
   
               $meal->rating = MealRating::select(DB::raw('round(AVG(rating),1) as rating'))->where('meal_id',$meal->id)->first();  
          
        });

      }

    
     $data['meals'] = $meal;
     return view('admin.meal.meal_list')->with($data);
}

public function meal_delete(Request $request ){
    $id = $request->input('id');
     $meal_delete = Meal::find($id);
    $delete = $meal_delete->delete();
    if ($delete) {
      return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Meal deleted successfully']);
  } else {
      return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while deleting meal ']);
  }
}


public function edit_meal(Request $request, $id=null){
    $id = base64_decode($id);
    //return $id;
      $data['meal'] = Meal::where('id',$id)->first();
      $data['unit'] = DislikeUnit::select('id','unit')->orderBy('id','Asc')->get(); 
      $data['ingredients'] = DislikeItem::select('id','name','unit_id')->orderBy('id','Asc')->get(); 
       $data['meal_macro_nutrients'] = MealMacroNutrients::where('meal_id',$id)->get();
         $data['meal_group_schedule'] = MealGroupSchedule::join('meal_schedules','meal_group_schedule.meal_schedule_id','=','meal_schedules.id')
       ->select('meal_schedules.id','meal_schedules.name')
       ->where('meal_group_schedule.meal_id',$id)->get();
        $data['mealWeekDay'] = MealWeekDay::select('id','week_days_id')->where('meal_id',$id)->get();
         $data['meal_diet_plan'] = MealDietPlan::join('diet_plan_types','meal_diet_plan.diet_plan_type_id','=','diet_plan_types.id')
        ->select('diet_plan_types.id','diet_plan_types.name')
        ->where('meal_diet_plan.meal_id',$id)
        ->get();
         $data['mealDepartment'] = MealDepartment::select('id','department_id')->where('meal_id',$id)->get();
    if($data){
        return view('admin.Meal.edit_meal')->with($data);

    }else{
        return redirect()->back()->with('error','details not found');
    } 
}

public function meal_update(Request $request,$id=null){
    $id = base64_decode($id);
     $data=[
   "name" => $request->input('name'),
   "name_ar" => $request->input('name_ar'),
   "side_dish" => $request->input('side_dish'),
   "side_dish_ar" => $request->input('side_dish_ar'),
   "description" => $request->input('description'),
   "description_ar" => $request->input('description_ar'),
   "food_type" => $request->input('check11'),
   "recipe_yields" => $request->input('recipe_yields'),
   "status" => $request->input('status'),




];

if(!empty($request->image)){
   $filename = $request->image->getClientOriginalName();
   $imageName = time().'.'.$filename;
   if(env('APP_ENV') == 'local'){
       $return = $request->image->move(
       base_path() . '/public/uploads/meal_image/', $imageName);
   }
   // else{
   //     $return = $request->banner_image->move(
   //     base_path() . '/../public/uploads/meal_image/', $imageName);
   // }
   $url = url('/uploads/meal_image/');
 $data['image'] = $url.'/'. $imageName;

}

$insert = Meal::find($id)->update($data);
MealMacroNutrients::where('meal_id',$id)->delete();

 $data=[
   ['meal_id'=> $id,  'user_calorie' => $request->input('user_calorie1'),'size_pcs' => $request->input('size1'), 'recipe_yields' => $request->input('recipe_yield1'), 'meal_calorie' => $request->input('meal_calorie1'), 'protein' => $request->input('protein1'),   'carbs' => $request->input('carb1'),  'fat' => $request->input('fat1')],
   ['meal_id'=>$id,  'user_calorie' => $request->input('user_calorie2'), 'size_pcs' => $request->input('size2'), 'recipe_yields' => $request->input('recipe_yield2'), 'meal_calorie' => $request->input('meal_calorie2'), 'protein' => $request->input('protein2'),   'carbs' => $request->input('carb2'),  'fat' => $request->input('fat2')],
   ['meal_id'=>$id,  'user_calorie' => $request->input('user_calorie3'), 'size_pcs' => $request->input('size3'), 'recipe_yields' => $request->input('recipe_yield3'), 'meal_calorie' => $request->input('meal_calorie3'), 'protein' => $request->input('protein3'),   'carbs' => $request->input('carb3'),  'fat' => $request->input('fat3')],
   ['meal_id'=>$id,  'user_calorie' => $request->input('user_calorie4'), 'size_pcs' => $request->input('size4'), 'recipe_yields' => $request->input('recipe_yield4'), 'meal_calorie' => $request->input('meal_calorie4'), 'protein' => $request->input('protein4'),   'carbs' => $request->input('carb4'),  'fat' => $request->input('fat4')],
   ['meal_id'=>$id,  'user_calorie' => $request->input('user_calorie5'), 'size_pcs' => $request->input('size5'), 'recipe_yields' => $request->input('recipe_yield5'), 'meal_calorie' => $request->input('meal_calorie5'), 'protein' => $request->input('protein5'),   'carbs' => $request->input('carb5'),  'fat' => $request->input('fat5')],
 
];

MealMacroNutrients::insert($data);

MealGroupSchedule::where('meal_id',$id)->delete();
foreach($request->meal_schedule_id  as $idd)
{
    if (!intval($idd)) {
       $schedule_id = MealSchedules::create([
            'name'  => $idd   
        ]);
    }
    if(!empty($schedule_id))
    {
      $ids = $schedule_id->id;
      if (is_numeric($ids)) {
          MealGroupSchedule::create([
             'meal_id' => $id,
              'meal_schedule_id'  => $ids   
           ]);
        } 
    }
 
    if (is_numeric($idd)) {
        MealGroupSchedule::create([
           'meal_id' => $id,
            'meal_schedule_id'  => $idd   
        ]);
     } 

}

// foreach($request->meal_schedule_id  as $id)
// { 
//     // return $intstr = intval($id);
//    if (!intval($id)) {
//       MealSchedules::create([
//           'name'  => $id   
//       ]);
//     } 
// }


MealWeekDay::where('meal_id',$id)->delete();
foreach($request->week_days_id  as $name)
{

if(!empty($name))
{

   MealWeekDay::create([
        'meal_id' => $id,
         'week_days_id'  => lcfirst($name) 
      ]);

}

//     if (!intval($id)) {
//        $schedule_id = WeekDays::create([
//             'name'  => $id   
//         ]);

//     if(!empty($schedule_id))
//     {
//       $ids = $schedule_id->id;
//       if (is_numeric($ids)) {
//         MealWeekDay::create([
//              'meal_id' => $insert->id,
//               'week_days_id'  => $ids   
//            ]);
//         } 
//     }
// }
// if (date("Y-m-d", $request->id)) {
//     $date_id = WeekDays::create([
//          'name'  => $id   
//      ]);

//  if(!empty($date_id))
//  {
//    $idss = $date_id->id;
//    if (is_numeric($idss)) {
//      MealWeekDay::create([
//           'meal_id' => $insert->id,
//            'week_days_id'  => $idss   
//         ]);
//      } 
//  }
// }

// if (is_numeric($id)) {
//     MealWeekDay::create([
//        'meal_id' => $insert->id,
//         'week_days_id'  => $id   
//     ]);
//  } 

}



MealDietPlan::where('meal_id',$id)->delete();
foreach($request->diet_plan_type_id  as $diet_id)
{
MealDietPlan::create([
   'meal_id' => $id,
    'diet_plan_type_id'  => $diet_id   
]);
}


MealDepartment::where('meal_id',$id)->delete();
foreach($request->department_id  as $idf)
{
if (!intval($idf)) {
  $schedule_id = MealAllocationDepartment::create([
       'name'  => $idf  
   ]);
}
if(!empty($schedule_id))
{
 $ids = $schedule_id->id;
 if (is_numeric($ids)) {
   MealDepartment::create([
        'meal_id' => $id,
         'department_id'  => $ids   
      ]);
   } 
}
if (is_numeric($idf)) {
   MealDepartment::create([
      'meal_id' => $id,
       'department_id'  => $idf   
   ]);
} 

}



if($request['ingredient'] != null)
{
foreach ($request->ingredient as $key => $value) {
if($value && $_POST['ingredient'][$key]){
 $servicefaq=[
     'meal_id' => $insert->id,
     'item_id' => $value,
     'quantity' => $request->qty[$key],
     'unit_id' => $request->unit[$key],
   
   ];
   $data =MealIngredientList::create($servicefaq);
}
}



}

if($insert){
return redirect('admin/meal-management')->with('success', ' Update successfully.');
}
else {
return redirect()->back()->with('error', 'Some error occurred while update ');
}

}

}
