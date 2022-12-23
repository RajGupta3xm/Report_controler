<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use App\Models\PromoCode;
use App\Models\Countries;
use App\Models\ReferEarnContent;
use App\Models\CalorieRecommend;
use App\Models\UserCaloriTarget;
use App\Models\ReferAndEarnUsed;
use App\Models\FitnessGoal;
use App\Models\DislikeItem;
use App\Models\UserUsedPromoCode;
use App\Models\MealIngredientList;
use App\Models\UserProfile;
use App\Models\SocialLink;
use App\Models\SelectDeliveryLocation;
use App\Models\UserDislike;
use App\Models\DietPlanType;
use App\Models\DislikeCategory;
use App\Models\DislikeGroup;
use App\Models\ReferAndEarn;
use App\Models\SubscriptionMealPlanVariant;
use App\Models\SubscriptionPlan;
use App\Models\Cities;
use App\Models\Subscription;
use App\Models\Content;
use App\Models\MealRating;
use App\Models\DeliveryDay;
use App\Models\Query;
use App\Models\Meal;
use App\Models\QueryReply;
use App\Models\OnboardingScreen;
use App\Models\UserCard;
use App\Models\UserAddress;
use App\Models\HomeScreenBanner;
use App\Models\DeliverySlot;
use App\Models\GiftCard;
use App\Models\SubscriptionDietPlan;
use App\Models\SubscriptionMealGroup;
use App\Models\SubscriptionCosts;
use App\Models\UserGiftCard;
use App\Models\MealSchedules;

