<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Diet On</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />
    <!-- Favicons -->
    <link href="{{asset('driver-assets/img/favicon.png')}}" rel="icon" />
    <link href="{{asset('driver-assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon" />
    <!-- Vendor CSS Files -->
    <link href="{{asset('driver-assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('driver-assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('driver-assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet" />
    <link href="{{asset('driver-assets/vendor/owl/owl.carousel.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.15.1/css/pro.min.css"/>
    <link href="{{asset('driver-assets/css/style.css')}}" rel="stylesheet" />
</head>
<body>
<div class="diet_on">
    <?php

    $phpVariable = "<script>document.write(javascriptVariable);</script>";

    ?>
{{--    <div class="splash_screen">--}}
{{--        <div class="truck_animation">--}}
{{--            <img class="truck_img  " src="{{asset('driver-assets/img/truckDelevry-removebg-preview1.png')}}" alt="">--}}
{{--        </div>--}}
{{--        <a href="login.html">--}}
{{--            <img class="logo_img" src="{{asset('driver-assets/img/logo.png')}}" alt="">--}}
{{--        </a>--}}
{{--    </div>--}}
    @yield('content')
        <input type="hidden" id="lattitude">
        <input type="hidden" id="longtitude">

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="{{asset('driver-assets/vendor/jquery.min.js')}}"></script>
<script src="{{asset('driver-assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('driver-assets/vendor/owl/owl.carousel.min.js')}}"></script>
<script src="{{asset('driver-assets/js/main.js')}}"></script>
@yield('script')
<input type="hidden" id="latitutes">
<input type="hidden" id="longtitude">

<script>
    getLocation();
    setInterval(function() {
        getLocation();
    }, 60 * 1000); // 60 * 1000 milsec

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
       document.getElementById("latitutes").value = position.coords.latitude;
       document.getElementById("longtitude").value = position.coords.longitude;

        $.ajax({
            url:'{{ url("driver/storeLocation") }}',
            method:'post',
            data: {
                latitude:position.coords.latitude,
                longitude:position.coords.longitude,
            },
            dataType:'json',
            type: "post",
            cache: false,
            success:function(data)
            {
                console.log(data)
            }
        })
    }


</script>
</body>
</html>
