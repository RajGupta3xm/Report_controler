<?php

namespace App\Http\Controllers\Admin;

use App\Models\FleetArea;
use App\Models\FleetDriver;
use App\Models\MealPlan;
use App\Models\MealPlanGroup;
use App\Models\MealPlanVariant;
use App\Models\MealVariantDefaultMeal;
use App\Models\Admin;
use App\Models\StaffMembers;
use App\Models\Order;
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
use App\Exports\FleetsExport;
use Maatwebsite\Excel\Facades\Excel;
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
             $data['areas'] = FleetArea::get();
            return view('admin.fleet-managment.index')->with($data);
        }
    }

    public function addArea(Request $request){

    // $data = json_decode($request->area,true);
    // $print = preg_replace('/^([^,]*).*$/', '$1', $data['description']);
    //   dd($print);
        FleetArea::create([
            'area'=>$request->area,
            'area_ar'=>$request->area_ar,
            'delivery_slot_ids'=>$request->delivery_slot_id,
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
            'area'=>$request->area_edit,
            'area_ar'=>$request->area_ar_edit,
            'delivery_slot_ids'=>$request->delivery_slot_id_edit,
            'staff_ids'=>isset($request->staff_ids_edit)?$request->staff_ids_edit:null,
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
                $fleetDriver->priority=$request->priority[$orderKey];
                $fleetDriver->save();
            }else{
                FleetDriver::firstOrCreate([
                    'order_id'=>$orderKey,
                    'staff_member_id'=>$driver_id,
                    'delivery_slot_id'=>$request->deliveryslot[$orderKey],
                    'priority'=>$request->priority[$orderKey]
                ]);
            }
        }
        \Illuminate\Support\Facades\Session::flash('driver');
        return redirect()->back()->with('success','FleetArea added successfully');
    }
    
    public function driverLocation(Request $request)
    {
        if($request->ajax()){
            $data = Admin::Find($request->id);
            return Response($data);
        }
     }


    public function allDriverLocation(Request $request)
{
      $date = $request->date;
     $drive = [];
    //    $getOrder = Order::join('fleet_driver','orders.id','=','fleet_driver.order_id')
    //  ->select('orders.id','fleet_driver.staff_member_id')->whereDate('orders.created_at',$date)->where('orders.plan_status','plan_active')->get();
    //  if($getOrder){
    //     foreach($getOrder as $getOrders){
    //          $driver[] = Admin::join('staff_members','admin.id','=','staff_members.admin_id')
    //         ->where('staff_members.id',$getOrders->staff_member_id)
    //         ->select('admin.latitude','admin.longitude')
    //         ->get();
    //         // array_push($drive,$driver);
           
    //     }
    //     $data['getOrders'] =$getOrder;
    //     // dd($drive);
        // die;
        // $data['drivers'] = $drive;
    //  }
    //  foreach($driver as $drivers){
    //     foreach($drivers as $driverr){
    //     $lat[] = $driverr;
    //     }
   
    // }
    // dd($lat);
    // die;
      $drivers = StaffMembers::join('fleet_driver','staff_members.id','=','fleet_driver.staff_member_id')
    ->join('admin','staff_members.admin_id','=','admin.id')
    ->select('admin.latitude','admin.longitude','admin.name')
    ->get();
//  $data['drivers'] = $drivers;
//   return $drivers = Admin::all();

     return view('admin.map')->with('drivers', $drivers);
}

public function export(Request $request)
{
    //  $users = User::all();
       $users =  Unit::select('*')->orderBy('id','desc')->get();

    return Excel::download(new UnitsExport($users), 'units.xlsx');
}

public function update(Request $request, $id=null){
        $data=[
     "deliver_note" => $request->input('reply'),
 ];
   $update = Order::where('id',$request->order_id)->update($data);
   if($update){
       return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Your remark update successfully']);
   }
   else {
       return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while update remark']);
   }
}

}
