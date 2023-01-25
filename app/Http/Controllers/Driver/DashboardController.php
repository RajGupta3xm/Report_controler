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


class DashboardController extends Controller {

    public function index()
    {
        return view('driver.my-delivery');
    }

    public function profileIndex()
    {
        return view('driver.profile');
    }

}
