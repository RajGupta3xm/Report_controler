@extends('driver.layout.master')
@section('content')
    <div class="splash_screen">
        <div class="truck_animation">
            <img class="truck_img  " src="{{asset('driver-assets/img/truckDelevry-removebg-preview1.png')}}" alt="">
        </div>
        <a href="login.html">
            <img class="logo_img" src="{{asset('driver-assets/img/logo.png')}}" alt="">
        </a>
    </div>
@endsection

