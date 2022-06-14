@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Report Detail</h1> 
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="banner-section-start">
                            <div class="post-section">
                                @if($post)
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="user-name">

                                            <h4>{{$post->name}} <a class="view-link" href="{{url('admin/user-detail/'.base64_encode($post->user_id))}}">&#64;{{$post->username}}</a></h4>

                                            <p>{{date('d-m-Y H:i:s',strtotime($post->created_at))}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="reply-section reply-section1 my-video">
                                            <div class="text-right trash-icon"> <a class="text-dark" style="cursor:default;" onclick="changeVideoStatus(this,{{$post->id}})"><i class="fa fa-trash"></i></a> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="post-data pt-0">
                                    <h3>{{$post->description}}</h3>
                                    <!-- <p style='max-height: 80px;overflow-y: hidden;' id='desc'>
                                        {{strlen($post->description) > 467 ? substr($post->description,0,459):$post->description}}

                                        @if(strlen($post->description) > 467)
                                        ... <a style="color: #ee6e52;cursor:default;"  onclick="viewalltext(this, 1);">See more</a>
                                        @endif
                                    </p> -->
                                    <p id='full_desc' style='display:none;'>
                                        {{$post->description}}
                                        <a style="color: #ee6e52;cursor:default;" onclick="viewalltext(this, 2);">See less</a>
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="post-box">
                                            <div class="post-img">
                                                <iframe height="300" width="100%" src="{{$post->video}}" style="background-image:url(<?= $post->thumbnail ?>);background-size: cover;">

                                                </iframe>
<!--                                                <img src="{{asset('assets/admin/images/song.jpg')}}">
                                                <p class="time">01:00</p>-->
                                            </div>
                                            <div class="video-views"> 
                                                <a href="#"><i class="fa fa-thumbs-up"></i> {{($post->total_likes > 1000 || $post->total_likes == 1000)?(($post->total_likes)/1000).'K':$post->total_likes }} Likes</a>
                                                <a href="#" class="ml-2"><i class="fa fa-comment"></i> {{($post->total_comments > 1000 || $post->total_comments == 1000)?(($post->total_comments)/1000).'K':$post->total_comments }} Comments</a>
                                                <span class="pull-right"><a href="#"><i class="fa fa-eye"></i> {{($post->total_views > 1000 || $post->total_views == 1000)?(($post->total_views)/1000).'K':$post->total_views }} Views</a></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card text-center text-white bg-gray">
                                                    <div class="card-body">
                                                        <label class="mb-0">Video Type</label>
                                                        <p>{{$post->video_type==1?'Standard':'Challenge'}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <div class="card text-center text-white bg-gray">
                                                    <div class="card-body">
                                                        <label class="mb-0">Category</label>
                                                        <p>{{$post->category_name?$post->category_name:'Category applicable on challenge video only'}}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <div class="card text-center text-white bg-gray">
                                                    <div class="card-body">
                                                        <label class="mb-0">Participants' Videos</label>
                                                        @if($post->video_type==2)
                                                        @if($post->participant_video)
                                                        <a href="{{url('admin/participants/'.base64_encode($post->id))}}">
                                                            <p>{{$post->participant_video}} videos</p>
                                                        </a>
                                                        @else
                                                        <p>no participants</p>
                                                        @endif
                                                        @else
                                                        <p>Participation applicable on challenge video only</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <label class="mb-0">Report For</label>
                                        <p><strong>{{$report->reason_id}}</strong></p>
                                        <p>{{$report->description}}</p>
                                    </div>
                                    <div class="col-md-12 user-name">
                                        <!--<label class="text-small">Report By</label>-->
                                        <p class="mb-0 text-right"><span class="text-black">Reported by :</span> <strong>{{$report->name}} <a class="view-link" href="{{url('admin/user-detail/'.base64_encode($report->user_id))}}">&#64;{{$report->username}}</a></strong></p>
                                        <p class="text-right"><span class="text-black">Reported on :</span> <i>{{date('d M Y H:i:s',strtotime($report->created_at))}}</i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function viewalltext(obj, type) {
            if (type == 1) {
                $("#full_desc").css('display', 'block');
                $("#desc").css('display', 'none');
            } else {
                $("#desc").css('display', 'block');
                $("#full_desc").css('display', 'none');
            }
        }

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
                                window.location.href = "<?= url('admin/video-management') ?>";
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