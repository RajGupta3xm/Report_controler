<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Auth;
use App\Models\Otp;
use DB;
use Validator;
use Response;
use URL;
use Route;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;


class LoginController extends Controller {

    protected $guard = "admin";
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
    }

    public function login(Request $request) {
//        if ($request->session()->exists('admin_logged_in')) {
//            return redirect()->intended('admin/home');
//        }
        if (\Auth::guard('admin')->check()) {
            return redirect()->intended('admin/dashboard');
        }

        $data['title'] = 'Admin Login';
        return view('admin.login')->with($data);
    }

    public function error() {
        return view('error.error');
    }

    public function resendotp(Request $request){
        //return $id = $request->all();
        $Admin = Admin::where('id',$request->admin_id)->first();
        //return $Admin['id'];
         $otpAdmin['user_id'] = $Admin['id'];
          $otpAdmin['otp'] =  '1234';
    
         $otp = Otp::create($otpAdmin);
    
    }

    public function forgot() {
        return view('admin.forgot-password');
    }

    public function forgotten(Request $request) {
        
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
                ], [
            'email.required' => 'Please enter email address.',
            'email.email' => 'Please enter valid email address.',
       ]);

        $validator->after(function ($validator) use (&$Admin, $request) {
            $Admin = Admin::where('email', $request->email)->first();

          if (empty($Admin)) {
                $validator->errors()->add('email', 'Your Account does not exist');
           } 
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $Admin = Admin::where('email', $request->email)->first();
            $otpAdmin['user_id'] = $Admin['id'];
            $otpAdmin['otp'] =  '1234';

            $otp = Otp::create($otpAdmin);
    
            return redirect()->route('otp', ['id' => base64_encode($otpAdmin['user_id'])]);
         
            
        }
        
    }

    public function showotp(Request $request) {
        
        $id = base64_decode($request->id);
        $adminOtp = Admin::where('id', $id)->first();
        $otp = Otp::where(['user_id' => $adminOtp->id])->latest()->first();
        $adminOtp['otp'] = $otp->otp;
        //return $adminOtp;
       
        return view('admin.otp-verification',$adminOtp);
    }

    public function checkOTP(Request $request){
        // return $a = $request->all();
       
        $validator = \Validator::make($request->all(), [
         'otp1' => 'required',
         'otp2' => 'required',
         'otp3' => 'required',
         'otp4' => 'required',
             ], [
         'otp1.required' => 'Please enter otp',
         'otp2.required' => 'Please enter otp',
         'otp3.required' => 'Please enter otp',
         'otp4.required' => 'Please enter otp',
       ]);
    
       $validator->after(function ($validator) use ($request) {
        $admin_given_otp=$request->otp1.$request->otp2.$request->otp3.$request->otp4;
        if($admin_given_otp){
            $checkOTP = Otp::where([
                'user_id' => $request['admin_id'],
                 // 'otp' => $request['otp'],
             ])->latest()->first();
         if ($checkOTP['otp'] != $admin_given_otp) {
             
             $validator->errors()->add('otp', 'otp is not correct please provide correct otp');
         }
        }
         // dd('a');
     });
    
     if ($validator->fails()) {
         // dd($validator->errors());
         return redirect()->back()->withErrors($validator)->withInput();
     } else {
    
         $checkAdmin = Admin::find($request['admin_id']);
         return redirect()->route('resetPassword', ['id' => base64_encode($checkAdmin['id'])]);
     }
    
     }

     public function resetPassword(Request $request) {
  
        $id = base64_decode($request->id);
        $AdminPswd = Admin::where('id', $id)->first();
       
        return view('admin.reset', $AdminPswd);
    }


    public function ConfirmPassword(Request $request){
        //return $request->all();
        $validator = \Validator::make($request->all(), [
            'password' => 'required|min:8|max:15',
            'confirm_password' => 'required',
                ], [
            'password.required' => 'please enter new password',
            'password.min' => 'password must be between 8 to 15 characters',
            'password.max' => 'password must be between 8 to 15 characters',
            'confirm_password.required' => 'please enter confirm password',
       ]);
    
       $validator->after(function ($validator) use ($request) {
        if (($request['password'] != null) && ($request['confirm_password'] != null)) {
            if ($request['password'] != $request['confirm_password']) {
                $validator->errors()->add('confirm_password', 'new password and confirm password must be same');
            }
           }   
          });
    
          if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
             //dd($request->admin_id);
            $admin = Admin::find($request->admin_id);
            $input['password'] = bcrypt($request->password);
            Admin::where('id', '=', $request->admin_id)->update($input);
            return redirect()->route('login')->with('block', 'password updated successfully');
        }   
    }

    public function authenticate(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'email' => 'required|email',
                    'password' => 'required'
                        ], [
                    'email.required' => 'Please enter email address.',
                    'email.email' => 'Please enter valid email address.',
                    'password.required' => 'Please enter password.'
        ]);
        $validator->after(function($validator) use(&$user, $request) {
            $user = Admin::where('email', $request->email)->first();
            // dd($user);
            // die;
            if (empty($user)) {
              
                $validator->errors()->add('email', 'Your account does not exist');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
             if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Admin::where('email', $request->email)->first();
                 Session::put('admin_logged_in', $user);
//                 dd('as');
                 return redirect()->intended('admin/dashboard');
             } else {
//                 dd('at');
                 $validator->errors()->add('password', 'Invalid credentials!');
                 return redirect()->back()->withErrors($validator)->withInput();
             }
//            $admin = Admin::where(['email' => $request->email, 'password' => md5($request->password)])->first();
//            if ($admin) {
//
//                Session::put('admin_logged_in', $user);
//                return redirect()->intended('admin/home');
//            } else {
//                $validator->errors()->add('password', 'Invalid credentials!');
//                return redirect()->back()->withErrors($validator)->withInput();
//            }
        }
    }


}
