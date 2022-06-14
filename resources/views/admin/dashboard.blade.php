@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Dashboard</h1> 
    </div>

    <div class="content"> 
        <div class="row">
            <div class="col-lg-6 col-xs-6 m-b-3">
                <div class="card">
                    <div class="card-body"><span class="info-box-icon bg-green"><i class="icon-user"></i></span>
                        <div class="info-box-content"> <span class="info-box-number">{{$total_count}}</span> <span class="info-box-text">
                                Total Users </span> </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xs-6 m-b-3">
                <div class="card">
                    <div class="card-body"><span class="info-box-icon bg-red"><i class="icon-video"></i></span>
                        <div class="info-box-content"> <span class="info-box-number">{{$total_video}}</span> <span class="info-box-text">
                                Total Videos </span> </div>
                    </div>
                </div>
            </div>  
        </div>  

        <div class="card mb-4">
            <div class="card-header mb-4">
                <h5 class="card-title">Recent Users</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>User Name</th>
                                <th>Mobile Number</th>
                                <th>Registration Date</th>  
                                <th>Country</th> 
                                <th>Status</th> 
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @if($users)
                            @foreach($users as $k=>$user)
                            <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$user->name}}</td>
                                <td>+{{$user->country_code}}-{{$user->mobile}}</td>
                                <td>{{date('d-m-Y',strtotime($user->created_at))}}</td>
                                <td>{{$user->country}}</td>
                                <td>
                                    @if($user->status > 0)
                                    <div class="mytoggle">
                                        <label class="switch">
                                            <input type="checkbox" <?= $user->status == 1 ? 'checked' : '' ?> onchange="changeUserStatus(this,'{{$user->id}}');"> <span class="slider round"> </span> 
                                        </label>
                                    </div>
                                    @else
                                    Not Active
                                    @endif
                                </td> 
                                <td><a href="{{url('admin/user-detail/'.base64_encode($user->id))}}" class="composemail"><i class="fa fa-eye"></i></a></td> 
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
        function changeUserStatus(obj, id) {
        var confirm_chk = confirm('Are you sure to change user status?');
        if (confirm_chk) {
        var checked = $(obj).is(':checked');
        if (checked == true) {
        var status = 1;
        } else {
        var status = 2;
        }
        if (id) {
        $.ajax({
        url: "<?= url('admin/user/change_user_status') ?>",
                type: 'post',
                data: 'id=' + id + '&action=' + status + '&_token=<?= csrf_token() ?>',
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
    </script>

    @endsection