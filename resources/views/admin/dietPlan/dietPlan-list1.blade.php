@extends('admin.layout.master')
@section('content')
      <div class="admin_main">
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
               <div class="row diet-plan-management justify-content-center">
                  <div class="col-12"> 
                     <div class="row mx-0">
                        <div class="col-12 text-end mb-4 pe-0"> 
                           <a href="<?= url('admin/add-diet-plan')?>" class="comman_btn me-2">Add Plan</a>
                           <a href="edit-diet-plan.html" class="comman_btn">Edit Plan</a>
                        </div>
                        <div class="col-12 design_outter_comman shadow mb-4">
                           <div class="row comman_header justify-content-between">
                              <div class="col">
                                 <h2>Diet Plan Management</h2>
                              </div> 
                              <div class="col-3">
                                 <form class="form-design" action="">
                                    <div class="form-group mb-0 position-relative icons_set">
                                       <input type="text" class="form-control" placeholder="Search" name="name" id="name" style="margin-top: 12px;">
                                       <i class="far fa-search"></i>
                                    </div>
                                 </form>
                              </div> 
                           </div>
                           <div class="row">
                              <div class="col-12 comman_table_design px-0"> 
                                 <div class="table-responsive">
                                    <table class="table mb-0">
                                       <thead>
                                         <tr>
                                           <th>
                                             <form class="table_btns d-flex align-items-center justify-content-center"> 
                                                <div class="check_radio">
                                                   <input type="checkbox" name="table1"  id="table" onclick="checkAll('table');" class="d-none">
                                                   <label for="table"></label>
                                                </div>
                                             </form>
                                           </th>
                                           <th>Media(En)</th>
                                           <th>Media(Ar)</th> 
                                           <th>Items</th> 
                                           <th>Status</th>
                                         </tr>
                                       </thead>
                                       <tbody>
                                        @foreach($diet_plan as $key=>$diet_plans)
                                         <tr>
                                           <td>
                                             <form class="table_btns d-flex align-items-center justify-content-center"> 
                                                <div class="check_radio td_check_radio">
                                                   <input type="checkbox" name="table1" id="table<?= $key+1 ?>" class="d-none">
                                                   <label for="table<?= $key+1 ?>"></label>
                                                </div>
                                             </form>
                                           </td>
                                           <td><img class="table_img" src="{{$diet_plans->image?$diet_plans->image:assets/img/bg-img.jpg}}" alt=""></td>
                                           <td><img class="table_img" src="{{$diet_plans->image_ar?$diet_plans->image_ar:assets/img/bg-img.jpg}}" alt=""></td>
                                           <td>{{$diet_plans->name}}</td>  
                                           <td>
                                               <div class="mytoggle">
                                                    <label class="switch">
                                                       <input type="checkbox" onchange="changeStatus(this, '<?= $diet_plans->id ?>');" <?= ( $diet_plans->status == 'active' ? 'checked' : '') ?>><span class="slider"></span><span class="labels"> </span> 
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
      <script>
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

      </script>
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
 