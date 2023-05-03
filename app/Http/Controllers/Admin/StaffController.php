<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\FitnessGoal;
use App\Models\StaffGroup;
use App\Models\Admin;
use App\Models\StaffMembers;


use DB;

class StaffController extends Controller
{
    public function index() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
           
             $data['staff_group'] = StaffGroup::select('id','name')->where('status','active')->orderBy('id','desc')->get();
              $data['staff_member'] = StaffMembers::with('group','admin')->select('*')->orderBy('id','desc')->get();
             return view('admin.staffGroup.add_staff')->with($data);
        }
    }

    public function add_staff_group() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
               $data['staff_group'] = StaffGroup::orderBy('id','desc')->get();
             return view('admin.staffGroup.addStaff-Group')->with($data);
        }
    }

    public function change_status(Request $request){
        $id = $request->input('id');
        $status = $request->input('action');
       $update = StaffGroup::find($id)->update(['status' => $status]);
       if ($update) {
           return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
       } else {
           return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
       }
   }

   public function group_delete(Request $request ){
    $id = $request->input('id');
     $group_delete = StaffGroup::find($id);
    $delete = $group_delete->delete();
    if ($delete) {
      return response()->json(['status' => true, 'error_code' => 200, 'message' => 'group deleted successfully']);
  } else {
      return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while deleting group']);
  }
}

public function submit(Request $request){
    if(StaffGroup::where('name',$request->name)->where('name_ar',$request->name_ar)->exists()){
        return redirect()->back()->with('error','Record already exist');
    }else{
    $data=[
     "name" => ucwords($request->input('name')),
     "name_ar" => $request->input('name_ar'),

   ];
   if(!empty($request->image)){
      $filename = $request->image->getClientOriginalName();
      $imageName = time().'.'.$filename;
      if(env('APP_ENV') == 'local'){
          $return = $request->image->move(
          base_path() . '/public/uploads/staff_group_image/', $imageName);
      }else{
          $return = $request->image->move(
          base_path() . '/../public/uploads/staff_group_image/', $imageName);
      }
      $url = url('/uploads/staff_group_image/');
   $data['image'] = $url.'/'. $imageName;
   
  }

   $insert = StaffGroup::create($data);
    if ($insert) {
        return redirect()->back()->with('success','Staff Group added successfully');
      } else {
        return redirect()->back()->with('error', 'Some error occurred while adding staff group');
      }
    }
 }

 public function get_staff_data(Request $request)
    {
        if($request->ajax()){
            $data = StaffGroup::Find($request->id);
            return Response($data);
        }
     }

 public function update(Request $request, $id=null){

    $update = StaffGroup::find($id);
    $update->name = $request->input('name');
    $update->name_ar  = $request->input('name_ar');

 
 if(!empty($request->hasFile('images'))){
    $path = '/public/uploads/staff_group_image/'.$update->image;
     if(File::exists($path)){
        File::delete($path);
     }
   $filename = $request->images->getClientOriginalName();
   $imageName = time().'.'.$filename;
   if(env('APP_ENV') == 'local'){
       $return = $request->images->move(
       base_path() . '/public/uploads/staff_group_image/', $imageName);
   }else{
       $return = $request->images->move(
       base_path() . '/../public/uploads/staff_group_image/', $imageName);
   }
   $url = url('/uploads/staff_group_image/');
   $update->image = $url.'/'. $imageName; 

}
   $update->save();

   if($update){
       return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Your content update successfully']);
   }
   else {
       return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while update content']);
   }
}


