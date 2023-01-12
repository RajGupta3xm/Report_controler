<?php

namespace App\Http\Controllers\Admin;

use App\Models\BrodcastNotification;
use App\Models\MealPlan;
use App\Models\MealPlanGroup;
use App\Models\MealPlanVariant;
use App\Models\MealVariantDefaultMeal;
use App\Models\PopUpNotification;
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
            return view('admin.notification-managment.index',compact('brodcastNotification','popupNotification'));
        }
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


}
