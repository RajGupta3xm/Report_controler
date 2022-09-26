@extends('admin.layout.master2')

@section('content')
      <section class="login_page">
         <div class="container-fluid px-0">
            <div class="row justify-content-center">  
               <div class="col-4">
                  <div class="login_page_form shadow">
                     <div class="row">
                        <div class="col-12 formheader mb-4">
                           <img src="{{asset('assets/img/logo.png')}}" alt="">
                           <h1>Forgot Password</h1>
                           <p>Please enter your registered Email Address to receive the OTP</p>
                        </div>
                        <div class="col-12">
                           <form class="row form-design"  method="POST"  id="sign_in" enctype="multipart/form-data"  action="{{url('admin/forgotten')}}" autocomplete="off">
                            @csrf
                              <div class="form-group col-12">
                                 <label for="">Email Address</label>
                                 <input type="text" class="form-control validate" placeholder="User@gmail.com" name="email" id="name">
                                 <p class="text-danger" id="emailError" style="text-align: left;"></p>
                                  @if ($errors->has('email'))
                                 <div class="help-block">
                                   <strong class="text-danger text-small">{{ $errors->first('email') }}</strong>
                               </div>
                                @endif
                              </div> 
                              <div class="form-group col-12">
                                  <!-- <a class="comman_btn" href="verification.html">Submit</a> -->
                                  <button type="button" onclick="validate(this);" class="comman_btn">Submit</button> 
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
<script>
            function validate(obj) {
            $(".text-danger").html('');
            var flag = true;
            var formData = $("#sign_in").find(".validate:input").not(':input[type=button]');
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
                $("#sign_in").submit();
            } else {
                return false;
            }

            
        }
    </script>