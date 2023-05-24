@extends('admin.layout.master')
@section('content')
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
               <div class="row meal-add-items justify-content-center">
                  <div class="col-12">
                     <div class="row mx-0">
                        <div class="col-12 design_outter_comman shadow mb-4">
                           <div class="row comman_header justify-content-between">
                              <div class="col">
                                 <h2>Add Item</h2>
                              </div>
                           </div>
                           <form class="form-design py-4 px-4 row align-items-start justify-content-start" method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/meal/meal_update',[base64_encode($meal->id)])}}">
                           {{ csrf_field() }} 
                              <div class="col-md-7 px-0">
                                 <div class="row">
                                    <div class="form-group col-6">
                                       <label for=""> Title (English) :</label>
                                       <input type="text" class="form-control validate" value="{{!empty($meal) ? $meal->name : '--'}}" name="name" id="name"   maxlength ="20">
                                       <p class="text-danger text-small" id="nameError"></p>
                                    </div>
                                    <div class="form-group col-6">
                                       <label for=""> Side Dish :</label>
                                       <input type="text" class="form-control validate" value="{{!empty($meal) ? $meal->side_dish : '--'}}" name="side_dish" id="name"  maxlength ="20">
                                       <p class="text-danger text-small" id="side_dishError"></p>
                                    </div>
                                    <div class="form-group col-6">
                                       <label for=""> Title (Arabic) :</label>
                                       <input type="text" class="form-control validate" value="{{!empty($meal) ? $meal->name_ar : '--'}}" name="name_ar" id="name"  maxlength ="20">
                                       <p class="text-danger text-small" id="name_arError"></p>
                                    </div>
                                    <div class="form-group col-6">
                                       <label for=""> Side Dish :</label>
                                       <input type="text" class="form-control validate" value="{{!empty($meal) ? $meal->side_dish_ar : '--'}}" name="side_dish_ar" id="name"   maxlength ="20">
                                       <p class="text-danger text-small" id="side_dish_arError"></p>
                                    </div>
                                    <div class="form-group col-12 textarea_height">
                                       <label for="">Method of Cooking (English) :</label>
                                       <textarea class="form-control validate" name="description" maxlength ="100" >{{!empty($meal) ? $meal->description : '--'}}</textarea>
                                       <p class="text-danger text-small" id="descriptionError"></p>
                                    </div>
                                    <div class="form-group col-12 textarea_height">
                                       <label for="">Method of Cooking (Arabic) :</label>
                                       <textarea class="form-control validate" name="description_ar" maxlength ="100" >{{!empty($meal) ? $meal->description_ar : '--'}}</textarea>
                                       <p class="text-danger text-small" id="description_arError"></p>
                                    </div>
                                    <div class="form-group col-12 uploadimg_box"> <span>Media :</span>
                                        <input type="file" id="uploadimg" class=" dropify" name="image" data-default-file="{{$meal->image}}">
{{--                                       <label for="uploadimg">--}}
{{--                                        <div class="uploadimg_inner"> <i class="fas fa-upload me-2"></i> <span>Upload File</span> </div>--}}
{{--                                                </label>--}}
                                                <!-- <p class="text-danger text-small" id="imageError"></p> -->
                                          </div>
                                    <!-- <div class="form-group col-12 uploadimg_box">
                                       <span>Media :</span>
                                       <input type="file" id="uploadimg" name="image" class="d-none validate">
                                       
                                       <label for="uploadimg">
                                          <div class="uploadimg_inner">
                                             <i class="fas fa-upload me-2"></i>
                                             <span>Upload File</span>
                                          </div>
                                       </label>
                                       <img id="blah" src="#" alt="your image" />
                                       <p class="text-danger text-small" id="imageError"></p>
                                    </div>  -->
                                 
                                 </div>
                              </div>
                              <div class="col-md-5 ps-4 pe-0">
                                 <div class="row additems_aside">
                                    <div class="form-group col-12">
                                       <h2 class="add_items_headign">
                                          Item Status :
                                       </h2>
                                       <select class="form-select form-control" aria-label="Default select example" name="status">
                                        @if($meal->status == 'active')
                                          <option selected value="active">Active</option>
                                          <option  value="inactive">Draft</option>
                                          @else
                                          <option selected value="inactive">Draft</option> 
                                          <option  value="active">Active</option>
                                          @endif
                                       </select>
                                    </div> 
                                    <div class="col-12">
                                       <h2 class="add_items_headign">
                                          Item Organization :
                                       </h2>
                                       <div class="row">
                                          <div class="form-group col-12">
                                             <label for="">Meal Group :</label>
                                            @php 
                                           
                                            $meal_schedule=\App\Models\MealSchedules::select('id','name')->orderBy('id','desc')->get();
                                         
                                            @endphp
                                             <select class="w-100 multiple-select-custom-field required" data-placeholder="Select" multiple name="meal_schedule_id[]"> 
                                             @foreach($meal_schedule as $meal_schedules)
                                                <option value="{{$meal_schedules->id}}" @foreach($meal_group_schedule as $meal_group_schedules) @if ($meal_group_schedules->name == $meal_schedules->name ) selected @endif   @endforeach>{{$meal_schedules->name}}</option>
                                                @endforeach
                                             </select>
                                             <p class="text-danger text-small" id='errorShow' ></p>
                                          </div>
                                          <div class="form-group col-12">
                                             <label for="">Tags : Date format: dd-mm-YY</label>
                                             @php 
                                           $meal_id=[];
                                           $meal_day=\App\Models\MealWeekDay::select('id','meal_id','week_days_id')->get();
                                           foreach($meal_day as $meal_days) {

                                                      array_push($meal_id,$meal_days->id);
                                         
                                                      $cate= $meal_id;
                                              }
                                           @endphp
                                           
                                             <select class="w-100 multiple-select-custom-field" data-placeholder="Select" multiple name="week_days_id[]">
                                             @foreach($mealWeekDay as $k=>$mealWeekDays)
  
                                                <option value="{{$mealWeekDays->week_days_id}}" {{in_array($mealWeekDays->id,$cate)?"selected" :"" }}>{{ucwords($mealWeekDays->week_days_id)}} </option>
                                                @endforeach
                                             </select>
                                          </div>
                                          <div class="form-group col-12">
                                             <label for="">Plan Type :</label>
                                             @php 
                                           
                                           $plan_type=\App\Models\DietPlanType::select('id','name')->get();
                                        
                                           @endphp
                                             <select class="w-100 selct_comman" data-placeholder="Select" multiple name="diet_plan_type_id[]"> 
                                            @foreach($plan_type as $plan_types)
                                                <option value="{{$plan_types->id}}" @foreach($meal_diet_plan as $meal_diet_plans) @if ($meal_diet_plans->name == $plan_types->name ) selected @endif   @endforeach >{{$plan_types->name}}</option>
                                             @endforeach
                                             </select>
                                          </div>
                                          <div class="form-group col-12">
                                             <label for="">Department :</label>
                                             @php 
                                           
                                           $department=\App\Models\MealAllocationDepartment::select('id','name')->get();
                                        
                                           @endphp
                                             <select class="w-100 multiple-select-custom-field" data-placeholder="Select" multiple name="department_id[]"> 
                                             @foreach($department as $departments)
                                                <option value="{{$departments->id}}"  @foreach($mealDepartment as $mealDepartments) @if ($mealDepartments->department_id == $departments->id ) selected @endif   @endforeach>{{$departments->name}}</option>
                                                @endforeach
                                             </select>
                                          </div>
                                          <div class="form-group col-12">
                                             <label for="">Food type :</label>
                                             <div class="row">
                                                <div class="col-4 pe-0">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none" type="radio" id="v1" value="veg" name="check11"  {{ ($meal->food_type=="veg")? "checked" : "" }}>
                                                      <label for="v1">Veg <div class="circle_cmn"></div> </label>
                                                   </div>
                                                </div>
                                                <div class="col-4 pe-0">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none" type="radio" id="v2" value="non_veg" name="check11" {{ ($meal->food_type=="non_veg")? "checked" : "" }}>
                                                      <label for="v2">Nonveg <div class="circle_cmn bg-red"></div></label>
                                                   </div>
                                                </div>
                                                <div class="col-4 pe-0">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none" type="radio" id="v3" value="none" name="check11" {{ ($meal->food_type=="none")? "checked" : "" }}>
                                                      <label for="v3">None</label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div> 
                              <div class="col-7 Portioning_tables border mb-4">
                                 <div class="row mx-0 comman_header justify-content-between">
                                    <div class="col">
                                       <h2>Recipe</h2>
                                    </div>
                                    <div class="col-auto">
                                    <a class="comman_btn yellow-btn add_row_btn addButton " href="javscript:;" onclick="addButton();" value="Insert row">
                                         Add Row
                                       </a>
                                    </div>
                                 </div>
                                 <div class="row" >
                                    <div class="col-12 comman_table_design New_tabledesign">
                                       <div class="table-responsive">
                                          <table class="table mb-0 cloning-table" id="cloningtable">
                                             <thead>
                                                <tr>
                                                   <th>Ingredients</th>
                                                   <th>Qty</th>
                                                   <th>Unit</th>
                                                </tr>
                                             </thead>
                                             <tbody id="AddContainer">
                                               
                                             <tr >
                                                <td class="searchDrop">
                                                    
                                                    <!-- Dropdown --> 
                                                    <select id='selUser_0'class="form-select table_input table_select adjust_lenth selUser"  onchange="getSubcategory(this,0);"  name="items[0][ingredient]" style="width: 159px;">
                                                       <option selected="" disabled>Select User</option> 
                                                       @foreach($ingredients as $ingredient)
                                                        <option value='{{$ingredient->id}}'>{{$ingredient->name}}</option> 
                                                        @endforeach
                                                     </select>
                                                    
                                                   </td>
                                                
                                                   <td>
                                                      <input class="form-control table_input  adjust_lenth" type="number" id="fname" name="items[0][qty]" value="">
                                                   </td>
                                                   <td>
                                                   <input class="form-control table_input  adjust_lenth" type="text" id="upload_videos_0"  value="">
                                                   <input class="form-control table_input  adjust_lenth" type="hidden" id="upload_videos_id_0" name="items[0][unit]" value="">
                                                   </td>
                                                </tr>
                                           
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-5 pe-0">
                                 <div class="row ms-3 me-0">
                                    <div class="col-12 instructions_table px-0 border">
                                       <div class="row comman_header justify-content-between">
                                          <div class="col logo_design">
                                             <img src="{{asset('assets/img/logo.png')}}" alt="Logo">
                                          </div> 
                                          <!-- <div class="col-auto">
                                             <a class="comman_btn yellow-btn add_row_btn" href="javscript:;">
                                               Edit
                                             </a>
                                          </div> -->
                                       </div>
                                       <div class="row p-3 instructions_box position-relative border-bottom">
                                          <span class="head_small mb-1">Instructions:</span>
                                             <textarea  id="note" name="meal_instruction">{{$mealLabel->instruction}}</textarea>
                                       </div>
                                       <div class="row p-3 instructions_box position-relative">
                                          <span class="head_small mb-1">Ingredients:</span>
                                          <div class="d-flex flex-wrap">
                                             <textarea id="note" class="me-2" name="meal_ingredients">{{$mealLabel->ingredients}}</textarea>
                                           
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-7 p-0">
                                 <div class="form-group row align-items-center mt-2 recipe_yields_box">
                                    <div class="col">
                                       <label class="mb-0" for="">100 % Recipe yields 1 serving of calorie.</label>
                                    </div>
                                    <div class="col-3">
                                       <input class="form-control table_input" type="text" placeholder="--" name="recipe_yields" value="{{!empty($meal)? $meal->recipe_yields : '--'}}">
                                    </div>
                                 </div>
                              </div> 
                              <div class="col-12 Portioning_tables border mt-4">
                                 <div class="row mx-0 comman_header justify-content-between">
                                    <div class="col">
                                       <h2>Portioning & Macro Nutrients</h2>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-12 comman_table_design New_tabledesign">
                                       <div class="table-responsive">
                                          <table class="table mb-0">
                                             <thead>
                                                <tr>
                                                   <th>User Calorie</th>
                                                   <th>Size/Pcs</th>
                                                   <th>Recipe Yields</th>
                                                   <th>Meal Calorie</th>
                                                   <th>Protein</th>
                                                   <th>Carbs.</th>
                                                   <th>Fat</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <tr >
                                                   <td>
                                                      <strong>1000 cal</strong>
                                                   </td>
                                                   <td>
                                                   <input class="form-control table_input" type="hidden" value="1000" name="user_calorie1">
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="size1" value="{{$meal_macro_nutrients[0]->size_pcs}}">
                                                      <p class="text-danger text-small" id="size1Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="recipe_yield1" value="{{$meal_macro_nutrients[0]->recipe_yields}}">
                                                      <p class="text-danger text-small" id="recipe_yield1Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="meal_calorie1" value="{{$meal_macro_nutrients[0]->meal_calorie}}">
                                                      <p class="text-danger text-small" id="meal_calorie1Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="protein1" value="{{$meal_macro_nutrients[0]->protein}}">
                                                      <p class="text-danger text-small" id="protein1Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="carb1" value="{{$meal_macro_nutrients[0]->carbs}}">
                                                      <p class="text-danger text-small" id="carb1Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="fat1" value="{{$meal_macro_nutrients[0]->fat}}">
                                                      <p class="text-danger text-small" id="fat1Error"></p>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <strong>1200 cal</strong> 
                                                   </td>
                                                   <td>
                                                   <input class="form-control table_input" type="hidden" value="1200" name="user_calorie2">
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="size2" value="{{$meal_macro_nutrients[1]->size_pcs}}"> 
                                                      <p class="text-danger text-small" id="size2Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="recipe_yield2" value="{{$meal_macro_nutrients[1]->recipe_yields}}">
                                                      <p class="text-danger text-small" id="recipe_yield2Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="meal_calorie2" value="{{$meal_macro_nutrients[1]->meal_calorie}}">
                                                      <p class="text-danger text-small" id="meal_calorie2Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--"  name="protein2" value="{{$meal_macro_nutrients[1]->protein}}">
                                                      <p class="text-danger text-small" id="protein2Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="carb2" value="{{$meal_macro_nutrients[1]->carbs}}">
                                                      <p class="text-danger text-small" id="carb2Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="fat2" value="{{$meal_macro_nutrients[1]->fat}}">
                                                      <p class="text-danger text-small" id="fat2Error"></p>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <strong>1500 cal</strong> 
                                                   </td>
                                                   <td>
                                                   <input class="form-control table_input" type="hidden" value="1500" name="user_calorie3">
                                                      <input class="form-control table_input validatee" type="text" placeholder="S" name="size3" value="{{$meal_macro_nutrients[2]->size_pcs}}">
                                                      <p class="text-danger text-small" id="size3Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="50%" name="recipe_yield3" value="{{$meal_macro_nutrients[2]->recipe_yields}}">
                                                      <p class="text-danger text-small" id="recipe_yield3Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="150" name="meal_calorie3" value="{{$meal_macro_nutrients[2]->meal_calorie}}">
                                                      <p class="text-danger text-small" id="meal_calorie3Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="28" name="protein3" value="{{$meal_macro_nutrients[2]->protein}}"> 
                                                      <p class="text-danger text-small" id="protein3Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="6" name="carb3" value="{{$meal_macro_nutrients[2]->carbs}}">
                                                      <p class="text-danger text-small" id="carb3Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="5" name="fat3" value="{{$meal_macro_nutrients[2]->fat}}">
                                                      <p class="text-danger text-small" id="fat3Error"></p>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <strong>1800 cal</strong> 
                                                   </td>
                                                   <td>
                                                   <input class="form-control table_input" type="hidden" value="1800" name="user_calorie4">
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="size4"  value="{{$meal_macro_nutrients[3]->size_pcs}}">
                                                      <p class="text-danger text-small" id="size4Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="recipe_yield4" value="{{$meal_macro_nutrients[3]->recipe_yields}}">
                                                      <p class="text-danger text-small" id="recipe_yield4Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="meal_calorie4" value="{{$meal_macro_nutrients[3]->meal_calorie}}"> 
                                                      <p class="text-danger text-small" id="meal_calorie4Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="protein4" value="{{$meal_macro_nutrients[3]->protein}}">
                                                      <p class="text-danger text-small" id="protein4Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="carb4" value="{{$meal_macro_nutrients[3]->carbs}}">
                                                      <p class="text-danger text-small" id="carb4Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="fat4" value="{{$meal_macro_nutrients[3]->fat}}">
                                                      <p class="text-danger text-small" id="fat4Error"></p>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <strong>2000 cal</strong> 
                                                   </td>
                                                   <td>
                                                   <input class="form-control table_input" type="hidden" value="2000" name="user_calorie5">
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="size5" value="{{$meal_macro_nutrients[4]->size_pcs}}">
                                                      <p class="text-danger text-small" id="size5Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="recipe_yield5" value="{{$meal_macro_nutrients[4]->recipe_yields}}">
                                                      <p class="text-danger text-small" id="recipe_yield5Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="meal_calorie5" value="{{$meal_macro_nutrients[4]->meal_calorie}}">
                                                      <p class="text-danger text-small" id="meal_calorie5Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="protein5" value="{{$meal_macro_nutrients[4]->protein}}">
                                                      <p class="text-danger text-small" id="protein5Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="carb5" value="{{$meal_macro_nutrients[4]->carbs}}">
                                                      <p class="text-danger text-small" id="carb5Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="fat5" value="{{$meal_macro_nutrients[4]->fat}}">
                                                      <p class="text-danger text-small" id="fat5Error"></p>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group col-6 text-end" style="margin-top: 23px;">
								 <button type="button" class="comman_btn" onclick="validate(this);">Save</button>
							   </div>
								<!-- <div class="form-group col-6 text-start">
									<button class="comman_btn bg-red">Close</button>
								</div> -->
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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.dropify').dropify();
    </script>
    <script>
   $("#cloningtable").on('click', '.remCF', function(){
     $(this).parent().parent().remove();
   });
 </script>
  <script>
      $(document).ready(function(){
 
 // Initialize select2
 $(".selUser").select2();

 // Read selected option
 $('#but_read').click(function(){
     var username = $('#selUser option:selected').text();
     var userid = $('#selUser').val();

     $('#result').html("id : " + userid + ", name : " + username);

 });
})
    </script>
     <script>
