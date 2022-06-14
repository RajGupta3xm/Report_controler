@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Report Reason Management</h1>
    </div>
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header mb-4">
                        <h5 class="card-title">Edit Reason</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" id="addForm" enctype="multipart/form-data" action="{{route('admin.reason.update',[base64_encode($reason->id)])}}">
                            @csrf
                            <div class="row">

                                @csrf
                                <div class="col-md-6 offset-3"> 
                                    <label>Enter Challenge Category Name</label>
                                    <input type="text" name="reason" value="{{$reason->reason}}" class="form-control validate" placeholder="Reason">
                                    <p class="text-danger" id="reasonError"></p>

                                    <div class="text-center mb-4 mt-5">
                                        <button type="button" onclick="validate(this);" class="btn btn-primary">Upload</button>                   
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
<script>
    function validate(obj) {
        var flag = true;
        var formData = $("#addForm").find(".validate:input").not(':input[type=button]');
        $(formData).each(function () {
            var element = $(this);
            var val = element.val();
            var name = element.attr("name");
            if (val == "" || val == "0" || val == null) {
                $("#" + name + "Error").html("This field is required");
                flag = false;
            } else {
                $("#" + name + "Error").html("");
            }
        });

        if (flag) {
            $("#addForm").submit();
        } else {
            return false;
        }
    }
</script>
@endsection