public function staff_member_submit(Request $request){
    if(StaffMembers::where('name',$request->name)->orWhere('email',$request->email)->orWhere('password',\Hash::make($request->input('password')))->exists()){
        return redirect()->back()->with('error','Record already exist');
    }else{
        $datasubadmin=[
         "name" => $request->input('name'),
         "email" => $request->input('email'),
         'password' => \Hash::make($request->input('password')),
         'type' => '1',
   
      ];
     if(!empty($request->image1)){
         $filename = $request->image1->getClientOriginalName();
         $imageName = time().'.'.$filename;
        if(env('APP_ENV') == 'local'){
             $return = $request->image1->move(
            base_path() . '/public/uploads/staff_group_image/', $imageName);
         }else{
           $return = $request->image1->move(
           base_path() . '/../public/uploads/staff_group_image/', $imageName);
         }
         $url = url('/uploads/staff_group_image/');
          $datasubadmin['image'] = $url.'/'. $imageName;
       }
   $insert = Admin::create($datasubadmin);
   if($insert){
    if($request->input('groupDriver') == ''){
         $data=[
        "admin_id" => $insert->id,
        "name" => $request->input('name'),
        "group_id" => $request->input('group_id'),
        "email" => $request->input('email'),
        'password' => \Hash::make($request->input('password')),
        "user_mgmt" => '3',
        "order_mgmt" => '3',
        "ingredient_mgmt" => '3',
        "fitness_goal_mgmt" => '3',
        "diet_plan_mgmt" => '3',
        "meal_mgmt" => '3',
        "meal_plan_mgmt" => '3',
        "fleet_mgmt" => '3',
        "promo_code_mgmt" => '3',
        "gift_card_mgmt" => '3',
        "notification_mgmt" => '3',
        "refer_earn_mgmt" => '3',
        "report_mgmt" => '3',
        "content_mgmt" => '3',
    ];
    }elseif($request->input('groupDriver') == 'Driver'){
        $data=[
            "admin_id" => $insert->id,
            "name" => $request->input('name'),
            "group_id" => $request->input('group_id'),
            "email" => $request->input('email'),
            'password' => \Hash::make($request->input('password')),
            "user_mgmt" => '4',
            "order_mgmt" => '4',
            "ingredient_mgmt" => '4',
            "fitness_goal_mgmt" => '4',
            "diet_plan_mgmt" => '4',
            "meal_mgmt" => '4',
            "meal_plan_mgmt" => '4',
            "fleet_mgmt" => '4',
            "promo_code_mgmt" => '4',
            "gift_card_mgmt" => '4',
            "notification_mgmt" => '4',
            "refer_earn_mgmt" => '4',
            "report_mgmt" => '4',
            "content_mgmt" => '4',
        ];
    
    }else{
       $data=[
    "admin_id" => $insert->id,
     "name" => $request->input('name'),
     "group_id" => $request->input('group_id'),
     "email" => $request->input('email'),
     'password' => \Hash::make($request->input('password')),
     "user_mgmt" => $request->input('check11'),
     "order_mgmt" => $request->input('checkv4'),
     "ingredient_mgmt" => $request->input('checki1'),
     "fitness_goal_mgmt" => $request->input('check01'),
     "diet_plan_mgmt" => $request->input('checkk1'),
     "meal_mgmt" => $request->input('v1'),
     "meal_plan_mgmt" => $request->input('v2'),
     "fleet_mgmt" => $request->input('v3'),
     "promo_code_mgmt" => $request->input('v4'),
     "gift_card_mgmt" => $request->input('v5'),
     "notification_mgmt" => $request->input('v6'),
     "refer_earn_mgmt" => $request->input('v7'),
     "report_mgmt" => $request->input('v8'),
     "content_mgmt" => $request->input('v10'),
   
   ];
}
   }
//    if(!empty($request->image1)){
//       $filename = $request->image1->getClientOriginalName();
//       $imageName = time().'.'.$filename;
//       if(env('APP_ENV') == 'local'){
//           $return = $request->image1->move(
//           base_path() . '/public/uploads/staff_group_image/', $imageName);
//       }else{
//           $return = $request->image1->move(
//           base_path() . '/../public/uploads/staff_group_image/', $imageName);
//       }
//       $url = url('/uploads/staff_group_image/');
//        $data['image'] = $url.'/'. $imageName;
   
//   }

   $insert = StaffMembers::create($data);

   

    if ($insert) {
        return redirect()->back()->with('success','Staff member added successfully');
      } else {
        return redirect()->back()->with('error', 'Some error occurred while adding staff member');
      }
    }
 }

 public function staff_member_change_status(Request $request){
    $id = $request->input('id');
    $status = $request->input('action');
   $update = StaffMembers::find($id)->update(['status' => $status]);
   if ($update) {
       return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
   } else {
       return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
   }
}

public function get_staff_member_data(Request $request){
      if($request->ajax()){
        $data = StaffMembers::with('admin')->find($request->id);
        return Response($data);
      }
}

