
@extends('admin.layout.master2')

@section('content')
<div class="container-fluid  wl-login">
    <div class="container ml-0 pl-0">
        <div class="login-box">
            <div class="form-section">
                <div class="login-logo">
                    <img src="{{asset('assets/images/logo.png')}}">
                </div>
                <h3>Hi, Welcome Back..!!</h3>
                <p>Login to your account</p>
                @if(session()->has('block'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('block') }}
                </div>
                @endif
                <form method=post action="{{url('admin/dologin')}}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" value="{{old('email')}}" placeholder="Email">
                        @if ($errors->has('email'))
                        <div class="help-block">
                            <strong class="text-danger text-small">{{ $errors->first('email') }}</strong>
                        </div>
                        @endif
                    </div>
                    <div class="form-group eyepassword">
                        <input type="password" name="password" id="password" class="form-control" value="{{old('password')}}" placeholder="Password">
                        <i class="fa fa-eye" onclick="showPassword(this,'password')"></i>
                        @if ($errors->has('password'))
                        <div class="help-block">
                            <strong class="text-danger text-small">{{ $errors->first('password') }}</strong>
                        </div>
                        @endif
                    </div> 
                    <button type="submit" class="btn btn-primary mybtns-send ">Sign In</button> 
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function showPassword(obj, id) {
        if ($('#' + id).attr('type') == 'text') {
            $('#' + id).attr('type', 'password');
            $(obj).removeClass('fa-eye-slash');
            $(obj).addClass('fa-eye');
        } else {
            $('#' + id).attr('type', 'text');
            $(obj).removeClass('fa-eye');
            $(obj).addClass('fa-eye-slash');
        }
    }
</script>
@endsection