//    $(document).ready(function(){
//    var Data_to_clone = $('.cloning-table tbody').html();
//     $(".addButton").click(function(){
//         $(Data_to_clone).appendTo(".cloning-table");
//     });

//     $(".cloning-table").on('click','.deleteButton',function(){
//         $(this).parents(".clonetr").remove();
//     });
// });

var int = 1;
   function addButton()
   {
      
      $('#AddContainer')
      // .find('div')
      // .remove()
      // .end()
      .append(
            '<tr>'+
            '<td>' +
              '<select id="selUser_'+ (int) +'" name="items['+ (int) +'][ingredient]" class="form-select table_input table_select adjust_lenth" onchange="getSubcategory(this,'+ (int) +');"  style="width: 159px;">@foreach($ingredients as $ingredient)<option value="{{$ingredient->id}}">{{$ingredient->name}}</option>@endforeach</select>' +
            '</td>'+
            '<td>'+
            '<input class="form-control table_input  adjust_lenth" type="number" id="fname" name="items['+ (int) +'][qty]" value="">' +
            '</td>'+
            '<td>'+
            '<input class="form-control table_input  adjust_lenth" type="text" id="upload_videos_'+ (int) +'"  value="">' +
            '<input class="form-control table_input  adjust_lenth" type="hidden" id="upload_videos_id_'+ (int) +'" name="items['+ (int) +'][unit]" value="">' +
            '<button class="remCF close" id="remCF"' + (int) +' type="button">-</button>' +
            '</td>'+
            '</tr>');

            int++;
   }

