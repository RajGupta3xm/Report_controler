<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DietPlanType;
use App\Models\DietPlanTypesMealCalorieMinMax;

use DB;

class DietPlanController extends Controller
{
    public function index() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
            $data['diet_plan'] = DietPlanType::select('id','image','image_ar','name','status')->get();
             return view('admin.dietPlan.dietPlan-list')->with($data);
        }
    }

    public function change_status(Request $request){
        $id = $request->input('id');
        $status = $request->input('action');
       $update = DietPlanType::find($id)->update(['status' => $status]);
       if ($update) {
           return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
       } else {
           return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
       }
   }

   public function add_diet_plan() {
    if (!Auth::guard('admin')->check()) {
        return redirect()->intended('admin/login');
    } else {

         return view('admin.dietPlan.addDiet-plan');
    }
}



public function edit_dietPlan(Request $request, $id=null){
    $id = base64_decode($id);
    //return $id;
     $data['edit_dietPlan'] = DietPlanType::where('id',$id)->first();
    if($data){
        return view('admin.dietPlan.edit-dietPlan')->with($data);

    }else{
        return redirect()->back()->with('error','details not found');
    } 
}



public function submit(Request $request){
        $data=[
    "name" => $request->input('name'),
    "name_ar" => $request->input('name_ar'),
    "description" => $request->input('description'),
    "description_ar" => $request->input('description_ar'),
    "protein_default_min" => $request->input('protein_default_min'),
    "protein_min_divisor" => $request->input('protein_min_divisor'),
    "protein_default_max" => $request->input('protein_default_max'),
    "protein_max_divisor" => $request->input('protein_max_divisor'),
    "carb_default_min" => $request->input('carb_default_min'),
    "carb_min_divisor" => $request->input('carb_min_divisor'),
    "carb_default_max" => $request->input('carb_default_max'),
    "carb_max_divisor" => $request->input('carb_max_divisor'),
    "fat_default_min" => $request->input('fat_default_min'),
    "fat_min_divisor" => $request->input('fat_min_divisor'),
    "fat_default_max" => $request->input('fat_default_max'),
    "fat_max_divisor" => $request->input('fat_max_divisor'),
   
  ];


  if(!empty($request->image)){
     $filename = $request->image->getClientOriginalName();
     $imageName = time().'.'.$filename;
     if(env('APP_ENV') == 'local'){
         $return = $request->image->move(
         base_path() . '/public/uploads/diet_plan/', $imageName);
     }else{
         $return = $request->image->move(
         base_path() . '/../public/uploads/diet_plan/', $imageName);
     }
     $url = url('/uploads/diet_plan/');
      $data['image'] = $url.'/'. $imageName;
  
 }

 if(!empty($request->image_ar)){
   $filename = $request->image_ar->getClientOriginalName();
   $imageName = time().'.'.$filename;
   if(env('APP_ENV') == 'local'){
       $return = $request->image_ar->move(
       base_path() . '/public/uploads/diet_plan/', $imageName);
   }else{
       $return = $request->image_ar->move(
       base_path() . '/../public/uploads/diet_plan/', $imageName);
   }
   $url = url('/uploads/diet_plan/');
    $data['image_ar'] = $url.'/'. $imageName;

}
 
  $insert = DietPlanType::create($data);
  if($insert){
     $protein_min = (($insert->protein_default_min/100)*1000)/$insert->protein_min_divisor;
     $protein_max = (($insert->protein_default_max/100)*1000)/$insert->protein_max_divisor;
     $carb_min = (($insert->carb_default_min/100)*1000)/$insert->carb_min_divisor;
     $carb_max = (($insert->carb_default_max/100)*1000)/$insert->carb_max_divisor;
     $fat_min = (($insert->fat_default_min/100)*1000)/$insert->fat_min_divisor;
     $fat_max = (($insert->fat_default_max/100)*1000)/$insert->fat_max_divisor;

     $protein_min1 = (($insert->protein_default_min/100)*1200)/$insert->protein_min_divisor;
     $protein_max1 = (($insert->protein_default_max/100)*1200)/$insert->protein_max_divisor;
     $carb_min1 = (($insert->carb_default_min/100)*1200)/$insert->carb_min_divisor;
     $carb_max1 = (($insert->carb_default_max/100)*1200)/$insert->carb_max_divisor;
     $fat_min1 = (($insert->fat_default_min/100)*1200)/$insert->fat_min_divisor;
     $fat_max1 = (($insert->fat_default_max/100)*1200)/$insert->fat_max_divisor;

     $protein_min2 = (($insert->protein_default_min/100)*1500)/$insert->protein_min_divisor;
     $protein_max2 = (($insert->protein_default_max/100)*1500)/$insert->protein_max_divisor;
     $carb_min2 = (($insert->carb_default_min/100)*1500)/$insert->carb_min_divisor;
     $carb_max2 = (($insert->carb_default_max/100)*1500)/$insert->carb_max_divisor;
     $fat_min2 = (($insert->fat_default_min/100)*1500)/$insert->fat_min_divisor;
     $fat_max2 = (($insert->fat_default_max/100)*1500)/$insert->fat_max_divisor;

     $protein_min3 = (($insert->protein_default_min/100)*1800)/$insert->protein_min_divisor;
     $protein_max3 = (($insert->protein_default_max/100)*1800)/$insert->protein_max_divisor;
     $carb_min3 = (($insert->carb_default_min/100)*1800)/$insert->carb_min_divisor;
     $carb_max3 = (($insert->carb_default_max/100)*1800)/$insert->carb_max_divisor;
     $fat_min3 = (($insert->fat_default_min/100)*1800)/$insert->fat_min_divisor;
     $fat_max3 = (($insert->fat_default_max/100)*1800)/$insert->fat_max_divisor;

     $protein_min4 = (($insert->protein_default_min/100)*2000)/$insert->protein_min_divisor;
     $protein_max4 = (($insert->protein_default_max/100)*2000)/$insert->protein_max_divisor;
     $carb_min4 = (($insert->carb_default_min/100)*2000)/$insert->carb_min_divisor;
     $carb_max4 = (($insert->carb_default_max/100)*2000)/$insert->carb_max_divisor;
     $fat_min4 = (($insert->fat_default_min/100)*2000)/$insert->fat_min_divisor;
     $fat_max4 = (($insert->fat_default_max/100)*2000)/$insert->fat_max_divisor;

    $data_calorie=[
        ['diet_plan_type_id'=> $insert->id,  'meal_calorie' => '1000','protein_max' => round($protein_max,0), 'protein_min' => round($protein_min,0), 'carbs_min' => round($carb_min,0), 'carbs_max' => round($carb_max,0),   'fat_min' => round($fat_min,0),  'fat_max' => round($fat_max,0)],
        ['diet_plan_type_id'=> $insert->id,  'meal_calorie' => '1200', 'protein_max' => round($protein_max1,0), 'protein_min' => round($protein_min1,0), 'carbs_min' => round($carb_min1,0), 'carbs_max' => round($carb_max1,0),   'fat_min' => round($fat_min1,0),  'fat_max' => round($fat_max1,0)],
        ['diet_plan_type_id'=> $insert->id,  'meal_calorie' => '1500', 'protein_max' => round($protein_max2,0), 'protein_min' => round($protein_min2,0), 'carbs_min' => round($carb_min2,0), 'carbs_max' => round($carb_max2,0),   'fat_min' => round($fat_min2,0),  'fat_max' => round($fat_max2,0)],
        ['diet_plan_type_id'=> $insert->id,  'meal_calorie' => '1800', 'protein_max' => round($protein_max3,0), 'protein_min' => round($protein_min3,0), 'carbs_min' => round($carb_min3,0), 'carbs_max' => round($carb_max3,0),   'fat_min' => round($fat_min3,0),  'fat_max' => round($fat_max3,0)],
        ['diet_plan_type_id'=> $insert->id,  'meal_calorie' => '2000', 'protein_max' => round($protein_max4,0), 'protein_min' => round($protein_min4,0), 'carbs_min' => round($carb_min4,0), 'carbs_max' => round($carb_max4,0),   'fat_min' => round($fat_min4,0),  'fat_max' => round($fat_max4,0)],
      
     ];
     
     DietPlanTypesMealCalorieMinMax::insert($data_calorie);
    
  }
   if ($insert) {
       return redirect()->back()->with('success','Diet Plan added successfully');
     } else {
       return redirect()->back()->with('error', 'Some error occurred while adding Diet Plan');
     }
}


