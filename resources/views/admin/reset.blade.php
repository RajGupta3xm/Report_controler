@extends('admin.layout.master2')

@section('content')

      <section class="login_page">
         <div class="container-fluid px-0">
            <div class="row justify-content-center"> 
               <div class="col-4">
                  <div class="login_page_form shadow">
                     <div class="row">
                        <div class="col-12 formheader mb-4">
                           <img src="assets/img/logo.png" alt="">
                           <h1>Reset Password</h1>
                           <p>Enter New Password</p>
                        </div>
                        <div class="col-12">
                           <form class="row form-design"  method="POST" action="{{url('admin/ConfirmPassword')}}">
                           {{ csrf_field() }}
                              <div class="form-group col-12">
                                 <label for="">New Password</label>
                                 <input type="text" class="form-control" placeholder="**********" name="password" id="name">
                                 <input type="hidden" name="admin_id" class="form-control" value="{{$id}}">
                                 @if ($errors->has('password'))
                                 <span class="help-block">
                                     <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                  </span>
                                  @endif
                              </div>
                              <div class="form-group col-12">
                                 <label for="">Confirm New Password</label>
                                 <input type="text" class="form-control" placeholder="**********" name="confirm_password" id="name">
                                 @if ($errors->has('confirm_password'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('confirm_password') }}</strong>
                                   </span>
                                   @endif
                              </div> 
                              <div class="form-group col-12">
                                  <!-- <a class="comman_btn" href="javscript:;">Submit</a> -->
                                  <button type="submit" class="comman_btn">Submit</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>

@endsection