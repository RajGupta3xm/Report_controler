@extends('driver.layout.master')
@section('content')
    <div class="diet_on_login position-relative">

        <img class="truck_after" src="{{asset('driver-assets/img/truck-cartoon-box-EKK0Y88-600-removebg-preview1.png')}}" alt="">
        <div class="container">
            <div class="row">

            </div>
            <div class="row">
                <div class="col-12 text-center logo_login mb-4">
                    <img src="{{asset('driver-assets/img/logo.png')}}" alt="">
                </div>

                <div class="col-12 mb-2 mt-5">
                    <div class="heading_part text-center">
                        <h2 class="text-start mx-2 mb-2">Welcome</h2>
                        <h3 class=" text-secondary text-start  fw-bold">Login to Continue</h3>

                    </div>
                </div>
                @if (Session::get('danger'))
                <div class="" style="margin-top: 8em;">
                    <div class="form-group position-relative mb-3 col-12">
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('danger') }}
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-12">


                    <form class="row mx-0 form_design" action="{{route('driver.login')}}" method="post">
                        @csrf

                        <div class="form-group position-relative mb-3 col-12">
                            <span>Email Address</span>
                            <label for="username"><i class="far fa-user"></i></label>
                            <input class="form-control" id="username" type="text" placeholder="info@example.com" name="email_address">
                        </div>
                        <div class="form-group position-relative mb-4 col-12">
                            <span>Password</span>
                            <label for="Password"><i class="far fa-key"></i></label>
                            <input class="form-control" id="username" type="text" placeholder="**********" name="password">
                        </div>
                        <div class="form-group position-relative mb-3 col-12">
                            <button class="comman_btn" type="submit">Login</button>
                        </div>
                        <div class="form-group position-relative mb-3 col-12 text-center">
                            <a class="forgot_password" href="forgot.html">Forgot Password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

