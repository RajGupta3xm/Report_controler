<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Content;
use App\Models\SocialLink;
use App\Models\OnboardingScreen;
use DB;

class ContentController extends Controller
{
    public function index() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
             $data['content'] = Content::orderBy('id','asc')->get();
             $data['onboarding_screen'] = OnboardingScreen::select('*')->get();
            //   $data['facebook'] = SocialLink::where('name','facebook')->select('*')->first();
            //   $data['linkedin'] = SocialLink::where('name','linkedin')->select('*')->first();
            //   $data['instagram'] = SocialLink::where('name','instagram')->select('*')->first();
            //   $data['twiter'] = SocialLink::where('name','twiter')->select('*')->first();
               $data['social_link'] = SocialLink::select('*')->first();
             return view('admin.content.content-list')->with($data);
        }
    }

    
    public function update(Request $request, $id=null){
         $data=[
           "content" => $request->input('reply'),
       ];
         $update = Content::find($id)->update($data);
         if($update){
             return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Your content update successfully']);
         }
         else {
             return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while update content']);
         }
    }

    public function updates(Request $request, $id=null){
         $data=[
          "content_ar" => $request->input('reply_ar'),
      ];
        $update = Content::find($id)->update($data);
        if($update){
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Your content update successfully']);
        }
        else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while update content']);
        }
   }

   public function updateOnboarding(Request $request){
    //  $id = $request->input('id');
     foreach ($request->id as $key=>$ids) {
  
                $data['title'] = $request->title[$key];
                $data['title_ar'] = $request->title_ar[$key];

                // if(!empty($request->image[$key])){
                //     $filename = $request->image[$key]->getClientOriginalName();
                //     $imageName = time().'.'.$filename;
                //     if(env('APP_ENV') == 'local'){
                //         $return = $request->image[$key]->move(
                //         base_path() . '/public/uploads/onboarding_screen/', $imageName);
                //     }else{
                //         $return = $request->banner_image->move(
                //         base_path() . '/../public/uploads/onboarding_screen/', $imageName);
                //     }
                //     $url = url('/uploads/onboarding_screen/');
                //     return$data['image'] = $url.'/'. $imageName;
                 
                // }

            $insert = OnboardingScreen::where('id', $request->id[$key])->update($data);
       
    }
   
    if ($insert) {
     return response()->json(['status' => true, 'success_code' => 200, 'message' => 'Onboarding details update successfully']);
 } else {
     return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while update details']);
 }
 }

 public function updateSocialLink(Request $request){
          $data =[
            'facebook_link' => $request->facebook,
           'linkedin_link' =>  $request->linkedin,
           'instagram_link' =>  $request->instagram,
           'twiter_link' =>  $request->twiter,
    
       ];
       $update=SocialLink::where('id',$request->id)->update($data);
    
       if ($update) {
        return redirect()->back()->with('success','Social link update successfully');
     } else {
         return redirect()->back()->with('error', 'Some error occurred while update Social link');
     }
       


  }

  
}
