@extends('admin.layout.master')
@section('content')
      <div class="admin_main">
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    <strong class="close" data-dismiss="alert" aria-hidden="true"></strong>
                    {{ session()->get('success') }}
                </div>
                @else 
                @if(session()->has('error'))  
                <div class="alert alert-danger">
                    <strong class="close" ></strong>
                    {{ session()->get('error') }}
                </div>
                @endif 
                @endif
               <div class="row">
                  <div class="col-12 editprofile design_outter_comman shadow">
                     <div class="row comman_header justify-content-between">
                        <div class="col-auto">
                           <h2>Edit Profile</h2>
                        </div> 
                     </div>
                     <div class="row justify-content-center">
                        <div class="col-md-6">
                           <form class="row form-design justify-content-center position-relative mx-0 p-4"  method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/edit_profileUpdate',[base64_encode($edit_admin->id)])}}">
                            {{ csrf_field() }} 
                              <div class="form-group col-auto">
                                 <div class="account_profile position-relative">
                                    <div class="circle">
                                       <img class="profile-pic" src="{{$edit_admin->image?$edit_admin->image: asset('assets/img/profile_img1.png')}}"> 
                                    </div>
                                    <div class="p-image">
                                       <i class="upload-button fas fa-camera"></i> 
                                       <input class="file-upload validate" type="file" name="image" accept="image/*">
                                    </div>
                                 </div>
                              </div> 
                              <p class="text-danger" id="imageError" style="text-align:center;"></p>
                              <div class="form-group col-12">
                                 <label for="">Full Name</label>
                                 <input type="text" class="form-control validate" value="{{$edit_admin->name ?: 'N/A' }}"  name="name" id="name">
                                 <p class="text-danger" id="nameError"></p>
                              </div>
                              <div class="form-group col-12 text-center">
                                 <!-- <a class="comman_btn" href="javscript:;">Save</a> -->
                                 <button type="button" onclick="validate(this);" class="comman_btn">Save</button>
                           </div>
                           </form>
                        </div>
                     </div>
                  </div> 
               </div>
            </div>
         </div>
      </div>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script>
 $(window).load(function(){
   setTimeout(function(){ $('.alert-danger').fadeOut('slow') }, 3000);
});
  </script>
   <script>
 $(window).load(function(){
   setTimeout(function(){ $('.alert-success').fadeOut('slow') }, 3000);
});
  </script>
   @endsection
   <script>
            function validate(obj) {
            $(".text-danger").html('');
            var flag = true;
            var formData = $("#addForm").find(".validate:input").not(':input[type=button]');
            $(formData).each(function () {
                var element = $(this);
                var val = element.val();
                var name = element.attr("name");
                if (val == "" || val == "0" || val == null) {
                    
                $("#" + name + "Error").html("This field is required");
                flag = false;
                    
                    
                } else {

                }
            });
           
            if (flag) {
                $("#addForm").submit();
            } else {
                return false;
            }

            
        }
    </script>