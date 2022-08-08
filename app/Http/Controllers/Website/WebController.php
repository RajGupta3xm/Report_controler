<?php

namespace App\Http\Controllers\Website;


use Auth;
use DB;
use Response;
use Session;
use App\Http\Requests\UsersRequest as StoreRequest;
use App\Http\Requests\UsersRequest as UpdateRequest;
use App\Http\Controllers\CrudOverrideController;
use Illuminate\Http\Request;
use App\Models\Users;

use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class WebController extends Controller {

    private $URI_PLACEHOLDER;
    private $jsondata;
    private $redirect;
    protected $message;
    protected $status;
    private $prefix;

    public function __construct() {

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
            $user_count = 0;
            $users = Users::where('status', '<>', 99)->orderBy('id', 'DESC')->get();
            if ($users) {
                $user_count = count($users);
                $users = Users::where('status', '<>', 99)->orderBy('id', 'DESC')->limit(5)->get();
                $data['users'] = $users;
            } else {
                $data['users'] = [];
            }
            $data['total_count'] = $user_count;
            $posts = Post::where('status', '1')->get();
            $data['total_video'] = count($posts);
            return view('admin.dashboard')->with($data);
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

    public function index(){
        // dd('hi');
        return view('web.index');
    }

    public function about(){
        return view('web.about');
    }

    public function terms_condition(){
        return view('web.terms_condition');
    }

    public function privacy_policy(){
        return view('web.privacy_policy');
    }

    public function interior(){
        return view('web.interior');
    }

    public function exterior(){
        return view('web.exterior');
    }

    public function performance(){
        return view('web.performance');
    }

    public function lighting(){
        return view('web.lighting');
    }

    public function wheels(){
        return view('web.wheels');
    }

    public function parts(){
        return view('web.parts');
    }


    public function product(){
        return view('web.product');
    }

    public function product_single(){
        return view('web.product_single');
    }

    public function add_new_address(){
        return view('web.add_new_address');
    }

    public function payment(){
        return view('web.payment');
    }

    public function add_new_card(){
        return view('web.add_new_card');
    }

    public function mycart(){
        return view('web.mycart');
    }

    public function checkout(){
        return view('web.checkout');
    }

    public function myaccount(){
        return view('web.myaccount');
    }

    public function set_session_details(Request $request){
        $sessionArray=['user_id'=>$request->user_id,'token'=>$request->token,'name'=>$request->name,'email'=>$request->email,'image'=>$request->image];
    }

}
