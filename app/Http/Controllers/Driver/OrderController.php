<?php

namespace App\Http\Controllers\Driver;

use App\Models\Admin;
use App\Models\FleetDriver;
use App\Models\Order;
use App\Models\StaffMembers;
use App\Models\User;
use App\Models\OrderDeliverByDriver;
use Auth;
use App\Models\Otp;
use DB;
use Validator;
use Response;
use URL;
use Route;
use Session;
use Carbon\Carbon;
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
   $currentDate = date('Y-m-d');
   $datess = Carbon::createFromFormat('Y-m-d',$currentDate);
    $day = strtolower($datess->format('l'));
        // if($request->type==1){
        //     $order=Order::find($request->order_id);
        //     $order->is_deliver=1;
        //     $order->status='delivered';
        //     $order->save();
        // }elseif($request->type==2){
        //     $order=Order::find($request->order_id);
        //     $order->is_deliver=2;
        //     $order->deliver_reason=$request->check1;
        //     $order->deliver_note=$request->other_note;
        //     $order->save();
        // }

        if($request->type==1){
             $order=Order::find($request->order_id);
            OrderDeliverByDriver::create([
                'user_id' => $order->user_id,
                'driver_id' => Auth::guard('staff_members')->id(),
                'address_id' =>  $request->address_id,
                'delivery_slot_id' => $request->time_slot_id,
                'order_id' =>$order->id,
                'plan_id' => $order->plan_id,
                'variant_id' =>  $order->variant_id,
                'cancel_or_delivery_date' => $currentDate,
                'cancel_or_delivery_day' =>$day,
                'is_deliver' => 'yes',
                'status' =>'delivered',
            ]);

            $title = 'delivered successfully';
            $body = 'Your Package is delivered successfully';
             if(!empty($request->order_id)){
                $this->sendNotification($order->user_id ,$title, $body);
            }
          }elseif($request->type==2){
            $order=Order::find($request->order_id);
            OrderDeliverByDriver::create([
                'user_id' => $order->user_id,
                'driver_id' => Auth::guard('staff_members')->id(),
                'address_id' =>  $request->address_id,
                'delivery_slot_id' => $request->time_slot_id,
                'order_id' =>$order->id,
                'plan_id' => $order->plan_id,
                'variant_id' =>  $order->variant_id,
                'cancel_or_delivery_date' => $currentDate,
                'cancel_or_delivery_day' =>$day,
                'is_deliver' => 'no',
                'cancel_reason' => $request->check1,
                'delivery_reason' => $request->other_note,
                'status' =>'cancelled',

            ]);
            $title = 'delivery failure';
            $body = 'We are unable to reach you for your package delivery, reach out for support for more information';
             if(!empty($request->order_id)){
                $this->sendNotification($order->user_id, $title, $body);
            }
        }
        

        return redirect()->route('dashboard');
    }

    public function login()
    {
        return view('driver.login');
    }

    public function sendNotification($user_id, $title, $body)
    {
         $firebaseToken = User::where('id',$user_id)->whereNotNull('device_token')->pluck('device_token')->all();
         
            
        $SERVER_API_KEY = 'AAAAbPtHfNY:APA91bGAvFfWkVSYIHvmBtptkAN9G3df3zLGyTiSZbO3nXgmdJWzadTOuS0dM2rH2MUG4-0WWpUYvr9ZwcTvAtBJzcAg1c56VYBFapL-QWdkpb0rVSrufA7yD4KgFBkeR72P5KbNzXsU';
    
        $data = [
            "to" => $firebaseToken,
            // "registration_ids" => $firebaseToken,
            // "to" => "fiwfGvvfQTCmQY2hVHj9Yh:APA91bEURwPi2BmznUprvblhnPCMpd7C3h0sBH5ye22LLE0PoPrNYA5YopO4DEwgLZfFRFROnVfhkDHiAiFLz8nbLYezMEZnSAkijFmUUl_2PxLo5PVfbcWsuzBD26I4JA436OruQo1-",
            "notification" => [
                "title" => $title,
                "body" => $body,  
            ]
        ];
        //  dd($data);
        // die;
        $dataString = json_encode($data);
      
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
      
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                 
        $response = curl_exec($ch);
    // dd($response);
    // die;
    //     return back()->with('success', 'Notification send successfully.');
    }
}
