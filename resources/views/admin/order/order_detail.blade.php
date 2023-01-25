
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
                                 <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                       <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Personal Details</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                       <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Order History(08)</button>
                                    </li>
                                 </ul>
                                 <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
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
                                                         <label for="">Workouts</label>
                                                         @if($user_details['activity_scale'] == '1')
                                                         <input type="text" class="form-control" value="Little or no Exercise" readonly="true" name="name" id="name">
                                                         @elseif($user_details['activity_scale'] == '2')
                                                         <input type="text" class="form-control" value="1-3 workouts/week" readonly="true" name="name" id="name">
                                                         @else
                                                         <input type="text" class="form-control" value="4-5 workouts/week" readonly="true" name="name" id="name">
                                                         @endif
                                                      </div>
                                                      <div class="form-group col-6">
                                                         <label for="">Fitness Goal</label>
                                                         <input type="text" class="form-control" value="{{!empty($user_details->fitness) ? $user_details->fitness->name : 'N/A'}}" readonly="true" name="name" id="name">
                                                      </div>
                                                      <div class="form-group col-6">
                                                         <label for="">Dislikes</label>
                                                         @if(!empty($user_dislike))
                                                         <input type="text" class="form-control"  <?php foreach($user_dislike as $user_dislikes){ ?> value="{{ $user_dislikes->pluck('name')->implode(',  ') }}"<?php } ?> readonly="true" name="name" id="name">
                                                        @else
                                                        <input type="text" class="form-control"  value="N/A" readonly="true" name="name" id="name">
                                                        @endif
                                                      </div>
                                                      <div class="form-group col-6">
                                                         <label for="">Plan Type</label>
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
                                                         <input type="text" class="form-control" value="{{!empty($userCalorieTargets) ? $userCalorieTargets->calori_per_day:'N/A'}}" readonly="true" name="name" id="name">
                                                      </div>
                                                      <div class="form-group col-6">
                                                         <label for="">Protein</label>
                                                         <input type="text" class="form-control"  value="{{!empty($userCalorieTargets) ? $userCalorieTargets->protein_per_day:'N/A'}}" readonly="true" name="name" id="name">
                                                      </div>
                                                      <div class="form-group col-6">
                                                         <label for="">Carbs</label>
                                                         <input type="text" class="form-control"  value="{{!empty($userCalorieTargets) ? $userCalorieTargets->carbs_per_day:'N/A'}}" readonly="true" name="name" id="name">
                                                      </div>
                                                      <div class="form-group col-6">
                                                         <label for="">Fat</label>
                                                         <input type="text" class="form-control"  value="{{!empty($userCalorieTargets) ? $userCalorieTargets->fat_per_day:'N/A'}}" readonly="true" name="name" id="name">
                                                      </div>
                                                   </div>
                                                </div>
                                             </form>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                       <div class="row mx-0">
                                          <div class="col-12">
                                             <div class="row p-4">
                                                <div class="col-12 mb-2">
                                                   <strong class="head_details">Current Plan</strong>
                                                </div>
                                                <div class="col-12 mb-5">
                                                   <div class="row">
                                                      <div class="col-md-12 mt-4">
                                                         <div class="plan_box">
                                                            <div class="row align-items-center">
                                                               <div class="col-4">
                                                                  <div class="plan_img">
                                                                     <img src="{{$subscription->image}}" alt=""> 
                                                                     @php
     
                                                                           $dates = carbon\Carbon::createFromFormat('Y-m-d',$subscription->start_date->start_date);
                                                                            $date = $dates->addDays($subscription->no_days);
                                                                            $diff = now()->diffInDays(carbon\Carbon::parse($date));
                                                                            if($diff == 0){
                                                                            $days_remaining  = "Your plan is expire today";
                                                                              }
                                                                             elseif($date< now()){
                                                                             $days_remaining  = "0";
                                                                               }else{
                                                                              $days_remaining  = $diff;
                                                                                }
      
                                                                     @endphp
                                                                     <span class="days_left">{{$days_remaining}} days left to expire</span>
                                                                  </div>
                                                               </div>
                                                               <div class="col-3">
                                                                  <div class="plan_data text-start pt-2">
                                                                     <h2>Plan Name <span>({{$subscription->name}})</span></h2>
                                                                     <strong>{{$subscription->cost}} SAR/{{$subscription->day}}</strong>
                                                                     <div class="promo">Promo 10%</div> 
                                                                     <div class="orderdetails mt-1">
                                                                        <span class="mb-1 d-flex">Order: <strong> #2305</strong></span>
                                                                        <span class="d-flex mb-1">Plan Expiry Date: <strong>{{date('d/m/Y',strtotime($date))}}</strong></span> 
                                                                        <span class="d-flex">Credit Balance: <strong>{{$user_details->available_credit}}</strong></span> 
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                               <div class="col">
                                                                  <div class="plan_discription">
                                                                     <strong>Description:</strong>
                                                                     <ul class="list-circle mb-0">
                                                                        @foreach($subscription->description as $subscriptions)
                                                                        <li>
                                                                           <p>{{$subscriptions}}</p>
                                                                        </li>
                                                                        @endforeach
                                                                        <!-- <li>
                                                                           <p>5 days a week.</p>
                                                                        </li>
                                                                        <li>
                                                                           <p>4 Meals Package (Breakfast, Lunch, Snacks, Dinner).</p>
                                                                        </li> -->
                                                                     </ul>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-12">
                                                   <div class="row mx-0">
                                                      <div class="col-12 px-0 mb-4 mt-4">
                                                         <div class="adress_deliveries">
                                                            <h3>Deliveries :</h3>
                                                            <div class="row">
                                                               <div class="col-6 mb-1">
                                                                  <div class="row">
                                                                     <div class="col-auto">
                                                                        <span>Location :</span>
                                                                     </div>
                                                                     <div class="col">
                                                                  
                                                                        <a href="javscript:;">{{$date}}, Vrindavan Umedshram Rd, Sv Rd, Borivli(w)</a>
                                        
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                               <div class="col-6">
                                                                  <div class="row">
                                                                     <div class="col-auto">
                                                                        <span>Slot :</span>
                                                                     </div>
                                                                     <div class="col">
                                                                        <a href="javscript:;">{{$date}}- {{$date}}</a>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="col-12 mt-2 mb-4">
                                                         <div class="Plan_category_slider owl-carousel">
                                                          
                                                         @foreach($getDatess as $k=>$datt)
                                                         @if($k==0)
                                                         
                                                         <div ><a class="Plan_datee date_name active" onclick="activeDate(this,'<?= $datt->date ?>');"  href="javscript:;">{{date('d M',strtotime($datt->date))}}</a></div>
                                                         @else
                                                     
                                                            <div><a class="Plan_datee  date_name" onclick="activeDate(this,'<?= $datt->date ?>');" href="javscript:;">{{date('d M', strtotime($datt->date))}} </a></div>
                                                            @endif
                                                            @endforeach
                                                          
                                                         </div>
                                                      </div>
                                                      <div class="col-12">
                                                   
                                                         <div class="row">
                                                         @foreach($getDatess as $k=>$datt)
                                                        
                                                            <div class="col-12 current_plan_tabbing date_list" id='date_list_<?= $datt->date ?>' <?php if($k!=0)  { ?> style="display:none" <?php }?>>
                                                               <nav>
                                                                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                                  
                                                                    @foreach($datt->category as $y=>$categories)
                                                                    @if($y==0)
                                                                     <button class="nav-link vaccine_name active" id="nav-home-tab" onclick="activeTab(this,<?=$categories['meal_schedule_id']?>);" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">{{$categories['meal_group']['name']}} ({{count($categories['meal_group']['meals'])}}) </button>
                                                                     @else
                                                                     <button class="nav-link vaccine_name" id="nav-home-tab" onclick="activeTab(this,<?=$categories['meal_schedule_id']?>);" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">{{$categories['meal_group']['name']}} ({{count($categories['meal_group']['meals'])}}) </button>
                                                                     @endif
                                                                     @endforeach
                                                                   
                                                                     <!-- <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Lunch & Dinner</button>
                                                                     <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Snacks</button>
                                                                     <button class="nav-link" id="nav-contact1-tab" data-bs-toggle="tab" data-bs-target="#nav-contact1" type="button" role="tab" aria-controls="nav-contact1" aria-selected="false">Dinner</button>
                                                                     <button class="nav-link" id="nav-contact2-tab" data-bs-toggle="tab" data-bs-target="#nav-contact2" type="button" role="tab" aria-controls="nav-contact2" aria-selected="false">Soup</button> -->
                                                                  </div>
                                                               </nav>
                                                               <div class="tab-content" id="nav-tabContent">
                                                             
                                                                  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                                
                                                                    @foreach($datt->category as $y=>$categories)
                                                                   
                                                                     <div class="row mx-0 plan_tabbing_inner video_list" id='video_list_<?=$categories['meal_schedule_id']?>' <?php if($y!=0)  { ?> style="display:none" <?php }?>>
                                                                        <div class="col-12 p-4">
                                                                        @foreach($categories['meal_group']['meals'] as $v=>$meal)
                                                                           <div class="plan_box mb-4">
                                                                              <div class="row align-items-center">
                                                                                 <div class="col">
                                                                                    <div class="plan_img">
                                                                                       <img src="{{$meal['image']}}" alt="">  
                                                                                    </div>
                                                                                 </div>
                                                                                 <div class="col-4">
                                                                                    <div class="plan_data text-start">
                                                                                       <h2>{{$meal['name']}}</h2>
                                                                                       <div class="rating_box">
                                                                                          <a href="javscript:;"><i class="fas fa-star"></i></a>
                                                                                          <a href="javscript:;"><i class="fas fa-star"></i></a>
                                                                                          <a href="javscript:;"><i class="fas fa-star"></i></a>
                                                                                          <a href="javscript:;"><i class="fas fa-star"></i></a>
                                                                                          <a href="javscript:;"><i class="fas fa-star"></i></a>
                                                                                       </div>
                                                                                       <div class="row mx-0 bg-light rounded-custom mt-2 border">
                                                                                          <div class="col-12">
                                                                                             <div class="row plan_box_inner py-1 border-bottom">
                                                                                                <div class="col-6 pe-1 ps-2">
                                                                                                   <span>Calories :</span>
                                                                                                </div>
                                                                                                <div class="col-6 ps-1 pe-2">
                                                                                                   <strong>{{$meal['meal_calorie']}} cal</strong>
                                                                                                </div>
                                                                                             </div>
                                                                                             <div class="row plan_box_inner py-1 border-bottom">
                                                                                                <div class="col-6 pe-1 ps-2">
                                                                                                   <span>Protein :</span>
                                                                                                </div>
                                                                                                <div class="col-6 ps-1 pe-2">
                                                                                                   <strong>{{$meal['protein']}} gms</strong>
                                                                                                </div>
                                                                                             </div>
                                                                                             <div class="row plan_box_inner py-1 border-bottom">
                                                                                                <div class="col-6 pe-1 ps-2">
                                                                                                   <span>Carbs :</span>
                                                                                                </div>
                                                                                                <div class="col-6 ps-1 pe-2">
                                                                                                   <strong>{{$meal['carbs']}} gms</strong>
                                                                                                </div>
                                                                                             </div>
                                                                                             <div class="row plan_box_inner py-1">
                                                                                                <div class="col-6 pe-1 ps-2">
                                                                                                   <span>Fat :</span>
                                                                                                </div>
                                                                                                <div class="col-6 ps-1 pe-2">
                                                                                                   <strong>{{$meal['fat']}} gms</strong>
                                                                                                </div>
                                                                                             </div>
                                                                                          </div>
                                                                                       </div>
                                                                                    </div>
                                                                                 </div>
                                                                                 <div class="col-4">
                                                                                    <div class="meal_discription">
                                                                                       <strong>Description:</strong>
                                                                                       <div class="meal_discription_inner border">
                                                                                          <p class="subhead">This meal contains:</p>
                                                                                          <ul class="list-circle mb-0">
                                                                                          @foreach($meal['dislikeItem'] as $t=>$dislikeItems)
                                                                                             <li>
                                                                                                <p>{{$dislikeItems->name}}</p>
                                                                                             </li>
                                                                                             @endforeach
                                                                                             <!-- <li>
                                                                                                <p>Chicken</p>
                                                                                             </li>
                                                                                             <li>
                                                                                                <p>Soy</p>
                                                                                             </li> -->
                                                                                          </ul>
                                                                                       </div>
                                                                                    </div>
                                                                                 </div>
                                                                              </div>
                                                                           </div> 
                                                                           @endforeach
                                                                           <!-- <div class="plan_box mb-4">
                                                                              <div class="row align-items-center">
                                                                                 <div class="col">
                                                                                    <div class="plan_img">
                                                                                       <img src="assets/img/bg-img.jpg" alt="">  
                                                                                    </div>
                                                                                 </div>
                                                                                 <div class="col-4">
                                                                                    <div class="plan_data text-start">
                                                                                       <h2>Meal Name</h2>
                                                                                       <div class="rating_box">
                                                                                          <a href="javscript:;"><i class="fas fa-star"></i></a>
                                                                                          <a href="javscript:;"><i class="fas fa-star"></i></a>
                                                                                          <a href="javscript:;"><i class="fas fa-star"></i></a>
                                                                                          <a href="javscript:;"><i class="fas fa-star"></i></a>
                                                                                          <a href="javscript:;"><i class="fas fa-star"></i></a>
                                                                                       </div>
                                                                                       <div class="row mx-0 bg-light rounded-custom mt-2 border">
                                                                                          <div class="col-12">
                                                                                             <div class="row plan_box_inner py-1 border-bottom">
                                                                                                <div class="col-6 pe-1 ps-2">
                                                                                                   <span>Calories :</span>
                                                                                                </div>
                                                                                                <div class="col-6 ps-1 pe-2">
                                                                                                   <strong>500 cal</strong>
                                                                                                </div>
                                                                                             </div>
                                                                                             <div class="row plan_box_inner py-1 border-bottom">
                                                                                                <div class="col-6 pe-1 ps-2">
                                                                                                   <span>Protein :</span>
                                                                                                </div>
                                                                                                <div class="col-6 ps-1 pe-2">
                                                                                                   <strong>150 gms</strong>
                                                                                                </div>
                                                                                             </div>
                                                                                             <div class="row plan_box_inner py-1 border-bottom">
                                                                                                <div class="col-6 pe-1 ps-2">
                                                                                                   <span>Carbs :</span>
                                                                                                </div>
                                                                                                <div class="col-6 ps-1 pe-2">
                                                                                                   <strong>250 gms</strong>
                                                                                                </div>
                                                                                             </div>
                                                                                             <div class="row plan_box_inner py-1">
                                                                                                <div class="col-6 pe-1 ps-2">
                                                                                                   <span>Fat :</span>
                                                                                                </div>
                                                                                                <div class="col-6 ps-1 pe-2">
                                                                                                   <strong>50 gms</strong>
                                                                                                </div>
                                                                                             </div>
                                                                                          </div>
                                                                                       </div>
                                                                                    </div>
                                                                                 </div>
                                                                                 <div class="col-4">
                                                                                    <div class="meal_discription">
                                                                                       <strong>Description:</strong>
                                                                                       <div class="meal_discription_inner border">
                                                                                          <p class="subhead">This meal contains:</p>
                                                                                          <ul class="list-circle mb-0">
                                                                                             <li>
                                                                                                <p>Gluten</p>
                                                                                             </li>
                                                                                             <li>
                                                                                                <p>Chicken</p>
                                                                                             </li>
                                                                                             <li>
                                                                                                <p>Soy</p>
                                                                                             </li>
                                                                                          </ul>
                                                                                       </div>
                                                                                    </div>
                                                                                 </div>
                                                                              </div>
                                                                           </div> -->
                                                                        </div>
                                                                        <div class="col-12 text-center mb-4">
                                                                           <!-- <a class="comman_btn me-3" href="javscript:;">Mark as delivered</a> -->
                                                                           <a href="order-timeline.html" class="comman_btn yellow-btn me-2">Order Timeline</a>
                                                                        </div>
                                                                     </div>
                                                                     @endforeach
                                                                    

                                                                  </div>
                                                               </div>
                                                            </div>
                                                            @endforeach
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
         </div>
      </div>
      
      <script src="assets/vendor/jquery.min.js"></script>
      <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="assets/vendor/owl/owl.carousel.min.js"></script>
      <script src="assets/js/main.js"></script>
      <script>
 function activeDate(obj,dat) {

   $('.date_list').css('display','none');
   $('#date_list_'+ dat ).css('display','block');
   $('.date_name').removeClass('active');
   $(obj ).addClass('active');

    }
    </script>
      <script>
 function activeTab(obj,id) {

   $('.video_list').css('display','none');
   $('#video_list_'+ id ).css('display','block');
   $('.vaccine_name').removeClass('active');
   $(obj ).addClass('active');

    }
    </script>
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