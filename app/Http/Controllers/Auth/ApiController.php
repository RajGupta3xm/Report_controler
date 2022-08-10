<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use App\Models\PromoCode;
use App\Models\Countries;
use App\Models\FitnessGoal;
use App\Models\DislikeItem;
use App\Models\UserProfile;
use App\Models\UserDislike;
use App\Models\DietPlanType;
use App\Models\DislikeCategory;
use App\Models\SubscriptionPlan;
use App\Models\Content;
use App\Models\Query;
use App\Models\QueryReply;

use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller {


    protected $content;

    public function __construct(Content $content)
    {
        $this->content = $content;

        DB::enableQueryLog();
    }

    // public function __construct() {
    //     DB::enableQueryLog();
    // }

    public function register(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'country_code' => 'required',
            'mobile' => 'required'
        ], [
            'name.required' => trans('validation.required', ['attribute' => 'name']),
            'email.required' => trans('validation.required', ['attribute' => 'email']),
            'country_code.required' => trans('validation.required', ['attribute' => 'country_code']),
            'mobile.required' => trans('validation.required', ['attribute' => 'mobile']),
        ]);
        if ($validatedData->fails()) {
            $this->status_code = 201;
            $this->message = $validatedData->errors();
        } else {
            $ifMobile = User::where(['country_code' => $request['country_code'],'mobile'=>$request['mobile']])->get()->first();
            if ($ifMobile) {
                User::where('id',$ifMobile->id)->update(['email'=>$request['email']]);
                $newUser = User::find($ifMobile->id);
            }else{
                $insert = [
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'country_code' => $request['country_code'],
                    'mobile'=> $request['mobile']
                ];

                $newUser = User::create($insert);
            }

            if($request->referal_code){

            }
            
            
            //dd($resultSMS);
            if ($newUser) {
                $createOtp = [
                    'user_id' => $newUser->id,
                    'otp' => '1234'
                ];
                $newUser->otp = $createOtp['otp'];
                $otp = Otp::create($createOtp);
                $newUser->user_id = $newUser->id;
                $response = new \Lib\PopulateResponse($newUser);
                $this->data = $response->apiResponse();
                $this->message = trans('messages.register');
            } else {
                $this->status_code = 202;
                $this->message = trans('messages.server_error');
            }
            $this->status = true;
        }

        return $this->populateResponse();
    }


    public function verifyOtp(request $request) {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
            'otp' => 'required'
        ], [
            'user_id.required' => trans('validation.required', ['attribute' => 'user_id']),
            'otp.required' => trans('validation.required', ['attribute' => 'otp']),
        ]);
        $validate->after(function ($validate) use ($request) {
            $userOtp = Otp::where(['user_id' => $request['user_id'], 'otp' => $request['otp']])->get()->first();
            if (!$userOtp) {
                $validate->errors()->add('otp', trans('messages.invalid_otp'));
            }
        });
        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
            $user = User::where('id', $request->user_id)->get()->first();
           
            $updateUser = User::where('id', $request->user_id)->update(['is_otp_verified' => '1', 'status' => '1']);
            
            $updateArr = array();
            if ($request->device_token != "" && $request->device_type != "") {
                $updateArr['device_token'] = $request->device_token;
                $updateArr['device_type'] = $request->device_type ? $request->device_type : 0;
            }
            if ($updateArr) {
                User::where('id', $user->id)->update($updateArr);
            }
            $user->user_id = $user->id;
            $user = $this->getToken($user);
            $response = new \Lib\PopulateResponse($user);
            $this->data = $response->apiResponse();
            
            $this->message = trans('messages.otp_verified');
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function login(request $request) {
        $validate = Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile' => 'required'
        ], [
            'country_code.required' => trans('validation.required', ['attribute' => 'country_code']),
            'mobile.required' => trans('validation.required', ['attribute' => 'mobile']),
        ]);

        $validate->after(function ($validate) use ($request) {
            $this->status_code = 201;
            $user = User::where(['country_code' => $request->country_code, 'mobile' => $request->mobile])->get()->first();
            if ($user) {
                if ($user->status == 2) {
                    $this->message = trans('messages.account_blocked');
                    $this->status_code = 203;
                    $validate->errors()->add('mobile', $this->message);
                }
            } else {
                $this->message = trans('messages.not_registered');
                $this->status_code = 201;
                $validate->errors()->add('mobile', $this->message);
            }
        });

        if ($validate->fails()) {

            $this->message = $validate->errors();
        } else {
            $this->status = true;
            $user = User::where(['country_code' => $request->country_code, 'mobile' => $request->mobile])->get()->first();
            Otp::where('user_id', $user->id)->delete();
            $createOtp = [
                'user_id' => $user->id,
                'otp'=>'1234'
            ];
            $data['user_id'] = $user->id;
            $data['otp'] = $createOtp['otp'];
            $otp = Otp::create($createOtp);
            $updateArr = array();
            if ($request->device_token != "" && $request->device_type != "") {
                $updateArr['device_token'] = $request->device_token;
                $updateArr['device_type'] = $request->device_type ? $request->device_type : 0;
            }
            if ($updateArr) {
                User::where('id', $user->id)->update($updateArr);
            }
            $user->user_id = $user->id;
            
            // $data = $user;
            $this->message = trans('messages.login_success');
            $this->status_code = 200;
            
            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
        }
        return $this->populateResponse();
    }

    public function getToken($user) {
        $userTokens = $user->tokens;

        foreach ($userTokens as $utoken) {
            $utoken->revoke();
        }

        $tokenResult = $user->createToken('MyApp');
        $token = $tokenResult->token;
        $token->save();
        $user['token'] = $tokenResult->accessToken;
        if ($user->image == null) {
            $user->image = url('assets/images/dummy2.jpg');
        }
        return $user;
    }

    public function aboutUs()
    {
        $content = $this->content->fetchtremsData('About Us');

        $response = new \Lib\PopulateResponse(compact('content'));

        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'about us content';
        
        return $this->populateResponse();     
    }

    public function privacyPolicy()
    {
        $content = $this->content->fetchtremsData('Privacy Policy');

        $response = new \Lib\PopulateResponse(compact('content'));

        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'privacy policy content';
        
        return $this->populateResponse();     
    }

    public function termsConditions()
    {
        $content = $this->content->fetchtremsData('Terms and Conditions');

        $response = new \Lib\PopulateResponse(compact('content'));

        $this->data = $response->apiResponse();
        $this->status   = true;
        $this->message  = 'content';
        
        return $this->populateResponse();     
    }

    public function myProfile() {
        $user = User::select('id as user_id', 'users.*')->where('id', Auth::guard('api')->id())->first();        
        $data = $user;
        $this->status = true;
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();

        $this->message = trans('messages.my_profile');

        return $this->populateResponse();
    }

    public function editProfile(Request $request) {
        $addUser=[];
        if ($request->name && $request->name!="") {
            $addUser['name'] = $request->name;
        }
        if ($request->country_id) {
            $addUser['country'] = $request->country_id;
        }
        if ($request->email) {
            $addUser['email'] = $request['email'];
        }
        if ($request->image) {
            $image = $request->image;
            $filename = $image->getClientOriginalName();
            $filename = str_replace(" ", "", $filename);
            $imageName = time() . '.' . $filename;
            $return = $image->move(
                    base_path() . '/public/uploads/user/', $imageName);
            $url = url('/uploads/user/');
            $addUser['image'] = $url . '/' . $imageName;
        }

        if($addUser){
            User::where('id', Auth::guard('api')->id())->update($addUser);
            $data = User::select('id as user_id', 'users.*')->find(Auth::guard('api')->id());
            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
            $this->message = trans('messages.update_profile_success');
        }else{
            $this->message = trans('messages.update_profile_success');
        }
        $this->status = true;
        
        return $this->populateResponse();
    }

    public function homescreen(request $request) {
        
        $profile=UserProfile::where('user_id',Auth::guard('api')->id())->first();
        if($profile){
            $flag=true;
            if($profile->fitness_scale_id == Null){
                $flag=false;
                $this->status_code=203;
                $this->message = trans('messages.fitness_selection_incomplete');
            }
            if($profile->diet_plan_type_id == Null){
                $flag=false;
                $this->status_code=204;
                $this->message = trans('messages.diet_plan_selection_incomplete');
            }
            if(!UserDislike::where(['user_id'=>Auth::guard('api')->id(),'status'=>'active'])->first()){
                $flag=false;
                $this->status_code=205;
                $this->message = trans('messages.dislikes_selection_incomplete');
            }
            if($flag){
                $data['promo_codes']=PromoCode::select('id','name','description','image')->where(['status'=>'active'])
                // ->whereRaw("((start_date < ".date('Y-m-d')." OR start_date == ".date('Y-m-d').") AND ((end_date > ".date('Y-m-d')." OR end_date == ".date('Y-m-d').") OR (extended_end_date > ".date('Y-m-d')." OR extended_end_date == ".date('Y-m-d').")))")
                ->where('end_date','>',"'".date('Y-m-d')."'")
                ->orWhere('extended_end_date','>',"'".date('Y-m-d')."'")
                ->get();
                // $data['plan_list']=SubscriptionPlan::where(['duration_type'=>'weekly','status'=>'active'])->get();
                $data['plan_type_list']=DietPlanType::select('id','name')->where(['status'=>'active'])->get();
                $data['my_plan']=new \stdClass();
                $this->message = trans('messages.homescreen_success');
                $response = new \Lib\PopulateResponse($data);
                $this->data = $response->apiResponse();
            }
            
        }else{
            $this->status_code=200;
            $this->message = trans('messages.homescreen_without_setup');
        }  
        $this->status = true; 
        
       
            
        return $this->populateResponse();
    }

    public function updatePersonalDetails(Request $request){
        $validate = Validator::make($request->all(), [
            'height' => 'required',
            'weight' => 'required',
            'dob' => 'required',
            'age' => 'required',
            'gender'=>'required',
            'activity_scale'=>'required',
        ], [
            'height.required' => trans('validation.required', ['attribute' => 'height']),
            'weight.required' => trans('validation.required', ['attribute' => 'weight']),
            'dob.required' => trans('validation.required', ['attribute' => 'dob']),
            'age.required' => trans('validation.required', ['attribute' => 'age']),
            'gender.required' => trans('validation.required', ['attribute' => 'gender']),
            'activity_scale.required' => trans('validation.required', ['attribute' => 'activity_scale'])
        ]);
        if ($validate->fails()) {
            $this->message = $validate->errors();
        } else {
            $user=UserProfile::updateOrCreate(
                ['user_id' =>  Auth::guard('api')->id()],
                [
                    'user_id' =>  Auth::guard('api')->id(),
                    'initial_body_weight' => $request->weight,
                    'height'=> $request->height,
                    'dob'=> $request->dob,
                    'age'=> $request->age,
                    'gender'=> $request->gender,
                    'activity_scale'=> $request->activity_scale
                ]
            );
            $this->status = true; 
            $this->message = trans('messages.update_profile_success');
        }
        
        return $this->populateResponse();
    }

    public function updateFitnessDetails(Request $request){
        $updates=[];
        if($request->fitness_scale_id){
            $updates['fitness_scale_id']=$request->fitness_scale_id;
        }
        if($request->diet_plan_type_id){
            $updates['diet_plan_type_id']=$request->diet_plan_type_id;
        }
        if($updates){
            $user=UserProfile::where('user_id',Auth::guard('api')->id())->update($updates);
        }   
        
        $this->status = true; 
        $this->message = trans('messages.update_profile_success');
        return $this->populateResponse();
    }

    public function fitnessGoals() {
        $fitnessGoals = FitnessGoal::select('id','name')->where('status','active')->get()->each(function($fitnessGoals){
            $fitnessGoals->selected=false;
            if(UserProfile::where(['user_id'=>Auth::guard('api')->id(),'fitness_scale_id'=>$fitnessGoals->id])->first()){
                $fitnessGoals->selected=true;
            }
        });
        $response = new \Lib\PopulateResponse($fitnessGoals);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('messages.fitness_goal_list');
        return $this->populateResponse();
    }

    public function dislikes() {
        $category=DislikeCategory::select('id','name')->with('items')->where('status','active')->get()->each(function($category){
            foreach($category->items as $item){
                $item->selected=false;
                if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$item->id,'status'=>'active'])->first()){
                    $item->selected=true;
                }
            }
            
        });

        $response = new \Lib\PopulateResponse($category);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('messages.dislike_items_list');
        return $this->populateResponse();
    }

    public function dietPlanType() {
        $plan_types = DietPlanType::select('id','name')->where('status','active')->get()->each(function($plan_types){
            $plan_types->selected=false;
            if(UserProfile::where(['user_id'=>Auth::guard('api')->id(),'diet_plan_type_id'=>$plan_types->id])->first()){
                $plan_types->selected=true;
            }
        });;
        $response = new \Lib\PopulateResponse($plan_types);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('messages.diet_plan_type_list');
        return $this->populateResponse();
    }

    public function countryList() {
        $country = Countries::select('id','name')->where('status', '<>',['inactive','trashed'])->get();
        $response = new \Lib\PopulateResponse($country);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('messages.country_list');
        return $this->populateResponse();
    }

    public function recommendedCaloriChart() {
        $country = Countries::where('status', '<>',['inactive','trashed'])->get();
        $response = new \Lib\PopulateResponse($country);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('messages.country_list');
        return $this->populateResponse();
    }

    
    // public function helpSupport(Request $request) {
    //     $validatedData = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'email' => 'required|email',
    //         'subject' => 'required',
    //         'message' => 'required'
    //     ], [
    //         'name.required' => trans('validation.required', ['attribute' => 'name']),
    //         'email.required' => trans('validation.required', ['attribute' => 'email']),
    //         'email.email' => trans('validation.email', ['attribute' => 'email']),
    //         'subject.required' => trans('validation.required', ['attribute' => 'subject']),
    //         'message.required' => trans('validation.required', ['attribute' => 'message'])
    //     ]);

    //     if ($validatedData->fails()) {
    //         $this->status_code = 201;
    //         $this->message = $validatedData->errors();
    //     } else {
    //         $insert = [
    //             'user_id' => Auth::guard('api')->id(),
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'subject' => $request->subject,
    //             'message' => $request->message,
    //             'created_at' => date('Y-m-d H:i:s'),
    //             'updated_at' => date('Y-m-d H:i:s'),
    //         ];
    //         $data = Query::insertGetId($insert);
    //         if ($data) {
    //             $this->message = trans('messages.query_sent');
    //         } else {
    //             $this->message = trans('messages.server_error');
    //             $this->status_code = 202;
    //         }
    //         $this->status = true;
    //     }
    //     return $this->populateResponse();
    // }


    public function notificationList() {
        $notifications = AppNotification::where('user_id', Auth::guard('api')->id())->where('type', '<>', 'post-tag')->orderBy('id', 'DESC')->get();
        $response = new \Lib\PopulateResponse($notifications);
        $this->data = $response->apiResponse();
        $this->status = true;
        $this->message = trans('messages.notification_list');
        return $this->populateResponse();
    }

    public function clearNotifications(Request $request) {
        if ($request->notification_id) {
            $this->message = trans('messages.notification_delete_success');
            $notifications = AppNotification::where('id', $request->notification_id)->where('user_id', Auth::guard('api')->id())->delete();
        } else {
            $this->message = trans('messages.notification_clear_success');
            $notifications = AppNotification::where('user_id', Auth::guard('api')->id())->delete();
        }
        $this->status = true;
        if ($notifications) {

        } else {
            // $this->status_code = 201;
            // $this->message = "Server could not get any response. Please try again later.";
        }
        return $this->populateResponse();
    }


    public function getLogout() {
        Auth::logout();
        $data = Users::where('user_id', Auth::guard('api')->id())->update(['device_token' => '']);
        $data = DB::table('oauth_access_tokens')->where('user_id', Auth::guard('api')->id())->update(['revoked' => '1']);
        $this->status = true;
        $this->message = trans('messages.logout');
        return $this->populateResponse();
    }

    public function switchPushNotification(){
            $user=Users::select('push_notification')->where('id','=',Auth::guard('api')->id())->first();
            if($user['push_notification'] == 'on'){
                $status='off';
                $this->message  = trans('messages.push_off');
            }else{
                $status='on';
                $this->message  = trans('messages.push_on');
            }
            $user = Users::where('id','=',Auth::guard('api')->id())->update(['push_notification'=>$status]);

            $user=Users::select('push_notification')->where('id','=',Auth::guard('api')->id())->first();
            
            $response = new \Lib\PopulateResponse($user);

            $this->data = $response->apiResponse();
            $this->status   = true;

            
            return $this->populateResponse();
        }


        public function helpSupportListing(Request $request){
            //  return $id = Auth::guard('api')->id();
            $queryList = Query::select('*')->where('user_id',Auth::guard('api')->id())->orderBy('id','desc')->get();
            $myQuery = [];
             if($queryList){
                 foreach($queryList as $query){
                     if($query->status == 1){
                        $query->status = "Closed"; 
                     }else{
                        $query->status = "Open"   ;
                     }
                    array_push($myQuery, $query);
                   
                 }
                  $data['query_list'] = $myQuery;
                  if($data){
                    $this->status = true;
                    $this->message = trans('messages.query_list');
                    $response = new \Lib\PopulateResponse($data);
                    $this->data = $response->apiResponse();
                  }else {
                    $this->status = true;
                    $this->status_code = 202;
                    $this->message = trans('messages.server_error');
                }
                return $this->populateResponse();
            }
           
        }
        
        
        public function helpSupportFirstReply(Request $request){
            $validate = Validator::make($request->all(), [
                'message' => 'required'
            ], [
                'message.required' => trans('validation.required', ['attribute' => 'message']),
            ]);
            if ($validate->fails()) {
                $this->status_code = 201;
                $this->message = $validate->errors();
            } else {
                $data=[
                    "message" => $request->input('message'),
                    'user_id' => Auth::guard('api')->id(),
                    'ticket_id'  => strtoupper(str_random(10)),
                    'type'  =>  'chat',
                ];
               
                $insert = Query::create($data);
                if($insert){
                 $response = new \Lib\PopulateResponse($insert);
                 $this->data = $response->apiResponse();
                 $this->message = trans('messages.query_sent');
                }else {
                    $this->message = trans('messages.server_error');
                    $this->status_code = 202;
                }
                $this->status = true;
            }
            return $this->populateResponse();
        }


        public function helpSupportReply(Request $request){
            $validate = Validator::make($request->all(), [
                'reply' => 'required'
            ], [
                'reply.required' => trans('validation.required', ['attribute' => 'reply']),
            ]);
            if ($validate->fails()) {
                $this->status_code = 201;
                $this->message = $validate->errors();
            } else {
                $id =  $request['query_id'];
                $data=[
                  "reply" => $request->input('reply'),
                  'user_type' => 'user',
                  'query_id'  =>  $id,
              ];
                //  $update = Query::find($id)->update($data);
                $insert = QueryReply::create($data);
                if($insert){
                    $data['last_reply_id'] = $insert->id;
                    $update = Query::find($id)->update($data);
                }
                if($insert){
                 $response = new \Lib\PopulateResponse($insert);
                 $this->data = $response->apiResponse();
                 $this->message = trans('messages.reply_sent');
                } else {
                    $this->message = trans('messages.server_error');
                    $this->status_code = 202;
                }
                $this->status = true;
            }
            return $this->populateResponse();
        }  
        
        
        public function helpSupportDetail(Request $request){
        
            $query = Query::with('queryreply')->where('id',$request->query_id)->where('user_id',Auth::guard('api')->id())->orderBy('id','asc')->get();
            $data['query'] = $query;
            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
            $this->status   = true;
            $this->message  = trans('messages.myQuery_list');
            return $this->populateResponse(); 
        }


}
