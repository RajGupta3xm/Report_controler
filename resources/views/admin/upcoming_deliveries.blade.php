
   @extends('admin.layout.master')
@section('content')
      <div class="admin_main">
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
               <div class="row upcoming-deliveries-part justify-content-center">
                  <div class="col-12"> 
                     <div class="row mx-0">
                        <div class="col-12 design_outter_comman shadow">
                           <div class="row comman_header justify-content-between">
                              <div class="col-auto">
                                 <h2>Upcoming Deliveries</h2>
                              </div>
                              <div class="col-3">
                                 <form class="form-design" method="POST"   enctype="multipart/form-data" action="{{url('admin/upcomingDeliveriesShow')}}">
                                 @csrf
                                    <div class="form-group mb-0 position-relative only_calender">
                                       <input type="date" name="start_date" id="form1"   class="form-control" placeholder="Search Recent Orders" > 
                                    </div>
                                 </form>
                              </div>
                           </div> 
                           <div class="row upcoming-deliveries">
                              <div class="col-12 deliveries_date py-4 text-center">
                                 <a href="javscript:;">Deliveries for {{$startDate}}</a>
                              </div>
                              <div class="col-12 upcoming-deliveries-tabs text-center">
                                 <ul class="nav nav-tabs justify-content-center border d-inline-flex overflow-hidden rounded shadow" id="myTab" role="tablist">
                                    @foreach($delivery_slots as $key=>$deliverySlot)
                                    <li class="nav-item" role="presentation">
                                    @if($key==0)
                                      <button class="nav-link vaccine_name active" id="home_tab"  onclick="activeTab(this,<?=$deliverySlot['id']?>);" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">{{$deliverySlot->name}} ({{$deliverySlot->start_time}} - {{$deliverySlot->end_time}})</button>
                                      @else
                                      <button class="nav-link vaccine_name" id="home_tab"  onclick="activeTab(this,<?=$deliverySlot['id']?>);" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">{{$deliverySlot->name}} ({{$deliverySlot->start_time}} - {{$deliverySlot->end_time}})</button>
                                    @endif
                                    </li>
                                    @endforeach
                                    <!-- <li class="nav-item" role="presentation">
                                      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Afternoon (12 Noon - 04 PM)</button>
                                    </li> -->
                                    <!-- <li class="nav-item" role="presentation">
                                      <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Evening (05 PM - 07 PM)</button>
                                    </li> -->
                                  </ul>
                                  <div class="tab-content mt-4" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    @foreach($delivery_slots as $key=>$deliverySlot)
                                       <div class="row mx-0 video_list" id='video_list_<?=$deliverySlot['id']?>' <?php if($key!=0)  { ?> style="display:none" <?php }?>>
                                          <div class="col-12 mb-4">
                                             <div class="no_delivery">Number of Delivery: <span>{{count($deliverySlot->address)}}</span></div>
                                          </div>
                                          @if($deliverySlot['address'])
                                                @foreach($deliverySlot['address'] as $v=>$name)
                                          <div class="col-12 mb-4 ">
                                             <div class="upcoming-deliveries-box">
                                                <form action="" class="deliveries-form row align-items-center">
                                                   <div class="col-3">
                                                      <div class="deliveries-form-profile">
                                                      <img src="{{$name->image?$name->image:asset('assets/img/profile.png')}}" alt="">
                                                         <span>{{$name->user_name}}</span>
                                                      </div>
                                                      @php
                                                        $planName = \App\Models\SubscriptionPlan::select('name')->where('id',$name->plan_id)->first();

                                                      @endphp
                                                      <div class="plan_name">
                                                         <a href="javscript:;">{{$planName->name}}</a>
                                                      </div>
                                                      <div class="orderdetails mt-3">
                                                         <span class="mb-1">Order: <strong>#{{$name->order_id}}</strong></span>
                                                         @php
                                                         $planName = \App\Models\SubscriptionMealPlanVariant::select('no_days')->where('meal_plan_id',$name->plan_id)->first();
                                                         if($planName){
                                                          
                                                         $puchase_on = $name->start_date;
                                                          $puchased_on = date('d M', strtotime($puchase_on));
                                                          $dates = \Carbon\Carbon::createFromFormat('Y-m-d',$name->start_date);
                                                           $expired_on = $dates->addDays($planName->no_days);
                                                            $expire_on = date('d/m/Y', strtotime($expired_on));
                                                         
                                                      }
                                                         @endphp
                                                         <span>Plan Expiry Date: <strong>{{$expire_on}}</strong></span> 
                                                      </div>
                                                   </div> 
                                                   <div class="col">
                                                      <div class="deliveries-box-comman">
                                                         <strong>Dishes :</strong>
                                                         <div class="deliveries-box-inner">
                                                         @foreach($name['meal_schedule'] as $k=>$meal_schedules)
                                                       
                                                         @php
                                                         
                                                            $foodMeal=[];
                                                         
                                                              foreach($meal_schedules['meal'] as $t=>$mealss)
                                                                    if(isset($mealss)){
                                                                    $foodMeal[]=implode(' , ' , (array)$mealss->name);
                                                                    } 
                                                        @endphp
                                                       
                                                         
                                                            <p><span>{{$meal_schedules->name}}:</span>{{count($meal_schedules->meal)}} Dishes  {{isset($foodMeal)? implode( ' , ', $foodMeal):'-'}}</p>
                                                          
                                                           @endforeach
                                                         
                                                            <!-- <p><span>Lunch:</span>2 Dishes (1 Pizza, 1 Burger)</p>
                                                            <p><span>Snacks:</span>2 Dishes (1 Pizza, 1 Burger)</p>
                                                            <p><span>Dinner:</span>2 Dishes (1 Pizza, 1 Burger)</p>  -->
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="col">
                                                      <div class="deliveries-box-comman">
                                                         <strong>Delivery Address :</strong>
                                                         <div class="deliveries-box-inner">
                                                           <textarea class="form-control" name="address" id="address" placeholder="" readOnly="true">{{$name->area}},{{$name->street}}</textarea>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   @foreach($deliverySlot['address'] as $v=>$name)
                                                   @php
                                                   $checkDeliverd =  \App\Models\Order::select('status')->where('id',$name->order_id)->first();
                                                   @endphp
                                                   @if($checkDeliverd->status == 'delivered')
                                                   <div class="col-12 text-end mt-3">
                                                      <a class="comman_btn"  href="javscript:;">delivered</a>
                                                   </div>
                                                   @else
                                                   <div class="col-12 text-end mt-3">
                                                      <a class="comman_btn" onclick="sendQuery(this,<?=$name->order_id ?>)" href="javscript:;">Mark as delivered</a>
                                                   </div>
                                                   @endif
                                                   @endforeach
                                                </form>
                                             </div> 
                                          </div> 
                                          @endforeach
                                          @endif
                                       </div>
                                       @endforeach
                                    </div>
                                    <!-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                       <div class="row mx-0">
                                          <div class="col-12 mb-4">
                                             <div class="no_delivery">Number of Delivery: <span>150</span></div>
                                          </div>
                                          <div class="col-12 mb-4">
                                             <div class="upcoming-deliveries-box">
                                                <form action="" class="deliveries-form row align-items-center">
                                                   <div class="col-3">
                                                      <div class="deliveries-form-profile">
                                                         <img src="assets/img/profile.png" alt="">
                                                         <span>John Dubey</span>
                                                      </div>
                                                      <div class="plan_name">
                                                         <a href="javscript:;">Plan Name</a>
                                                      </div>
                                                      <div class="orderdetails mt-3">
                                                         <span class="mb-1">Order: <strong>#2305</strong></span>
                                                         <span>Plan Expiry Date: <strong>23/09/2022</strong></span> 
                                                      </div>
                                                   </div> 
                                                   <div class="col">
                                                      <div class="deliveries-box-comman">
                                                         <strong>Dishes :</strong>
                                                         <div class="deliveries-box-inner">
                                                            <p><span>Breakfast:</span>2 Dishes (1 Pizza, 1 Burger)</p>
                                                            <p><span>Lunch:</span>2 Dishes (1 Pizza, 1 Burger)</p>
                                                            <p><span>Snacks:</span>2 Dishes (1 Pizza, 1 Burger)</p>
                                                            <p><span>Dinner:</span>2 Dishes (1 Pizza, 1 Burger)</p> 
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="col">
                                                      <div class="deliveries-box-comman">
                                                         <strong>Delivery Address :</strong>
                                                         <div class="deliveries-box-inner">
                                                           <textarea class="form-control" name="address" id="address" placeholder="A-301/302, Vrindavan Umedshram Rd, Sv Rd, Borivli(w)"></textarea>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="col-12 text-end mt-3">
                                                      <a class="comman_btn" href="javscript:;">Mark as delivered</a>
                                                   </div>
                                                </form>
                                             </div> 
                                          </div> 
                                       </div>
                                    </div>
                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                       <div class="row mx-0">
                                          <div class="col-12 mb-4">
                                             <div class="no_delivery">Number of Delivery: <span>150</span></div>
                                          </div>
                                          <div class="col-12 mb-4">
                                             <div class="upcoming-deliveries-box">
                                                <form action="" class="deliveries-form row align-items-center">
                                                   <div class="col-3">
                                                      <div class="deliveries-form-profile">
                                                         <img src="assets/img/profile.png" alt="">
                                                         <span>John Dubey</span>
                                                      </div>
                                                      <div class="plan_name">
                                                         <a href="javscript:;">Plan Name</a>
                                                      </div>
                                                      <div class="orderdetails mt-3">
                                                         <span class="mb-1">Order: <strong>#2305</strong></span>
                                                         <span>Plan Expiry Date: <strong>23/09/2022</strong></span> 
                                                      </div>
                                                   </div> 
                                                   <div class="col">
                                                      <div class="deliveries-box-comman">
                                                         <strong>Dishes :</strong>
                                                         <div class="deliveries-box-inner">
                                                            <p><span>Breakfast:</span>2 Dishes (1 Pizza, 1 Burger)</p>
                                                            <p><span>Lunch:</span>2 Dishes (1 Pizza, 1 Burger)</p>
                                                            <p><span>Snacks:</span>2 Dishes (1 Pizza, 1 Burger)</p>
                                                            <p><span>Dinner:</span>2 Dishes (1 Pizza, 1 Burger)</p> 
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="col">
                                                      <div class="deliveries-box-comman">
                                                         <strong>Delivery Address :</strong>
                                                         <div class="deliveries-box-inner">
                                                           <textarea class="form-control" name="address" id="address" placeholder="A-301/302, Vrindavan Umedshram Rd, Sv Rd, Borivli(w)"></textarea>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="col-12 text-end mt-3">
                                                      <a class="comman_btn" href="javscript:;">Mark as delivered</a>
                                                   </div>
                                                </form>
                                             </div> 
                                          </div> 
                                       </div>
                                    </div> -->
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
   function sendQuery(obj,id) {
var flag = true;
if (flag) {
    $.ajax({
        url: "<?= url('admin/updateDeliveryStatus/') ?>/",
        type: 'POST',
        data:   '&id=' + id + '&_token=<?= csrf_token() ?>',
        success: function(data) {
            swal({
                title: "Status Updated!",
                text: data.message,
                icon: "success",
                buttons: false,
            });
            setTimeout(function() {
                location.reload();
            }, 2000);
        }
    });
}
}               
</script>
      <script>
    
         var select = document.getElementById('form1');
      select.onchange = function(){
      this.form.submit();
     };

   
</script>
      <script>
 function activeTab(obj,id) {

   $('.video_list').css('display','none');
   $('#video_list_'+ id ).css('display','block');
   $('.vaccine_name').removeClass('active');
   $(obj ).addClass('active');

    }
    </script>
    </script>
      <script src="assets/vendor/jquery.min.js"></script>
      <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="assets/vendor/owl/owl.carousel.min.js"></script>
      <script src="assets/js/main.js"></script>
      @endsection