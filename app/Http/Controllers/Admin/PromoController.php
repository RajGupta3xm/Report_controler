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
use App\Models\UserUsedPromoCode;
use App\Models\SubscriptionMealPlanVariant;
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
               $plan = SubscriptionPlan::select('id','name')->orderBy('id','DESC')
              ->get()->each(function($plan){
                   $plan->variant = SubscriptionMealPlanVariant::select('id','meal_plan_id','variant_name')
                   ->where('meal_plan_id',$plan->id)
                   ->orderBy('id','DESC')
                   ->get();
              });
            //    $plan_variants = SubscriptionMealPlanVariant::select('id','meal_plan_id','variant_name')->orderBy('id','asc')->get();
                    $promoCode = PromoCode::withcount('promoCodeUsed')->with('promoCodeDietPlan')->orderBy('id','desc')->get()
                  ->each(function($promoCode){
                    if(!empty($promoCode->discount)){
                      $promoCode->totalValue = $promoCode->promo_code_used_count * $promoCode->discount ;
                    }else{
                        $promoCode->totalValue = $promoCode->promo_code_used_count * $promoCode->price ;
                    }
                });
            //   $codeUsed = PromoCode::withcount('promoCodeUsed')->get();
            
            // $data['dietplan'] = $dietplan;
             $data['promoCode'] = $promoCode;
            $data['plan'] = $plan;
            return view('admin.promoCode.promo_list')->with($data);
        }
    }

    public function promoCode_submit(Request $request ){

          $data=[
         "name" => $request->input('promo_name'),
        //  'diet_plan_type_id' => implode(',', $request->diet_plan_type_id),
         "discount" => $request->input('discount'),
         "price" => $request->input('price'),
         "maximum_discount_uses" => $request->input('maximum_discount_uses'),
         "limit_to_one_use" => $request->input('v4'),
         "start_date" => $request->input('valid_from'),
         "end_date" => $request->input('valid_till'),
         "promo_code_ticket_id" =>  substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 14),
     ];

     
 
     if(!empty($request->image)){
         $filename = $request->image->getClientOriginalName();
         $imageName = time().'.'.$filename;
         if(env('APP_ENV') == 'local'){
             $return = $request->image->move(
             base_path() . '/public/uploads/promo_image/', $imageName);
         }else{
             $return = $request->image->move(
             base_path() . '/../public/uploads/promo_image/', $imageName);
         }
         $url = url('/uploads/promo_image/');
      $data['image'] = $url.'/'. $imageName;
      
     }
 
 $insert = PromoCode::create($data);

 $variant_id = $request->variant_id;
   if(isset($request->plan_id) && count($request->plan_id) > 0){
       foreach ($request->plan_id as $key=> $plan){
            $plans=SubscriptionMealPlanVariant::where('meal_plan_id',$key)->get();
            foreach($plans as $planss){
                PromoCodeDietPlan::create([
                    'promo_code_id' =>  $insert->id,
                    'meal_plan_id'  => $planss['meal_plan_id'] , 
                    'variant_id'    => $planss['id'],
                ]);
            }
       }                
    }
    if(isset($request->variant_id) && count($request->variant_id) > 0){
        foreach ($request->variant_id as $k=> $variant_ids){
            $variants=SubscriptionMealPlanVariant::where('id',$k)->get();
            foreach($variants as $variant){
                PromoCodeDietPlan::create([
                    'promo_code_id' =>   $insert->id,
                    'meal_plan_id'  => $variant['meal_plan_id'] , 
                    'variant_id'    => $variant['id'],
                ]);
            }
        }                  
     }


//  foreach($request->items  as $item)
//      {
//          $plan = PromoCodeDietPlan::create([
//             'promo_code_id' => $insert->id,
//             'meal_plan_id'  => $item['meal_plan'] , 
//             'variant_id'    => $item['variant_name'],
//         ]);
//      }
 
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

public function filter_list(Request $request) {
    $start_date = date('Y-m-d 00:00:00', strtotime($request->input('start_date')));
    $end_date = date('Y-m-d 23:59:59', strtotime($request->input('end_date')));
    if ($request->input('start_date') && $request->input('end_date')) {
        $plan = SubscriptionPlan::select('id','name')->orderBy('id','DESC')
        ->get()->each(function($plan){
             $plan->variant = SubscriptionMealPlanVariant::select('id','meal_plan_id','variant_name')
             ->where('meal_plan_id',$plan->id)
             ->orderBy('id','DESC')
             ->get();
        });
        $promoCode = PromoCode::withcount('promoCodeUsed')->where('status', '<>', 99)
            ->where('start_date','>=',$start_date)
            ->where('end_date','<=', $end_date)
                ->orderBy('id', 'DESC')
                ->get();
      
    } 
    $data['start_date'] = $request->input('start_date');
    $data['end_date'] = $request->input('end_date');
    $data['promoCode'] = $promoCode;
    $data['plan'] = $plan;

    return view('admin.promoCode.promo_list')->with($data);
}

public function get_data(Request $request)
    {
        if($request->ajax()){
            $data = SubscriptionMealPlanVariant::where('meal_plan_id',$request->id)->get();
            return Response($data);
        }
     }


public function print_promo()
{

    // retrieve the user data that you want to print
      $users =  PromoCode::withcount('promoCodeUsed')->orderBy('id','asc')->get();
    
    // return a view that displays the user data in a printable format
    return view('admin.promoCode.print_promo', compact('users'));
}

}
