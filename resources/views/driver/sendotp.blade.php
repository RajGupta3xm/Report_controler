@extends('driver.layout.master')
@section('content')
    <div class="diet_on_login position-relative">
        <div class="container">
            <div class="row mt-5 ">
                <div class="col-12 logo_login mb-2 text-center">
                    <img src="{{asset('driver-assets/img/logo.png')}}" alt="">

                </div>
                <div class="col-10 col-sm-10 mb-5 text-center">
                    <img class="truck_after_forg" src="{{asset('driver-assets/img/truck-cartoon-box-EKK0Y88-600-removebg-preview1.png')}}" alt="">

                </div>

                <div class="col-12 mb-2 heading_main ">
                    <div class="heading_part text-center">

                        <h4 class=" text-secondary text-center  fw-bold">Otp Verification</h4>

                        <p class=" text-success">Enter the OTP sent to your registered Email.</span></p>


                    </div>
                </div>
                <div class="col-10  text-center">
                    <div class="otp-verify-form">
                        <form action="" method="">
                            <div class="d-flex justify-content-between mb-5 rtl-flex-d-row-r">
                                <input class="single-otp-input form-control" type="text" value="" placeholder="-" maxlength="1">
                                <input class="single-otp-input form-control" type="text" value="" placeholder="-" maxlength="1">
                                <input class="single-otp-input form-control" type="text" value="" placeholder="-" maxlength="1">
                                <input class="single-otp-input form-control" type="text" value="" placeholder="-" maxlength="1">
                            </div>
                            <a href="{{route('driver.resetpassword')}}" class="comman_btn">Verify &amp; Proceed</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

