
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
                           <div class="row comman_header justify-content-between">
                              <div class="col">
                                 <h2>Fitness Goal Management</h2>
                              </div>
                           </div>
                           <form class="form-design py-4 px-4 row align-items-start justify-content-start mb-4"  method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/fitness-goal/submit')}}">
                            @csrf
                              <div class="col-md-12">
                                 <div class="row">
                                    <div class="col-6 pe-5 border-end mb-4">
                                       <div class="form-group">
                                          <label for=""> Title (English):</label>
                                          <input type="text" class="form-control validate" value="" name="name" id="name"> 
                                          <p class="text-danger text-small" id="nameError">
                                       </div> 
                                       <div class="form-group uploadimg_box">
                                          <span>Media (English):</span>
                                          <input type="file" id="uploadimg" name="image" class="d-none ">
                                          <label for="uploadimg">
                                             <div class="uploadimg_inner">
                                                <i class="fas fa-upload me-2"></i>
                                                <span>Upload File</span>
                                             </div>
                                          </label>
                                        
                                       </div>  
                                    </div> 
                                    <div class="col-6 ps-5 mb-4">
                                       <div class="form-group">
                                          <label for=""> Title (Arabic):</label>
                                          <input type="text" class="form-control validate" value="" name="name_ar" id="name">
                                          <p class="text-danger text-small" id="name_arError">
                                       </div> 
                                       <div class="form-group uploadimg_box">
                                          <span>Media (Arabic):</span>
                                          <input type="file" id="uploadimg1" name="image_ar" class="d-none ">
                                          <label for="uploadimg1">
                                             <div class="uploadimg_inner">
                                                <i class="fas fa-upload me-2"></i>
                                                <span>Upload File</span>
                                             </div>
                                          </label>
                                        
                                       </div>  
                                    </div>  
                                    <div class="form-group mb-0 col-12 text-center">
                                       <button type="button" onclick="validate(this)" class="comman_btn">Save</button>
                                    </div>
                                 </div>
                              </div>   
                           </form>
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
                                                 <th>Status</th> 
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
                                                 <td>
                                                   <div class="mytoggle">
                                                      <label class="switch">
                                                            <input type="checkbox" onchange="changeStatus(this, '<?= $fitness_goals->id ?>');" <?= ( $fitness_goals->status == 'active' ? 'checked' : '') ?>><span class="slider"></span><span class="labels"> </span> 
                                                        </label>
                                                   </div>
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
               </div>
            </div>
         </div>
      </div> 
      @endsection
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
