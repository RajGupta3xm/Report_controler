
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
               <div class="row fitness-goal-management justify-content-center">
                  <div class="col-12">
                     <div class="row mx-0">
                        <div class="col-12 design_outter_comman shadow mb-4">
                           @if(Session::get('admin_logged_in')['type']=='0')
                           <div class="row comman_header justify-content-between" style="margin-bottom: 14px;">
                              <div class="col">
                                 <h2>Fitness Goal Management</h2>
                              </div>
                           </div>
                           <form class="form-design py-4 px-4 row align-items-start justify-content-start mb-4  needs-validation" novalidate  method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/fitness-goal/submit')}}">
                            @csrf
                              <div class="col-md-12">
                                 <div class="row">
                                    <div class="col-6 pe-5 border-end mb-4">
                                       <div class="form-group">
                                          <label for="validationCustom01"> Title (English):</label>
                                          <input type="text" class="form-control validate" value="" name="name" id="validationCustom01" required maxlength="20"> 
                                          <!-- <p class="text-danger text-small" id="nameError"> -->
                                          <div class="invalid-feedback">
                                              Please choose a username.
                                           </div>
                                       </div> 
                                       <!-- <div class="form-group uploadimg_box">
                                          <span>Media (English):</span>
                                          <input type="file" id="uploadimg" name="image" class="d-none ">
                                          <label for="uploadimg">
                                             <div class="uploadimg_inner">
                                                <i class="fas fa-upload me-2"></i>
                                                <span>Upload File</span>
                                             </div>
                                          </label>
                                       </div>   -->
                                       <div class="form-group col-12 uploadimg_box"> <span>Media :</span>
                                        <input type="file" id="uploadimg" class="validate dropify" name="image" accept="image/*">
{{--                                       <label for="uploadimg">--}}
{{--                                        <div class="uploadimg_inner"> <i class="fas fa-upload me-2"></i> <span>Upload File</span> </div>--}}
{{--                                                </label>--}}
                                                <p class="text-danger text-small" id="imageError"></p>
                                          </div>
                                    </div> 
                                    <div class="col-6 ps-5 mb-4">
                                       <div class="form-group">
                                          <label for=""> Title (Arabic):</label>
                                          <input type="text" class="form-control validate" value="" name="name_ar" id="name" maxlength="20">
                                          <p class="text-danger text-small" id="name_arError">
                                       </div> 
                                       <!-- <div class="form-group uploadimg_box">
                                          <span>Media (Arabic):</span>
                                          <input type="file" id="uploadimg1" name="image_ar" class="d-none ">
                                          <label for="uploadimg1">
                                             <div class="uploadimg_inner">
                                                <i class="fas fa-upload me-2"></i>
                                                <span>Upload File</span>
                                             </div>
                                          </label>
                                        
                                       </div>   -->
                                       <div class="form-group col-12 uploadimg_box"> <span>Media :</span>
                                        <input type="file" id="uploadimg1" class="validate dropify" name="image_ar" accept="image/*">
{{--                                       <label for="uploadimg1">--}}
{{--                                        <div class="uploadimg_inner"> <i class="fas fa-upload me-2"></i> <span>Upload File</span> </div>--}}
{{--                                                </label>--}}
                                                <p class="text-danger text-small" id="image_arError"></p>
                                          </div>
                                    </div>  
                                    <div class="form-group mb-0 col-12 text-center">
                                       <button type="submit" onclick="validate(this)" class="comman_btn">Save</button>
                                    </div>
                                 </div>
                              </div>   
                           </form>
                           @endif
                           @if(Session::get('admin_logged_in')['type']=='1')
                           @if(Session::get('staff_logged_in')['fitness_goal_mgmt']=='1')
                           <div class="row comman_header justify-content-between" style="margin-bottom: 14px;">
                              <div class="col">
                                 <h2>Fitness Goal Management</h2>
                              </div>
                           </div>
                           @endif
                           @endif
                           @if(Session::get('admin_logged_in')['type']=='1')
                           @if(Session::get('staff_logged_in')['fitness_goal_mgmt']!='1')
                           <form class="form-design py-4 px-4 row align-items-start justify-content-start mb-4"  method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/fitness-goal/submit')}}">
                            @csrf
                              <div class="col-md-12">
                                 <div class="row">
                                    <div class="col-6 pe-5 border-end mb-4">
                                       <div class="form-group">
                                          <label for=""> Title (English):</label>
                                          <input type="text" class="form-control validate" value="" name="name" id="name" maxlength="20"> 
                                          <p class="text-danger text-small" id="nameError">
                                       </div> 
                                       <!-- <div class="form-group uploadimg_box">
                                          <span>Media (English):</span>
                                          <input type="file" id="uploadimg" name="image" class="d-none ">
                                          <label for="uploadimg">
                                             <div class="uploadimg_inner">
                                                <i class="fas fa-upload me-2"></i>
                                                <span>Upload File</span>
                                             </div>
                                          </label>
                                       </div>   -->
                                       <div class="form-group col-12 uploadimg_box"> <span>Media :</span>
                                        <input type="file" id="uploadimg" class="validate dropify" name="image" accept="image/*">
{{--                                       <label for="uploadimg">--}}
{{--                                        <div class="uploadimg_inner"> <i class="fas fa-upload me-2"></i> <span>Upload File</span> </div>--}}
{{--                                                </label>--}}
                                                <p class="text-danger text-small" id="imageError"></p>
                                          </div>
                                    </div> 
                                    </div> 
                                    <div class="col-6 ps-5 mb-4">
                                       <div class="form-group">
                                          <label for=""> Title (Arabic):</label>
                                          <input type="text" class="form-control validate" value="" name="name_ar" id="name" maxlength="20">
                                          <p class="text-danger text-small" id="name_arError">
                                       </div> 
                                       <div class="form-group col-12 uploadimg_box"> <span>Media :</span>
                                        <input type="file" id="uploadimg1" class="validate dropify" name="image_ar" accept="image/*">
{{--                                       <label for="uploadimg1">--}}
{{--                                        <div class="uploadimg_inner"> <i class="fas fa-upload me-2"></i> <span>Upload File</span> </div>--}}
{{--                                                </label>--}}
                                                <p class="text-danger text-small" id="image_arError"></p>
                                          </div>
                                       <!-- <div class="form-group uploadimg_box">
                                          <span>Media (Arabic):</span>
                                          <input type="file" id="uploadimg1" name="image_ar" class="d-none ">
                                          <label for="uploadimg1">
                                             <div class="uploadimg_inner">
                                                <i class="fas fa-upload me-2"></i>
                                                <span>Upload File</span>
                                             </div>
                                          </label>
                                       </div>   -->
                                    </div>  
                                    <div class="form-group mb-0 col-12 text-center">
                                       <button type="button" onclick="validate(this)" class="comman_btn">Save</button>
                                    </div>
                                 </div>
                              </div>   
                           </form>
                           @endif
                           @endif
                           <div class="row mx-0 pb-4 px-4">
                              <div class="col-12 design_outter_comman border">
                                 <div class="row comman_header justify-content-between">
                                    <div class="col-auto">
                                       <h2>Fitness Goals</h2>
                                    </div>
                                 </div> 
                                 <div class="row">
                                    <div class="col-12 comman_table_design px-0">
                                       <div class="table-responsive">
                                          <table class="table mb-0">
                                             <thead>
                                               <tr>
                                                 <th>S.No.</th>
                                                 <th>Title(En)</th>
                                                 <th>Title(Ar)</th>
                                                 <th>Media(En)</th>
                                                 <th>Media(Ar)</th>
                                                 @if(Session::get('admin_logged_in')['type']=='0')
                                                 <th>Status</th> 
                                                 <th>Action</th> 
                                                 @endif
                                                 @if(Session::get('admin_logged_in')['type']=='1')
                                                  @if(Session::get('staff_logged_in')['fitness_goal_mgmt']!='1')
                                                 <th>Status</th> 
                                                 <th>Action</th> 
                                                 @endif
                                                 @endif
                                               </tr>
                                             </thead>
                                             <tbody>
                                                @foreach($fitness_goal as $key=>$fitness_goals)
                                               <tr>
                                                 <td>{{$key+1}}</td>
                                                 <td>{{$fitness_goals->name}}</td>
                                                 <td>{{$fitness_goals->name_ar}}</td> 
                                                 <td><img class="table_imggg" src="{{$fitness_goals->image}}" alt=""></td>
                                                 <td><img class="table_imggg" src="{{$fitness_goals->image_ar}}" alt=""></td> 
                                                 @if(Session::get('admin_logged_in')['type']=='0')
                                                 <td>
                                                   <div class="mytoggle">
                                                      <label class="switch">
                                                            <input type="checkbox" onchange="changeStatus(this, '<?= $fitness_goals->id ?>');" <?= ( $fitness_goals->status == 'active' ? 'checked' : '') ?>><span class="slider"></span><span class="labels"> </span> 
                                                        </label>
                                                   </div>
                                                </td>
                                                <td> 
                                                   <!-- <a class="comman_btn table_viewbtn" href="javscript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop07">Edit</a>  -->
                                                   <a class="comman_btn table_viewbtn " onclick="getFitnessData(this,'{{$fitness_goals->id}}');"  href="javscript:;"  data-toggle="modal"  >Edit</a> 
                                                   <a class="comman_btn table_viewbtn delete_btn" onclick="deleteFitnessData(this,'{{$fitness_goals->id}}');" href="javscript:;">Delete</a> 
                                                </td> 
                                                @endif
                                                 @if(Session::get('admin_logged_in')['type']=='1')
                                                  @if(Session::get('staff_logged_in')['fitness_goal_mgmt']!='1')
                                                 <td>
                                                   <div class="mytoggle">
                                                      <label class="switch">
                                                            <input type="checkbox" onchange="changeStatus(this, '<?= $fitness_goals->id ?>');" <?= ( $fitness_goals->status == 'active' ? 'checked' : '') ?>><span class="slider"></span><span class="labels"> </span> 
                                                        </label>
                                                   </div>
                                                </td>
                                                @endif
                                                @endif
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
               </div>
            </div>
         </div>
      </div> 
        <!------------------------------------------------- Fitness Goal modal ------------------------------------------>
        <div class="modal fade comman_modal" id="staticBackdrop09" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Edit Group</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" id="fitnessGoalForm"> 
              @csrf
              <input type="hidden" class="form-control"  id="id" name="id" >
               <div class="col-md-12">
                  <div class="row">
                     <div class="col-6 pe-5 border-end mb-4">
                           <div class="form-group">
                              <label for=""> Title (English):</label>
                              <input type="text" class="form-control validate" value="" name="title_name" id="title_name" maxlength="20"> 
                              <p class="text-danger text-small" id="nameError">
                           </div>  
                           <div class="form-group col-12 uploadimg_box"> <span>Media :</span>
                             <input type="file" id="uploadimg4" class="dropify" name="images" data-default-file="" accept="image/*">
                              <p class="text-danger text-small" id="imagesError"></p>
                           </div>
                     </div> 
                     <div class="col-6 ps-5 mb-4">
                        <div class="form-group">
                          <label for=""> Title (Arabic):</label>
                           <input type="text" class="form-control validate" value="" name="title_name_ar" id="title_name_ar" maxlength="20">
                            <p class="text-danger text-small" id="name_arError">
                        </div> 
                        <div class="form-group col-12 uploadimg_box"> <span>Media :</span>
                          <input type="file" id="uploadimg5" class="dropify" name="images_ar" data-default-file="" accept="image/*">
                            <p class="text-danger text-small" id="imagesError"></p>
                         </div>
                      </div>  
                        <div class="form-group mb-0 col-12 text-center">
                           <button type="button" onclick="updateFitnessGoal(this)" class="comman_btn">Save</button>
                        </div>
                   </div>
               </div>   
            </form>
        </div> 
      </div>
    </div>
