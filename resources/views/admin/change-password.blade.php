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
                           <h2>Change Password</h2>
                        </div> 
                     </div>
                     <div class="row justify-content-center">
                        <div class="col-md-6">
                           <form class="row form-design justify-content-center position-relative mx-0 p-4"  method="POST" enctype="multipart/form-data" action="{{url('admin/edit_passwordUpdate')}}">
                            {{ csrf_field() }} 
                              <div class="form-group col-12">
                                 <label for="">Old Password</label>
                                 <input type="text" class="form-control  validate "  name="old_password" placeholder="********" id="name">
                                   @if ($errors->has('old_password'))
                                      <span class="help-block">
                                          <strong class="text-danger text-small">{{ $errors->first('old_password') }}</strong>
                                      </span>
                                   @endif
                              </div>
                              <div class="form-group col-12">
                                 <label for="">New Password</label>
                                 <input type="text" class="form-control  validate"  name="new_password" placeholder="********" id="name">
                                  @if ($errors->has('new_password'))
                                        <span class="help-block">
                                            <strong class="text-danger text-small">{{ $errors->first('new_password') }}</strong>
                                       </span>
                                  @endif
                              </div>
                              <div class="form-group col-12">
                                 <label for="">Confirm New Password</label>
                                 <input type="text" class="form-control  validate"  name="confirm_password" placeholder="********" id="name">
                                  @if ($errors->has('confirm_password'))
                                      <span class="help-block">
                                         <strong class="text-danger text-small">{{ $errors->first('confirm_password') }}</strong>
                                     </span>
                                   @endif
                              </div>
                              <div class="form-group col-12 text-center">
                                 <!-- <a class="comman_btn" href="javscript:;">Save</a> -->
                                 <button type="submit"  class="comman_btn">Save</button>
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
   setTimeout(function(){ $('.alert-success').fadeOut('slow') }, 5000);
});
  </script>
      @endsection