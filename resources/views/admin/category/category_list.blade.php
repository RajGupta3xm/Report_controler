@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Category Management</h1>
        <!--        <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li><i class="fa fa-angle-right"></i> Category Management</li>
                </ol>-->
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
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
                <div class="card">
                    <div class="card-header mb-4">
                        <h5 class="card-title">Add Category</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" id="addForm" enctype="multipart/form-data" action="{{route('admin.category.store')}}">
                            <div class="row">

                                @csrf
                                <div class="col-md-6 offset-3"> 
                                    <label>Enter Challenge Category Name</label>
                                    <input type="text" name="category_name"  class="form-control validate" placeholder="Category Name">
                                    <p class="text-danger" id="category_nameError"></p>

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





    <div class="col-md-12 mt-4">
        <div class="card"> 
            <div class="card-header">
                <h5 class="card-title">Category List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive table-image">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Category Name</th>
                                <th>Status</th> 
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @if($categories)
                            @foreach($categories as $key=>$category)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$category->name}}</td>
                                <td>
                                    <div class="mytoggle">
                                        <label class="switch">
                                            <input type="checkbox" onchange="changeCategoryStatus(this,'{{$category->id}}');" <?= ($category->status == '1' ? 'checked' : '') ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td> 
                                <td>
                                    <a href="{{url("admin/edit-category").'/'.base64_encode($category->id)}}" class="edit-composemail"><i class="fa fa-edit"></i></a>
                                    <a href="#" onclick="deleteCategory(this,'{{$category->id}}');" class="edit-composemail"><i class="fa fa-trash"></i></a>
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
                if (val.length < 3) {
                    $("#" + name + "Error").html("minimum 3 characters are required");
                    flag = false; 
                }else{
                    $("#" + name + "Error").html("");
                }
            }
        });
        if (flag) {
            $("#addForm").submit();
        } else {
            return false;
        }
    }

    function changeCategoryStatus(obj, id) {
        var confirm_chk = confirm('Are you sure to change category status?');
        if (confirm_chk) {
            var checked = $(obj).is(':checked');
            if (checked == true) {
                var status = 1;
            } else {
                var status = 0;
            }
            if (id) {
                $.ajax({
                    url: "<?= url('admin/category/change_category_status') ?>",
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

    function deleteCategory(obj, id) {
        var confirm_chk = confirm('Are you sure to delete category?');
        if (confirm_chk) {
            if (id) {
                $.ajax({
                    url: "<?= url('admin/category/delete') ?>",
                    type: 'post',
                    data: 'id=' + id + '&_token=<?= csrf_token() ?>',
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