use App\Models\CreditTransaction;
use App\Models\UserSelectedDaysForAddress;
use Carbon\Carbon;
use DateTime;
use App\Mail\YourMailTemplate;
use Mail;


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
            // 'family_name' => 'required',
            'email' => 'required',
            'country_code' => 'required',
            'mobile' => 'required'
        ], [
            'name.required' => trans('validation.required', ['attribute' => 'name']),
            // 'family_name.required' => trans('validation.required', ['attribute' => 'family_name']),
            'email.required' => trans('validation.required', ['attribute' => 'email']),
            'country_code.required' => trans('validation.required', ['attribute' => 'country_code']),
            'mobile.required' => trans('validation.required', ['attribute' => 'mobile']),
        ]);

        $validatedData->after(function ($validatedData) use ($request) {
            if($request['country_code'] && $request['mobile']){
                $mobile_number = User::where('country_code',$request['country_code'])->where('mobile',$request['mobile'])->whereNotIn('status',['0'])->first();
                if ($mobile_number) {
                    $validatedData->errors()->add('mobile_number', 'This number is already exist, Please signup with another number');
                 
                    
                }
            }
            if($request['referal_code']){
            $CheckReferIsValid = ReferAndEarn::where('ticket_id',$request->referal_code)->first();
            if(empty($CheckReferIsValid))
            {
                $validatedData->errors()->add('referral', 'This code is not valid');
            }
         }

            // if($request['email']){
            //     $email = User::where('email',$request['email'])->whereNotIn('status',['0'])->first();
            //     if ($email) {
            //         $validatedData->errors()->add('email', 'email already registered');
            //     }
            // }
            
        });
        
        if ($validatedData->fails()) {
            // return response()->json([
            //     "status" => false,
            //     "data"=> [],
            //     "message"=>  'User already register',
            //     "status_code" =>201,
            //  ]);
            $this->status_code = 201;
            $this->message = $validatedData->errors();

            // return response()->json([$responseArr]);
            // $this->status_code = 201;
            // $this->message = 'kkk';
        } else {
            $ifMobile = User::where(['country_code' => $request['country_code'],'mobile'=>$request['mobile']])->get()->first();
            if ($ifMobile) {
                User::where('id',$ifMobile->id)->update(['email'=>$request['email']]);
                $newUser = User::find($ifMobile->id);
            }else{
                $insert = [
                    'name' => $request['name'] .' ' . $request['family_name'] ,
                    'email' => $request['email'],
                    'country_code' => $request['country_code'],
                    'mobile'=> $request['mobile']
                ];

                $newUser = User::create($insert);
            }

            if($request->referal_code){
                $referee_id = $request->referee_id;
                $CheckReferIsValid = ReferAndEarn::where('ticket_id',$request->referal_code)->first();
                if(!empty($CheckReferIsValid)){
                    $insertReferRegistration = [
                    'refer_and_earn_id'  => $CheckReferIsValid->id,
                    'referral_id'  => $newUser->id,
                    'referee_id'  => $referee_id,
                    'used_for'  => 'registration',

                    ];
                    $refer_registration = ReferAndEarnUsed::create($insertReferRegistration);

                    $referral_registration = ReferAndEarnUsed::join('refer_and_earn','refer_and_earn_used.refer_and_earn_id','=','refer_and_earn.id')
                    ->select('refer_and_earn.*')
                    ->where('refer_and_earn.status','active')
                    ->where('refer_and_earn_used.status','active')
                    ->where('refer_and_earn_used.referral_id',$newUser->id,)
                    ->where('refer_and_earn_used.used_for','registration')
                    ->get();
                    $totalCostRegistration = 0; 
                    foreach($referral_registration as $cost){
                       $totalCostRegistration += $cost->register_referral;
                   }
                   $referee_registration = ReferAndEarnUsed::join('refer_and_earn','refer_and_earn_used.refer_and_earn_id','=','refer_and_earn.id')
                    ->select('refer_and_earn.*')
                    ->where('refer_and_earn.status','active')
                    ->where('refer_and_earn_used.status','active')
                    ->where('refer_and_earn_used.referee_id',$referee_id,)
                    ->where('refer_and_earn_used.used_for','registration')
                    ->get();
                    $totalCostRefereeRegistration = 0; 
                    foreach($referee_registration as $cost){
                       $totalCostRefereeRegistration += $cost->register_referee;
                   }
                   UserProfile::updateOrCreate(
                    ['user_id' =>  $referee_id],
                    [
                        'available_referral' => $totalCostRefereeRegistration,
                       
                    ]
                   
                 );
                  
                   UserProfile::updateOrCreate(
                       ['user_id' =>  $newUser->id],
                       [
                           'available_referral' => $totalCostRegistration,
                          
                       ]
                      
                   );
                 
                }
   
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
           
             $userProfile = UserProfile::where('user_id', $request->user_id)->get()->first();
             if(!empty($userProfile)){
                $user->detailStatus = 'filled';
             }else{
                $user->detailStatus = 'pending';
             }
           
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

     // Resend OTP on email/mobile
     public function resendOTP(Request $request)    
     {
         $user = User::find($request->user_id);
         if($user){
             $otpUser['otp']             =   '1234';
             $otpUser['user_id']         =   $request->user_id;
             $otp                        =   Otp::create($otpUser);
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
            // return response()->json([
            //     "status" => false,
            //     "data"=> [],
            //     "message"=>  $validate->errors(),
            //     "status_code" =>201,
            //  ]);
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
            // $user->image = url('assets/images/dummy2.jpg');
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
         $userProfile = UserProfile::where('user_id', Auth::guard('api')->id())->first();
         $name = trim($user->name);
         $family_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
         $first_name = trim( preg_replace('#'.$family_name.'#', '', $name ) );        
        $data = $user;
        $data->age = $userProfile->age;
        $data->family_name = $family_name;
        $data->first_name = $first_name;
        $data->gender = $userProfile->gender;
        $data->dob = $userProfile->dob;
        $this->status = true;
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();

        $this->message = trans('messages.my_profile');

        return $this->populateResponse();
    }

    public function editProfile(Request $request) {
        $validator = \Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'country_code' => 'required',
            // 'mobile' => 'required|numeric',
            'mobile' => 'required',
            'email' => 'required',
            'image' => 'required',
            'dob' => 'required',
            'gender' => 'required',

                ], [
            'first_name.required' =>    'first_name is required field',
            'last_name.required' =>    'last_name is required field',
            'email.required' =>         'email is required field',
            'image.required' =>          'image is required field',
            'dob.required' =>           'dob is required field',
            'gender.required' => 'gender is required field',
            'mobile.required' => 'Mobile Number is required field',
            // 'mobile.numeric' => 'Mobile Number should be numeric ',
       ]);

      $validator->after(function ($validator) use ($request) {

      });

      if ($validator->fails()) {
       //  return ($validator->errors());
       $this->status_code = 201;
       $this->message = $validator->errors();
      }else{
        $addUser=[];
        $editProfile=[];
        if ($request->first_name && $request->last_name) {
            $addUser['name'] = $request->first_name. ' ' .$request->last_name;
        }
       
        if ($request->country_code) {
            $addUser['country_code'] = $request->country_code;
        }
        if ($request->mobile) {
            $addUser['mobile'] = $request->mobile;
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

        // if($request->dob || $request->gender){
        //     $editProfile = [
        //         'dob'  => $request->dob,
        //         'gender'  => $request->gender,
        //     ]; 
             
            UserProfile::where('user_id', Auth::guard('api')->id())
            ->update([
                'dob'  => $request->dob,
                'gender'  => $request->gender,

            ]);

        

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
    }
        return $this->populateResponse();
    }

    public function homescreen(Request $request) {
        
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

                $data['home_screen_banner'] = HomeScreenBanner::select('*')->get();

                   $data['your_subscription'] = Subscription::join('subscription_plans','subscriptions.plan_id','=','subscription_plans.id')
                   ->select('subscription_plans.name','subscription_plans.description','subscription_plans.image','subscriptions.*')
                   ->where('user_id',Auth::guard('api')->id())->where('delivery_status','paused')
                   ->get();

                 $data['promo_codes']=PromoCode::select('id','name','description','image')->where(['status'=>'active'])
                // ->whereRaw("((start_date < ".date('Y-m-d')." OR start_date == ".date('Y-m-d').") AND ((end_date > ".date('Y-m-d')." OR end_date == ".date('Y-m-d').") OR (extended_end_date > ".date('Y-m-d')." OR extended_end_date == ".date('Y-m-d').")))")
                ->where('end_date','>',"'".date('Y-m-d')."'")
                ->orWhere('extended_end_date','>',"'".date('Y-m-d')."'")
                ->get();
                // $data['plan_list']=SubscriptionPlan::where(['duration_type'=>'weekly','status'=>'active'])->get();
                $data['plan_type_list']=DietPlanType::select('id','name')->where(['status'=>'active'])->get();
                // $data['my_plan']=new \stdClass();

                $plan_type= $request->plan_types;
                $selectDietPlan = DietPlanType:: select('diet_plan_types.name','diet_plan_types.id')
                ->get()
                // ->toArray();
            
                ->each(function($selectDietPlan) use($plan_type) {
                        // $user_recommended_calorie=2200;
                       
                           $subscriptions=SubscriptionPlan::select('id','name','image')->where(['status'=>'active'])->get();
                        
                        if($subscriptions){
                            foreach($subscriptions as $subscription){
                                $subscription->cost="0";
                                $subscription->delivery_day_type="N/A";
                                // $plan_type= $request->plan_types;
                                // $plan_type=2;
                                $subscription->meal_groups=[];
                
                                if(SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id,'diet_plan_id'=>$selectDietPlan->id])->first()){
                                    if($plan_type == 1 || $plan_type == 2){
                                        $subscription->delivery_day_type="Week";
                                    }else{
                                        $subscription->delivery_day_type="Month";
                                    }
                                          $deliveryDay=DeliveryDay::find($plan_type);

                
                                        if(SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id,'option1'=>$deliveryDay->type])->first()){
                                            if(SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id,'option2'=>$deliveryDay->including_weekend])->first()){
                                          $costss=SubscriptionMealPlanVariant::where(['meal_plan_id'=>$subscription->id,'diet_plan_id'=>$selectDietPlan->id])->get();
                                          foreach($costss as $costs){

                                          $subscription->cost=$costs['plan_price'];
                
                                        $meals=[];
                                        $meal_des=[];
                                          $subscription->meal_groups=SubscriptionMealGroup::select('meal_schedule_id')->with('meal_group')->where(['plan_id'=>$subscription->id])->get();
                                        foreach($subscription->meal_groups as $meal){
                                          
                                            array_push($meal_des,$meal->meal_group->name);
                                        }
                                        $meal_des=count($meal_des)." Meals Package (".implode(',',$meal_des).")";
                
                                        $subscription->description=[
                                            "Serves Upto $costs->serving_calorie calories out of $costs->calorie calories recommended for you.",
                                            $deliveryDay->number_of_days." days a ".$subscription->delivery_day_type,
                                            " ".$meal_des
                                        ];
                                         $subscription->meal_groups='';
                
                                        }
                                     }
                                    }
                                }
  
                                
                            }
                        }
                    
                         $selectDietPlan->meals=$subscriptions;
                        
                        });

                $data['select_diet_plan'] = $selectDietPlan;
                
        
                 $dietPlanType = DietPlanType:: select('diet_plan_types.name','diet_plan_types.id')
                ->get()
                // ->toArray();
                ->each(function($dietPlanType) {
                   $meals= $dietPlanType->meals= Meal::join('meal_diet_plan','meals.id','=','meal_diet_plan.meal_id')
                   ->where('meal_diet_plan.diet_plan_type_id', $dietPlanType->id)
                   ->select('meals.id as meal_id','meals.name as meal_name','meals.food_type','image','meals.created_at as date')->get()
                 ->each(function($meals){
                    $meals->meal_schedule= MealSchedules::join('meal_group_schedule','meal_schedules.id','=','meal_group_schedule.meal_schedule_id')
                   ->where('meal_group_schedule.meal_id', $meals->meal_id)
                   ->select('meal_schedules.name')->first();
                });       
                })->toArray(); 
                $data['our_preview_plan'] = $dietPlanType;
                // echo '<pre>';print_r($category);
                // die;

                $this->message = trans('messages.homescreen_success');
                $response = new \Lib\PopulateResponse($data);
                $this->data = $response->apiResponse();
            }
            
        }else{
            $this->status_code=206;
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
            $step = '';
        if($request->step=='1'){
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
        }
        elseif($request->step=='2'){
            $user=UserProfile::updateOrCreate(
                ['user_id' =>  Auth::guard('api')->id()],
                [
                    'fitness_scale_id'=> $request->fitness_scale_id
                ]
            );

        }
        elseif($request->step == '3'){
            UserDislike::where('user_id',Auth::guard('api')->id())->delete();
             $add_item = json_decode($request->item_id,TRUE);
            if($add_item){
              foreach($add_item as $item_id){
               
                $user=UserDislike::create([
                    'user_id' =>  Auth::guard('api')->id(),
                    'item_id'=> $item_id
                ]);
                //   $user=UserDislike::updateOrCreate(
                //   ['user_id' =>  Auth::guard('api')->id(),
                //  'item_id'=> $item_id
                //   ],
                //   [
                //     'user_id' =>  Auth::guard('api')->id(),
                //     'item_id'=> $item_id
                //   ]
                //   );
                } 
           }
        }
        elseif($request->step == '4'){
            $user=UserProfile::updateOrCreate(
                ['user_id' =>  Auth::guard('api')->id()],
                [
                    'diet_plan_type_id'=> $request->diet_plan_type_id
                ]
            );
        }
     
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
        $category=DislikeGroup::select('id','name','image')
        // ->with('items')
        ->where('status','active')->get();
        // ->each(function($category){
            foreach($category as $item){
                $item->selected=false;
                if(UserDislike::where(['user_id'=>Auth::guard('api')->id(),'item_id'=>$item->id,'status'=>'active'])->first()){
                    $item->selected=true;
                }
            }
            
        // });

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


        public function mealRating(Request $request){
            $validate = Validator::make($request->all(), [
                'meal_id' => 'required'
            ], [
                'meal_id.required' => trans('validation.required', ['attribute' => 'meal id']),
            ]);
            if ($validate->fails()) {
                $this->status_code = 201;
                $this->message = $validate->errors();
            } else {
                $data=[
                  "meal_id" => $request->input('meal_id'),
                  "user_id" => Auth::guard('api')->id(),
                  "rating" => $request->input('rating'),
              ];
                $insert = MealRating::create($data);
                if($insert){
                 $response = new \Lib\PopulateResponse($insert);
                 $this->data = $response->apiResponse();
                 $this->message = trans('messages.rating_message');
                } else {
                    $this->message = trans('messages.server_error');
                    $this->status_code = 202;
                }
                $this->status = true;
            }
            return $this->populateResponse();
        }    
        
        

        public function addCard(Request $request){
            $validate = Validator::make($request->all(), [
                'card_holder_name' => 'required',
                'card_number' => 'required',
                'expiry_date' => 'required',
                'card_type' => 'required'

            ], [
                'card_holder_name.required' => trans('validation.required', ['attribute' => 'card holder name']),
                'card_number.required' => trans('validation.required', ['attribute' => 'card_number ']),
                'expiry_date.required' => trans('validation.required', ['attribute' => 'expiry date ']),
                'card_type.required' => trans('validation.required', ['attribute' => 'card type  ']),
            ]);
            if ($validate->fails()) {
                $this->status_code = 201;
                $this->message = $validate->errors();
            } else {
                $data=[
                  "card_holder_name" => $request->input('card_holder_name'),
                  "user_id" => Auth::guard('api')->id(),
                  "card_number" => $request->input('card_number'),
                  "expiry_date" => $request->input('expiry_date'),
                  "cvv" => $request->input('cvv'),
              ];

              if($request->card_type == "credit"){
                $data['card_type']  =  "credit";
              }else{
                $data['card_type']  =  "debit";
              }
              
                $insert = UserCard::create($data);
                if($insert){
                 $response = new \Lib\PopulateResponse($insert);
                 $this->data = $response->apiResponse();
                 $this->message = trans('messages.card_add');
                } else {
                    $this->message = trans('messages.server_error');
                    $this->status_code = 202;
                }
                $this->status = true;
            }
            return $this->populateResponse();
        } 



public function deleteAddCard(Request $request) {
    $validator = \Validator::make($request->all(), [
                'card_id' => 'required'
                    ], [
                'card_id.required' => trans('validation.required', ['attribute' => 'card id'])
    ]);
    if ($validator->fails()) {
        $this->status_code = 201;
        $this->message = $validator->errors();
    } else {
        $delete = UserCard::where(['user_id' => Auth::guard('api')->id(), 'id' => $request->card_id])->delete();
        if ($delete) {
            $this->message = trans('messages.card_delete');
        } else {
            $this->status_code = 202;
            $this->message =  trans('messages.server_error');
        }
        $this->status = true;
    }
    return $this->populateResponse();
}


public function addAddress(Request $request){
    $validate = Validator::make($request->all(), [
        'area' => 'required',
        // 'address_type' => 'required',
        // 'selected_day' => 'required',
        'building' => 'required',
        'street' => 'required',
        'postal_code' => 'required',
        'delivery_slot_id' => 'required',


    ], [
        'area.required' => trans('validation.required', ['attribute' => 'area']),
        // 'address_type.required' => trans('validation.required', ['attribute' => 'address type ']),
        // 'selected_day.required' => trans('validation.required', ['attribute' => 'selected day  ']),
        'building.required' => trans('validation.required', ['attribute' => 'building ']),
        'street.required' => trans('validation.required', ['attribute' => 'street ']),
        'postal_code.required' => trans('validation.required', ['attribute' => 'postal_code']),
        'delivery_slot_id.required' => trans('validation.required', ['attribute' => 'delivery slot id  ']),

    ]);
    if ($validate->fails()) {
        $this->status_code = 201;
        $this->message = $validate->errors();
    } else {
         $data=[
          "area" => $request->input('area'),
          "user_id" => Auth::guard('api')->id(),
          "building" => $request->input('building'),
          "house_number" => $request->input('house_number'),
          "street" => $request->input('street'),
          "postal_code" => $request->input('postal_code'),
          "delivery_slot_id" => $request->input('delivery_slot_id'),
          "latitude" => $request->input('latitude'),
          "longitude" => $request->input('longitude'),
          "mobile_number" => $request->input('mobile_number'),
          "instructions" => $request->input('instructions'),

      ];

      if($request->address_type == '0'){

           $data['address_type'] = "Home";
         
      }elseif($request->address_type == '1'){

         $data['address_type'] = "Office";

      }else{

        $data['address_type'] = "Other";

      }

      if($request->monday == "1"){
        $data['monday'] = "1";

      }
      if($request->tuesday == "1"){
        $data['tuesday'] = "1";

      } if($request->wednesday == "1"){
        $data['wednesday'] = "1";

      } if($request->thursday == "1"){
        $data['thursday'] = "1";

      } if($request->friday == "1"){
        $data['friday'] = "1";

      } if($request->saturday == "1"){
        $data['saturday'] = "1";

      } if($request->sunday == "1"){
        $data['sunday'] = "1";

      }

        $insert = UserAddress::create($data);
       
        if($insert){
         $response = new \Lib\PopulateResponse($insert);
         $this->data = $response->apiResponse();
         $this->message = trans('messages.add_address');
        } else {
            $this->message = trans('messages.server_error');
            $this->status_code = 202;
        }
        $this->status = true;
    }
    return $this->populateResponse();
} 



public function editAddress(Request $request){
    $validate = Validator::make($request->all(), [
        'area' => 'required',
         'user_address_id' => 'required',
        // 'address_type' => 'required',
        'building' => 'required',
        'street' => 'required',
        'postal_code' => 'required',
        'delivery_slot_id' => 'required',


    ], [
        'area.required' => trans('validation.required', ['attribute' => 'area']),
        'user_address_id.required' => trans('validation.required', ['attribute' => 'user address id']),
        // 'address_type.required' => trans('validation.required', ['attribute' => 'address type ']),
        'building.required' => trans('validation.required', ['attribute' => 'building ']),
        'street.required' => trans('validation.required', ['attribute' => 'street ']),
        'postal_code.required' => trans('validation.required', ['attribute' => 'postal_code']),
        'delivery_slot_id.required' => trans('validation.required', ['attribute' => 'delivery slot id  ']),

    ]);
    if ($validate->fails()) {
        $this->status_code = 201;
        $this->message = $validate->errors();
    } else {
           $data=[
          "area" => $request->input('area'),
          "user_id" => Auth::guard('api')->id(),
          "building" => $request->input('building'),
          "house_number" => $request->input('house_number'),
          "street" => $request->input('street'),
          "postal_code" => $request->input('postal_code'),
          "delivery_slot_id" => $request->input('delivery_slot_id'),
          "latitude" => $request->input('latitude'),
          "longitude" => $request->input('longitude'),
          "mobile_number" => $request->input('mobile_number'),
          "instructions" => $request->input('instructions'),

      ];

      if($request->address_type == '0'){

           $data['address_type'] = "home";
         
      }elseif($request->address_type == '1'){

         $data['address_type'] = "office";

      }else{

        $data['address_type'] = "other";

      }

      if($request->monday == "1"){
         $data['monday'] = "1";
      }else{
        $data['monday'] = "0";
      }

      if($request->tuesday == "1"){
        $data['tuesday'] = "1";
      }else{
        $data['tuesday'] = "0";
      }

       if($request->wednesday == "1"){
        $data['wednesday'] = "1";
      } else{
        $data['wednesday'] = "0";
      }

      if($request->thursday == "1"){
        $data['thursday'] = "1";
      } else{
        $data['thursday'] = "0";
      }
      if($request->friday == "1"){
        $data['friday'] = "1";
      } else{
        $data['friday'] = "0";
      }

      if($request->saturday == "1"){
        $data['saturday'] = "1";
      } else{
        $data['saturday'] = "0";
      }

      if($request->sunday == "1"){
        $data['sunday'] = "1";
      }else{
        $data['sunday'] = "0";
      }

        $update = UserAddress::where('id',$request->user_address_id)->where('user_id',Auth::guard('api')->id())->update($data);
       
        if($update){
         $data = UserAddress::select('id as user_address_id' ,'user_address.*')->where('id',$request->user_address_id)->where('user_id',Auth::guard('api')->id())->get();
         $response = new \Lib\PopulateResponse($data);
         $this->data = $response->apiResponse();
         $this->message = trans('messages.update_address');
        } else {
            $this->message = trans('messages.server_error');
            $this->status_code = 202;
        }
        $this->status = true;
    }
    return $this->populateResponse();
} 


public function addressListing(Request $request) {
  
     $address_data = UserAddress::where('user_address.user_id', Auth::guard('api')->id())->where('user_address.status','active')
   ->select('user_address.id as address_id','user_address.*','delivery_slots.*' )
   ->join('delivery_slots', 'delivery_slots.id','=','user_address.delivery_slot_id')
   ->orderBy('user_address.id','Desc')
   ->limit(3)
   ->get();

   $data = $address_data;
   if($data){
       $this->status = true;
       $this->message = trans('messages.address_detail');
       $response = new \Lib\PopulateResponse($data);
       $this->data = $response->apiResponse();

      }else{

       $this->status = true;
       $data = [];                
       $this->message = trans('messages.address_notfound');
       $response = new \Lib\PopulateResponse($data);
       $this->data = $response->apiResponse();

      }
return $this->populateResponse();
}


public function giftCardListing(Request $request) {
  
    $gift_card = GiftCard::where('status', 'active')->orderBy('id', 'ASC')->get();
    $response = new \Lib\PopulateResponse($gift_card);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.card_listing');
    return $this->populateResponse();
}

public function giftCardOneShow(Request $request) {
  
    $gift_card_show = GiftCard::where(['id'=>$request->gift_card_id,'status'=>'active'])->orderBy('id', 'ASC')->first();
    if($gift_card_show->discount){
        $amount_discount = ($gift_card_show->discount*100)/100;
        $gift_card_show->buying_amount = $gift_card_show->gift_card_amount - $amount_discount;
    }elseif($gift_card_show->amount){
        $gift_card_show->buying_amount = $gift_card_show->gift_card_amount - $gift_card_show->amount;

    }
    $gift_card_show ->how_to_redeem = 'ggg';
    $response = new \Lib\PopulateResponse($gift_card_show);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.card_listing');
    return $this->populateResponse();
}

public function mySaveCardListing(Request $request) {
  
    $user_card = UserCard::where('user_id', Auth::guard('api')->id())->orderBy('id', 'ASC')->get();
    $response = new \Lib\PopulateResponse($user_card);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.save_card_listing');
    return $this->populateResponse();
}


public function addGiftCard(Request $request){
    $validate = Validator::make($request->all(), [
        'purchase_type' => 'required',
       
    ], [
        'purchase_type.required' => trans('validation.required', ['attribute' => 'purchase type ']),
      
    ]);
    // $validate->after(function ($validate) use ($request) {
    //     if ($request['country_code'] &&  $request['receiver_mobile']) {
    //         $getBooking = User::where('country_code', $request['country_code'])->where('mobile', $request['receiver_mobile'])->first();
    //         if (!$getBooking) {
    //             $this->error_code = 201;
    //             $validate->errors()->add('purchase_type', "This user is not registered");
    //         }
    //     }
    
    // });
    if ($validate->fails()) {
        $this->status_code = 201;
        $this->message = $validate->errors();
    } else {
     if($request->purchase_type == 'gifted'){
        // $identifyUserId = User::select('id','email','name','created_at')->where('country_code',$request->country_code)->where('mobile',$request->receiver_mobile)->first();
          $data=[
          "receiver_name" => $request->input('receiver_name'),
          "quantity" => $request->input('quantity'),
          "gift_card_id" => $request->input('gift_card_id'),
          "gift_from_user_id" => Auth::guard('api')->id(),
        //   "user_id" => $identifyUserId->id,
          "receiver_email" => $request->input('receiver_email'),
          "mobile_number" => $request->input('receiver_mobile'),
          "purchase_type" => 'gifted',
          'voucher_code' => substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 14),
          'voucher_pin' => mt_rand(100000, 999999),
          "purchase_amount" => $request->input('purchase_amount'),
          "occassion" => $request->input('occassion'),
          "message_for_receiver" => $request->input('message_for_receiver'),

      ];
      $insert = UserGiftCard::create($data);
      $email = [
        'to' => $request->input('receiver_email'),
        'name' => $request->input('receiver_name'),
        'voucher_code' => $insert->voucher_code,
         'voucher_pin' =>$insert->voucher_pin,
        'subject' => "You have received a gift from",
        'message' => "You have Received a gift card of Diet-on",
        'created_at' => date('d M Y H:i A', strtotime($insert->created_at))
    ];
    $this->send_mail($email);

    }else{
        $identifyUserId = User::select('id','email','name','created_at')->where('id',Auth::guard('api')->id())->first();
        $data=[
            "quantity" => $request->input('quantity'),
            "user_id" => Auth::guard('api')->id(),
            "gift_card_id" => $request->input('gift_card_id'),
            "purchase_type" => 'self',
            'voucher_code' => substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 14),
            'voucher_pin' => mt_rand(100000, 999999),
            "purchase_amount" => $request->input('purchase_amount'),
  
        ];
        $insert = UserGiftCard::create($data);
        $email = [
            'to' => $identifyUserId->email,
            'name' => $identifyUserId->name,
            'voucher_code' => $insert->voucher_code,
            'voucher_pin' =>$insert->voucher_pin,
            'subject' => "You have received a gift from",
            'message' => "You have Received a gift card of Diet-on",
            'created_at' => date('d M Y H:i A', strtotime($identifyUserId->created_at))
        ];
        $this->send_mail($email);

    }

        $insert = UserGiftCard::create($data);
        if($insert){
         $response = new \Lib\PopulateResponse($insert);
         $this->data = $response->apiResponse();
         $this->message = trans('messages.purchase_gift_card');
        } else {
            $this->message = trans('messages.server_error');
            $this->status_code = 202;
        }
        $this->status = true;
    }
    return $this->populateResponse();
} 

