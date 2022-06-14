<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\Otp;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Category;
use App\Models\Country;
use App\Models\Favourite;
use App\Models\PostView;
use App\Models\Blocked;
use App\Models\UserFollowing;
use App\Models\Query;
use App\Models\Reported;
use App\Models\Notification;
use App\Models\AppNotification;
use App\Models\ReportReason;
use App\Models\ChallengeParticipant;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller {

    public function __construct() {
        DB::enableQueryLog();
    }

    public function register(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required',
            // 'username' => 'required',
            // 'country_code' => 'required',
            // 'mobile' => 'required',
            'email' => 'required',
            'password' => 'required'
        ], [
            'name.required' => 'name is required field',
            // 'username.required' => 'username is required field',
            // 'country_code.required' => 'country code is required field',
            // 'mobile.required' => 'mobile is required field',
            'email.required' => 'email is required field',
            'password.required' => 'password is required field',
        ]);
        $validatedData->after(function ($validatedData) use ($request) {
            $ifMobile = Users::where(['email' => $request['email']])->get()->first();
            if ($ifMobile) {
                $validatedData->errors()->add('email', 'email already registered');
            }
            
        });
        if ($validatedData->fails()) {
            $this->status_code = 201;
            $this->message = $validatedData->errors();
        } else {
            
            $insert = [
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password'])
            ];

            $newUser = Users::create($insert);
            
            //dd($resultSMS);
            if ($newUser) {
                $createOtp = [
                    'user_id' => $newUser->id,
                    'otp' => '1234'
                    // 'otp' => generateRandomOtp()
                ];
                $newUser->otp = $createOtp['otp'];
                // $resultSMS = sendSMS("+".$request['country_code'],$request['mobile'],$createOtp['otp']);
                $otp = Otp::create($createOtp);
                $newUser->user_id = $newUser->id;
                $response = new \Lib\PopulateResponse($newUser);
                $this->data = $response->apiResponse();
                $this->message = 'registration Successful';
            } else {
                $this->message = 'Server could not get any response. Please try again later.';
            }
            $this->status = true;
        }

        return $this->populateResponse();
    }

    public function uniqueUsername(request $request) {
        $validate = Validator::make($request->all(), [
            'username' => 'required'
        ], [
            'username.required' => 'username is required field'
        ]);

        $validate->after(function ($validate) use ($request) {
            if ($request['username']) {
                $ifUsername = Users::where(['username' => $request['username']])->get()->first();
                if ($ifUsername) {
                    $validate->errors()->add('username', 'username is not available');
                }
            }
        });

        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
            $this->message = 'username is available';
            $this->status = true;
        }

        return $this->populateResponse();
    }

    public function verifyOtp(request $request) {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
            'otp' => 'required',
            'type' => 'required'
        ], [
            'user_id.required' => 'user id is required field',
            'otp.required' => 'otp is required field',
            'type.required' => 'type is required field'
        ]);
        $validate->after(function ($validate) use ($request) {
            $userOtp = Otp::where(['user_id' => $request['user_id'], 'otp' => $request['otp']])->get()->first();
            if (!$userOtp) {
                $validate->errors()->add('otp', 'invalid OTP');
            }
        });
        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
            $user = Users::where('id', $request->user_id)->get()->first();
            if ($request->type == 'register') {
                $updateUser = Users::where('id', $request->user_id)->update(['is_otp_verified' => '1', 'mobile_verified_at' => date('Y-m-d H:i:s'), 'status' => '1']);
            } else {
                $updateUser = Users::where('id', $request->user_id)->update(['is_otp_verified' => '1']);
            }

            if ($request->type == 'register') {
                $updateArr = array();
                if ($request->device_token != "" && $request->device_type != "") {
                    $updateArr['device_token'] = $request->device_token;
                    $updateArr['device_type'] = $request->device_type ? $request->device_type : 0;
                }
                if ($updateArr) {
                    Users::where('id', $user->id)->update($updateArr);
                }
                $user->user_id = $user->id;
                $user = $this->getToken($user);
                $response = new \Lib\PopulateResponse($user);
                $this->data = $response->apiResponse();
            }
            $this->message = 'OTP verified successfully';
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function login(request $request) {
        $validate = Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile' => 'required',
            'password' => 'required'
        ], [
            'country_code.required' => 'country code is required field',
            'mobile.required' => 'mobile is required field',
            'password.required' => 'password is required field',
        ]);

        $validate->after(function ($validate) use ($request) {
            $this->status_code = 201;
            $user = Users::where(['country_code' => $request->country_code, 'mobile' => $request->mobile])->get()->first();
            if ($user) {
                $credentials = request(['country_code', 'mobile', 'password']);
                if (!Auth::attempt($credentials)) {
                    $this->message = 'Invalid Credentials';
                    $this->status_code = 202;
                    $validate->errors()->add('password', $this->message);
                } else {
                    if ($user->status == 2) {
                        $this->message = 'This account is blocked by Upvade';
                        $this->status_code = 204;
                        $validate->errors()->add('country code', $this->message);
                        $validate->errors()->add('mobile', $this->message);
                    }
                }
            } else {
                $this->message = 'This mobile is not registered';
                $this->status_code = 201;
                $validate->errors()->add('country code', $this->message);
                $validate->errors()->add('mobile', $this->message);
            }
        });

        if ($validate->fails()) {

            $this->message = $validate->errors();
        } else {
            $this->status = true;
            $user = Users::where(['country_code' => $request->country_code, 'mobile' => $request->mobile])->get()->first();
            if ($user->status == 0) {
                Otp::where('user_id', $user->id)->delete();
                $createOtp = [
                    'user_id' => $user->id,
                    'otp'=>'1234'
                    // 'otp' => generateRandomOtp()
                ];
                $data['user_id'] = $user->id;
                $data['otp'] = $createOtp['otp'];
                $resultSMS = sendSMS("+".$request->country_code,$request->mobile,$createOtp['otp']);
                $otp = Otp::create($createOtp);
                $this->message = 'verify mobile number to proceed. OTP sent on registered mobile number.';
                $this->status_code = 203;
            } else {
                $this->status_code = 200;
                $updateArr = array();
                if ($request->device_token != "" && $request->device_type != "") {
                    $updateArr['device_token'] = $request->device_token;
                    $updateArr['device_type'] = $request->device_type ? $request->device_type : 0;
                }
                if ($updateArr) {
                    Users::where('id', $user->id)->update($updateArr);
                }
                $user->user_id = $user->id;
                $user = $this->getToken($user);
                // $userTokens = $user->tokens;
                // foreach($userTokens as $utoken) {
                //     $utoken->revoke();
                // }
                // $tokenResult =  $user->createToken('MyApp');
                // $token = $tokenResult->token;
                // $token->save();
                // $user['token'] = $tokenResult->accessToken;
                $this->message = 'Login Successful';
                $data = $user;
            }

            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
        }
        return $this->populateResponse();
    }

    public function getToken($user) {
        $userTokens = $user->tokens;

        foreach ($userTokens as $utoken) {
            $utoken->revoke();
        }

        $tokenResult = $user->createToken('MyApp');
        $token = $tokenResult->token;
        $token->save();
        $user['token'] = $tokenResult->accessToken;
        if ($user->image == null) {
            $user->image = url('assets/images/dummy2.jpg');
        }
        return $user;
    }

    public function forgotPassword(request $request) {
        $validate = Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile' => 'required'
        ], [
            'country_code.required' => 'country code is required field',
            'mobile.required' => 'mobile is required field'
        ]);

        $validate->after(function ($validate) use ($request) {
            $this->status_code = 201;
            $user = Users::where(['country_code' => $request->country_code, 'mobile' => $request->mobile])->get()->first();
            if ($user) {
                if ($user->status == 2) {
                    $this->message = 'This account is blocked by Upvade';
                    $this->status_code = 204;
                    $validate->errors()->add('country_code', $this->message);
                    $validate->errors()->add('mobile', $this->message);
                }
            } else {
                $this->message = 'This mobile is not registered';
                $this->status_code = 201;
                $validate->errors()->add('country code', $this->message);
                $validate->errors()->add('mobile', $this->message);
            }
        });

        if ($validate->fails()) {
            $this->message = $validate->errors();
        } else {
            $this->status_code = 200;
            $this->status = true;
            $user = Users::where(['country_code' => $request->country_code, 'mobile' => $request->mobile])->get()->first();
            Otp::where('user_id', $user->id)->delete();
            $createOtp = [
                'user_id' => $user->id,
                'otp' => '1234'
                // 'otp' => generateRandomOtp()
            ];
            $data['user_id'] = $user->id;
            $data['otp'] = $createOtp['otp'];
            $resultSMS = sendSMS("+".$request->country_code,$request->mobile,$createOtp['otp']);
            $otp = Otp::create($createOtp);
            $this->message = 'verify mobile number to proceed. OTP sent on registered mobile number.';

            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
        }
        return $this->populateResponse();
    }

    public function resetPassword(request $request) {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
            'new_password' => 'required'
        ], [
            'user_id.required' => 'user_id is required field',
            'new_password.required' => 'new password is required field'
        ]);

        $validate->after(function ($validate) use ($request) {

            if ($request->new_password && $request->user_id) {
                $user = Users::where(['id' => $request->user_id])->update(['password' => bcrypt($request->new_password)]);
                if (!$user) {
                    $this->message = 'Some error occured';
//                    $this->status_code = 201;
                    $validate->errors()->add('new_password', $this->message);
                }
            }
        });

        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
            $this->status = true;
            $this->message = 'Password changed successfully';
        }
        return $this->populateResponse();
    }

    public function changePassword(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|alpha_dash|min:8',
            'confirm_password' => 'required|min:8|same:new_password'
        ], [
            'current_password.required' => trans('validation.required', ['attribute' => 'current password']),
            'new_password.required' => trans('validation.required', ['attribute' => 'new password']),
            'new_password.alpha_dash' => trans('validation.alpha_dash', ['attribute' => 'new password']),
            'new_password.min' => trans('validation.min', ['attribute' => 'new password']),
            'confirm_password.required' => trans('validation.required', ['attribute' => 'confirm password']),
            'confirm_password.min' => trans('validation.min', ['attribute' => 'confirm password']),
            'confirm_password.same' => trans('validation.same', ['attribute' => 'confirm password'])
        ]);
        $validatedData->after(function ($validatedData) use ($request) {
            if ($request->current_password) {
                $user = Users::where(['id' => Auth::guard('api')->id()])->first();
                if (!Hash::check($request->current_password, $user->password)) {
                    $validatedData->errors()->add('current_password', 'incorrect current password');
                }
            }
        });
        if ($validatedData->fails()) {
            $this->status_code = 201;
            $this->message = $validatedData->errors();
        } else {
            $this->status = true;
            $user = Users::where(['id' => Auth::guard('api')->id()])->first();
            $updateUser = [
                'password' => Hash::make($request->new_password)
            ];
            $data = Users::where('id', Auth::guard('api')->id())->update($updateUser);
            if ($data) {
                $this->message = 'Password changed successully';
            } else {
                $this->message = 'Some error occured';
                $this->status_code = 201;
            }
        }
        return $this->populateResponse();
    }

    public function myProfile() {
        $user = Users::select('id as user_id', 'users.*')->where('id', Auth::guard('api')->id())->first();
        if ($user->image == null) {
            $user->image = url('assets/images/dummy2.jpg');
        }
        $user->total_views = "0";
        $post = Post::selectRaw("SUM(total_views) as views")->where(['user_id' => Auth::guard('api')->id(), 'status' => '1'])->first();
        if ($post) {
            $user->total_views = $post->views;
        }
        $user->total_comments = 0;
        $total_comments = Comment::where(['posts.user_id' => Auth::guard('api')->id(), 'posts.status' => '1'])->join('posts', 'posts.id', '=', 'comments.post_id')->get();
        if ($total_comments) {
            $user->total_comments = count($total_comments);
        }
        $user->total_likes = 0;
        $total_likes = Like::where(['posts.user_id' => Auth::guard('api')->id(), 'posts.status' => '1'])->join('posts', 'posts.id', '=', 'likes.post_id')->get();
        if ($total_likes) {
            $user->total_likes = count($total_likes);
        }
        $user->total_fans = 0;
        $total_fans = UserFollowing::where(['following_user_id' => Auth::guard('api')->id()])->get();
        if ($total_fans) {
            $user->total_fans = count($total_fans);
        }
        $user->total_followings = 0;
        $total_following = UserFollowing::where(['user_id' => Auth::guard('api')->id()])->get();
        if ($total_following) {
            $user->total_followings = count($total_following);
        }
        $user->total_participants=0;
//        $total_participants=ChallengeParticipant::where(['posts.user_id'=>Auth::guard('api')->id()])->join('posts', 'challenge_participants.user_id', '=', 'posts.user_id')->get()->count();
        $total_participants=Post::where(['user_id'=>Auth::guard('api')->id(),'status' => '1'])->get();
        if($total_participants){
            foreach($total_participants as $participants){
                $get_participants=Post::where(['parent_post_id'=>$participants->id,'status'=>'1'])->get()->count();
                if($get_participants){
                    $user->total_participants= $user->total_participants+$get_participants;
                }
            }
//            $user->total_participants=$total_participants;
        }
        $data = $user;
        $this->status = true;
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();

        $this->message = "fetching user profile successfully";

        return $this->populateResponse();
    }

    public function editProfile(Request $request) {
        $validator = \Validator::make($request->all(), [
            'name' => 'required'
        ], [
            'name.required' => 'name is required field'
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->email) {
                $email = Users::where('email', $request['email'])->where('id', '<>', Auth::guard('api')->id())->first();
                if ($email) {
                    $validator->errors()->add('email', "This email already in use");
                }
            }
        });

        if ($validator->fails()) {
            $this->status_code = 201;
            $this->message = $validator->errors();
        } else {

            $addUser['name'] = $request['name'];
//            if ($request->email) {
            $addUser['email'] = $request['email'];
//            }
            if ($request->image) {
                $image = $request->image;
                $filename = $image->getClientOriginalName();
                $filename = str_replace(" ", "", $filename);
                $imageName = time() . '.' . $filename;
                $return = $image->move(
                    base_path() . '/public/uploads/user/', $imageName);
                $url = url('/uploads/user/');
                $addUser['image'] = $url . '/' . $imageName;
            }


            $data = Users::where('id', Auth::guard('api')->id())->update($addUser);
            if ($data) {
                $data = Users::select('id as user_id', 'users.*')->find(Auth::guard('api')->id());
                $response = new \Lib\PopulateResponse($data);
                $this->data = $response->apiResponse();
                $this->message = 'Profile updated successfully';
            } else {
                $this->status_code = 201;
                $this->message = 'Server could not get any response. Please try again later.';
            }
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function homescreen(request $request) {
        $validate = Validator::make($request->all(), [
            // 'country' => 'required',
            'type' => 'required'
        ], [
            // 'country.required' => 'country is required field',
            'type.required' => 'type is required field'
        ]);

        if ($validate->fails()) {
            $this->message = $validate->errors();
        } else {
            $postList = [];
            $start = 0;
            if ($request->start) {
                $start = $request->start * 10;
            }
            if (Auth::guard('api')->id()) {
                $user_id = Auth::guard('api')->id();
                $limit = 10;
            } else {
                $user_id = 0;
                // $limit = 5;
                $limit = 10;
            }
            if ($request->type == 1) {
                if($request->country){
                    $recentPosts = Post::select('posts.id', 'posts.user_id', 'video_privacy', 'video_type', 'category_id', 'title', 'description', 'thumbnail', 'video', 'total_views', 'tags', 'posts.created_at', 'username', 'name', 'image', 'country', 'country_code')
                    ->where(['country' => $request->country, 'posts.status' => '1','parent_post_id'=>"0"])
                    ->when($request->category_id, function ($query) use ($request) {
                        if($request->category_id){
                            $query->where('posts.category_id', $request->category_id);
                        }
                    })
                    ->join('users', 'users.id', '=', 'posts.user_id')
                    ->orderBy('posts.id', 'DESC')
                    ->limit($limit)
                    ->offset($start)->get();
                }else{
                   $recentPosts=[]; 
                }
            } else {
                $recentPosts = Post::select('posts.id', 'posts.user_id', 'video_privacy', 'video_type', 'category_id', 'title', 'description', 'thumbnail', 'video', 'total_views', 'tags', 'posts.created_at', 'username', 'name', 'image', 'country', 'country_code')
                ->where(['video_privacy' => '2', 'posts.status' => '1','parent_post_id'=>"0"])
                ->when($request->category_id, function ($query) use ($request) {
                        if($request->category_id){
                            $query->where('posts.category_id', $request->category_id);
                        }
                    })
                ->join('users', 'users.id', '=', 'posts.user_id')
                ->orderBy('posts.id', 'DESC')
                ->limit($limit)->offset($start)->get();
            }
            if ($recentPosts) {
                foreach ($recentPosts as $post) {
                    $blocked = 0;
                    if ($user_id) {
                        $is_blocked = $this->checkIfBlocked(Auth::guard('api')->id(), $post->user_id);            // you blocked user
                        $if_blocked = $this->checkIfBlocked($post->user_id, Auth::guard('api')->id());           // user blocked you
                        if ($is_blocked || $if_blocked) {
                            $blocked = 1;
                        }
                    }
                    if (!$blocked) {
                        $post = $this->getVideoDetail($post);
                        array_push($postList, $post);
                    }
                }
            }
            $data['posts'] = $postList;
            $this->status = true;
            $this->message = 'Fetching popular videos';
            $response = new \Lib\PopulateResponse($postList);
            $this->data = $response->apiResponse();
        }
        return $this->populateResponse();
    }

    public function videoDetail(request $request) {
        $validator = \Validator::make($request->all(), [
            'post_id' => 'required'
        ], [
            'post_id.required' => 'post id is required field'
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->post_id) {
                $post = Post::where(['id' => $request->post_id, 'status' => 1])->get()->first();
                if (!$post) {
//                    $this->status_code = 201;
                    $validator->errors()->add('post_id', "video post not found.");
                }
            }
        });

        if ($validator->fails()) {
            $this->status_code = 201;
            $this->message = $validator->errors();
        } else {
            // $post = Post::select('posts.id', 'posts.user_id', 'video_privacy', 'video_type', 'category_id', 'title', 'description', 'thumbnail', 'video', 'total_views', 'tags', 'posts.created_at', 'username', 'name', 'image', 'country', 'country_code')->where(['posts.id' => $request->post_id, 'posts.status' => '1','posts.parent_post_id'=>'0'])->join('users', 'users.id', '=', 'posts.user_id')->get()->first();

            $post = Post::select('posts.id', 'posts.user_id', 'video_privacy', 'video_type', 'category_id', 'title', 'description', 'thumbnail', 'video', 'total_views', 'tags', 'posts.created_at', 'username', 'name', 'image', 'country', 'country_code')->where(['posts.id' => $request->post_id, 'posts.status' => '1'])->join('users', 'users.id', '=', 'posts.user_id')->get()->first();

            if ($post) {
                $post = $this->getVideoDetail($post);
                $post->is_fan = 0;

                if (UserFollowing::where(['user_id' => Auth::guard('api')->id(), 'following_user_id' => $post->user_id])->first()) {
                    $post->is_fan = 1;
                }


                $post->comments_list = [];
                $tagged_users = [];
                if ($post->tags) {
                    $tagged_people = explode(',', $post->tags);
                    foreach ($tagged_people as $tagged) {
                        $user = Users::select('id as user_id', 'name', 'username', 'country', 'image')->where('id', $tagged)->first();
                        if ($user) {
                            if ($user->image == null) {
                                $user->image = url('assets/images/dummy2.jpg');
                            }
                            array_push($tagged_users, $user);
                        }
                    }
                }
                $post->tagged_users = $tagged_users;
//                $post->challenge_accepted = 0;
//                $post->participants = [];
                $data = $post;
                $this->status = true;
                $this->message = 'Fetching video details';
                $response = new \Lib\PopulateResponse($data);
                $this->data = $response->apiResponse();
            } else {
                $this->status = true;
                $data = [];                
                $this->message = 'Video not found';
                $response = new \Lib\PopulateResponse($data);
                $this->data = $response->apiResponse();
            }
        }
        return $this->populateResponse();
    }

    public function addVideo(request $request) {
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'video_privacy' => 'required',
            // 'video_type' => 'required',
            'description' => 'required',
            'thumbnail' => 'required',
            'video' => 'required|file|max:30720',
            'category_id' => 'required_if:video_type,=,2'
        ], [
            'title.required' => trans('validation.required', ['attribute' => 'title']),
            'video_privacy.required' => trans('validation.required', ['attribute' => 'video_privacy']),
            // 'video_type.required' => trans('validation.required', ['attribute' => 'video_type']),
            'description.required' => trans('validation.required', ['attribute' => 'description']),
            'thumbnail.required' => trans('validation.required', ['attribute' => 'thumbnail']),
            'video.required' => trans('validation.required', ['attribute' => 'video']),
            'video.file' => trans('validation.file', ['attribute' => 'video']),
            'video.max' => "The video may not be greater than 30MB.",
            'category_id.required_if' => trans('validation.required', ['attribute' => 'category']),
        ]);
        // $validate->after(function($validate) use($request) {
        // });
        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