public function update_member(Request $request, $id=null){
    $groupIdd =  StaffGroup::where('id',$request->input('group_id'))->first();
    if($groupIdd->name == 'Driver' || $groupIdd->name == 'Drivers'){
        $data=[
           "name" => $request->input('name'),
           "group_id" => $request->input('group_id'),
           "email" => $request->input('email'),
           "group_id" => $request->input('group_id'),
           'password' => \Hash::make($request->input('password')),
           "user_mgmt" => '4',
           "order_mgmt" => '4',
           "ingredient_mgmt" => '4',
           "fitness_goal_mgmt" => '4',
           "diet_plan_mgmt" => '4',
           "meal_mgmt" => '4',
           "meal_plan_mgmt" => '4',
           "fleet_mgmt" => '4',
           "promo_code_mgmt" => '4',
           "gift_card_mgmt" => '4',
           "notification_mgmt" => '4',
           "refer_earn_mgmt" => '4',
           "report_mgmt" => '4',
           "content_mgmt" => '4',
       ];
   }else{
    if($request->input('check11') == ''){
         $data=[
            "name" => $request->input('name'),
            "group_id" => $request->input('group_id'),
            "email" => $request->input('email'),
            "group_id" => $request->input('group_id'),
            'password' => \Hash::make($request->input('password')),
            "user_mgmt" => '3',
            "order_mgmt" => '3',
            "ingredient_mgmt" => '3',
            "fitness_goal_mgmt" => '3',
            "diet_plan_mgmt" => '3',
            "meal_mgmt" => '3',
            "meal_plan_mgmt" => '3',
            "fleet_mgmt" => '3',
            "promo_code_mgmt" => '3',
            "gift_card_mgmt" => '3',
            "notification_mgmt" => '3',
            "refer_earn_mgmt" => '3',
            "report_mgmt" => '3',
            "content_mgmt" => '3',
        ];
    }else{
        $data=[
            "name" => $request->input('name'),
            "group_id" => $request->input('group_id'),
            "email" => $request->input('email'),
            "group_id" => $request->input('group_id'),
            'password' => \Hash::make($request->input('password')),
            "user_mgmt" => $request->input('check11'),
            "order_mgmt" => $request->input('checkv4'),
            "ingredient_mgmt" => $request->input('checki1'),
            "fitness_goal_mgmt" => $request->input('check01'),
            "diet_plan_mgmt" => $request->input('checkk1'),
            "meal_mgmt" => $request->input('v1'),
            "meal_plan_mgmt" => $request->input('v2'),
            "fleet_mgmt" => $request->input('v3'),
            "promo_code_mgmt" => $request->input('v4'),
            "gift_card_mgmt" => $request->input('v5'),
            "notification_mgmt" => $request->input('v6'),
            "refer_earn_mgmt" => $request->input('v7'),
            "report_mgmt" => $request->input('v8'),
            "content_mgmt" => $request->input('v10'),
          
          ];
    }
}
    //   if(!empty($request->image3)){
    //      $filename = $request->image3->getClientOriginalName();
    //      $imageName = time().'.'.$filename;
    //      if(env('APP_ENV') == 'local'){
    //          $return = $request->image3->move(
    //          base_path() . '/public/uploads/staff_member_image/', $imageName);
    //      }else{
    //          $return = $request->image3->move(
    //          base_path() . '/../public/uploads/staff_member_image/', $imageName);
    //      }
    //      $url = url('/uploads/staff_member_image/');
    //         $data['image'] = $url.'/'. $imageName;
      
    //  }
   
   $update = StaffMembers::find($id)->update($data);
   $id = StaffMembers::where('id',$id)->first();
   if($id){
   $updatesubadmin=[
    "name" => $request->input('name'),
    "email" => $request->input('email'),
    'password' => \Hash::make($request->input('password')),

    ];
    if(!empty($request->image3)){
             $filename = $request->image3->getClientOriginalName();
             $imageName = time().'.'.$filename;
             if(env('APP_ENV') == 'local'){
                 $return = $request->image3->move(
                 base_path() . '/public/uploads/staff_member_image/', $imageName);
             }else{
                 $return = $request->image3->move(
                 base_path() . '/../public/uploads/staff_member_image/', $imageName);
             }
             $url = url('/uploads/staff_member_image/');
                 $updatesubadmin['image'] = $url.'/'. $imageName;
          
         }
$update = Admin::where('id',$id->admin_id)->update($updatesubadmin);
   }
   if($update){
       return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Your content update successfully']);
   }
   else {
       return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while update content']);
   }
}

public function filterStaffData(Request $request){
      $status = $request->input('level');
    $data['staff_group'] = StaffGroup::select('id','name')->orderBy('id','Asc')->get();
    $data['staff_member'] = StaffMembers::with('group','admin')->select('*')->where('status',$status)->orderBy('id','Asc')->get();
   if ($data) {
     return view('admin.staffGroup.add_staff')->with($data);
   }
}

public function filterStaffGroupData(Request $request){
   $status = $request->input('level');
   $data['staff_group'] = StaffGroup::where('status',$status)->orderBy('id','desc')->get();
 if ($data) {
    return view('admin.staffGroup.addStaff-Group')->with($data);
 }
}

public function print_staff()
{
    // retrieve the user data that you want to print
     $users =  StaffMembers::with('group','admin')->select('*')->orderBy('id','desc')->get();
    
    // return a view that displays the user data in a printable format
    return view('admin.staffGroup.print_staff', compact('users'));
}


}
