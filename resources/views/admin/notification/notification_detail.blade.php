@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Notification Detail</h1> 
    </div>
    <div class="content"> 

        <div class="row">  
            <div class="col-md-12"> 
                <div class="card">  
                    <div class="card-body">  
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <p>Sent On</p>
                                <label>{{date('d-m-Y h:i A',strtotime($notification->created_at))}}</label>
                            </div>
                            <div class="col-md-12 mb-3">
                                <p>Title</p>
                                <label>{{$notification->title}}</label>
                            </div>
                            <div class="col-md-12 mb-3">
                                <p>Sent To</p>
                                <label>{{$notification->user_list}}</label>
                            </div>
                            <div class="col-md-12 mb-3">
                                <p>Message</p>
                                <label>{{$notification->message}}</label>
                            </div>
                        </div>

                    </div>   
                </div>
            </div>
        </div>
    </div>
    @endsection