public function send_mail($email) {
    $data = ['name' => $email['name'], 'query' => $email['message'], 'voucher_code' => $email['voucher_code'], 'voucher_pin' => $email['voucher_pin']];
    Mail::send('admin.giftcard.email', $data, function ($message) use ($email) {
        $message->to($email['to'], $email['name'])->subject('Reply to: ' . $email['subject']);
        $message->from('praveen.techgropse@gmail.com', 'Diet-on ');
    });
}


public function availableCredit(Request $request) {
    $meal_des=[];
    $status=[];
     $available_credit = UserProfile::select('available_credit')->where('user_id', Auth::guard('api')->id())->first();
     $chech_status = SubscriptionPlan::join('subscriptions','subscription_plans.id','=','subscriptions.plan_id')
     ->select('subscription_plans.name','subscriptions.delivery_status',DB::raw('DATE_FORMAT(subscriptions.created_at,"%d %b %Y") as date'))
     ->where('subscriptions.delivery_status','!=','upcoming')
     ->where('subscriptions.delivery_status','!=','terminted')
     ->where('subscriptions.user_id', Auth::guard('api')->id())
     ->get();
    

     $data['available_credit'] = $available_credit;
     $data['timeline'] = $chech_status;
    $response = new \Lib\PopulateResponse($data);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.available_credit');
    return $this->populateResponse();
}


