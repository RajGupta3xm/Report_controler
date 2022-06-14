@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Report List</h1> 
    </div>

    <div class="content">   

        <div class="card mb-2">
            <form method="post" action="{{route('admin.report.filter')}}">
                @csrf
                <div class="card-body">
                    <div class="row"> 
                        <div class="col-lg-3 col-xs-6">
                            <div class="form-group">
                                <label>From </label>
                                <input type="date" onchange="$('#start_date').attr('min', $(this).val());" max="<?= date('Y-m-d') ?>"  value="{{isset($start_date)?$start_date:''}}"  name="start_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="form-group">
                                <label>To </label>
                                <input type="date" id="start_date" name="end_date" max="<?= date('Y-m-d') ?>" value="{{isset($end_date)?$end_date:''}}" class="form-control">
                            </div>
                        </div> 
                        <div class="col-md-3 col-xs-6 mt-4">
                            <a href="#filter" onclick="filterList(this)"; class="btn btn-primary pt-2 pb-2 w-100 mt-1">Search</a>
                        </div> 
                        <div class="col-md-3 col-xs-6 mt-4">
                            <a href='<?= url('admin/video-management') ?>' class="btn btn-primary pt-2 pb-2 w-100 mt-1">Reset</a>
                        </div>  
                        <div class="col-md-12 col-xs-12">
                            <p id="formError" class="text-danger"></p>
                        </div>
                    </div>  
                </div>   
            </form>
        </div>   
        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Shared by</th>
                                <th>Video Title</th>
                                <th>Report For</th>
                                <th>Posted On</th>  
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @if($posts)
                            @foreach($posts as $key=>$post)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><a class="view-link" href="{{url('admin/user-detail/'.base64_encode($post->user_id))}}">&#64;{{$post->username}}</a></td>
                                <td>{{$post->title}}</td>
                                <td>{{$post->reason_id}}</td>
                                <td>{{date('d-m-Y H:i:s',strtotime($post->created_at))}}</td>  
                                <td>
                                    <a href="{{url('admin/report-detail/'.base64_encode($post->id))}}" class="edit-composemail"><i class="fa fa-eye"></i></a>
                                    <!--<a href="#" class="edit-composemail"><i class="fa fa-trash"></i></a>-->
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
    <script>
        function filterList(obj) {
            if ($(':input[name=start_date]').val() == '' && $(':input[name=end_date]').val() == '') {
                $("#formError").html('Select filter attribute');
            } else {

                if ($(':input[name=start_date]').val() != '' && $(':input[name=end_date]').val() != '') {
                    $('form').submit();
                } else {
                    if ($(':input[name=start_date]').val() != '') {
                        $("#formError").html('End date is required');
                    } else if ($(':input[name=end_date]').val() != '') {
                        $("#formError").html('Start date is required');
                    } else {
                        $("#formError").html('Select filter attribute');
                    }
                }
            }

        }
    </script>
@endsection