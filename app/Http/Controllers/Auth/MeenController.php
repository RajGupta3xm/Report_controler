<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\User;
use App\Models\Otp;
use App\Models\Ringtone;
use App\Models\ChatGroup;
use App\Models\Subscription;
use App\Models\GalleryDirectory;
use App\Models\UserPoll;
use App\Models\PollOption;
use App\Models\PollAnswer;
use App\Models\UserEvent;
use App\Models\Support_subject;
use App\Models\EventReminder;
use App\Models\DirectoryFile;
use App\Models\Help_support;
use App\Models\UserSubscription;
use App\Models\SubscriptionOrder;
use App\Models\assignContactGroup;
use App\Models\ScheduleMessageSend;
use App\Models\ScheduleMessageDelete;
use App\Models\GroupAdminPermission;
use App\Models\JoinGroupRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /******************  USER MANAGEMENT  ***********************/

    // Create user account api


    public function register(Request $request)      
    {
        $validator = \Validator::make($request->all(), [      
            'first_name'          =>  'required|max:40',
            'last_name'          =>  'required|max:40',
            'user_name'          =>  'required|max:40',
            'email'         =>  'email',
            'mobile_number' =>  'integer|min:8',
            'password' => [
                'required',
                'min:8',             // must be at least 8 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            //'type'        =>  'required',
        ],[
            'first_name.required'   =>  trans('messages.F001'),
            'last_name.required'   =>  trans('messages.F001'),
            'user_name.required'   =>  trans('messages.F097'),
            'first_name.max'   =>  trans('messages.F027'),
            'last_name.max'   =>  trans('messages.F027'),
            'email.email'        =>  trans('messages.F003'),
            'mobile_number.integers'          =>  trans('messages.F028'),
            'mobile_number.min'          =>  trans('messages.F030'),
            'password.required'          =>  trans('messages.F005'),
            'password.min'          =>  trans('messages.F029'),
            'password.regex'          =>  trans('messages.F031'),
            //'type.required'          =>  trans('messages.F034'),
        ]);

        $validator->after(function($validator) use($request) {
            if($request['mobile_number']){      // check if mobile number already registered and active
                $mobile_number = User::where('country_code',$request['country_code'])->where('mobile_number',$request['mobile_number'])->whereNotIn('status',['trashed'])->first();
                if ($mobile_number) {
                    $validator->errors()->add('mobile_number', trans('messages.F033'));
                }
            }
            if($request['email']){       // check if email already registered and active
                $email = User::where('email',$request['email'])->whereNotIn('status',['trashed'])->first();
                if ($email) {
                    $validator->errors()->add('email', trans('messages.F032'));
                }
            }
            if($request['user_name']){ // check if username already registered and active
                $username = User::where('user_name',$request['user_name'])->whereNotIn('status',['trashed'])->first();
                if ($username) {
                    $validator->errors()->add('user_name', trans('messages.F097'));
                }
            }
            
            
        });

        if ($validator->fails()) {
            $this->message = $validator->errors();
        }
        else
        {

            $addUser['password']        =   bcrypt($request->password);
            $addUser['first_name']            =   $request['first_name'];
            $addUser['last_name']            =   $request['last_name'];
            $addUser['user_name']            =   $request['user_name'];
            $addUser['email']           =   $request['email'];
            $addUser['is_otp_verified'] =   'no';
            $addUser['status']          =   'inactive';
            $addUser['type']            =   'user';
            $addUser['country_code']    =   $request['country_code'];
            $addUser['mobile_number']   =   $request['mobile_number'];
            // $addUser['type']            =   $request['type'];
           
            $data                       =   User::create($addUser);  // Create user
           
            $otpUser['otp']             =   '1111';       // Static OTP for development purposes only
            $otpUser['user_id']         =   $data['id'];
            $otp                        =   Otp::create($otpUser);    // Create OTP for verification

            // SMS getway & SMTP integration


            // SMS getway & SMTP integration

            $response = new \Lib\PopulateResponse($data);    // Create response data structure calling from library PopulateResponse
                
            $this->data = $response->apiResponse();         // get final response data
            $this->status   = true;
            $this->message  = trans('messages.F007');
        }
            return $this->populateResponse();      // populateResponse from Controller Class sending final json response
    }


    // Create user account api


    // User login using email/mobile
    public function login(Request $request)     
    {
        $validator = \Validator::make($request->all(), [
            //'country_code' => ['required'],
            //'mobile_number' => ['required'],
            'password' =>['required']
        ],[
            //'mobile_number.required'        =>  trans('messages.F022'),
            'password.required'             =>  trans('messages.F005'),
            //'country_code.required'         =>  trans('messages.F023'),
        ]);
        
        if(!empty($request->mobile_number)){
            $validator->after(function($validator) use(&$user, $request) {
                
                $mobile_number = User::where('country_code',$request['country_code'])->where('mobile_number',$request['mobile_number'])->whereNotIn('status',['trashed'])->first();                   // check if user account with number exist 
                if ($mobile_number) {
                    $credentials = request(['country_code','mobile_number', 'password']);

                    if(!Auth::attempt($credentials))
                    $validator->errors()->add('mobile_number', trans('messages.F011'));
                }else{
                    $validator->errors()->add('mobile_number', trans('messages.F099'));
                }
                
            });
        }
        if(!empty($request->email)){
            $validator->after(function($validator) use(&$user, $request) {
                $email = User::where('email',$request['email'])->whereNotIn('status',['trashed'])->first(); // check if user account with email exist 
                if ($email) {
                    $credentials = request(['email', 'password']);

                    if(!Auth::attempt($credentials))
                    $validator->errors()->add('email', trans('messages.F011'));
                }else{
                    $validator->errors()->add('email', trans('messages.F098'));
                }
                
            });
        }
        
        
        if ($validator->fails()) {
           $this->message = $validator->errors();
        }else{
            if(!empty($request->mobile_number)){        // in case of mobile login
                $userInactive = User::where('mobile_number', $request->mobile_number)->where('country_code', $request->country_code)->orderBy('created_at', 'desc')/*->where('is_completed','yes')*/->first();
            }
            if(!empty($request->email)){               // in case of email login
                $userInactive = User::where('email', $request->email)->orderBy('created_at', 'desc')/*->where('is_completed','yes')*/->first();
            }
            
            if($userInactive['status'] == 'inactive'){   // otp verification incomplete send user to verification screen

                $otpUser['otp']            =   '1
                111';
                $otpUser['user_id']         =   $userInactive['id'];
                $otp                        =   Otp::create($otpUser);

                // SMS getway & SMTP integration


                // SMS getway & SMTP integration

                $this->status   = true;
                $response = new \Lib\PopulateResponse($userInactive);

                $this->data = $response->apiResponse();
                return $this->populateResponse();

            }
            if(!empty($request->mobile_number)){
                $user = User::where([
                    'country_code'=>$request->country_code,
                    'mobile_number'=>$request->mobile_number,
                    'status'=>'active'
                ])->first();
            }
            if(!empty($request->email)){
                $user = User::where([
                    'email'=>$request->email,
                    'status'=>'active'
                ])->first();
            }    

            $updateArr = array();
            // $updateArr['timezone'] = $request->timezone;
            if($request->device_token != "" && $request->device_type != "") {    
                $updateArr['device_token'] = $request->device_token;
                $updateArr['device_type'] = $request->device_type == 'iphone' ? 'ios' : 'android';
            }
            if ($updateArr) {
                User::where('id',$user->id)->update($updateArr); // update device details on login 
            }

            $userTokens = $user->tokens;  // Get previous auth token

            if($userTokens){              // Revoke previous auth tokens
                foreach($userTokens as $token) {
                    $token->revoke();   
                }
            }
            
            // create auth token for current login
            $tokenResult =  $user->createToken('MyApp');  
            $token = $tokenResult->token;
            $token->save();
            $user['token'] = $tokenResult->accessToken;
            unset($user['tokens']);
            // create auth token for current login
            
            $response = new \Lib\PopulateResponse($user);

            $this->data = $response->apiResponse();
            $this->status   = true;
            $this->message  = trans('messages.F012');
            
        }
        return $this->populateResponse();
    }

    // User login using email/mobile


    // User Forgot Password using email/mobile
    public function forgotPassword(Request $request)        
    {
        $validator = \Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile_number' => 'required',
        ],[
            'country_code.required' => trans('messages.F023'),
            'mobile_number.required' => trans('messages.F022'),
        ]);


        $validator->after(function($validator) use($request) {
            if($request->email){
                $user = User::where('email', $request->email)->first();
            }else{
                $user = User::where('country_code', $request->country_code)->where('mobile_number', $request->mobile_number)->first();

            }
            
            if(empty($user)){
                $validator->errors()->add('mobile_number', trans('messages.F024'));
            }else{
                if($user->status == 'inactive'){        // otp verification incomplete
                    $validator->errors()->add('mobile_number', trans('messages.F025'));
                }
                if($user->status == 'trashed'){        // account deleted from admin
                    $validator->errors()->add('mobile_number', trans('messages.F026'));
                }

            }

        });
        
        if ($validator->fails()) {
            // $this->type  = 'first';

            $this->message = $validator->errors();
        }
        else {
            if($request->email){
                $user = User::where('email', $request->email)->first();
            }else{
                $user = User::where('country_code', $request->country_code)->where('mobile_number', $request->mobile_number)->first();
            }
            $otpUser['user_id'] = $user['id'];
            $otpUser['otp']     = '1111';

            $otp                =   Otp::create($otpUser);

            // SMS getway & SMTP integration


            // SMS getway & SMTP integration

            $response = new \Lib\PopulateResponse($otpUser);
            $this->data = $response->apiResponse();
            $this->status   = true;
            $this->message  = 'Otp send successfully.';
        }
        
        return $this->populateResponse();     

    }

    // User Forgot Password using email/mobile

    // User mobile/email OTP verification
    public function otp(Request $request)       
    {
        $validator = \Validator::make($request->all(), [
            'otp'         =>  'required',
            'user_id'     =>  'required'
        ],[
            'otp.required'   =>  trans('messages.F008'),
            'user.required'   =>  trans('messages.F008'),
        ]);

        $validator->after(function($validator) use($request) {
            $checkOTP = OTP::where([
                'user_id' => $request['user_id'],
                'otp' => $request['otp'],
            ])->latest()->first();
           
            if(empty($checkOTP)){
                $validator->errors()->add('error', trans('messages.F009'));
            }
            
        });

        if ($validator->fails()) {
            // $this->type  = 'first';

            $this->message = $validator->errors();
        }
        else
        {
        
            $user = User::find($request['user_id']);
            // if($request->type == 'registration'){
            User::where('id', $request['user_id'])->update([
                'is_otp_verified' => 'yes',
                'status' => 'active',
            ]);
            $userTokens = $user->tokens;

            if($userTokens){
                foreach($userTokens as $token) {
                    $token->revoke();   
                }
            }

            $tokenResult =  $user->createToken('MyApp');
            $token = $tokenResult->token;
            $token->save();
            $user['token'] = $tokenResult->accessToken;
            unset($user['tokens']);

            // }elseif ($request->type == 'forgotPassword') {
            $data = [];
            $users = User::find($request['user_id']);
            
            $response = new \Lib\PopulateResponse($user);

            $this->data = $response->apiResponse();
            $this->status   = true;
            $this->message = trans('messages.F010');
            // }
        }
            return $this->populateResponse();
        
    }

    // User mobile/email OTP verification

    // Resend OTP on email/mobile
    public function resendOTP(Request $request)    
    {
        $user = User::find($request->user_id);
        if($user){
            $otpUser['otp']             =   '1111';
            $otpUser['user_id']         =   $request->user_id;
            $otp                        =   OTP::create($otpUser);
            // SMS getway & SMTP integration


            // SMS getway & SMTP integration
            $data = [];
            $response = new \Lib\PopulateResponse($data);

            $this->data = $response->apiResponse();
            $this->status   = true;
            $this->message  = 'OTP resend successfully.';
        }
        return $this->populateResponse(); 
    }
    // Resend OTP on email/mobile

    // User Reset Password without authorization
    public function updatePassword(Request $request)    
    {
        $validator = \Validator::make($request->all(), [
            'new_password'              =>[
                'required',
                'min:8',             // must be at least 8 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            'confirm_password'          =>  'required|same:new_password',
            
        ],[
            'new_password.required'        =>  trans('messages.F005'),
            'new_password.min'             =>  trans('messages.F029'),
            'new_password.regex'           =>  trans('messages.F031'),
            'confirm_password.required'    =>  trans('messages.F018'),
            'confirm_password.same'        =>  trans('messages.F019'),
            
        ]);

        $validator->after(function($validator) use($request) {
            
            
        });

        if ($validator->fails()) {
            // $this->type  = 'first';

            $this->message = $validator->errors();
        }else{
            $input['password']  = bcrypt($request->new_password);
            
            User::where('id','=',$request->user_id)->update($input);
            $data = [];
            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
            $this->status   = true;
            $this->message  = trans('messages.F020');
        }
        

        return $this->populateResponse();  
    }

    // User Reset Password without authorization

    // User's Profile
    public function myProfile(){       
        $user=User::select('id','first_name','last_name','user_name','email','country_code','mobile_number','profile_pic','friend_profile_pic','family_profile_pic','work_profile_pic','friend_first_name','friend_last_name','work_first_name','work_last_name', 'family_first_name','family_last_name','quickblog_id')->find(Auth::guard('api')->id());
        $data=$user;
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'My profile was fetched successfully.';
        return $this->populateResponse(); 
    }
    // User's Profile

    // update/edit user's profile
    public function editProfile(Request $request){    
        $validator = \Validator::make($request->all(), [
            'first_name' =>  'required',
            'last_name' =>  'required'
        ],[
            'first_name.required'     =>  trans("validation.required",['attribute'=>'First name']),
            'last_name.required'     =>  trans("validation.required",['attribute'=>'Last name'])
        ]);

        $validator->after(function($validator) use($request) {
            
            
        });

        if ($validator->fails()) {
            $this->message = $validator->errors();
        }else{
            $update=[
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'friend_first_name'=>$request->friend_first_name,
                'friend_last_name'=>$request->friend_last_name,
                'work_first_name'=>$request->work_first_name,
                'work_last_name'=>$request->work_last_name,
                'family_first_name'=>$request->family_first_name,
                'family_last_name'=>$request->family_last_name
            ];
            if ($request->quickblog_id) {
                $update['quickblog_id'] =$request->quickblog_id;
            }
            if ($request->profile_pic || ($request->profile_pic == 0  && $request->profile_pic != "")) {
                if($request->profile_pic == 0  && $request->profile_pic != ""){
                    $update['profile_pic'] = "";
                }else{
                    $image = $request->profile_pic;
                    $filename = $image->getClientOriginalName();
                    $filename = str_replace(" ", "", $filename);
                    $imageName = time() . '.' . $filename;
                    $return = $image->move(
                        base_path() . '/public/uploads/user/', $imageName);
                    $url = url('/uploads/user/');
                    $update['profile_pic'] = $url . '/' . $imageName;
                }
            }
            if ($request->friend_profile_pic || ($request->friend_profile_pic == 0 && $request->friend_profile_pic != "")) {
                if($request->friend_profile_pic == 0 && $request->friend_profile_pic != ""){
                    $update['friend_profile_pic'] = "";
                }else{
                    $image = $request->friend_profile_pic;
                    $filename = $image->getClientOriginalName();
                    $filename = str_replace(" ", "", $filename);
                    $imageName = time() . '.' . $filename;
                    $return = $image->move(
                        base_path() . '/public/uploads/user/', $imageName);
                    $url = url('/uploads/user/');
                    $update['friend_profile_pic'] = $url . '/' . $imageName;
                }
            }
            
            if ($request->family_profile_pic || ($request->family_profile_pic == 0 && $request->family_profile_pic != "")) {
                if($request->family_profile_pic == 0 && $request->family_profile_pic != ""){
                    $update['family_profile_pic'] = ""; 
                }else{
                    $image = $request->family_profile_pic;
                    $filename = $image->getClientOriginalName();
                    $filename = str_replace(" ", "", $filename);
                    $imageName = time() . '.' . $filename;
                    $return = $image->move(
                        base_path() . '/public/uploads/user/', $imageName);
                    $url = url('/uploads/user/');
                    $update['family_profile_pic'] = $url . '/' . $imageName;
                }
            }
            if ($request->work_profile_pic || ($request->work_profile_pic == 0 && $request->work_profile_pic != "")) {
                if($request->work_profile_pic == 0 && $request->work_profile_pic != ""){
                    $update['work_profile_pic'] = ""; 
                }else{
                    $image = $request->work_profile_pic;
                    $filename = $image->getClientOriginalName();
                    $filename = str_replace(" ", "", $filename);
                    $imageName = time() . '.' . $filename;
                    $return = $image->move(
                        base_path() . '/public/uploads/user/', $imageName);
                    $url = url('/uploads/user/');
                    $update['work_profile_pic'] = $url . '/' . $imageName;
                }
            }
            User::where('id',Auth::guard('api')->id())->update($update);
            $user=User::select('id','first_name','last_name','user_name','email','country_code','mobile_number','profile_pic','friend_profile_pic','family_profile_pic','work_profile_pic','friend_first_name','friend_last_name','work_first_name','work_last_name', 'family_first_name',                'family_last_name')->find(Auth::guard('api')->id());
            $data=$user;
            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
            $this->status   = true;
            $this->message  = 'Profile updated successfully.';
           
        }
         return $this->populateResponse(); 
    }
    // update/edit user's profile

    /************************  USER MANAGEMENT  ***********************/

    /************************  SUBSCRIPTION MANAGEMENT  ***********************/

    // Subscription plan list
    public function planListing(Request $request)   
    {

        // User active plan //

        $data['user'] = User::find(Auth::guard('api')->id());

        // User active plan //

        $plans = Subscription::where('status','active')->get();

        $response = new \Lib\PopulateResponse($plans);

        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'Plans fetched successfully.';
        return $this->populateResponse(); 
    }
    // Subscription plan list

    // Subscribe/Purchase Plan
    public function subscribePlan(Request $request){
        $validator = \Validator::make($request->all(), [
            'plan_id' =>  'required',
            'amount' =>  'required'
        ],[
            'plan_id.required'     =>  trans("validation.required",['attribute'=>'Plan']),
            'amount.required'     =>  trans("validation.required",['attribute'=>'Amount'])
        ]);

        $validator->after(function($validator) use($request) {
            if($request->plan_id){
                // Check if plan is still active

                $plan=Subscription::where(['id'=>$request->plan_id,'status'=>'active'])->first();
                if(empty($plan)){
                    $validator->errors()->add('plan_id', "Selected plan is not available at the moment.");
                }

                // Check if plan is still active
            }
        });

        if ($validator->fails()) {
            $this->message = $validator->errors();
        }else{
            $available_space=0;
            $plan=Subscription::find($request->plan_id);

            // previous subscribed plan of user

            $previousSubscription=UserSubscription::where('user_id',Auth::guard('api')->id())->orderBy('id','DESC')->first();
            if($previousSubscription){
                $used_space=$previousSubscription->alloted_space-$previousSubscription->current_available_space;
                $available_space=$plan->size_kb-$used_space;
            }else{
                $available_space=$plan->size_kb;
            }

            // previous subscribed plan of user
            
            $insert=[
                'user_id'=>Auth::guard('api')->id(),
                'plan_id'=>$request->plan_id,
                'amount'=>$plan->amount,
                'alloted_space'=>$plan->size_kb,
                'current_available_space'=>$available_space,
                'valid_till'=>date('Y-m-d H:i:s',strtotime("+".$plan->validity." days",time())),
                'data_store_till_date'=>date('Y-m-d H:i:s',strtotime("+".$plan->storage_validity." days",time()))
            ];
            $subscribe=UserSubscription::create($insert);
            if($subscribe){

                // Terminate previous subscribed plan of user

                UserSubscription::where('id','!=',$subscribe->id)->where('user_id',Auth::guard('api')->id())->update(['status'=>'terminated']);

                // Terminate previous subscribed plan of user

                // Create order for subscription purchase payment

                $order=[                
                    'user_id'=>Auth::guard('api')->id(),
                    'subscription_id'=>$subscribe->id,
                    'amount'=>$plan->amount,
                    'total_amount'=>$plan->amount,
                    'payment_method'=>'online',
                    'status'=>'success'
                ];
                $createOrder=SubscriptionOrder::create($order);

                // Create order for subscription purchase payment

                $data=$subscribe;
                $response = new \Lib\PopulateResponse($data);
                $this->data = $response->apiResponse();
                $this->status   = true;
                $this->message  = 'Plan subscribed successfully.';
            }else{
                $data=[];
                $response = new \Lib\PopulateResponse($data);
                $this->data = $response->apiResponse();
                $this->status   = true;
                $this->message  = 'Some error occured.';
            }
            
            
        }
        return $this->populateResponse(); 
    }
    // Subscribe/Purchase Plan

    // Check if user's subscribed plan is still active and valid or not

    public function checkValidPlan(){
        $plan_details=[];
        $subscription=UserSubscription::where(['user_id'=>Auth::guard('api')->id(),'status'=>'active'])->first();
        if(!empty($subscription)){    // If active
            $plan_details=[
                'subscription_id'=>$subscription->id,
                'plan_id'=>$subscription->plan_id,
                'validity'=>$subscription->valid_till,
                'available_space'=>$subscription->current_available_space,
                'status'=>'active'
            ];
        }else{
            $subscription=UserSubscription::where(['user_id'=>Auth::guard('api')->id(),'status'=>'expired'])->orderBy('id','DESC')->first();
            if(!empty($subscription)){ // If expired
                $plan_details=[
                    'subscription_id'=>$subscription->id,
                    'plan_id'=>$subscription->plan_id,
                    'validity'=>$subscription->valid_till,
                    'available_space'=>$subscription->current_available_space,
                    'status'=>'expired'
                ];
            }else{    // If terminated due to other subscription or payment issues
                $subscription=UserSubscription::where(['user_id'=>Auth::guard('api')->id(),'status'=>'terminated'])->orderBy('id','DESC')->first();
                if(!empty($subscription)){
                    $plan_details=[
                        'subscription_id'=>$subscription->id,
                        'plan_id'=>$subscription->plan_id,
                        'validity'=>$subscription->valid_till,
                        'available_space'=>$subscription->current_available_space,
                        'status'=>'terminated'
                    ];
                }
            }
        }

        return $plan_details;
    }

    // Check if user's subscribed plan is still active and valid or not
    

    /************************  SUBSCRIPTION MANAGEMENT  ***********************/

    /********************  DIRECTORY/GALLERY MANAGEMENT  *********************/
    
    // Create Folder in user gallery
    public function addFolder(Request $request){       
        $validator = \Validator::make($request->all(), [
            'directory_name'              =>  'required',
            
        ],[
            'directory_name.required'     =>  trans('messages.F044'),
        ]);

        $validator->after(function($validator) use($request) {
            
            
        });

        if ($validator->fails()) {
            $this->message = $validator->errors();
        }else{
            $insert=[
                'user_id'=>Auth::guard('api')->id(),
                'directory_name'=>$request->directory_name
            ];
            $add=GalleryDirectory::create($insert);
            if($add){
                $data = [];
                $response = new \Lib\PopulateResponse($data);
                $this->data = $response->apiResponse();
                $this->status   = true;
                $this->message  = trans('messages.F042');
            }else{
                $this->status   = true;
                $this->message  = trans('messages.F043');
            }
        }

        return $this->populateResponse(); 
    }
    // Create Folder in user gallery

    // Get User's folders list in gallery
    public function myFolders()    
    {
        $directory_list=[];
        $directory = GalleryDirectory::select('*')->where('user_id',Auth::guard('api')->id())->where('status','1')->get();
        
        if($directory){
            foreach ($directory as $key => $value) {
                // folder size calculation 

                $value->total_size=0;
                $value->total_files=0;
                $files=DirectoryFile::where('directory_id',$value->id)->where('status','<>','trashed')->get();
                if($files){
                    $value->total_files=count($files);
                }
                $file_size=DirectoryFile::where('directory_id',$value->id)->where('status','<>','trashed')->sum('file_size');
                $value->total_size=number_format($file_size,2,'.','');

                // folder size calculation
                array_push($directory_list,$value);
            }
        }
        
        $data['directory']=$directory_list;
        $response = new \Lib\PopulateResponse($data);

        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'Directories fetched successfully.';
        return $this->populateResponse(); 
    }
    // Get User's folders list in gallery
    
    // Delete single folder from user gallery
    public function deleteFolder(Request $request){                   
         $directory_id = $request->directory_id;
        if(GalleryDirectory::find($request->directory_id)){
            GalleryDirectory::where('id',$request->directory_id)->delete();
            $delete_file = DirectoryFile::where('directory_id',$directory_id);
            $delete = $delete_file->delete();
            $data = [];
            if($delete){
                /* // Update user allocated space 

                 $checkPlan=UserSubscription::where(['user_id'=>Auth::guard('api')->id()])->where('status','!=','payment_pending')->orderBy('id','DESC')->first();
                 if($checkPlan){
                    $space=$checkPlan['current_available_space']+$kb_size->file_size;
                    UserSubscription::where('id',$checkPlan['id'])->update(['current_available_space'=>$space]);
                 }

                // Update user allocated space */
            }
        }
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'Folder deleted successfully.';
        return $this->populateResponse();
    }
    // Delete single folder from user gallery

    // Upload Media/File in Folder (single)
    public function fileUpload(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'directory_id' => 'required',
            'file' => 'required'
            ],
            [
                'directory_id.required' => trans('validation.required',['attribute' => 'directory_id']),
                'file.required' => trans('validation.required',['attribute' => 'file'])
            ]);
            $validator->after(function($validator) use($request) {
        });
        if ($validator->fails()) {
            $this->message = $validator->errors();
        }else{
            $insert=[
                'directory_id' => $request->directory_id,
                'user_id' => Auth::guard('api')->id(),
                    // 'file_type' => $request->file_type
            ];
               
            // Check Available space for user 

            /* $checkPlan=$this->checkValidPlan();    
               if($checkPlan){
                 if($checkPlan['status']=='active'){
                     if ($request->hasFile('file')) {
                         $image = $request->file;
                         $size = $image->getSize();        /// in Bytes
                         // $kb_size = str_replace(',','',number_format(($size/1000),'3'));
                         $kb_size =($size/1000);
                            
                     }
                    
                    
                     if(strtotime($checkPlan['validity']) < strtotime(date('Y-m-d H:i:s'))){
            
                         $this->message  = 'Plan expired, renew to upload files';
                     }else if($checkPlan['available_space'] < $kb_size){
                         $this->message  = 'Not enough storage. Buy more storage to upload files.';
                        // echo 'hello';die;
                    }else{ 
            */

            // Check Available space for user 

            // Upload file

                        if ($request->hasFile('file')) {
                            $image = $request->file;
                            $size = $image->getSize();        /// in Bytes
                            // $kb_size = str_replace(',','',number_format(($size/1000),'3'));
                            $kb_size =($size/1000);
                            $filename = $image->getClientOriginalName();
                            $insert['file_name'] = $filename;
                            $filename = str_replace(" ", "", $filename);
                            $imageName = time() . '.' . $filename;
                            $imgExt=$image->getClientOriginalExtension();
                            $return = $image->move(
                                    base_path() . '/public/uploads/gallary/images', $imageName);
                            $insert['file_path'] = "uploads/gallary/images/". $imageName;
                            $insert['file_size'] = $kb_size;
                            $insert['file_type'] = $imgExt;
                        }

            // Upload file

                        $insert['fileUid'] =$request->fileUid;  // Quickblox file id
                        $data = [];
                        $add = DirectoryFile::create($insert);

            // Calculate and update available space w.e.o. file upload
                        /* 
                         $space=$checkPlan['available_space']-$kb_size;
                         UserSubscription::where('id',$checkPlan['subscription_id'])->update(['current_available_space'=>$space]);
                        */
            // Calculate and update available space w.e.o. file upload

            // Update file details

                        $file=DirectoryFile::find($add->id);
                        $file['file_path']=url($file['file_path']);
                        $file['file_size']=str_replace(',','',number_format($file['file_size'],'3'));

             // Update file details
                        $data['file']=$file;
                        $response = new \Lib\PopulateResponse($data);
                        $this->data = $response->apiResponse();
                            
                        $this->message  = 'file uploaded successfully.';
                    /* }
                        
                 }else{
                     $this->message  = 'Plan expired, renew to upload files';
                 }
             }else{
                 $this->message  = 'Buy plan to upload files';
             } 
            */
                
            $this->status   = true;
                   
            }
        return $this->populateResponse();
    }
    // Upload Media/File in Folder (single)
    
    // Get Media/File in Folder List
    public function directoryfileListing(Request $request){
        $directory_id = $request->directory_id;
        $file = DirectoryFile::where('directory_id',$directory_id)->where('status','active')->orderBy('id','DESC')->get();
        if($file){
            foreach($file as $f){
                $f['file_path']=url($f['file_path']);
                $f['file_size']=str_replace(',','',number_format($f['file_size'],'3'));
            }
        }
        $data['file']=$file;
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'Files fetched successfully.';
        return $this->populateResponse();
    }
    // Get Media/File in Folder List

    // Search File in folder/gallery
    public function searchFile(Request $request)
    {
      $directory_id  = $request->directory_id;
      $file_name = $request->file_name;
      $files=[];
      if($directory_id){
          $files = DirectoryFile::select('*')->where('file_name','like','%'.$file_name.'%')->where('directory_id',$directory_id)->where('user_id',auth::guard('api')->id())->where('status','active')->get();
      }else{
          $files = DirectoryFile::select('*')->where('file_name','like','%'.$file_name.'%')->where('user_id',auth::guard('api')->id())->get();
          
      }
      
      if($files){
          foreach($files as $f){
                $f['file_path']=url($f['file_path']);
                $f['file_size']=str_replace(',','',number_format($f['file_size'],'3'));
            }
        $data['file']=$files;
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'file fetched successfully.';
            return $this->populateResponse();
      }else{
        $this->status   = true;
        $this->message  = "Some error occured while fetch file";
      }
    }
    // Search File in folder/gallery

    // Search Folder
    public function searchFolder(Request $request)
    {
      $directory_name = $request->directory_name;
      $directory_list=[];
      
      $directories = GalleryDirectory::select('*')->where('directory_name','like','%'.$directory_name.'%')->where('user_id',auth::guard('api')->id())->get();
          
        if($directories){
            foreach ($directories as $key => $value) {
                $value->total_size=0;
                $value->total_files=0;

                // Calculate folder size

                $files=DirectoryFile::where('directory_id',$value->id)->where('status','<>','trashed')->get();
                if($files){
                    $value->total_files=count($files);
                }
                $file_size=DirectoryFile::where('directory_id',$value->id)->where('status','<>','trashed')->sum('file_size');
                $value->total_size=number_format($file_size,2,'.','');

                // Calculate folder size

                array_push($directory_list,$value);
            }
        }
        $data['directory']=$directory_list;
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'Directory fetched successfully.';
        return $this->populateResponse();
    }
    // Search Folder
    
   // Update Quickblox id of directory file
    public function updateFileId(Request $request){
          $file_id = $request->file_id;      // Primary key id of directory file
          $file_uid = $request->file_uid;    // Quickblox file id to update 
          if($file_uid && $file_id){
              $files = DirectoryFile::where('id',$file_id)->where('user_id',auth::guard('api')->id())->update(['fileUid'=>$file_uid]);
          }else{
              $files=false;
          }
          if($files){
            $data['file']=DirectoryFile::find($file_id);
            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
            $this->status   = true;
            $this->message  = 'File updated successfully.';
                return $this->populateResponse();
          }else{
            $this->status   = true;
            $this->message  = "Some error occured while fetch file";
          }
    }
    // Update Quickblox id of directory file

    // Delete directory file
    public function fileDelete(Request $request)
    {
        $id = json_decode($request->id);
        $directory_id = json_decode($request->directory_id);
        $delete_file = DirectoryFile::where('id',$id)->where('directory_id',$directory_id);
        $kb_size=$delete_file->first();    // get file size
        $delete = $delete_file->delete();
        $data = [];
        if($delete){

            // Calculate & Update available space w.e.o deleted file

            /*
             $checkPlan=UserSubscription::where(['user_id'=>Auth::guard('api')->id()])->where('status','!=','payment_pending')->orderBy('id','DESC')->first();
             if($checkPlan){
                 $space=$checkPlan['current_available_space']+$kb_size->file_size;
                 UserSubscription::where('id',$checkPlan['id'])->update(['current_available_space'=>$space]);
             }
            */

            // Calculate & Update available space w.e.o deleted file
             
            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
            $this->status = true;
            $this->message = "Data delete successfully";
            
        }else{
            $this->status   = true;
            $this->message  = "Some error occured while deleting file";
        }

        return $this->populateResponse();
    }
    // Delete directory file

   /********************  DIRECTORY/GALLERY MANAGEMENT  *********************/

   /**************************  POLL MANAGEMENT  ****************************/

    // Create user Poll
    public function addPoll(Request $request){        
        $validator = \Validator::make($request->all(), [
            'question' =>  'required',
            'time' =>  'required',
            
        ],[
            'question.required'     =>  trans("validation.required",['attribute'=>'Question']),
            'time.required'     =>  trans("validation.required",['attribute'=>'Time']),
        ]);

        $validator->after(function($validator) use($request) {
            
            
        });

        if ($validator->fails()) {
            $this->message = $validator->errors();
        }else{
            $insert=[
                'user_id'=>Auth::guard('api')->id(),
                'question'=>$request->question,
                'type'=>'mcq',
                'time'=>$request->time
            ];
            $add=UserPoll::create($insert);
            if($add){

                // Add options of poll 

                if($request->options){
                    if(is_array($request->options)){
                        $options= $request->options;
                    }else{
                        $options=json_decode($request->options);
                    }
                    if($options){
                        foreach($options as $option){
                            if($option){
                                $insert=[
                                    'poll_id'=>$add['id'],
                                    'option'=>$option
                                ];
                                $addOption=PollOption::create($insert);
                            }
                        }
                    }
                }

                // Add options of poll

                $data = [];
                $response = new \Lib\PopulateResponse($data);
                $this->data = $response->apiResponse();
                $this->status   = true;
                $this->message  = "Poll question added successfully";
            }else{
                $this->status   = true;
                $this->message  = "Some error occured while adding poll";
            }
        }

        return $this->populateResponse(); 
    }
    // Create user Poll

    // Get user's poll list
    public function myPolls()    
    {
        $polls = UserPoll::select('*')->with('created_by','options')->where('user_id',Auth::guard('api')->id())->where('status','1')->orderBy('id','DESC')->get();

        $data['polls']=$polls;
        $response = new \Lib\PopulateResponse($data);

        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'Polls fetched successfully.';
        return $this->populateResponse(); 
    }
    // Get user's poll list

    // Get all user's poll list
    public function allPolls()    
    {
        $polls = UserPoll::select('*')->with('created_by','options')->where('status','1')->orderBy('id','DESC')->get();

        $data['polls']=$polls;
        $response = new \Lib\PopulateResponse($data);

        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'Polls fetched successfully.';
            return $this->populateResponse(); 
    }
    // Get all user's poll list

    // Submit user response of polling
    public function sendMyAnswer(Request $request){    
        $validator = \Validator::make($request->all(), [
            'poll_id' =>  'required',
            'option_id' =>  'required|integer',
            
        ],[
            'poll_id.required'     =>  trans("validation.required",['attribute'=>'poll_id']),
            'option_id.required'     =>  trans("validation.required",['attribute'=>'option']),
        ]);

        $validator->after(function($validator) use($request) {
            
            
        });

        if ($validator->fails()) {
            $this->message = $validator->errors();
        }else{
            // save response 

            PollAnswer::where(['user_id'=>Auth::guard('api')->id(),'poll_id'=>$request->poll_id])->delete();
            $insert=[
                'user_id'=>Auth::guard('api')->id(),
                'poll_id'=>$request->poll_id,
                'option_id'=>$request->option_id
            ];
            
            $add=PollAnswer::create($insert);  

            // save response 

            if($add){
                //  Update Calculations for the poll option w.e.f. user's response
                $allAnswer=PollAnswer::where(['poll_id'=>$request->poll_id])->count();
                $pollOptions=PollOption::where(['poll_id'=>$request->poll_id])->get();
                if($pollOptions){
                    foreach($pollOptions as $pollOption){
                        $selectedOption=PollAnswer::where(['poll_id'=>$request->poll_id,'option_id'=>$pollOption->id])->count();
                        $percentage=($selectedOption/$allAnswer)*100;
                        PollOption::where(['poll_id'=>$request->poll_id,'id'=>$pollOption->id])->update(['selection_percentage'=>$percentage]);
                    }
                }
                //  Update Calculations for the poll option w.e.f. user's response

                // Poll details

                $poll = UserPoll::select('*')->with('created_by','options')
                // ->where('user_id','<>',Auth::guard('api')->id())
                ->where('status','1')->where('id',$request->poll_id)->first();
                if(!empty($poll)){
                    $data=$poll;
                }else{
                    $data=new \stdClass();
                }

                // Poll details
                
                $response = new \Lib\PopulateResponse($data);
                $this->data = $response->apiResponse();
                $this->status   = true;
                $this->message  = "Your answer sent successfully";
            }else{
                $this->status   = true;
                $this->message  = "Some error occured while sending your response";
            }
        }
       

        return $this->populateResponse();
    }
    // Submit user response of polling

    // Update/edit user poll
    public function updatePoll(Request $request){   
         $validator = \Validator::make($request->all(), [
            'id' =>  'required',
            'question' =>  'required',
            'time' =>  'required',
            
        ],[
            'id.required'     =>  trans("validation.required",['attribute'=>'id']),
            'question.required'     =>  trans("validation.required",['attribute'=>'Question']),
            'time.required'     =>  trans("validation.required",['attribute'=>'Time']),
        ]);

        $validator->after(function($validator) use($request) {
            
            
        });

        if ($validator->fails()) {
            $this->message = $validator->errors();
        }else{
            $insert=[
                'question'=>$request->question,
                'type'=>'mcq',
                'time'=>$request->time
            ];
            $add=UserPoll::where('id',$request->id)->update($insert);
            if($add){
                // update options

                if($request->options){
                    if(is_array($request->options)){
                        $options= $request->options;
                    }else{
                        $options=json_decode($request->options);
                    }
                    if($options){
                        foreach($options as $option){
                            if($option){
                                $insert=[
                                    'option'=>$option->text
                                ];

                                // Update if existing 
                                if($option->option_id && $option->text){
                                    $addOption=PollOption::where('id',$option->option_id)->update($insert);
                                }
                                // Update if existing 
                                // Delete if existing 
                                else if($option->option_id && $option->text==""){
                                    $addOption=PollOption::where('id',$option->option_id)->delete();
                                }
                                // Delete if existing 
                                // Add if new
                                else{
                                    $insert['poll_id']=$request->id;
                                    $addOption=PollOption::create($insert);
                                }
                                // Add if new
                            }
                        }
                    }
                }
                // update options

                $data = [];
                $response = new \Lib\PopulateResponse($data);
                $this->data = $response->apiResponse();
                $this->status   = true;
                $this->message  = "Poll updated successfully";
            }else{
                $this->status   = true;
                $this->message  = "Some error occured while adding poll";
            }
        }

        return $this->populateResponse(); 
    }
    // Update/edit user poll

    // Delete user poll(single)
    public function deletePoll(Request $request){      
        $validator = \Validator::make($request->all(), [
            'poll_id' =>  'required'
            
        ],[
            'poll_id.required'     =>  trans("validation.required",['attribute'=>'poll_id'])
        ]);

        $validator->after(function($validator) use($request) {
            if($request->poll_id){
                if(!UserPoll::where(['id'=>$request->poll_id,'user_id'->Auth::guard('api')->id()])->first()){
                    $validator->errors()->add('poll_id', trans('messages.F045'));
                }
            }
            
        });
        $add=UserPoll::where(['id'=>$request->poll_id])->update(['status'=>"0"]);
            if($add){
                $data = [];
                $response = new \Lib\PopulateResponse($data);
                $this->data = $response->apiResponse();
                $this->status   = true;
                $this->message  = "Your poll deleted successfully";
            }else{
                $this->status   = true;
                $this->message  = "Some error occured while deleting poll";
            }

        return $this->populateResponse();
    }
    // Delete user poll(single)

    // Search poll    
    public function searchPoll(Request $request)
    {
        $question = $request->question;
        $polls = UserPoll:: select('*')->with('created_by','options')->where('question','like','%'.$question.'%')->where('user_id',Auth::guard('api')->id())->where('status','1')->get();
        
        $data['polls']=$polls;
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'Polls fetched successfully.';
            return $this->populateResponse();
    }
    // Search poll

    // Get poll detail
    public function pollDetail(REQUEST $request){
        $poll = UserPoll::select('*')->with('created_by','options')        ->where('status','1')->where('id',$request->poll_id)->first();
        if(!empty($poll)){
            $data=$poll;
        }
        // else{
        //     $data=new \stdClass();
        // }
        if(!empty($data)){
            $this->status = true;
            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
            $this->message  = 'Poll details fetched successfully.';

        }else{
            $this->status = true;
            $this->status_code = 201;
            $this->message  = 'Poll details fetched successfully.';

        }
        return $this->populateResponse(); 
    }
    // Get poll detail
    
    /**************************  POLL MANAGEMENT  ****************************/

    /**************************  EVENT MANAGEMENT  ****************************/

    // Create user event
    public function addEvent(Request $request){                 
        $validator = \Validator::make($request->all(), [
            'title' =>  'required',
            'description' =>  'required',
            'date' =>  'required',
            'time' =>  'required',
            'end_time' =>  'required',
            'location' =>  'required',
        ],[
            'title.required'     =>  trans("validation.required",['attribute'=>'Title']),
            'description.required'     =>  trans("validation.required",['attribute'=>'Description']),
            'date.required'     =>  trans("validation.required",['attribute'=>'Date']),
            'time.required'     =>  trans("validation.required",['attribute'=>'Start Time']),
            'end_time.required'     =>  trans("validation.required",['attribute'=>'End Time']),
            'location.required'     =>  trans("validation.required",['attribute'=>'Location']),
        ]);

        $validator->after(function($validator) use($request) {
            
            
        });

        if ($validator->fails()) {
            $this->message = $validator->errors();
        }else{
            $insert=[
                'user_id'=>Auth::guard('api')->id(),
                'title'=>$request->title,
                'description'=>$request->description,
                'date'=>$request->date,
                'time'=>$request->time,
                'end_time'=>$request->end_time,
                'location'=>$request->location
            ];
            if($request->image){
                $filename = $request->image->getClientOriginalName();
                $imageName = time().'.'.$filename;
                if(env('APP_ENV') == 'local'){
                    $return = $request->image->move(
                    base_path() . '/public/uploads/events/', $imageName);
                }else{
                    $return = $request->image->move(
                    base_path() . '/public/uploads/events/', $imageName);
                    //$return = $request->image->move(
                   // base_path() . '/../public/uploads/events/', $imageName);
                }
                $url = url('/uploads/events/');
                $insert['image'] = $url.'/'.$imageName;
                // $insert['image'] = $url;
            }
            if($request->reminder){
                $insert['is_reminder']="1";
            }
            $add=UserEvent::create($insert);
            if($add){
               // Create reminder for event

                if($request->reminder){
                    if(is_array($request->reminder)){
                        $reminders=$request->reminder;
                    }else{
                        $reminders=json_decode($request->reminder);
                    }
                    if($reminders){
                        foreach($reminders as $reminder){
                            if($reminder){
                                $insert=[
                                    'event_id'=>$add['id'],
                                    'reminder_time'=>$reminder,
                                    'set_time'=>$reminder
                                ];
                                $addOption=EventReminder::create($insert);
                            }
                        }
                    }
                }
                
                // Create reminder for event
                
                $data = [];
                $response = new \Lib\PopulateResponse($data);
                $this->data = $response->apiResponse();
                $this->status   = true;
                $this->message  = "Event added successfully";
            }else{
                $this->status   = true;
                $this->message  = "Some error occured while adding poll";
            }
        }
       
        return $this->populateResponse(); 
    }
    // Create user event

    // User's events list
    public function myEventList(Request $request)    
    {
        if($request->type == 'upcoming'){
            $events = UserEvent::select('*')->where('user_id',Auth::guard('api')->id())
            ->whereRaw('((date="'.date('Y-m-d').'" AND time>"'.date('H:i:s').'") OR (date>"'.date('Y-m-d').'"))')
            ->where('status','1')
            ->orderBy('id','DESC')
            ->get();
        }else if($request->type == 'ongoing'){
            $events = UserEvent::select('*')->where('user_id',Auth::guard('api')->id())
            ->whereRaw('(date="'.date('Y-m-d').'" AND time<"'.date('H:i:s').'" AND end_time>"'.date('H:i:s').'")')
             ->where('status','1')
            ->orderBy('id','DESC')
            ->get();
        }else if($request->type == 'overdue'){
            $events = UserEvent::select('*')->where('user_id',Auth::guard('api')->id())
            ->whereRaw('((date="'.date('Y-m-d').'" AND time<"'.date('H:i:s').'" AND end_time<"'.date('H:i:s').'") OR (date<"'.date('Y-m-d').'"))')
             ->where('status','1')
            ->orderBy('id','DESC')
            ->get();
        }else{
            $events = UserEvent::select('*')->where('user_id',Auth::guard('api')->id())
             ->where('status','1')
            ->orderBy('id','DESC')
            ->get();
        }
        
        if(!empty($events)){
            foreach($events as $event){
                $event->time=date('h:i A',strtotime($event->time));
                $event->end_time=date('h:i A',strtotime($event->end_time));
                $event->reminder=EventReminder::where('event_id',$event->id)->get();
            }
        }

        $data['events']=$events;
        $response = new \Lib\PopulateResponse($data);

        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'Events fetched successfully.';
            return $this->populateResponse(); 
    }
    // User's events list

    // All user events list
    public function allEventList(Request $request)   
    {
        if($request->type == 'upcoming'){
            $events = UserEvent::select('*')
            ->whereRaw('((date="'.date('Y-m-d').'" AND time>"'.date('H:i:s').'") OR (date>"'.date('Y-m-d').'"))')
            ->where('status','1')
            ->orderBy('id','DESC')
            ->get();
        }else if($request->type == 'ongoing'){
            $events = UserEvent::select('*')
            ->whereRaw('(date="'.date('Y-m-d').'" AND time<"'.date('H:i:s').'" AND end_time>"'.date('H:i:s').'")')
             ->where('status','1')
            ->orderBy('id','DESC')
            ->get();
        }else if($request->type == 'overdue'){
            $events = UserEvent::select('*')
            ->whereRaw('((date="'.date('Y-m-d').'" AND time<"'.date('H:i:s').'" AND end_time<"'.date('H:i:s').'") OR (date<"'.date('Y-m-d').'"))')
             ->where('status','1')
            ->orderBy('id','DESC')
            ->get();
        }else{
            $events = UserEvent::select('*')
             ->where('status','1')
            ->orderBy('id','DESC')
            ->get();
        }
        if(!empty($events)){
            foreach($events as $event){
                $event->time=date('h:i A',strtotime($event->time));
                $event->end_time=date('h:i A',strtotime($event->end_time));
                $event->reminder=EventReminder::where('event_id',$event->id)->get();
            }
        }
        $data['events']=$events;
        $response = new \Lib\PopulateResponse($data);

        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'Events fetched successfully.';
        return $this->populateResponse(); 
    }
    // All user events list
    
    // Update/Edit Event
    public function updateEvent(Request $request){      
        $validator = \Validator::make($request->all(), [
            'event_id' =>  'required',
            'title' =>  'required',
            'description' =>  'required',
            'date' =>  'required',
            'time' =>  'required',
            'end_time' =>  'required',
            'location' =>  'required',
        ],[
            'event_id.required'     =>  trans("validation.required",['attribute'=>'event_id']),
            'title.required'     =>  trans("validation.required",['attribute'=>'Title']),
            'description.required'     =>  trans("validation.required",['attribute'=>'Description']),
            'date.required'     =>  trans("validation.required",['attribute'=>'Date']),
            'time.required'     =>  trans("validation.required",['attribute'=>'Start Time']),
            'end_time.required'     =>  trans("validation.required",['attribute'=>'End Time']),
            'location.required'     =>  trans("validation.required",['attribute'=>'Location']),
        ]);

        $validator->after(function($validator) use($request) {
            
            
        });

        if ($validator->fails()) {
            $this->message = $validator->errors();
        }else{
            $insert=[
                'title'=>$request->title,
                'description'=>$request->description,
                'date'=>$request->date,
                'time'=>$request->time,
                'end_time'=>$request->end_time,
                'location'=>$request->location
            ];
            if(!empty($request->image)){
                
                $filename = $request->image->getClientOriginalName();
                $imageName = time().'.'.$filename;
                if(env('APP_ENV') == 'local'){
                    $return = $request->image->move(
                    base_path() . '/public/uploads/events/', $imageName);
                }else{
                    $return = $request->image->move(
                    base_path() . '/public/uploads/events/', $imageName);
                    // $return = $request->image->move(
                    // base_path() . '/../public/uploads/events/', $imageName);
                }
               
                $url = url('/uploads/events/');
                $insert['image'] = $url.'/'.$imageName;
                // $insert['image'] = $url;
            }
            if($request->reminder){
                $insert['is_reminder']="1";
            }
            $add = UserEvent::where('id',$request->event_id)->update($insert);
            
            if($add){
                // Update event reminders

                if($request->reminder){
                    if(is_array($request->reminder)){
                        $reminders=$request->reminder;
                    }else{
                        $reminders=json_decode($request->reminder);
                    }
                    if($reminders){

                        // Delete previous event reminders
                        
                        DB::table('event_reminders')->where('event_id', $request->event_id)->delete();

                        // Delete previous event reminders

                        // Add new event reminders
                        foreach($reminders as $reminder){
                            if($reminder){
                                $insert=[
                                    'event_id'=>$request->event_id,
                                    'reminder_time'=>$reminder,
                                    'set_time'=>$reminder
                                ];
                                $addOption=EventReminder::create($insert);
                            }
                        }
                        // Add new event reminders
                    }
                }
                // Update event reminders

                $data = [];
                $response = new \Lib\PopulateResponse($data);
                $this->data = $response->apiResponse();
                $this->status   = true;
                $this->message  = "Event updated successfully";
            }else{
                $this->status   = true;
                $this->message  = "Some error occured while adding poll";
            }
        }

        return $this->populateResponse(); 
    }
    // Update/Edit Event
    
    // Delete Event (single)
    public function deleteEvent(Request $request){    
        $validator = \Validator::make($request->all(), [
            'event_id' =>  'required'
            
        ],[
            'event_id.required'     =>  trans("validation.required",['attribute'=>'event_id'])
        ]);

        $validator->after(function($validator) use($request) {
            if($request->event_id){
                if(!UserEvent::where(['id'=>$request->event_id,'user_id'->Auth::guard('api')->id()])->first()){
                    $validator->errors()->add('event_id', trans('messages.F045'));
                }
            }
            
        });
        $add=UserEvent::where(['id'=>$request->event_id])->update(['status'=>"0"]);
            if($add){
                $data = [];
                $response = new \Lib\PopulateResponse($data);
                $this->data = $response->apiResponse();
                $this->status   = true;
                $this->message  = "Your event deleted successfully";
            }else{
                $this->status   = true;
                $this->message  = "Some error occured while deleting poll";
            }

        return $this->populateResponse();
    }
    // Delete Event (single)

    // Get event detail
    public function eventDetail(REQUEST $request){  
        $event = UserEvent::select('*')
        ->where('id',$request->event_id)
        ->where('status','1')
        ->first();
        if(!empty($event)){
                $event->time=date('h:i A',strtotime($event->time));
                $event->end_time=date('h:i A',strtotime($event->end_time));
                $event->reminder=EventReminder::where('event_id',$event->id)->get();
            $data=$event;
        }
        // else{
        //     $data=new \stdClass();
        // }
        if(!empty($data)){
            $this->status = true;
            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
            $this->message  = 'Event details fetched successfully.';

        }else{
            $this->status = true;
            $this->status_code = 201;
            $this->message  = 'Event details fetched successfully.';

        }
        return $this->populateResponse(); 
    }
    // Get event detail
    
    // Search event
    public function searchEvent(Request $request)
    {
      $event = $request->event;
      $events = UserEvent:: select('*')->where('title','like','%'.$event.'%')->where('user_id',Auth::guard('api')->id())->where('status','1')->get();
      $data['events']=$events;
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'Events fetched successfully.';
            return $this->populateResponse();
    }
    // Search event
     
    /**************************  EVENT MANAGEMENT  ****************************/

    /***********************  USER SETTINGS MANAGEMENT  ***********************/
    
    // Get list of available ringtones
    public function ringtones()  
    {
        $events = Ringtone::where('status','active')->get();

        $data['ringtones']=$events;
        $response = new \Lib\PopulateResponse($data);

        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'Ringtones fetched successfully.';
            return $this->populateResponse(); 
    }
    // Get list of available ringtones
    
    /***********************  USER SETTINGS MANAGEMENT  ***********************/

    /********************  MEEN APP USERS PROFILE DETAILS  *********************/

    // Get other user's profile details(multiple)
    public function memberProfile(REQUEST $request){    
        $user_list=[];
        // With user_id
        if($request->user_id){                
            $users=json_decode($request->user_id); 
            if($users){
            foreach($users as $user_id){
                $user=User::select('id','first_name','last_name','user_name','email','country_code','mobile_number','profile_pic','quickblog_id')->find($user_id);
                if(!empty($user)){
                    $user->notifications=true;
                    $user->ringtone_id="0";
                    $user->type_of_user="";
                    $user->common_group=[];
                    $user->shared_media=[];

                    // Check User's contact group with member i.e. work,friend,family

                    $group=assignContactGroup::where(['user_id'=>$user_id,'contact_user_id'=>Auth::guard('api')->id()])->first();
                    if($group){
                        $user->group_name=$group['group_name'];
                        
                        $profile=User::select('profile_pic','work_profile_pic','friend_profile_pic','family_profile_pic','work_profile_pic','friend_first_name','friend_last_name','work_first_name','work_last_name', 'family_first_name',                'family_last_name')->find($user_id);
                        $name=$group['group_name'].'_profile_pic';
                        if($profile[$name] != null){
                            $user->profile_pic= $profile[$name];  // set display picture according to group
                        }
                        
                        if($profile[$group['group_name']."_first_name"] != null){
                            $user->first_name= $profile[$group['group_name']."_first_name"]; // set display name according to group
                        }
                        if($profile[$group['group_name']."_last_name"] != null){
                            
                            $user->last_name= $profile[$group['group_name']."_last_name"]; // set display name according to group
                        }
                    }else{
                        $user->group_name="";
                    }
                    
                    // Check User's contact group with member i.e. work,friend,family

                    // Check Member's contact group with user i.e. work,friend,family

                    $i_set_group=assignContactGroup::where(['user_id'=>Auth::guard('api')->id(),'contact_user_id'=>$user_id])->first();
                    if($i_set_group){
                        $user->type_of_user=$i_set_group['group_name'];
                    }

                    // Check Member's contact group with user i.e. work,friend,family

                    // Get common group of both users

                    if($user->quickblog_id){
                        $myUser=User::find(Auth::guard('api')->id());
                        
                        $common_groups=ChatGroup::whereRaw('FIND_IN_SET('.$user->quickblog_id.',members) AND FIND_IN_SET('.$myUser->quickblog_id.',members)')->get();
                        
                        if($common_groups){
                            $user->common_group=$common_groups;
                        }
                    }

                    // Get common group of both users

                    array_push($user_list,$user);
                }
            }
        }
        }else{            
            // With Quickblox user_id

            $users=json_decode($request->quickblog_id);           
            if($users){
                foreach($users as $user_id){
                    $user=User::select('id','first_name','last_name','user_name','email','country_code','mobile_number','profile_pic','quickblog_id')->where('quickblog_id',$user_id)->first();
                    if(!empty($user)){
                        $user->notifications=true;
                        $user->ringtone_id="0";
                        $user->type_of_user="";
                        $user->common_group=[];
                        $user->shared_media=[];

                        // Check User's contact group with member i.e. work,friend,family

                        $group=assignContactGroup::where(['user_id'=>$user->id,'contact_user_id'=>Auth::guard('api')->id()])->first();
                        if($group){
                            $user->group_name=$group['group_name'];
                            $user->type_of_user=$group['group_name'];
                            
                            $profile=User::select('profile_pic','work_profile_pic','friend_profile_pic','family_profile_pic','work_profile_pic','friend_first_name','friend_last_name','work_first_name','work_last_name', 'family_first_name',                'family_last_name')->find($user->id);
                            $name=$group['group_name'].'_profile_pic';
                            if($profile[$name] != null){
                                $user->profile_pic= $profile[$name];
                                // $user->first_name= $profile[$name."_first_name"];
                                // $user->last_name= $profile[$name."_last_name"];
                            }
                            
                            if($profile[$group['group_name']."_first_name"] != null){
                            $user->first_name= $profile[$group['group_name']."_first_name"];
                            }
                            if($profile[$group['group_name']."_last_name"] != null){
                                
                                $user->last_name= $profile[$group['group_name']."_last_name"];
                            }
                        }else{
                            $user->group_name="";
                            
                        }

                        // Check User's contact group with member i.e. work,friend,family
                        
                        // Check Member's contact group with user i.e. work,friend,family

                        $i_set_group=assignContactGroup::where(['user_id'=>Auth::guard('api')->id(),'contact_user_id'=>$user->id])->first();
                        if($i_set_group){
                            $user->type_of_user=$i_set_group['group_name'];
                        }

                        // Check Member's contact group with user i.e. work,friend,family
                        
                        // Get common group of both users

                        if($user->quickblog_id){
                            $myUser=User::find(Auth::guard('api')->id());
                            
                            $common_groups=ChatGroup::whereRaw('FIND_IN_SET('.$user->quickblog_id.',members) AND FIND_IN_SET('.$myUser->quickblog_id.',members)')->get();
                            
                            if($common_groups){
                                $user->common_group=$common_groups;
                            }
                        }

                        // Get common group of both users
                
                        array_push($user_list,$user);
                    }
                }
            }
        }
        
        $data=$user_list;
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'Member profile fetched successfully.';
        return $this->populateResponse(); 
    }
    // Get other user's profile details(multiple)
    
    // Device Contact sync with server
    public function contactSync(Request $request){
        $user_list=[];
        $user_check_list=[];
        $ifJson=json_decode($request->contact_numbers);
        if(is_array($ifJson)){
            $contact_list=[];
            foreach($ifJson as $contact_number){
                $user=User::select('id','first_name','last_name','user_name','email','country_code','mobile_number','profile_pic','quickblog_id')->selectRaw('CONCAT(country_code,"",mobile_number) as number')->having('mobile_number',$contact_number)->orHaving('number',trim($contact_number,'+'))->orHaving('number','+'.trim($contact_number,'+'))->first();
                if(!empty($user)){
                    $user->notifications=true;
                    $user->ringtone_id="0";
                    $user->type_of_user="";
                    $user->common_group=[];
                    $user->shared_media=[];

                    // Check User's contact group with member i.e. work,friend,family

                    $group=assignContactGroup::where(['user_id'=>$user->id,'contact_user_id'=>Auth::guard('api')->id()])->first();
                    if($group){
                        $user->group_name=$group['group_name'];
                        $profile=User::select('profile_pic','work_profile_pic','friend_profile_pic','family_profile_pic')->find($user_id);
                        if($profile[$group['group_name'].'_profile_pic'] != null){
                            $user->profile_pic= $profile[$group['group_name'].'_profile_pic'];
                        }
                        
                        if($profile[$group['group_name']."_first_name"] != null){
                            $user->first_name= $profile[$group['group_name']."_first_name"];
                        }
                        if($profile[$group['group_name']."_last_name"] != null){
                            
                            $user->last_name= $profile[$group['group_name']."_last_name"];
                        }
                        
                        
                    }else{
                        $user->group_name="";
                    }

                    // Check User's contact group with member i.e. work,friend,family

                    // Remove Duplicates

                    if(!in_array($user->id,$user_check_list) && $user->id != Auth::guard('api')->id()){
                        array_push($user_list,$user);
                        array_push($user_check_list,$user->id);
                    }

                    // Remove Duplicates
                }
            }
        }
        $data=$user_list;
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'fetching contacts';
        return $this->populateResponse();
    }
    // Device Contact sync with server

    /********************  MEEN APP USERS PROFILE DETAILS  *********************/

    /************************  QUICKBLOX SERVER CODE  *********************/

    // Schedule send message for quickblox (not in use)
    public function secheduleMessageSend(Request $request){    
        $validator = \Validator::make($request->all(), [
            'chat_user_id' =>  'required',
            'receiver_user_id' =>  'required',
            'date'=>  'required',
            'time'=>  'required'
        ],[
            'chat_user_id.required'     =>  trans("validation.required",['attribute'=>'chat_user_id']),
            'receiver_user_id.required' =>  trans("validation.required",['attribute'=>'receiver_user_id']),
            'date.required'     =>  trans("validation.required",['attribute'=>'date']),
            'time.required'     =>  trans("validation.required",['attribute'=>'time'])
        ]);

        $validator->after(function($validator) use($request) {
            
            
        });

        if ($validator->fails()) {
            $this->message = $validator->errors();
        }else{
            $attachment="";
            if ($request->attachment) {
                $image = $request->attachment;
                $filename = $image->getClientOriginalName();
                $filename = str_replace(" ", "", $filename);
                $imageName = time() . '.' . $filename;
                $return = $image->move(
                    base_path() . '/public/uploads/attachments/', $imageName);
                $url = url('/uploads/attachments/');
                $attachment= $url . '/' . $imageName;
            }

            $data=ScheduleMessageSend::create(
                [
                    'user_id'=>Auth::guard('api')->id(),
                    'chat_user_id'=>$request->chat_user_id,
                    'chat_dialog_id'=>$request->chat_dialog_id,
                    'receiver_user_id'=>$request->receiver_user_id,
                    'send_to_chat'=>1,
                    'markable'=>1,
                    'message'=>$request->message,
                    'attachment'=>$attachment,
                    'date'=>$request->date,
                    'time'=>$request->time,
                    'status'=>'pending'
                ]
            );

            $data=[];
            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
            $this->status   = true;
            $this->message  = 'Message scheduled successfully.';
           
        }
         return $this->populateResponse(); 
    }
    // Schedule send message for quickblox (not in use)
    
    // Schedule delete message for quickblox (not in use)
    public function secheduleMessageDelete(Request $request){ 
        $validator = \Validator::make($request->all(), [
            'chat_user_id' =>  'required',
            'chat_message_id' =>  'required',
            'date'=>  'required',
            'time'=>  'required'
        ],[
            'chat_user_id.required'     =>  trans("validation.required",['attribute'=>'chat_user_id']),
            'chat_message_id.required' =>  trans("validation.required",['attribute'=>'chat_message_id']),
            'date.required'     =>  trans("validation.required",['attribute'=>'date']),
            'time.required'     =>  trans("validation.required",['attribute'=>'time'])
        ]);

        $validator->after(function($validator) use($request) {
            
            
        });
        
        if ($validator->fails()) {
            $this->message = $validator->errors();
        }else{
            $data=ScheduleMessageDelete::create(
                [
                    'user_id'=>Auth::guard('api')->id(),
                    'chat_user_id'=>$request->chat_user_id,
                    'chat_message_id'=>$request->chat_message_id,
                    'date'=>$request->date,
                    'time'=>$request->time,
                    'status'=>'pending'
                ]
            );
            $data=[];
            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
            $this->status   = true;
            $this->message  = 'Delete message scheduled successfully.';
           
        }
         return $this->populateResponse(); 
    }
    // Schedule delete message for quickblox (not in use)

    // Update group details on quickblox server

    public function updateDialogue($request){
        // $r = $request['quickblox_group_id'];
        // print_r($r);
        // die;
           $getGroup = ChatGroup::where('quickblox_group_id', $request['quickblox_group_id'])->first();

        
        $auth_token=$this->createSession();  // Create session for quickblox login - refer to Controller class 
          $token=$this->loginQB($auth_token, $getGroup->user_id);     // Quickblox login for authentication - refer to Controller class 
         $headers = array(
            'Accept' => 'application/json',
            'Content-Type: application/json',
            "QB-Token: ".$token
        );

        // set fields to update

        $fields=[];
        if(isset($request['group_name']) && $request['group_name']){
            $fields['name']=$request['group_name'];
        }
        if(isset($request['image'])){
            $fields['photo']=$request['image'];
        }
        if(isset($request['add_member']) && $request['add_member']){
            $fields['push_all']=['occupants_ids'=>$request['add_member']];
        }
        if(isset($request['remove_member']) && $request['remove_member']){
            $fields['pull_all']=['occupants_ids'=>$request['remove_member']];
           
        } 
        // print_r($fields); die;
        // set fields to update

        if($fields){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.quickblox.com/chat/Dialog/".$request['quickblox_group_id'].".json");
            // curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            // $result=json_decode($result);
           
            curl_close($ch);
            //    print_r($result); die;
            if (isset($result->errors)) {
                return false;
            } else {
                return true;
            }
        }else{
            return false;
        }
    }
    // Update group details on quickblox server

    /************************  QUICKBLOX SERVER CODE  *********************/
    
    /************************  USER'S CONTACT MANAGEMENT  *********************/

    // Assign Contact group to an existing member to view only custom details of its profile
    public function assignContactGroup(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'contact_user_id' => 'required',  // logged in user sets group for contact_user_id to be able to view only custom details of its profile 
            'group_name' => 'required'     // work/family/friend
        ],
        [
            'contact_user_id.required' => trans('validation.required',['attribute' => 'contact_user_id']),
            'group_name.required' => trans('validation.required',['attribute' => 'group_name'])
        ]);
        
        $validator->after(function($validator) use($request) {
        });
        
        if ($validator->fails()) {
            $this->message = $validator->errors();
        }else{
            // Delete previous relation between two profiles

            assignContactGroup::where(['user_id'=>auth::guard('api')->id(),'contact_user_id'=>$request->contact_user_id])->delete();

            // Delete previous relation between two profiles

            $insert=[
                'user_id' => auth::guard('api')->id(),
                'contact_user_id' => $request->contact_user_id,
                'group_name' =>$request->group_name
            ];

            $data = [];
            $add = assignContactGroup::create($insert);
            if($add)
                {
                    $response = new \Lib\PopulateResponse($data);
                    $this->data = $response->apiResponse();
                    $this->status   = true;
                    
               }else
               {
                    $this->status   = true;
                    $this->message  = "Some error occured while adding contact";
                    
                }
            }
        return $this->populateResponse();
    }

    // Assign Contact group to an existing member to view only custom details of its profile

    /************************  USER'S CONTACT MANAGEMENT  *********************/
    
    /*************************  USER CHAT & CHAT GROUPS ************************/
    
    // Add new chat group
    public function addChatGroup(Request $request)
    {
        // return $id = Auth::guard('api')->id();
        $validator = \Validator::make($request->all(), [
          'group_name' => 'required',
          'group_type' => 'required',
          'members' => 'required',
          'quickblox_user_id'=>'required',
          'quickblox_group_id'=>'required'
        ],[
            'group_name.required' => trans("validation.required",['attribute'=>'group name']),
            'group_type.required' => trans("validation.required",['attribute'=>'group type']),
            'members.required' => trans("validation.required",['attribute'=>'members']),
             'quickblox_user_id.required' => trans("validation.required",['attribute'=>'quickblox user id']),
             'quickblox_group_id.required' => trans("validation.required",['attribute'=>'quickblox group id']),
      ]);
       
       
      if($validator->fails()){
          $this->message = $validator->errors();
      }else{
            $members=json_decode($request->members);
            if($members){
                $members=implode(',',$members);
            }else{
                $members="";
            }
            $insert =[
                'user_id' => Auth::guard('api')->id(),
                'group_admin_id' => $request->quickblox_user_id,
                'quickblox_group_id' => $request->quickblox_group_id,
                'quickblox_user_id' => $request->quickblox_user_id,
                'group_name' =>$request->group_name,
                'members' => $members,
                'group_type' => $request->group_type,
            ];
            
            if($request->group_type){
                if($request->group_type == 1){
                    $insert['permissions'] = $request->permission;
                    $insert['read_permissions'] = $request->read_permissions;
                }else{
                    $insert['permissions'] = NULL;
                }
                $insert['group_type'] = $request->group_type;
            }
             
            if($request->invite_link){
                $insert['invite_link'] = $request->invite_link;
            }
            
            // if($request->group_type){
            //     $insert['group_type'] = "0";
            // }
            
            if($request->image){
                $filename = $request->image->getClientOriginalName();
                $imageName = time().'.'.$filename;
                // if(env('APP_ENV') == 'local'){
                    $return = $request->image->move(
                    base_path() . '/public/uploads/chat_group/', $imageName);
                // }else{
                //     $return = $request->image->move(
                //     base_path() . '/../public/uploads/chat_group/', $imageName);
                // }
                
                $url = url('/uploads/chat_group/');
                $insert['image'] = $url.'/'. $imageName;
            }
            $add = ChatGroup::create($insert);
            GroupAdminPermission::create([
                'group_id'=>$request->quickblox_group_id,
                'admin_id'=> $request->quickblox_user_id,
                'edit_group_info'=>'1',
                'remove_member'=>'1',
                'delete_chat'=>'1',
                'add_new_admin'=>'1',
            ]); 
            $group=ChatGroup::find($add->id);
            $data['group']=$group;
            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
            $this->status   = true;
            $this->message  = 'chat group added successfully';
        }
          
        return $this->populateResponse();
    }
    // Add new chat group
    
    // Update existing chat group details
    public function updateChatGroup(Request $request)
    {

      
        $insert=[];
        $validator = \Validator::make($request->all(), [
            'quickblox_group_id' =>'required',
            // 'permissions' =>'required_if:group_type,0'
        ],[
            'quickblox_group_id.required' => trans("validator.required",['attribute'=>'quickblox_group_id']),
            // 'permissions.required_if'=>trans("validator.required",['attribute'=>'permissions'])
        ]);
        $validator->after(function($validator) use($request) {
             $user=User::find(Auth::guard('api')->id()); 
            if($request->quickblox_group_id){
                $group=ChatGroup::where('quickblox_group_id', $request->quickblox_group_id)
                // ->whereIn('group_admin_id',$user->quickblog_id)
                ->first();

                //remove member validation
                if($request->remove_members){
                    if(!empty($group)){
                       
                       $admins=explode(',',$group->group_admin_id);
                       // echo 're:'. in_array($user->quickblog_id,$admins);die;
                       // print_r($admins);die;
                      
                           if($user->quickblog_id){
                               $members = explode(',', $user->quickblog_id);
                               // print_r($members);die;
                           }else{
                               $members=[];
                           }
                               foreach($admins as $add){
                                   array_push($members,$add);
                                       
                               }
                          $member=array_unique($members);
                           $check_permission= GroupAdminPermission::where(['group_id'=>$request->quickblox_group_id,'admin_id'=> $member])->first();  
                           if(!is_null($check_permission) && $check_permission->remove_member !='0'){
     
   
                           }else{

                            $validator->errors()->add( 'remove_member','You have not a permission to remove a member');
   
                           }
                       }    
                   }
                   /****Remove memebers  */

                    //add admin validation
                   if($request->add_admin){
                    if(!empty($group)){
                       
                       $admins=explode(',',$group->group_admin_id);
                      
                           if($user->quickblog_id){
                               $members = explode(',', $user->quickblog_id);
                               // print_r($members);die;
                           }else{
                               $members=[];
                           }
                               foreach($admins as $add){
                                   array_push($members,$add);
                                       
                               }
                          $member=array_unique($members);
                           $check_permission= GroupAdminPermission::where(['group_id'=>$request->quickblox_group_id,'admin_id'=> $member])->first();  
                           if($check_permission->add_new_admin !='0'){
   
   
                           }else{

                            $validator->errors()->add( 'add_admin','You have not a permission to add a admin');
   
                           }
                       }    
                   }

                   /***add admin */

                   /*****Add edit group info validation */
                   if($request['image'] ||  $request['group_name'] || $request['add_members'] || $request['remove_admin'] || $request['invite_link'] || $request['group_type'] || $request['permissions'] || $request['read_permissions'] ){
                    if(!empty($group)){
                       
                       $admins=explode(',',$group->group_admin_id);
                        // print_r($admins);die;
                           if($user->quickblog_id){
                               $members = explode(',', $user->quickblog_id);
                               // print_r($members);die;
                           }else{
                               $members=[];
                           }
                               foreach($admins as $add){
                                   array_push($members,$add);
                                       
                               }
                           $member=array_unique($members);
                            $check_permission= GroupAdminPermission::where(['group_id'=>$request->quickblox_group_id,'admin_id'=> $member])->first();  
                            // print_r($check_permission->add_new_admin);die;
                           if($check_permission->edit_group_info !='0'){
    
   
                           }else{
                            $validator->errors()->add( 'edit_group_info','You have not a permission to update details  ');
                            
                           }
                       }    
                   }
                   /********Add edit group info validation */

               
                if(!empty($group)){
                    
                    $admins=explode(',',$group->group_admin_id);
                    // echo 're:'. in_array($user->quickblog_id,$admins);die;
                    // print_r($admins);die;
                    if(in_array($user->quickblog_id,$admins)){
                        
                    }else{
                        $validator->errors()->add('group_admin_id', 'Only group admin can make changes to the group');
                    }
                }
            }
        });
        if($validator->fails()){
            $this->message = $validator->errors();
        }else{
             $fields=[];
            if($request->group_type != "" ) {  
             if($request->group_type==1 || $request->group_type==0){
                if($request->group_type == 1){
                    $insert['permissions'] = $request->permissions;
                    $insert['read_permissions'] = $request->read_permissions;
                }else{
                    $insert['permissions'] = NULL;
                    $insert['read_permissions'] = NULL;
                }
                $insert['group_type'] = $request->group_type;
             }
            }
             
             if($request->group_name){
                  $insert['group_name'] =$request->group_name;
                  $fields['group_name'] =$request->group_name;
             }
             if($request->remove_members){  
                 $remove_member = json_decode($request->remove_members,TRUE);
                if($remove_member){
                    $fields['remove_member'] =$remove_member; 
                }
                $getMembers = ChatGroup::where('quickblox_group_id', $request->quickblox_group_id)->first();
                if($getMembers){
                    if($getMembers->members){
                        $members = explode(',', $getMembers->members);
                        foreach($remove_member as $remove){
                            if(in_array($remove,$members)){
                                $index=array_search($remove,$members);
                                unset($members[$index]);
                            }
                        }
                        $insert['members'] = implode(',',$members);
                        
                    }
                }
               
             }
         
             if($request->add_members){  
                      $add_member = json_decode($request->add_members,TRUE);
                   if($add_member){
                     $fields['add_member'] =$add_member; 
                    }
                    $getMembers = ChatGroup::where('quickblox_group_id', $request->quickblox_group_id)->first();
                    if($getMembers){
                        if($getMembers->members){
                            $members = explode(',', $getMembers->members);
                        }else{
                            $members=[];
                        }
                        foreach($add_member as $add){
                            array_push($members,$add);
                                
                        }
                        $members=array_unique($members);
                         $insert['members'] = implode(',',$members);
                        
                    }
             }
         
             if(!empty($request->image)){
                 
                $filename = $request->image->getClientOriginalName();
                $imageName = time().'.'.$filename;
                // if(env('APP_ENV') == 'local'){
                    $return = $request->image->move(
                    base_path() . '/public/uploads/chat_group/', $imageName);
                // }else{
                //     $return = $request->image->move(
                //     base_path() . '/../public/uploads/chat_group/', $imageName);
                // }
                $url = url('/uploads/chat_group/');
                $insert['image'] = $url.'/'. $imageName;
                $fields['image'] = $insert['image']; 
            }else{
                if($request->image == 0 && $request->image != ""){
                    $fields['image'] = NULL;
                    $insert['image'] = "";
                };
            }
            
            if($request->remove_admin){  
                   $remove_admin = json_decode($request->remove_admin,TRUE);
                   $getAdmin = ChatGroup::where('quickblox_group_id', $request->quickblox_group_id)->first();
                    if($getAdmin){
                        if($getAdmin->group_admin_id){
                            $members = explode(',', $getAdmin->group_admin_id);
                            foreach($remove_admin as $remove){
                                if(in_array($remove,$members)){
                                    
                                    $index=array_search($remove,$members);
                                    unset($members[$index]);
                                    GroupAdminPermission::where(['group_id'=>$request->quickblox_group_id,'admin_id'=> $remove])->delete();
                                }
                            }
                            $insert['group_admin_id'] = implode(',',$members);
                        }
                    }
             }
         
             if($request->add_admin){  
                   $add_admin = json_decode($request->add_admin,TRUE);
                   $getAdmin = ChatGroup::where('quickblox_group_id', $request->quickblox_group_id)->first();
                    if($getAdmin){
                        if($getAdmin->group_admin_id){
                            $members = explode(',', $getAdmin->group_admin_id);
                        }else{
                            $members=[];
                        }
                        foreach($add_admin as $add){
                            array_push($members,$add);
                            $check= GroupAdminPermission::where(['group_id'=>$request->quickblox_group_id,'admin_id'=> $add])->first();  
                            if(!empty($check)){
                                
                            }else{
                                GroupAdminPermission::create([
                                    'group_id'=>$request->quickblox_group_id,
                                    'admin_id'=> $add,
                                    'edit_group_info'=>"1",
                                    'remove_member'=>"1",
                                    'delete_chat'=>"1",
                                    'add_new_admin'=>"1",
                                ]); 
                            }
                               
                        }
                        $members=array_unique($members);
                        $insert['group_admin_id'] = implode(',',$members);
                        
                    }
             }
             
                if($request->invite_link){
                    $insert['invite_link'] = $request->invite_link;
                }
               $data = [];
               if($insert){
                    $add = ChatGroup::where('quickblox_group_id',$request->quickblox_group_id)->update($insert);
                   $fields['quickblox_group_id']=$request->quickblox_group_id;
                    $this->updateDialogue($fields);
               }
               $group=ChatGroup::where('quickblox_group_id',$request->quickblox_group_id)->first();
               $data['group']=$group;
               $response = new \Lib\PopulateResponse($data);
               $this->data = $response->apiResponse();
               $this->status   = true;
               $this->message  = 'chat group update successfully';
       }
       
          return $this->populateResponse(); 
    }
    // Update existing chat group details

    //remove admin
    public function removeAdmin(Request $request){
        $validator = \Validator::make($request->all(), [
            'remove_admin' =>'required',
            'quickblox_group_id' =>'required',
        ],[
            'remove_admin.required' => trans("validator.required",['attribute'=>'remove_admin']),
            'quickblox_group_id.required' => trans("validator.required",['attribute'=>'quickblox_group_id']),
        ]);

        $validator->after(function($validator) use($request) {
            // $remove_admin = json_decode($request->remove_admin,TRUE);
           $user=User::find(Auth::guard('api')->id());
           if($request->quickblox_group_id){
              $group=ChatGroup::where('quickblox_group_id', $request->quickblox_group_id)
              // ->whereIn('group_admin_id',$user->quickblog_id)
              ->first();
              
              if(!empty($group)){
                    
                $admins=explode(',',$group->quickblox_user_id);
                // echo 're:'. in_array($user->quickblog_id,$admins);die;
                // print_r($admins);die;
                if(in_array($user->quickblog_id, $admins)){

                  
                    
                }else{
                    $validator->errors()->add('group_admin_id', 'Only group admin have permission to  make changes');
                }
            }
          }
      });
        
        if($validator->fails()){
            $this->message = $validator->errors();
        }else{
             if($request->remove_admin){  
                 $remove_admin = json_decode($request->remove_admin,TRUE);
                
                $getAdmin = ChatGroup::where('quickblox_group_id', $request->quickblox_group_id)->first();
                 if($getAdmin){
                     if($getAdmin->group_admin_id){
                         $members = explode(',', $getAdmin->group_admin_id);
                         foreach($remove_admin as $remove){
                             if(in_array($remove,$members)){
                                 
                                 $index=array_search($remove,$members);
                                 unset($members[$index]);
                                 GroupAdminPermission::where(['group_id'=>$request->quickblox_group_id,'admin_id'=> $remove])->delete();
                             }
                         }
                         $insert['group_admin_id'] = implode(',',$members);
                     }
                 }
          
            $data = [];
            if($insert){
            $add = ChatGroup::where('quickblox_group_id',$request->quickblox_group_id)->update($insert);
            // $fields['quickblox_group_id']=$request->quickblox_group_id;
            // $this->updateDialogue($fields);
            }
            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
            $this->status   = true;
            $this->message  = 'Admin remove successfully.';
        }
    }
        return $this->populateResponse(); 
    }

    // Get chat group details
    public function groupDetails(Request $request){
        $profile=User::where('id',Auth::guard('api')->id())->first();
        if($profile){
            $flag = $request->flag;
            if($flag==0){
                
              $ifJson=json_decode($request->quickblox_group_id);
            
              if(is_array($ifJson)){
                  $groups=[];
                  foreach($ifJson as $quickblox_group_id){
                      $group=ChatGroup::where('quickblox_group_id', $quickblox_group_id)->first();
                      if($group){
                          $group_member=[];
                          $group_admins=[];
                          if($group->members){
                              $members=explode(',',$group->members);
                              foreach($members as $member){
                                  $getUser=User::select("id","first_name","last_name","user_name","email", "country_code","mobile_number","profile_pic","quickblog_id")->where('quickblog_id',$member)->first();  
                                  if(!empty($getUser)){
                                      $assignedgroup=assignContactGroup::where(['user_id'=>$getUser->id,'contact_user_id'=>Auth::guard('api')->id()])->first();
                                      if($assignedgroup){
                                          $profile=User::select('profile_pic','work_profile_pic','friend_profile_pic','family_profile_pic','friend_first_name','friend_last_name','work_first_name','work_last_name', 'family_first_name',        'family_last_name')->find($getUser->id);
                                          $name=$assignedgroup['group_name'].'_profile_pic';
                                          if($profile[$name] != null){
                                              $getUser->profile_pic= $profile[$name];
                                              // $getUser->first_name= $profile[$name."_first_name"];
                                              // $getUser->last_name= $profile[$name."_last_name"];
                                          }
                                          
                                          if($profile[$group['group_name']."_first_name"] != null){
                                              $getUser->first_name= $profile[$group['group_name']."_first_name"];
                                          }
                                          if($profile[$group['group_name']."_last_name"] != null){
                                              
                                              $getUser->last_name= $profile[$group['group_name']."_last_name"];
                                          }
                                      }
                                      array_push($group_member,$getUser);
                                  }
                              } 
                          }
                          if($group->group_admin_id){
                              $admins=explode(',',$group->group_admin_id);
                              foreach($admins as $admin){
                                 $getUser=User::select("id","first_name","last_name","user_name","email", "country_code","mobile_number","profile_pic","quickblog_id")->where('quickblog_id',$admin)->first();  
                                  if(!empty($getUser)){
                                      
                                      // $getUser['permissions']=GroupAdminPermission::where(['group_id'=>$quickblox_group_id,'admin_id'=> $getUser->quickblog_id])->first();
                                      
                                      if(GroupAdminPermission::where(['group_id'=>$quickblox_group_id,'admin_id'=> $getUser->quickblog_id])->first()){
                                          $getUser['permissions']=GroupAdminPermission::where(['group_id'=>$quickblox_group_id,'admin_id'=> $getUser->quickblog_id])->first();
                                      }else{
                                          $getUser['permissions']=['edit_group_info'=>'0','remove_member'=>'0','delete_chat'=>'0','add_new_admin'=>'0',];
                                      }
                                      array_push($group_admins,$getUser);
                                  }    
                              } 
                          }
                          $group->group_members=$group_member;
                          $group->group_admins=$group_admins;
                          array_push($groups,$group);
                      
                      }  
                  }
                  $data['group']=$groups;
              }else{
                  $group=ChatGroup::where('quickblox_group_id', $request->quickblox_group_id)->first();
                  if($group){
                      $group_member=[];
                      $group_admins=[];
                      if($group->members){
                          $members=explode(',',$group->members);
                          foreach($members as $member){
                              $getUser=User::select("id","first_name","last_name","user_name","email", "country_code","mobile_number","profile_pic","quickblog_id")->where('quickblog_id',$member)->first();  
                              if(!empty($getUser)){
                                  $assignedgroup=assignContactGroup::where(['user_id'=>$getUser->id,'contact_user_id'=>Auth::guard('api')->id()])->first();
                                  if($assignedgroup){
                                      $profile=User::select('profile_pic','work_profile_pic','friend_profile_pic','family_profile_pic','friend_first_name','friend_last_name','work_first_name','work_last_name', 'family_first_name','family_last_name')->find($getUser->id);
                                      $name=$assignedgroup['group_name'].'_profile_pic';
                                      if($profile[$name] != null){
                                          $getUser->profile_pic= $profile[$name];
                                          // $getUser->first_name= $profile[$name."_first_name"];
                                          // $getUser->last_name= $profile[$name."_last_name"];
                                      }
                                      
                                      if($profile[$group['group_name']."_first_name"] != null){
                                              $getUser->first_name= $profile[$group['group_name']."_first_name"];
                                          }
                                          if($profile[$group['group_name']."_last_name"] != null){
                                              
                                              $getUser->last_name= $profile[$group['group_name']."_last_name"];
                                          }
                                  }
                                  array_push($group_member,$getUser);
                              }
                          } 
                      }
                      if($group->group_admin_id){
                          
                          $admins=explode(',',$group->group_admin_id);
                          foreach($admins as $admin){
                             $getUser=User::select("id","first_name","last_name","user_name","email", "country_code","mobile_number","profile_pic","quickblog_id")->where('quickblog_id',$admin)->first();  
                              if(!empty($getUser)){
                                  if(GroupAdminPermission::where(['group_id'=>$request->quickblox_group_id,'admin_id'=> $getUser->quickblog_id])->first()){
                                      $getUser['permissions']=GroupAdminPermission::where(['group_id'=>$request->quickblox_group_id,'admin_id'=> $getUser->quickblog_id])->first();
                                  }else{
                                      $getUser['permissions']=['edit_group_info'=>'0','remove_member'=>'0','delete_chat'=>'0','add_new_admin'=>'0',];
                                  }
                                  array_push($group_admins,$getUser);
                              }    
                          } 
                      }
                      $group->group_members=$group_member;
                      $group->group_admins=$group_admins;
                      $data['group']=$group;
                  
                  }else{
                      $data['group']=new \Stdclass(); 
                  }
              }
      
          }else{

        $checkMember = ChatGroup::select('members')->where('quickblox_group_id', $request->quickblox_group_id)->first();
    if($checkMember){
        $checkUser=User::select("quickblog_id")->where('id',Auth::guard('api')->id())->first();  
        if($checkMember->members){
          $members=explode(',',$checkMember->members);
          $users=explode(',',$checkUser->quickblog_id);
           foreach($users as $searchUser){
                if(in_array($searchUser,$members)){
                //    $index=array_search($remove,$members);
        $ifJson=json_decode($request->quickblox_group_id);
      
        if(is_array($ifJson)){
            $groups=[];
            foreach($ifJson as $quickblox_group_id){
                $group=ChatGroup::where('quickblox_group_id', $quickblox_group_id)->first();
                if($group){
                    $group_member=[];
                    $group_admins=[];
                    if($group->members){
                        $members=explode(',',$group->members);
                        foreach($members as $member){
                            $getUser=User::select("id","first_name","last_name","user_name","email", "country_code","mobile_number","profile_pic","quickblog_id")->where('quickblog_id',$member)->first();  
                            if(!empty($getUser)){
                                $assignedgroup=assignContactGroup::where(['user_id'=>$getUser->id,'contact_user_id'=>Auth::guard('api')->id()])->first();
                                if($assignedgroup){
                                    $profile=User::select('profile_pic','work_profile_pic','friend_profile_pic','family_profile_pic','friend_first_name','friend_last_name','work_first_name','work_last_name', 'family_first_name',        'family_last_name')->find($getUser->id);
                                    $name=$assignedgroup['group_name'].'_profile_pic';
                                    if($profile[$name] != null){
                                        $getUser->profile_pic= $profile[$name];
                                        // $getUser->first_name= $profile[$name."_first_name"];
                                        // $getUser->last_name= $profile[$name."_last_name"];
                                    }
                                    
                                    if($profile[$group['group_name']."_first_name"] != null){
                                        $getUser->first_name= $profile[$group['group_name']."_first_name"];
                                    }
                                    if($profile[$group['group_name']."_last_name"] != null){
                                        
                                        $getUser->last_name= $profile[$group['group_name']."_last_name"];
                                    }
                                }
                                array_push($group_member,$getUser);
                            }
                        } 
                    }
                    if($group->group_admin_id){
                        $admins=explode(',',$group->group_admin_id);
                        foreach($admins as $admin){
                           $getUser=User::select("id","first_name","last_name","user_name","email", "country_code","mobile_number","profile_pic","quickblog_id")->where('quickblog_id',$admin)->first();  
                            if(!empty($getUser)){
                                
                                // $getUser['permissions']=GroupAdminPermission::where(['group_id'=>$quickblox_group_id,'admin_id'=> $getUser->quickblog_id])->first();
                                
                                if(GroupAdminPermission::where(['group_id'=>$quickblox_group_id,'admin_id'=> $getUser->quickblog_id])->first()){
                                    $getUser['permissions']=GroupAdminPermission::where(['group_id'=>$quickblox_group_id,'admin_id'=> $getUser->quickblog_id])->first();
                                }else{
                                    $getUser['permissions']=['edit_group_info'=>'0','remove_member'=>'0','delete_chat'=>'0','add_new_admin'=>'0',];
                                }
                                array_push($group_admins,$getUser);
                            }    
                        } 
                    }
                    $group->group_members=$group_member;
                    $group->group_admins=$group_admins;
                    array_push($groups,$group);
                
                }  
            }
            $data['group']=$groups;
        }else{
            $group=ChatGroup::where('quickblox_group_id', $request->quickblox_group_id)->first();
            if($group){
                $group_member=[];
                $group_admins=[];
                if($group->members){
                    $members=explode(',',$group->members);
                    foreach($members as $member){
                        $getUser=User::select("id","first_name","last_name","user_name","email", "country_code","mobile_number","profile_pic","quickblog_id")->where('quickblog_id',$member)->first();  
                        if(!empty($getUser)){
                            $assignedgroup=assignContactGroup::where(['user_id'=>$getUser->id,'contact_user_id'=>Auth::guard('api')->id()])->first();
                            if($assignedgroup){
                                $profile=User::select('profile_pic','work_profile_pic','friend_profile_pic','family_profile_pic','friend_first_name','friend_last_name','work_first_name','work_last_name', 'family_first_name','family_last_name')->find($getUser->id);
                                $name=$assignedgroup['group_name'].'_profile_pic';
                                if($profile[$name] != null){
                                    $getUser->profile_pic= $profile[$name];
                                    // $getUser->first_name= $profile[$name."_first_name"];
                                    // $getUser->last_name= $profile[$name."_last_name"];
                                }
                                
                                if($profile[$group['group_name']."_first_name"] != null){
                                        $getUser->first_name= $profile[$group['group_name']."_first_name"];
                                    }
                                    if($profile[$group['group_name']."_last_name"] != null){
                                        
                                        $getUser->last_name= $profile[$group['group_name']."_last_name"];
                                    }
                            }
                            array_push($group_member,$getUser);
                        }
                    } 
                }
                if($group->group_admin_id){
                    
                    $admins=explode(',',$group->group_admin_id);
                    foreach($admins as $admin){
                       $getUser=User::select("id","first_name","last_name","user_name","email", "country_code","mobile_number","profile_pic","quickblog_id")->where('quickblog_id',$admin)->first();  
                        if(!empty($getUser)){
                            if(GroupAdminPermission::where(['group_id'=>$request->quickblox_group_id,'admin_id'=> $getUser->quickblog_id])->first()){
                                $getUser['permissions']=GroupAdminPermission::where(['group_id'=>$request->quickblox_group_id,'admin_id'=> $getUser->quickblog_id])->first();
                            }else{
                                $getUser['permissions']=['edit_group_info'=>'0','remove_member'=>'0','delete_chat'=>'0','add_new_admin'=>'0',];
                            }
                            array_push($group_admins,$getUser);
                        }    
                    } 
                }
                $group->group_members=$group_member;
                $group->group_admins=$group_admins;
                $data['group']=$group;
            
            }else{
                $data['group']=new \Stdclass(); 
            }
        } 
    }else{
           
            $data['group']=[];
            
        }
    }
}
    }
}
}
      
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'chat group update successfully';
        return $this->populateResponse();
    }
    // Get chat group details

    // Update chat group admin permissions

    public function updateAdminPermissions(Request $request){
        // change permissions allowed for group admin 
        $getUser=GroupAdminPermission::where(['group_id'=>$request->quickblox_group_id,'admin_id'=> $request->admin_id])->update([
                'edit_group_info'=>$request->group_info,
                'remove_member'=>$request->remove_member,
                'delete_chat'=>$request->delete_chat,
                'add_new_admin'=>$request->add_new_admin,
            ]);
        // change permissions allowed for group admin 
        $data['permissions']=GroupAdminPermission::where(['group_id'=>$request->quickblox_group_id,'admin_id'=> $request->admin_id])->first();
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'fetching contacts';
        return $this->populateResponse();
    }
    // Update chat group admin permissions
    
    // Chat group send join request to admin for closed groups

    public function joinGroupRequest(Request $request){
        $fields=[];
         $group=ChatGroup::where('quickblox_group_id', $request->quickblox_group_id)->first(); 

        if($group->group_type == '1' && $group->permissions == 'permission'){
            //  private group with admin permissions to join
            $requestData=[
                'user_id'=>Auth::guard('api')->id(),
                'group_id'=>$request->quickblox_group_id,
                'status'=>'pending'
            ];
            if(!JoinGroupRequest::where(['user_id'=>Auth::guard('api')->id(),'group_id'=>$request->quickblox_group_id])->first()){
                        JoinGroupRequest::create($requestData);
            }else{
                JoinGroupRequest::where(['user_id'=>Auth::guard('api')->id(),'group_id'=>$request->quickblox_group_id])->update(['status'=>'pending']);
            }
            $this->message  = 'Request sent to group admin';
        }else if($group->group_type == '1' && $group->permissions == 'open'){
            //  public group direct join
            $userDetail=User::find(Auth::guard('api')->id());
            if($group->members){
                $groupMembers=explode(',',$group->members);
                array_push($groupMembers,$userDetail->quickblog_id);
            }
            $groupMembers=array_unique($groupMembers);
            $groupMembers=implode(',',$groupMembers);
            if($groupMembers){
                $members = explode(',',$groupMembers);
                $fields['add_member'] = $members;
            }
            // $members=$group->members.','.$userDetail->quickblog_id;
            ChatGroup::where('quickblox_group_id', $request->quickblox_group_id)->update(['members'=>$groupMembers]);
            $fields['quickblox_group_id']=$request->quickblox_group_id;
            $this->updateDialogue($fields);
            $this->message  = 'Group joined successfully.';
        }
        else if($group->group_type == '0' ){
            //  public group direct join if group is public
             $userDetail=User::find(Auth::guard('api')->id());
            if($group->members){
                $groupMembers=explode(',',$group->members);
                array_push($groupMembers,$userDetail->quickblog_id);
            }
            $groupMembers=array_unique($groupMembers);
            $groupMembers=implode(',',$groupMembers);
            // print_r($groupMembers);die;
            if($groupMembers){
                $member=explode(',',$groupMembers);
                  $fields['add_member'] =$member; 
           }
        //    $fields['add_member'] = $groupMembers; 
            // $members=$group->members.','.$userDetail->quickblog_id;
            ChatGroup::where('quickblox_group_id', $request->quickblox_group_id)->update(['members'=>$groupMembers]);
            $fields['quickblox_group_id']=$request->quickblox_group_id;
            $this->updateDialogue($fields);
            $this->message  = 'Group joined successfully.';
        }else{
            $this->status_code   = 201;
            $this->message  = 'Invalid request';
        }
        $response = new \Lib\PopulateResponse([]);
        $this->data = $response->apiResponse();
        $this->status   = true;
       
        return $this->populateResponse();
    }
    // Chat group send join request to admin for closed groups
    
    // Chat group join request list for admin(closed groups)

    public function joinGroupRequestList(Request $request){
        
         $group=ChatGroup::where('quickblox_group_id', $request->quickblox_group_id)->first();
        $adminDetail=User::find(Auth::guard('api')->id());
        $admins=explode(',',$group->group_admin_id);
        if(in_array($adminDetail->quickblog_id,$admins)){ // if group admin
            $allRequest=JoinGroupRequest::select('*')->where('group_id',$request->quickblox_group_id)->where('status','pending')->orderBy('id','DESC')->get(); // fetch all requests
            
            if(!empty($allRequest)){
                foreach($allRequest as $requests){
                    $getDetails=User::select('id','first_name','last_name','user_name','profile_pic','quickblog_id')->find($requests->user_id);
                    // Check User's contact group with member i.e. work,friend,family and set member profile details

                    $group=assignContactGroup::where(['user_id'=>$requests->user_id,'contact_user_id'=>Auth::guard('api')->id()])->first();
                    if($group){
                        $getDetails->group_name=$group['group_name'];
                        
                        $profile=User::select('profile_pic','work_profile_pic','friend_profile_pic','family_profile_pic','work_profile_pic','friend_first_name','friend_last_name','work_first_name','work_last_name', 'family_first_name',                'family_last_name')->find($requests->user_id);
                        $name=$group['group_name'].'_profile_pic';
                        if($profile[$name] != null){
                            $getDetails->profile_pic= $profile[$name];
                            
                        }
                        if($profile[$group['group_name']."_first_name"] != null){
                            $getDetails->first_name= $profile[$group['group_name']."_first_name"];
                        }
                        if($profile[$group['group_name']."_last_name"] != null){
                            
                            $getDetails->last_name= $profile[$group['group_name']."_last_name"];
                        }
                    }else{
                        $getDetails->group_name="";
                    }

                    // Check User's contact group with member i.e. work,friend,family and set member profile details

                    $requests->user_detail=$getDetails;
                }
            }
            $data['requests']=$allRequest;
            $this->message  = 'fetching join group request';
        }else{
            $data['requests']=[];
            $this->status_code   = 201;
            $this->message  = 'Only admin see the join requests';
        }
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->status   = true;
       
        return $this->populateResponse();
    }
    // Chat group join request list for admin(closed groups)
    
    // Accept/Reject group join request by admin(closed groups)

    public function acceptGroupRequest(Request $request){
        $fields=[];
         $requestDetail=JoinGroupRequest::where('status','pending')->find($request->request_id);
          $group=ChatGroup::where('quickblox_group_id', $requestDetail->group_id)->first();
          $adminDetail=User::find(Auth::guard('api')->id());
        $admins=explode(',',$group->group_admin_id);

        if(in_array($adminDetail->quickblog_id,$admins)){  // Check if group admin
             //***for selecting admin's quickblox_group_id**/
             array_push($admins,$adminDetail->quickblog_id);
             $groupMembers=array_unique($admins);
              $groupMember=implode(',',$groupMembers);
                $admin_quickblox_group_id=ChatGroup::where('group_admin_id', $groupMember)->first();
              /**** */
  
            JoinGroupRequest::where('id',$request->request_id)->update(['status'=>$request->status]);
            $userDetail=User::find($requestDetail->user_id);

            if($request->status == 'accepted'){
                // Add member to group

                $members=$group->members.','.$userDetail->quickblog_id;
                if($members){
                     $member=explode(',',$members);
                       $fields['add_member'] =$member; 
                }
                ChatGroup::where('quickblox_group_id', $requestDetail->group_id)->update(['members'=>$members]);
                  $fields['quickblox_group_id']=$admin_quickblox_group_id->quickblox_group_id;
                  $this->updateDialogue($fields);
                // Add member to group
                $this->message  = 'member added successfully';
            }else{
                $this->message  = 'request rejected successfully';
            }
        }else{
            $this->status_code   = 201;
            $this->message  = 'Only admin can add members to group';
        }
        $data=[];
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->status   = true;
        
        return $this->populateResponse(); 
    }
    // Accept/Reject group join request by admin(closed groups)
    
    // Leave group for users

    public function leaveGroup(Request $request){
        $validator = \Validator::make($request->all(), [
            'quickblox_id' =>'required',
            'quickblox_group_id' =>'required',
        ],[
            'quickblox_id.required' => trans("validator.required",['attribute'=>'quickblox_id']),
            'quickblox_group_id.required' => trans("validator.required",['attribute'=>'quickblox_group_id']),
        ]);
        
        if($validator->fails()){
            $this->message = $validator->error();
        }else{
            $group=ChatGroup::where('quickblox_group_id', $request->quickblox_group_id)->first();
            if($group->members){
                // Update group members
                $set_members=[];
                 $members=explode(',',$group->members);
                 
                if($members){
                    foreach($members as $member){
                        if($member != $request->quickblox_id){
                            array_push($set_members,$member);
                            $next_member_admin = $set_members[0];
                        }
                    }
                    if($set_members){
                        ChatGroup::where('quickblox_group_id', $request->quickblox_group_id)->update(['members'=>implode(',',$set_members)]);
                    }else{
                        ChatGroup::where('quickblox_group_id', $request->quickblox_group_id)->update(['members'=>'']);
                    }
                }
                // Update group members
                
                // Update group admin (if member left was an admin of group)
                $set_admins=[];
                 $admins=explode(',',$group->group_admin_id);
                if($admins){
                    foreach($admins as $admin){
                        if($admin != $request->quickblox_id){
                            array_push($set_admins,$admin);
                            
                        }
                    }
                    if($set_admins){
                        ChatGroup::where('quickblox_group_id', $request->quickblox_group_id)->update(['group_admin_id'=>implode(',',$set_admins)]);
                    }else{
                        ChatGroup::where('quickblox_group_id', $request->quickblox_group_id)->update(['group_admin_id'=>$next_member_admin]);
                    }
                }
                // Update group admin (if member left was an admin of group)
            }
            $data=[];
            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
            $this->status   = true;
            $this->message  = 'Group left successfully.';
        }
        
        return $this->populateResponse(); 
    }
    // Leave group for users

    /*************************  USER CHAT & CHAT GROUPS ************************/
    
    /*****************************  USER QUERY *********************************/
    
    // Help & Support subjects list

    public function subjectList(){
        $data['subjects']=Support_subject::where('status','active')->get();
        
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'chat group update successfully';
        return $this->populateResponse();
    }
    // Help & Support subjects list

    // Send Query

    public function helpSupport(Request $request){
        $validator = \Validator::make($request->all(), [
            'subject_id' =>'required',
            'message' =>'required',
        ],[
            'subject_id.required' => trans("validator.required",['attribute'=>'subject']),
            'message.required' => trans("validator.required",['attribute'=>'message']),
        ]);
        
        if($validator->fails()){
            $this->message = $validator->errors();
        }else{
            $insert=[
                'user_id'=>Auth::guard('api')->id(),
                'subject_id'=>$request->subject_id,
                'message'=>$request->message,
                'status'=>'0'
            ];
            
            if(!empty($request->image)){
                $filename = $request->image->getClientOriginalName();
                $imageName = time().'.'.$filename;
                if(env('APP_ENV') == 'local'){
                    $return = $request->image->move(
                    base_path() . '/public/uploads/help_center/', $imageName);
                }else{
                    $return = $request->image->move(
                    base_path() . '/../public/uploads/help_center/', $imageName);
                }
                $url = url('/uploads/chat_group/');
                $insert['image'] = $url.'/'. $imageName;
            }
            
            Help_support::create($insert);
            $this->status   = true;
            $this->message  = 'Query submitted successfully';
        }
        return $this->populateResponse();
    }

    // Send Query
     
    /*****************************  USER QUERY *********************************/

    public function getuser(Request $request){
        $user =User::select("quickblog_id")->where('id',Auth::guard('api')->id())->first();
        if(!empty($user->quickblog_id)){
           $user->selected=true;
           $response = new \Lib\PopulateResponse($user);
           $this->status = true;
           $this->data = $response->apiResponse();
           $this->message  = 'user quickblog id';
        }else{
           $user->selected=false;
           $response = new \Lib\PopulateResponse($user);
           $this->status = true;
           $this->data = $response->apiResponse();
           $this->message  = 'user quickblog id does not exist';
        }
      
    
      return $this->populateResponse();
   }
   
}