public function creditTransactionList(Request $request) {
  
    $credit_transaction = CreditTransaction::where('user_id', Auth::guard('api')->id())->orderBy('id', 'ASC')->get();
    $response = new \Lib\PopulateResponse($credit_transaction);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.credit_transaction');
    return $this->populateResponse();
}

public function basicInfo(Request $request){
    $validate = Validator::make($request->all(), [
        'height' => 'required',
        'weight' => 'required',
        'dob' => 'required',
        'age' => 'required',
        'gender'=>'required',
        'activity_scale'=>'required',

    ], [
        'height.required' => trans('validation.required', ['attribute' => 'height ']),
        'weight.required' => trans('validation.required', ['attribute' => 'weight']),
        'dob.required' => trans('validation.required', ['attribute' => 'dob ']),
        'age.required' => trans('validation.required', ['attribute' => 'age ']),
        'gender.required' => trans('validation.required', ['attribute' => 'gender']),
        'activity_scale.required' => trans('validation.required', ['attribute' => 'activity_scale'])

    ]);
    if ($validate->fails()) {
        $this->status_code = 201;
        $this->message = $validate->errors();
    } else {
        $step = '';
        if($request->step=='1'){
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
        }
        elseif($request->step=='2'){
            $user=UserProfile::updateOrCreate(
                ['user_id' =>  Auth::guard('api')->id()],
                [
                    'fitness_scale_id'=> $request->fitness_scale_id
                ]
            );

        }
        elseif($request->step == '3'){
            UserDislike::where('user_id',Auth::guard('api')->id())->delete();
             $add_item = json_decode($request->item_id,TRUE);
            if($add_item){
              foreach($add_item as $item_id){
               
                $user=UserDislike::create([
                    'user_id' =>  Auth::guard('api')->id(),
                    'item_id'=> $item_id
                ]);
                //   $user=UserDislike::updateOrCreate(
                //   ['user_id' =>  Auth::guard('api')->id(),
                //  'item_id'=> $item_id
                //   ],
                //   [
                //     'user_id' =>  Auth::guard('api')->id(),
                //     'item_id'=> $item_id
                //   ]
                //   );
                } 
           }
        }
        elseif($request->step == '4'){
            $user=UserProfile::updateOrCreate(
                ['user_id' =>  Auth::guard('api')->id()],
                [
                    'diet_plan_type_id'=> $request->diet_plan_type_id
                ]
            );


        }

        
        
        $this->status = true;
         $this->message = trans('messages.basic_info');
       
    }
    return $this->populateResponse();
}  