count= 0;
function getSubcategory(obj,count) {
   // alert(count);
   var allList =<?= \GuzzleHttp\json_encode($ingredients)?>;
   var allLists =<?= \GuzzleHttp\json_encode($unit)?>;
  
   var ingredientId =$('#selUser_'+count).find('option:selected').val();
   // alert(ingredientId);
            $(allList).each(function (a, ingredients) {
               if (ingredients.id == ingredientId) {
                  var unit_id = ingredients.unit_id;
                  $(allLists).each(function (a, unit) {
                   if (unit.id == unit_id) {
                     $("#upload_videos_"+count).val(unit.unit);
                     $("#upload_videos_id_"+count).val(unit.id);
                      }
      
                   });
                  
                } 
            });
}

</script>
      <script>
         uploadimg.onchange = evt => {
  const [file] = uploadimg.files
  if (file) {
    blah.src = URL.createObjectURL(file)
  }
}
      </script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script>
 $(window).load(function(){
   setTimeout(function(){ $('.alert-danger').fadeOut('slow') }, 3000);
});
  </script>
   <script>
 $(window).load(function(){
   setTimeout(function(){ $('.alert-success').fadeOut('slow') }, 3000);
});
  </script>
  
      @endsection
      <script src="assets/vendor/jquery.min.js"></script>
      <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
      <script src="assets/vendor/owl/owl.carousel.min.js"></script>
      <script src="assets/js/main.js"></script>
      <script>
         $( '.selct_comman' ).select2( {
            theme: "bootstrap-5", 
         });
         $( '.multiple-select-custom-field' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
            tags: true
         } );
      </script>

