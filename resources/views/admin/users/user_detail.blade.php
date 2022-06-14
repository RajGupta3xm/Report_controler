@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>User Detail</h1> 
    </div>
    <div class="content userdetails">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box-profile text-white">
                            <div class="user-flag">
                                <img class="profile-user-img img-responsive img-circle m-b-1" src="{{$user->image?$user->image:asset('assets/images/user.png')}}" alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center text-black">{{$user->name}}</h3>
                            <p class="text-small text-muted text-center">&#64;{{$user->username}}</p>
                            <p class="text-dark text-center mt-2">{{$user->country}}
                                <!--<div>--> 
                                <img src="{{url($user->flag)}}" class="flag-icon"> 
                                <!--</div>-->

                            </p>
                            <p class="text-small text-center text-dark">Registered on: {{date('d M Y',strtotime($user->created_at))}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-4 col-xs-6 m-b-3">
                <div class="card">
                    <div class="card-body"><span class="info-box-icon bg-green"><i class="icon-phone"></i></span>
                        <div class="info-box-content"> <span class="info-box-number f-14">Mobile number</span>  <span class="info-box-text">
                                (+{{$user->country_code}}) {{$user->mobile}}  </span> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6 m-b-3">
                <div class="card">
                    <div class="card-body"><span class="info-box-icon bg-red"><i class="icon-envelope"></i></span>
                        <div class="info-box-content"> <span class="info-box-number f-14">Email Id </span>  <span class="info-box-text">
                                {{$user->email?$user->email:'N/A'}}</span> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6 m-b-3">
                <div class="card">
                    <div class="card-body"><span class="info-box-icon bg-yellow"><i class="icon-user"></i></span>
                        <div class="info-box-content"> <span class="info-box-number f-14">Total Fans</span>  <span class="info-box-text">
                                {{$user->fans?$user->fans:0}}</span> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header mb-4">
                <h5 class="card-title">Uploaded Videos</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('admin.user_post.filter')}}">
                    @csrf
                    <div class="row"> 
                        <input type="hidden" name="user_id" value="{{$user->id}}">
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
                            <a href='<?= url('admin/user-detail/' . base64_encode($user->id)) ?>' class="btn btn-primary pt-2 pb-2 w-100 mt-1">Reset</a>
                        </div>  
                        <div class="col-md-12 col-xs-12">
                            <p id="formError" class="text-danger"></p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Video Title</th>
                                    <th>Video Type</th>
                                    <th>Category</th>
                                    <th>Posted On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($user->posts)
                                @foreach($user->posts as $key=>$post)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$post->description}}</td>
                                    <td>{{$post->video_type == 1?'Standard':'Challenge'}}</td>
                                    <td>{{$post->category_name?$post->category_name:'none'}}</td>
                                    <td>{{date('d M Y H:i:s',strtotime($post->created_at))}}</td>  
                                    <td><a href="{{url('admin/video-detail/'.base64_encode($post->id))}}" class="composemail"><i class="fa fa-eye"></i></a>
                                        <a style="cursor:default;" onclick="changeVideoStatus(this,{{$post->id}})" class="composemail"><i class="fa fa-trash"></i></a>
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
    function changeVideoStatus(obj, id) {
    var confirm_chk = confirm('Are you sure to delete this video?');
    if (confirm_chk) {

    if (id) {
    $.ajax({
    url: "<?= url('admin/video/change_video_status') ?>",
            type: 'post',
            data: 'id=' + id + '&action=3&_token=<?= csrf_token() ?>',
            success: function (data) {
            if (data.error_code == "200") {
            alert(data.message);
            location.reload();
            } else {
            alert(data.message);
            }
            }
    });
    } else {
    alert("Something went wrong");
    }
    } else {
    return false;
    }
    }

    function filterList(obj){
    if ($(':input[name=start_date]').val() == '' && $(':input[name=end_date]').val() == ''){
    $("#formError").html('Select search attribute');
    } else{

    if ($(':input[name=start_date]').val() != '' && $(':input[name=end_date]').val() != ''){
    $('form').submit();
    } else{
    if ($(':input[name=start_date]').val() != ''){
    $("#formError").html('End date is required');
    } else if ($(':input[name=end_date]').val() != ''){
    $("#formError").html('Start date is required');
    } else{
    $("#formError").html('Select search attribute');
    }
    }
    }

    }
</script>
@endsection