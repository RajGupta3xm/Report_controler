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
use App\Models\ReferAndEarnUsed;
use App\Models\ReferAndEarn;
use App\Models\ReferEarnContent;
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
           
               $registration_count = User::withcount('registration_count')->get();
                $refer_content = ReferEarnContent::select('*')->get();
                $plan_purchase_count = ReferAndEarnUsed::withcount('user')->where('used_for','plan_purchase')->get();
          
                   $refer = User::withcount('user_referral')->with('refers')->get()
              ->each(function($refer){
                     $refer->purchase = ReferAndEarnUsed::where(['referral_id'=>$refer->id,'used_for'=>'plan_purchase'])->count(); 
                     $planPurchase = ReferAndEarn::where(['id'=>$refer->refers['refer_and_earn_id']])->select('plan_purchase_referral')->first(); 
                     $refer->plan_referral = $planPurchase['plan_purchase_referral'];  
                     $refer->plan_purchase_total = $refer->purchase*$refer->plan_referral;
            
            // ->each(function($refer){
                $refer->registration = ReferAndEarnUsed::where(['referral_id'=>$refer->id,'used_for'=>'registration'])->count();
                $registerReferral = ReferAndEarn::where(['id'=>$refer->refers['refer_and_earn_id']])->select('register_referral')->first();  
              $refer->register_referral = $registerReferral['register_referral'];   
               $refer->registration_total = $refer->registration* $refer->register_referral;
               $refer->grand_total = $refer->registration_total+$refer->plan_purchase_total;

    //   });
    });
//       ->each(function($refer) {
//         $registerReferral = ReferAndEarn::where(['id'=>$refer->refers['refer_and_earn_id']])->select('register_referral')->first();  
//         $refer->register_referral = $registerReferral['register_referral'];   
//         $refer->registration_total = $refer->register_referral*$registration;
// })
// ->each(function($refer) {
//     $planPurchase = ReferAndEarn::where(['id'=>$refer->refers['refer_and_earn_id']])->select('plan_purchase_referral')->first(); 
//     $refer->plan_referral = $planPurchase['plan_purchase_referral'];     
// });
              $data['refer'] = $refer;
              $data['refer_contents'] = $refer_content;
            return view('admin.referEarn.refer_earn_list')->with($data);
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
        'ticket_id'  => strtoupper(str_random(14)),

    ];

$insert = ReferAndEarn::create($data);
if($insert){
   return redirect('admin/refer-earn-management')->with('success', ' Insert successfully.');
}
else {
   return redirect()->back()->with('error', 'Some error occurred while insert ');
}

}

public function refer_content_update(Request $request ){
    return $data=[
   "content_ar" => $request->input('content_ar'),
];

$insert = ReferAndEarn::create($data);
if($insert){
return redirect('admin/refer-earn-management')->with('success', ' Insert successfully.');
}
else {
return redirect()->back()->with('error', 'Some error occurred while insert ');
}

}

public function update_content(Request $request, $id=null){
      $update['content'] = $request->input('action');
   $update = ReferEarnContent::find($id)->update($update);
   if ($update) {
       return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
   } else {
       return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
   }
}

}
