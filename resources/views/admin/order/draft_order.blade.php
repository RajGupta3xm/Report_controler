@extends('admin.layout.master')
@section('content')
      <div class="admin_main">
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
               <div class="row report-management justify-content-center">
                  <div class="col-12">
                     <div class="row mx-0">
                        <div class="col-12 design_outter_comman shadow">
                           <div class="row comman_header freez_header justify-content-between">
                              <div class="col-auto">
                                 <h2>Draft Order</h2>
                              </div>
                              <!-- <div class="col-3">
                                 <form class="form-design row" action="">
                                    <div class="form-group col-12 mb-0 position-relative icons_set">
                                       <input type="text" class="form-control" placeholder="Search" name="name" id="name">
                                       <i class="far fa-search"></i>
                                    </div>
                                 </form>
                              </div> -->
                              <div class="col-auto">
                             
                                 <div class="custom_pagination ms-4 d-flex align-items-center">
                                    <div class="pagination_left d-flex align-items-center">
                                       <div class="pagination_count">
                                       <a href="<?= url('admin/draft-orders') ?>" class="comman_btn me-2">Reset</a>
                                       </div>
                                    </div>
                                    <div class="pagination_btns ms-3">
                                       <a href="javscript:;"><i class="far fa-angle-left"></i></a>
                                       <a class="ms-1" href="javscript:;"><i class="far fa-angle-right"></i></a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                       
                           <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" method="post"  action="{{route('admin.draft.filter')}}">
                              @csrf
                              <div class="form-group mb-0 col-5">
                                 <label for="">From</label>
                                 <input type="date" onchange="$('#start_date').attr('min', $(this).val());" max="<?= date('Y-m-d') ?>"  value="{{isset($start_date)?$start_date:''}}"  name="start_date" class="form-control">
                              </div>
                              <div class="form-group mb-0 col-5">
                                 <label for="">To</label>
                                 <input type="date" id="start_date" name="end_date" max="<?= date('Y-m-d') ?>" value="{{isset($end_date)?$end_date:''}}" class="form-control">
                              </div>
                              <div class="form-group mb-0 col-auto">
                                 <button class="comman_btn" onclick="filterList(this)";>Search</button>
                              </div> 
                              <div class="col-md-12 col-xs-12">
                                   <p id="formError" class="text-danger"></p>
                              </div>
                           </form>
                           <div class="row">
                              <div class="col-12 comman_table_design px-0">
                                 <div class="table-responsive">
                                    <table class="table mb-0" id="example1">
                                       <thead>
                                          <tr>
                                             <th>S.NO.</th>
                                             <th>Client Name</th>
                                             <th>User ID</th>
                                             <th>Meal Plan Name</th>
                                             <th>Diet Plan Type</th>
                                             <th>Status</th>
                                             <th>Remark</th>
                                             <th>Date</th>
                                             <th>Time Slot</th>
                                             <th></th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                        @if(count($cancel_orders)>0)
                                       @foreach($cancel_orders as $key=>$cancel_order)
                                          <tr>
                                             <td>{{$key+1}}</td>
                                             <td>{{$cancel_order->name}}</td>
                                             <td>{{$cancel_order->user_id}}</td>
                                             <td>{{$cancel_order->plan_name}}</td>
                                             @foreach($cancel_order->dietPlans as $diet_plan)
                                             <td>{{$diet_plan->name}}</td>
                                             @endforeach
                                             @if($cancel_order->is_deliver == 'no')
                                             <td>Cancelled</td>
                                             @endif
                                             <td>{{$diet_plan->cancel_reason}}</td>
                                             <td>{{\Carbon\Carbon::parse($cancel_order->cancel_or_delivery_date)->format('d/m/Y')}}</td>
                                             <td>{{$cancel_order->delivery_slot->name}} &nbsp; ({{$cancel_order->delivery_slot->start_time}} - {{$cancel_order->delivery_slot->end_time}})</td>
                                             <td>
                                                <!-- <a data-bs-toggle="modal" data-bs-target="#draftorder" class="comman_btn table_viewbtn showEdit" href="javascript:;" data-id="{{$cancel_order->id}}">Draft Order</a> -->
                                                <a class="comman_btn table_viewbtn " onclick="getDraftData(this,'{{$cancel_order->id}}');"  href="javscript:;"  data-toggle="modal" data-bs-target="#draftorder" >Draft Order</a> 
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
               </div>
            </div>
         </div>
      </div>
      <script src="assets/vendor/jquery.min.js"></script>
      <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="assets/vendor/owl/owl.carousel.min.js"></script>  
      <script src="assets/js/main.js"></script>

<!-------------------- modal ------------>
<div class="modal fade comman_modal" id="draftorder" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0">
         <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Draft Order</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body px-4 py-4" id="smallBody">

        
         </div>
      </div>
   </div>
</div>
<!-------------------- End modal ------------>
@endsection
<script>
   function getDraftData(obj,id) {
    alert(id);
      $.ajax({
        type : 'get',
        url  : "<?= url('admin/get_draftData/data/') ?>/" + id,
        data : {'id':id},
        success:function(data){
            console.log(data);
        $('#draftorder').modal("show");
        $('#smallBody').html(data.html).show();
        }
      });
   }
</script>
<script>
       function filterList(obj){
        if ($(':input[name=start_date]').val() == '' && $(':input[name=end_date]').val() == ''){
        $("#formError").html('Select filter attribute');
        } else{

        if ($(':input[name=start_date]').val() != '' && $(':input[name=end_date]').val() != ''){
        $('form').submit();
        } else{
        if ($(':input[name=start_date]').val() != ''){
        $("#formError").html('End date is required');
        } else if ($(':input[name=end_date]').val() != ''){
        $("#formError").html('Start date is required');
        } else{
        $("#formError").html('Select filter attribute');
        }
        }
        }

        }
    
 </script>