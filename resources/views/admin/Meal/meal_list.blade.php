
 @extends('admin.layout.master')
@section('content')
      <div class="admin_main">
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
               <div class="row meal-management justify-content-center">
                  <div class="col-12"> 
                     <div class="row mx-0">
                     @if(Session::get('admin_logged_in')['type']=='0')
                        <div class="col-12 text-end mb-4 pe-0">
                        <a href="{{url('admin/export/meal_list')}}"  class="comman_btn">Export to Excel</a>
                           <!-- <a href="javscript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop"  class="comman_btn me-2">Export Excel</a> -->
                           <!-- <a href="javscript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop1"  class="comman_btn me-2">Import Excel</a> -->
                           <a href="javscript:;" class="comman_btn me-2">Print</a>
                           <a href="{{url('admin/add-meal')}}" class="comman_btn yellow-btn me-2">Add Items</a>
                        </div>
                        @endif
                     @if(Session::get('admin_logged_in')['type']=='1')
                       @if(Session::get('staff_logged_in')['meal_mgmt']!='1')
                        <div class="col-12 text-end mb-4 pe-0">
                        <a href="{{url('admin/export/meal_list')}}"  class="comman_btn">Export to Excel</a>
                           <!-- <a href="javscript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop"  class="comman_btn me-2">Export Excel</a> -->
                           <!-- <a href="javscript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop1"  class="comman_btn me-2">Import Excel</a> -->
                           <a href="javscript:;" class="comman_btn me-2">Print</a>
                           <a href="{{url('admin/add-meal')}}" class="comman_btn yellow-btn me-2">Add Items</a>
                        </div>
                        @endif
                        @endif
                        <div class="col-12 design_outter_comman shadow mb-4">
                           <div class="row comman_header justify-content-between">
                              <div class="col">
                                 <h2>Meal Management</h2>
                              </div> 
                              <!-- <div class="col-3" style="margin-top: 11px;">
                                 <form class="form-design" action="">
                                    <div class="form-group mb-0 position-relative icons_set">
                                       <input type="text" class="form-control" placeholder="Search" name="name" id="name" >
                                       <i class="far fa-search"></i>
                                    </div>
                                 </form>
                              </div>  -->
                              <div class="col-auto">
                                 <div class="dropdown more_filters">
                                 
                                 <a href="<?= url('admin/meal-management') ?>" class="comman_btn me-2">Reset</a>
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                       More Filters 
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1"> 
                                       <form method="post" action="{{route('admin.meal.filter')}}">
                                          @csrf
                                          <div class="form-group mb-2">
                                             <label for="">Tagged With :</label>
                                             <select class="form-select form-control" aria-label="Default select example" name="meal_day" id="meal_day">
                                                <option selected disabled>Tagged With</option>
                                                @foreach($mealWeekDay as $mealWeekDays)
                                                <option value="{{$mealWeekDays->week_days_id}}">All {{ucwords($mealWeekDays->week_days_id)}}</option>
                                                @endforeach
                                              </select>
                                          </div>
                                          <div class="form-group mb-2">
                                             <label for="">Status :</label>
                                             <select class="form-select form-control" aria-label="Default select example" name="status" id="status">
                                                <option selected disabled>Status</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Draft</option> 
                                              </select>
                                          </div>
                                          <div class="form-group mb-2">
                                             <label for="">Meal Type :</label>
                                             <select class="form-select form-control" aria-label="Default select example" name="meal_type" id="meal_type">
                                                <option selected disabled>Meal Type</option>
                                                @foreach($mealSchedule as $mealSchedules)
                                                <option value="{{$mealSchedules->id}}">{{$mealSchedules->name}}</option>
                                              @endforeach
                                              </select>
                                          </div>
                                          <div class="form-group mb-2">
                                             <label for="">Plan Type :</label>
                                             <select class="form-select form-control" aria-label="Default select example" name="plan_type" id="plan_type">
                                                <option selected disabled>Plan Type</option>
                                                @foreach($dietPlanType as $dietPlanTypes)
                                                <option value="{{$dietPlanTypes->id}}">{{$dietPlanTypes->name}}</option>
                                               @endforeach
                                              </select>
                                          </div>
                                          <div class="form-group mb-0">
                                          <label for="">Select Date</label>
                                          <input type="date" onchange="$('#start_date').attr('min', $(this).val());" max="<?= date('Y-m-d') ?>"  value="{{isset($start_date)?$start_date:''}}"  name="start_date" class="form-select form-control">
                                          </div>
                                          <div class="col-md-12 col-xs-12">
                                              <p id="formError" class="text-danger"></p>
                                           </div>
                                          <div class="col-12 mb-4 pe-0">
                                          <a href="#filter" onclick="filterList(this)"; class="btn btn-primary pt-2 pb-2 w-100 mt-1">Search</a>
                                          </div>
                                       </form>
                                    </div>
                                  </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-12 comman_table_design px-0">
                                 <!-- <div class="meal_tablebtsn py-3 px-4">
                                    <a class="comman_btn me-2" href="javscript:;">00 Selected</a>
                                    <a class="comman_btn" href="javscript:;">Edit Selected</a>
                                 </div> -->
                                 <div class="table-responsive">
                                    <table class="table mb-0"  id="example1">
                                       <thead>
                                         <tr>
                                           <!-- <th>
                                             <form class="table_btns d-flex align-items-center justify-content-center"> 
                                                <div class="check_radio">
                                                   <input type="checkbox" name="table1" id="table1" class="d-none">
                                                   <label for="table1"></label>
                                                </div>
                                             </form>
                                           </th> -->
                                           <th>Media</th>
                                           <th>Items</th>
                                           <th>Meal Group</th>
                                           <th>Plan Type</th>
                                           <th>Rating</th> 
                                           @if(Session::get('admin_logged_in')['type']=='0')
                                           <th>Status</th>
                                           <th>Action</th>
                                           @endif
                                           @if(Session::get('admin_logged_in')['type']=='1')
                                            @if(Session::get('staff_logged_in')['meal_mgmt']!='1')
                                             <th>Status</th>
                                             <th>Action</th>
                                           @endif
                                           @endif
                                         </tr>
                                       </thead>
                                       <tbody>
                                         @if(count($meals) > 0)
                                          @foreach($meals as $meal)
                                         <tr>
                                           <!-- <td>
                                             <form class="table_btns d-flex align-items-center justify-content-center"> 
                                                <div class="check_radio td_check_radio">
                                                   <input type="checkbox" name="table2" id="table2" class="d-none">
                                                   <label for="table2"></label>
                                                </div>
                                             </form>
                                           </td> -->
                                           <td><img class="table_img" src="{{$meal->image}}" alt=""></td>
                                           <td>{{$meal->name}}</td> 
                                           <td>{{$meal->meal_group->pluck('name')->implode(',  ')}}</td>
                                           <td>{{$meal->diet_plan->pluck('name')->implode(', ')}}</td>
                                           <td>{{$meal->rating['rating']??'0'}}</td> 
                                           @if(Session::get('admin_logged_in')['type']=='0')
                                           <td>
                                           <div class="mytoggle">
                                             <label class="switch">
                                             <input type="checkbox" onchange="changeStatus(this, '<?= $meal->id ?>');" <?= ($meal->status == 'active' ? 'checked' : '') ?> ><span class="slider round"> </span> 
                                             </label>
                                         </div>
                                           </td>
                                           <td> 
                                             <a class="comman_btn table_viewbtn" href="<?= url('admin/edit-meal/' . base64_encode($meal->id)); ?>">Edit</a>
                                             <a class="comman_btn table_viewbtn delete_btn" onclick="deleteMeal(this,'{{$meal->id}}');" href="javscript:;">Delete</a> 
                                           </td>
                                         @endif
                                         @if(Session::get('admin_logged_in')['type']=='1')
                                            @if(Session::get('staff_logged_in')['meal_mgmt']!='1')
                                           <td>
                                           <div class="mytoggle">
                                             <label class="switch">
                                             <input type="checkbox" onchange="changeStatus(this, '<?= $meal->id ?>');" <?= ($meal->status == 'active' ? 'checked' : '') ?> ><span class="slider round"> </span> 
                                             </label>
                                         </div>
                                           </td>
                                           @endif
                                           @endif
                                         </tr> 
                                       @endforeach
                                       @else
                                       <tr>
                                          <td>
                                            <p>  No Plan Found...</p>
                                          </td> 
                                        </tr>
                                        @endif
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
      function deleteMeal(obj, id){
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
                        url : "<?= url('admin/meal-delete') ?>",
                        type : "POST",
                        data : 'id=' + id + '&_token=<?= csrf_token() ?>',
                        success: function(data){
                            swal({
                                title: "Success!",
                                text : "Meal has been deleted \n Click OK to refresh the page",
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
       function filterList(obj){
        if ($('#meal_day').find('option:selected').val() == '' && $('#status').find('option:selected').val()  == ''  && $('#meal_type').find('option:selected').val() == '' && $('#plan_type').find('option:selected').val() == ''){
        $("#formError").html('Select filter attribute');
        } else{

        if ($('#meal_day').find('option:selected').val() != '' && $('#status').find('option:selected').val() != '' &&  $('#meal_type').find('option:selected').val() != '' && $('#plan_type').find('option:selected').val() != ''){
        $('form').submit();
        } else{
        if ($('#meal_day').find('option:selected').val() != ''){
        $("#formError").html('meal day is required');
        } else if ($('#status').find('option:selected').val() != ''){
        $("#formError").html('status is required');
        } else if ($('#meal_type').find('option:selected').val() != ''){
        $("#formError").html('meal type is required');
        }else if ($('#plan_type').find('option:selected').val() != ''){
        $("#formError").html('plan type is required');
        }else{
        $("#formError").html('Select filter attribute');
        }
        }
        }

        }
    
 </script>
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
       <form class="form-design py-4 px-4 row align-items-start justify-content-start" method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/meal/export')}}">
       @csrf
            <div class="form-group row mb-4">
               <div class="col-12 mb-3 Export_head">
                  <label for="">Exports :</label>
               </div>
               <div class="col-12">
                  <div class="comman_radio mb-2"> 
                     <input class="d-none" type="radio" id="radio1" value="all" name="radio1">
                     <label for="radio1">All Items</label>
                  </div>
                  <div class="comman_radio mb-2">
                     <input class="d-none" type="radio"  id="radio2" value="50" name="radio1">
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
                     <input class="d-none" type="radio"  id="radio3" value="allProperFormat" name="radio1">
                     <label for="radio3">Excel (In Proper Format)</label>
                  </div>
               </div>
            </div>
            <button type="submit" class="comman_btn me-2 export_to_excel">Export</button>
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
            <a  href="<?= url('admin/meal-management') ?>" class="comman_btn me-2" >Import</a>
         </form>
       </div> 
     </div>
   </div>
 </div>
 <script>
   $(document).on('click', '.export_to_excel', function() {
    $.ajax({
        type: 'get',
        url: '/export-to-excel',
        data: {
            'from_date': from_date,
            'to_date': to_date
        },
        success: function(data) {
            console.log(data);
            alertify.set('notifier', 'position', 'bottom-center');
            alertify.success(data.success);
        }
    });
});
 </script>
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