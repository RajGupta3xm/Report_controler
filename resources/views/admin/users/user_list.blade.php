@extends('admin.layout.master')
@section('content')
      <div class="admin_main">
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
               <div class="row user-management justify-content-center">
                  <div class="col-12"> 
                     <div class="row mx-0">
                     @if(Session::get('admin_logged_in')['type']=='0')
                        <div class="col-12 mb-4 text-end">
                        <a href="<?= url('admin/user-management') ?>" class="comman_btn me-2">Reset</a>
                           <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="comman_btn">Export to Excel</button>
                        </div>
                        @endif
                        @if(Session::get('admin_logged_in')['type']=='1')
                        @if(Session::get('staff_logged_in')['user_mgmt']!='1')
                        <div class="col-12 mb-4 text-end">
                        <a href="<?= url('admin/user-management') ?>" class="comman_btn me-2">Reset</a>
                           <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="comman_btn">Export to Excel</button>
                        </div>
                        @endif
                        @endif
                        <div class="col-12 design_outter_comman recent_orders shadow">
                           <div class="row comman_header justify-content-between ">
                              <div class="col-auto">
                                 <h2>Users Management</h2>
                              </div>
                           
                              <div class="col-6">
                                 <form class="form-design row align-items-center justify-content-end" id="filterUserForm" method="post"  action="{{url('admin/user/filterUserData')}}">
                                    @csrf
                                    <div class="form-group mb-0 col-4 ps-0" style="margin-top: 12px;"> 
                                       <select class="form-select form-control" aria-label="Default select example"  name="status"  id="loadUserData">
                                          <option selected="" disabled="">Users Status</option>
                                          <option value="active">Active</option>
                                          <option value="inactive">Inactive</option> 
                                          <option value="paused">Paused</option> 
                                          <option value="expired">Expired</option> 
                                        </select>
                                    </div>
                                 </form>
                              </div>
                           </div>
                           <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" method="post"  action="{{route('admin.query.filter')}}">
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
                                           <th>S.No.</th>
                                           <th>User Id</th>
                                           <th>User Name</th>
                                           <th>Mobile Number</th>
                                           <th>Email</th>
                                           <th>Registration Date</th>
                                           <th>Total Orders</th> 
                                           <th>Total Spent</th> 
                                           <th>Delivery Location 1</th> 
                                           <th>Delivery Location 2</th> 
                                           <th>Status</th>
                                           <th>Action</th>
                                         </tr>
                                       </thead>
                                       <tbody>
                                       @if(count($users) > 0)
                                        @foreach($users as $key=>$user)
                                         <tr>
                                           <td>{{$key+1}}</td>
                                           <td>{{$user->id}}</td>
                                           <td>{{$user->name}}</td>
                                           <td>{{$user->country_code}}&nbsp{{$user->mobile}}</td>
                                           <td>{{$user->email}}</td>
                                           <td>{{date('d/m/Y',strtotime($user->created_at))}}</td>
                                           @php
                                                $totalOrder=\App\Models\Order::where('user_id',$user->id)->count();
                                               
                                            @endphp
                                           <td>{{$totalOrder}}</td> 
                                           <td>22</td> 
                                           @forelse ($user->TotalOrder->take(2) as $k=>$order)
                                           <td>{{$order->area}}</td>
                                           @empty
                                           <td>-</td>
                                           <td>-</td>
                                           @endforelse
                                           @if($user->delivery_status == 'terminted')
                                           <td> 
                                           Expired
                                           </td> 
                                           @else
                                           <td> 
                                           {{$user->delivery_status}}
                                           </td> 
                                           @endif
                                           <td> 
                                             <a class="comman_btn table_viewbtn" href="{{url('admin/user-details/'.base64_encode($user->id))}}">View</a>
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
               <!-- <div class="form-group row mb-4">
                  <div class="col-12 mb-3 Export_head"> <label for="">Exports :</label> </div>
                  <div class="col-12">
                     <div class="comman_radio mb-2"> <input class="d-none" type="radio" id="radio1" name="radio1"> <label for="radio1">All Items</label> </div>
                     <div class="comman_radio mb-2"> <input class="d-none" type="radio" checked id="radio2" name="radio2"> <label for="radio2">Selected 50+ Items</label> </div>
                  </div>
               </div> -->
               <div class="form-group row">
                  <div class="col-12 mb-3 Export_head"> <label for="">Exports As :</label> </div>
                  <div class="col-12">
                     <div class="comman_radio mb-2"> <input class="d-none" type="radio" checked id="radio3" name="radio3"> <label for="radio3">Excel (In Proper Format)</label> </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<script src="assets/vendor/jquery.min.js"></script>
      <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="assets/vendor/owl/owl.carousel.min.js"></script>
      <script src="assets/js/main.js"></script>
   <script>
      var select = document.getElementById('loadUserData');
      select.onchange = function(){
      this.form.submit();
      };
   </script>
@endsection
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