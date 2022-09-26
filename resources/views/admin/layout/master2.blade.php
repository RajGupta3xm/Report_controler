
<!DOCTYPE html>
<html lang="en">

    <head>
    <meta charset="utf-8" />
      <meta content="width=device-width, initial-scale=1.0" name="viewport" />
      <title>diet-on : Admin Panel</title>
      <meta content="" name="description" />
      <meta content="" name="keywords" />
      <!-- Favicons -->
      <link href="{{asset('assets/img/favicon.png')}}" rel="icon" />
      <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon" />
      <!-- Vendor CSS Files -->
      <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet"/>
      <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet" />
      <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet" />
      <link href="{{asset('assets/vendor/owl/owl.carousel.min.css')}}" rel="stylesheet" />
      <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.15.1/css/pro.min.css"/>
      <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" /> 
        <style>
            .text-danger{
                font-size:13px;
            }
        </style>
    </head>

    <body class="login-page sty1">
        @yield('content')
        <script src="{{asset('assets/vendor/jquery.min.js')}}"></script>
      <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
      <script src="{{asset('assets/vendor/owl/owl.carousel.min.js')}}"></script>
      <script src="{{asset('assets/js/main.js')}}"></script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </body>

</html>