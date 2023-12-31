@extends('admin.layout.master')
@section('content')
    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css" rel="stylesheet"/>
    <div class="admin_main">
        <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        <strong class="close" data-dismiss="alert " aria-hidden="true"></strong>
                        {{ session()->get('success') }}
                    </div>
                @else
                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            <strong class="close" ></strong>
                            {{ session()->get('error') }}
                        </div>
                    @endif
                @endif
                <div class="row addmeal_plann justify-content-center">
                    <div class="col-12">
                        <div class="row mx-0">
                            <div class="col-12 design_outter_comman shadow">
                                <div class="row comman_header justify-content-between">
                                    <div class="col-auto">
                                        <h2>Edit Meal Plan</h2> </div>
                                </div>
                                <form class="form-design py-4 px-4 row align-items-start justify-content-start" id="AddVariantsForms" action="{{url('admin/edit-mealplan/edit_update',[base64_encode($edit_mealPlan->id)])}}" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <input type="hidden" name="images_hidden" value="{{$edit_mealPlan->image}}" id="images_hidden">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for=""> Title (English) :</label>
                                                <input type="text" class="form-control validate" value="{{$edit_mealPlan->name}}" name="title" id="name"> <p class="text-danger text-small" id="titleError"></p></div>
                                            <div class="form-group col-6">
                                                <label for=""> Title (Arabic) :</label>
                                                <input type="text" class="form-control validate" value="{{$edit_mealPlan->name_ar}}" name="title_ar" id="name"> <p class="text-danger text-small" id="title_arError"></p></div>
                                            <div class="form-group col-12 uploadimg_box"> <span>Media :</span>
                                                <input type="file" id="uploadimg" class="dropify" name="images" data-default-file="{{$edit_mealPlan->image}}">
                                                <p class="text-danger text-small" id="imagesError"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 comman_table_design mb-4 New_tabledesign">
                                        <div class="row mx-0">
                                            <div class="col-12 setup_pricing_main border">
                                                <div class="row mx-0 comman_header justify-content-between rounded-top">
                                                    <div class="col">
                                                        <h2>SETUP PRICING</h2> </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="table-responsive border rounded-bottom">
                                                            <table class="table mb-0">
                                                                <thead>
                                                                <tr>
                                                                    <th> VARIANT NAME </th>
                                                                    <th> Diet Plan </th>
                                                                    <th> Option 1 </th>
                                                                    <th> Option 2 </th>
                                                                    <th> No.of Days </th>
                                                                    <th> Calorie </th>
                                                                    <th> Serving Calorie </th>
                                                                    <th> Delivery Price </th>
                                                                    <th> Enter Plan price </th>
                                                                    <th> Compare at price </th>
                                                                    <th> Charge Vat 15% </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <input class="form-control table_input validate" type="text" name="variant_name" id="variant_name"  style="    width: 157px !important;">
                                                                        <p class="text-danger text-small" id="variant_nameError"></p>
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $diet_plans=\App\Models\DietPlanType::get();
                                                                        @endphp

                                                                        <select class="form-select table_input table_select validate" aria-label="Default select example" name="diet_plan" id="diet_plan_id" style="    width: 157px !important;">
                                                                            @if(count($diet_plans) > 0)
                                                                                <option value="">Select Text</option>
                                                                                @foreach($diet_plans as $key=> $group)
                                                                                    <option value="{{$group->name}}" data-id="{{$group->id}}">{{$group->name}}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                        <p class="text-danger text-small" id="diet_planError"></p>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-select table_input table_select option1" aria-label="Default select example" name="option1" id="option1_value" style="    width: 157px !important;">
                                                                            <option value="">Select Text</option>
                                                                            <option value="weekly">Weekly</option>
                                                                            <option value="monthly">Monthly</option>
                                                                        </select>
                                                                        <p class="text-danger text-small" id="option1Error"></p>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-select table_input table_select option2" aria-label="Default select example" name="option2" id="option2_value" style="    width: 157px !important;">
                                                                            <option value="">Select Text</option>
                                                                            <option value="weekend" data-id="With Weekend">With Weekend</option>
                                                                            <option value="withoutweekend" data-id="Without Weekend">Without Weekend</option>
                                                                        </select>
                                                                        <p class="text-danger text-small" id="option2Error"></p>
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control table_input validate serving_calorie" type="text" name="no_of_days" id="no_of_days"  style="    width: 157px !important;">
                                                                        <p class="text-danger text-small" id="no_of_daysError"></p>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-select table_input table_select" aria-label="Default select example" name="calorie" id="calorie_value" style="    width: 157px !important;">
                                                                            <option value="">Select Text</option>
                                                                            <option value="1000">1000 cal</option>
                                                                            <option value="1200">1200 cal</option>
                                                                            <option value="1500">1500 cal</option>
                                                                            <option value="1800">1800 cal</option>
                                                                            <option value="2000">2000 cal</option>
                                                                        </select>
                                                                        <p class="text-danger text-small" id="calorieError"></p>
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control table_input serving_calorie validate" type="text" name="serving_calorie" id="serving_calorie_value"  style="    width: 157px !important;">
                                                                        <p class="text-danger text-small" id="serving_calorieError"></p>
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control table_input " type="text" name="delivery_price" id="delivery_price_value"  style="    width: 157px !important;">
                                                                        <p class="text-danger text-small" id="delivery_priceError"></p>
                                                                    </td>

                                                                    <td>
                                                                        <input class="form-control table_input " type="text" name="plan_price" id="plan_price_value"  style="    width: 157px !important;">
                                                                        <p class="text-danger text-small" id="plan_priceError"></p>
                                                                    </td>

                                                                    <td>
                                                                        <input class="form-control table_input " type="text" name="compare_price" id="compare_price_value"  style="    width: 157px !important;">
                                                                        <p class="text-danger text-small" id="compare_priceError"></p>
                                                                    </td>

                                                                    <td>
                                                                        <select class="form-select table_input table_select" aria-label="Default select example" name="is_charge_vat" id="is_charge_vat"  style="    width: 157px !important;">
                                                                            <option selected>Yes</option>
                                                                            <option value="1">No</option>
                                                                        </select>
                                                                        <p class="text-danger text-small" id="is_charge_vatError"></p>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="row p-4 setup_pricing">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-12 mb-4"> <strong class="head_details">Meal Groups</strong> </div>
                                                                    @php
                                                                        $meal_groups=\App\Models\MealSchedules::get();
                                                                    @endphp
                                                                    @foreach($meal_groups as $key=> $group)
                                                                        <div class="form-group col-12 mb-3 draggable" draggable="true" ondragstart="start()" ondragover="dragover()">
                                                                            <div class="check_radio d-flex">
                                                                                <div class="tb_bg1"></div>
                                                                                <input type="checkbox" name="meal_groups[]" id="v{{$key}}" class="d-none meal_groups" value="{{$group->id}}" data-value="{{$group->name}}" id="meal_groups" @if($key==0) checked @endif>
                                                                                <label for="v{{$key}}">{{$group->name}}</label>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-12 mb-4"> <strong class="head_details">Description</strong> </div>
                                                                    <div class="col-12 setup_Description">
                                                                        <ul class="">
                                                                            <li>
                                                                                <p>Serves from <span id="serving_calorie">-</span> in a day out of the recommended calories depending upon meal selection.</p>
                                                                            </li>
                                                                            <li>
                                                                                <p><span id="DaysCount">-</span> Days in a <span id="option2">-</span></p>
                                                                            </li>
                                                                            <li>
                                                                                <p>Plan consists of <span id="mealGroups">-</span>.</p>
                                                                            </li>
                                                                        </ul>
                                                                        <div class="form-group mb-0">
                                                                            <input class="form-control" type="text" placeholder="ENTER YOUR CUSTOM TEXT" name="description" id="description_value">
                                                                            <p class="text-danger text-small" id="descriptionError"></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 text-center mb-3 setup_pricingbtns">
                                                        <button class="comman_btn me-3" id="AddVariants" type="button">ADD</button>
                                                        <button class="comman_btn bg-red" type="reset">CLEAR</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="DefaultSelection">

                                        @php
                                        //$dates=[];
                                       // $meal_groups=[];

                                       // foreach ($edit_mealPlan->meal_plan_variant_default as $key=> $value){

                                            //if(!in_array($value->date, $dates)){
                                                //$dates[$key]=$value->date;
                                            //}
                                            //$dates[]=$value->date;
                                            //$meal_groups[]=$value->meal_schedule_id;
                                        //}
                                        //$dates = array_unique($dates);
                                        
                                        $dates = [];
                                         $date = now();             
                                            //        $request->no_of_days
                                           for ($i = 0; $i < 28; $i++) {
                                              $dates[] = $date->addDay()->format('y-m-d');
                                            }

                                        @endphp
                                        <div class="col-12 comman_table_design mb-4 New_tabledesign">
                                            <div class="row mx-0">
                                                <div class="col-12 default_meal_selection border">
                                                    <div class="row comman_header mx-0 justify-content-between rounded-top">
                                                        <div class="col">
                                                            <h2>Default Meal Selection</h2>
                                                        </div>
                                                    </div>
                                                    <div class="row mx-0">
                                                        <div class="col-12 px-0 text-center">
                                                            <nav>
                                                                <div class="mealoutter_tabs nav nav-tabs border-0 justify-content-center shadow d-inline-flex" id="nav-tab" role="tablist">

                                                                    @foreach($dates as $key=> $date)
                                                                        <button class="nav-link @if($key==0)active @endif" id="nav-home-tab{{$key}}" data-bs-toggle="tab" data-bs-target="#nav-home{{$key}}" type="button" role="tab" aria-controls="nav-home" aria-selected="true" data-value="{{$date}}">
                                                                            {{\Carbon\Carbon::parse($date)->format('d-F')}}</button>
                                                                        <input type="hidden" name="dates[]" value="{{$date}}">
                                                                    @endforeach
                                                                </div>
                                                            </nav>
                                                            <div class="tab-content mt-4" id="nav-tabContent">
                                                                @foreach($dates as $key=> $date)
                                                                    <div class="tab-pane fade @if($key==0)active show @endif" id="nav-home{{$key}}" role="tabpanel" aria-labelledby="nav-home-tab">
                                                                        <div class="row meal_innerpart justify-content-center">
                                                                            <div class="col-12 text-center">
                                                                                <nav>
                                                                                    <div class="nav nav-tabs justify-content-center mid_tabsdesign border-0" id="nav-tab" role="tablist">
                                                                                        @foreach(\App\Models\DietPlanType::get() as $key1=>$value)
                                                                                            <button class="nav-link @if($key1 == 0)active @endif shadow border-0" id="vj1-tab" data-bs-toggle="tab" data-bs-target="#vj1{{$key}}{{$key1}}" type="button" role="tab" aria-controls="vj1" aria-selected="false">{{$value->name}}</button>
                                                                                        @endforeach
                                                                                    </div>
                                                                                </nav>
                                                                                <div class="tab-content mt-4 pt-2" id="nav-tabContent">
                                                                                    @foreach(\App\Models\DietPlanType::get() as $key2=>$value)
                                                                                        <div class="tab-pane fade @if($key2 == 0)active show @endif" id="vj1{{$key}}{{$key2}}" role="tabpanel" aria-labelledby="vj1-tab">
                                                                                            <div class="row">
                                                                                                <div class="col-12">
                                                                                                    <ul class="nav nav-tabs mealinner_tabs d-inline-flex justify-content-center rounded-pill shadow overflow-hidden" id="myTab" role="tablist">
                                                                                                        @foreach($edit_mealPlan->meal_schedule as $key1=> $group)

                                                                                                            @php
                                                                                                                $schedule=\App\Models\MealSchedules::where('id',$group->meal_schedule_id)->first();
                                                                                                            @endphp
                                                                                                            <li class="nav-item" role="presentation">
                                                                                                                <button class="nav-link @if($key1==0)active @endif" id="home-tab" data-bs-toggle="tab" data-bs-target="#home{{$key}}{{$key2}}{{$schedule->id}}" type="button" role="tab" aria-controls="home" aria-selected="true" data-value="{{$schedule->id}}">
                                                                                                                    {{$schedule->name}}</button>
                                                                                                            </li>
                                                                                                        @endforeach
                                                                                                    </ul>
                                                                                                    <div class="tab-content mt-4" id="myTabContent">
                                                                                                        @foreach($edit_mealPlan->meal_schedule as $key3=> $group)
                                                                                                            @php
                                                                                                                $day = \Carbon\Carbon::parse($date)->format('l');
                                                                                                                     $schedule=\App\Models\MealSchedules::where('id',$group->meal_schedule_id)->first();

                                                                                                                      $meals_id=\App\Models\MealGroupSchedule::where('meal_schedule_id',$schedule->id)->pluck('meal_id')->toArray();

                                                                                                                      $meals=\App\Models\MealDietPlan::whereIn('meal_id',$meals_id)->where('diet_plan_type_id',$value->id)->pluck('meal_id')->toArray();
                                                                                                                        $meals=\App\Models\MealWeekDay::whereIn('meal_id',$meals)->where('week_days_id',strtolower($day))->orWhere('week_days_id','=',$date)->get();

                                                                                                            @endphp
                                                                                                            <div class="tab-pane fade @if($key3==0)active show @endif" id="home{{$key}}{{$key2}}{{$schedule->id}}" role="tabpanel" aria-labelledby="home-tab{{$key}}{{$key2}}{{$schedule->id}}">
                                                                                                                <div class="row">
                                                                                                                    <div class="col-12 comman_table_design New_tabledesign">
                                                                                                                        <div class="table-responsive">
                                                                                                                            <table class="table mb-0">
                                                                                                                                <thead>
                                                                                                                                <tr>
                                                                                                                                    <th>Item Name</th>
                                                                                                                                    <th>Meal Group</th>
                                                                                                                                    <th>Default Selection</th>
                                                                                                                                </tr>
                                                                                                                                </thead>
                                                                                                                                <tbody>
                                                                                                                                @foreach($meals as $key3=> $meal)
                                                                                                                                    @if(isset($meal->meal_items->name))
                                                                                                                                        @php

                                                                                                                                            $is_default=\App\Models\SubscriptionMealVariantDefaultMeal::where('meal_plan_id',$group->plan_id)->where('meal_schedule_id',$schedule->id)->where('item_id',$meal->meal_id)->where('date',$date)->where('is_default',1)->first();

                                                                                                                                        @endphp
                                                                                                                                        <tr>
                                                                                                                                            <td>{{$meal->meal_items->name??'-'}}</td>
                                                                                                                                            <td>{{$schedule->name}}</td>
                                                                                                                                            <td>
                                                                                                                                                <div class="check_radio td_check_radio">
                                                                                                                                                    <input type="checkbox" name="selectionvariant[{{$date}}][{{$schedule->name}}][{{$meal->meal_id}}]" id="t{{$key}}{{$key2}}{{$key3}}{{$schedule->id}}" class="d-none defaultSelection" data-id="1" @if(isset($is_default) && $is_default->is_default == 1) checked @endif>
                                                                                                                                                    <label for="t{{$key}}{{$key2}}{{$key3}}{{$schedule->id}}"></label>
                                                                                                                                                </div>
                                                                                                                                            </td>
                                                                                                                                        </tr>
                                                                                                                                    @endif
                                                                                                                                @endforeach
                                                                                                                                </tbody>
                                                                                                                            </table>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        @endforeach
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach

                                                                                </div>
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
                                    @if(count($edit_mealPlan->mealplan_variant) > 0)

                                        <div class="col-12 comman_table_design mb-4 New_tabledesign" id="variantsShow">
                                            <div class="row mx-0 comman_header justify-content-between rounded-top">
                                                <div class="col">
                                                    <h2>VARIANTS</h2>
                                                </div>
                                            </div>
                                            <div class="table-responsive border rounded-bottom variants_table">
                                                <table class="table mb-0">
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
                                                        <th>VARIANT Name</th>
                                                        <th>Diet plan</th>
                                                        <th>Meal Group</th>
                                                        <th>Option 1</th>
                                                        <th>Option 2</th>
                                                        <th>No.of Days</th>
                                                        <th>Calorie</th>
                                                        <th>Serving Calorie</th>
                                                        <th>Delivery Price</th>
                                                        <th>Plan Enter price</th>
                                                        <th>Compare price</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="tbody">
                                                     @foreach($edit_mealPlan->mealplan_variant as $value1)
                                                         <tr>
                                                         <td>

                                                             <div class="check_radio td_check_radio">
                                                                 <input type="checkbox" checked name="table2" id="table2" class="d-none">
                                                                 <label for="table2"></label>
                                                             </div>

                                                         </td>
                                                         <td>{{$value1->variant_name}}</td>
                                                         <td>{{$value1->dietPlan->name}}</td>
                                                         <td>{{$value1->meal_group_name}}</td>
                                                         <td>{{$value1->option1}}</td>
                                                         <td>{{$value1->option2}}</td>
                                                         <td>{{$value1->no_days}}</td>
                                                         <td>{{$value1->calorie}}</td>
                                                         <td>{{$value1->serving_calorie}}</td>
                                                         <td>{{$value1->delivery_price}}</td>
                                                         <td>{{$value1->plan_price}}</td>
                                                         <td>{{$value1->compare_price}}</td>
                                                         <td>{{$value1->custom_text}}</td>
                                                             <td>
                                                                 <a class="comman_btn table_viewbtn showEdit" data-id="{{$value1->id}}" data-bs-toggle="modal" data-bs-target="#staticBackdrop" href="javscript:;" >Edit</a>
                                                                 <a class="comman_btn table_viewbtn delete_btn" onclick="deleteData1(this,'{{$value1->id}}');" href="javscript:;">Delete</a>
                                                             </td>
                                                         </tr>
                                                     @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @else

                                        <div class="col-12 comman_table_design mb-4 New_tabledesign" id="variantsShow" style="display: none;">
                                            <div class="row mx-0 comman_header justify-content-between rounded-top">
                                                <div class="col">
                                                    <h2>VARIANTS</h2>
                                                </div>
                                            </div>
                                            <div class="table-responsive border rounded-bottom variants_table">
                                                <table class="table mb-0">
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
                                                        <th>VARIANT Name</th>
                                                        <th>Diet plan</th>
                                                        <th>Meal Group</th>
                                                        <th>Option 1</th>
                                                        <th>Option 2</th>
                                                        <th>No.of Days</th>
                                                        <th>Calorie</th>
                                                        <th>Serving Calorie</th>
                                                        <th>Delivery Price</th>
                                                        <th>Plan Enter price</th>
                                                        <th>Compare price</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="tbody">


                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="form-group col-6 text-end">
                                        <button type="button" class="comman_btn" onclick="validate(this);">Save</button>
                                    </div>
                                    <div class="form-group col-6 text-start">
                                        <a class="comman_btn bg-red" href="{{url('admin/meal-plan-management')}}" >Close</a>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>

        $(document).ready(function(){

            $('.option1').on('change',function(){
                var value=$(this).val();
                if(value=="weekly"){
                    var option2=$(this).find(":selected").data('id');
                    if(option2=="With Weekend"){
                        $("#days_value").text(7);
                        $("#no_of_days").val(7);
                        $("#DaysCount").text(7);
                    }else if(option2=="Without Weekend"){
                        $("#days_value").text(5);
                        $("#no_of_days").val(5);
                        $("#DaysCount").text(5);
                    }
                    $('#option2').text(value+' '+option2)
                }else if(value=="monthly"){
                    var option2=$(this).find(":selected").data('id');
                    if(option2=="With Weekend"){
                        $("#days_value").text(28);
                        $("#no_of_days").val(28);
                        $("#DaysCount").text(28);
                    }else if(option2=="Without Weekend"){
                        $("#days_value").text(20);
                        $("#no_of_days").val(20);
                        $("#DaysCount").text(20);
                    }
                    $('#option2').text(value+' '+option2)
                }
            })

            $('.option2').on('change',function(){
                var value=$(this).find(":selected").data('id');
                if(value=="With Weekend"){
                    var option1=$('.option1').val();
                    if(option1=="weekly"){
                        $("#days_value").text(7);
                        $("#no_of_days").val(7);
                        $("#DaysCount").text(7);
                    }else if(option1=="monthly"){
                        $("#days_value").text(28);
                        $("#no_of_days").val(28);
                        $("#DaysCount").text(28);
                    }
                    $('#option2').text(option1+' '+value)
                }else if(value=="Without Weekend"){
                    var option1=$('.option1').val();
                    if(option1=="weekly"){
                        $("#days_value").text(5);
                        $("#no_of_days").val(5);
                        $("#DaysCount").text(5);
                    }else if(option1=="monthly"){
                        $("#days_value").text(20);
                        $("#no_of_days").val(20);
                        $("#DaysCount").text(20);
                    }
                    $('#option2').text(option1+' '+value)
                }
            })
            $(document).on('blur','.serving_calorie',function(){
                var value=$(this).val();
                $('#serving_calorie').text(value)
            })
            $(document).on('change','.meal_groups',function(){
                var Envie = '';
                var total = $('.meal_groups').length;
                $('.meal_groups').each(function (index) {
                    if(this.checked) {
                        if (index === total - 1) {
                            Envie += $(this).data('value');
                        }else{
                            Envie += $(this).data('value') + ',';
                        }
                    }
                })
                $("#mealGroups").text(Envie);
            })

            $('#AddVariants').on('click',function(){

                $(".text-danger").html('');
                var flag = true;
                var formData = $("#AddVariantsForms").find(".validate:input").not(':input[type=button]');
                $(formData).each(function () {
                    var element = $(this);
                    var val = element.val();
                    var name = element.attr("name");
                    if (val == "" || val == "0" || val == null) {

                        $("#" + name + "Error").html("This field is required");
                        flag = false;


                    } else {

                    }
                });
                if(flag){
                    var variant_name =$('#variant_name').val();
                    var diet_plan_id =$('#diet_plan_id').find('option:selected').val();
                    var diet_plan =$('#diet_plan_id').find('option:selected').attr('data-id');
                    var option1_value =$('#option1_value').val();
                    var option2_value =$('#option2_value').val();
                    var no_of_days =$('#no_of_days').val();
                    var calorie_value =$('#calorie_value').find('option:selected').val();
                    var serving_calorie_value =$('#serving_calorie_value').val();
                    var delivery_price_value =$('#delivery_price_value').val();
                    var plan_price_value =$('#plan_price_value').val();
                    var compare_price_value =$('#compare_price_value').val();
                    var is_charge_vat =$('#is_charge_vat').val();
                    var meal_groups =$('#meal_groups').val();
                    var description_value =$('#description_value').val();
                    var meal_groups_hidden=[];
                    var arr = $("input:checkbox[name*=meal_groups]:checked").each(function(){
                        meal_groups_hidden.push($(this).val());
                    });

                    var meal_groups_hidden_name=[];
                    var arr1 = $("input:checkbox[name*=meal_groups]:checked").each(function(){
                        meal_groups_hidden_name.push($(this).data('value'));
                    });
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url:'{{ url("admin/add_variants") }}',
                        method:'post',
                        data: {
                            variant_name:variant_name,
                            diet_plan_id:diet_plan_id,
                            option1_value:option1_value,
                            no_of_days:no_of_days,
                            option2_value:option2_value,
                            calorie_value:calorie_value,
                            serving_calorie_value:serving_calorie_value,
                            delivery_price_value:delivery_price_value,
                            compare_price_value:compare_price_value,
                            is_charge_vat:is_charge_vat,
                            plan_price_value:plan_price_value,
                            meal_groups_hidden:meal_groups_hidden,
                            description_value:description_value,
                            meal_groups_hidden_name:meal_groups_hidden_name
                        },
                        dataType:'json',
                        type: "post",
                        cache: false,
                        success:function(data)
                        {
                          //  $('#DefaultSelection').html(data.html);
                           $('#variantsShow').css('display','block');
                           $('#tbody').append('<tr><td><div class="check_radio td_check_radio"><input type="checkbox" checked name="table2" id="table2" class="d-none"><label for="table2"></label></div></td><td>'+variant_name+'</td><td>'+diet_plan_id+'</td><td>'+meal_groups_hidden_name+'</td><td>'+ option1_value+'</td><td>'+option2_value+'</td><td>'+no_of_days+'</td><td>'+calorie_value+'</td><td>'+serving_calorie_value+'</td><td>'+delivery_price_value+'</td><td>'+plan_price_value+'</td><td>'+compare_price_value+'</td><td>'+description_value+'</td><input type="hidden" name="variant_name_hidden[]" value="'+variant_name+'"><input type="hidden" name="diet_plan_hidden[]" value="'+diet_plan+'"><input type="hidden" name="option1_hidden[]" value="'+option1_value+'"><input type="hidden" name="option2_hidden[]" value="'+option2_value+'"><input type="hidden" name="no_of_days_hidden[]" value="'+no_of_days+'"><input type="hidden" name="serving_calorie_hidden[]" value="'+serving_calorie_value+'"><input type="hidden" name="meal_groups_hidden_name[]" value="'+meal_groups_hidden_name+'"><input type="hidden" name="calorie_hidden[]" value="'+calorie_value+'"><input type="hidden" name="delivery_price_hidden[]" value="'+delivery_price_value+'"><input type="hidden" name="plan_price_hidden[]" value="'+plan_price_value+'"><input type="hidden" name="compare_price_hidden[]" value="'+compare_price_value+'"><input type="hidden" name="is_charge_vat_hidden[]" value="'+is_charge_vat+'"><input type="hidden" name="description_value_hidden[]" value="'+description_value+'"></tr>');
                           alert('Plan Added Successfully');
                        }
                    })
                }


            });
        });

    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var certificateDropify = $('.dropify').dropify();
         certificateDropify.on('dropify.afterClear', function (event, element) {
            $('#images_hidden').val("");
        });
    </script>


    <div class="modal fade comman_modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Meal Plan Variant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="smallBody">

                </div>
            </div>
        </div>
    </div>
