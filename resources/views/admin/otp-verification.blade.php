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
                           <h1>Verification</h1>
                           <p>Please enter the OTP received on your Email Address </p>
                        </div>
                        <div class="col-12">
                           <form class="row form-design" method="POST" action="{{url('admin/checkOTP')}}">
                            {{ csrf_field()}}
                              <div class="form-group col-12 otp_input d-flex"> 
                                 <input type="text" class="form-control me-3 px-1 text-center" maxlength="1" placeholder="1" name="otp1" id="name" autocomplete="off">
                                 <input type="text" class="form-control me-3 px-1 text-center" maxlength="1" placeholder="2" name="otp2" id="name" autocomplete="off">
                                 <input type="text" class="form-control me-3 px-1 text-center" maxlength="1" placeholder="3" name="otp3" id="name" autocomplete="off">
                                 <input type="text" class="form-control me-3 px-1 text-center" maxlength="1" placeholder="4" name="otp4" id="name" autocomplete="off">
                              </div> 
                              @if ($errors->has('otp'))
                                <div class="help-block">
                                    <strong class="text-danger">{{ $errors->first('otp') }}</strong>
                                 </div>
                                 @endif
                                 <input type="hidden" name="admin_id" id="otp"  value="{{$id}}" class="form-control" placeholder="">
                              <div class="form-group col-12 text-center">
                                 <span class="count_Sec" id="timer">00:30</span>
                              </div>
                              <div class="form-group col-12 text-center">
                                 <label class="text-center" for="">Didn't received the OTP? <a id="regenerateOTP" href="javscript:;">Request again</a></label>
                              </div>
                              <div class="form-group col-12">
                                  <!-- <a class="comman_btn" href="verification.html">Submit</a> -->
                                  <button type="submit"  class="comman_btn " style=" margin:auto; display:block;">Verify</button> 
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>

<script src="https://code.jquery.com/jquery-latest.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
      <script>
    //function onclickFunction(obj)
    $("#regenerateOTP").click(function(e){
      e.preventDefault();
      disableResend();
        timer(30);
      $.ajax({
        type: "post",
        url: "{{ url('admin/resend_otp') }}",
        data: {
          '_token': $('input[name=_token]').val(),
          'admin_id': $('#otp').val(),
        },
        success: function (data) {
            swal({ title: "Sweet!", text: "One time password  is sent on your email", timer: 2000, imageUrl: "../images/thumbs-up.jpg" });
        },
        error: function (data) {
            swal({ title: "Error!", text: "We are facing technical error!", type: "error", confirmButtonText: "Ok" });
            return false;
        }
      });
});
    
    function disableResend()
{
 $("#regenerateOTP").attr("disabled", true);
 timer(30);
  //$('.regenerateOTP').prop('disabled', true);
  setTimeout(function() {
    // enable click after 1 second
    //$("#regenerateOTP").attr("disabled", false);
   $('#regenerateOTP').removeAttr("disabled");
    //$('.disable-btn').prop('disabled', false);
  }, 60000); // 1 second delay
}

let timerOn = true;

function timer(remaining) {
  var m = Math.floor(remaining / 60);
  var s = remaining % 60;
  
  m = m < 10 ? '0' + m : m;
  s = s < 10 ? '0' + s : s;
  document.getElementById('timer').innerHTML =  m + ':' + s;
  remaining -= 1;
  
  if(remaining >= 0 && timerOn) {
    setTimeout(function() {
        timer(remaining);
    }, 1000);
    return;
  }

  if(!timerOn) {
    // Do validate stuff here
    return;
  }
  
  // Do timeout stuff here
  swal({ title: "Sweet!", text: "OTP expired. Pls. try again." });
}
</script>
@endsection
