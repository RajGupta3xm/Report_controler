@extends('admin.layout.master')
@section('content')
      <div class="admin_main">
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    <strong class="close" data-dismiss="alert " aria-hidden="true"></strong>
                    {{ session()->get('success') }}
                </div>
                @else 
                @if(session()->has('error'))  
                <div class="alert alert-danger">
                    <strong class="close" ></strong>
                    {{ session()->get('error') }}
                </div>
                @endif 
                @endif
               <div class="row add_staff justify-content-center">
                  <div class="col-12 mb-4 design_outter_comman recent_orders shadow">
                     <div class="row comman_header justify-content-between">
                         <div class="col-auto">
                             <h2>Add Staff New Group</h2>
                         </div>
                     </div>
                     <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/staff_group/submit')}}">
                        @csrf
                         <div class="form-group mb-0 col"> <label for="">Group Name (En)</label> <input type="text" class="form-control validate" value="" name="name" id="name"><p class="text-danger text-small" id="nameError"></p> </div>
                         <div class="form-group mb-0 col"> <label for="">Group Name (Ar)</label> <input type="text" class="form-control validate" value="" name="name_ar" id="name"><p class="text-danger text-small" id="name_arError"></p> </div>
                         <div class="form-group mb-0 col choose_file position-relative"> <span>Upload Image</span> <label for="upload_video"><i class="fal fa-camera me-1"></i>Choose File</label> <input type="file" class="form-control validate" value="" name="image" id="upload_video"> <p class="text-danger text-small" id="imageError"></p></div>
                         <div class="form-group mb-0 col-auto"> <button type="button" onclick="validate(this)" class="comman_btn">Save</button> </div>
                     </form>
                  </div>
                  <div class="col-12 mb-4 design_outter_comman recent_orders shadow">
                     <div class="row comman_header justify-content-start">
                         <div class="col">
                             <h2>Staff Groups Management</h2>
                         </div>
                         <div class="col-3">
                             <form class="form-design" action="">
                                <div class="form-group mb-0 position-relative icons_set">
                                   <input type="text" class="form-control" placeholder="Search" name="name" id="name">
                                   <i class="far fa-search"></i>
                                </div>
                             </form>
                          </div>
                         <div class="col-auto text-end">
                             <div class="dropdown more_filters"> <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"> Filters </button>
                                 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                     <form action="">
                                         <div class="form-group mb-2"> <label for="">Status :</label> <select class="form-select form-control" aria-label="Default select example">
                                                 <option selected="" disabled="">Status</option>
                                                 <option value="1">Active</option>
                                                 <option value="2">Draft</option>
                                             </select> 
                                         </div>
                                     </form>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-12 comman_table_design bg-white px-0">
                             <div class="table-responsive">
                                 <table class="table mb-0">
                                     <thead>
                                         <tr>
                                             <th>S.No.</th> 
                                             <th>Media</th>
                                             <th>Group Name (En)</th>
                                             <th>Group Name (Ar)</th>
                                             <th>Status</th>
                                             <th>Action</th> 
                                         </tr>
                                     </thead>
                                     <tbody>
                                        @foreach($staff_group as $key=>$staff_groups)
                                         <tr>
                                             <td>{{$key+1}}</td>
                                             <td> <img class="table_img" src="{{$staff_groups->image?$staff_groups->image:asset('assets/img/bg-img.jpg')}}" alt=""> </td>
                                             <td>{{$staff_groups->name}}</td>
                                             <td>{{$staff_groups->name_ar}}</td>
                                             <td>
                                               <div class="mytoggle">
                                                  <label class="switch">
                                                      <input type="checkbox" onchange="changeStatus(this, '<?= $staff_groups->id ?>');" <?= ( $staff_groups->status == 'active' ? 'checked' : '') ?>><span class="slider"></span><span class="labels"> </span> 
                                                    </label>
                                                </div>
                                             </td>
                                             <td> 
                                                 <a class="comman_btn table_viewbtn" href="javscript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop08{{$staff_groups->id}}">Edit</a> 
                                                
                                                 <a class="comman_btn table_viewbtn delete_btn" onclick="deleteData(this,'{{$staff_groups->id}}');" href="javscript:;">Delete</a> 
                                             </td> 
                                         </tr>
                                         @endforeach
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
@foreach($staff_group as $key=>$staff_groups)
<div class="modal fade comman_modal" id="staticBackdrop08{{$staff_groups->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content border-0">
       <div class="modal-header">
         <h5 class="modal-title" id="staticBackdropLabel">Edit Group</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body">
         <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" id="queryForms"> 
         @csrf
           <div class="form-group mb-0 col"> <label for="">Group Name (En)</label> <input type="text" class="form-control" value="{{$staff_groups->name}}" name="name" id="name"> </div>
           <div class="form-group mb-0 col"> <label for="">Group Name (Ar)</label> <input type="text" class="form-control" value="{{$staff_groups->name_ar}}" name="name_ar" id="name"> </div>
           <div class="form-group mb-0 col choose_file position-relative"> <span>Upload Image</span> <label for="img1"><i class="fal fa-camera me-1"></i>Choose File</label> <input type="file" class="form-control" name="images" id="img1"> </div>
           <div class="form-group mb-0 col-auto"> <button type="button" onclick="sendReply(this,<?= $staff_groups->id ?>)" class="comman_btn">Save</button> </div>
         </form>
       </div> 
     </div>
   </div>
