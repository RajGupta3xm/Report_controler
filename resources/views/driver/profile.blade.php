@extends('driver.layout.master')
@section('content')
    <div class="main_screens">
        <div class="header_part">
            <div class="row align-items-center w-100 justify-content-between">
                <div class="col-2 px-1">
                    <a class="back_btn" href="{{route('dashboard')}}">
                        <i class="fas fa-angle-left"></i>
                    </a>
                </div>
                <div class="col-8 px-1 header_logo text-center">
                    <img src="{{asset('driver-assets/img/logo.png')}}" alt="">
                </div>
                <div class="col-2 px-1">
                    <a class="profile_heder" href="{{route('profile')}}">
                        <img src="{{Auth::guard('staff_members')->user()->image}}" alt="">
                    </a>
                </div>
            </div>
        </div>
        <div class="inner_part">
            <div class="row">
                <div class="col-12 comman_heading mb-4">
                    <h2>Profile</h2>
                </div>
                <div class="col-12">
                    <div class="profile_box text-center">
                         <span class="profile_immg">
                            <img src="{{Auth::guard('staff_members')->user()->image}}" alt="">
                         </span>
                        <strong class="user_nam">{{ucfirst(Auth::guard('staff_members')->user()->name)}}</strong>
                    </div>
                </div>
            </div>
            <a class="comman_btn signout_btn" href="{{route('logout')}}">Sign Out</a>
        </div>
    </div>
@endsection

