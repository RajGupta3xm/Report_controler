@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Participants Videos</h1> 
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">

                @if($posts)
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="banner-section-start">

                            <div class="row">

                                @foreach($posts as $post)
                                <div class="col-md-6 mb-4">
                                    <div class="post-section">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="user-name">
                                                    <h4>{{$post['name']}}</h4>
                                                    <a style="font-size:13px;" href="{{url('admin/user-detail/'.base64_encode($post['user_id']))}}">&#64;{{$post['username']}}</a>
                                                    <p><span class="text-dark" style="font-size:16px;">{{$post['description']}}</span></p>
                                                    <p class="mb-0">{{date('d M Y',strtotime($post['created_at']))}} at {{date('H:i',strtotime($post['created_at']))}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="reply-section reply-section1 my-video">
                                                    <div class="text-right trash-icon"> 
                                                        <a class="text-dark" style="cursor:default;" onclick="changeVideoStatus(this,{{$post['id']}})"><i class="fa fa-trash"></i></a> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!--                                                <div class="post-box">
                                                                                                    <div class="post-img">-->
                                                <iframe height="280" width="100%" src='{{$post['video']}}' style="background-image:url(<?=$post['thumbnail']?>);background-size: cover;">

                                                </iframe>
<!--                                                        <img src="{{asset('assets/images/03.jpg')}}">
                                                <p class="time">01:00</p>-->
                                                <!--                                                    </div>
                                                                                                </div>-->

                                                <div class="video-views"> 
                                                    <a href="#"><i class="fa fa-thumbs-up"></i> {{($post['total_likes'] > 1000 || $post['total_likes'] == 1000)?(($post['total_likes'])/1000).'K':$post['total_likes'] }} Likes</a>
                                                    <a href="#" class="ml-2"><i class="fa fa-comment"></i> {{($post['total_comments'] > 1000 || $post['total_comments'] == 1000)?(($post['total_comments'])/1000).'K':$post['total_comments'] }} Comments</a>
                                                    <span class="pull-right"><a href="#"><i class="fa fa-eye"></i> {{($post['total_views'] > 1000 || $post['total_views'] == 1000)?(($post['total_views'])/1000).'K':$post['total_views'] }} Views</a></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>

                        </div>

                    </div>
                </div>
                @else
                <p>No participation videos uploaded.<p>
                    @endif

            </div>
        </div>
    </div>
    <script>
        function changeVideoStatus(obj, id) {
        var confirm_chk = confirm('Are you sure to delete this video?');
        if (confirm_chk) {

        if (id) {
        $.ajax({
        url: "<?= url('admin/video/change_participationvideo_status') ?>",
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
    </script>
    @endsection