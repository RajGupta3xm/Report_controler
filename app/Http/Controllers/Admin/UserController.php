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
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserDislike;
use App\Models\Subscription;
use App\Models\DislikeItem;
use App\Models\Order;
use App\Models\SubscriptionPlan;
use App\Models\UserAddress;
use App\Models\DietPlanTypesMealCalorieMinMax;
use App\Models\CalorieRecommend;
use App\Models\UserCaloriTarget;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class UserController extends Controller {

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
            // $userList = [];
               $user = User::join('subscriptions','users.id','=','subscriptions.user_id')
               ->select('users.*','subscriptions.delivery_status')->orderBy('id', 'DESC')->get()
              ->each(function($user){
                $user->TotalOrder = Order::join('order_on_address','orders.id','=','order_on_address.order_id')
                ->select('orders.id','order_on_address.*')
                ->where('orders.user_id',$user->id)
                ->where('order_on_address.user_id',$user->id)
                ->get();
                // $user->countTotalOrder = Order::where('user_id',$user->id)->count();
              });
             
        // dd($user);
        // die;
           $data['users'] = $user;
           
            
            return view('admin.users.user_list')->with($data);
        }
        
    }

    public function filterUserData(Request $request){
     $status = $request->input('status');
     if($status == 'active'){
     $user = User::join('subscriptions','users.id','=','subscriptions.user_id')
     ->select('users.*','subscriptions.delivery_status')
     ->where('subscriptions.delivery_status','active')
     ->orderBy('id', 'DESC')->get()
    ->each(function($user){
      $user->TotalOrder = Order::join('order_on_address','orders.id','=','order_on_address.order_id')
      ->select('orders.id','order_on_address.*')
      ->where('orders.user_id',$user->id)
      ->where('order_on_address.user_id',$user->id)
      ->get();
    });
}
elseif($status == 'inactive'){
    $user = User::join('subscriptions','users.id','=','subscriptions.user_id')
    ->select('users.*','subscriptions.delivery_status')
    ->where('subscriptions.delivery_status','!=','active')
    ->where('subscriptions.delivery_status','!=','terminted')
    ->where('subscriptions.delivery_status','!=','paused')
    ->where('subscriptions.delivery_status','!=','upcoming')
    ->orderBy('id', 'DESC')->get()
   ->each(function($user){
     $user->TotalOrder = Order::join('order_on_address','orders.id','=','order_on_address.order_id')
     ->select('orders.id','order_on_address.*')
     ->where('orders.user_id',$user->id)
     ->where('order_on_address.user_id',$user->id)
     ->get();
   });
}elseif($status == 'paused'){
    $user = User::join('subscriptions','users.id','=','subscriptions.user_id')
    ->select('users.*','subscriptions.delivery_status')
    ->where('subscriptions.delivery_status','paused')
    ->orderBy('id', 'DESC')->get()
   ->each(function($user){
     $user->TotalOrder = Order::join('order_on_address','orders.id','=','order_on_address.order_id')
     ->select('orders.id','order_on_address.*')
     ->where('orders.user_id',$user->id)
     ->where('order_on_address.user_id',$user->id)
     ->get();
   });

}else{
    $user = User::join('subscriptions','users.id','=','subscriptions.user_id')
    ->select('users.*','subscriptions.delivery_status')
    ->where('subscriptions.delivery_status','terminted')
    ->orderBy('id', 'DESC')->get()
   ->each(function($user){
     $user->TotalOrder = Order::join('order_on_address','orders.id','=','order_on_address.order_id')
     ->select('orders.id','order_on_address.*')
     ->where('orders.user_id',$user->id)
     ->where('order_on_address.user_id',$user->id)
     ->get();
   });
}

 $data['users'] = $user;
 
     if ($data) {
       return view('admin.users.user_list')->with($data);
     }
  }

    public function show(Request $request, $id = null) {
        if (Auth::guard('admin')->check()) {
              $id = base64_decode($id);
               $user = User::where('id',$id)->first();     

            //   return $user->pets_count;
            // $user_dislikes =[];
            if($user){
                      $user_detail = UserProfile::with('fitness','dietplan')->where('user_id',$user->id)->first();
                       $userCalorieTarget = UserCaloriTarget::where('user_id',$user->id)->first(); 
                        $calorie = CalorieRecommend::select('recommended')->where('id',$userCalorieTarget->custom_result_id)->first(); 
                      if(!empty($calorie)){
                         $UserGainCalorie = DietPlanTypesMealCalorieMinMax::where('meal_calorie',$calorie->recommended)->where('diet_plan_type_id',$user_detail->diet_plan_type_id)->first();
                      }

                     $item_id = UserDislike::where('user_id',$user->id)->get();
                   if($item_id){
                    foreach($item_id as $item_ids){
                          $user_dislikes = DislikeItem::where('id',$item_ids['item_id'])->get();
                          if($user_dislikes){
                            $data['user_dislike'] = $user_dislikes;

                          }else{
                            $data['user_dislike'] = '';

                          }
                            // array_push($user_dislikes,$user_dislike);
                    }
                   }
            }else{
                
            }
              $user_previous_plan = Subscription::join('subscription_plans','subscriptions.plan_id','=','subscription_plans.id')
            ->join('subscriptions_meal_plans_variants','subscriptions.variant_id','=','subscriptions_meal_plans_variants.id')
            ->join('orders','subscriptions.variant_id','=','orders.variant_id')
            ->select('orders.id as order_id','subscriptions.start_date','subscriptions.plan_id','subscription_plans.name','subscriptions_meal_plans_variants.option1','subscriptions_meal_plans_variants.plan_price','subscriptions_meal_plans_variants.no_days','subscriptions_meal_plans_variants.plan_price','subscriptions.id','subscriptions.status','subscriptions.user_id','subscriptions_meal_plans_variants.id as variant_id')
           ->where(['subscriptions.delivery_status'=>'terminted','subscriptions.user_id'=>$id])
           ->where(['subscriptions.plan_status'=>'plan_inactive'])
           ->where(['orders.user_id'=>$id,'orders.plan_status'=>'plan_inactive'])
           ->get()->each(function($user_previous_plan){
            $puchase_on = $user_previous_plan->start_date;
            $user_previous_plan->puchase_on = date('d M', strtotime($puchase_on));
            $dates = Carbon::createFromFormat('Y-m-d',$user_previous_plan->start_date);
            $expired_on = $dates->addDays($user_previous_plan->no_days);
            $user_previous_plan->expired_on = date('d M', strtotime($expired_on));
        
           });
     
               $data['user_previous_plan'] = $user_previous_plan;

                   $userDetail = UserProfile::select('user_id','subscription_id','variant_id')->where('user_id',$id)->first();
              
                   $user_current_plan = UserProfile::join('subscriptions','user_profile.variant_id','=','subscriptions.variant_id')
            ->join('orders','user_profile.user_id','=','orders.user_id')
            ->join('subscription_plans','user_profile.subscription_id','=','subscription_plans.id')
            ->join('subscriptions_meal_plans_variants','user_profile.subscription_id','=','subscriptions_meal_plans_variants.meal_plan_id')
            ->select('subscriptions.start_date','orders.id as order_id','subscription_plans.name','subscriptions_meal_plans_variants.option1','subscriptions_meal_plans_variants.plan_price','user_profile.available_credit','subscriptions_meal_plans_variants.no_days','subscriptions.id','subscriptions.status','user_profile.user_id','user_profile.subscription_id')
            ->where('user_profile.user_id',$id)
            ->where('subscriptions.user_id',$id)
            ->where(['orders.plan_id'=>$userDetail->subscription_id,'orders.variant_id'=>$userDetail->variant_id])
            ->where('subscriptions.plan_id',$userDetail->subscription_id)
            ->where('orders.plan_status','plan_active')
            ->where('subscriptions_meal_plans_variants.id',$userDetail->variant_id)
            ->where(function($q){
                $q->where('subscriptions.delivery_status','active')
                   ->orwhere('subscriptions.delivery_status','paused');
                    })
            ->first();
            if(!empty($user_current_plan)){
                 $puchase_on = $user_current_plan->start_date;
                  $user_current_plan['puchase_on'] = date('d/m/Y', strtotime($puchase_on));
                 $dates = Carbon::createFromFormat('Y-m-d',$user_current_plan->start_date);
                 $expired_on = $dates->addDays($user_current_plan->no_days);
                  $user_current_plan['expired_on'] = date('d/m/Y', strtotime($expired_on));
            }

                $data['user_current_plan'] = $user_current_plan;
            $data['user'] = $user;

            $data['user_details'] = $user_detail;
           
             $data['userCalorieTargets'] = $UserGainCalorie;

        
            if ($data) {                
                
                return view('admin.users.user_detail')->with($data);
            } else {
                return redirect('admin/dashboard')->with('error', 'User not found');
            }
        } else {
            return redirect()->intended('admin/login');
        }
    }

    public function change_user_status(Request $request){
        $id = $request->input('id');
        $status = $request->input('action');
       $update = User::find($id)->update(['status' => $status]);
       if ($update) {
           return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
       } else {
           return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
       }
   }


   public function filter_list(Request $request) {
    $start_date = date('Y-m-d 00:00:00', strtotime($request->input('start_date')));
    $end_date = date('Y-m-d 23:59:59', strtotime($request->input('end_date')));
    if ($request->input('start_date') && $request->input('end_date')) {
        $user = User::where('status', '<>', 99)
                ->whereBetween('created_at', [$start_date, $end_date])
                ->orderBy('id', 'DESC')
                ->get();
    } else {
        $user = User::where('status', '<>', 99)->orderBy('id', 'DESC')->get();
    }
    $data['start_date'] = $request->input('start_date');
    $data['end_date'] = $request->input('end_date');
     $data['users'] = $user;
    return view('admin.users.user_list')->with($data);
}

public function export(Request $request)
{
    //  $users = User::all();
      $users = User::join('subscriptions','users.id','=','subscriptions.user_id')
     ->select('users.*','subscriptions.delivery_status')->orderBy('id', 'DESC')->get()
    ->each(function($users){
      $users->TotalOrder = Order::join('order_on_address','orders.id','=','order_on_address.order_id')
      ->select('orders.id','order_on_address.*')
      ->where('orders.user_id',$users->id)
      ->where('order_on_address.user_id',$users->id)
      ->get();
    });

    return Excel::download(new UsersExport($users), 'users.xlsx');
}

}
