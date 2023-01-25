@extends('driver.layout.master')
@section('content')
    <div class="diet_on_login position-relative">
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12 logo_login mb-2 text-center">
                    <img src="{{asset('driver-assets/img/logo.png')}}" alt="">

                </div>
                <div class="col-10 col-sm-10 mb-5 text-center">
                    <img class="truck_after_forg" src="{{asset('driver-assets/img/truck-cartoon-box-EKK0Y88-600-removebg-preview1.png')}}" alt="">

                </div>

                <div class="col-12 mb-4 heading_main ">
                    <div class="heading_part text-center">

                        <h4 class=" text-secondary text-center  fw-bold">Forgot Password</h4>
                        <p class=" text-success">Please enter your registered Email Address to receive the OTP</span></p>

                    </div>
                </div>
                <div class="col-11">
                    <form class="row mx-0 form_design" action="">
                        <div class="form-group position-relative mb-3 col-12">
                            <span>Email Address</span>
                            <label for="username"><i class="far fa-user"></i></label>
                            <input class="form-control" id="username" type="text" placeholder="info@example.com">
                        </div>
                        <a href="{{route('driver.sendotp')}}" class="comman_btn" type="submit">Send OTP</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

