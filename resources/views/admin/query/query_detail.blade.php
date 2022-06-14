@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Help & Support Detail</h1> 
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
                        <div class="row">
                            <div class="col-md-6">
                                <label>Query Id</label>
                                <p>#{{$query->id}}</p>
                            </div>
                            <div class="col-md-6">
                                <label>Query Date & Time</label>
                                <p>{{date('d M Y H:i:s',strtotime($query->created_at))}}</p>
                            </div>
                            <div class="col-md-6">
                                <label>User Name</label>
                                <p>{{$query->name}}</p>
                            </div>
                            <div class="col-md-6">
                                <label>Email Id</label>
                                <p>{{$query->email}}</p>
                            </div>
                            <div class="col-md-6">
                                <label>Query Status</label>
                                <p><span class="text-{{$query->status == 1?'success':'danger'}}">{{$query->status == 1?'replied':'not replied'}}</span>
                                </p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 mb-3">
                                <label>Reason For Contact</label>
                                <p>{{$query->subject}}</p>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Message</label>
                                <p>{{$query->message}}</p>
                            </div>
                            @if($query->reply)
                            <div class="col-md-12 mb-3">
                                <label>Reply</label>
                                <p>{{$query->reply}}</p>
                            </div>
                            @endif
                            <div class="col-md-12 text-right"> <a href="{{url('admin/query-management')}}" class="composemail">Go Back</a>
                                @if(!$query->reply)
                                <a class="composemail" onclick="$(this).hide();" id="openForm" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Reply</a>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="collapse" id="collapseExample">
                                    <form method="post" action="{{route('admin.query.reply')}}">
                                        @csrf
                                        <div class="card card-body">
                                            <label>Your Message</label>
                                            <textarea class="form-control" name="reply" cols="6" rows="6" placeholder="Write here...."></textarea>
                                            <p class="text-danger" id="error"></p>
                                            <div class="mt-4 mb-4 text-right"> <a style="cursor:default;" onclick="closeTab(this);" class="composemail">Cancel</a>  <a style="cursor:default;" onclick="sendReply(this,<?= $query->id ?>);" class="composemail">Send</a> 
                                            </div>
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
    <script>
        function sendReply(obj, id) {
            if (id) {
                var reply = $(":input[name=reply]").val();
                if (reply) {
                    $.ajax({
                        url: "<?= url('admin/query/reply') ?>",
                        type: 'post',
                        data: 'id=' + id + '&reply=' + reply + '&_token=<?= csrf_token() ?>',
                        success: function (data) {
                            if (data.error_code == "200") {
                                alert(data.message);
                                closeTab();
                                location.reload();
                            } else {
                                $("#error").html(data.message);
//                            alert(data.message);
                            }
                        }
                    });
                } else {
                    $("#error").html("Message field is required");
                }
            } else {
                alert("Something went wrong");
            }
        }

        function closeTab(obj) {
            $('.collapse').removeClass('show');
            $('#openForm').show();
            $(":input[name=reply]").val("");
            $("#error").html("");
        }
    </script>
@endsection