public function promoCodeListings(Request $request) {
 
    $promo_codes = PromoCode::join('promo_code_diet_plan','promo_codes.id','=','promo_code_diet_plan.promo_code_id')
    ->select('promo_codes.id','promo_codes.name','promo_codes.image','promo_codes.description','promo_codes.start_date','promo_codes.end_date','promo_codes.promo_code_ticket_id')->orderBy('id', 'ASC')
    ->where('promo_code_diet_plan.meal_plan_id', $request->meal_plan_id)
    ->where('promo_codes.status', 'active')
    ->get();

    $response = new \Lib\PopulateResponse($promo_codes);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.promo_code');
    return $this->populateResponse();
}

public function onboardingScreen(Request $request) {
  
    $onboarding_screen = OnboardingScreen::select('*')->get();
    $response = new \Lib\PopulateResponse($onboarding_screen);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.onboarding_screen');
    return $this->populateResponse();
}

public function basicInfoDetail(Request $request) {
    $basicInfo_detail = UserProfile::select('initial_body_weight','height','dob','age','gender','activity_scale')->where('user_id',Auth::guard('api')->id())->first();
    $response = new \Lib\PopulateResponse($basicInfo_detail);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.onboarding_screen');
    return $this->populateResponse();
}



public function insertImage(Request $request) {

    if ($request->image) {
        $image = $request->image;
        $filename = $image->getClientOriginalName();
        $filename = str_replace(" ", "", $filename);
        $imageName = time() . '.' . $filename;
        $return = $image->move(
                base_path() . '/public/uploads/fitness_goal/', $imageName);
        $url = url('/uploads/fitness_goal/');
        $addUser['image'] = $url . '/' . $imageName;
    }
    // if ($request->image_ar) {
    //     $image = $request->image_ar;
    //     $filename = $image->getClientOriginalName();
    //     $filename = str_replace(" ", "", $filename);
    //     $imageName = time() . '.' . $filename;
    //     $return = $image->move(
    //             base_path() . '/public/uploads/fitness_goal/', $imageName);
    //     $url = url('/uploads/fitness_goal/');
    //     $addUser['image_ar'] = $url . '/' . $imageName;
    // }
//           $addUser['title'] = 'Get the exact nutrition ';
//           $addUser['title_ar'] = 'منتجات الألبان';

    if($addUser){
       $data = HomeScreenBanner::create($addUser);
         $data =  HomeScreenBanner::where('id','1')->get();
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->message = trans('messages.update_profile_success');
    }else{
        $this->message = trans('messages.update_profile_success');
    }
    $this->status = true;

    return $this->populateResponse();
}

