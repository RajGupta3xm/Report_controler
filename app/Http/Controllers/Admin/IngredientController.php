<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Unit;
use App\Models\User;
use App\Models\DislikeUnit;
use App\Models\DislikeCategory;
use App\Models\DislikeGroup;
use App\Models\DislikeItem;
use App\Exports\IngredientsExport;
use App\Exports\GroupsExport;
use App\Exports\CategorysExport;
use App\Exports\UnitsExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

use DB;

class IngredientController extends Controller
{
    public function index() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
             $data['group'] = DislikeGroup::select('*')->orderBy('id','desc')->get();
             $data['category'] = DislikeCategory::select('*')->orderBy('id','desc')->get();
             $data['unit'] = Unit::select('*')->orderBy('id','desc')->get();
             $data['ingredient'] = DislikeItem::with('group','category','unit')->select('*')->orderBy('name')->get();

             $data['groups'] = DislikeGroup::select('*')->orderBy('id','desc')->where('status','active')->get();
             $data['categorys'] = DislikeCategory::select('*')->orderBy('id','desc')->where('status','active')->get();
             $data['units'] = Unit::select('*')->orderBy('id','desc')->where('status','active')->get();
             $data['ingredients'] = DislikeItem::with('group','category','unit')->select('*')->where('status','active')->orderBy('id','desc')->get();
             return view('admin.ingredient.ingredient-list')->with($data);
        }
    }

    public function unit_submit(Request $request){
        if(Unit::where('unit',$request->unit)->orWhere('unit_ar',$request->unit_ar)->exists()){
            return redirect()->back()->with('error','Record already exist');
        }else{
         $data=[
            "unit" => ucwords($request->input('unit')),
            "unit_ar" => $request->input('unit_ar'),

        ];

    $insert = Unit::create($data);
    if ($insert) {
        return redirect()->back()->with('success','Unit added successfully');
     } else {
         return redirect()->back()->with('error', 'Some error occurred while adding unit');
     }
    }
    
    }

    public function ingredient_submit(Request $request){
      if(DislikeItem::where('name',$request->name)->orWhere('name_ar',$request->name_ar)->exists()){

        return redirect()->back()->with('error', 'Record already exist');
      }else{

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
   }

    public function category_submit(Request $request){
        if(DislikeCategory::where('name',$request->category)->orWhere('name_ar',$request->category_ar)->exists()){
            return redirect()->back()->with('error', 'Record already exist');
        }else{
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
   
   }

    public function group_submit(Request $request){
    if(DislikeGroup::where('name',$request->group)->orWhere('name_ar',$request->group_ar)->exists()){
        return redirect()->back()->with('error', 'Record already exist');
    }else{
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
      return response()->json(['status' => true, 'success_code' => 200, 'message' => 'group deleted successfully']);
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
          return response()->json(['status' => true, 'sucess' => 200, 'message' => 'Unit deleted successfully']);
      } else {
          return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while deleting Unit']);
      }
    } 
    
    
    public function export(Request $request)
{
    //  $users = User::all();
      $users = DislikeItem::with('group','category','unit')->select('*')->where('status','active')->orderBy('id','desc')->get();

    return Excel::download(new IngredientsExport($users), 'ingredients.xlsx');
}

 
public function export_group(Request $request)
{
    //  $users = User::all();
       $users =  DislikeGroup::select('*')->orderBy('id','desc')->get();

    return Excel::download(new GroupsExport($users), 'groups.xlsx');
}

public function export_category(Request $request)
{
    //  $users = User::all();
       $users =  DislikeCategory::select('*')->orderBy('id','desc')->get();

    return Excel::download(new CategorysExport($users), 'categories.xlsx');
}

public function export_unit(Request $request)
{
    //  $users = User::all();
       $users =  Unit::select('*')->orderBy('id','desc')->get();

    return Excel::download(new UnitsExport($users), 'units.xlsx');
}

public function import_ingredients(Request $request)
{ 
    $file = $request->file('file');
    $file_path = $file->getPathName();
    $rows = array_map('str_getcsv', file($file_path));
    $header = array_shift($rows);

    foreach ($rows as $row) {
        $data = array_combine($header, $row);
       $groupId =  DislikeGroup::create([
            'name' => $data['group'],
            'name_ar' => $data['group_ar'],
        ]);
        $unitId =  DislikeUnit::create([
            'unit' => $data['unit'],
            'unit_ar' => $data['unit_ar'],
        ]);
        $categoryId =  DislikeCategory::create([
            'name' => $data['category'],
            'name_ar' => $data['category_ar'],
        ]);
        DislikeItem::create([
            'name' => $data['name'],
            'name_ar' => $data['name_ar'],
            'group_id' => $groupId->id,
            'category_id' => $categoryId->id,
            'unit_id' => $unitId->id,
        ]);
    }

    return redirect()->back()->with('success', 'Group added successfully');
}

public function import_groups(Request $request)
{ 
    $file = $request->file('file');
    $file_path = $file->getPathName();
    $rows = array_map('str_getcsv', file($file_path));
    $header = array_shift($rows);

    foreach ($rows as $row) {
        $data = array_combine($header, $row);
         DislikeGroup::create([
            'name' => $data['name'],
            'name_ar' => $data['name_ar'],
        ]);
        
    }

    return redirect()->back()->with('success', 'Group added successfully');
}

public function import_category(Request $request)
{ 
    $file = $request->file('file');
    $file_path = $file->getPathName();
    $rows = array_map('str_getcsv', file($file_path));
    $header = array_shift($rows);

    foreach ($rows as $row) {
        $data = array_combine($header, $row);
         DislikeCategory::create([
            'name' => $data['category'],
            'name_ar' => $data['category_ar'],
        ]);
        
    }

    return redirect()->back()->with('success', 'Group added successfully');
}

public function import_unit(Request $request)
{ 
    $file = $request->file('file');
    $file_path = $file->getPathName();
    $rows = array_map('str_getcsv', file($file_path));
    $header = array_shift($rows);

    foreach ($rows as $row) {
        $data = array_combine($header, $row);
         DislikeUnit::create([
            'unit' => $data['unit'],
            'unit_ar' => $data['unit_ar'],
        ]);
        
    }

    return redirect()->back()->with('success', 'Group added successfully');
}


public function print_ingredient()
{
    // retrieve the user data that you want to print
     $users = DislikeItem::with('group','category','unit')->select('*')->orderBy('name')->get();
    
    // return a view that displays the user data in a printable format
    return view('admin.ingredient.print_ingredient', compact('users'));
}

public function print_group()
{
    // retrieve the user data that you want to print
     $users =   DislikeGroup::select('*')->orderBy('id','desc')->get();
    
    // return a view that displays the user data in a printable format
    return view('admin.ingredient.print_group', compact('users'));
}

public function print_category()
{
    // retrieve the user data that you want to print
     $users =  DislikeCategory::select('*')->orderBy('id','desc')->get();
    
    // return a view that displays the user data in a printable format
    return view('admin.ingredient.print_category', compact('users'));
}

public function print_unit()
{
    // retrieve the user data that you want to print
     $users =  Unit::select('*')->orderBy('id','desc')->get();
    
    // return a view that displays the user data in a printable format
    return view('admin.ingredient.print_unit', compact('users'));
}

}
