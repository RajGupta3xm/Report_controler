<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <title>Autoparts</title>
      <meta content="" name="description">
      <meta content="" name="keywords">
      <!-- Favicons -->
      <link href="{{asset('assets/web/img/favicon.png')}}" rel="icon">
      <link href="{{asset('assets/web/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
      <!-- Vendor CSS Files -->
      <link href="{{asset('assets/web/vendor/aos/aos.css')}}" rel="stylesheet">
      <link href="{{asset('assets/web/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
      <link href="{{asset('assets/web/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
      <link href="{{asset('assets/web/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
      <link href="{{asset('assets/web/vendor/owl/owl.carousel.min.css')}}" rel="stylesheet">
      <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.15.1/css/pro.min.css">
      <link href="{{asset('assets/web/css/style.css')}}" rel="stylesheet">
      
   </head>
   <body>
        

            <!-- Navbar -->
            @include('web.layout.header')
            <!-- /.navbar -->
            <!-- Main Sidebar Container -->
            <!-- <div class="dashboard-section"> -->
            
            <!-- Content Wrapper. Contains page content -->
            <!-- <div class="content-wrapper"> -->
            <!-- <div id="loader" class="lds-dual-ring hidden overlay"></div> -->
            <!-- Content Header (Page header) -->
            @yield('content')
            <!-- /.content-header -->
            <!-- </div> -->
            <!-- Main Footer -->
            @include('web.layout.footer')
            <!-- </div> -->
            <!-- /.content-wrapper -->

        

        <script src="{{asset('assets/web/vendor/jquery.min.js')}}"></script>
        <script src="{{asset('assets/web/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/web/vendor/owl/owl.carousel.min.js')}}"></script> 
        <script src="{{asset('assets/web/js/main.js')}}"></script>
        <script>
          $(document).ready(function(){
        $('.characterOnly').keypress(function (e) {
            var regex = new RegExp(/^[a-zA-Z\s]+$/);
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            } else {
                e.preventDefault();
                return false;
            }
        });

        $('.numberOnly').keypress(function (e) {
            var input_val=$(this).val();
            var regex = new RegExp(/^[0-9]+$/);
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                if(input_val =="" && str == "0"){
                    return false;
                }else{
                    return true;   
                }
                
            } else {
                e.preventDefault();
                return false;
            }
        });

        $(".fractionNumber").keypress(function (e) {
            var k = String.fromCharCode(e.which);
            var v = $(this).val();
            var expected = v + k;
            var discount = 0;
            if ($(this).attr('name') == 'discount') {
                discount = 1;
            }
    //            alert(expected);
            if ((e.which >= 48 && e.which <= 57) || e.which == 46) {
                if (isNaN(expected)) {
                    e.preventDefault();
                    return false;
                } else {
                    if (discount) {
                        if (expected < 0 || expected > 100) {
                            e.preventDefault();
                            return false;
                        } else {
                            return true;
                        }
                    } else {
                        return true;
                    }
                }
            } else {
                e.preventDefault();
                return false;
            }
        });
    });
        </script>
        <script>
          var user_id;
          function validator(formid){
            var flag=0;
            $('.error-field').css('display','none');
            var form_fields=$('#'+formid+' .mandate:input');
            $(form_fields).each(function(i,v){
              if($(v).val() == "" && $(v).attr('type') != "checkbox" && $(v).attr('type') != "radio"){
                ++flag;
                $('#'+$(v).attr('id')+'_error').css('display','block');
                $('#'+$(v).attr('id')+'_error').html($(v).attr('data-required'));
              }else{
                // alert($(v).attr('id'));
                $('#'+$(v).attr('id')+'_error').html('');
                if($(v).attr('type') == "password" && $(v).val() != ""){
                  if(($(v).val()).length < 8){
                    ++flag;
                    $('#'+$(v).attr('id')+'_error').css('display','block');
                    $('#'+$(v).attr('id')+'_error').html($(v).attr('data-password'));
                  }else{
                    $('#'+$(v).attr('id')+'_error').css('display','none');
                  }
                }
              }
              if(($(v).attr('type') == "checkbox" || $(v).attr('type') == "radio") && $(v).is(":checked") == false){
                ++flag;
                $('#'+$(v).attr('id')+'_error').css('display','block');
                $('#'+$(v).attr('id')+'_error').html($(v).attr('data-required'));
              }else{
                $('#'+$(v).attr('id')+'_error').css('display','none');
              }
            });
            return flag;
          }

          function signup(){            
            var validation=validator('registrationForm');
            if(validation){
              return false;
            }else{
              $.ajax({
                url:"{{url('/api/registerUser')}}",
                type:'post',
                data:$("#registrationForm").serialize(),
                success: function(response){
                    if(response.status_code == '200'){
                      $("#staticBackdrop").modal('hide');
                      $("#staticBackdrop3").modal('show');
                      user_id=response.data['user_id'];
                    }
                }
              });
            }
          }


          function verification(){
            var validation=validator('verificationForm');
            if(validation){
              return false;
            }else{
              var code=$("#code1").val()+$("#code2").val()+$("#code3").val()+$("#code4").val();
              if(code){
                $.ajax({
                  url:"{{url('/api/verifyOtp')}}",
                  type:'post',
                  data:'user_id='+user_id+'&otp='+code+'&type=register',
                  success: function(response){
                      if(response.status_code == '200'){
                        $("#staticBackdrop3").modal('close');
                        loginUser(response);
                      }
                  }
                });
              }else{
                $('#'+$(v).attr('id')+'_error').html($(v).attr('data-required'));
              }
            }
          }


          function loginUser(userdata){
            $.ajax({
                  url:"{{url('/setsessiondetails')}}",
                  type:'post',
                  data:userdata,
                  success: function(response){
                      if(response.status_code == '200'){
                        window.location.href="{{url('home')}}";
                      }
                  }
                });
          }
        </script>
    </body>
</html>