public function cities_listing(Request $request) {
  
    $data['city'] = Cities::select('id','city')->Where('city','<>','')->orderBy('id', 'ASC')->first();
    $data['upcoming_city'] = Cities::select('upcoming_cities')->orderBy('id', 'ASC')->get();
    $response = new \Lib\PopulateResponse($data);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.promo_code');
    return $this->populateResponse();
}

public function select_delivery_location(Request $request) {
    $insert=SelectDeliveryLocation::updateOrCreate(
        ['user_id' =>  Auth::guard('api')->id()],
        [
            'user_id' => Auth::guard('api')->id(),
            'city_id' => $request->city_id,
            'selected_or_not' => $request->selected_or_not,
        ]
    );
      
    if($insert){
    $response = new \Lib\PopulateResponse($insert);
    $this->data = $response->apiResponse();
    $this->message = trans('messages.user_delivery_location');
    }else {
        $this->message = trans('messages.server_error');
        $this->status_code = 202;
    }
    $this->status = true;
    return $this->populateResponse();
}

public function resume_meal_plan(Request $request) {

    $data =Subscription::updateOrCreate(
        ['user_id' =>  Auth::guard('api')->id(),
        'id' => $request->subscription_id,
         ],
        [
            'plan_id'=> $request->plan_id,
            'start_date'=> $request->starting_date,
            'is_weekend'=> $request->is_weekend,
            'delivery_status'=> 'active',

        ]
    );
    if($data){
        UserProfile::updateOrCreate(
            ['user_id' =>  Auth::guard('api')->id(),
            'subscription_id' => $request->subscription_id,
            ],
            [
                'diet_plan_type_id'=> $request->diet_plan_type_id,

            ]
        );

    }
   
      
    if($data){
    $response = new \Lib\PopulateResponse($data);
    $this->data = $response->apiResponse();
    $this->message = trans('messages.plan_resume');
    }else {
        $this->message = trans('messages.server_error');
        $this->status_code = 202;
    }
    $this->status = true;
    return $this->populateResponse();
}

