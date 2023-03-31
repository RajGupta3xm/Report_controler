<?php

namespace App\Http\Controllers\Admin;

use App\Models\BrodcastNotification;
use App\Models\MealPlan;
use App\Models\MealPlanGroup;
use App\Models\MealPlanVariant;
use App\Models\MealVariantDefaultMeal;
use App\Models\PopUpNotification;
use App\Models\Notification;
use App\Models\Subscription;
use Auth;
use Carbon\CarbonPeriod;
use DB;
use Response;
use Session;
use Mail;
//use App\Http\Requests\UsersRequest as StoreRequest;
//use App\Http\Requests\UsersRequest as UpdateRequest;
//use App\Http\Controllers\CrudOverrideController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserDislike;
use App\Models\DislikeItem;
use App\Models\DietPlanType;
use App\Models\MealRating;
use App\Models\WeekDays;
use App\Models\MealWeekDay;
use App\Models\MealDepartment;
use App\Models\MealDietPlan;
use App\Models\EmailNotification;
use App\Models\MealGroupSchedule;
use App\Models\MealMacroNutrients;
use App\Models\MealIngredientList;
use App\Models\MealSchedules;
use App\Models\MealItemOrganization;
use App\Models\Meal;
use App\Models\UserCaloriTarget;
use App\Models\StaffGroup;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class NotificationController extends Controller {

    private $URI_PLACEHOLDER;
    private $jsondata;
    private $redirect;
    protected $message;
    protected $status;
    private $prefix;

    public function __construct() {
        // dd('aaaa');
        $this->middleware('admin');
        $this->jsondata = [];
        $this->message = false;
        $this->redirect = false;
        $this->status = false;
        $this->prefix = \DB::getTablePrefix();
        $this->URI_PLACEHOLDER = \Config::get('constants.URI_PLACEHOLDER');
    }

    public function index() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
            $brodcastNotification=BrodcastNotification::get();
            $popupNotification=PopUpNotification::get();
              $invoiceEmailNotification=EmailNotification::where('identifier','invoice email')->first();
              $deliveryEmailNotification=EmailNotification::where('identifier','delivery email')->first();
              $giftCardEmailNotification=EmailNotification::where('identifier','gift card email')->first();
            return view('admin.notification-managment.index',compact('brodcastNotification','popupNotification','invoiceEmailNotification','deliveryEmailNotification','giftCardEmailNotification'));
        }
    }

    public function index1()
    {
        return view('admin.pushNotification');
    } 
    

    public function sendNotification(Request $request)
    {
         $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
            
        $SERVER_API_KEY = 'AAAAbPtHfNY:APA91bGAvFfWkVSYIHvmBtptkAN9G3df3zLGyTiSZbO3nXgmdJWzadTOuS0dM2rH2MUG4-0WWpUYvr9ZwcTvAtBJzcAg1c56VYBFapL-QWdkpb0rVSrufA7yD4KgFBkeR72P5KbNzXsU';
    
        $data = [
            "registration_ids" => $firebaseToken,
            // "to" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,  
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
    dd($response);
    die;
        return back()->with('success', 'Notification send successfully.');
    }


    public function storeBroadCastNotification(Request $request){
        if(isset($request->images)){
            $filename = $request->images->getClientOriginalName();
            $imageName = time().'.'.$filename;
            if(env('APP_ENV') == 'local'){
                $return = $request->images->move(
                    base_path() . '/public/uploads/meal_image/', $imageName);
            }
            $url = url('/uploads/meal_image/');
            $images = $url.'/'. $imageName;
        }
        BrodcastNotification::create([
            'notification_label'=>$request->notification_label,
            'date_time'=>$request->date_time,
            'image'=>$images,
            'description'=>$request->description,
        ]);
        
         $userBroadcast = User::whereNotIn('status',['0'])->get();
         if(count($userBroadcast)>0){
            foreach($userBroadcast as $userBroadcasts){
            $data = [
                'user_id' => $userBroadcasts->id,
                'title_en' => 'Insatnt',
                'title_ar' => 'Instant',
                'body_en' => $request->description,
                'body_ar' => $request->description,
                // 'body' => [
                // 'notification' => $notification,
                // 'data' => $extraNotificationData
                // ],
                'type' => 'yes',
                'read_status' => 'unread'
            ];
     
            Notification::create($data);
    }
         }
     
      
        \Illuminate\Support\Facades\Session::flash('broadcast');
        return redirect('admin/notification-management')->with('success', ' Insert successfully.');
    }

    public function storePopupNotification(Request $request){
        if(isset($request->images)){
            $filename = $request->images->getClientOriginalName();
            $imageName = time().'.'.$filename;
            if(env('APP_ENV') == 'local'){
                $return = $request->images->move(
                    base_path() . '/public/uploads/meal_image/', $imageName);
            }
            $url = url('/uploads/meal_image/');
            $images = $url.'/'. $imageName;
        }
        PopUpNotification::create([
            'notification_label'=>$request->notification_label,
            'date_time'=>$request->date_time,
            'image'=>$images,
            'description'=>$request->description,
        ]);
        \Illuminate\Support\Facades\Session::flash('popup');
        return redirect('admin/notification-management')->with('success', ' Insert successfully.');
    }


    public function update(Request $request, $id=null){

        $update = EmailNotification::find($id);
        $update->description = $request->input('invoiceEmail'); 
         $update->save();  
     
          if($update){
              return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Your content update successfully']);
          }
          else {
              return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while update content']);
          }
      }

      public function delivery_update(Request $request, $id=null){

         $update = EmailNotification::find($id);
        $update->description = $request->input('delivery_email'); 
         $update->save();  
     
          if($update){
              return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Your content update successfully']);
          }
          else {
              return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while update content']);
          }
      }

      public function giftCard_update(Request $request, $id=null){

         $update = EmailNotification::find($id);
       $update->description = $request->input('giftCardEmail'); 
        $update->save();  
    
         if($update){
             return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Your content update successfully']);
         }
         else {
             return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while update content']);
         }
     }


}
