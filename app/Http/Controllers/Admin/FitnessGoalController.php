<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\FitnessGoal;

use DB;

class FitnessGoalController extends Controller
{
    public function index() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
           
            $data['fitness_goal'] = FitnessGoal::select('*')->get();
             return view('admin.fitnessGoal.fitnessGoal-list')->with($data);
        }
    }

    public function change_status(Request $request){
        $id = $request->input('id');
        $status = $request->input('action');
       $update = FitnessGoal::find($id)->update(['status' => $status]);
       if ($update) {
           return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
       } else {
           return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
       }
   }


   public function submit(Request $request){
     $data=[
     "name" => $request->input('name'),
     "name_ar" => $request->input('name_ar'),

   ];
   if(!empty($request->image)){
      $filename = $request->image->getClientOriginalName();
      $imageName = time().'.'.$filename;
      if(env('APP_ENV') == 'local'){
          $return = $request->image->move(
          base_path() . '/public/uploads/fitness_goal/', $imageName);
      }else{
          $return = $request->image->move(
          base_path() . '/../public/uploads/fitness_goal/', $imageName);
      }
      $url = url('/uploads/fitness_goal/');
      $data['image'] = $url.'/'. $imageName;
   
  }

  if(!empty($request->image_ar)){
    $filename = $request->image_ar->getClientOriginalName();
    $imageName = time().'.'.$filename;
    if(env('APP_ENV') == 'local'){
        $return = $request->image_ar->move(
        base_path() . '/public/uploads/fitness_goal/', $imageName);
    }else{
        $return = $request->image_ar->move(
        base_path() . '/../public/uploads/fitness_goal/', $imageName);
    }
    $url = url('/uploads/fitness_goal/');
    $data['image_ar'] = $url.'/'. $imageName;
 
}
  

   $insert = FitnessGoal::create($data);
    if ($insert) {
        return redirect()->back()->with('success','Fitness Goal added successfully');
      } else {
        return redirect()->back()->with('error', 'Some error occurred while adding Fitness Goal');
      }
 }


}
