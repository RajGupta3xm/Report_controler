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
        <div class="inner_part p-0">
            <div class="order_details_main">
                @php

                    $user=auth()->guard('staff_members')->user();
                    $admin=\App\Models\Admin::where('id',$user->admin_id)->first();
                    $lat1=$admin->latitude;
                    $lon1=$admin->longitude;
                    $lat2=$order->orders->user->user_address->latitude;
                    $lon2=$order->orders->user->user_address->longitude;
                @endphp
                <iframe src="https://www.google.com/maps/embed/v1/directions?origin={{$lat1}},{{$lon1}}&destination={{$lat2}},{{$lon2}}&key=AIzaSyBfnznJ2gE8vjoNP6f3pYzeRxzd-Ha5Yo8" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
{{--                <iframe src="https://www.google.com/maps/embed/v1/directions?origin=40.7127837,-74.0059413&destination=42.3600825,-71.05888&key=AIzaSyBfnznJ2gE8vjoNP6f3pYzeRxzd-Ha5Yo8" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>--}}
{{--                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14934509.338896776!2d36.04889435051902!3d23.95618070781279!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15e7b33fe7952a41%3A0x5960504bc21ab69b!2sSaudi%20Arabia!5e0!3m2!1sen!2sin!4v1670064175434!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>--}}
                <div class="order_details_box">
                    <div class="row align-items-end mb-2">
                        <div class="col-6 pe-0">
                            <div class="id_details">#53444</div>
                            <div class="id_order">User Id : <span>4556</span></div>
                        </div>
                        <div class="col-6 ps-0 text-end">
                            <a class="call_to" href="javscript:;"><i class="fas fa-phone-volume"></i></a>
                            <strong class="timing_order">6:00AM - 12:00PM</strong>
                        </div>
                    </div>
                    <div class="row mb-2 mx-0">
                        <div class="col-12 d-flex align-items-stretch px-0 mb-2">
                            <div class="row address_details_box rounded border mx-0">
                                <strong>Address:</strong>
                                <span>Area name, Street name , House/Flat no, Building Name/No-- </span>
                            </div>
                        </div>
                        <div class="col-6 d-flex align-items-stretch ps-0 pe-1 mb-0">
                            <div class="row address_details_box rounded border mx-0">
                                <strong>Order Details:</strong>
                                <span>Plan name | Variant Name</span>
                            </div>
                        </div>
                        <div class="col-6 d-flex align-items-stretch pe-0 ps-1 mb-0">
                            <div class="row address_details_box rounded border mx-0">
                                <strong>Notes:</strong>
                                <span>Lorem, ipsum dolor </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a class="comman_btn" href="{{route('navigation',$order->order_id)}}">Start Navigation</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

