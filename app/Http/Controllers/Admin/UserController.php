<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Response;
use Session;
use Mail;
//use App\Http\Requests\UsersRequest as StoreRequest;
//use App\Http\Requests\UsersRequest as UpdateRequest;
//use App\Http\Controllers\CrudOverrideController;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Post;
use App\Models\Query;
use App\Models\Category;
use App\Models\Country;
use App\Models\Like;
use App\Models\ChallengeParticipant;
use App\Models\Comment;
use App\Models\UserFollowing;
use App\Models\Reported;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class UserController extends Controller {

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
            $users = Users::where('status', '<>', 99)->orderBy('id', 'DESC')->get();
            $country = Country::get();
            $data['users'] = $users;
            $data['country_list'] = $country;
            return view('admin.users.user_list')->with($data);
        }
    }

    public function show(Request $request, $id = null) {
        if (Auth::guard('admin')->check()) {
            $id = base64_decode($id);
            $user = Users::where('id', $id)->first();
            if ($user) {
                $country = Country::where(['country' => $user->country, 'country_code' => $user->country_code])->first();
                if ($country) {
                    $user->flag = url($country->flag);
                } else {
                    $user->flag = url('/assets/images/flag.png');
                }
                $myFollowings = UserFollowing::where(['following_user_id' => $id])->count();
                $user->fans = $myFollowings;
                $postsList = [];

                if ($request->input('start_date') && $request->input('end_date')) {
                    $start_date = date('Y-m-d 00:00:00', strtotime($request->input('start_date')));
                    $end_date = date('Y-m-d 23:59:59', strtotime($request->input('end_date')));
                    $posts = $posts = Post::where(['posts.status' => '1', 'user_id' => $id])
                            ->whereBetween('posts.created_at', [$start_date, $end_date])
                            ->orderBy('id', 'DESC')
                            ->get();
                    $data['start_date'] = $request->input('start_date');
                    $data['end_date'] = $request->input('end_date');
                } else {
                    $posts = Post::where(['posts.status' => '1', 'user_id' => $id])->orderBy('id', 'DESC')->get();
                }
                if ($posts) {
                    foreach ($posts as $post) {
                        if ($post->category_id) {
                            $category = Category::find($post->category_id);
                            if ($category) {
                                $post->category_name = $category->name;
                            } else {
                                $post->category_name = "N\A";
                            }
                        } else {
                            $post->category_name = "";
                        }
                    }
                }
                $user->posts = $posts;
                $data['user'] = $user;
                return view('admin.users.user_detail')->with($data);
            } else {
                return redirect('admin/user-management')->with('error', 'User not found');
            }
        } else {
            return redirect()->intended('admin/login');
        }
    }

    public function user_post_filter(Request $request, $id = null) {
        if (Auth::guard('admin')->check()) {
            $id = $request->input('user_id');

            $user = Users::where('id', $id)->first();
            if ($user) {
                $country = Country::where(['country' => $user->country, 'country_code' => $user->country_code])->first();
                if ($country) {
                    $user->flag = url($country->flag);
                } else {
                    $user->flag = url('/assets/images/flag.png');
                }
                $myFollowings = UserFollowing::where(['following_user_id' => $id])->count();
                $user->fans = $myFollowings;
                $postsList = [];

                if ($request->input('start_date') && $request->input('end_date')) {
                    $start_date = date('Y-m-d 00:00:00', strtotime($request->input('start_date')));
                    $end_date = date('Y-m-d 23:59:59', strtotime($request->input('end_date')));
                    $posts = $posts = Post::where(['posts.status' => '1', 'user_id' => $id])
                            ->whereBetween('posts.created_at', [$start_date, $end_date])
                            ->orderBy('id', 'DESC')
                            ->get();
                    $data['start_date'] = $request->input('start_date');
                    $data['end_date'] = $request->input('end_date');
                } else {
                    $posts = Post::where(['posts.status' => '1', 'user_id' => $id])->orderBy('id', 'DESC')->get();
                }
                if ($posts) {
                    foreach ($posts as $post) {
                        if ($post->category_id) {
                            $category = Category::find($post->category_id);
                            if ($category) {
                                $post->category_name = $category->name;
                            } else {
                                $post->category_name = "N\A";
                            }
                        } else {
                            $post->category_name = "";
                        }
                    }
                }
                $user->posts = $posts;
                $data['user'] = $user;
                return view('admin.users.user_detail')->with($data);
            } else {
                return redirect('admin/user-management')->with('error', 'User not found');
            }
        } else {
            return redirect()->intended('admin/login');
        }
    }

    public function change_user_status(Request $request) {
        $id = $request->input('id');
        $status = $request->input('action');

        $update = Users::find($id)->update(['status' => $status]);
        if ($update) {
            if ($status == '2') {
                $data = DB::table('oauth_access_tokens')->where('user_id', $id)->update(['revoked' => '1']);
            }
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
        }
    }

    public function filter_list(Request $request) {
        $country = DB::table('country')->get();
        $data['country_list'] = $country;
//          print_r($_POST);die;
        $start_date = date('Y-m-d 00:00:00', strtotime($request->input('start_date')));
        $end_date = date('Y-m-d 23:59:59', strtotime($request->input('end_date')));
        if ($request->input('country') && $request->input('start_date') && $request->input('end_date')) {
            $users = Users::where('status', '<>', 99)
                    ->where('country', $request->input('country'))
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->orderBy('id', 'DESC')
                    ->get();
        } else if ($request->input('country')) {
            $users = Users::where('status', '<>', 99)
                    ->where('country', $request->input('country'))
                    ->orderBy('id', 'DESC')
                    ->get();
        } else if ($request->input('start_date') && $request->input('end_date')) {
            $users = Users::where('status', '<>', 99)
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->orderBy('id', 'DESC')
                    ->get();
        } else {
            $users = Users::where('status', '<>', 99)->orderBy('id', 'DESC')->get();
        }
        $data['country_name'] = $request->input('country');
        $data['start_date'] = $request->input('start_date');
        $data['end_date'] = $request->input('end_date');
        $data['users'] = $users;
        return view('admin.users.user_list')->with($data);
    }

    public function videoList(Request $request) {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
            $posts = Post::select('posts.*', 'username', 'name', 'image', 'country')->where('posts.status', '1')->where('video_type','<>','3')->join('users', 'posts.user_id', '=', 'users.id')->orderBy('id', 'DESC')->get();
            $data['posts'] = $posts;
            return view('admin.video.video_list')->with($data);
        }
    }

    public function videoDetail(Request $request, $id = null) {
        if (Auth::guard('admin')->check()) {
            $id = base64_decode($id);
            $post = Post::select('posts.*', 'username', 'name', 'image', 'country')->where('posts.id', $id)->where('posts.status', '1')->join('users', 'posts.user_id', '=', 'users.id')->first();
            if ($post) {
                if ($post->category_id) {
                    $category = Category::find($post->category_id);
                    if ($category) {
                        $post->category_name = $category->name;
                    } else {
                        $post->category_name = "N\A";
                    }
                } else {
                    $post->category_name = "";
                }
                $challange_video = 0;
                $allLikes = Like::where('post_id', $id)->get();
                $post->total_likes = count($allLikes);
                $allcomment = Comment::where('post_id', $id)->get();
                $post->total_comments = count($allcomment);
                // $getChallengeVideo = ChallengeParticipant::where(['status' => '1', 'post_id' => $id])->get()->toArray();
                $getChallengeVideo = Post::where(['status' => '1', 'parent_post_id' => $id])->get()->toArray();
                if ($getChallengeVideo) {
                    $challange_video = count($getChallengeVideo);
                }
                $post->participant_video = $challange_video;
                $data['post'] = $post;
                return view('admin.video.video_detail')->with($data);
            } else {
                return redirect('admin/video-management')->with('error', 'Video not found');
            }
        } else {
            return redirect()->intended('admin/login');
        }
    }

    public function participants(Request $request, $id = null) {
        if (Auth::guard('admin')->check()) {
            $id = base64_decode($id);
            $post = Post::where('id', $id)->where('status', '1')->first();
            if ($post) {

                $challange_video = [];

                // $getChallengeVideo = ChallengeParticipant::select('challenge_participants.*', 'name', 'username', 'image', 'country')->where(['challenge_participants.status' => '1', 'post_id' => $id])->join('users', 'challenge_participants.user_id', '=', 'users.id')->get()->toArray();
                $getChallengeVideo = Post::select('posts.*', 'name', 'username', 'image', 'country')->where(['posts.status' => '1', 'parent_post_id' => $id])->join('users', 'posts.user_id', '=', 'users.id')->get()->toArray();
                if ($getChallengeVideo) {
                    foreach($getChallengeVideo as  $getChallenge){
                        $getChallenge['total_likes']=0;
                        $getChallenge['total_comments']=0;
                        $comments = Comment::where('post_id', $getChallenge['id'])->where('comments.comment_id', '0')->where('comments.status', '1')->get();
                        $getChallenge['total_comments']= count($comments);

                        $allLikes = Like::where('post_id', $getChallenge['id'])->get();
                        $getChallenge['total_likes'] = count($allLikes);
                        array_push($challange_video,$getChallenge);
                    }
                    // $challange_video = $getChallengeVideo;
                }
//                $post->participant_video = $challange_video;
                $data['posts'] = $challange_video;
                return view('admin.video.participants_video')->with($data);
            } else {
                return redirect('admin/video-detail/' . base64_encode($id))->with('error', 'Some error occured');
            }
        } else {
            return redirect()->intended('admin/login');
        }
    }

    public function change_video_status(Request $request) {
        $id = $request->input('id');
        $status = $request->input('action');
        $update = Post::find($id)->update(['status' => $status]);
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Video Deleted successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while deleting video']);
        }
    }

    public function filter_video_list(Request $request) {
        $start_date = date('Y-m-d 00:00:00', strtotime($request->input('start_date')));
        $end_date = date('Y-m-d 23:59:59', strtotime($request->input('end_date')));
        if ($request->input('start_date') && $request->input('end_date')) {
            $posts = $posts = Post::select('posts.*', 'username', 'name', 'image', 'country')
                    ->where('posts.status', '1')
                    ->where('posts.video_type','<>','3')
                    ->whereBetween('posts.created_at', [$start_date, $end_date])
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->orderBy('id', 'DESC')
                    ->get();
        } else {
            $posts = Post::select('posts.*', 'username', 'name', 'image', 'country')->where('posts.status', '1')->where('posts.video_type','<>','3')->join('users', 'posts.user_id', '=', 'users.id')->orderBy('id', 'DESC')->get();
        }
        $data['start_date'] = $request->input('start_date');
        $data['end_date'] = $request->input('end_date');
        $data['posts'] = $posts;
        return view('admin.video.video_list')->with($data);
    }

    public function change_participationvideo_status(Request $request) {
        $id = $request->input('id');
        $status = $request->input('action');
        $update = Post::find($id)->update(['status' => $status]);
        // $update = ChallengeParticipant::find($id)->update(['status' => $status]);
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Video Deleted successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while deleting video']);
        }
    }

    public function reportList(Request $request) {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
            $posts = Reported::select('reported.*', 'username', 'posts.user_id', 'posts.description as title','report_reasons.reason as reason_id')->where('posts.status', '1')->join('posts', 'reported.post_id', '=', 'posts.id')->join('report_reasons', 'report_reasons.id', '=', 'reported.reason_id')->join('users', 'reported.user_id', '=', 'users.id')->orderBy('reported.id', 'DESC')->get();
            $data['posts'] = $posts;
            return view('admin.report.report_list')->with($data);
        }
    }

    public function reportDetail(Request $request, $id = null) {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
            $id = base64_decode($id);
            $report = Reported::select('username', 'name', 'reported.*','report_reasons.reason as reason_id')->where('reported.id', $id)->join('report_reasons', 'report_reasons.id', '=', 'reported.reason_id')->join('users', 'reported.user_id', '=', 'users.id')->join('posts', 'reported.post_id', '=', 'posts.id')->first();
            if ($report) {
                $post = Post::select('posts.*', 'username', 'name', 'image', 'country')->where('posts.id', $report->post_id)->where('posts.status', '1')->join('users', 'posts.user_id', '=', 'users.id')->first();
                if ($post) {
                    if ($post->category_id) {
                        $category = Category::find($post->category_id);
                        if ($category) {
                            $post->category_name = $category->name;
                        } else {
                            $post->category_name = "N\A";
                        }
                    } else {
                        $post->category_name = "";
                    }
                    $challange_video = 0;
                    $allLikes = Like::where('post_id', $report->post_id)->get();
                    $post->total_likes = count($allLikes);
                    $allcomment = Comment::where('post_id', $report->post_id)->get();
                    $post->total_comments = count($allcomment);
                    // $getChallengeVideo = ChallengeParticipant::where(['status' => '1', 'post_id' => $report->post_id])->get()->toArray();
                    $getChallengeVideo = Post::where(['status' => '1', 'parent_post_id' => $report->post_id])->get()->toArray();
                    if ($getChallengeVideo) {
                        $challange_video = count($getChallengeVideo);
                    }
                    $post->participant_video = $challange_video;
                    $data['report'] = $report;
                    $data['post'] = $post;
                } else {
                    $data['post'] = [];
                }
                return view('admin.report.report_detail')->with($data);
            } else {
                return redirect('admin/report-management')->with('error', 'Report not found');
            }
        }
    }

    public function filter_report_list(Request $request) {
        $start_date = date('Y-m-d 00:00:00', strtotime($request->input('start_date')));
        $end_date = date('Y-m-d 23:59:59', strtotime($request->input('end_date')));
        if ($request->input('start_date') && $request->input('end_date')) {
            $posts = $posts = Reported::select('reported.*', 'username', 'posts.user_id', 'title')
                    ->where('posts.status', '1')
                    ->whereBetween('reported.created_at', [$start_date, $end_date])
                    ->join('posts', 'reported.post_id', '=', 'posts.id')
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->orderBy('reported.id', 'DESC')
                    ->get();
        } else {
            $posts = Reported::select('reported.*', 'username', 'posts.user_id', 'title')->where('posts.status', '1')->join('posts', 'reported.post_id', '=', 'posts.id')
                            ->join('users', 'posts.user_id', '=', 'users.id')
                            ->orderBy('id', 'DESC')->get();
        }
        $data['start_date'] = $request->input('start_date');
        $data['end_date'] = $request->input('end_date');
        $data['posts'] = $posts;
        return view('admin.report.report_list')->with($data);
    }

    public function queryList(Request $request) {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
            $query = Query::orderBy('id', 'DESC')->get();
            $data['queries'] = $query;
            return view('admin.query.query_list')->with($data);
        }
    }

    public function queryDetail(Request $request,$id=null) {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
            $id = base64_decode($id);
            $query = Query::where('id', $id)->first();
            if ($query) {
                $data['query'] = $query;
                return view('admin.query.query_detail')->with($data);
            } else {
                return redirect('admin/query-management')->with('error', 'Query not found');
            }
        }
    }
    
    public function query_reply(Request $request){
        $id = $request->input('id');
        $reply = $request->input('reply');
        $update= Query::find($id)->update(['reply' => $reply,'status'=>'1']);
        if ($update) {
            $query=Query::find($id);
            $email=[
                'to'=>$query->email,
                'name'=>$query->name,
                'subject'=>$query->subject,
                'message'=>$query->message,
                'reply'=>$query->reply,
                'status'=>'1',
                'created_at'=>date('d M Y H:i A',strtotime($query->creater))
            ];
            $this->send_mail($email);
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Reply sent successfully']);
        } else {
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