public function meal_plan_listing(Request $request){
    $data['meal_plan'] =SubscriptionPlan::select('id','name')->where('diet_plan_type_id',$request->diet_plan_type_id)->get();
    $available_credit = UserProfile::select('available_credit')->where('user_id',Auth::guard('api')->id())->first();
    if($available_credit){
        $data['description'] = "You have $available_credit->available_credit credit valid for 3 Days";
    }
  
   $response = new \Lib\PopulateResponse($data);
   $this->status = true;
   $this->data = $response->apiResponse();
   $this->message = trans('plan_messages.diet_plan_detail');
   return $this->populateResponse();
}

public function sample_daily_meals(Request $request) {
    $dates = $request->date;
   
       $category = MealSchedules::select('id','name')
       ->get()
        ->each(function($category) use($dates){
                   $meals = $category->meals=Meal::
                //    join('meal_ratings','meals.id','=','meal_ratings.meal_id' )
                   join('meal_group_schedule','meals.id','=','meal_group_schedule.meal_id')
                //    ->where(['meal_ratings.user_id',Auth::guard('api')->id()])
                   ->select('meals.*')
                    ->where('meal_group_schedule.meal_schedule_id',$category->id)
                   ->whereDate('meals.created_at','=', date('Y-m-d', strtotime($dates)))
                //    ->where(['meals.meal_schedule_id'=>$category->id])
                    
                   ->get()->each(function($meals) {
                    $meals->ingredient=MealIngredientList::select('ingredients')->where(['meal_id'=>$meals->id])->get();
                    $meals->rating = MealRating::select(DB::raw('avg(rating) as avg_rating'))
                    ->where('meal_id', $meals->id)
                    ->groupBy('meal_id')
                   ->first();
                   $meals->ratingcount = MealRating::where('meal_id', $meals->id)
                   ->groupBy('meal_id')
                  ->count();
            })->toArray();
           })->toArray();
   
   $data = $category;
   if($data){
    $response = new \Lib\PopulateResponse($data);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.sample_daily_meal');


      }else{
       $data =[];
        $response = new \Lib\PopulateResponse($data);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('messages.sample_daily_meal_not');

      }
return $this->populateResponse();
}


public function balance_sample_daily_meals(Request $request) {
    $dates = $request->date;

                   $meals =Meal::
                //    join('meal_ratings','meals.id','=','meal_ratings.meal_id' )
                   join('meal_group_schedule','meals.id','=','meal_group_schedule.meal_id')
                //    ->where(['meal_ratings.user_id',Auth::guard('api')->id()])
                   ->select('meals.*')
                   ->whereDate('meals.created_at','=', date('Y-m-d', strtotime($dates)))
                //    ->where(['meals.meal_schedule_id'=>$category->id])
                    
                   ->get()->each(function($meals) {
                    $meals->ingredient=MealIngredientList::select('ingredients')->where(['meal_id'=>$meals->id])->get();
                    $meals->rating = MealRating::select(DB::raw('avg(rating) as avg_rating'))
                    ->where('meal_id', $meals->id)
                    ->groupBy('meal_id')
                   ->first();
                   $meals->ratingcount = MealRating::where('meal_id', $meals->id)
                   ->groupBy('meal_id')
                  ->count();
            })->toArray();
   
   $data = $meals;
   if($data){
    $response = new \Lib\PopulateResponse($data);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.sample_daily_meal');


      }else{
       $data =[];
        $response = new \Lib\PopulateResponse($data);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = trans('messages.sample_daily_meal_not');

      }
return $this->populateResponse();
}

// public function select_start_day_meal(Request $request) {
//     $dates = $request->date;
//     $plan_id = $request->plan_id;
//     $meals = Meal::join('subscription_meal_plan_variant_default_meal','meals.id','subscription_meal_plan_variant_default_meal.item_id')
//                ->select('meals.*')
//                ->where('subscription_meal_plan_variant_default_meal.meal_plan_id','=', $plan_id)
//                ->whereDate('meals.created_at','=', date('Y-m-d', strtotime($dates)))
//                ->get();

   
//    $data = $meals;
//    if($data){
//     $response = new \Lib\PopulateResponse($data);
//     $this->status = true;
//     $this->data = $response->apiResponse();
//     $this->message = trans('messages.sample_daily_meal');


//       }else{
//        $data =[];
//         $response = new \Lib\PopulateResponse($data);
//         $this->status = true;
//         $this->data = $response->apiResponse();
//         $this->message = trans('messages.sample_daily_meal_not');

//       }
// return $this->populateResponse();
// }


