<?php

namespace App\Http\Controllers\Admin;

use App\Models\FleetArea;
use App\Models\FleetDriver;
use App\Models\MealPlan;
use App\Models\MealPlanGroup;
use App\Models\MealPlanVariant;
use App\Models\MealVariantDefaultMeal;
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

class FleetController extends Controller {

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
            $data['area'] = FleetArea::get();
            return view('admin.fleet-managment.index')->with($data);;
        }
    }

    public function addArea(Request $request){
        FleetArea::create([
            'area'=>$request->area,
            'area_ar'=>$request->area_ar,
            'delivery_slot_ids'=>json_encode($request->delivery_slot_id),
        ]);

        return redirect()->back()->with('success','FleetArea added successfully');

    }
    public function editArea(Request $request){

        $clients=FleetArea::where('id',$request->tour_id)->first();
        $returnHTML =view('admin.fleet-managment.edit', compact('clients'))->render();
        return response()->json(['html'=>$returnHTML]);

    }

    public function edit_update($id,Request $request){
        FleetArea::where('id',$id)->update([
            'area'=>$request->area,
            'area_ar'=>$request->area_ar,
            'delivery_slot_ids'=>json_encode($request->delivery_slot_id),
            'staff_ids'=>isset($request->staff_ids)?json_encode($request->staff_ids):null,
        ]);
        return redirect()->back()->with('success','FleetArea added successfully');
    }

    public function change_status(Request $request){
        $id = $request->input('id');
         $status = $request->input('action');
        $update = FleetArea::find($id)->update(['status' => $status]);
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
        }
    }

    public function storeFleetDriver(Request $request){

        foreach ($request->driver as $orderKey=>$driver_id){
            $fleetDriver=FleetDriver::where('order_id',$orderKey)->first();
            if(isset($fleetDriver)){
                $fleetDriver->order_id=$orderKey;
                $fleetDriver->staff_member_id=$driver_id;
                $fleetDriver->delivery_slot_id=$request->deliveryslot[$orderKey];
                $fleetDriver->save();
            }else{
                FleetDriver::firstOrCreate([
                    'order_id'=>$orderKey,
                    'staff_member_id'=>$driver_id,
                    'delivery_slot_id'=>$request->deliveryslot[$orderKey]
                ]);
            }
        }
        \Illuminate\Support\Facades\Session::flash('driver');
        return redirect()->back()->with('success','FleetArea added successfully');
    }

}