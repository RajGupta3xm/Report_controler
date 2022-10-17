<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Query;
use App\Models\QueryReply;
use DB;

class SupportController extends Controller
{
  
    public function index() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
              $query = Query::with('queryreply')->where('type','chat')->orderBy('id','asc')->get();
            // return $query_reply = Query::with('queryreply')->orderBy('id','asc')->get();
            //  return $query[0]->queryreply[0]->reply;
            $data['queries'] = $query;
            // $data['reply'] = $query_reply;
             return view('admin.query.query-list')->with($data);
        }
    }

    public function change_status(Request $request){
        $id = $request->input('id');
         $status = $request->input('action');
        $update = Query::find($id)->update(['status' => $status]);
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
        }
    }

    public function query_delete(Request $request ){
        $id = $request->input('id');
         $query_delete = Query::find($id);
        $delete = $query_delete->delete();
        if ($delete) {
          return response()->json(['status' => true, 'error_code' => 200, 'message' => 'query deleted successfully']);
      } else {
          return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while deleting event']);
      }
}

public function filter_list(Request $request) {
    $start_date = date('Y-m-d 00:00:00', strtotime($request->input('start_date')));
     $end_date = date('Y-m-d 23:59:59', strtotime($request->input('end_date')));
    if ($request->input('start_date') && $request->input('end_date')) {
         $query = Query::where('status', '<>', 99)
                ->whereBetween('created_at', [$start_date, $end_date])
                ->orderBy('id', 'DESC')
                ->get();
    } else {
        $query = Query::where('status', '<>', 99)->orderBy('id', 'DESC')->get();
    }
    $data['start_date'] = $request->input('start_date');
    $data['end_date'] = $request->input('end_date');
    $data['queries'] = $query;
    return view('admin.query.query-list')->with($data);
}

public function queryChat(Request $request){
     $chat_id = $request->input('id');
      $data['querydata'] = Query::where('id',$chat_id)->where('status','0')->first();
      $data['queryreply'] = QueryReply::where('query_id',$chat_id)->get();
      

   if($data){
      return response()->json([ 'success'=>true, 'data'=>$data]);
  }else {
   return response()->json(['success' => false,  'msg' => 'Error while getting message']);
}

}

public function query_reply(Request $request){
      $id =  $request['id'];
     $data=[
      "reply" => $request->input('reply'),
      'user_type' => 'admin',
      'query_id'  =>  $id,
  ];
    //  $update = Query::find($id)->update($data);
    $insert = QueryReply::create($data);
    if($insert){
        $data['last_reply_id'] = $insert->id;
        $update = Query::find($id)->update($data);
    }
    if($insert){
        return response()->json(['status' => true, 'success_code' => 200, 'data'=>$insert]);
    }
    else {
        return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while sending reply']);
    }
}

public function send_mail($email) {
    $data=['name'=>$email['name'],'query'=>$email['message'],'reply'=>$email['reply']];
    Mail::send('email', $data, function($message) use ($email) {
        $message->to($email['to'], $email['name'])->subject('Reply: '.$email['subject']);
        $message->from('testmail.gropse@gmail.com', 'Upvade Management');
    });
}
  
}