</div>
    <!------------------------------------ End Fitness Goal modal ------------------------------------------->

      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.dropify').dropify();
    </script>
   <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()
   </script>
      <script>
   function getFitnessData(obj,id) {
    
      $.ajax({
        type : 'get',
        url  : "<?= url('admin/get_fitnessGoal/data/') ?>/" + id,
        data : {'id':id},
        success:function(data){
            console.log(data);
          $('#id').val(data.id);
          $('#title_name').val(data.name);
          $('#title_name_ar').val(data.name_ar);
         //  $('#uploadimg4').attr("data-default-file", "imagePath");
          $('#staticBackdrop09').modal('show');
        }
      });
   }
</script>
@endsection
<script>
    
function updateFitnessGoal(obj) {
    
var flag = true;
let  formData = new FormData($("#fitnessGoalForm")[0]);
formData.append('_token', "{{ csrf_token() }}");
var id = $('#id').val();
if (flag) {
    $.ajax({
        // _token: _token,
        url: "<?= url('admin/edit_fitnessGoal/update/') ?>/" + id,
        type: 'POST',
        enctype: 'multipart/form-data',
        // data: $("#carForm_"+id).serialize() + '&_token=<?= csrf_token() ?>',
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
      function deleteFitnessData(obj, id){
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
                        url : "<?= url('admin/fitness-goal-delete') ?>",
                        type : "POST",
                        data : 'id=' + id + '&_token=<?= csrf_token() ?>',
                        success: function(data){
                            swal({
                                title: "Success!",
                                text : "Fitness goal has been deleted \n Click OK to refresh the page",
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
                                    url: "<?= url('admin/fitness_goal/change_status') ?>",
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