</div>
@endforeach
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script>
 $(window).load(function(){
   setTimeout(function(){ $('.alert-danger').fadeOut('slow') }, 3000);
});
  </script>
   <script>
 $(window).load(function(){
   setTimeout(function(){ $('.alert-success').fadeOut('slow') }, 3000);
});
  </script>
   <script>
    
function sendReply(obj, id) {

var flag = true;
let _token = $('input[name=_token]').val();
var myForm = $("#queryForms")[0];
var formData = new FormData(myForm);
if (flag) {
    $.ajax({
        _token: _token,
        url: "<?= url('admin/edit_staff_group/update/') ?>/" + id,
        type: 'POST',
        //data: $("#carForm").serialize(),
        enctype: 'multipart/form-data',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {
            swal({
                title: "Details Updated!",
                text: data.message,
                icon: "success",
                buttons: false,
            });
            setTimeout(function() {
                location.reload();
            }, 2000);
        }
    });
}
}               
</script>
 
<script>
       function changeStatus(obj, id) {
            swal({
                title: "Are you sure?",
                text: " status will be closed",
                icon: "warning",
                buttons: ["No", "Yes"],
                dangerMode: true,
            })
                    .then((willDelete) => {
                        if (willDelete) {
                            var checked = $(obj).is(':checked');
                            if (checked == true) {
                                var status = 'active';
                            } else {
                                var status = 'inactive';
                            }
                            if (id) {
                                $.ajax({
                                    url: "<?= url('admin/staff_group_status/change_status') ?>",
                                    type: 'post',
                                    data: 'id=' + id + '&action=' + status + '&_token=<?= csrf_token() ?>',
                                    success: function (data) {
                                    
                                        swal({
                                           title: "Success!",
                                            text : "Status has been Updated ",
                                            icon : "success",
                                        })
                                    }
                                });
                            } else {
                                var data = {message: "Something went wrong"};
                                errorOccured(data);
                            }
                        } else {
                            var checked = $(obj).is(':checked');
                            if (checked == true) {
                                $(obj).prop('checked', false);
                            } else {
                                $(obj).prop('checked', true);
                            }
                            return false;
                        }
                    });
        }
    </script>

<script>
      function deleteData(obj, id){
            //var csrf_token=$('meta[name="csrf_token"]').attr('content');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this record!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url : "<?= url('admin/staff-group-delete') ?>",
                        type : "POST",
                        data : 'id=' + id + '&_token=<?= csrf_token() ?>',
                        success: function(data){
                            swal({
                                title: "Success!",
                                text : "Group has been deleted \n Click OK to refresh the page",
                                icon : "success",
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error : function(){
                            swal({
                                title: 'Opps...',
                                text : data.message,
                                type : 'error',
                                timer : '1500'
                            })
                        }
                    })
                } else {
                swal("Your  file is safe!");
                }
            });
        }
        
</script>
<script>
            function validate(obj) {
            $(".text-danger").html('');
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

                }
            });
           
            if (flag) {
                $("#addForm").submit();
            } else {
                return false;
            }

            
        }
    </script>