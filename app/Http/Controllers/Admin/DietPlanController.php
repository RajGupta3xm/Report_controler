<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DietPlanType;

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

         return view('admin.dietPlan.addDiet-Plan');
    }
}


public function submit(Request $request){
      $data=[
    "name" => $request->input('name'),
    "name_ar" => $request->input('name_ar'),
    "description" => $request->input('description'),
    "description_ar" => $request->input('description_ar'),
    "protein" => $request->input('default_protein'),
    "protein_actual" => $request->input('actual_protein'),
    "carbs" => $request->input('default_carb'),
    "carbs_actual" => $request->input('actual_carb'),
    "fat" => $request->input('default_fat'),
    "fat_actual" => $request->input('actual_fat'),
  ];
 $data['protein_actual_divisor'] = round($request->input('actual_protein')/$request->input('total1'),2);
 $data['carbs_actual_divisor'] = round($request->input('actual_carb')/$request->input('total2'),2);
 $data['fat_actual_divisor'] = round($request->input('actual_fat')/$request->input('total3'),2);

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
   if ($insert) {
       return redirect()->back()->with('success','Diet Plan added successfully');
     } else {
       return redirect()->back()->with('error', 'Some error occurred while adding Diet Plan');
     }
}


}
