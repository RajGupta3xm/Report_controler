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
                           <h1>Login for Admin Panel</h1>
                           <p>Please enter your email and password</p>
                           @if (session('block'))
                             <!-- <div class="alert alert-login-success"> -->
                                <strong class="alert alert-login-success"> {{ session('block') }}</strong>
                              <!-- </div> -->
                          @endif
                        </div>
                        <div class="col-12">
                           <form class="row form-design" method=post id="addForm" enctype="multipart/form-data" action="{{url('admin/dologin')}}">
                              @csrf
                              <div class="form-group col-12 title">
                                 <label for="">User Name</label>
                                 <input type="text" class="form-control validate" placeholder="User@gmail.com" name="email" id="name">
                                 <span class="text-danger errorshift" id="emailError" ></span>
                                 @if ($errors->has('email'))
                                 <span class="help-block">
                                     <strong class="text-danger text-small">{{ $errors->first('email') }}</strong>
                                  </span>
                                  @endif
                              </div>
                              <div class="form-group col-12 title">
                                 <label for="">Password</label>
                                 <input type="text" class="form-control validate" placeholder="**********" name="password" id="name">
                                 <span class="text-danger errorshift" id="passwordError" ></span>
                                  @if ($errors->has('password'))
                                  <span class="help-block">
                                      <strong class="text-danger text-small">{{ $errors->first('password') }}</strong>
                                    </span>
                                   @endif
                              </div>
                              <div class="form-group col-12">
                                 <a class="for_got" href="{{url('admin/forgot')}}">Forgot Password?</a> 
                              </div>
                              <div class="form-group col-12">
                                  <!-- <a class="comman_btn" href="language-selection.html">Submit</a> -->
                                  <button type="button" onclick="validate(this);" class="comman_btn">Submit</button> 
                              </div>
                              <div class="form-group col-12"> 
                                 <div class="flag-lists translation-links d-flex "> 
                                    <a class="arabic shadow" data-lang="Arabic" href="{{url('admin/language_selector')}}">
                                     <img class="mr-md-2 ml-md-0 ml-1 flag_img" src="{{asset('assets/img/language-logo.jpg')}}">
                                      <span>Change Language</span>
                                    </a> 
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script>
 $(window).load(function(){
   setTimeout(function(){ $('.alert-login-success').fadeOut('slow') }, 5000);
});
  </script>
      @endsection
      <style>
         .title .errorshift { float:left }
      </style>


      
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
