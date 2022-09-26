@extends('admin.layout.master')
@section('content')

      <div class="admin_main">
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
               <div class="row dashboard_part justify-content-center">
                  <div class="col-12">
                     <div class="row ms-3 mb-5 justify-content-center">
                        <div class="col d-flex align-items-stretch">
                           <a href="user-management.html" class="row dashboard_box box_design me-3 w-100">
                              <div class="col-auto px-0">
                                 <span class="dashboard_icon"><i class="fas fa-user"></i></span>
                              </div>
                              <div class="col pe-0">
                                 <div class="dashboard_boxcontent">
                                    <h2>Total Users</h2> 
                                 </div>
                                 <div class="row total_user_main">
                                    <div class="col-6 mb-1">
                                       <h3>Active : <span> 123</span></h3>
                                    </div>
                                    <div class="col-6 mb-1">
                                       <h3>Inactive : <span> 435</span></h3>
                                    </div>
                                    <div class="col-6">
                                       <h3>Paused : <span> 1234</span></h3>
                                    </div>
                                    <div class="col-6">
                                       <h3>Expired : <span> 234</span></h3>
                                    </div>
                                 </div>
                              </div>
                           </a>
                        </div>
                        <div class="col d-flex align-items-stretch">
                           <a href="order-details.html" class="row dashboard_box box_design me-3 w-100">
                              <div class="col-auto px-0">
                                 <span class="dashboard_icon"><i class="fal fa-box-full"></i></span>
                              </div>
                              <div class="col pe-0">
                                 <div class="dashboard_boxcontent">
                                    <h2>Total Orders</h2>
                                    <span>20000</span>
                                 </div>
                              </div>
                           </a>
                        </div>
                        <div class="col d-flex align-items-stretch pe-0">
                           <a href="upcoming-deliveries.html" class="row dashboard_box box_design me-0 w-100">
                              <div class="col-auto px-0">
                                 <span class="dashboard_icon"><i class="fas fa-biking-mountain"></i></span>
                              </div>
                              <div class="col pe-0">
                                 <div class="dashboard_boxcontent">
                                    <h2>Upcoming Deliveries</h2>
                                    <span>23/08/2022</span>
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
                                       <input type="text" class="form-control" placeholder="Search Recent Orders" name="name" id="name">
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
                                    <table class="table mb-0">
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
                                         <tr>
                                           <td>1</td>
                                           <td>John Debey</td>
                                           <td>9899012312</td>
                                           <td>01/07/2022</td>
                                           <td>1001</td>
                                           <td>Name</td>
                                           <td>Weekly</td>
                                           <td>
                                             <a class="comman_btn table_viewbtn" href="user-details.html">View</a>
                                          </td>
                                         </tr>
                                         <tr>
                                          <td>2</td>
                                          <td>John Debey</td>
                                          <td>9899012312</td>
                                          <td>01/07/2022</td>
                                          <td>1002</td>
                                          <td>Name</td>
                                          <td>Weekly</td>
                                          <td>
                                            <a class="comman_btn table_viewbtn" href="user-details.html">View</a>
                                         </td>
                                        </tr>
                                        <tr>
                                          <td>3</td>
                                          <td>John Debey</td>
                                          <td>9899012312</td>
                                          <td>01/07/2022</td>
                                          <td>1003</td>
                                          <td>Name</td>
                                          <td>Weekly</td>
                                          <td>
                                            <a class="comman_btn table_viewbtn" href="user-details.html">View</a>
                                         </td>
                                        </tr>
                                        <tr>
                                          <td>4</td>
                                          <td>John Debey</td>
                                          <td>9899012312</td>
                                          <td>01/07/2022</td>
                                          <td>1004</td>
                                          <td>Name</td>
                                          <td>Weekly</td>
                                          <td>
                                            <a class="comman_btn table_viewbtn" href="user-details.html">View</a>
                                         </td>
                                        </tr>
                                        <tr>
                                          <td>5</td>
                                          <td>John Debey</td>
                                          <td>9899012312</td>
                                          <td>01/07/2022</td>
                                          <td>1005</td>
                                          <td>Name</td>
                                          <td>Weekly</td>
                                          <td>
                                            <a class="comman_btn table_viewbtn" href="user-details.html">View</a> </td>
                                        </tr> 
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