@extends('admin.layout.master')

@section('content')
<style>


    .chosen-single{
        /*margin-top: 10px;*/
        width: 100%;
        max-width: 350px;
        height: 38px !important;
        border-radius: 5px;
        /*background: -webkit-linear-gradient(top, #ffffff 20%, #f6f6f6 50%, #eeeeee 52%, #f4f4f4 100%) !important;*/
        border: 1px solid #ccc !important;
        color: #495057;
        font-size: 14px;
        box-shadow:0;

    }

    .chosen-single span{
        padding-top: 5px;
    }

    .chosenImage-container .chosen-single {
        /*padding-left: 2px;*/
        background-position: left 7px top 8px;
    }

</style>

<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>user List</h1> 
    </div>
    <div class="content">  
        <div class="card mb-2">
            <div class="card-body">
                <form method="post" action="{{route('admin.user.filter')}}">
                    @csrf
                    <div class="row"> 
                        <div class="col-md-4 col-xs-6">
                            <div class="form-group">
                                <label>Select a Country </label>
                                <select class="form-control my-select"  data-placeholder="Choose a Project..." id="country" name="country">
                                    <option value="" data-img-src="{{asset('assets/images/globe.png')}}" selected>Select Country</option>
                                    @if($country_list)
                                    @foreach($country_list as $country)
                                    <option data-img-src="{{url($country->flag)}}" <?= isset($country_name) ? ($country_name == $country->country ? 'selected' : '') : '' ?>> {{$country->country}}</option>
                                    @endforeach
                                    @endif
                                </select> 
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-6">
                            <div class="form-group">
                                <label>From </label>
                                <input type="date" name="start_date" onchange="$('#start_date').attr('min', $(this).val());" max="<?= date('Y-m-d') ?>" value="{{isset($start_date)?$start_date:''}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-6">
                            <div class="form-group">
                                <label>To </label>
                                <input type="date" id="start_date" name="end_date" max="<?= date('Y-m-d') ?>" value="{{isset($end_date)?$end_date:''}}" class="form-control">
                            </div>
                        </div> 
                        <div class="col-md-12 col-xs-12">
                            <p id="formError" class="text-danger"></p>
                        </div>
                        <div class="col-md-4 col-xs-6 mt-1 offset-4">
                            <a href="#filter" onclick="filterList(this)"; class="btn btn-primary pt-2 pb-2 w-100 mt-1">Search</a>
                        </div> 
                        <div class="col-md-4 col-xs-6 mt-1">
                            <a href='<?= url('admin/user-management') ?>' class="btn btn-primary pt-2 pb-2 w-100 mt-1">Reset</a>
                        </div>     
                    </div> 
                </form>  
            </div>   
        </div>   
        <div class="card">
            @if(session()->has('error'))  
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session()->get('error') }}
            </div>
            @endif
            <div class="card-body">  

                <div class="table-responsive">
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Full Name</th>
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
                                <td>+{{$user->country_code}} {{$user->mobile}}</td>
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
                                    <label class="text-muted">Not Active</label>
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

        function filterList(obj){
        if (($(':input[name=country]').val() == null || $(':input[name=country]').val() == '') && $(':input[name=start_date]').val() == '' && $(':input[name=end_date]').val() == ''){
        $("#formError").html('Select search attribute');
        } else{
        if ($(':input[name=country]').val() != null){
        $('form').submit();
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

        }
    </script>

    @endsection