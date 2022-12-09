@extends('admin.layout.master')
@section('content')
    <div class="admin_main">
        <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
                <div class="row plan-management justify-content-center">
                    <div class="col-12">
                        <div class="row mx-0">
                            <div class="col-12 text-end mb-4 pe-0">
                                <a href="{{url('admin/add-mealplan')}}" class="comman_btn yellow-btn me-2">Add Plan</a>
                                <a href="edit-meal-plan.html" class="comman_btn">Edit Plan</a>
                            </div>
                            <div class="col-12 design_outter_comman shadow mb-4">
                                <div class="row comman_header justify-content-between">
                                    <div class="col">
                                        <h2>Meal Plan Management</h2>
                                    </div>
                                    <div class="col-3">
                                        <form class="form-design" action="">
                                            <div class="form-group mb-0 position-relative icons_set">
                                                <input type="text" class="form-control" placeholder="Search" name="name" id="name">
                                                <i class="far fa-search"></i>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 comman_table_design px-0">
                                        <div class="table-responsive">
                                            <table class="table mb-0 sortable-table">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>S.No.</th>
                                                    <th>
                                                        <form class="table_btns d-flex align-items-center justify-content-center">
                                                            <div class="check_radio">
                                                                <input type="checkbox" name="table5" id="table5" class="d-none">
                                                                <label for="table5"></label>
                                                            </div>
                                                        </form>
                                                    </th>
                                                    <th>Media</th>
                                                    <th>Plan Name</th>
                                                    <th>Plan Type</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($fitness_goal as $key=>$fitness_goals)
                                                    <tr draggable="true" ondragstart="start()" ondragover="dragover()" class="draggable">
                                                        <td class="tb_bg"></td>
                                                        <td>1</td>
                                                        <td>
                                                            <form class="table_btns d-flex align-items-center justify-content-center">
                                                                <div class="check_radio td_check_radio">
                                                                    <input type="checkbox" name="v1" id="v1" class="d-none">
                                                                    <label for="v1"></label>
                                                                </div>
                                                            </form>
                                                        </td>
                                                        <td><img class="table_img" src="{{$fitness_goals->image}}" alt=""></td>
                                                        <td><a class="text-dark" href="add-meal-plan.html">{{$fitness_goals->name}}</a></td>
                                                        <td>{{isset($fitness_goals->mealplan_variant[0]->diet_plan->name)?$fitness_goals->mealplan_variant[0]->diet_plan->name:'-'}}</td>
                                                        <td>
                                                            <div class="mytoggle">
                                                                <label class="switch">
                                                                    <input type="checkbox" onchange="changeStatus(this, '<?= $fitness_goals->id ?>');" <?= ( $fitness_goals->status == 'active' ? 'checked' : '') ?>><span class="slider"></span><span class="labels"> </span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a class="comman_btn table_viewbtn" href="<?= url('admin/edit-mealplan/' . base64_encode($fitness_goals->id)); ?>">Edit</a>
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
                             url: "<?= url('admin/mealPlan/change_status') ?>",
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