public function edit_update(Request $request, $id=null){
     $id = base64_decode($id);
    $data=[
        "name" => $request->input('name'),
        "name_ar" => $request->input('name_ar'),
        "description" => $request->input('description'),
        "description_ar" => $request->input('description_ar'),
        "protein_default_min" => $request->input('protein_default_min'),
        "protein_min_divisor" => $request->input('protein_min_divisor'),
        "protein_default_max" => $request->input('protein_default_max'),
        "protein_max_divisor" => $request->input('protein_max_divisor'),
        "carb_default_min" => $request->input('carb_default_min'),
        "carb_min_divisor" => $request->input('carb_min_divisor'),
        "carb_default_max" => $request->input('carb_default_max'),
        "carb_max_divisor" => $request->input('carb_max_divisor'),
        "fat_default_min" => $request->input('fat_default_min'),
        "fat_min_divisor" => $request->input('fat_min_divisor'),
        "fat_default_max" => $request->input('fat_default_max'),
        "fat_max_divisor" => $request->input('fat_max_divisor'),
       
      ];
  
      if(!empty($request->image)){
         $filename = $request->image->getClientOriginalName();
         $imageName = time().'.'.$filename;
         if(env('APP_ENV') == 'local'){
             $return = $request->image->move(
             base_path() . '/public/uploads/diet_plan/', $imageName);
         }else{
             $return = $request->image->move(
             base_path() . '/../public/uploads/diet_plan/', $imageName);
         }
         $url = url('/uploads/diet_plan/');
          $data['image'] = $url.'/'. $imageName;
      
     }
    
     if(!empty($request->image_ar)){
       $filename = $request->image_ar->getClientOriginalName();
       $imageName = time().'.'.$filename;
       if(env('APP_ENV') == 'local'){
           $return = $request->image_ar->move(
           base_path() . '/public/uploads/diet_plan/', $imageName);
       }else{
           $return = $request->image_ar->move(
           base_path() . '/../public/uploads/diet_plan/', $imageName);
       }
       $url = url('/uploads/diet_plan/');
        $data['image_ar'] = $url.'/'. $imageName;
    
    }

$update = DietPlanType::find($id)->update($data);
$insert = DietPlanType::find($id);
if($insert){
    $protein_min = (($insert->protein_default_min/100)*1000)/$insert->protein_min_divisor;
    $protein_max = (($insert->protein_default_max/100)*1000)/$insert->protein_max_divisor;
    $carb_min = (($insert->carb_default_min/100)*1000)/$insert->carb_min_divisor;
    $carb_max = (($insert->carb_default_max/100)*1000)/$insert->carb_max_divisor;
    $fat_min = (($insert->fat_default_min/100)*1000)/$insert->fat_min_divisor;
    $fat_max = (($insert->fat_default_max/100)*1000)/$insert->fat_max_divisor;

    $protein_min1 = (($insert->protein_default_min/100)*1200)/$insert->protein_min_divisor;
    $protein_max1 = (($insert->protein_default_max/100)*1200)/$insert->protein_max_divisor;
    $carb_min1 = (($insert->carb_default_min/100)*1200)/$insert->carb_min_divisor;
    $carb_max1 = (($insert->carb_default_max/100)*1200)/$insert->carb_max_divisor;
    $fat_min1 = (($insert->fat_default_min/100)*1200)/$insert->fat_min_divisor;
    $fat_max1 = (($insert->fat_default_max/100)*1200)/$insert->fat_max_divisor;

    $protein_min2 = (($insert->protein_default_min/100)*1500)/$insert->protein_min_divisor;
    $protein_max2 = (($insert->protein_default_max/100)*1500)/$insert->protein_max_divisor;
    $carb_min2 = (($insert->carb_default_min/100)*1500)/$insert->carb_min_divisor;
    $carb_max2 = (($insert->carb_default_max/100)*1500)/$insert->carb_max_divisor;
    $fat_min2 = (($insert->fat_default_min/100)*1500)/$insert->fat_min_divisor;
    $fat_max2 = (($insert->fat_default_max/100)*1500)/$insert->fat_max_divisor;

    $protein_min3 = (($insert->protein_default_min/100)*1800)/$insert->protein_min_divisor;
    $protein_max3 = (($insert->protein_default_max/100)*1800)/$insert->protein_max_divisor;
    $carb_min3 = (($insert->carb_default_min/100)*1800)/$insert->carb_min_divisor;
    $carb_max3 = (($insert->carb_default_max/100)*1800)/$insert->carb_max_divisor;
    $fat_min3 = (($insert->fat_default_min/100)*1800)/$insert->fat_min_divisor;
    $fat_max3 = (($insert->fat_default_max/100)*1800)/$insert->fat_max_divisor;

    $protein_min4 = (($insert->protein_default_min/100)*2000)/$insert->protein_min_divisor;
    $protein_max4 = (($insert->protein_default_max/100)*2000)/$insert->protein_max_divisor;
    $carb_min4 = (($insert->carb_default_min/100)*2000)/$insert->carb_min_divisor;
    $carb_max4 = (($insert->carb_default_max/100)*2000)/$insert->carb_max_divisor;
    $fat_min4 = (($insert->fat_default_min/100)*2000)/$insert->fat_min_divisor;
    $fat_max4 = (($insert->fat_default_max/100)*2000)/$insert->fat_max_divisor;

    DietPlanTypesMealCalorieMinMax::where('diet_plan_type_id',$insert->id)->delete();
   $data_calorie=[
       ['diet_plan_type_id'=> $insert->id,  'meal_calorie' => '1000','protein_max' => round($protein_max,0), 'protein_min' => round($protein_min,0), 'carbs_min' => round($carb_min,0), 'carbs_max' => round($carb_max,0),   'fat_min' => round($fat_min,0),  'fat_max' => round($fat_max,0)],
       ['diet_plan_type_id'=> $insert->id,  'meal_calorie' => '1200', 'protein_max' => round($protein_max1,0), 'protein_min' => round($protein_min1,0), 'carbs_min' => round($carb_min1,0), 'carbs_max' => round($carb_max1,0),   'fat_min' => round($fat_min1,0),  'fat_max' => round($fat_max1,0)],
       ['diet_plan_type_id'=> $insert->id,  'meal_calorie' => '1500', 'protein_max' => round($protein_max2,0), 'protein_min' => round($protein_min2,0), 'carbs_min' => round($carb_min2,0), 'carbs_max' => round($carb_max2,0),   'fat_min' => round($fat_min2,0),  'fat_max' => round($fat_max2,0)],
       ['diet_plan_type_id'=> $insert->id,  'meal_calorie' => '1800', 'protein_max' => round($protein_max3,0), 'protein_min' => round($protein_min3,0), 'carbs_min' => round($carb_min3,0), 'carbs_max' => round($carb_max3,0),   'fat_min' => round($fat_min3,0),  'fat_max' => round($fat_max3,0)],
       ['diet_plan_type_id'=> $insert->id,  'meal_calorie' => '2000', 'protein_max' => round($protein_max4,0), 'protein_min' => round($protein_min4,0), 'carbs_min' => round($carb_min4,0), 'carbs_max' => round($carb_max4,0),   'fat_min' => round($fat_min4,0),  'fat_max' => round($fat_max4,0)],
     
    ];
    
    DietPlanTypesMealCalorieMinMax::insert($data_calorie);
   
 }


if($update){
   return redirect('admin/dietPlan-management')->with('success', ' update successfully.');
}
else {
   return redirect()->back()->with('error', 'Some error occurred while update ');
}

}


public function dietPlanDelete(Request $request ){
    $id = $request->input('id');
     $dietplan_delete = DietPlanType::find($id);
    $delete = $dietplan_delete->delete();
    if ($delete) {
      return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Diet plan deleted successfully']);
  } else {
      return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while deleting diet plan']);
  }
}

}