<script>
    $(document).on('click','.showEdit',function(){

        var tour_id= $(this).data('id');

        $.ajax({
            url:'{{ url("admin/mealplanvariants/edit") }}',
            method:'post',
            data: {
                tour_id:tour_id,
            },
            dataType:'json',
            type: "post",
            cache: false,
            success:function(data)
            {
                $('#staticBackdrop').modal("show");
                $('#smallBody').html(data.html).show();
                $( '.multiple-select-custom-field' ).select2( {
                    theme: "bootstrap-5",
                    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                    placeholder: $( this ).data( 'placeholder' ),
                    closeOnSelect: false,
                    tags: true
                } );
            }
        })


    });
</script>
@endsection
<script>

    function validate(obj) {
        $(".text-danger").html('');
        var flag = true;
        var formData = $("#AddVariantsForms").find(".validate:input").not(':input[type=button]');
        $(formData).each(function () {
            var element = $(this);
            var val = element.val();

            var name = element.attr("name");
            console.log(name);
            if(name == 'variant_name' || name=='diet_plan' || name=='no_of_days' || name=='serving_calorie'){

            }else{
                if (val == "" || val == "0" || val == null) {
                    $("#" + name + "Error").html("This field is required");
                    flag = false;


                } else {

                }
            }

        });

        if (flag) {
            $("#AddVariantsForms").submit();
        } else {
            return false;
        }


    }
</script>
<script>
    function deleteData1(obj, id){
        //var csrf_token=$('meta[name="csrf_token"]').attr('content');
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this record!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url : "<?= url('admin/mealplanvariants-delete') ?>",
                        type : "POST",
                        data : 'id=' + id + '&_token=<?= csrf_token() ?>',
                        success: function(data){
                            swal({
                                title: "Success!",
                                text : "Meal Plan Variant has been deleted \n Click OK to refresh the page",
                                icon : "success",
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error : function(){
                            swal({
                                title: 'Opps...',
                                text : data.message,
                                type : 'error',
                                timer : '1500'
                            })
                        }
                    })
                } else {
                    swal("Your  file is safe!");
                }
            });
    }

</script>