//            dd(config('filesystems.disks.s3.region'));
//            if ($request->thumbnail) {
//                $thumbnail = $this->uploadfile('/uploads/video_thumbnail/', $request->thumbnail);
//            }
//            if ($request->video) {
//                $video = $this->uploadfile('/uploads/videos/', $request->video);
//            }
            if ($request->thumbnail && $request->video) {
                $response = $this->store($request);
//                print_r($_FILES);
//                print_r($response);die;
                $thumbnail = $response['thumbnail'];
                $video = $response['video'];
            } else {
                $thumbnail = "";
                $video = "";
            }

            if ($request->category_id) {
                $category = $request->category_id;
            } else {
                $category = 0;
            }
            $insert = [
                'user_id' => Auth::guard('api')->id(),
                'parent_post_id'=>'0',
                'title' => $request->title,
                'video_privacy' => $request->video_privacy,
                // 'video_type' => $request->video_type,
                'video_type' => 2,
                'category_id' => $category,
                'description' => $request->description,
                'thumbnail' => $thumbnail,
                'video' => $video
            ];

            if ($request->tags) {
                $insert['tags'] = trim($request->tags, ',');
            }
            $add = Post::create($insert);
            $myArray = explode(',', $add['tags']);
            foreach ($myArray as $key => $value) {
                $Finduser = Users::find($value);
                $userTaged=Users::find(Auth::guard('api')->id());
                // $title = __('front/errors/validation.plan_upgraded_successfully');
                $notificationTitle = 'Post Tag';
                $notificationMessage = '@'.$userTaged->username.' tagged you in a post';
                $notificationType = 'post-tag';
                $sendData = [
                    'id' => $add->id
                ];
                if($Finduser){
                    if($Finduser->push_notification == 'on'){
                        $notifiable=true;
                    }else{
                        $notifiable=false;
                    }
                    sendNotification($Finduser->id, $Finduser->device_token, $notificationTitle, $notificationMessage, $notificationType, $sendData, $notifiable);
                }
            }
            $this->status = true;
            if ($add) {
                $data = $add;
                $response = new \Lib\PopulateResponse($add);
                $this->data = $response->apiResponse();
                $this->message = 'Post created successfully';
            } else {
                $this->status_code = 201;
                $this->message = 'Error occurred while uploading post';
            }
        }
        return $this->populateResponse();
    }

    public function categoryList() {
        $category = Category::where('status', '1')->orderBy('name', 'ASC')->get();
        $response = new \Lib\PopulateResponse($category);
        $this->status = true;
        $this->data = $response->apiResponse();
        $this->message = 'Fetching categories successfully';
        return $this->populateResponse();
    }

    public function myVideos(Request $request) {
        $validate = Validator::make($request->all(), [
            'video_type' => 'required'
        ], [
            'video_type.required' => 'video_type is required field'
        ]);
        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
            $start = 0;
            if ($request->start) {
                $start = $request->start * 9;
            }
            $postList = [];
            $recentPosts = Post::select('posts.id', 'user_id', 'video_privacy', 'video_type', 'category_id', 'title', 'description', 'thumbnail', 'video', 'total_views', 'tags', 'posts.created_at','username', 'name', 'image', 'country', 'country_code')->where(['user_id' => Auth::guard('api')->id(), 'video_type' => $request->video_type, 'posts.status' => '1'])->join('users', 'users.id', '=', 'posts.user_id')->orderBy('id', 'DESC')->limit(9)->offset($start)->get();
            if ($recentPosts) {
                foreach ($recentPosts as $post) {
                    $post = $this->getVideoDetail($post);
                    array_push($postList, $post);
                }
            }
            $data['my_videos'] = $postList;
            $this->status = true;
            $response = new \Lib\PopulateResponse($postList);
            $this->data = $response->apiResponse();

            $this->message = "Fetching my videos";
        }
        return $this->populateResponse();
    }

    public function makeFavourite(Request $request) {
        $validate = Validator::make($request->all(), [
            'post_id' => 'required'
        ], [
            'post_id.required' => trans('validation.required', ['attribute' => 'post_id'])
        ]);
        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
            $ifPosts = Post::where(['id' => $request->post_id, 'status' => '1'])->first();
            if ($ifPosts) {
                if (Favourite::where(['post_id' => $request->post_id, 'user_id' => Auth::guard('api')->id()])->first()) {
                    $add = Favourite::where(['post_id' => $request->post_id, 'user_id' => Auth::guard('api')->id()])->delete();
                    $this->message = "Video removed from favourites.";
                } else {
                    $insert = [
                        'post_id' => $request->post_id,
                        'user_id' => Auth::guard('api')->id(),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    $add = Favourite::insert($insert);
                    $this->message = "Video added to my favourite successfully.";
                }

                if (!$add) {
                    $this->status_code = 201;
                    $this->message = "Some error occured.";
                } else {

                }
            } else {
                $this->status_code = 202;
                $this->message = "Video cannot not be added to favourites, may be it's removed.";
            }
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function myFavourites(Request $request) {
        $start = 0;
        if ($request->start) {
            $start = $request->start * 10;
        }
        $postList = [];
        $myFavourites = Favourite::where(['user_id' => Auth::guard('api')->id()])->limit(10)->offset($start)->get();
        if ($myFavourites) {
            foreach ($myFavourites as $post) {
                $getPost = Post::select('posts.id', 'posts.user_id', 'video_privacy', 'video_type', 'category_id', 'title', 'description', 'thumbnail', 'video', 'total_views', 'tags', 'posts.created_at', 'username', 'name', 'image', 'country', 'country_code')->where(['posts.id' => $post['post_id'], 'posts.status' => '1'])->join('users', 'users.id', '=', 'posts.user_id')->first();
                if ($getPost) {
                    $ifBlocked = $this->checkIfBlocked($getPost->user_id, Auth::guard('api')->id());
                    if (!$ifBlocked) {
                        $post = $this->getVideoDetail($getPost);
                        array_push($postList, $post);
                    }
                }
            }
        }

        $this->status = true;
        $this->message = "My Favourites.";
        $data['my_favourites'] = $postList;
        $response = new \Lib\PopulateResponse($postList);
        $this->data = $response->apiResponse();

        return $this->populateResponse();
    }

    public function likeVideo(Request $request) {
        $validate = Validator::make($request->all(), [
            'post_id' => 'required'
        ], [
            'post_id.required' => trans('validation.required', ['attribute' => 'post_id'])
        ]);
        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
            $ifPosts = Post::where(['id' => $request->post_id, 'status' => '1'])->first();
            if ($ifPosts) {
                if (Like::where(['post_id' => $request->post_id, 'user_id' => Auth::guard('api')->id()])->first()) {
                    $add = Like::where(['post_id' => $request->post_id, 'user_id' => Auth::guard('api')->id()])->delete();
                    $this->message = "Your like removed from video.";
                } else {
                    $insert = [
                        'post_id' => $request->post_id,
                        'user_id' => Auth::guard('api')->id(),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    $add = Like::insert($insert);
                    $Finduser = Users::find($ifPosts->user_id);
                    $userLikes=Users::find(Auth::guard('api')->id());
                    // $title = __('front/errors/validation.plan_upgraded_successfully');
                    $notificationTitle = 'Post Like';
                    $notificationMessage = '@'.$userLikes->username.' liked your post';
                    $notificationType = 'post-like';
                    $sendData = [
                        'id' => $ifPosts->id,
                        'user_id'=>Auth::guard('api')->id()
                    ];

                    if($ifPosts->user_id != Auth::guard('api')->id()){
                        $flag=true;
                        $userNotification=AppNotification::where('user_id',$Finduser->id)->where('type','post-like')->get();
                        if($userNotification){
                            foreach($userNotification as $sent){
                                $body=$sent->body;
                                
                                if($body['data']['id'] == $request->post_id && $body['data']['user_id'] == Auth::guard('api')->id()){
                                    $flag=false;
                                }
                            }
                        }
                        if($flag){
                            if($Finduser->push_notification == 'on'){
                                $notifiable=true;
                            }else{
                                $notifiable=false;
                            }
                            sendNotification($Finduser->id, $Finduser->device_token, $notificationTitle, $notificationMessage, $notificationType, $sendData, $notifiable);
                        }
                    }
                    $this->message = "You liked video.";
                }

                if (!$add) {
                    $this->status_code = 201;
                    $this->message = "Some error occured.";
                } else {

                }
            } else {
                $this->status_code = 202;
                $this->message = "Video not found maybe it's removed.";
            }
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function postLikes(Request $request) {
        $validate = Validator::make($request->all(), [
            'post_id' => 'required'
        ], [
            'post_id.required' => trans('validation.required', ['attribute' => 'post_id'])
        ]);
        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
            $getLikes = $this->getLikeList($request->post_id, 0);
            $this->status = true;
            $this->message = "All likes on post";
            $data = $getLikes;
            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
        }
        return $this->populateResponse();
    }

    public function getLikeList($post_id, $limit) {
        $likeList = [];
        if ($limit) {
            $allLikes = Like::select('users.id as user_id', 'name', 'username', 'country', 'country_code', 'image')->where('post_id', $post_id)->join('users', 'users.id', '=', 'likes.user_id')->limit($limit)->offset(0)->orderBy('likes.id', 'DESC')->get();
        } else {
            $allLikes = Like::select('users.id as user_id', 'name', 'username', 'country', 'country_code', 'image')->where('post_id', $post_id)->join('users', 'users.id', '=', 'likes.user_id')->orderBy('likes.id', 'DESC')->get();
        }
        if ($allLikes) {
            foreach ($allLikes as $liked) {
                if ($liked->image == null) {
                    $liked->image = url('assets/images/dummy2.jpg');
                }
                $country = Country::where(['country' => $liked->country, 'country_code' => $liked->country_code])->first();
                if ($country) {
                    $liked->flag = url($country->flag);
                } else {
                    $liked->flag = url('/assets/images/flag.png');
                }
                $ifBlocked = $this->checkIfBlocked($liked->user_id, Auth::guard('api')->id());
                if (!$ifBlocked) {
                    $liked->is_fan = 0;
                    if (UserFollowing::where(['user_id' => Auth::guard('api')->id(), 'following_user_id' => $liked->user_id])->first()) {
                        $liked->is_fan = 1;
                    }
                    array_push($likeList, $liked);
                }
            }
        }
        return $likeList;
    }

    public function becomeFan(Request $request) {
        $validate = Validator::make($request->all(), [
            'following_user_id' => 'required'
        ], [
            'following_user_id.required' => trans('validation.required', ['attribute' => 'following_user_id'])
        ]);
        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
            $ifUser = Users::find($request->following_user_id);
            if ($ifUser) {
                $ifBlocked = $this->checkIfBlocked($request->following_user_id, Auth::guard('api')->id());
                if (!$ifBlocked) {
                    if (UserFollowing::where(['following_user_id' => $request->following_user_id, 'user_id' => Auth::guard('api')->id()])->first()) {
                        $add = UserFollowing::where(['following_user_id' => $request->following_user_id, 'user_id' => Auth::guard('api')->id()])->delete();
                        $this->message = "You are no longer a fan of $ifUser->name.";
                    } else {
                        $insert = [
                            'user_id' => Auth::guard('api')->id(),
                            'following_user_id' => $request->following_user_id,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ];
                        $add = UserFollowing::insert($insert);
                        $Finduser = Users::find($request->following_user_id);
                        $userFollowed=Users::find(Auth::guard('api')->id());
                        // $title = __('front/errors/validation.plan_upgraded_successfully');
                        $notificationTitle = 'Follower';
                        $notificationMessage = '@'.$userFollowed->username.' started following you';
                        $notificationType = 'become-fan';
                        $sendData = [
                            'id' => Auth::guard('api')->id()
                        ];
                        if($Finduser->push_notification == 'on'){
                            $notifiable=true;
                        }else{
                            $notifiable=false;
                        }

                        sendNotification($Finduser->id, $Finduser->device_token, $notificationTitle, $notificationMessage, $notificationType, $sendData, $notifiable);
                        
                        $this->message = "You started following $ifUser->name.";
                    }
                    if (!$add) {
                        $this->status_code = 201;
                        $this->message = "Some error occured.";
                    }
                } else {
                    $this->status_code = 202;
                    $this->message = "User not found.";
                }
            } else {
                $this->status_code = 202;
                $this->message = "User not found.";
            }
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function myFollowings() {
        $followings = [];
        $myFollowings = UserFollowing::select('users.id as user_id', 'name', 'username', 'country', 'country_code', 'image')->where(['user_id' => Auth::guard('api')->id()])->join('users', 'users.id', '=', 'user_followings.following_user_id')->get();
        if ($myFollowings) {
            foreach ($myFollowings as $following) {
                if ($following->image == null) {
                    $following->image = url('assets/images/dummy2.jpg');
                }
                $country = Country::where(['country' => $following->country, 'country_code' => $following->country_code])->first();
                if ($country) {
                    $following->flag = url($country->flag);
                } else {
                    $following->flag = url('/assets/images/flag.png');
                }
                array_push($followings, $following);
            }
        }
        $this->status = true;
        $this->message = "Your Followings";
        $data = $followings;
        $response = new \Lib\PopulateResponse($followings);
        $this->data = $response->apiResponse();
        return $this->populateResponse();
    }

    public function userProfile(Request $request) {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required'
        ], [
            'user_id.required' => trans('validation.required', ['attribute' => 'user_id'])
        ]);
        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
            $user = Users::select('id as user_id', 'name', 'username', 'country', 'country_code', 'image','device_token')->where('id', $request->user_id)->first();
            if ($user) {
                $country = Country::where(['country' => $user->country, 'country_code' => $user->country_code])->first();
                if ($country) {
                    $user->flag = url($country->flag);
                } else {
                    $user->flag = url('/assets/images/flag.png');
                }
                $ifBlocked = $this->checkIfBlocked($request->user_id, Auth::guard('api')->id());
                if (!$ifBlocked) {
                    $user->total_videos = 0;
                    $post = Post::where(['user_id' => $request->user_id, 'status' => '1'])->get();
                    if ($post) {
                        $user->total_videos = count($post);
                    }
                    $user->total_views = "0";
                    $post = Post::selectRaw("SUM(total_views) as views")->where(['user_id' => $request->user_id, 'status' => '1'])->first();
                    if ($post) {
                        $user->total_views = $post->views;
                    }
                    $user->total_comments = 0;
                    $total_comments = Comment::where(['posts.user_id' => $request->user_id, 'posts.status' => '1'])->join('posts', 'posts.id', '=', 'comments.post_id')->get();
                    if ($total_comments) {
                        $user->total_comments = count($total_comments);
                    }
                    $user->total_likes = 0;
                    $total_likes = Like::where(['posts.user_id' => $request->user_id, 'posts.status' => '1'])->join('posts', 'posts.id', '=', 'likes.post_id')->get();
                    if ($total_likes) {
                        $user->total_likes = count($total_likes);
                    }
                    $user->total_fans = 0;
                    $total_fans = UserFollowing::where(['following_user_id' => $request->user_id])->get();
                    if ($total_fans) {
                        $user->total_fans = count($total_fans);
                    }
                    $user->is_fan = 0;
                    if (UserFollowing::where(['user_id' => Auth::guard('api')->id(), 'following_user_id' => $request->user_id])->first()) {
                        $user->is_fan = 1;
                    }
                    $user->total_followings = 0;
                    $myFollowings = UserFollowing::where(['user_id' => $request->user_id])->get();
                    if ($myFollowings) {
                        $user->total_followings = count($myFollowings);
                    }
                    $user->is_blocked = 0;
                    if ($this->checkIfBlocked(Auth::guard('api')->id(), $request->user_id)) {
                        $user->is_blocked = 1;
                    }
                    if ($user->image == null) {
                        $user->image = url('assets/images/dummy2.jpg');
                    }
                    $user->total_participants=0;
//                    $total_participants=ChallengeParticipant::where(['posts.user_id'=>$request->user_id])->join('posts', 'challenge_participants.user_id', '=', 'posts.user_id')->get()->count();
                    $total_participants=Post::where(['user_id'=>$request->user_id,'status'=>'1'])->get();
                    if($total_participants){
                        foreach($total_participants as $participants){
                            $get_participants=Post::where(['parent_post_id'=>$participants->id,'status'=>'1'])->get()->count();
                            if($get_participants){
                                $user->total_participants= $user->total_participants+$get_participants;
                            }
                        }
            //            $user->total_participants=$total_participants;
                    }
                    $this->message = "User Profile";
                    $response = new \Lib\PopulateResponse($user);
                    $this->data = $response->apiResponse();
                } else {
                    $this->status_code = 202;
                    $this->message = "User not found";
                }
            } else {
                $this->status_code = 202;
                $this->message = "User not found";
            }
        }
        $this->status = true;
        return $this->populateResponse();
    }

    public function myFans() {
        $followings = [];
        $myFollowings = UserFollowing::select('users.id as user_id', 'name', 'username', 'country', 'country_code', 'image')->where(['following_user_id' => Auth::guard('api')->id()])->join('users', 'users.id', '=', 'user_followings.user_id')->get();
        if ($myFollowings) {
            foreach ($myFollowings as $following) {
                $country = Country::where(['country' => $following->country, 'country_code' => $following->country_code])->first();
                if ($following->image == null) {
                    $following->image = url('assets/images/dummy2.jpg');
                }
                if ($country) {
                    $following->flag = url($country->flag);
                } else {
                    $following->flag = url('/assets/images/flag.png');
                }
                array_push($followings, $following);
            }
        }
        $this->status = true;
        $this->message = "My Fans";
        $data = $followings;
        $response = new \Lib\PopulateResponse($followings);
        $this->data = $response->apiResponse();
        return $this->populateResponse();
    }

    public function blockUser(Request $request) {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required'
        ], [
            'user_id.required' => trans('validation.required', ['attribute' => 'user_id'])
        ]);
        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
            $this->status = true;
            $user = Users::find($request->user_id);
            if (!Blocked::where(['user_id' => Auth::guard('api')->id(), 'blocked_user_id' => $request->user_id])->first()) {
                $block = Blocked::insert([
                    'user_id' => Auth::guard('api')->id(),
                    'blocked_user_id' => $request->user_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                if ($block) {
//                    if (UserFollowing::where(['following_user_id' => Auth::guard('api')->id(), 'user_id' => $request->user_id])->get()) {
                    UserFollowing::where(['following_user_id' => Auth::guard('api')->id(), 'user_id' => $request->user_id])->delete();
//                    }
//                    if (UserFollowing::where(['following_user_id' => $request->user_id, 'user_id' => Auth::guard('api')->id()])->get()) {
                    UserFollowing::where(['following_user_id' => $request->user_id, 'user_id' => Auth::guard('api')->id()])->delete();
//                    }
                    $this->message = "You blocked $user->name.";
                } else {
                    $this->status_code = 202;
                    $this->message = "Some error occured";
                }
            } else {
                $unblock = Blocked::where(['user_id' => Auth::guard('api')->id(), 'blocked_user_id' => $request->user_id])->delete();
                if ($unblock) {
                    $this->message = "You unblocked $user->name.";
                } else {
                    $this->status_code = 202;
                    $this->message = "Some error occured";
                }
            }
        }
        return $this->populateResponse();
    }

    public function searchUser(Request $request) {
        $validate = Validator::make($request->all(), [
            'search_name' => 'required'
        ], [
            'search_name.required' => trans('validation.required', ['attribute' => 'search_name'])
        ]);
        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
            $this->status = true;
            $foundUsers = [];
            $searchUser = Users::select('id as user_id', 'name', 'username', 'image', 'country', 'country_code')->where('name', 'like', '%' . $request->search_name . '%')->orWhere('username', 'like', '%' . $request->search_name . '%')->get();
            if ($searchUser) {
                foreach ($searchUser as $user) {
                    if ($user->image == null) {
                        $user->image = url('assets/images/dummy2.jpg');
                    }
                    $country = Country::where(['country' => $user->country, 'country_code' => $user->country_code])->first();
                    if ($country) {
                        $user->flag = url($country->flag);
                    } else {
                        $user->flag = url('/assets/images/flag.png');
                    }
                    if ((Auth::guard('api')->id() != $user->user_id) && (!$this->checkIfBlocked($user->user_id, Auth::guard('api')->id())) && (!$this->checkIfBlocked(Auth::guard('api')->id(), $user->user_id))) {
                        array_push($foundUsers, $user);
                    }
                }
            }
            if ($foundUsers) {
                $this->message = "All users found with name";
                $response = new \Lib\PopulateResponse($foundUsers);
                $this->data = $response->apiResponse();
            } else {
                $this->status_code = 202;
                $this->message = "no users found with this name";
            }
        }
        return $this->populateResponse();
    }

    public function getVideoDetail($getPost) {
        $getPost->fan = 0;
        $getPost->is_favourite = 0;

        $total_fans = UserFollowing::where(['following_user_id' => $getPost->user_id])->get();
        if ($total_fans) {
            $getPost->fan = count($total_fans);
        }
        if ($getPost->image == null) {
            $getPost->image = url('assets/images/dummy2.jpg');
        }
        $country = Country::where(['country' => $getPost->country, 'country_code' => $getPost->country_code])->first();
        if ($country) {
            $getPost->flag = url($country->flag);
        } else {
            $getPost->flag = url('/assets/images/flag.png');
        }
        if ($getPost->category_id) {
            $category = Category::where('id', $getPost->category_id)->get()->first();
            if ($category) {
                $getPost->category_name = $category->name;
            } else {
                $getPost->category_name = "N/A";
            }
        } else {
            $getPost->category_name = "";
        }
        $getPost->comments = 0;
        $data = Comment::where('post_id', $getPost->id)->where('comments.comment_id', '0')->where('comments.status', '1')->get();
        $getPost->comments = count($data);
        $getPost->total_likes = count($this->getLikeList($getPost->id, 0));
        $getPost->likes = $this->getLikeList($getPost->id, 4);
        $getPost->is_liked = 0;
        $getPost->is_viewed = 0;
        $getPost->is_fan = 0;
        $getPost->participants = 0;
        $getPost->participant_videos = [];
        if ($getPost->video_type == '2') {
            $participants = [];
//            $data = ChallengeParticipant::select('challenge_participants.id', 'challenge_participants.user_id', 'title', 'description', 'thumbnail', 'video', 'challenge_participants.created_at', 'username', 'name', 'image', 'country', 'country_code')->where('post_id', $getPost->id)->where('challenge_participants.status', '1')->join('users', 'users.id', '=', 'challenge_participants.user_id')->orderBy('id', 'DESC')->get();
//            echo '<pre>';print_r($data);die;
            $data = Post::select('posts.id', 'user_id', 'title', 'description', 'thumbnail', 'video', 'posts.created_at', 'username', 'name', 'image', 'country', 'country_code')->where('parent_post_id', $getPost->id)->where(['posts.status'=>'1','users.status'=>'1'])->join('users', 'users.id', '=', 'posts.user_id')->orderBy('posts.id', 'DESC')->get();
            if ($data) {
                foreach ($data as $row) {
                    $is_blocked = $this->checkIfBlocked(Auth::guard('api')->id(), $row['user_id']);            // you blocked user
                    $if_blocked = $this->checkIfBlocked($row['user_id'], Auth::guard('api')->id());           // user blocked you
                    if (!$is_blocked && !$if_blocked) {
                        if ($row->image == null) {
                            $row->image = url('assets/images/dummy2.jpg');
                        }
                        $country = Country::where(['country' => $row->country, 'country_code' => $row->country_code])->first();
                        if ($country) {
                            $row->flag = url($country->flag);
                        } else {
                            $row->flag = url('/assets/images/flag.png');
                        }
                        $getPost->participants++;
                        if (count($participants) < 4) {
                            array_push($participants, $row);
                        }
                    }
                }
                $getPost->participant_videos = $participants;
            }
        }
        if (Auth::guard('api')->id()) {
            if (Like::where(['post_id' => $getPost->id, 'user_id' => Auth::guard('api')->id()])->first()) {
                $getPost->is_liked = 1;
            }
            if (PostView::where(['post_id' => $getPost->id])->whereRaw("FIND_IN_SET(" . Auth::guard('api')->id() . ", user_id)")->first()) {
                $getPost->is_viewed = 1;
            }
            if (UserFollowing::where(['user_id' => Auth::guard('api')->id(), 'following_user_id' => $getPost->user_id])->first()) {
                $getPost->is_fan = 1;
            }
            if (Favourite::where(['user_id' => Auth::guard('api')->id(), 'post_id' => $getPost->id])->first()) {
                $getPost->is_favourite = 1;
            }
        }
        return $getPost;
    }

    public function taggedVideos(Request $request) {
        $start = 0;
        if ($request->start) {
            $start = $request->start * 10;
        }
        $postList = [];
        $myTags = Post::select('posts.id', 'posts.user_id', 'video_privacy', 'video_type', 'category_id', 'title', 'description', 'thumbnail', 'video', 'total_views', 'tags', 'posts.created_at', 'username', 'name', 'image', 'country', 'country_code')->where('posts.status', '1')->whereRaw("FIND_IN_SET(" . Auth::guard('api')->id() . ", tags)")->join('users', 'users.id', '=', 'posts.user_id')->orderBy('posts.id', 'DESC')->limit(10)->offset($start)->get();
        if ($myTags) {
            foreach ($myTags as $post) {
                $ifBlocked = $this->checkIfBlocked($post->user_id, Auth::guard('api')->id());
                if (!$ifBlocked) {
                    $post = $this->getVideoDetail($post);
                    $tagged_users = [];
                    if ($post->tags) {
                        $tagged_people = explode(',', $post->tags);
                        foreach ($tagged_people as $tagged) {
                            $user = Users::select('id as user_id', 'name', 'username', 'country', 'image')->where('id', $tagged)->first();
                            if ($user) {
                                if ($user->image == null) {
                                    $user->image = url('assets/images/dummy2.jpg');
                                }
                                array_push($tagged_users, $user);
                            }
                        }
                    }
                    $post->tagged_users = $tagged_users;
                    array_push($postList, $post);
                }
            }
        }

        $this->status = true;
        $this->message = "Tagged Videos.";
        $data['tagged_videos'] = $postList;
        $response = new \Lib\PopulateResponse($postList);
        $this->data = $response->apiResponse();

        return $this->populateResponse();
    }

    public function exploreVideos(Request $request) {
        $validate = Validator::make($request->all(), [
            'country' => 'required',
            'video_privacy' => 'required',
            'sort_type' => 'required',
        ], [
            'country.required' => trans('validation.required', ['attribute' => 'country']),
            'video_privacy.required' => trans('validation.required', ['attribute' => 'video_privacy']),
            'sort_type.required' => trans('validation.required', ['attribute' => 'sort_type']),
        ]);
        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
            $start = 0;
            if ($request->start) {
                $start = $request->start * 10;
            }
            $postList = [];
            
            // echo $category_condition;die;
            if ($request->video_privacy == 1) {
                if ($request->sort_type == 1) {
                    $newVideos = Post::select('posts.id', 'posts.user_id', 'video_privacy', 'video_type', 'category_id', 'title', 'description', 'thumbnail', 'video', 'total_views', 'tags', 'posts.created_at', 'username', 'name', 'image', 'country', 'country_code')->selectRaw('(SELECT COUNT(*) FROM likes WHERE post_id=posts.id) as total_likes')->where(['country' => $request->country, 'posts.status' => '1','posts.parent_post_id'=>'0'])
                    ->when($request->category_id, function ($query) use ($request) {
                        if($request->category_id){
                            $query->where('posts.category_id', $request->category_id);
                        }
                    })->join('users', 'users.id', '=', 'posts.user_id')->orderBy('total_likes', 'DESC')->limit(10)->offset($start)->get();
                } else {
                    $newVideos = Post::select('posts.id', 'posts.user_id', 'video_privacy', 'video_type', 'category_id', 'title', 'description', 'thumbnail', 'video', 'total_views', 'tags', 'posts.created_at', 'username', 'name', 'image', 'country', 'country_code')->where(['country' => $request->country, 'posts.status' => '1','posts.parent_post_id'=>'0'])
                    ->when($request->category_id, function ($query) use ($request) {
                        if($request->category_id){
                            $query->where('posts.category_id', $request->category_id);
                        }
                    })->join('users', 'users.id', '=', 'posts.user_id')->orderBy('total_views', 'DESC')->limit(10)->offset($start)->get();
                }
            } else {
                if ($request->sort_type == 1) {
                    $newVideos = Post::select('posts.id', 'posts.user_id', 'video_privacy', 'video_type', 'category_id', 'title', 'description', 'thumbnail', 'video', 'total_views', 'tags', 'posts.created_at', 'username', 'name', 'image', 'country', 'country_code')->selectRaw('(SELECT COUNT(*) FROM likes WHERE post_id=posts.id) as total_likes')->where(['video_privacy' => '2', 'posts.status' => '1'])
                    ->when($request->category_id, function ($query) use ($request) {
                        if($request->category_id){
                            $query->where('posts.category_id', $request->category_id);
                        }
                    })->join('users', 'users.id', '=', 'posts.user_id')->orderBy('total_likes', 'DESC')->limit(10)->offset($start)->get();
                } else {
                    $newVideos = Post::select('posts.id', 'posts.user_id', 'video_privacy', 'video_type', 'category_id', 'title', 'description', 'thumbnail', 'video', 'total_views', 'tags', 'posts.created_at', 'username', 'name', 'image', 'country', 'country_code')->where(['video_privacy' => '2', 'posts.status' => '1'])
                    ->when($request->category_id, function ($query) use ($request) {
                        if($request->category_id){
                            $query->where('posts.category_id', $request->category_id);
                        }
                    })->join('users', 'users.id', '=', 'posts.user_id')->orderBy('total_views', 'DESC')->limit(10)->offset($start)->get();
                }
            }
            if ($newVideos) {
                foreach ($newVideos as $post) {
                    $ifBlocked = $this->checkIfBlocked($post->user_id, Auth::guard('api')->id());
                    if (!$ifBlocked) {
                        $post = $this->getVideoDetail($post);
                        $tagged_users = [];
//                        if ($post->tags) {
//                            $tagged_people = explode(',', $post->tags);
//                            foreach ($tagged_people as $tagged) {
//                                $user = Users::select('id as user_id', 'name', 'username', 'country', 'image')->where('id', $tagged)->first();
//                                if ($user) {
//                                    array_push($tagged_users, $user);
//                                }
//                            }
//                        }
                        $post->tagged_users = $tagged_users;
                        array_push($postList, $post);
                    }
                }
            }

            $this->status = true;
            $this->message = "Explore Videos.";
            $data['explore_videos'] = $postList;
            $response = new \Lib\PopulateResponse($postList);
            $this->data = $response->apiResponse();
        }
        return $this->populateResponse();
    }

    public function updateView(Request $request) {
        $validate = Validator::make($request->all(), [
            'post_id' => 'required'
        ], [
            'post_id.required' => trans('validation.required', ['attribute' => 'post_id'])
        ]);
        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
            $postViews = PostView::where(['post_id' => $request->post_id])->first();
            if ($postViews) {
                $views = explode(',', $postViews->user_id);
                if (in_array(Auth::guard('api')->id(), $views)) {

                } else {
                    array_push($views, Auth::guard('api')->id());
                }
                Post::where('id', $request->post_id)->update(['total_views' => count($views)]);
                $views = trim(implode(',', $views), ',');
                $update = PostView::where('post_id', $request->post_id)->update(['user_id' => $views]);
            } else {
                $insert = [
                    'post_id' => $request->post_id,
                    'user_id' => Auth::guard('api')->id()
                ];
                $update = PostView::create($insert);
                Post::where('id', $request->post_id)->update(['total_views' => 1]);
            }
            if ($update) {
                $this->message = "Post views updated.";
            } else {
                $this->status_code = 202;
                $this->message = "Some error occured.";
            }
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function userFollowings(Request $request) {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required'
        ], [
            'user_id.required' => trans('validation.required', ['attribute' => 'user_id'])
        ]);
        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
            $followings = [];
            $myFollowings = UserFollowing::select('users.id as user_id', 'name', 'username', 'country', 'country_code', 'image')->where(['user_id' => $request->user_id])->join('users', 'users.id', '=', 'user_followings.following_user_id')->get();
            if ($myFollowings) {
                foreach ($myFollowings as $following) {
                    $is_blocked = $this->checkIfBlocked(Auth::guard('api')->id(), $following->following_user_id);            // you blocked user
                    $if_blocked = $this->checkIfBlocked($following->following_user_id, Auth::guard('api')->id());           // user blocked you
                    if (!$is_blocked && !$if_blocked) {
                        if ($following->image == null) {
                            $following->image = url('assets/images/dummy2.jpg');
                        }
                        $country = Country::where(['country' => $following->country, 'country_code' => $following->country_code])->first();
                        if ($country) {
                            $following->flag = url($country->flag);
                        } else {
                            $following->flag = url('/assets/images/flag.png');
                        }
                        array_push($followings, $following);
                    }
                }
            }
            $this->status = true;
            $this->message = "User Followings";
            $data = $followings;
            $response = new \Lib\PopulateResponse($followings);
            $this->data = $response->apiResponse();
        }
        return $this->populateResponse();
    }

    public function userFans(Request $request) {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required'
        ], [
            'user_id.required' => trans('validation.required', ['attribute' => 'user_id'])
        ]);
        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
            $followings = [];
            $myFollowings = UserFollowing::select('users.id as user_id', 'name', 'username', 'country', 'country_code', 'image')->where(['following_user_id' => $request->user_id])->join('users', 'users.id', '=', 'user_followings.user_id')->get();
            if ($myFollowings) {
                foreach ($myFollowings as $following) {
                    $is_blocked = $this->checkIfBlocked(Auth::guard('api')->id(), $following->user_id);            // you blocked user
                    $if_blocked = $this->checkIfBlocked($following->user_id, Auth::guard('api')->id());           // user blocked you
                    if (!$is_blocked && !$if_blocked) {
                        if ($following->image == null) {
                            $following->image = url('assets/images/dummy2.jpg');
                        }
                        $country = Country::where(['country' => $following->country, 'country_code' => $following->country_code])->first();
                        if ($country) {
                            $following->flag = url($country->flag);
                        } else {
                            $following->flag = url('/assets/images/flag.png');
                        }
                        array_push($followings, $following);
                    }
                }
            }
            $this->status = true;
            $this->message = "User Fans";
            $data = $followings;
            $response = new \Lib\PopulateResponse($followings);
            $this->data = $response->apiResponse();
        }
        return $this->populateResponse();
    }

    public function userVideos(Request $request) {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
            'video_type' => 'required'
        ], [
            'user_id.required' => trans('validation.required', ['attribute' => 'user_id']),
            'video_type.required' => trans('validation.required', ['attribute' => 'video_type'])
        ]);
        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
            $start = 0;
            if ($request->start) {
                $start = $request->start * 9;
            }
            $postList = [];
            if($request->video_type == 1){
                $recentPosts = Post::select('posts.id', 'user_id', 'video_privacy', 'video_type', 'category_id', 'title', 'description', 'thumbnail', 'video', 'total_views', 'tags', 'posts.created_at', 'username', 'name', 'image', 'country', 'country_code')->where(['user_id' => $request->user_id, 'video_type' => '3', 'posts.status' => '1'])->join('users', 'users.id', '=', 'posts.user_id')->orderBy('posts.id', 'DESC')->limit(9)->offset($start)->get();
            }else{
                $recentPosts = Post::select('posts.id', 'user_id', 'video_privacy', 'video_type', 'category_id', 'title', 'description', 'thumbnail', 'video', 'total_views', 'tags', 'posts.created_at', 'username', 'name', 'image', 'country', 'country_code')->where(['user_id' => $request->user_id, 'video_type' => '2', 'posts.status' => '1','parent_post_id'=>'0'])->join('users', 'users.id', '=', 'posts.user_id')->orderBy('posts.id', 'DESC')->limit(9)->offset($start)->get();
            }

            if ($recentPosts) {
                foreach ($recentPosts as $post) {
                    $post = $this->getVideoDetail($post);
                    array_push($postList, $post);
                }
            }
            $data['my_videos'] = $postList;
            $this->status = true;
            $response = new \Lib\PopulateResponse($postList);
            $this->data = $response->apiResponse();

            $this->message = "Fetching user videos";
        }
        return $this->populateResponse();
    }

    public function checkIfBlocked($first_user_id, $second_user_id) {
        // first_user_id blocked second_user_id
        if (Blocked::where(['user_id' => $first_user_id, 'blocked_user_id' => $second_user_id])->first()) {
            return true;
        } else {
            return false;
        }
    }

    public function acceptChallenge(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'post_id' => 'required',
//            'title' => 'required',
//            'description' => 'required',
            'thumbnail' => 'required',
            'video' => 'required|file|max:30720',
        ], [
            'post_id.required' => trans('validation.required', ['attribute' => 'post_id']),
//            'title.required' => trans('validation.required', ['attribute' => 'title']),
//            'description.required' => trans('validation.required', ['attribute' => 'description']),
            'thumbnail.required' => trans('validation.required', ['attribute' => 'thumbnail']),
            'video.required' => trans('validation.required', ['attribute' => 'video']),
            'video.file' => trans('validation.file', ['attribute' => 'video']),
            'video.max' => "The video may not be greater than 30MB.",
        ]);

        $validatedData->after(function ($validatedData) use ($request) {
            if ($request->post_id) {
                $post = Post::where('id', $request->post_id)->where('status', '1')->first();
                if (empty($post)) {
                    $validatedData->errors()->add('post_id', 'This video is removed.');
                }
            }
        });

        if ($validatedData->fails()) {
            $this->status_code = 201;
            $this->message = $validatedData->errors();
        } else {
            $post = Post::where('id', $request->post_id)->where('status', '1')->first();
            if ($request->thumbnail && $request->video) {
                $response = $this->store($request);
                $thumbnail = $response['thumbnail'];
                $video = $response['video'];
            } else {
                $thumbnail = "";
                $video = "";
            }
            $insert = [
                'user_id' => Auth::guard('api')->id(),
                'parent_post_id' => $request->post_id,
                'title' => $post->title,
                'description' => $post->description,
                'video_privacy' => $post->video_privacy,
                'video_type' => 3,
                'category_id' => $post->category_id,
                'thumbnail' => $thumbnail,
                'video' => $video,
//                'created_at' => date('Y-m-d H:i:s'),
//                'updated_at' => date('Y-m-d H:i:s')
            ];
//            $data = ChallengeParticipant::insert($insert);
            $data = Post::create($insert);
            if ($data) {
                

                $Finduser = Users::find($post->user_id);
                $userParticipated=Users::find(Auth::guard('api')->id());
                // $title = __('front/errors/validation.plan_upgraded_successfully');
                $notificationTitle = 'Video upload';
                $notificationMessage = '@'.$userParticipated->username.' has uploaded their video on your challenge';
                $notificationType = 'accept-challenge';
                $sendData = [
                    'id' => $post->id
                ];
                if($Finduser->push_notification == 'on'){
                    $notifiable=true;
                }else{
                    $notifiable=false;
                }
                sendNotification($Finduser->id, $Finduser->device_token, $notificationTitle, $notificationMessage, $notificationType, $sendData, $notifiable);
                
                $this->data = $data;
                $this->message = 'Participation video updated successfully';
            } else {
                $this->message = 'Server could not get any response. Please try again later.';
                $this->status_code = 201;
            }
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function participants(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'post_id' => 'required'
        ], [
            'post_id.required' => trans('validation.required', ['attribute' => 'post_id'])
        ]);

        $validatedData->after(function ($validatedData) use ($request) {
            if ($request->post_id) {
                $post = Post::where('id', $request->post_id)->where('status', '1')->first();
                if (empty($post)) {
                    $validatedData->errors()->add('post_id', 'This video is removed.');
                }
            }
        });

        if ($validatedData->fails()) {
            $this->status_code = 201;
            $this->message = $validatedData->errors();
        } else {
            $start = 0;
            if ($request->start) {
                $start = $request->start * 10;
            }
            $participants = [];
//            $data = ChallengeParticipant::select('challenge_participants.id', 'challenge_participants.user_id', 'title', 'description', 'thumbnail', 'video', 'challenge_participants.created_at', 'username', 'name', 'image', 'country', 'country_code')->where('post_id', $request->post_id)->where('challenge_participants.status', '1')->join('users', 'users.id', '=', 'challenge_participants.user_id')->orderBy('id', 'DESC')->limit(5)->offset($start)->get();
            $data = Post::select('posts.id', 'user_id', 'title', 'description', 'thumbnail', 'video', 'posts.created_at', 'username', 'name', 'image', 'country', 'country_code')->where('parent_post_id', $request->post_id)->where(['posts.status'=>'1','users.status'=>'1'])->join('users', 'users.id', '=', 'posts.user_id')->orderBy('posts.id', 'DESC')
            // ->limit(5)->offset($start)
            ->get();
            if ($data) {
                foreach ($data as $row) {

                    $is_blocked = $this->checkIfBlocked(Auth::guard('api')->id(), $row['user_id']);            // you blocked user
                    $if_blocked = $this->checkIfBlocked($row['user_id'], Auth::guard('api')->id());           // user blocked you
                    if (!$is_blocked && !$if_blocked) {
                        if ($row->image == null) {
                            $row->image = url('assets/images/dummy2.jpg');
                        }
                        $country = Country::where(['country' => $row->country, 'country_code' => $row->country_code])->first();
                        if ($country) {
                            $row->flag = url($country->flag);
                        } else {
                            $row->flag = url('/assets/images/flag.png');
                        }
                        $row->is_fan=0;
                        $row->is_favourite = 0;
                        $total_fans = UserFollowing::where(['following_user_id' => $row->user_id])->get();
                        if ($total_fans) {
                            $row->fan = count($total_fans);
                        }
                        if ($row->category_id) {
                            $category = Category::where('id', $row->category_id)->get()->first();
                            if ($category) {
                                $row->category_name = $category->name;
                            } else {
                                $row->category_name = "N/A";
                            }
                        } else {
                            $row->category_name = "";
                        }
                        $row->comments = 0;
                        $data = Comment::where('post_id', $row->id)->where('comments.comment_id', '0')->where('comments.status', '1')->get();
                        $row->comments = count($data);
                        $row->total_likes = count($this->getLikeList($row->id, 0));
                        $row->likes = $this->getLikeList($row->id, 4);
                        $row->is_liked = 0;
                        $row->is_viewed = 0;
                        $row->is_fan = 0;
                        $row->participants = 0;
                        $row->participant_videos = [];
                        if (Auth::guard('api')->id()) {
                            if (Like::where(['post_id' => $row->id, 'user_id' => Auth::guard('api')->id()])->first()) {
                                $row->is_liked = 1;
                            }
                            if (PostView::where(['post_id' => $row->id])->whereRaw("FIND_IN_SET(" . Auth::guard('api')->id() . ", user_id)")->first()) {
                                $row->is_viewed = 1;
                            }
                            if (UserFollowing::where(['user_id' => Auth::guard('api')->id(), 'following_user_id' => $row->user_id])->first()) {
                                $row->is_fan = 1;
                            }
                            if (Favourite::where(['user_id' => Auth::guard('api')->id(), 'post_id' => $row->id])->first()) {
                                $row->is_favourite = 1;
                            }
                        }
                        // if (UserFollowing::where(['user_id' => Auth::guard('api')->id(), 'following_user_id' => $row['user_id']])->first()) {
                        //     $row->is_fan = 1;
                        // }
                        array_push($participants, $row);
                    }
                }
                $this->data = $participants;
                $this->message = "Participation's videos";
            }
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function deleteMyVideo(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'post_id' => 'required',
            'type' => 'required'
        ], [
            'post_id.required' => trans('validation.required', ['attribute' => 'post_id']),
            'type.required' => trans('validation.required', ['attribute' => 'type'])
        ]);
        $validatedData->after(function ($validatedData) use ($request) {
            if ($request->post_id) {
//                if ($request->type == 1) {
                    $post = Post::where('id', $request->post_id)->where('user_id', Auth::guard('api')->id())->first();
                    if (empty($post)) {
                        $validatedData->errors()->add('post_id', 'video not found.');
                    }
//                } else {
//                    $post = ChallengeParticipant::where('id', $request->post_id)->where('user_id', Auth::guard('api')->id())->first();
//                    if (empty($post)) {
//                        $validatedData->errors()->add('post_id', 'video not found.');
//                    }
//                }
            }
        });

        if ($validatedData->fails()) {
            $this->status_code = 201;
            $this->message = $validatedData->errors();
        } else {
//            if ($request->type == 1) {
                $update = Post::where('id', $request->post_id)->where('user_id', Auth::guard('api')->id())->update(['status' => '3']);
//            } else {
//                $update = ChallengeParticipant::where('id', $request->post_id)->where('user_id', Auth::guard('api')->id())->update(['status' => '3']);
//            }
            if ($update) {
                $this->message = 'Video deleted successfully';
            } else {
                $this->message = 'Server could not get any response. Please try again later.';
                $this->status_code = 201;
            }
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function deleteParticipationVideo(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'post_id' => 'required'
        ], [
            'post_id.required' => trans('validation.required', ['attribute' => 'post_id'])
        ]);
        $validatedData->after(function ($validatedData) use ($request) {
            if ($request->post_id) {
//                $post = ChallengeParticipant::where('id', $request->post_id)->first();
                $post = Post::where('id', $request->post_id)->first();
                if (empty($post)) {
                    $validatedData->errors()->add('post_id', 'video not found.');
                } else {
                    $post = Post::where('id', $post->parent_post_id)->first();
                    if ($post->user_id != Auth::guard('api')->id()) {
                        $validatedData->errors()->add('post_id', 'Cannot delete participant only post creator can remove participation videos.');
                    }
                }
            }
        });

        if ($validatedData->fails()) {
            $this->status_code = 201;
            $this->message = $validatedData->errors();
        } else {
//            $update = ChallengeParticipant::where('id', $request->post_id)->update(['status' => '3']);
            $update = Post::where('id', $request->post_id)->update(['status' => '3']);
            if ($update) {
                $this->message = 'Video deleted successfully';
            } else {
                $this->message = 'Server could not get any response. Please try again later.';
                $this->status_code = 201;
            }
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function addComment(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'post_id' => 'required',
            'comment' => 'required'
        ], [
            'post_id.required' => trans('validation.required', ['attribute' => 'post_id']),
            'comment.required' => trans('validation.required', ['attribute' => 'comment'])
        ]);
        $validatedData->after(function ($validatedData) use ($request) {
            if ($request->post_id) {
                $post = Post::where('id', $request->post_id)->where('status', '1')->first();
                if (empty($post)) {
                    $validatedData->errors()->add('post_id', 'This video is removed.');
                }
            }
        });

        if ($validatedData->fails()) {
            $this->status_code = 201;
            $this->message = $validatedData->errors();
        } else {
            $insert = [
                'user_id' => Auth::guard('api')->id(),
                'post_id' => $request->post_id,
                'comment_id' => $request->comment_id,
                'comment' => $request->comment,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            if ($request->comment_id) {
                $getComment = Comment::where(['id' => $request->comment_id, 'status' => 1])->first();
                if ($getComment) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            } else {
                $flag = true;
            }
            if ($flag) {
                $data = Comment::insertGetId($insert);
                if ($data) {
                    $post = Post::where('id', $request->post_id)->where('status', '1')->first();
                    $Finduser = Users::find($post->user_id);
                    $userComment=Users::find(Auth::guard('api')->id());
                    // $title = __('front/errors/validation.plan_upgraded_successfully');
                    $notificationTitle = 'Post Comment';
                    $notificationMessage = '@'.$userComment->username.' commented on your post';
                    $notificationType = 'post-comment';
                    $sendData = [
                        'id' => $post->id
                    ];

                    if($post->user_id != Auth::guard('api')->id()){
                        if($Finduser->push_notification == 'on'){
                            $notifiable=true;
                        }else{
                            $notifiable=false;
                        }
                        sendNotification($Finduser->id, $Finduser->device_token, $notificationTitle, $notificationMessage, $notificationType, $sendData, $notifiable);
                    }
                    $comment = ['comment_id' => $data, 'comment' => $request->comment];
                    $response = new \Lib\PopulateResponse($comment);
                    $this->data = $response->apiResponse();
                    $this->message = 'Comment posted successfully';
                } else {
                    $this->message = 'Server could not get any response. Please try again later.';
                    $this->status_code = 201;
                }
            } else {
                $this->message = 'Server could not get any response. Please try again later.';
                $this->status_code = 201;
            }
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function commentList(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'post_id' => 'required'
        ], [
            'post_id.required' => trans('validation.required', ['attribute' => 'post_id'])
        ]);

        $validatedData->after(function ($validatedData) use ($request) {
            if ($request->post_id) {
                $post = Post::where('id', $request->post_id)->where('status', '1')->first();
                if (empty($post)) {
                    $validatedData->errors()->add('post_id', 'This video is removed.');
                }
            }
        });

        if ($validatedData->fails()) {
            $this->status_code = 201;
            $this->message = $validatedData->errors();
        } else {
            $start = 0;
            if ($request->start) {
                $start = $request->start * 10;
            }
            $comments = [];
            $data = Comment::select('comments.id', 'comments.user_id', 'post_id', 'comment', 'comments.created_at', 'username', 'name', 'image', 'country', 'country_code')->selectRaw('(SELECT COUNT(*) FROM comment_likes WHERE post_id=comments.post_id AND comment_id=comments.id) as total_likes')->where('post_id', $request->post_id)->where('comments.comment_id', '0')->where('comments.status', '1')->join('users', 'users.id', '=', 'comments.user_id')->orderBy('id', 'DESC')
            // ->limit(10)->offset($start)
            ->get();
            if ($data) {
                foreach ($data as $row) {
                    $is_blocked = $this->checkIfBlocked(Auth::guard('api')->id(), $row['user_id']);            // you blocked user
                    $if_blocked = $this->checkIfBlocked($row['user_id'], Auth::guard('api')->id());           // user blocked you
                    if (!$is_blocked && !$if_blocked) {
                        if ($row['image'] == null) {
                            $row['image'] = url('assets/images/dummy2.jpg');
                        }
                        $country = Country::where(['country' => $row['country'], 'country_code' => $row['country_code']])->first();
                        if ($country) {
                            $row['flag'] = url($country->flag);
                        } else {
                            $row['flag'] = url('/assets/images/flag.png');
                        }

                        $row['is_liked'] = 0;
                        if (Auth::guard('api')->id()) {
                            if (CommentLike::where(['user_id' => Auth::guard('api')->id(), 'comment_id' => $row['id']])->first()) {
                                $row['is_liked'] = 1;
                            }
                        }
                        $row['reply'] = [];
                        $thread = [];
                        $threads = Comment::select('comments.id', 'comments.user_id', 'post_id', 'comment', 'comments.created_at', 'username', 'name', 'image', 'country', 'country_code')->selectRaw('(SELECT COUNT(*) FROM comment_likes WHERE post_id=comments.post_id AND comment_id=comments.id) as total_likes')->where('post_id', $request->post_id)->where('comments.comment_id', $row['id'])->where('comments.status', '1')->join('users', 'users.id', '=', 'comments.user_id')->orderBy('id', 'DESC')->get();
                        if ($threads) {
                            foreach ($threads as $rows) {
                                $is_blocked = $this->checkIfBlocked(Auth::guard('api')->id(), $rows['user_id']);            // you blocked user
                                $if_blocked = $this->checkIfBlocked($rows['user_id'], Auth::guard('api')->id());           // user blocked you
                                if (!$is_blocked && !$if_blocked) {
                                    if ($rows['image'] == null) {
                                        $rows['image'] = url('assets/images/dummy2.jpg');
                                    }
                                    $country = Country::where(['country' => $rows['country'], 'country_code' => $rows['country_code']])->first();
                                    if ($country) {
                                        $rows['flag'] = url($country->flag);
                                    } else {
                                        $rows['flag'] = url('/assets/images/flag.png');
                                    }
                                    $rows['is_liked'] = 0;
                                    if (Auth::guard('api')->id()) {
                                        if (CommentLike::where(['user_id' => Auth::guard('api')->id(), 'comment_id' => $rows['id']])->first()) {
                                            $rows['is_liked'] = 1;
                                        }
                                    }
                                    array_push($thread, $rows);
                                }
                            }
                        }
                        $row['reply'] = $thread;
                        array_push($comments, $row);
                    }
                }
                $this->data = $comments;
                $this->message = "Post comments";
            }
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function likeComment(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'post_id' => 'required',
            'comment_id' => 'required',
        ], [
            'post_id.required' => trans('validation.required', ['attribute' => 'post_id']),
            'comment_id.required' => trans('validation.required', ['attribute' => 'comment_id'])
        ]);

        if ($validatedData->fails()) {
            $this->status_code = 201;
            $this->message = $validatedData->errors();
        } else {
            if (CommentLike::where(['user_id' => Auth::guard('api')->id(), 'post_id' => $request->post_id, 'comment_id' => $request->comment_id])->first()) {
                $delete = CommentLike::where(['user_id' => Auth::guard('api')->id(), 'post_id' => $request->post_id, 'comment_id' => $request->comment_id])->delete();
                if ($delete) {
                    $this->message = 'Your like removed from the comment';
                } else {
                    $this->message = 'Server could not get any response. Please try again later.';
                    $this->status_code = 201;
                }
            } else {
                $insert = [
                    'user_id' => Auth::guard('api')->id(),
                    'post_id' => $request->post_id,
                    'comment_id' => $request->comment_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $data = CommentLike::insert($insert);
                if ($data) {
                    $this->message = 'You liked comment';
                } else {
                    $this->message = 'Server could not get any response. Please try again later.';
                    $this->status_code = 201;
                }
            }
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function commentLikes(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'post_id' => 'required',
            'comment_id' => 'required',
        ], [
            'post_id.required' => trans('validation.required', ['attribute' => 'post_id']),
            'comment_id.required' => trans('validation.required', ['attribute' => 'comment_id'])
        ]);

        if ($validatedData->fails()) {
            $this->status_code = 201;
            $this->message = $validatedData->errors();
        } else {
            $likedUsers = [];
            $likes = CommentLike::select('users.id as user_id', 'name', 'username', 'country', 'country_code', 'image')->where(['post_id' => $request->post_id, 'comment_id' => $request->comment_id])->join('users', 'users.id', '=', 'comment_likes.user_id')->get();
            if ($likes) {
                foreach ($likes as $row) {
                    $is_blocked = $this->checkIfBlocked(Auth::guard('api')->id(), $row['user_id']);            // you blocked user
                    $if_blocked = $this->checkIfBlocked($row['user_id'], Auth::guard('api')->id());           // user blocked you
                    if (!$is_blocked && !$if_blocked) {
                        if ($row['image'] == null) {
                            $row['image'] = url('assets/images/dummy2.jpg');
                        }
                        $country = Country::where(['country' => $row['country'], 'country_code' => $row['country_code']])->first();
                        if ($country) {
                            $row['flag'] = url($country->flag);
                        } else {
                            $row['flag'] = url('/assets/images/flag.png');
                        }
                        array_push($likedUsers, $row);
                    }
                }
            }
            $this->data = $likedUsers;
            $this->message = "Comment Likes";
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function helpSupport(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ], [
            'name.required' => trans('validation.required', ['attribute' => 'name']),
            'email.required' => trans('validation.required', ['attribute' => 'email']),
            'email.email' => trans('validation.email', ['attribute' => 'email']),
            'subject.required' => trans('validation.required', ['attribute' => 'subject']),
            'message.required' => trans('validation.required', ['attribute' => 'message'])
        ]);

        if ($validatedData->fails()) {
            $this->status_code = 201;
            $this->message = $validatedData->errors();
        } else {
            $insert = [
                'user_id' => Auth::guard('api')->id(),
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $data = Query::insertGetId($insert);
            if ($data) {
                $this->message = 'Query sent successfully';
            } else {
                $this->message = 'Server could not get any response. Please try again later.';
                $this->status_code = 201;
            }
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function reportPost(Request $request) {
        $validate = Validator::make($request->all(), [
            'post_id' => 'required',
            'reason_id' => 'required',
            'description' => 'required'
        ], [
            'post_id.required' => trans('validation.required', ['attribute' => 'post_id']),
            'reason_id.required' => trans('validation.required', ['attribute' => 'reason']),
            'description.required' => trans('validation.required', ['attribute' => 'description'])
        ]);
        if ($validate->fails()) {
            $this->status_code = 201;
            $this->message = $validate->errors();
        } else {
            $this->status = true;
            $report = Reported::insert([
                'user_id' => Auth::guard('api')->id(),
                'post_id' => $request->post_id,
                'reason_id' => $request->reason_id,
                'description' => $request->description,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            if ($report) {
                $this->message = "You reported this video";
            } else {
                $this->status_code = 201;
                $this->message = "Server could not get any response. Please try again later.";
            }
        }
        return $this->populateResponse();
    }

    public function followingVideos(Request $request) {
        $followings = [];
        $postList = [];
        $myvideos=[];
        $following_id=[];
        $whereCondition="";
        $myFollowings = UserFollowing::select('users.id as user_id', 'name', 'username', 'country', 'country_code', 'image','user_followings.created_at')->where(['user_id' => Auth::guard('api')->id()])->join('users', 'users.id', '=', 'user_followings.following_user_id')->get()->toArray();
        if (!empty($myFollowings)) {
            foreach ($myFollowings as $k=>$following) {
                // array_push($following_id, $following->user_id);
                // array_push($followings, ['user_id'=>$following->user_id,'followed_at'=>$following->created_at]);
                if($k==0){
                    if(count($myFollowings)==1){
                        $whereCondition="(posts.user_id=".$following['user_id']." AND (posts.created_at>='".$following['created_at']."' OR posts.created_at='".$following['created_at']."'))";
                    }else{
                        $whereCondition="((posts.user_id=".$following['user_id']." AND (posts.created_at>='".$following['created_at']."' OR posts.created_at='".$following['created_at']."'))";
                    }
                    
                }else if($k==count($myFollowings)-1  && $k>0){
                    if(count($myFollowings)==1){
                        $whereCondition=$whereCondition." OR (posts.user_id=".$following['user_id']." AND (posts.created_at>'".$following['created_at']."' OR posts.created_at='".$following['created_at']."'))";
                    }else{
                        $whereCondition=$whereCondition." OR (posts.user_id=".$following['user_id']." AND (posts.created_at>'".$following['created_at']."' OR posts.created_at='".$following['created_at']."')))";
                    }
                }else{
                    $whereCondition=$whereCondition." OR (posts.user_id=".$following['user_id']." AND (posts.created_at>'".$following['created_at']."' OR posts.created_at='".$following['created_at']."'))";
                }
                
            }
            $start = 0;
            if ($request->start) {
                $start = $request->start * 10;
            }

            // $myvideos = Post::select('posts.id', 'posts.user_id', 'video_privacy', 'video_type', 'category_id', 'title', 'description', 'thumbnail', 'video', 'total_views', 'tags', 'posts.created_at', 'username', 'name', 'image', 'country', 'country_code')
            // ->where('posts.status', '1')
            // ->where('posts.parent_post_id', '0')
            // ->whereIn('posts.user_id', $followings)
            // ->join('users', 'users.id', '=', 'posts.user_id')
            // ->orderBy('posts.id', 'DESC')
            // ->limit(10)->offset($start)
            // ->get();
           $myvideos = Post::select('posts.id', 'posts.user_id', 'video_privacy', 'video_type', 'category_id', 'title', 'description', 'thumbnail', 'video', 'total_views', 'tags', 'posts.created_at', 'username', 'name', 'image', 'country', 'country_code')
            ->where('posts.status', '1')
            ->where('posts.parent_post_id', '0')
            ->whereRaw($whereCondition)
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->orderBy('posts.id', 'DESC')
            ->limit(10)->offset($start)
            ->get();
            if ($myvideos) {
                foreach ($myvideos as $post) {
                    $ifBlocked = $this->checkIfBlocked($post->user_id, Auth::guard('api')->id());
                    if (!$ifBlocked) {
                        $post = $this->getVideoDetail($post);
                        $tagged_users = [];
                        if ($post->tags) {
                            $tagged_people = explode(',', $post->tags);
                            foreach ($tagged_people as $tagged) {
                                $user = Users::select('id as user_id', 'name', 'username', 'country', 'image')->where('id', $tagged)->first();
                                if ($user) {
                                    if ($user->image == null) {
                                        $user->image = url('assets/images/dummy2.jpg');
                                    }
                                    array_push($tagged_users, $user);
                                }
                            }
                        }
                        $post->tagged_users = $tagged_users;
                        array_push($postList, $post);
                    }
                }
            }
        }
        $this->status = true;
        $this->message = "Following User Videos.";
        $data['tagged_videos'] = $postList;
        $response = new \Lib\PopulateResponse($postList);
        $this->data = $response->apiResponse();

        return $this->populateResponse();
    }

    public function notificationList() {
        $notifications = AppNotification::where('user_id', Auth::guard('api')->id())->where('type', '<>', 'post-tag')->orderBy('id', 'DESC')->get();
        $response = new \Lib\PopulateResponse($notifications);
        $this->data = $response->apiResponse();
        $this->status = true;
        $this->message = "Notification List";
        return $this->populateResponse();
    }

    public function tagNotificationList() {
        $notifications = AppNotification::where('user_id', Auth::guard('api')->id())->where('type', 'post-tag')->orderBy('id', 'DESC')->get();
        $response = new \Lib\PopulateResponse($notifications);
        $this->data = $response->apiResponse();
        $this->status = true;
        $this->message = "Tagged Notification List";
        return $this->populateResponse();
    }

    public function clearNotifications(Request $request) {
        if ($request->notification_id) {
            $this->message = "Notification deleted!";
            $notifications = AppNotification::where('id', $request->notification_id)->where('user_id', Auth::guard('api')->id())->delete();
        } else {
            $this->message = "Notification list cleared!";
            $notifications = AppNotification::where('user_id', Auth::guard('api')->id())->delete();
        }
        $this->status = true;
        if ($notifications) {

        } else {
            // $this->status_code = 201;
            // $this->message = "Server could not get any response. Please try again later.";
        }
        return $this->populateResponse();
    }

    public function reportReasons() {
        $reasons = ReportReason::select('id','reason as name','status','created_at','updated_at')->where('status', '1')->orderBy('id', 'DESC')->get();
        $response = new \Lib\PopulateResponse($reasons);
        $this->data = $response->apiResponse();
        $this->status = true;
        $this->message = "Reason List";
        return $this->populateResponse();
    }

    public function getLogout() {
//        Auth::logout();
        $data = Users::where('user_id', Auth::guard('api')->id())->update(['device_token' => '']);
        $data = DB::table('oauth_access_tokens')->where('user_id', Auth::guard('api')->id())->update(['revoked' => '1']);
        $this->status = true;
        $this->message = 'Logout Successfull';
        return $this->populateResponse();
    }

    public function store($request) {
//        $thumbnail = $request->file('thumbnail')->store('uploads/video_thumbnail');
//        $video = $request->file('video')->store('uploads/videos');
//        $path = $request->file('image')->store('images', 's3');
//        return Storage::disk('s3')->response('images/' . $image->filename);
        $file = $request->file('video');
        $fullName = $file->getClientOriginalName();
        $stringName = $this->my_random_string(explode('.', $fullName)[0]);
        $explodeName = explode('.', $fullName);
        $filename = $stringName . '.' . end($explodeName);
        $thumbnail = $request->file('thumbnail')->store('video_thumbnail', 's3');
        $thumbnail_url = Storage::disk('s3')->url('video_thumbnail/' . basename($thumbnail));
//        $video = $request->file('video')->store('videos', 's3');
        $video = $request->file('video')->storeAs('videos', $filename, ['disk' => 's3', 'visibility' => 'public']);

        $video_url = Storage::disk('s3')->url('videos/' . basename($video));
        return ['thumbnail' => $thumbnail_url, 'video' => $video_url];
    }


    public function switchPushNotification(){
            $user=Users::select('push_notification')->where('id','=',Auth::guard('api')->id())->first();
            if($user['push_notification'] == 'on'){
                $status='off';
            }else{
                $status='on';
            }
            $user = Users::where('id','=',Auth::guard('api')->id())->update(['push_notification'=>$status]);

            $user=Users::select('push_notification')->where('id','=',Auth::guard('api')->id())->first();
            
            $response = new \Lib\PopulateResponse($user);

            $this->data = $response->apiResponse();
            $this->status   = true;
            $this->message  = 'Data Fetched successfully.';
            return $this->populateResponse();
        }

    
    public function myParticipation(Request $request){
        // $validate = Validator::make($request->all(), [
        //     'video_type' => 'required'
        // ], [
        //     'video_type.required' => 'video_type is required field'
        // ]);
        // if ($validate->fails()) {
        //     $this->status_code = 201;
        //     $this->message = $validate->errors();
        // } else {
            $start = 0;
            if ($request->start) {
                $start = $request->start * 9;
            }
            $postList = [];
            $recentPosts = Post::select('posts.id', 'user_id', 'video_privacy', 'video_type', 'category_id', 'title', 'description', 'thumbnail', 'video', 'total_views', 'tags', 'posts.created_at', 'username', 'name', 'image', 'country', 'country_code')->where(['user_id' => Auth::guard('api')->id(),'video_type' => 3, 'posts.status' => '1'])->join('users', 'users.id', '=', 'posts.user_id')->orderBy('posts.id', 'DESC')->limit(9)->offset($start)->get();
            if ($recentPosts) {
                foreach ($recentPosts as $post) {
                    $post = $this->getVideoDetail($post);
                    array_push($postList, $post);
                }
            }
            $data['my_videos'] = $postList;
            $this->status = true;
            $response = new \Lib\PopulateResponse($postList);
            $this->data = $response->apiResponse();

            $this->message = "Fetching my participation videos";
        // }
        return $this->populateResponse();
    }


}