<script>
            function validate(obj) {
            $(".text-danger").html('');
            var flag = true;
            var formData = $("#addForm").find(".validate:input").not(':input[type=button]');
            var formDatas = $("#addForm").find(".validatee:input").not(':input[type=button]');
            $('select.required').each(function () {
      //   var message = $(this).attr('title');
        if($(this).val() == '' || $(this).val() == 0) {                
            //   alert(message);
              $('#errorShow').text("This field is required");
              flag = false;
            }else {

               }
        });
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
            $(formDatas).each(function () {
                var element = $(this);
                var val = element.val();
                var name = element.attr("name");
                if (val == "" || val == "0" || val == null) {
                    
                $("#" + name + "Error").html("Required field");
                flag = false;
                    
                    
                } else {

                }
            });
           
            if (flag) {
                $("#addForm").submit();
            } else {
                return false;
            }

            
        }
    </script>
   <script>
    var textarea = document.getElementById("note");
   textarea.oninput = function() {
  textarea.style.height = "auto";
  textarea.style.height = Math.min(textarea.scrollHeight, limit) + "px";
};
   </script>
<style>
textarea#note {
	width:100%;
   height:100%;
	box-sizing:border-box;
   overflow:hidden;
	display:block;
	max-width:100%;
	line-height:1.5;
   resize: none;
	padding:15px 15px 30px;
	border-radius:3px;
   outline: 0px solid transparent;
	border:none;
	font:14px Tahoma, cursive;
}
</style>
   