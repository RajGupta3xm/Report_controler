
 @extends('admin.layout.master')
@section('content')
      <div class="admin_main">
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
               <div class="row meal-management justify-content-center">
                  <div class="col-12"> 
                     <div class="row mx-0">
                        <div class="col-12 text-end mb-4 pe-0">
                           <a href="javscript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop"  class="comman_btn me-2">Export Excel</a>
                           <a href="javscript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop1"  class="comman_btn me-2">Import Excel</a>
                           <a href="javscript:;" class="comman_btn me-2">Print</a>
                           <a href="{{url('admin/add-meal')}}" class="comman_btn yellow-btn me-2">Add Items</a>
                        </div>
                        <div class="col-12 design_outter_comman shadow mb-4">
                           <div class="row comman_header justify-content-between">
                              <div class="col">
                                 <h2>Meal Management</h2>
                              </div> 
                              <div class="col-3">
                                 <form class="form-design" action="">
                                    <div class="form-group mb-0 position-relative icons_set">
                                       <input type="text" class="form-control" placeholder="Search" name="name" id="name">
                                       <i class="far fa-search"></i>
                                    </div>
                                 </form>
                              </div> 
                              <div class="col-auto">
                                 <div class="dropdown more_filters">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                       More Filters 
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1"> 
                                       <form action="">
                                          <div class="form-group mb-2">
                                             <label for="">Tagged With :</label>
                                             <select class="form-select form-control" aria-label="Default select example">
                                                <option selected disabled>Tagged With</option>
                                                <option value="1">All Sunday</option>
                                                <option value="2">All Monday</option>
                                                <option value="3">All Wednesday</option>
                                              </select>
                                          </div>
                                          <div class="form-group mb-2">
                                             <label for="">Status :</label>
                                             <select class="form-select form-control" aria-label="Default select example">
                                                <option selected disabled>Status</option>
                                                <option value="1">Active</option>
                                                <option value="2">Draft</option> 
                                              </select>
                                          </div>
                                          <div class="form-group mb-2">
                                             <label for="">Meal Type :</label>
                                             <select class="form-select form-control" aria-label="Default select example">
                                                <option selected disabled>Meal Type</option>
                                                <option value="1">Breakfast</option>
                                                <option value="2">Snack</option> 
                                              </select>
                                          </div>
                                          <div class="form-group mb-0">
                                             <label for="">Plan Type :</label>
                                             <select class="form-select form-control" aria-label="Default select example">
                                                <option selected disabled>Plan Type</option>
                                                <option value="1">Low Carb</option>
                                                <option value="2">Balanced Diet</option> 
                                              </select>
                                          </div>
                                       </form>
                                    </div>
                                  </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-12 comman_table_design px-0">
                                 <div class="meal_tablebtsn py-3 px-4">
                                    <a class="comman_btn me-2" href="javscript:;">02 Selected</a>
                                    <a class="comman_btn" href="javscript:;">Edit Selected</a>
                                 </div>
                                 <div class="table-responsive">
                                    <table class="table mb-0">
                                       <thead>
                                         <tr>
                                           <th>
                                             <form class="table_btns d-flex align-items-center justify-content-center"> 
                                                <div class="check_radio">
                                                   <input type="checkbox" name="table1" id="table1" class="d-none">
                                                   <label for="table1"></label>
                                                </div>
                                             </form>
                                           </th>
                                           <th>Media</th>
                                           <th>Items</th>
                                           <th>Meal Group</th>
                                           <th>Plan Type</th>
                                           <th>Rating</th> 
                                           <th>Status</th>
                                         </tr>
                                       </thead>
                                       <tbody>
                                          @foreach($meals as $meal)
                                         <tr>
                                           <td>
                                             <form class="table_btns d-flex align-items-center justify-content-center"> 
                                                <div class="check_radio td_check_radio">
                                                   <input type="checkbox" name="table2" id="table2" class="d-none">
                                                   <label for="table2"></label>
                                                </div>
                                             </form>
                                           </td>
                                           <td><img class="table_img" src="{{$meal->image}}" alt=""></td>
                                           <td>{{$meal->name}}</td> 
                                           <td>{{$meal->meal_group->pluck('name')->implode(',  ')}}</td>
                                           <td>{{$meal->diet_plan->pluck('name')->implode(', ')}}</td>
                                           <td>{{$meal->rating['rating']??'0'}}</td> 
                                           <td>
                                           <div class="mytoggle">
                                             <label class="switch">
                                             <input type="checkbox" onchange="changeStatus(this, '<?= $meal->id ?>');" <?= ($meal->status == 'active' ? 'checked' : '') ?> ><span class="slider round"> </span> 
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
      @endsection
      <script src="assets/vendor/jquery.min.js"></script>
      <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="assets/vendor/owl/owl.carousel.min.js"></script>
      <script src="assets/js/main.js"></script> 
  
 
 <!-- Modal -->
 <div class="modal fade reply_modal Import_export" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content border-0">
       <div class="modal-header">
         <h5 class="modal-title" id="staticBackdropLabel">Export Excel</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body py-4">
         <form class="Import_export_form px-4" action="">
            <div class="form-group row mb-4">
               <div class="col-12 mb-3 Export_head">
                  <label for="">Exports :</label>
               </div>
               <div class="col-12">
                  <div class="comman_radio mb-2">
                     <input class="d-none" type="radio" id="radio1" name="radio1">
                     <label for="radio1">All Items</label>
                  </div>
                  <div class="comman_radio mb-2">
                     <input class="d-none" type="radio" checked id="radio2" name="radio2">
                     <label for="radio2">Selected 50+ Items</label>
                  </div>
               </div>
            </div>
            <div class="form-group row">
               <div class="col-12 mb-3 Export_head">
                  <label for="">Exports As :</label>
               </div>
               <div class="col-12"> 
                  <div class="comman_radio mb-2">
                     <input class="d-none" type="radio" checked id="radio2" name="radio2">
                     <label for="radio2">Excel (In Proper Format)</label>
                  </div>
               </div>
            </div>
         </form>
       </div> 
     </div>
   </div>
 </div>

 <!-- Modal -->
 <div class="modal fade reply_modal Import_export" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content border-0">
       <div class="modal-header">
         <h5 class="modal-title" id="staticBackdropLabel">Import Excel</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body py-4">
         <form class="Import_export_form px-4" action="">
            <div class="form-group row mb-4">
               <div class="col-12 mb-3 Export_head">
                  <label for="">Import :</label>
               </div>
               <div class="col-12">
                  <div class="comman_radio mb-2">
                     <input class="d-none" type="radio" id="radio1" name="radio1">
                     <label for="radio1">All Items</label>
                  </div>
                  <div class="comman_radio mb-2">
                     <input class="d-none" type="radio" checked id="radio2" name="radio2">
                     <label for="radio2">Selected 50+ Items</label>
                  </div>
               </div>
            </div>
            <div class="form-group row">
               <div class="col-12 mb-3 Export_head">
                  <label for="">Import As :</label>
               </div>
               <div class="col-12"> 
                  <div class="comman_radio mb-2">
                     <input class="d-none" type="radio" checked id="radio2" name="radio2">
                     <label for="radio2">Excel (In Proper Format)</label>
                  </div>
               </div>
            </div>
         </form>
       </div> 
     </div>
   </div>
 </div>
 <script>
       function changeStatus(obj, id) {
            swal({
                title: "Are you sure?",
                text: " status will be updated",
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
                                    url: "<?= url('admin/meal/change_status') ?>",
                                    type: 'post',
                                    data: 'id=' + id + '&action=' + status + '&_token=<?= csrf_token() ?>',
                                    success: function (data) {
                                    
                                        swal({
                                           title: "Success!",
                                            text : " Status has been Updated ",
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