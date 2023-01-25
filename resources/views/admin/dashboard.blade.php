@extends('admin.layout.master')
@section('content')

      <div class="admin_main">
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
               <div class="row dashboard_part justify-content-center">
                  <div class="col-12">
                     <div class="row ms-3 mb-5 justify-content-center">
                        <div class="col d-flex align-items-stretch">
                           <a href="{{url('admin/user-management')}}" class="row dashboard_box box_design me-3 w-100">
                              <div class="col-auto px-0">
                                 <span class="dashboard_icon"><i class="fas fa-user"></i></span>
                              </div>
                              <div class="col pe-0">
                                 <div class="dashboard_boxcontent">
                                    <h2>Total Users</h2> 
                                 </div>
                                 <div class="row total_user_main">
                                    <div class="col-6 mb-1">
                                       <h3>Active : <span>{{$activeUser}}</span></h3>
                                    </div>
                                    <div class="col-6 mb-1">
                                       <h3>Inactive : <span>{{$pausedUser}}</span></h3>
                                    </div>
                                    <div class="col-6">
                                       <h3>Paused : <span>{{$expiredUser}}</span></h3>
                                    </div>
                                    <div class="col-6">
                                       <h3>Expired : <span>{{$inactiveUser}}</span></h3>
                                    </div>
                                 </div>
                              </div>
                           </a>
                        </div>
                        <div class="col d-flex align-items-stretch">
                           <a href="{{url('admin/order-management')}}" class="row dashboard_box box_design me-3 w-100">
                              <div class="col-auto px-0">
                                 <span class="dashboard_icon"><i class="fal fa-box-full"></i></span>
                              </div>
                              <div class="col pe-0">
                                 <div class="dashboard_boxcontent">
                                    <h2>Total Orders</h2>
                                    <span>{{$totalOrder}}</span>
                                 </div>
                              </div>
                           </a>
                        </div>
                        <div class="col d-flex align-items-stretch pe-0">
                           <a href="{{url('admin/upcoming-deliveries')}}" class="row dashboard_box box_design me-0 w-100">
                              <div class="col-auto px-0">
                                 <span class="dashboard_icon"><i class="fas fa-biking-mountain"></i></span>
                              </div>
                              <div class="col pe-0">
                                 <div class="dashboard_boxcontent">
                                    <h2>Upcoming Deliveries</h2>
                                    <span>{{date('d-m-Y', strtotime(' +1 day'))}}</span>
                                 </div>
                              </div>
                           </a>
                        </div> 
                     </div>
                     <div class="row mx-0">
                        <div class="col-12 design_outter_comman recent_orders shadow">
                           <div class="row comman_header justify-content-between">
                              <div class="col-auto">
                                 <h2>Recent Orders</h2>
                              </div>
                              <div class="col-3">
                                 <form class="form-design" action="">
                                    <div class="form-group mb-0 position-relative icons_set">
                                       <input type="text" class="form-control" placeholder="Search Recent Orders" name="name" >
                                       <i class="far fa-search"></i>
                                    </div>
                                 </form>
                              </div>
                           </div>
                           <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" action="">
                              <div class="form-group mb-0 col-5">
                                 <label for="">From</label>
                                 <input type="date" class="form-control">
                              </div>
                              <div class="form-group mb-0 col-5">
                                 <label for="">To</label>
                                 <input type="date" class="form-control">
                              </div>
                              <div class="form-group mb-0 col-auto">
                                 <button class="comman_btn">Search</button>
                              </div> 
                           </form>
                           <div class="row">
                              <div class="col-12 comman_table_design px-0">
                                 <div class="table-responsive">
                                    <table class="table mb-0" >
                                       <thead>
                                         <tr>
                                           <th>S.No.</th>
                                           <th>User Name</th>
                                           <th>Mobile Number</th>
                                           <th>Order Date</th>
                                           <th>Order ID</th>
                                           <th>Plan Name</th>
                                           <th>Duration</th>
                                           <th>Action</th>
                                         </tr>
                                       </thead>
                                       <tbody>
                                          @foreach($recent_order as $key=>$users_order)
                                         <tr>
                                           <td>{{$key+1}}</td>
                                           <td>{{$users_order->user_name}}</td>
                                           <td>{{$users_order->mobile}}</td>
                                           <td>{{date('d-m-Y',strtotime($users_order->start_date))}}</td>
                                           <td>{{$users_order->order_id}}</td>
                                           @foreach($users_order->get_plan as $plan)
                                           <td>{{$plan->name}}</td>
                                           <td>{{$plan->option1}}</td>
                                           @endforeach
                                           <td>
                                           <a class="comman_btn table_viewbtn" href="{{url('admin/user-details/'.base64_encode($users_order->id))}}">View</a>
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