<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Unit;
use App\Models\DislikeUnit;
use App\Models\DislikeCategory;
use App\Models\DislikeGroup;
use App\Models\DislikeItem;

use DB;

class IngredientController extends Controller
{
    public function index() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
             $data['group'] = DislikeGroup::select('*')->get();
             $data['category'] = DislikeCategory::select('*')->get();
             $data['unit'] = Unit::select('*')->get();
             $data['ingredient'] = DislikeItem::with('group','category','unit')->select('*')->get();
             return view('admin.ingredient.ingredient-list')->with($data);
        }
    }

    public function unit_submit(Request $request){
         $data=[
            "unit" => $request->input('name'),
            "unit_ar" => $request->input('name_ar'),

        ];

    $insert = Unit::create($data);
    if ($insert) {
        return redirect()->back()->with('success','Unit added successfully');
     } else {
         return redirect()->back()->with('error', 'Some error occurred while adding unit');
     }
    
    }

    public function ingredient_submit(Request $request){
         $data=[
           "name" => ucwords($request->input('name')),
           "name_ar" => $request->input('name_ar'),
           "group_id" => $request->input('group_id'),
           "category_id" => $request->input('category_id'),
           "unit_id" => $request->input('unit_id'),


       ];

   $insert = DislikeItem::create($data);
   if ($insert) {
       return redirect()->back()->with('success','Ingredient added successfully');
    } else {
        return redirect()->back()->with('error', 'Some error occurred while adding Ingredient');
    }
   
   }

    public function category_submit(Request $request){
        $data=[
           "name" => ucwords($request->input('category')),
           "name_ar" => $request->input('category_ar'),

       ];

   $insert = DislikeCategory::create($data);
   if ($insert) {
       return redirect()->back()->with('success','Category added successfully');
    } else {
        return redirect()->back()->with('error', 'Some error occurred while adding category');
    }
   
   }

    public function group_submit(Request $request){
      $data=[
       "name" => $request->input('group'),
       "name_ar" => $request->input('group_ar'),

     ];
     if(!empty($request->images1)){
        $filename = $request->images1->getClientOriginalName();
        $imageName = time().'.'.$filename;
        if(env('APP_ENV') == 'local'){
            $return = $request->images1->move(
            base_path() . '/public/uploads/group_image/', $imageName);
        }else{
            $return = $request->images1->move(
            base_path() . '/../public/uploads/group_image/', $imageName);
        }
        $url = url('/uploads/group_image/');
      $data['image'] = $url.'/'. $imageName;
     
    }

     $insert = DislikeGroup::create($data);
      if ($insert) {
          return redirect()->back()->with('success','Group added successfully');
        } else {
          return redirect()->back()->with('error', 'Some error occurred while adding group');
        }
   }

   public function change_status(Request $request){
     $id = $request->input('id');
     $status = $request->input('action');
    $update = DislikeGroup::find($id)->update(['status' => $status]);
    if ($update) {
        return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
    } else {
        return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
    }
}

public function change_status_ingredient(Request $request){
    $id = $request->input('id');
    $status = $request->input('action');
   $update = DislikeItem::find($id)->update(['status' => $status]);
   if ($update) {
       return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
   } else {
       return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
   }
}

public function get_data(Request $request)
    {
        if($request->ajax()){
            $data = DislikeGroup::Find($request->id);
            return Response($data);
        }
     }

public function update(Request $request, $id=null){

  $update = DislikeGroup::find($id);
  $update->name = $request->input('group_name');
  $update->name_ar = $request->input('group_name_ar');


  if($request->hasFile('images')){
     $path = '/public/uploads/group_image/'.$update->image;
     if(File::exists($path)){
        File::delete($path);
     }
    $filename = $request->images->getClientOriginalName();
    $imageName = time().'.'.$filename;
    if(env('APP_ENV') == 'local'){
        $return = $request->images->move(
        base_path() . '/public/uploads/group_image/', $imageName);
    }else{
        $return = $request->images->move(
        base_path() . '/../public/uploads/group_image/', $imageName);
    }
    $url = url('/uploads/group_image/');
   $update->image = $url.'/'. $imageName;
}
$update->save();
   
//     $update = DislikeGroup::where([ 'id' => $id])->update(
//         [
//             'name' => $request->group_name,
//             'name_ar' => $request->group_name_ar,
//             // 'image' => $image,
           
//         ]
// );
    if($update){
        return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Your content update successfully']);
    }
    else {
        return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while update content']);
    }
}

public function update_ingredient(Request $request, $id=null){
      $data=[
     "name" => $request->input('name'),
     "name_ar" => $request->input('name_ar'),
     "group_id" => $request->input('group_id'),
     "category_id" => $request->input('category_id'),
     "unit_id" => $request->input('unit_id'),

 ];

   $update = DislikeItem::find($id)->update($data);
   if($update){
       return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Your content update successfully']);
   }
   else {
       return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while update content']);
   }
}

public function group_delete(Request $request ){
    $id = $request->input('id');
     $group_delete = DislikeGroup::find($id);
    $delete = $group_delete->delete();
    if ($delete) {
      return response()->json(['status' => true, 'error_code' => 200, 'message' => 'group deleted successfully']);
  } else {
      return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while deleting group']);
  }
}

public function ingredient_delete(Request $request ){
    $id = $request->input('id');
     $ingredient_delete = DislikeItem::find($id);
    $delete = $ingredient_delete->delete();
    if ($delete) {
      return response()->json(['status' => true, 'error_code' => 200, 'message' => 'ingredient deleted successfully']);
  } else {
      return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while deleting ingredient']);
  }
}

public function change_status_category(Request $request){
    $id = $request->input('id');
    $status = $request->input('action');
   $update = DislikeCategory::find($id)->update(['status' => $status]);
   if ($update) {
       return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
   } else {
       return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
   }
}

public function get_category_data(Request $request)
    {
        if($request->ajax()){
            $data = DislikeCategory::Find($request->id);
            return Response($data);
        }
     }


     public function update_category(Request $request, $id=null){

        $update = DislikeCategory::find($id);
        $update->name = $request->input('category_name');
        $update->name_ar = $request->input('category_name_ar');

      $update->save();

          if($update){
              return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Your content update successfully']);
          }
          else {
              return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while update content']);
          }
      }

      public function category_delete(Request $request ){
        $id = $request->input('id');
         $category_delete = DislikeCategory::find($id);
        $delete = $category_delete->delete();
        if ($delete) {
          return response()->json(['status' => true, 'error_code' => 200, 'message' => 'category deleted successfully']);
      } else {
          return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while deleting category']);
      }
    }


    public function unit_status(Request $request){
        $id = $request->input('id');
        $status = $request->input('action');
       $update = DislikeUnit::find($id)->update(['status' => $status]);
       if ($update) {
           return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
       } else {
           return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
       }
   }

   public function get_unit_data(Request $request)
    {
        if($request->ajax()){
            $data = DislikeUnit::Find($request->id);
            return Response($data);
        }
     }

     public function update_unit(Request $request, $id=null){

        $update = DislikeUnit::find($id);
        $update->unit = $request->input('unit_name');
        $update->unit_ar = $request->input('unit_name_ar');

      $update->save();

          if($update){
              return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Your content update successfully']);
          }
          else {
              return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while update content']);
          }
      }

      public function unit_delete(Request $request ){
        $id = $request->input('id');
         $unit_delete = DislikeUnit::find($id);
        $delete = $unit_delete->delete();
        if ($delete) {
          return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Unit deleted successfully']);
      } else {
          return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while deleting Unit']);
      }
    }    
}
