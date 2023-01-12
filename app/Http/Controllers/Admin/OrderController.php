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
use App\Models\SubscriptionOrder;
use App\Models\SubscriptionMealPlanVariant;
use App\Models\Subscription;
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
use App\Models\Order;
use App\Models\SubscriptionPlan;
use App\Models\UserCaloriTarget;
use App\Models\StaffGroup;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class OrderController extends Controller {

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
             $user = User::select('id','name')->where('status','1')->get()
             ->each(function($user){
                 $user->order = SubscriptionOrder::join('subscriptions','subscription_orders.subscription_id','=','subscriptions.id')
                 ->select('subscription_orders.id as order_id','subscription_orders.created_at','subscription_orders.amount','subscriptions.plan_id')
                 ->where('subscription_orders.user_id',$user->id)
                 ->get()
                 ->each(function($order){
                       $order->plans = SubscriptionMealPlanVariant::with('plan','dietPlans')
                       ->where('meal_plan_id',$order->plan_id)->get();
                      
                    });
             });
              

                 $data['orders'] = $user;
            return view('admin.order.order_list')->with($data);
        }
    }
    

    public function change_status(Request $request){
         $id = $request->input('id');
         $status = $request->input('action');
        $update = Subscription::find($id)->update(['status' => $status]);
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
        }
    }

    public function change_previousPlan_status(Request $request){
        $id = $request->input('id');
        $status = $request->input('action');
       $update = Subscription::find($id)->update(['status' => $status]);
       if ($update) {
           return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
       } else {
           return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
       }
   }

   public function show(Request $request, $id = null) {
     if (Auth::guard('admin')->check()) {
          $id = base64_decode($id);     
           $user = User::where('id',$id)->first();   
          if($user){
            $user_detail = UserProfile::with('fitness','dietplan')->where('user_id',$user->id)->first();
             $userCalorieTarget = UserCaloriTarget::where('user_id',$user->id)->first(); 
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

     $data['user'] = $user;

     $data['user_details'] = $user_detail;
    
     $data['userCalorieTargets'] = $userCalorieTarget;
      return view('admin.order.order_detail')->with($data);
        
    } else {
        return redirect()->intended('admin/login');
    }
}

public function updateDeliveryStatus(Request $request, $id = NULL){
    $id = $request->input('id');
   $update = Order::find($id)->update(['status' => 'delivered']);
   if ($update) {
       return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
   } else {
       return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
   }
}

}