public function updateBasicInfo(Request $request){
 
    $user=UserProfile::where('user_id',Auth::guard('api')->id())->first();
  $dietPlan=DietPlanType::where('id',$user->diet_plan_type_id)->first();

  if($user->gender == 'female'){
  
        ///// Calculation /////
      $forWomen = ((10*$user->initial_body_weight)+(6.253*$user->height)-(5*$user->age)-161);
      if($user->activity_scale == '1'){
          $total_calorie = $forWomen*1.2;
      }elseif($user->activity_scale == '2'){
          $total_calorie = $forWomen*1.375;
      }else{
          $total_calorie = $forWomen*1.55; 
      }

      if($user->fitness_scale_id == '1'){
          $total_recommended_Kcal = $total_calorie-500;
      }else{
          $total_recommended_Kcal = $total_calorie ;
      }
     
        ///// Calculation /////

  }else{

        ///// Calculation /////
      $forMen = ((10*$user->initial_body_weight)+(6.253*$user->height)-(5*$user->age)+5);
      if($user->activity_scale == '1'){
          $total_calorie = $forMen*1.2;
      }elseif($user->activity_scale == '2'){
          $total_calorie = $forMen*1.375;
      }else{
          $total_calorie = $forMen*1.55; 
      }

      if($user->fitness_scale_id == '1'){
          $total_recommended_Kcal = $total_calorie-500;
      }else{
          $total_recommended_Kcal = $total_calorie ;
      }
        ///// Calculation /////

  }
   //return $total_recommended_Kcal;
   if(round($total_recommended_Kcal<2000,0)){
       $recommended_result=CalorieRecommend::where('min_range','<=',$total_recommended_Kcal)->where('max_range','>=',$total_recommended_Kcal)->first();
      $update=[

          'user_id'=>Auth::guard('api')->id(),
          'recommended_result_id'=>$recommended_result->id,
        
         
      ];
   }else{
       $recommended_result['recommended'] = '2000';
      $update=[

          'user_id'=>Auth::guard('api')->id(),
          'recommended_result_id'=>'5',
         
      ];

   }
  
  UserCaloriTarget::updateOrCreate(['user_id'=>Auth::guard('api')->id()],$update);

  $response = new \Lib\PopulateResponse($total_recommended_Kcal);
  $this->status = true;
   $this->message = trans('messages.basic_info');
   return $this->populateResponse();
}


public function delivery_slot(Request $request) {
  
    $data['delivery_slot'] = DeliverySlot::select('*')->Where('status','active')->orderBy('id', 'ASC')->get();
    $response = new \Lib\PopulateResponse($data);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.delivery_slot');
    return $this->populateResponse();
}

public function social_link(Request $request) {
  
    $data['socialLink'] = SocialLink::select('*')->orderBy('id', 'ASC')->get();
    $response = new \Lib\PopulateResponse($data);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.social_link');
    return $this->populateResponse();
}

public function refer_and_earn(Request $request) {

    $terms = ReferEarnContent::select('content')->first();
    $refer = ReferAndEarn::select('*')->where('status','active')->first();
    if($refer){
        $total_get = ($refer->register_referee+$refer->plan_purchase_referee);
    }
    $data['refer'] = $refer;
    $data['total_get'] = $total_get;
    $data['terms'] = $terms;
    $response = new \Lib\PopulateResponse($data);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.refer');
    return $this->populateResponse();
}


public function paymentAvailableCredit(Request $request) {
    $meal_des=[];
    $status=[];
     $available_credit = UserProfile::select('available_credit')->where('user_id', Auth::guard('api')->id())->first();
     $available_referral = UserProfile::select('available_referral')->where('user_id', Auth::guard('api')->id())->first();

    // $referral_plan_purchase = ReferAndEarnUsed::join('refer_and_earn','refer_and_earn_used.refer_and_earn_id','=','refer_and_earn.id')
    //  ->select('refer_and_earn.*')
    //  ->where('refer_and_earn.status','active')
    //  ->where('refer_and_earn_used.status','active')
    //  ->where('refer_and_earn_used.referral_id',Auth::guard('api')->id())
    //  ->where('refer_and_earn_used.used_for','plan_purchase')
    //  ->get();
    //  $totalCostPlan = 0; 
    //  foreach($referral_plan_purchase as $cost){
    //     $totalCostPlan += $cost->plan_purchase_referral;
    // }
    // $referral_registration = ReferAndEarnUsed::join('refer_and_earn','refer_and_earn_used.refer_and_earn_id','=','refer_and_earn.id')
    //  ->select('refer_and_earn.*')
    //  ->where('refer_and_earn.status','active')
    //  ->where('refer_and_earn_used.status','active')
    //  ->where('refer_and_earn_used.referral_id',Auth::guard('api')->id())
    //  ->where('refer_and_earn_used.used_for','registration')
    //  ->get();
    //  $totalCostRegistration = 0; 
    //  foreach($referral_registration as $cost){
    //     $totalCostRegistration += $cost->register_referral;
    // }
//     $referee_plan_purchase = ReferAndEarnUsed::join('refer_and_earn','refer_and_earn_used.refer_and_earn_id','=','refer_and_earn.id')
//     ->select('refer_and_earn.*')
//     ->where('refer_and_earn.status','active')
//     ->where('refer_and_earn_used.status','active')
//     ->where('refer_and_earn_used.referee_id',Auth::guard('api')->id())
//     ->where('refer_and_earn_used.used_for','plan_purchase')
//     ->get();
//     $totalCostPlanReferee = 0; 
//     foreach($referee_plan_purchase as $cost){
//        $totalCostPlanReferee += $cost->plan_purchase_referee;
//    }
//    $referee_registration = ReferAndEarnUsed::join('refer_and_earn','refer_and_earn_used.refer_and_earn_id','=','refer_and_earn.id')
//    ->select('refer_and_earn.*')
//    ->where('refer_and_earn.status','active')
//    ->where('refer_and_earn_used.status','active')
//    ->where('refer_and_earn_used.referee_id',Auth::guard('api')->id())
//    ->where('refer_and_earn_used.used_for','registration')
//    ->get();
//    $totalCostRegisterReferee = 0; 
//    foreach($referee_registration as $cost){
//       $totalCostRegisterReferee += $cost->register_referee;
//   }
    // $available_referrals = $totalCostPlan+$totalCostRegistration;
    // $available_referees = $totalCostPlanReferee+$totalCostRegisterReferee;
    // $available_referral = $available_referrals+$available_referees;
    

     $data['available_credit'] = $available_credit;
     $data['available_referral'] = $available_referral;
    $response = new \Lib\PopulateResponse($data);
    $this->status = true;
    $this->data = $response->apiResponse();
    $this->message = trans('messages.available_credit');
    return $this->populateResponse();
}

}
