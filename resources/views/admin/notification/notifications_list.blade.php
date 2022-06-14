@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Notification List</h1> 
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if(session()->has('success'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ session()->get('success') }}
                        </div>
                        @else 
                        @if(session()->has('error'))  
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ session()->get('error') }}
                        </div>
                        @endif 
                        @endif
                        <div class="table-responsive table-image">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th>Sent On</th>
                                        <th>Title</th>
                                        <th>To</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($notifications)
                                    @foreach($notifications as $k=>$notification)
                                    <tr>
                                        <td>{{$k+1}}</td>
                                        <td>{{date('d-m-Y h:i A',strtotime($notification->created_at))}}</td>
                                        <td>{{$notification->title}}</td>
                                        <td>{{$notification->user_list}}</td>
                                        <td><a href="{{url('admin/notification-detail/'.base64_encode($notification->id))}}" class="composemail"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- </div> -->
    @endsection