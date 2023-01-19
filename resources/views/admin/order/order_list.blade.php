@extends('admin.layout.master')
@section('content')
      <div class="admin_main">  
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
               <div class="row report-management justify-content-center">
                  <div class="col-12"> 
                     <div class="row mx-0">  
                        <div class="col-12 text-end mb-4 pe-0"> 
                           <a href="javscript:;" class="comman_btn yellow-btn me-2">Draft Order</a> 
                           <a href="javscript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="comman_btn me-2">Export Excel</a> 
                            <!-- <a href="javscript:;" id="print" class="comman_btn yellow-btn me-0">Print</a>  -->
                            <input type="button" class="comman_btn yellow-btn me-0" onclick="printableDiv('printableArea')" value="print" />
                        </div>
                        <div class="col-12 design_outter_comman shadow">
                           <div class="row comman_header justify-content-between">
                              <div class="col-auto">
                                 <h2>Order Management</h2>
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
                           <form class="form-design py-4 px-3 row align-items-end justify-content-between" action="">
                              <div class="form-group mb-0 col-5">
                                 <label for="">From</label>
                                 <input type="datetime-local" class="form-control">
                              </div>
                              <div class="form-group mb-0 col-5">
                                 <label for="">To</label>
                                 <input type="datetime-local" class="form-control">
                              </div>
                              <div class="form-group mb-0 col-auto">
                                 <button class="comman_btn">Search</button>
                              </div> 
                           </form>
                           <div class="row">
                              <div class="col-12 comman_table_design px-0"  >
                                 <div class="table-responsive" id="printableArea">
                                    <table class="table mb-0" >
                                       <thead>
                                         <tr>
                                          <th>
                                             <form class="table_btns d-flex align-items-center justify-content-center">
                                                <div class="check_radio">
                                                   <input type="checkbox" name="table5" id="table5" class="d-none">
                                                   <label for="table5"></label>
                                                </div>
                                             </form>
                                          </th>
                                           <th>S.No.</th>
                                           <th>Date/Time</th>
                                           <th>User Name</th>  
                                           <th>Order ID</th>
                                           <th>Diet Plan Type</th>
                                           <th>Plan Name</th>
                                           <th>Variant Name</th>
                                           <th>Total</th>
                                           <th>Action</th>
                                         </tr>
                                       </thead>
                                       <tbody>
                                          @if(count($orders) > 0)
                                          @foreach($orders as $key1=>$order)
                                    
                                          @foreach($order->plans as $key3=>$variant)
                                          <tr>
                                             <td >
                                                <form class="table_btns d-flex align-items-center justify-content-center">
                                                   <div class="check_radio td_check_radio">
                                                      <input type="checkbox" name="v1" id="v1" class="d-none">
                                                      <label for="v1"></label>
                                                   </div>
                                                </form>
                                             </td>
                                             <td>{{$key1+1}}</td>
                                             <td>{{date('d/m/Y',strtotime($order->created_at))}}<br>{{date('h:i A',strtotime($order->created_at))}}</td>
                                             <td>{{$order->name}}</td>
                                             <td>#{{$order->order_id}}</td>
                                             <td>{{$variant->dietPlans['name']}}</td>
                                             <td>{{$variant->plan['name']}}</td>
                                             <td>{{$variant->variant_name}}</td>
                                             <td>{{$variant->plan_price}} SR</td>     
                                             <td> <a class="comman_btn table_viewbtn" href="{{url('admin/order-details/'.base64_encode($order['id']))}}">View</a></td>
                                          </tr>
                                          @endforeach
                                        
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
      
      <!-- <script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="js/jquery.printPage.js"></script>
      <link href="/css/print.css" rel="stylesheet" media="print" type="text/css"> -->

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
<script>
   
</script>
<script>
function printableDiv(printableAreaDivId) {
     var printContents = document.getElementById(printableAreaDivId).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;
     window.print();

     document.body.innerHTML = originalContents;
}

</script>
 <!-- Modal -->
<div class="modal fade reply_modal Import_export" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content border-0">
           <div class="modal-header">
               <h5 class="modal-title" id="staticBackdropLabel">Export Excel</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body py-4">
               <form class="Import_export_form px-4" action="">
                   <div class="form-group row mb-4">
                       <div class="col-12 mb-3 Export_head"> <label for="">Exports :</label> </div>
                       <div class="col-12">
                           <div class="comman_radio mb-2"> <input class="d-none" type="radio" id="radio1" name="radio1"> <label for="radio1">All Items</label> </div>
                           <div class="comman_radio mb-2"> <input class="d-none" type="radio" checked id="radio2" name="radio2"> <label for="radio2">Selected 50+ Items</label> </div>
                       </div>
                   </div>
                   <div class="form-group row">
                       <div class="col-12 mb-3 Export_head"> <label for="">Exports As :</label> </div>
                       <div class="col-12">
                           <div class="comman_radio mb-2"> <input class="d-none" type="radio" checked id="radio2" name="radio2"> <label for="radio2">Excel (In Proper Format)</label> </div>
                       </div>
                   </div>
               </form>
           </div>
       </div>
   </div>
</div> 

@endsection