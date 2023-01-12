<?php

namespace App\Http\Controllers\Admin;


use Auth;
use DB;
use Response;
use Session;
use App\Http\Requests\UsersRequest as StoreRequest;
use App\Http\Requests\UsersRequest as UpdateRequest;
use App\Http\Controllers\CrudOverrideController;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserAddress;
use App\Models\DeliverySlot;
use App\Models\Order;
use App\Models\SubscriptionPlan;
use App\Models\MealSchedules;
use App\Models\SubscriptionMealVariantDefaultMeal;
use App\Models\SubscriptionOrder;
use App\Models\Admin;
use App\Models\Subscription;
use App\Models\ReportReason;
use App\Models\AdminNotification;
use App\Models\Meal;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AdminController extends Controller {

    protected $guard = "admin";
    private $URI_PLACEHOLDER;
    private $jsondata;
    private $redirect;
    protected $message;
    protected $status;
    private $prefix;

    public function __construct() {
        $this->middleware('admin');

        $this->jsondata = [];
        $this->message = false;
        $this->redirect = false;
        $this->status = false;
        $this->prefix = \DB::getTablePrefix();
        $this->URI_PLACEHOLDER = \Config::get('constants.URI_PLACEHOLDER');
//                 dd($this->middleware('auth'));
    }

    public function getLogout(request $request) {
        Auth::guard('admin')->logout();
        Session::forget('admin_logged_in');

        return redirect('admin/login');
    }

    public function error() {
        return view('error.error');
    }

//    public function dashboard(Request $request) {
//        $data['content'] = StaticPage::getData($request);
//        $data['current_url'] = url('/');
//        return view('dashboard')->with($data);
//    }

    public function dashboard(Request $request) {
        if (!Auth::guard('admin')->check()) {
//            dd('hello');
            return redirect()->intended('admin/login');
        } else {
            $activeUser = 0;
            $pausedUser = 0;
            $expiredUser = 0;
            $inactiveUser = 0;


             $data['activeUser'] = Subscription::where('delivery_status','active')->count();
             $data['pausedUser'] = Subscription::where('delivery_status','paused')->count();
             $data['expiredUser'] = Subscription::where('delivery_status','terminted')->count();
             $data['inactiveUser'] = User::where('status','0')->count();
              $data['totalOrder'] = SubscriptionOrder::where('payment_status','completed')->count();
              $userList = [];
             $recent_order = User::join('user_profile','users.id','=','user_profile.user_id')
            ->join('subscriptions','Users.id','=','subscriptions.user_id')
            ->join('orders','Users.id','=','orders.user_id')
            ->select('users.id','users.name as user_name','users.mobile','user_profile.subscription_id','subscriptions.start_date','orders.id as order_id')
            ->where('subscriptions.delivery_status','active')
            ->get();
            if(!empty($recent_order)){
                foreach($recent_order as $recent_orders){
                $recent_orders->get_plan = SubscriptionPlan::join('subscriptions_meal_plans_variants','subscription_plans.id','=','subscriptions_meal_plans_variants.meal_plan_id')
                           ->select('subscriptions_meal_plans_variants.option1','subscription_plans.name')
                           ->where('subscription_plans.id',$recent_orders->subscription_id)
                           ->get();

                           array_push($userList,$recent_orders);
                }

            }
           
            $data['recent_order'] = $userList;
            return view('admin.dashboard')->with($data);
        }
    }

    public function upcomingDeliveriesShow(Request $request) {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
              $start_date = date('Y-m-d', strtotime($request->input('start_date')));
                $date = $start_date;
           
             $delivery_slot = DeliverySlot::select('id','name','start_time','end_time')->get()
            ->each(function($delivery_slot) use($date){
                $delivery_slot->address = Order::join('user_address','orders.address_id','=','user_address.id')
                ->join('users','orders.user_id','=','users.id')
                ->join('subscriptions','orders.user_id','=','subscriptions.user_id')
                ->select('orders.id as order_id','orders.user_id','user_address.area','user_address.street','users.name as user_name','subscriptions.plan_id','subscriptions.start_date','users.image')
                ->where('subscriptions.delivery_status','active')
                ->where('subscriptions.start_date',$date)
                ->where(['user_address.delivery_slot_id'=>$delivery_slot->id,'user_address.status'=>'active'])
                ->get()
                ->each(function($address){
                       $address->meal_schedule = MealSchedules::join('subscription_meal_groups','meal_schedules.id','=','subscription_meal_groups.meal_schedule_id')
                       ->select('meal_schedules.id','meal_schedules.name')
                       ->where('subscription_meal_groups.plan_id',$address->plan_id)
                       ->get()->each(function($meal_schedule) use($address){
                               $meal_schedule->meal = Meal::join('subscription_meal_plan_variant_default_meal','meals.id','=','subscription_meal_plan_variant_default_meal.item_id')
                                 ->select('meals.id as meal_id','meals.name')
                                 ->where('subscription_meal_plan_variant_default_meal.meal_schedule_id',$meal_schedule->id)
                                 ->where('subscription_meal_plan_variant_default_meal.meal_plan_id',$address->plan_id)
                                 ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                                 ->get();
                       });
                });
                
            });
                  
            $data['startDate'] = date('d/m/Y',strtotime($date));
               $data['delivery_slots'] = $delivery_slot;
            return view('admin.upcoming_deliveries')->with($data);
        }
    }


    public function upcoming_deliveries() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
            
                $date = date('Y-m-d',strtotime(' +1day'));
             
           
             $delivery_slot = DeliverySlot::select('id','name','start_time','end_time')->get()
            ->each(function($delivery_slot) use($date){
                $delivery_slot->address = Order::join('user_address','orders.address_id','=','user_address.id')
                ->join('users','orders.user_id','=','users.id')
                ->join('subscriptions','orders.user_id','=','subscriptions.user_id')
                ->select('orders.id as order_id','orders.user_id','orders.status','user_address.area','user_address.street','users.name as user_name','subscriptions.plan_id','subscriptions.start_date','users.image')
                ->where('subscriptions.delivery_status','active')
                ->where('subscriptions.start_date',$date)
                ->where(['user_address.delivery_slot_id'=>$delivery_slot->id,'user_address.status'=>'active'])
                ->get()
                ->each(function($address){
                       $address->meal_schedule = MealSchedules::join('subscription_meal_groups','meal_schedules.id','=','subscription_meal_groups.meal_schedule_id')
                       ->select('meal_schedules.id','meal_schedules.name')
                       ->where('subscription_meal_groups.plan_id',$address->plan_id)
                       ->get()->each(function($meal_schedule) use($address){
                               $meal_schedule->meal = Meal::join('subscription_meal_plan_variant_default_meal','meals.id','=','subscription_meal_plan_variant_default_meal.item_id')
                                 ->select('meals.id as meal_id','meals.name')
                                 ->where('subscription_meal_plan_variant_default_meal.meal_schedule_id',$meal_schedule->id)
                                 ->where('subscription_meal_plan_variant_default_meal.meal_plan_id',$address->plan_id)
                                 ->where('subscription_meal_plan_variant_default_meal.is_default','1')
                                 ->get();
                       });
                });
                
            });
                  
            $data['startDate'] = date('d/m/Y',strtotime($date));
                $data['delivery_slots'] = $delivery_slot;
            return view('admin.upcoming_deliveries')->with($data);
        }
    }

    public function change_password(Request $request){
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
            $data['edit_password'] = Admin::where('id',Auth::guard('admin')->id())->first();
             return view('admin.change-password')->with($data);
            
        }
    }

    public function password_update(Request $request){
    
        $this->validate($request, [
            'old_password'     => 'required',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user_id = Auth::guard('admin')->id();    
        $user_password =Admin:: find($user_id);       
        if(\Hash::check($request->input('old_password'), $user_password->password))
        {          
        //   $user_id = \Auth::User()->id;                       
          $obj_user = Admin::find($user_id);
          $data['password'] = \Hash::make($request->input('new_password'));
         $update = Admin::find($user_id)->update($data);
         return redirect('admin/change_password')->with('success', 'Password update successfully.');
        }
        else
        {           
           return redirect()->back()->with('error', 'Please enter correct current password ');
        } 
}

public function edit_profile(Request $request){
    if (!Auth::guard('admin')->check()) {
        return redirect()->intended('admin/login');
    } else {
            $data['edit_admin'] = Admin::where('id',Auth::guard('admin')->id())->first();
         return view('admin.edit-profile')->with($data);
        
    }
    
}


public function edit_update(Request $request, $id=null){
    $id = base64_decode($id);
     $data=[
        "name" => $request->input('name'),
    ];

    if(!empty($request->image)){
        $filename = $request->image->getClientOriginalName();
        $imageName = time().'.'.$filename;
        if(env('APP_ENV') == 'local'){
            $return = $request->image->move(
            base_path() . '/public/uploads/admin_image/', $imageName);
        }else{
            $return = $request->banner_image->move(
            base_path() . '/../public/uploads/admin_image/', $imageName);
        }
        $url = url('/uploads/admin_image/');
     $data['image'] = $url.'/'. $imageName;
     
    }

$update = Admin::find($id)->update($data);
if($update){
   return redirect('admin/dashboard')->with('success', ' update successfully.');
}
else {
   return redirect()->back()->with('error', 'Some error occurred while update ');
}

}
    
    public function reason_list(Request $request) {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
            $category = ReportReason::where('status', '<>', '99')->orderBy('id', 'DESC')->get();
            $data['reasons'] = $category;
            return view('admin.report.reason_list')->with($data);
        }
    }

    public function reason_store(Request $request) {
        $insert_arr = [
            'reason' => ucwords($request->input('reason'))
        ];


        $add = ReportReason::create($insert_arr);
        if ($add) {
            return redirect('admin/reason-management')->with('success', 'Reason added succesfully');
        } else {
            
        }
        return back()->withInput()->with('error', 'Error while adding reason');
    }

    public function change_reason_status(Request $request) {
        $id = $request->input('id');
        $status = $request->input('action');
        $update = ReportReason::find($id)->update(['status' => $status]);
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
        }
    }

    public function delete_reason(Request $request) {
        $id = $request->input('id');
        $update = ReportReason::find($id)->update(['status' => '99']);
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Reason deleted successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while deleting reason']);
        }
    }

    public function edit_reason(Request $request, $id = null) {
        $id = base64_decode($id);
        $category = ReportReason::find($id);
        if ($category) {
            $data['reason'] = $category;
            return view('admin.report.edit_reason')->with($data);
        } else {
            return redirect('admin/reason-management')->with('error', 'Reason not found');
        }
    }

    public function reason_update(Request $request, $id = null) {
        $id = base64_decode($id);
        $insert_arr = [
            'reason' => ucwords($request->input('reason'))
        ];
        $update = ReportReason::where('id', $id)->update($insert_arr);
        if ($update) {
            return redirect('admin/reason-management')->with('success', 'Reason Updated Succesfully');
        }
        return back()->withInput()->with('error', 'Error while updating Reason');
    }
    
    public function notificationList(Request $request) {
        if (!Auth::guard('admin')->check()) {
//            dd('hello');
            return redirect()->intended('admin/login');
        } else {
            $notifications=[];
            $list = AdminNotification::orderBy('id', 'DESC')->get();
            if ($list) {
                    
                    foreach($list as $notifi){
                        $user_list=[];
                        $users=explode(',',$notifi->user_id);
                        foreach($users as $user){
                            $getUser=Users::find($user);
                            if($getUser){
                                array_push($user_list,$getUser->name);
                            }
                        }
                        $notifi['user_list']=implode(', ',$user_list);
                        array_push($notifications,$notifi);
                    }
                $data['notifications'] = $notifications;
            } else {
                $data['notifications'] = [];
            }
            return view('admin.notification.notifications_list')->with($data);
        }
    }
    
    public function notificationDetails($id=null) {
        if (!Auth::guard('admin')->check()) {
//            dd('hello');
            return redirect()->intended('admin/login');
        } else {
            $id = base64_decode($id);
            $notification = AdminNotification::find($id);
            if ($notification) {
                $user_list=[];
                $users=explode(',',$notification->user_id);
                foreach($users as $user){
                    $getUser=Users::find($user);
                    if($getUser){
                        array_push($user_list,$getUser->name);
                    }
                }
                $notification['user_list']=implode(', ',$user_list);
                $data['notification'] = $notification;

                return view('admin.notification.notification_detail')->with($data);
            } else {
                return redirect('admin/notification-management')->with('error', 'Notification not found');
            }
        }
    }
    
    public function customNotification(Request $request) {        
        $users = Users::where('status', '<>', 99)->orderBy('id', 'DESC')->get();
        if($users){
            $data['users'] = $users;
        }else{
            $data['users'] = [];
        }
        $validator = \Validator::make($request->all(), [
                    'users' => 'required',
                    'title' => 'required',
                    'message' => 'required'
                        ], [
                    'users.required' => 'Please select users.',
                    'title.required' => 'Please enter title.',
                    'message.required' => 'Please enter message.'
        ]);

        if ($validator->fails()) {             
            if($request->all()){
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                return view('admin.notification.compose_new')->with($data);
            }
                   
        } else {
            $add=[
                'user_id'=>implode(',',$request->input('users')),
                'title'=>$request->input('title'),
                'message'=>$request->input('message')
            ];

            $add=AdminNotification::create($add);
            if($add){
                $selected_users=$request->input('users');
                foreach($selected_users as $user){
                    $Finduser=Users::find($user);
                    if($Finduser->push_notification == 'on'){
                        $notifiable=true;
                    }else{
                        $notifiable=false;
                    }
                    sendNotification($Finduser->id, $Finduser->device_token, $request->input('title'), $request->input('message'), 'admin-notification', ['id'=>'1'], $notifiable);
                }

                return redirect('admin/notification-management')->with('success', 'Notification Sent Succesfully');
            }else{
                return back()->withInput()->with('error', 'Error while sending notification');
            }
            
        }
        
        
    }

}
