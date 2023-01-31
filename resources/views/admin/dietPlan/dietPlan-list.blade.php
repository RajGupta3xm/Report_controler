@extends('admin.layout.master')
@section('content')
      <div class="admin_main">
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
               <div class="row diet-plan-management justify-content-center">
                  <div class="col-12"> 
                     <div class="row mx-0">
                     @if(Session::get('admin_logged_in')['type']=='0')
                        <div class="col-12 text-end mb-4 pe-0"> 
                        <a href="<?= url('admin/add-diet-plan')?>" class="comman_btn me-2">Add Plan</a>
                        </div>
                        @endif
                     @if(Session::get('admin_logged_in')['type']=='1')
                       @if(Session::get('staff_logged_in')['diet_plan_mgmt']!='1')
                        <div class="col-12 text-end mb-4 pe-0"> 
                        <a href="<?= url('admin/add-diet-plan')?>" class="comman_btn me-2">Add Plan</a>
                        </div>
                        @endif
                        @endif
                        <div class="col-12 design_outter_comman shadow mb-4">
                           <div class="row comman_header justify-content-between">
                              <div class="col">
                                 <h2>Diet Plan Management</h2>
                              </div> 
                              <!-- <div class="col-3">
                                 <form class="form-design" action="">
                                    <div class="form-group mb-0 position-relative icons_set">
                                       <input type="text" class="form-control" placeholder="Search" name="name" id="name">
                                       <i class="far fa-search"></i>
                                    </div>
                                 </form>
                              </div>  -->
                           </div>
                           <div class="row">
                              <div class="col-12 comman_table_design px-0"> 
                                 <div class="table-responsive" >
                                    <table class="table mb-0" id="example1">
                                       <thead>
                                         <tr> 
                                           <th>Media(En)</th>
                                           <th>Media(Ar)</th> 
                                           <th>Items</th> 
                                           @if(Session::get('admin_logged_in')['type']=='0')
                                           <!-- <th>Status</th> -->
                                           <th>Action</th>
                                           @endif
                                           @if(Session::get('admin_logged_in')['type']=='1')
                                           @if(Session::get('staff_logged_in')['diet_plan_mgmt']!='1')
                                           <!-- <th>Status</th> -->
                                           <th>Action</th>
                                           @endif
                                           @endif
                                         </tr>
                                       </thead>
                                       <tbody>
                                       @foreach($diet_plan as $key=>$diet_plans)
                                         <tr> 
                                           <td><img class="table_img" src="{{$diet_plans->image?$diet_plans->image:assets/img/bg-img.jpg}}" alt=""></td>
                                           <td><img class="table_img" src="{{$diet_plans->image_ar?$diet_plans->image_ar:assets/img/bg-img.jpg}}" alt=""></td>
                                           <td>{{$diet_plans->name}}</td>  
                                           @if(Session::get('admin_logged_in')['type']=='0')
                                           <!-- <td>
                                               <div class="mytoggle">
                                                    <label class="switch">
                                                       <input type="checkbox" onchange="changeStatus(this, '<?= $diet_plans->id ?>');" <?= ( $diet_plans->status == 'active' ? 'checked' : '') ?>><span class="slider"></span><span class="labels"> </span> 
                                                    </label>
                                                </div>
                                           </td> -->
                                           <td> 
                                             <a class="comman_btn table_viewbtn" href="<?= url('admin/edit-dietPlan/' . base64_encode($diet_plans->id)); ?>">Edit</a>
                                             <a class="comman_btn table_viewbtn delete_btn" onclick="deleteDietPlanData(this,'{{$diet_plans->id}}');" href="javscript:;">Delete</a> 
                                           </td>
                                           @endif
                                           @if(Session::get('admin_logged_in')['type']=='1')
                                           @if(Session::get('staff_logged_in')['diet_plan_mgmt']!='1')
                                           <!-- <td>
                                               <div class="mytoggle">
                                                    <label class="switch">
                                                       <input type="checkbox" onchange="changeStatus(this, '<?= $diet_plans->id ?>');" <?= ( $diet_plans->status == 'active' ? 'checked' : '') ?>><span class="slider"></span><span class="labels"> </span> 
                                                    </label>
                                                </div>
                                           </td> -->
                                           <td> 
                                             <a class="comman_btn table_viewbtn" href="<?= url('admin/edit-dietPlan/' . base64_encode($diet_plans->id)); ?>">Edit</a>
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
  @endsection
  <script>
      function deleteDietPlanData(obj, id){
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
                        url : "<?= url('admin/diet-plan-delete') ?>",
                        type : "POST",
                        data : 'id=' + id + '&_token=<?= csrf_token() ?>',
                        success: function(data){
                            swal({
                                title: "Success!",
                                text : "Diet Plan has been deleted \n Click OK to refresh the page",
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
  <!-- <script>
function checkAll(checkId) {
  var inputs = document.getElementsByTagName("input");
  for (var i = 0; i < inputs.length; i++) {
    if (inputs[i].id != checkId) {
      if (inputs[i].name == "table1") {
        if (inputs[i].checked == true) {
          inputs[i].checked = false;
        } else if (inputs[i].checked == false) {
          inputs[i].checked = true;
        }
      }
    }
  }
}

      </script> -->

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
                                    url: "<?= url('admin/diet_plan/change_status') ?>",
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
 