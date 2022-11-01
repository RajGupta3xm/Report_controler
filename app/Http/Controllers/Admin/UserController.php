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
            $data['users'] = User::select('*')->orderBy('id', 'DESC')->get();
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

}
