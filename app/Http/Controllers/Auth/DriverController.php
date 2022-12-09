<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;
use Illuminate\Auth\AuthenticationException;
use App\Models\User;
use App\Models\Otp;
use App\Models\Content;
use App\Models\StaffMembers;
use Carbon\Carbon;
use DateTime;
use File;
use Storage;


class DriverController extends Controller
{
    protected $content;

    public function __construct(Content $content)
    {
        $this->content = $content;

        DB::enableQueryLog();
    }


    public function login(request $request) {
        $validate = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'email is required field',
            'password.required' => 'password is required field',
        ]);

        $validate->after(function ($validate) use ($request) {
            $this->status_code = 201;
              $user = StaffMembers::where(['email' => $request->email])->get()->first();
             
            if ($user) {
                // $credentials = request(['email', 'password']);
                // if(!Auth::attempt(['email' => request('email'), 'password' => request('password')])){
                    if (!auth()->guard('staff_members')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
                // if (!Auth::attempt($credentials)) {
                    $this->message = 'Invalid Credentials';
                    $this->status_code = 202;
                    $validate->errors()->add('password', $this->message);
                } else {
                    if ($user->status == 'blocked') {
                        $this->message = 'This account is blocked by Admin';
                        $this->status_code = 204;
                        $validate->errors()->add('email', $this->message);
                    }
                }
            } else {
                $this->message = 'This email is not registered';
                $this->status_code = 201;
                $validate->errors()->add('country code', $this->message);
                $validate->errors()->add('mobile', $this->message);
            }
        });

        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
            $this->status = true;
            $user = StaffMembers::where(['email' => $request->email])->get()->first();
              // otp verification incomplete send user to verification screen
                if($user['status'] == 'inactive' || 'active'){

                    $otpUser['otp']            =    1234;
                    $otpUser['user_id']         =   $user['id'];
                    $otp                        =   Otp::create($otpUser);
    
                }else{
    
                    $this->message = "User Otp cannot be send, some error occured.";
                    $this->error_code = 201;
                }
               
                $this->status_code = 200;
                $updateArr = array();
                if ($request->device_token != "" && $request->device_type != "") {
                    $updateArr['device_token'] = $request->device_token;
                    $updateArr['device_type'] = $request->device_type ? $request->device_type : 0;
                }
                if ($updateArr) {
                    StaffMembers::where('id', $user->id)->update($updateArr);
                }
                $user->user_id = $user->id;
                $user = $this->getToken($user);
                $this->message = 'Login Successful';
                $data = $user;
            

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
        unset($user['tokens']);
        if ($user->image == null) {
            $user->image = url('assets/images/dummy2.jpg');
        }
        return $user;
    }

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
        }else{
            $this->status_code = 202;
            $this->message =  trans('messages.server_error');
        }
        return $this->populateResponse(); 
    }


    public function forgotPassword(request $request) {
        $validate = Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile' => 'required'
        ], [
            'country_code.required' => 'country code is required field',
            'mobile.required' => 'mobile is required field'
        ]);

        $validate->after(function ($validate) use ($request) {
            $this->status_code = 201;
            $user = User::where(['country_code' => $request->country_code, 'mobile' => $request->mobile])->get()->first();
            if ($user) {
                if ($user->status == 2) {
                    $this->message = 'This account is blocked by Admin';
                    $this->status_code = 204;
                    $validate->errors()->add('country_code', $this->message);
                    $validate->errors()->add('mobile', $this->message);
                }
            } else {
                $this->message = 'This mobile is not registered';
                $this->status_code = 201;
                $validate->errors()->add('country code', $this->message);
                $validate->errors()->add('mobile', $this->message);
            }
        });

        if ($validate->fails()) {
            $this->message = $validate->errors();
        } else {
            $this->status_code = 200;
            $this->status = true;
            $user = User::where(['country_code' => $request->country_code, 'mobile' => $request->mobile])->get()->first();
            Otp::where('user_id', $user->id)->delete();
            $createOtp = [
                'user_id' => $user->id,
                'otp' => '1234'
                // 'otp' => generateRandomOtp()
            ];
            $data['user_id'] = $user->id;
            $data['otp'] = $createOtp['otp'];
            $otp = Otp::create($createOtp);
            $this->message = 'verify mobile number to proceed. OTP sent on registered mobile number.';

            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
        }
        return $this->populateResponse();
    }

    public function updatePassword(Request $request) {
        $validatedData = Validator::make($request->all(), [
            
            'new_password' => 'required|min:8',
           
        ], [
            // 'current_password.required' => trans('validation.required', ['attribute' => 'current password']),
            'new_password.required' => trans('validation.required', ['attribute' => 'new password']),
            'new_password.min' => trans('validation.min', ['attribute' => 'new password']),
            // 'confirm_password.required' => trans('validation.required', ['attribute' => 'confirm password']),
            // 'confirm_password.min' => trans('validation.min', ['attribute' => 'confirm password']),
            // 'confirm_password.same' => trans('validation.same', ['attribute' => 'confirm password'])
        ]);
        $validatedData->after(function ($validatedData) use ($request) {
            // if ($request->current_password) {
            //     $user = User::where(['id' => Auth::guard('api')->id()])->first();
            //     if (!Hash::check($request->current_password, $user->password)) {
            //         $validatedData->errors()->add('current_password', 'incorrect current password');
            //     }
            // }
        });
        if ($validatedData->fails()) {
            $this->status_code = 201;
            $this->message = $validatedData->errors();
        } else {
            $this->status = true;
            $input['password']  = bcrypt($request->new_password);
            // dd($request->user_id);
            $data = User::where('id','=',$request->user_id)->update($input);
            if ($data) {
                $this->message = 'Password changed successully';
            } else {
                $this->message = 'Some error occured';
                $this->status_code = 201;
            }
        }
        return $this->populateResponse();
    }


  



}

