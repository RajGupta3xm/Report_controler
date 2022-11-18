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
use App\Models\ReferAndEarn;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class ReferAndEarnController extends Controller {

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
           
            return view('admin.referEarn.refer_earn_list');
        }
    }

    public function refer_earn_submit(Request $request ){
         $data=[
        "register_referee" => $request->input('register_referee'),
        "register_referral" => $request->input('register_referral'),
        "plan_purchase_referee" => $request->input('plan_purchase_referee'),
        "plan_purchase_referral" => $request->input('plan_purchase_referral'),
        "how_it_work_en" => $request->input('how_it_work_en'),
        "how_it_work_ar" => $request->input('how_it_work_ar'),
        "referral_per_user" => $request->input('referral_per_user'),
        "message_body_en" => $request->input('message_body_en'),
        "message_body_ar" => $request->input('message_body_ar'),
        "start_date" => $request->input('start_date'),

    ];

$insert = ReferAndEarn::create($data);
if($insert){
   return redirect('admin/refer-earn-management')->with('success', ' Insert successfully.');
}
else {
   return redirect()->back()->with('error', 'Some error occurred while insert ');
}

}

}
