@extends('driver.layout.master')
@section('content')
    <div class="main_screens">
        <div class="header_part">
            <div class="row align-items-center w-100 justify-content-between">
                <div class="col-2 px-1">
                    
                    <a class="back_btn" href="{{route('orderdetails',$order->id)}}">
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
{{--                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14934509.338896776!2d36.04889435051902!3d23.95618070781279!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15e7b33fe7952a41%3A0x5960504bc21ab69b!2sSaudi%20Arabia!5e0!3m2!1sen!2sin!4v1670064175434!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>--}}
                <iframe src="https://www.google.com/maps/embed/v1/directions?origin={{$lat1}},{{$lon1}}&destination={{$lat2}},{{$lon2}}&key=AIzaSyBfnznJ2gE8vjoNP6f3pYzeRxzd-Ha5Yo8" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <div class="order_details_box">
                    <div class="row align-items-end mb-2">
                        <div class="col-6 pe-0">
                            <div class="id_details">#{{$order->orders->id}}</div>
                            <div class="id_order">User Id : <span>{{$order->orders->user->id}}</span></div>
                        </div>
                        <div class="col-6 ps-0 text-end">
                            <a class="call_to" href="javscript:;"><i class="fas fa-phone-volume"></i></a>
                            <strong class="timing_order">{{$order->deliverySlot->start_time}}-{{$order->deliverySlot->end_time}}</strong>
                        </div>
                    </div>
                    <div class="row mb-2 mx-0">
                        <div class="col-12 d-flex align-items-stretch px-0 mb-2">
                            <div class="row address_details_box rounded border mx-0">
                                <strong>Address:</strong>
                                <span>{{$order->orders->user->user_address->area}}, {{$order->orders->user->user_address->street}} , {{$order->orders->user->user_address->house_number}}, {{$order->orders->user->user_address->building}} </span>
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
                        <div class="col-6 pe-1">
                            <a class="comman_btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" href="javascript:;">Deliver</a>
                        </div>
                        <div class="col-6 ps-1">
                            <a class="comman_btn bg-danger" href="{{route('cancelorder',$order->orders->id)}}">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade sure_to" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-body py-4">
                    <form class="row" action="{{route('submitcancelorder')}}" method="post">
                        @csrf
                        <input type="hidden" name="type" value="1">
                        <input type="hidden" name="order_id" value="{{$order->order_id}}">
                        <div class="row justify-content-center text-center py-3">
                            <div class="col-12 sure_to_content">
                                <i class="fas fa-check-circle"></i>
                                <h3>Are You Sure ?</h3>
                            </div>
                            <div class="col-6 pe-1">
                                <button class="comman_btn" type="submit">Yes</button>
                            </div>
                            <div class="col-6 ps-1">
                                <a class="comman_btn bg-danger" data-bs-dismiss="modal" href="javascript:;">No</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

