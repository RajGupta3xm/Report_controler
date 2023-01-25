@extends('driver.layout.master')
@section('content')
    <div class="diet_on_login position-relative mt-0" >
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12 logo_login mb-2 text-center">
                    <img src="{{asset('driver-assets/img/logo.png')}}" alt="">

                </div>
                <div class="col-10 col-sm-10 mb-5 text-center">
                    <img class="truck_after_forg" src="{{asset('driver-assets/img/truck-cartoon-box-EKK0Y88-600-removebg-preview1.png')}}" alt="">

                </div>

                <div class="col-12  heading_main ">
                    <div class="heading_part text-center">

                        <h4 class=" text-secondary text-center  fw-bold mt-5">Reset Password</h4>
                        <p class=" text-success">Create a new Password </span></p>

                    </div>
                </div>
                <div class="col-10">
                    <form class="row mx-0 form_design" action="">
                        <div class="form-group position-relative mb-4 col-12">
                            <span> New Password</span>
                            <label for="Password"><i class="far fa-key"></i></label>
                            <input class="form-control" id="username" type="text" placeholder="**********">
                        </div>
                        <div class="form-group position-relative mb-4 col-12">
                            <span>Confirm Password</span>
                            <label for="Password"><i class="far fa-key"></i></label>
                            <input class="form-control" id="username" type="text" placeholder="**********">
                        </div>
                        <a href="{{route('driver.login')}}" class="comman_btn" type="submit">Submit</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

