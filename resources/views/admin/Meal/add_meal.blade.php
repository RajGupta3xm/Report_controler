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
                           <form class="form-design py-4 px-4 row align-items-start justify-content-start" method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/meal/submit')}}">
                           {{ csrf_field() }} 
                              <div class="col-md-7 px-0">
                                 <div class="row">
                                    <div class="form-group col-6">
                                       <label for=""> Title (English) :</label>
                                       <input type="text" class="form-control validate" value="" name="name" id="name"   maxlength ="20">
                                       <p class="text-danger text-small" id="nameError"></p>
                                    </div>
                                    <div class="form-group col-6">
                                       <label for=""> Side Dish :</label>
                                       <input type="text" class="form-control validate" value="" name="side_dish" id="name"  maxlength ="20">
                                       <!-- <p class="text-danger text-small" id="side_dishError"></p> -->
                                    </div>
                                    <div class="form-group col-6">
                                       <label for=""> Title (Arabic) :</label>
                                       <input type="text" class="form-control validate" value="" name="name_ar" id="name"  maxlength ="20">
                                       <p class="text-danger text-small" id="name_arError"></p>
                                    </div>
                                    <div class="form-group col-6">
                                       <label for=""> Side Dish :</label>
                                       <input type="text" class="form-control validate" value="" name="side_dish_ar" id="name"   maxlength ="20">
                                       <!-- <p class="text-danger text-small" id="side_dish_arError"></p> -->
                                    </div>
                                    <div class="form-group col-12 textarea_height">
                                       <label for="">Method of Cooking (English) :</label>
                                       <textarea class="form-control " name="description" maxlength ="100" ></textarea>
                                       <!-- <p class="text-danger text-small" id="descriptionError"></p> -->
                                    </div>
                                    <div class="form-group col-12 textarea_height">
                                       <label for="">Method of Cooking (Arabic) :</label>
                                       <textarea class="form-control " name="description_ar" maxlength ="100" ></textarea>
                                       <!-- <p class="text-danger text-small" id="description_arError"></p> -->
                                    </div>
                                    <div class="form-group col-12 uploadimg_box"> <span>Media :</span>
                                        <input type="file" id="uploadimg" class="validate dropify" name="image">
{{--                                       <label for="uploadimg">--}}
{{--                                        <div class="uploadimg_inner"> <i class="fas fa-upload me-2"></i> <span>Upload File</span> </div>--}}
{{--                                                </label>--}}
                                                <p class="text-danger text-small" id="imageError"></p>
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
                                       <select class="form-select form-control validate" aria-label="Default select example" name="status">
                                          <option selected="" disabled>Select</option>
                                          <option value="active">Active</option>
                                          <option value="inactive">Draft</option> 
                                       </select>
                                       <p class="text-danger text-small" id="statusError"></p>
                                    </div> 
                                    <div class="col-12">
                                       <h2 class="add_items_headign">
                                          Item Organization :
                                       </h2>
                                       <div class="row">
                                          <div class="form-group col-12">
                                             <label for="">Meal Group :</label>
                                             <select class="w-100 multiple-select-custom-field required" data-placeholder="Select"  multiple name="meal_schedule_id[]" id="sampleMut" title="This is required field" > 
                                             @foreach($meal_schedule as $meal_schedules) 
                                                <option value="{{$meal_schedules->id}}">{{$meal_schedules->name}}</option>
                                             @endforeach
                                             </select>
                                             <p class="text-danger text-small" id='errorShow' ></p>
                                          </div>
                                          <div class="form-group col-12">
                                             <label for="">Tags : Date format: dd/mm/YY</label>
                                             <select class="w-100 multiple-select-custom-field required1"  data-placeholder="Select" multiple name="week_days_id[]">
                                               @foreach($tags as $tag)
                                                <option value="{{$tag->week_days_id}}">{{ucfirst($tag->week_days_id)}}</option>
                                              @endforeach
                                             </select>
                                             <p class="text-danger text-small" id='errorShow1' ></p>
                                          </div>
                                          <div class="form-group col-12">
                                             <label for="">Plan Type :</label>
                                             <select class="w-100 selct_comman required2" data-placeholder="Select" multiple name="diet_plan_type_id[]"> 
                                             @foreach($diet_plan as $diet_plans) 
                                                <option value="{{$diet_plans->id}}">{{$diet_plans->name}}</option>
                                               @endforeach 
                                             </select>
                                             <p class="text-danger text-small" id='errorShow2' ></p>
                                          </div>
                                          <div class="form-group col-12">
                                             <label for="">Department :</label>
                                             <select class="w-100 multiple-select-custom-field required3" data-placeholder="Select" multiple name="department_id[]"> 
                                             @foreach($department as $departments) 
                                                <option value="{{$departments->id}}">{{$departments->name}}</option>
                                               @endforeach 
                                             </select>
                                             <p class="text-danger text-small" id='errorShow3' ></p>
                                          </div>
                                          <div class="form-group col-12">
                                             <label for="">Food type :</label>
                                             <div class="row">
                                                <div class="col-4 pe-0">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none" type="radio" id="v1" value="veg" name="check11">
                                                      <label for="v1">Veg <div class="circle_cmn"></div> </label>
                                                   </div>
                                                </div>
                                                <div class="col-4 pe-0">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none" type="radio" id="v2" value="non_veg" name="check11">
                                                      <label for="v2">Nonveg <div class="circle_cmn bg-red"></div></label>
                                                   </div>
                                                </div>
                                                <div class="col-4 pe-0">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none" type="radio" id="v3" value="none" name="check11" checked>
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
                                          <table class="table mb-0 " id="cloningtable">
                                             <thead>
                                                <tr>
                                                   <th>Ingredients</th>
                                                   <th>Qty</th>
                                                   <th>Unit</th>
                                                </tr>
                                             </thead>
                                             <tbody id="AddContainer">
                                             
                                                <tr class="clonetr">
                                                <td class="searchDrop">
                                                      <!-- <select class="form-select table_input table_select adjust_lenth" id="categoryList" onchange="getSubcategory(this);" aria-label="Default select example" id="fname"  name="ingredient[]"> -->
                                                    <!-- Dropdown --> 
                                                    <select id='selUser_0'class="form-select table_input table_select adjust_lenth selUser "  onchange="getSubcategory(this,0);"  name="items[0][ingredient]" >
                                                       <option selected="" disabled>Select User</option> 
                                                       @foreach($ingredients as $ingredient)
                                                        <option value='{{$ingredient->id}}'>{{$ingredient->name}}</option> 
                                                        @endforeach
                                                     </select>
                                                     <!-- <div id='result'></div> -->
                                                     <!-- <input class="form-control table_input  adjust_lenth" type="number" id="fname" name="ingredient[]" value=""> -->
                                                   </td>
                                                
                                                   <td>
                                                      <input class="form-control table_input  adjust_lenth" type="number" id="fname" name="items[0][qty]" value="">
                                                   </td>
                                                   <td>
                                                   <input class="form-control table_input  adjust_lenth" type="text" id="upload_videos_0" name="items[0][unit]" value="">
                                                      <!-- <select class="form-select table_input table_select adjust_lenth" id="subcategoryList" aria-label="Default select example" id="fname" name="unit[]">
                                                      <option value=''>select </option>
                                                      @foreach($unit as $units)
                                                         <option value='{{$units->id}}'>{{$units->unit}}</option>
                                                         @endforeach
                                                     </select> -->
                                                   </td>
                                                   <!-- <td><input type="button" class=" btn btn-danger deleteButton " value="delete"/></td> -->
                                                   <!-- <td>
                                                      <input class="form-control table_input" type="text" id="fname" name="ingredient[]" value="">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="number" id="fname" name="qty[]" value="">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" id="fname" name="unit[]" value="">
                                                   </td> -->
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
                                          <div class="col-auto">
                                             <a class="comman_btn yellow-btn add_row_btn" href="javscript:;">
                                               Edit
                                             </a>
                                          </div>
                                       </div>
                                       <div class="row p-3 instructions_box position-relative border-bottom">
                                          <span class="head_small mb-1">Instructions:</span>
                                          <ul class="list-unstyled">
                                             <li>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                                             </li>
                                             <li>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                                             </li>
                                             <li>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                                             </li>
                                             <li>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                                             </li>
                                          </ul>
                                       </div>
                                       <div class="row p-3 instructions_box position-relative">
                                          <span class="head_small mb-1">Ingredients:</span>
                                          <div class="d-flex flex-wrap">
                                             <p class="me-2">Onion,</p>
                                             <p class="me-2">Tomato,</p>
                                             <p class="me-2">Onion</p>
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
                                       <input class="form-control table_input" type="text" placeholder="200" name="recipe_yields">
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
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="size1">
                                                      <p class="text-danger text-small" id="size1Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="recipe_yield1">
                                                      <p class="text-danger text-small" id="recipe_yield1Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="meal_calorie1">
                                                      <p class="text-danger text-small" id="meal_calorie1Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="protein1">
                                                      <p class="text-danger text-small" id="protein1Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="carb1">
                                                      <p class="text-danger text-small" id="carb1Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="fat1">
                                                      <p class="text-danger text-small" id="fat1Error"></p>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <strong>1200 cal</strong> 
                                                   </td>
                                                   <td>
                                                   <input class="form-control table_input" type="hidden" value="1200" name="user_calorie2">
                                                      <input class="form-control table_input validatee" type="text" placeholder="-" name="size2"> 
                                                      <p class="text-danger text-small" id="size2Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="recipe_yield2">
                                                      <p class="text-danger text-small" id="recipe_yield2Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="meal_calorie2">
                                                      <p class="text-danger text-small" id="meal_calorie2Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--"  name="protein2">
                                                      <p class="text-danger text-small" id="protein2Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="carb2">
                                                      <p class="text-danger text-small" id="carb2Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="fat2">
                                                      <p class="text-danger text-small" id="fat2Error"></p>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <strong>1500 cal</strong> 
                                                   </td>
                                                   <td>
                                                   <input class="form-control table_input" type="hidden" value="1500" name="user_calorie3">
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="size3">
                                                      <p class="text-danger text-small" id="size3Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="recipe_yield3">
                                                      <p class="text-danger text-small" id="recipe_yield3Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="meal_calorie3">
                                                      <p class="text-danger text-small" id="meal_calorie3Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="protein3">
                                                      <p class="text-danger text-small" id="protein3Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="carb3">
                                                      <p class="text-danger text-small" id="carb3Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="fat3">
                                                      <p class="text-danger text-small" id="fat3Error"></p>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <strong>1800 cal</strong> 
                                                   </td>
                                                   <td>
                                                   <input class="form-control table_input" type="hidden" value="1800" name="user_calorie4">
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="size4">
                                                      <p class="text-danger text-small" id="size4Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="recipe_yield4">
                                                      <p class="text-danger text-small" id="recipe_yield4Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="meal_calorie4"> 
                                                      <p class="text-danger text-small" id="meal_calorie4Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="protein4">
                                                      <p class="text-danger text-small" id="protein4Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="carb4">
                                                      <p class="text-danger text-small" id="carb4Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="fat4">
                                                      <p class="text-danger text-small" id="fat4Error"></p>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <strong>2000 cal</strong> 
                                                   </td>
                                                   <td>
                                                   <input class="form-control table_input" type="hidden" value="2000" name="user_calorie5">
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="size5">
                                                      <p class="text-danger text-small" id="size5Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="recipe_yield5">
                                                      <p class="text-danger text-small" id="recipe_yield5Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="meal_calorie5">
                                                      <p class="text-danger text-small" id="meal_calorie5Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="protein5">
                                                      <p class="text-danger text-small" id="protein5Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="carb5">
                                                      <p class="text-danger text-small" id="carb5Error"></p>
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input validatee" type="text" placeholder="--" name="fat5">
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
   $("#cloningtable").on('click', '.remCF', function(){
     $(this).parent().parent().remove();
   });
 </script>
     <script>
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
              '<select id="selUser_'+ (int) +'" name="items['+ (int) +'][ingredient]" class="form-select table_input table_select adjust_lenth" onchange="getSubcategory(this,'+ (int) +');" >@foreach($ingredients as $ingredient)<option value="{{$ingredient->id}}">{{$ingredient->name}}</option>@endforeach</select>' +
            '</td>'+
            '<td>'+
            '<input class="form-control table_input  adjust_lenth" type="number" id="fname" name="items['+ (int) +'][qty]" value="">' +
            '</td>'+
            '<td>'+
            '<input class="form-control table_input  adjust_lenth" type="text" id="upload_videos_'+ (int) +'" name="items['+ (int) +'][unit]" value="">' +
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
                     // <input type="hidden" name="compare_price_hidden[]" value="'+compare_price_value+'">
                     // html += '<option value='" + unit.unit + "'>" + unit.unit + "</option>';
                      }
      
                   });
                  //  $("#upload_videos_" + level).append(html);
                } 
            });
}
// function insRow(id) {
//     var filas = document.getElementById("myTable").rows.length;
//     alert(filas);
//     var x = document.getElementById(id).insertRow(filas);
//     var y = x.insertCell(0);
//     var z = x.insertCell(1);
//     var t = x.insertCell(2);
//     y.insertAdjacentHTML('<select  class="form-select table_input table_select adjust_lenth" aria-label="Default select example " name="ingredient[]" id="fname" @foreach($ingredients as $ingredient)<option value="{{$ingredient->id}}" >{{$ingredient->name}}</option>@endforeach</select>');
//     z.innerHTML ='<input class="form-control table_input table_select adjust_lenth" type="text" name="qty[]" id="fname">';
//     t.insertAdjacentHTML('beforeend','<select  class="form-select table_input table_select adjust_lenth" aria-label="Default select example " name="unit[]" id="fname">@foreach($unit as $units)<option value="{{$units->id}}">{{$units->unit}}</option>@endforeach</select>');
// }
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
        /****************** error message show for multiple select dropdown */ 
       $('select.required').each(function () {
      //   var message = $(this).attr('title');
        if($(this).val() == '' || $(this).val() == 0) {                
            //   alert(message);
              $('#errorShow').text("This field is required");
              flag = false;
            }else {

               }
        });
        $('select.required1').each(function () {
      //   var message = $(this).attr('title');
        if($(this).val() == '' || $(this).val() == 0) {                
            //   alert(message);
              $('#errorShow1').text("This field is required");
              flag = false;
            }else {

               }
        });
        $('select.required2').each(function () {
      //   var message = $(this).attr('title');
        if($(this).val() == '' || $(this).val() == 0) {                
            //   alert(message);
              $('#errorShow2').text("This field is required");
              flag = false;
            }else {

               }
        });
        $('select.required3').each(function () {
      //   var message = $(this).attr('title');
        if($(this).val() == '' || $(this).val() == 0) {                
            //   alert(message);
              $('#errorShow3').text("This field is required");
              flag = false;
            }else {

               }
        });
           /****************** end */ 
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
   