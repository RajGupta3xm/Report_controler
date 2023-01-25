@extends('driver.layout.master')
@section('content')

    <div class="main_screens">
        <div class="header_part">
            <div class="row align-items-center w-100 justify-content-between">
                <div class="col-2 px-1">
                    <a class="profile_heder" href="{{route('profile')}}">
                        <img src="{{Auth::guard('staff_members')->user()->image}}" alt="">
                    </a>
                </div>
                <div class="col-8 px-1 header_logo text-center">
                    <img src="{{asset('driver-assets/img/logo.png')}}" alt="">
                </div>
                <div class="col-2 px-1">

                </div>
            </div>
        </div>
        <div class="inner_part">
            <div class="row">
                <div class="col-12 comman_heading mb-4">
                    <h2>My Deliveries</h2>
                </div>
                @php
                    $date = \Carbon\Carbon::now();
                    $month = \Carbon\Carbon::now()->format('F');
                    $dates[]=$date->format('D j');
                    for ($i = 0; $i < 6; $i++) {
                        $dates[] = $date->addDay()->format('D j');
                    }
                    $date1 = \Carbon\Carbon::now();
                    $month = \Carbon\Carbon::now()->format('F');
                    $dates1[]=$date1->format('d-M-Y');
                    for ($i = 0; $i < 6; $i++) {
                        $dates1[] = $date1->addDay()->format('d-M-Y');
                    }

                @endphp
                <div class="col-12">
                    <div class="my_deliveries">
                        <span class="date_show">{{$month}}</span>
                        <nav>
                            <div class="nav nav-tabs first_tabs" id="nav-tab" role="tablist">
                                @foreach($dates as $key1=> $date)
                                    @php
                                        $month=explode(' ',$date);
                                    @endphp
                                    <button class="nav-link @if($key1==0) active @endif" id="nav-home-tab{{$key1}}" data-bs-toggle="tab" data-bs-target="#nav-home{{$key1}}" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                                        {{mb_substr($month[0], 0, 1)}} <br/> {{$month[1]}}</button>
                                @endforeach

                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            @foreach($dates1 as $key2=> $date)
                                @php
                                        $date=\Carbon\Carbon::parse($date)->format('Y-m-d');
                                        $pending_orders=\App\Models\FleetDriver::wherehas('orders',function($q) use($date){
                                            $q->wheredate('created_at',$date);
                                            $q->where('status','=','order_placed');
                                        })->where('priority',1)->get();
                                        $completed_orders=\App\Models\FleetDriver::wherehas('orders',function($q) use($date){
                                            $q->wheredate('created_at',$date);
                                            $q->where('is_deliver',1);
                                            $q->where('status','=','delivered');
                                        })->where('priority',1)->get();
                                        $priority_orders=\App\Models\FleetDriver::wherehas('orders',function($q) use($date){
                                            $q->wheredate('created_at',$date);
                                            $q->where('status','=','order_placed');
                                        })->where('priority',2)->get();
                                @endphp
                                <div class="tab-pane fade @if($key2==0) show active @endif" id="nav-home{{$key2}}" role="tabpanel" aria-labelledby="nav-home-tab{{$key2}}">
                                    <form action="" class="row py-2 search_design">
                                        <div class="col form-group position-relative search_icon">
                                            <input class="form-control" type="text" placeholder="Search">
                                            <i class="fad fa-search"></i>
                                        </div>
                                        <div class="col-auto form-group ps-0">
                                            <a data-bs-toggle="modal" data-bs-target="#exampleModal" class="filter_btn" href="javscript:;">
                                                <i class="fa fa-sort"></i>
                                            </a>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-12">
                                            <nav class="mx-1">
                                                <div class="nav nav-tabs inner_tabs_design border-0" id="nav-tab" role="tablist">
                                                    <button class="nav-link active" id="nav-homepending-tab" data-bs-toggle="tab" data-bs-target="#nav-homepending" type="button" role="tab" aria-controls="nav-home1" aria-selected="true">Pending <span>{{count($pending_orders)}}</span></button>
                                                    <button class="nav-link" id="nav-profilecompleted-tab" data-bs-toggle="tab" data-bs-target="#nav-profilecompleted" type="button" role="tab" aria-controls="nav-profile1" aria-selected="false">Completed <span>{{count($completed_orders)}}</span></button>
                                                    <button class="nav-link" id="nav-vispriority-tab" data-bs-toggle="tab" data-bs-target="#nav-vispriority" type="button" role="tab" aria-controls="nav-vis" aria-selected="false">Priority <span style="background-color: red;">{{count($priority_orders)}}</span></button>
                                                </div>
                                            </nav>
                                            <div class="tab-content mt-4 pt-1" id="nav-tabContent">
                                                {{--Pending Orders--}}
                                                <div class="tab-pane fade show active" id="nav-homepending" role="tabpanel" aria-labelledby="nav-homepending-tab">
                                                    <div class="row my_deliveries_inner">
                                                        @if(count($pending_orders) > 0)
                                                            @foreach($pending_orders as $orders)

                                                                @php
                                                                    $user=auth()->guard('staff_members')->user();
                                                                    $admin=\App\Models\Admin::where('id',$user->admin_id)->first();
                                                                   $lat1=$admin->latitude;
                                                                   $lon1=$admin->longitude;
                                                                    $lat2=$orders->orders->user->user_address->latitude;
                                                                    $lon2=$orders->orders->user->user_address->longitude;
                                                                     $theta = $lon1 - $lon2;
                                                                     $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                                                                     $dist = acos($dist);
                                                                     $dist = rad2deg($dist);
                                                                     $miles = $dist * 60 * 1.1515;
                                                                     $km   = $miles*1.609344;
                                                                @endphp

                                                                <div class="col-12 mb-4 mt-1">
                                                                    <a href="{{route('orderdetails',$orders->orders->id)}}" class="my_deliveries_box">
                                                                        <div class="map_main"><i class="fas fa-map-signs me-2"></i>
                                                                            {{number_format($km,1)}} km</div>
                                                                        <div class="missing_orders">
                                                                            <i class="fa fa-exclamation"></i>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6 deliveries_left">
                                                                                <strong>#{{$orders->orders->id}}</strong>
                                                                                <div class="user_main">User ID: <span class="user_id">{{$orders->orders->user->id}}</span></div>
                                                                            </div>
                                                                            <div class="col-6 deliveries_right ps-0 text-end">
                                                                                <strong class="timing_maion">{{$orders->deliverySlot->start_time}}-{{$orders->deliverySlot->end_time}}</strong>
                                                                                <div class="location_map ">
                                                                                    At {{$orders->orders->user->user_address->area}}
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                {{--Completed Orders--}}
                                                <div class="tab-pane fade" id="nav-profilecompleted" role="tabpanel" aria-labelledby="nav-profilecompleted-tab">
                                                    <div class="row my_deliveries_inner">
                                                        @if(count($completed_orders) > 0)
                                                            @foreach($completed_orders as $orders)
                                                                @php
                                                                    $user=auth()->guard('staff_members')->user();
                                                                        $admin=\App\Models\Admin::where('id',$user->admin_id)->first();
                                                                        $lat1=$admin->latitude;
                                                                        $lon1=$admin->longitude;
                                                                         $lat2=$orders->orders->user->user_address->latitude;
                                                                         $lon2=$orders->orders->user->user_address->longitude;
                                                                          $theta = $lon1 - $lon2;
                                                                          $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                                                                          $dist = acos($dist);
                                                                          $dist = rad2deg($dist);
                                                                          $miles = $dist * 60 * 1.1515;
                                                                          $km   = $miles*1.609344;
                                                                @endphp
                                                                <div class="col-12 mb-4 mt-1">
                                                                    <a href="{{route('orderdetails',$orders->orders->id)}}" class="my_deliveries_box">
                                                                        <div class="map_main"><i class="fas fa-map-signs me-2"></i> {{number_format($km,1)}} km</div>
                                                                        <div class="missing_orders">
                                                                            <i class="fa fa-exclamation"></i>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6 deliveries_left">
                                                                                <strong>#{{$orders->orders->id}}</strong>
                                                                                <div class="user_main">User ID: <span class="user_id">{{$orders->orders->user->id}}</span></div>
                                                                            </div>
                                                                            <div class="col-6 deliveries_right ps-0 text-end">
                                                                                <strong class="timing_maion">{{$orders->deliverySlot->start_time}}-{{$orders->deliverySlot->end_time}}</strong>
                                                                                <div class="location_map ">
                                                                                    At {{$orders->orders->user->user_address->area}}
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            @endforeach

                                                        @endif
                                                    </div>
                                                </div>
                                                {{--Priority Orders--}}
                                                <div class="tab-pane fade" id="nav-vispriority" role="tabpanel" aria-labelledby="nav-vispriority-tab">
                                                    <div class="row my_deliveries_inner">
                                                        @if(count($priority_orders) > 0)
                                                            @foreach($priority_orders as $orders)
                                                                @php

                                                                    $user=auth()->guard('staff_members')->user();
                                                                   $admin=\App\Models\Admin::where('id',$user->admin_id)->first();
                                                                   $lat1=$admin->latitude;
                                                                   $lon1=$admin->longitude;
                                                                   $lat2=$orders->orders->user->user_address->latitude;
                                                                   $lon2=$orders->orders->user->user_address->longitude;
                                                                    $theta = $lon1 - $lon2;
                                                                    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                                                                    $dist = acos($dist);
                                                                    $dist = rad2deg($dist);
                                                                    $miles = $dist * 60 * 1.1515;
                                                                    $km   = $miles*1.609344;
                                                                @endphp
                                                                <div class="col-12 mb-4 mt-1">
                                                                    <a href="{{route('orderdetails',$orders->orders->id)}}" class="my_deliveries_box">
                                                                        <div class="map_main"><i class="fas fa-map-signs me-2"></i> {{number_format($km,1)}} km</div>
                                                                        <div class="missing_orders">
                                                                            <i class="fa fa-exclamation"></i>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6 deliveries_left">
                                                                                <strong>#{{$orders->orders->id}}</strong>
                                                                                <div class="user_main">User ID: <span class="user_id">{{$orders->orders->user->id}}</span></div>
                                                                            </div>
                                                                            <div class="col-6 deliveries_right ps-0 text-end">
                                                                                <strong class="timing_maion">{{$orders->deliverySlot->start_time}}-{{$orders->deliverySlot->end_time}}</strong>
                                                                                <div class="location_map ">
                                                                                    At {{$orders->orders->user->user_address->area}}
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>
                <div class="col-12 mb-4 px-2">
                    <a class="comman_btn" href="scan-orders.html">Pick Up</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade sorting_modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sort By</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3 pb-4">
                    <form class="row" action="">
                        <div class="form-group col-12 custom_checkbox mb-3">
                            <input type="radio" id="check1" checked name="check1">
                            <label for="check1">Distance from current location</label>
                        </div>
                        <div class="form-group col-12 custom_checkbox mb-3">
                            <input type="radio" id="check2" name="check1">
                            <label for="check2">Order Id</label>
                        </div>
                        <div class="form-group col-12 custom_checkbox mb-3">
                            <input type="radio" id="check3" name="check1">
                            <label for="check3">Time Slot</label>
                        </div>
                        <div class="form-group col-12 custom_checkbox mb-3">
                            <input type="radio" id="chec43" name="check1">
                            <label for="check4">Area</label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

