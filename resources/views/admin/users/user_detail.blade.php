@extends('admin.layout.master')
@section('content')
      <div class="admin_main">
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
               <div class="row user-details-part justify-content-center">
                  <div class="col-12">
                     <div class="row mx-0">
                        <div class="col-12 design_outter_comman shadow mb-4">
                           <div class="row comman_header justify-content-between">
                              <div class="col-auto">
                                 <h2>User's Information</h2>
                              </div>
                           </div>
                           <div class="row">
                              <form class="row align-items-center justify-content-center form-design position-relative p-4 py-5">
                              @if(Session::get('admin_logged_in')['type']=='0')
                                 <div class="check_toggle">
                                    <input type="checkbox"  name="check1" id="check1" class="d-none"  onchange="changeStatus(this, '<?= $user->id ?>');" <?= ( $user->status == '1' ? 'checked' : '') ?>>
                                    <label for="check1"></label>
                                 </div>
                                 @endif
                                 @if(Session::get('admin_logged_in')['type']=='1')
                                 @if(Session::get('staff_logged_in')['user_mgmt']!='1')
                                 <div class="check_toggle">
                                    <input type="checkbox"  name="check1" id="check1" class="d-none"  onchange="changeStatus(this, '<?= $user->id ?>');" <?= ( $user->status == '1' ? 'checked' : '') ?>>
                                    <label for="check1"></label>
                                 </div>
                                 
                                 @endif
                                 @endif
                                 <div class="col-5">
                                    <div class="row adjust_margin">
                                       <div class="form-group col-12 mb-2">
                                          <div class="userinfor_box text-center">
                                             <span class="user_imgg">
                                             <img src="{{$user->image?$user->image:asset('assets/img/profile.png')}}" alt="">
                                             </span>
                                             <strong>{{$user->name}}</strong>
                                          </div>
                                       </div>
                                       <div class="form-group col-12 text-center mb-0">
                                          <label class="mb-0 text-center" for="">Registration Date: {{date('d/m/Y', strtotime($user->created_at))}}</label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-5">
                                    <div class="row">
                                       <div class="form-group col-12">
                                          <label for="">Mobile Number</label>
                                          <input type="text" class="form-control" value="{{$user->country_code}}&nbsp;&nbsp;{{$user->mobile}}" readonly="true" name="name" id="name">
                                       </div>
                                       <div class="form-group col-12 mb-0">
                                          <label for="">Email Id </label>
                                          <input type="text" class="form-control" value="{{$user->email}}" name="name" readonly="true" id="name">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-auto"></div>
                              </form>
                           </div>
                        </div>
                        <div class="col-12 design_outter_comman shadow">
                           <div class="row">
                              <div class="col-12 px-0 user-details-tabs">
                                 <ul class="nav nav-tabs border-bottom" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                       <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Personal Details</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                       <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Order History(08)</button>
                                    </li>
                                 </ul>
                                 <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                       <div class="row">
                                          <div class="col-12">
                                             <form class="row form-design position-relative mx-0 p-4 pb-0 border-bottom">
                                                <div class="col-12 border-bottom pb-4">
                                                   <div class="row">
                                                      <div class="form-group col-12">
                                                         <strong class="head_details">Body Details</strong>
                                                      </div>
                                                      <div class="form-group col-6">
                                                         <label for="">Height</label>
                                                         <input type="text" class="form-control"  value="{{!empty($user_details) ? $user_details->height : 'N/A'}}" readonly="true" name="name" id="name">
                                                      </div>
                                                      <div class="form-group col-6">
                                                         <label for="">Weight</label>
                                                         <input type="text" class="form-control" value="{{!empty($user_details) ? $user_details->initial_body_weight : 'N/A'}}" readonly="true" name="name" id="name">
                                                      </div>
                                                      <div class="form-group col-6">
                                                         <label for="">DOB</label>
                                                         <input type="text" class="form-control" value="{{!empty($user_details) ? $user_details->dob : 'N/A'}}" readonly="true" name="name" id="name">
                                                      </div>
                                                      <div class="form-group col-6">
                                                         <label for="">Age</label>
                                                         <input type="text" class="form-control" value="{{!empty($user_details) ? $user_details->age: 'N/A'}}" readonly="true" name="name" id="name">
                                                      </div>
                                                      <div class="form-group col-6">
                                                         <label for="">Gender</label>
                                                         <input type="text" class="form-control" value="{{$user_details['gender']}}" readonly="true" name="name" id="name">
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-12 border-bottom pb-4 pt-4">
                                                   <div class="row">
                                                      <div class="form-group col-12">
                                                         <strong class="head_details">Activity Details</strong>
                                                      </div>
                                                      <div class="form-group col-6"> 
                                                        @if($user_details['activity_scale'] == '1')
                                                         <input type="text" class="form-control" value="Little or no Exercise" readonly="true" name="name" id="name">
                                                         @elseif($user_details['activity_scale'] == '2')
                                                         <input type="text" class="form-control" value="1-3 workouts/week" readonly="true" name="name" id="name">
                                                         @else
                                                         <input type="text" class="form-control" value="4-5 workouts/week" readonly="true" name="name" id="name">
                                                         @endif
                                                      </div> 
                                                   </div>
                                                </div>
                                                <div class="col-12 border-bottom pb-4 pt-4">
                                                   <div class="row">
                                                      <div class="form-group col-12">
                                                         <strong class="head_details">Fitness Goal</strong>
                                                      </div>
                                                      <div class="form-group col-6"> 
                                                         <input type="text" class="form-control" value="{{!empty($user_details->fitness) ? $user_details->fitness->name : 'N/A'}}" readonly="true" name="name" id="name">
                                                      </div> 
                                                   </div>
                                                </div>
                                                <div class="col-12 border-bottom pb-4 pt-4">
                                                   <div class="row">
                                                      <div class="form-group col-12">
                                                         <strong class="head_details">Dislikes</strong>
                                                      </div>
                                                      <div class="form-group col-6"> 
                                                       @if(!empty($user_dislike))
                                                         <input type="text" class="form-control"  <?php foreach($user_dislike as $user_dislikes){ ?> value="{{ $user_dislikes->pluck('name')->implode(',  ') }}"<?php } ?> readonly="true" name="name" id="name">
                                                        @else
                                                        <input type="text" class="form-control"  value="N/A" readonly="true" name="name" id="name">
                                                        @endif
                                                      </div> 
                                                   </div>
                                                </div>
                                                <div class="col-12 border-bottom pb-4 pt-4">
                                                   <div class="row">
                                                      <div class="form-group col-12">
                                                         <strong class="head_details">Plan Type</strong>
                                                      </div>
                                                      <div class="form-group col-6"> 
                                                         <input type="text" class="form-control" value="{{ !empty($user_details->dietplan) ? $user_details->dietplan->name:'N/A' }}" readonly="true" name="name" id="name">
                                                      </div> 
                                                   </div>
                                                </div>
                                                <div class="col-12 border-bottom pb-4 pt-4">
                                                   <div class="row">
                                                      <div class="form-group col-12">
                                                         <strong class="head_details">Target Calories & Macro Nutrients</strong>
                                                      </div>
                                                      <div class="form-group col-6">
                                                         <label for="">Calories</label>
                                                         <input type="text" class="form-control" value="{{!empty($userCalorieTargets) ? $userCalorieTargets->calori_per_day:'--'}}" readonly="true" name="name" id="name">
                                                      </div>
                                                      <div class="form-group col-6">
                                                         <label for="">Protein</label>
                                                         <input type="text" class="form-control"  value="{{!empty($userCalorieTargets) ? $userCalorieTargets->protein_per_day:'--'}}" readonly="true" name="name" id="name">
                                                      </div>
                                                      <div class="form-group col-6">
                                                         <label for="">Carbs</label>
                                                         <input type="text" class="form-control"  value="{{!empty($userCalorieTargets) ? $userCalorieTargets->carbs_per_day:'--'}}" readonly="true" name="name" id="name">
                                                      </div>
                                                      <div class="form-group col-6">
                                                         <label for="">Fat</label>
                                                         <input type="text" class="form-control"  value="{{!empty($userCalorieTargets) ? $userCalorieTargets->fat_per_day:'--'}}" readonly="true" name="name" id="name">
                                                      </div>
                                                   </div>
                                                </div>
                                             </form>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                       <div class="row mx-0 p-4">  
                                          <div class="col-12 design_outter_comman border mb-4">
                                             <div class="row comman_header justify-content-between">
                                                <div class="col">
                                                   <h2>Current Plan</h2>
                                                </div> 
                                             </div> 
                                             <div class="row">
                                                <div class="col-12 comman_table_design px-0">
                                                   <div class="table-responsive">
                                                      <table class="table mb-0">
                                                         <thead>
                                                           <tr>
                                                             <th>S.No.</th>
                                                             <th>Plan Name</th>
                                                             <th>Order ID</th>
                                                             <th>SAR</th>
                                                             <th>Purchased On</th>
                                                             <th>Expired On</th> 
                                                             <th>Credit Balance</th> 
                                                             <th>Status</th> 
                                                             <th>Action</th>
                                                             <th>Send Invoice</th>
                                                           </tr>
                                                         </thead>
                                                         <tbody>
                                                           <tr>
                                                             <td>1</td>   
                                                             <td>{{$user_current_plan['name'] ?: '--'}}</td>   
                                                             <td>{{$user_current_plan['order_id'] ?: '--' }}</td>   
                                                             <td>{{$user_current_plan['plan_price'] ?: '--' }}/<?php if($user_current_plan['option1'] == 'weekly'){?> week <?php }else{?> month <?php }?></td>   
                                                             <td>{{$user_current_plan['puchase_on'] ?: '--' }}</td>   
                                                             <td>{{$user_current_plan['expired_on'] ?: '--' }}</td>   
                                                             <td>{{$user_current_plan['available_credit'] ?: '--' }} SAR</td>   
                                                             <td>
                                                             <div class="mytoggle">
                                                                <label class="switch">
                                                                   <input type="checkbox" onchange="changeStatusForCurrentPlan(this, '<?= $user_current_plan['id'] ?>');" <?= ($user_current_plan['status'] == 'active' ? 'checked' : '') ?> ><span class="slider round"> </span> 
                                                                 </label>
                                                             </div>
                                                             </td>    
                                                             <td>
                                                             <a class="comman_btn table_viewbtn" href="{{url('admin/order-details/'.base64_encode($user_current_plan['user_id']))}}">View</a>
                                                             </td>
                                                             <td>
                                                               <a class="comman_btn table_viewbtn" href="javscript:;">Send</a>
                                                             </td>
                                                      
                                                         </tbody>
                                                       </table>
                                                   </div>
                                                </div>
                                             </div>
                                          </div> 
                                          <div class="col-12 design_outter_comman border mb-4">
                                             <div class="row comman_header justify-content-between">
                                                <div class="col-auto">
                                                   <h2>Previous Plans</h2>
                                                </div>
                                                <div class="col-auto"> 
                                                   <button class="comman_btn">Print</button>
                                                </div>
                                             </div> 
                                             <div class="row">
                                                <div class="col-12 comman_table_design px-0">
                                                   <div class="table-responsive">
                                                      <table class="table mb-0">
                                                         <thead>
                                                           <tr>
                                                             <th>S.No.</th>
                                                             <th>Plan Name</th>
                                                             <th>Order ID</th>
                                                             <th>SAR</th>
                                                             <th>Purchased On</th>
                                                             <th>Expired On</th> 
                                                             <th>Credit Balance</th> 
                                                             <th>Status</th> 
                                                             <th>Action</th>
                                                             <th>Send Invoice</th>
                                                           </tr>
                                                         </thead>
                                                         <tbody>
                                                            @if(count($user_previous_plan) > 0)
                                                            @foreach($user_previous_plan as $key=>$user_previous_plans)
                                                           <tr>
                                                             <td>{{$key+1}}</td>   
                                                             <td>{{$user_previous_plans['name'] ?: '-'}}</td>  
                                                             @php 
                                                             $orderId =\App\Models\Order::select('id')->where('user_id',$user_previous_plans['user_id'])->first();
                                                             @endphp
                                                            
                                                             <td>{{$orderId['id'] ?: '-' }}</td>   
                                                             <td>{{$user_previous_plans['plan_price'] ?: '-' }}/<?php if($user_previous_plans['option1'] == 'weekly'){?> week <?php }else{?> month <?php }?></td>      
                                                             <td>{{date('d/m/Y',strtotime($user_previous_plans['puchase_on']))}}</td>   
                                                             <td>{{date('d/m/Y',strtotime($user_previous_plans['expired_on']))}}</td>   
                                                             <td>{{$user_previous_plans['plan_price'] ?: '-' }} SAR</td>   
                                                             <td>
                                                             <div class="mytoggle">
                                                                <label class="switch">
                                                                   <input type="checkbox" onchange="changeStatusForPreviousPlan(this, '<?= $user_previous_plans['id'] ?>');" <?= ($user_previous_plans['status'] == 'active' ? 'checked' : '') ?> ><span class="slider round"> </span> 
                                                                 </label>
                                                             </div>
                                                             </td>    
                                                             <td>
                                                             <a class="comman_btn table_viewbtn" href="{{url('admin/previous-order-details',['id' => $user_previous_plans['user_id'] ,'plan_id' => $user_previous_plans['plan_id']] )}}">View</a>
                                                             </td>
                                                             <td>
                                                               <a class="comman_btn table_viewbtn" href="javscript:;">Send</a>
                                                             </td>
                                                           </tr> 
                                                          @endforeach
                                                          @else
                                                          <tr>
                                                            <td>
                                                           <p> No Plan Found...</p>
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
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
    @endsection
    <script>
       function changeStatusForPreviousPlan(obj, id) {
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
                                var status = 'terminted';
                            }
                            if (id) {
                                $.ajax({
                                    url: "<?= url('admin/currentPlan/change_previousPlan_status') ?>",
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
    <script>
       function changeStatusForCurrentPlan(obj, id) {
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
                                var status = 'terminted';
                            }
                            if (id) {
                                $.ajax({
                                    url: "<?= url('admin/currentPlan/change_currentPlan_status') ?>",
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
                                var status = '1';
                            } else {
                                var status = '0';
                            }
                            if (id) {
                                $.ajax({
                                    url: "<?= url('admin/user/change_user_status') ?>",
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


