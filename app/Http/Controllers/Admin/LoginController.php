<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Auth;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

            if (empty($user)) {
//                 dd($user);
                $validator->errors()->add('email', 'Your account does not exist');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
             if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
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
