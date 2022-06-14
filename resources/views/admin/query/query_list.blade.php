@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Help & Support List</h1> 
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
                                        <th>User Name </th>    
                                        <th>Email Id </th>  
                                        <th>Query Date and Time</th> 
                                        <th>Status</th> 
                                        <th>Action</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($queries)
                                    @foreach($queries as $key=>$query)
                                    <tr> 
                                        <td class="property-link"><a href="#">{{$key+1}}</a></td>
                                        <td class="property-link"><a href="{{url('admin/user-detail/'.base64_encode($query->user_id))}}">{{$query->name}}</a></td> 
                                        <td>{{$query->email}}</td>
                                        <td>{{date('d M Y H:i:s',strtotime($query->created_at))}}</td>
                                        <td><span class="text-{{$query->status == 1?'success':'danger'}}">{{$query->status == 1?'replied':'not replied'}}</span></td> 
                                        <td>
                                            <a href="{{url('admin/query-detail/'.base64_encode($query->id))}}" class="composemail"><i class="fa fa-eye"></i></a>
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
    @endsection