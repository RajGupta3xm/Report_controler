<?php

namespace App\Http\Controllers\Driver;

use App\Models\Admin;
use App\Models\StaffMembers;
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


    public function index()
    {
        return view('driver.splash');
    }

    public function login()
    {
        if (\Auth::guard('staff_members')->check()) {
            return redirect()->intended('driver/dashboard');
        }
        return view('driver.login');
    }

    public function getLogout(request $request) {
        Auth::guard('staff_members')->logout();


        return redirect('driver/login');
    }

    public function postLogin(Request $request)
    {
        $admin = Admin::where(['email' => $request->email_address])->where('type', '=', '1')->first();

        if (isset($admin)) {

            $user = StaffMembers::where(['admin_id' => $admin->id])->first()->getAuthIdentifierName();

            if (!auth()->guard('staff_members')->attempt(['email' => $request->input('email_address'), 'password' => $request->input('password')])) {
                return \redirect()->back()->with('danger', 'Driver not found');
            } else {

                return redirect('driver/dashboard');
            }
        } else {

            return \redirect()->back()->with('danger', 'Driver not found');
        }
    }

    public function smsAPI(){
        $url =
            "https://mshastra.com/sendurl.aspx?user=xxxxxxxx&pwd=xxxxxx&senderid=SMSAlert&mobileno=mobileno,mobileno&msgtext=Hello&priority=High&CountryCode=ALL";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl_scraped_page = curl_exec($ch);
        dd($curl_scraped_page);
        curl_close($ch);
        echo $curl_scraped_page;
    }

    public function storeLocation(Request $request){

        Admin::where('id',auth()->guard('staff_members')->user()->admin_id)->update([
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude
        ]);
    }


//    public function forgotpassword(){
//        return view('driver.forgotpassword');
//    }
//    public function sendotp(){
//        return view('driver.sendotp');
//    }
//    public function resetpassword(){
//        return view('driver.reset-password');
//    }
//    public function orderDetails(){
//        return view('driver.orderdetails');
//    }
//    public function scanorders(){
//        return view('driver.scan-order');
//    }
//    public function myDelivery(){
//        return view('driver.my-delivery');
//    }
//    public function scanFail(){
//        return view('driver.order-fail');
//    }
//    public function scanSuccess(){
//        return view('driver.order-success');
//    }

}
