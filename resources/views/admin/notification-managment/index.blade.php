@extends('admin.layout.master')

@section('content')
    <link rel="stylesheet" href="https://rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">
    <div class="admin_main">
        <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
                <div class="row notification-management justify-content-center">
                    <div class="col-12">
                        <div class="row mx-0">
                            <div class="col-12 design_outter_comman shadow">
                                <div class="row">
                                    <div class="col-12 px-0 comman_tabs">
                                        <nav>
                                            @php
                                                $brodcast=Session::get('broadcast');
                                                $popup=Session::get('popup');
                                                $email=Session::get('email');
                                            @endphp
                                            <div class="nav nav-tabs flex-nowrap" id="nav-tab" role="tablist">
                                                <button class="nav-link @if(!isset($popup) && !isset($email)) active @endif w-50" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Broadcast Notification</button>
                                                <button class="nav-link w-50 @if(isset($popup)) active @endif" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Popup Notification</button>
                                                <button class="nav-link w-50 @if(isset($email)) active @endif" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile1" type="button" role="tab" aria-controls="nav-profile1" aria-selected="false">Email Notification</button>
                                            </div>
                                        </nav>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade @if(!isset($popup) && !isset($email)) show active @endif" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <div class="row mx-0 px-4 py-4">
                                                    <div class="col-12 mb-4 inner_design_comman border">
                                                        <div class="row comman_header justify-content-between">
                                                            <div class="col-auto">
                                                                <h2>Create New Notification</h2>
                                                            </div>
                                                        </div>
                                                        <form class="form-design notification-form py-4 px-4 row align-items-end justify-content-start mb-3" action="{{url('admin/brodcastnotify/submit')}}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="form-group col-4">
                                                                <label for="">Notification Label</label>
                                                                <input type="text" class="form-control" name="notification_label">
                                                            </div>
                                                            <div class="form-group col-4">
                                                                <label for="">Date & Time</label>
                                                                <input type="datetime-local" class="form-control" name="date_time">
                                                            </div>
                                                            <div class="form-group col-4 choose_file position-relative">
                                                                <span>Upload Image</span>
                                                                <label for="upload_video"><i class="fal fa-camera me-1"></i>Choose File</label>
                                                                <input type="file" class="dropify" value="" id="upload_video" name="images">
                                                            </div>
                                                            <div class="form-group mb-0 col">
                                                                <label for="">Enter Text Here :</label>
                                                                <textarea class="emojionearea1" name="description" id=""></textarea>
                                                            </div>
                                                            <div class="form-group mb-0 col-auto">
                                                                <button class="comman_btn" type="submit">Send</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-12">
                                                        @if(count($brodcastNotification) > 0)
                                                            @foreach($brodcastNotification as $notification)
                                                                <div class="row notification-box shadow mb-4">
                                                                    <div class="col-2">
                                                                        <div class="notification_icon">
                                                                            <img class="" src="{{$notification->image}}" alt="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="notification-box-content">
                                                                            <h2>{{$notification->notification_label}}</h2>
                                                                            <span class="">{{\Carbon\Carbon::parse($notification->date_time)->format('d-m-Y H:i')}}</span>
                                                                            <p>{{$notification->description}}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade @if(isset($popup)) show active @endif" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                <div class="row mx-0 px-4 py-4">
                                                    <div class="col-12 mb-4 inner_design_comman border">
                                                        <div class="row comman_header justify-content-between">
                                                            <div class="col-auto">
                                                                <h2>Create New Notification</h2>
                                                            </div>
                                                        </div>
                                                        <form class="form-design notification-form py-4 px-4 row align-items-end justify-content-start mb-3" action="{{url('admin/popupnotify/submit')}}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="form-group col-4">
                                                                <label for="">Notification Label</label>
                                                                <input type="text" class="form-control" name="notification_label">
                                                            </div>
                                                            <div class="form-group col-4">
                                                                <label for="">Date & Time</label>
                                                                <input type="datetime-local" class="form-control" name="date_time">
                                                            </div>
                                                            <div class="form-group col-4 choose_file position-relative">
                                                                <span>Upload Image</span>
                                                                <label for="upload_video"><i class="fal fa-camera me-1"></i>Choose File</label>
                                                                <input type="file" class="dropify" value="" name="images" id="upload_video">
                                                            </div>
                                                            <div class="form-group mb-0 col">
                                                                <label for="">Enter Text Here :</label>
                                                                <textarea class="emojionearea1" name="description" id=""></textarea>
                                                            </div>
                                                            <div class="form-group mb-0 col-auto">
                                                                <button class="comman_btn" type="submit">Send</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-12">
                                                        @if(count($popupNotification) > 0)
                                                            @foreach($popupNotification as $notification)
                                                                <div class="row notification-box shadow mb-4">
                                                                    <div class="col-2">
                                                                        <div class="notification_icon">
                                                                            <img class="" src="{{$notification->image}}" alt="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="notification-box-content">
                                                                            <h2>{{$notification->notification_label}}</h2>
                                                                            <span class="">{{\Carbon\Carbon::parse($notification->date_time)->format('d-m-Y H:i')}}</span>
                                                                            <p>{{$notification->description}}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade @if(isset($email)) show active @endif" id="nav-profile1" role="tabpanel" aria-labelledby="nav-profile1-tab">
                                                <div class="row mx-0 px-4 py-4">
                                                    <div class="col-12 mb-4 inner_design_comman border">
                                                        <div class="row comman_header justify-content-between">
                                                            <div class="col-auto">
                                                                <h2>Invoice Email</h2>
                                                            </div>
                                                        </div>
                                                        <form class="form-design notification-form py-4 px-4 row align-items-end justify-content-start mb-3" >
                                                            <div class="form-group mb-0 col">
                                                                <label for="">Enter Text Here :</label>
                                                                <textarea class="emojionearea1" name="" id=""></textarea>
                                                            </div>
                                                            <div class="form-group mb-0 col-auto">
                                                                <button class="comman_btn">Send</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-12 mb-4 inner_design_comman border">
                                                        <div class="row comman_header justify-content-between">
                                                            <div class="col-auto">
                                                                <h2>Delivery Email</h2>
                                                            </div>
                                                        </div>
                                                        <form class="form-design notification-form py-4 px-4 row align-items-end justify-content-start mb-3" action="">
                                                            <div class="form-group mb-0 col">
                                                                <label for="">Enter Text Here :</label>
                                                                <textarea class="emojionearea1" name="" id=""></textarea>
                                                            </div>
                                                            <div class="form-group mb-0 col-auto">
                                                                <button class="comman_btn">Send</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-12 mb-4 inner_design_comman border">
                                                        <div class="row comman_header justify-content-between">
                                                            <div class="col-auto">
                                                                <h2>Gift Card</h2>
                                                            </div>
                                                        </div>
                                                        <form class="form-design notification-form py-4 px-4 row align-items-end justify-content-start mb-3" action="">
                                                            <div class="form-group mb-0 col">
                                                                <label for="">Enter Text Here :</label>
                                                                <textarea class="emojionearea1" name="" id=""></textarea>
                                                            </div>
                                                            <div class="form-group mb-0 col-auto">
                                                                <button class="comman_btn">Send</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $('.dropify').dropify();
    </script>
@endsection
