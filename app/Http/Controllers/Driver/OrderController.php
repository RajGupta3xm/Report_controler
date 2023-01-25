<?php

namespace App\Http\Controllers\Driver;

use App\Models\Admin;
use App\Models\FleetDriver;
use App\Models\Order;
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


class OrderController extends Controller {

    public function index()
    {

        return view('driver.orderdetails');
    }

    public function orderDetails($id)
    {
        $order=FleetDriver::where('order_id',$id)->first();
      
        return view('driver.orderdetails',compact('order'));
    }

    public function navigation($id)
    {
        $order=FleetDriver::where('order_id',$id)->first();

        return view('driver.navigation',compact('order'));
    }

    public function orderCancel($id)
    {
        $order=FleetDriver::where('order_id',$id)->first();
        return view('driver.cancel-delivery',compact('order'));
    }

    public function submitCancelOrder(Request $request){

        if($request->type==1){
            $order=Order::find($request->order_id);
            $order->is_deliver=1;
            $order->status='delivered';
            $order->save();
        }elseif($request->type==2){
            $order=Order::find($request->order_id);
            $order->is_deliver=2;
            $order->deliver_reason=$request->check1;
            $order->deliver_note=$request->other_note;
            $order->save();
        }


        return redirect()->route('dashboard');
    }

    public function login()
    {
        return view('driver.login');
    }
}
