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
use App\Models\SubscriptionPlan;
use App\Models\PromoCodeDietPlan;
use App\Models\PromoCode;
use App\Models\UserCaloriTarget;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class PromoController extends Controller {

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
             $dietplan = SubscriptionPlan::select('id','name')->orderBy('id','asc')->get();
             $promoCode = PromoCode::select('*')->orderBy('id','asc')->get();
            $data['dietplan'] = $dietplan;
            $data['promoCode'] = $promoCode;
            return view('admin.promoCode.promo_list')->with($data);
        }
    }

    public function promoCode_submit(Request $request ){
         $data=[
         "name" => $request->input('promo_name'),
        //  'diet_plan_type_id' => implode(',', $request->diet_plan_type_id),
         "discount" => $request->input('discount'),
         "price" => $request->input('price'),
         "start_date" => $request->input('valid_from'),
         "end_date" => $request->input('valid_till'),
     ];
 
     if(!empty($request->image)){
         $filename = $request->image->getClientOriginalName();
         $imageName = time().'.'.$filename;
         if(env('APP_ENV') == 'local'){
             $return = $request->image->move(
             base_path() . '/public/uploads/promo_image/', $imageName);
         }else{
             $return = $request->banner_image->move(
             base_path() . '/../public/uploads/promo_image/', $imageName);
         }
         $url = url('/uploads/promo_image/');
      $data['image'] = $url.'/'. $imageName;
      
     }
 
 $insert = PromoCode::create($data);
 foreach($request->diet_plan_type_id  as $id)
 {
     PromoCodeDietPlan::create([
        'promo_code_id' => $insert->id,
         'meal_plan_id'  => $id   
    ]);
 }
 
 if($insert){
    return redirect('admin/promo-code-management')->with('success', ' Insert successfully.');
 }
 else {
    return redirect()->back()->with('error', 'Some error occurred while update ');
 }
 
 }

 public function change_status(Request $request){
    $id = $request->input('id');
     $status = $request->input('action');
    $update = PromoCode::find($id)->update(['status' => $status]);
    if ($update) {
        return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
    } else {
        return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
    }
}

public function promoCode_delete(Request $request ){
    $id = $request->input('id');
     $promoCode_delete = PromoCode::find($id);
    $delete = $promoCode_delete->delete();
    if ($delete) {
      return response()->json(['status' => true, 'success_code' => 200, 'message' => 'promo code deleted successfully']);
  } else {
      return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while deleting evepromo code']);
  }
}

}
