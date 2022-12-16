<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\GiftCard;
use DB;

class GiftCardController extends Controller
{
  
    public function index() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
             $giftCard = GiftCard::select('*')->orderBy('id','asc')->get();
            $data['giftCards'] = $giftCard;
            // $data['reply'] = $query_reply;
             return view('admin.giftcard.gift-card-detail')->with($data);
        }
    }

    public function change_status(Request $request){
        $id = $request->input('id');
         $status = $request->input('action');
        $update = GiftCard::find($id)->update(['status' => $status]);
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
        }
    }

    public function giftCard_delete(Request $request ){
        $id = $request->input('id');
         $giftcard_delete = GiftCard::find($id);
        $delete = $giftcard_delete->delete();
        if ($delete) {
          return response()->json(['status' => true, 'success_code' => 200, 'message' => 'query deleted successfully']);
      } else {
          return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while deleting event']);
      }
}


public function giftCard_submit(Request $request ){
       $data=[
        "title" => $request->input('name_en'),
        "title_ar" => $request->input('name_ar'),
        "discount" => $request->input('discount'),
        "amount" => $request->input('price'),
        "gift_card_amount" => $request->input('gift_card_amount'),
        "description" => $request->input('description'),
        "description_ar" => $request->input('description_ar'),
    ];


    if(!empty($request->image)){
        $filename = $request->image->getClientOriginalName();
        $imageName = time().'.'.$filename;
        if(env('APP_ENV') == 'local'){
            $return = $request->image->move(
            base_path() . '/public/uploads/giftCard_image/', $imageName);
        }else{
            $return = $request->image->move(
            base_path() . '/public/uploads/giftCard_image/', $imageName);
        }
        $url = url('/uploads/giftCard_image/');
     $data['image'] = $url.'/'. $imageName;
     
    }

$insert = GiftCard::create($data);
if($insert){
   return redirect('admin/gift-card-management')->with('success', ' Insert successfully.');
}
else {
   return redirect()->back()->with('error', 'Some error occurred while update ');
}

}
  
}
