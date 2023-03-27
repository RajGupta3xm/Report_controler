@extends('admin.layout.master')
@section('content')
      <div class="admin_main">   
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
               <div class="row report-management justify-content-center">
                  <div class="col-12">
                     <div class="row mx-0"> 
                        <div class="col-12 design_outter_comman shadow">
                           <div class="row">
                              <div class="col-12 px-0 comman_tabs">
                                 <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                       <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Active users</button>
                                       <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Meals count</button>
                                       <button class="nav-link" id="nav-profile1-tab" data-bs-toggle="tab" data-bs-target="#nav-profile1" type="button" role="tab" aria-controls="nav-profile1" aria-selected="false">Procurement</button> 
                                       <button class="nav-link" id="nav-profile2-tab" data-bs-toggle="tab" data-bs-target="#nav-profile2" type="button" role="tab" aria-controls="nav-profile2" aria-selected="false">Packing List</button>
                                    </div>
                                 </nav>
                                 <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                       <div class="row mx-0 px-4 py-4">
                                          <div class="col-12 mb-4">
                                             <form class="form-design filter_check" action=""> 
                                                <div class="check_toggle d-flex">
                                                   <span>Filter : </span>
                                                   <input type="checkbox" name="check1" id="check1" class="d-none">
                                                   <label class="onclk" for="check1"></label>
                                                </div>
                                             </form>
                                          </div>
                                          <div class="col-12 design_outter_comman">
                                             <div class="row comman_header justify-content-between">
                                                <div class="col-auto">
                                                   <h2>Active User</h2> 
                                                </div>
                                                <div class="col text-center">
                                                   <span class="selected_date">06/10/2022</span>
                                                </div>
                                             </div>
                                             <div class="row"> 
                                                <div class="col-12 comman_table_design border bg-white px-0 search_show_tables">
                                                   <div class="table-responsive">
                                                      <table class="table mb-0" id="example1">
                                                         <thead>
                                                           <tr>
                                                             <th>Customer Name & Mobile Number</th>
                                                             <th>Diet Plan Name</th>
                                                             <th>Meal Plan</th>
                                                             <th>Variant Name</th>
                                                             <th>Order Id</th>
                                                             <th>Location </th> 
                                                             <th>Time Slot </th>  
                                                             <th>Driver</th>  
                                                           </tr>
                                                         </thead>
                                                         <tbody>
                                                            <tr>
                                                               <td>Mohd. Aarif/محمد. عارف
                                                                  <br>+971 09819283109
                                                               </td>
                                                               <td>Low Crab</td>
                                                               <td>Fully Monthly</td> 
                                                               <td>Lorem</td>
                                                               <td>1001</td>
                                                               <td>Lorem ipsum dolor</td>
                                                               <td>6AM - 10AM</td>
                                                               <td>XYZ</td>
                                                            </tr> 
                                                            <tr>
                                                               <td>Mohd. Aarif/محمد. عارف
                                                                  <br>+971 09819283109
                                                               </td>
                                                               <td>Low Crab</td>
                                                               <td>Fully Monthly</td> 
                                                               <td>Lorem</td>
                                                               <td>1001</td>
                                                               <td>Lorem ipsum dolor</td>
                                                               <td>6AM - 10AM</td>
                                                               <td>XYZ</td>
                                                            </tr>
                                                            <tr>
                                                               <td>Mohd. Aarif/محمد. عارف
                                                                  <br>+971 09819283109
                                                               </td>
                                                               <td>Low Crab</td>
                                                               <td>Fully Monthly</td> 
                                                               <td>Lorem</td>
                                                               <td>1001</td>
                                                               <td>Lorem ipsum dolor</td>
                                                               <td>6AM - 10AM</td>
                                                               <td>XYZ</td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </div>
                                                </div> 
                                             </div> 
                                          </div>
                                       </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                       <div class="row mx-0 px-4 py-4">
                                          <div class="col-12 mb-4">
                                             <form class="form-design filter_check" action=""> 
                                                <div class="check_toggle d-flex">
                                                   <span>Filter : </span>
                                                   <input type="checkbox" name="checkvp" id="checkvp" class="d-none">
                                                   <label class="onclk1" for="checkvp"></label>
                                                </div>
                                             </form>
                                          </div>
                                          <div class="col-12 design_outter_comman">
                                             <div class="row comman_header justify-content-between">
                                                <div class="col-auto">
                                                   <h2>Meals count</h2> 
                                                </div>
                                                <div class="col text-center">
                                                   <span class="selected_date">06/10/2022</span>
                                                </div>
                                                <div class="col-auto d-flex">
                                                   <a href="javscript:;" class="comman_btn yellow-btn me-2">Print</a>
                                                   <form class="form-design" action="">
                                                      <div class="form-group mb-0 position-relative only_calender">
                                                         <input type="date" class="form-control" placeholder="Search Recent Orders" name="name" id="name"> 
                                                      </div>
                                                   </form>
                                                </div>
                                             </div> 
                                             <div class="row">
                                                <div class="col-12 comman_table_design border bg-white px-0 search_show_tables1">
                                                   <div class="table-responsive">
                                                      <table class="table mb-0">
                                                         <thead>
                                                           <tr>
                                                             <th>Label <br> <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text"></th>
                                                             <th>Name of Meal <br> <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text"></th>
                                                             <th>Diet Plan <br> <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text"></th>
                                                             <th>Category <br> <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text"></th>
                                                             <th>Department <br> <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text"></th>
                                                             <th>XS</th>
                                                             <th>s</th> 
                                                             <th>m</th>  
                                                             <th>l</th>  
                                                             <th>xl</th>  
                                                             <th>Total <br> <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text"></th>  
                                                           </tr>
                                                         </thead>
                                                         <tbody>
                                                            <tr>
                                                               <td>
                                                                  <a class="pdf_icon" href="javascript:;"><i class="fas fa-file-pdf"></i></a>
                                                               </td>
                                                               <td>Club Sandwich</td>
                                                               <td>Balanced Diet</td>
                                                               <td>Lunch&dinner</td>
                                                               <td>Sandwich</td>
                                                               <td>25</td>
                                                               <td>10</td>
                                                               <td>5</td>
                                                               <td>100</td>
                                                               <td>250</td>
                                                               <td>390</td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  <a class="pdf_icon" href="javascript:;"><i class="fas fa-file-pdf"></i></a>
                                                               </td>
                                                               <td>Corn Flakes Milk</td>
                                                               <td>Balanced Diet</td>
                                                               <td>Breakfast</td>
                                                               <td>Hot Section</td>
                                                               <td></td>
                                                               <td>120</td>
                                                               <td> </td>
                                                               <td>100</td>
                                                               <td></td>
                                                               <td>220</td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  <a class="pdf_icon" href="javascript:;"><i class="fas fa-file-pdf"></i></a>
                                                               </td>
                                                               <td>Corn Flakes Milk</td>
                                                               <td>Balanced Diet</td>
                                                               <td>Snack</td>
                                                               <td>Bakery</td>
                                                               <td>115</td>
                                                               <td>52</td>
                                                               <td> </td>
                                                               <td> </td>
                                                               <td>10</td>
                                                               <td>177</td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  <a class="pdf_icon" href="javascript:;"><i class="fas fa-file-pdf"></i></a>
                                                               </td>
                                                               <td>Egg Wrap</td>
                                                               <td>Balanced Diet</td>
                                                               <td>Snack</td>
                                                               <td>Hot Section</td>
                                                               <td></td>
                                                               <td>55</td>
                                                               <td> </td>
                                                               <td> </td>
                                                               <td>100</td>
                                                               <td>155</td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  <a class="pdf_icon" href="javascript:;"><i class="fas fa-file-pdf"></i></a>
                                                               </td>
                                                               <td>Fattoush Salad</td>
                                                               <td>Balanced Diet</td>
                                                               <td>Snack</td>
                                                               <td>Salad</td>
                                                               <td>2</td>
                                                               <td>100</td>
                                                               <td>1</td>
                                                               <td> </td>
                                                               <td></td>
                                                               <td>103</td>
                                                            </tr>
                                                            <tr>
                                                               <td>
                                                                  <a class="pdf_icon" href="javascript:;"><i class="fas fa-file-pdf"></i></a>
                                                               </td>
                                                               <td>French Onion Soup</td>
                                                               <td>Balanced Diet</td>
                                                               <td>Lunch&dinner</td>
                                                               <td>Hot Section</td>
                                                               <td>25</td>
                                                               <td>10</td>
                                                               <td>5</td>
                                                               <td>100</td>
                                                               <td>250</td>
                                                               <td>390</td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </div>
                                                </div>
                                             </div>  
                                          </div>
                                       </div>
                                    </div> 
                                    <div class="tab-pane fade" id="nav-profile1" role="tabpanel" aria-labelledby="nav-profile1-tab">
                                       <div class="row mx-0 px-4 py-4">
                                          <div class="col-12 mb-4">
                                             <form class="form-design filter_check" action=""> 
                                                <div class="check_toggle d-flex">
                                                   <span>Filter : </span>
                                                   <input type="checkbox" name="check23" id="check23" class="d-none">
                                                   <label class="onclk2" for="check23"></label>
                                                </div>
                                             </form>
                                          </div>
                                          <div class="col-12 design_outter_comman">
                                             <div class="row comman_header justify-content-between">
                                                <div class="col-auto">
                                                   <h2>Procurement</h2> 
                                                </div>
                                                <div class="col text-center">
                                                   <span class="selected_date">06/10/2022</span>
                                                </div>
                                                <div class="col-auto d-flex">
                                                   <a href="javscript:;" class="comman_btn yellow-btn me-2">Print</a>
                                                   <form class="form-design" action="">
                                                      <div class="form-group mb-0 position-relative only_calender">
                                                         <input type="date" class="form-control" placeholder="Search Recent Orders" name="name" id="name"> 
                                                      </div>
                                                   </form>
                                                </div>
                                             </div> 
                                             <div class="row">
                                                <div class="col-12 comman_table_design border bg-white px-0 search_show_tables2">
                                                   <div class="table-responsive">
                                                      <table class="table mb-0">
                                                         <thead>
                                                           <tr>
                                                             <th>Name of Item <br> <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text"></th>
                                                             <th>Unit <br> <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text"></th>
                                                             <th>Category <br> <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text"></th>
                                                             <th>Department <br> <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text"></th>
                                                             <th>Qty <br> <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text"></th> 
                                                           </tr>
                                                         </thead>
                                                         <tbody>
                                                            <tr>
                                                               <td>Onion</td>
                                                               <td>Gram</td>
                                                               <td>Vegetable</td>
                                                               <td>Hot section</td>
                                                               <td>20000</td> 
                                                            </tr>
                                                            <tr>
                                                               <td>Potatot</td>
                                                               <td>Gram</td>
                                                               <td>Vegetable</td>
                                                               <td></td>
                                                               <td>1000</td> 
                                                            </tr> 
                                                            <tr>
                                                               <td>Green Chilli</td>
                                                               <td>Gram</td>
                                                               <td>Vegetable</td>
                                                               <td></td>
                                                               <td>500</td> 
                                                            </tr>
                                                            <tr>
                                                               <td>Lettuce</td>
                                                               <td>Gram</td>
                                                               <td>Vegetable</td>
                                                               <td></td>
                                                               <td>2000</td> 
                                                            </tr>
                                                            <tr>
                                                               <td>Cabbage</td>
                                                               <td>Gram</td>
                                                               <td>Vegetable</td>
                                                               <td></td>
                                                               <td>3500</td> 
                                                            </tr>
                                                            <tr>
                                                               <td>Oil</td>
                                                               <td>Ml</td>
                                                               <td>Kitchen diary</td>
                                                               <td></td>
                                                               <td>1555</td> 
                                                            </tr>
                                                            <tr>
                                                               <td>Cheese</td>
                                                               <td>Gram</td>
                                                               <td>Frozen Products</td>
                                                               <td></td>
                                                               <td>550</td> 
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </div>
                                                </div>
                                             </div> 
                                          </div>
                                       </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile2" role="tabpanel" aria-labelledby="nav-profile2-tab">
                                       <div class="row mx-0 px-4 py-4">
                                          <div class="col-12 mb-4 px-0">
                                             <form class="form-design help-support-form row align-items-end justify-content-flex-start" action="">
                                                <div class="form-group col-3">
                                                   <label for="">User Name</label>
                                                   <input class="form-control" type="text" id="userName" name="">
                                                </div>
                                                <div class="form-group col-3">
                                                   <label for="">User ID</label>
                                                   <input class="form-control" type="text" id="userId" name="">
                                                </div>
                                                <div class="form-group col-3">
                                                   <label for="">Plan Type</label>
                                                   <select class="form-select form-control" aria-label="Default select example" id="plan_type">
                                                      <option selected="">Select Plan Type</option>
                                                      @foreach($dietPlanType as $dietPlanTypes)
                                                      <option value="{{$dietPlanTypes->id}}">{{$dietPlanTypes->name}}</option>
                                                     @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-3">
                                                   <label for="">Date</label>
                                                   <input class="form-control" type="date" id="planDate" name="">
                                                </div>
                                                <div class="form-group col-3 mb-0">
                                                   <label for="">Mobile Number</label>
                                                   <input class="form-control" type="text" id="userNumber" name="">
                                                </div>
                                                <div class="form-group col-3 mb-0">
                                                   <label for="">Time Slot</label>
                                                   <select class="form-select form-control" aria-label="Default select example" id="timeSlot">
                                                      <option selected="">Select Time Slot</option>
                                                      @foreach($timeSlot as $timeSlots)
                                                      <option value="{{$timeSlots->id}}">{{$timeSlots->name}}({{$timeSlots->start_time}}-{{$timeSlots->end_time}}</option>
                                                   @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-3 mb-0">
                                                   <label for="">Driver</label>
                                                   <select class="form-select form-control" aria-label="Default select example" id="driver">
                                                      <option selected="">Select Driver</option>
                                                      @foreach($driver as $drivers)
                                                      <option value="{{$drivers->id}}">{{$drivers->name}}</option>
                                                     @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-3 mb-0">
                                                   <label for="">Area</label>
                                                   <select class="form-select form-control" aria-label="Default select example" id="selectArea">
                                                      <option selected="">Select Area</option>
                                                      @foreach($area as $areas)
                                                      <option value="{{$areas->area}}">{{$areas->area}}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                             </form>
                                          </div>
                                          <div class="col-12 mb-4 text-center">
                                             <button class="comman_btn mx-2" id="searchPackingList" type="button">Search</button> 
                                             <button class="comman_btn mx-2">Print</button>
                                             <button class="comman_btn mx-2">Excel</button>
                                          </div>
                                          
                                          <div id="DefaultSelection">
                                     <!-- defaultMealPageSection -->
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
            </div>
         </div>
      </div>
      <script src="{{asset('assets/vendor/jquery.min.js')}}"></script>
      <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
      <script src="{{asset('assets/vendor/owl/owl.carousel.min.js')}}"></script>
      <script src="{{asset('assets/js/main.js')}}"></script>
   
   <script>
   $(document).ready(function(){
   $('#searchPackingList').on('click',function(){
var flag = true;

if(flag){
    var user_name =$('#userName').val();
    var user_id =$('#userId').val();
    var diet_plan_id =$('#plan_type').find('option:selected').val();
    // var diet_plan =$('#diet_plan_id').find('option:selected').attr('data-id');
    var planDate =$('#planDate').val();
    var userNumber =$('#userNumber').val();
    var timeSlot =$('#timeSlot').val();
    var driver =$('#driver').find('option:selected').val();
    var selectArea =$('#selectArea').find('option:selected').val();

    // var meal_groups_hidden=[];
    // var arr = $("input:checkbox[name*=meal_groups]:checked").each(function(){
    //     meal_groups_hidden.push($(this).val());
    // });
   
    $.ajax({
        url:'{{ url("admin/search_packing_list") }}',
        method:'post',
        data: {
            user_name:user_name,
            user_id:user_id,
            diet_plan_id:diet_plan_id,
            planDate:planDate,
            userNumber:userNumber,
            timeSlot:timeSlot,
            driver:driver,
            selectArea:selectArea,
            // meal_groups_hidden_name:meal_groups_hidden_name
            "_token": "{{ csrf_token() }}",
        },
        dataType:'json',
        type: "post",
        cache: false,
        success:function(data)
        {
            // console.log(data);
            $('#DefaultSelection').html(data.html);
            // $('#variantsShow').css('display','block');
            // $('#tbody').append('<tr><td><div class="check_radio td_check_radio"><input type="checkbox" checked name="table2" id="table2" class="d-none"><label for="table2"></label></div></td><td>'+variant_name+'</td><td>'+diet_plan_id+'</td><td>'+meal_groups_hidden_name+'</td><td>'+ option1_value+'</td><td>'+option2_value+'</td><td>'+no_of_days+'</td><td>'+calorie_value+'</td><td>'+serving_calorie_value+'</td><td>'+delivery_price_value+'</td><td>'+plan_price_value+'</td><td>'+compare_price_value+'</td><td>'+description_value+'</td><input type="hidden" name="variant_name_hidden[]" value="'+variant_name+'"><input type="hidden" name="diet_plan_hidden[]" value="'+diet_plan+'"><input type="hidden" name="option1_hidden[]" value="'+option1_value+'"><input type="hidden" name="option2_hidden[]" value="'+option2_value+'"><input type="hidden" name="no_of_days_hidden[]" value="'+no_of_days+'"><input type="hidden" name="serving_calorie_hidden[]" value="'+serving_calorie_value+'"><input type="hidden" name="meal_groups_hidden_name[]" value="'+meal_groups_hidden_name+'"><input type="hidden" name="calorie_hidden[]" value="'+calorie_value+'"><input type="hidden" name="delivery_price_hidden[]" value="'+delivery_price_value+'"><input type="hidden" name="plan_price_hidden[]" value="'+plan_price_value+'"><input type="hidden" name="compare_price_hidden[]" value="'+compare_price_value+'"><input type="hidden" name="is_charge_vat_hidden[]" value="'+is_charge_vat+'"><input type="hidden" name="description_value_hidden[]" value="'+description_value+'"></tr>');
        }
    })
}


});

});
</script>
@endsection