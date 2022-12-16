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
                                       <input type="text" class="form-control validate" value="" name="name" id="name">
                                       <p class="text-danger text-small" id="nameError"></p>
                                    </div>
                                    <div class="form-group col-6">
                                       <label for=""> Side Dish :</label>
                                       <input type="text" class="form-control validate" value="" name="side_dish" id="name">
                                       <p class="text-danger text-small" id="side_dishError"></p>
                                    </div>
                                    <div class="form-group col-6">
                                       <label for=""> Title (Arabic) :</label>
                                       <input type="text" class="form-control validate" value="" name="name_ar" id="name">
                                       <p class="text-danger text-small" id="name_arError"></p>
                                    </div>
                                    <div class="form-group col-6">
                                       <label for=""> Side Dish :</label>
                                       <input type="text" class="form-control validate" value="" name="side_dish_ar" id="name">
                                       <p class="text-danger text-small" id="side_dish_arError"></p>
                                    </div>
                                    <div class="form-group col-12 textarea_height">
                                       <label for="">Method of Cooking (English) :</label>
                                       <textarea class="form-control validate" name="description" id=""></textarea>
                                       <p class="text-danger text-small" id="descriptionError"></p>
                                    </div>
                                    <div class="form-group col-12 textarea_height">
                                       <label for="">Method of Cooking (Arabic) :</label>
                                       <textarea class="form-control validate" name="description_ar" id=""></textarea>
                                       <p class="text-danger text-small" id="description_arError"></p>
                                    </div>
                                    <div class="form-group col-12 uploadimg_box">
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
                                    </div> 
                                 
                                 </div>
                              </div>
                              <div class="col-md-5 ps-4 pe-0">
                                 <div class="row additems_aside">
                                    <div class="form-group col-12">
                                       <h2 class="add_items_headign">
                                          Item Status :
                                       </h2>
                                       <select class="form-select form-control" aria-label="Default select example" name="status">
                                          <option selected="">Select</option>
                                          <option value="active">Active</option>
                                          <option value="inactive">Draft</option> 
                                       </select>
                                    </div> 
                                    <div class="col-12">
                                       <h2 class="add_items_headign">
                                          Item Organization :
                                       </h2>
                                       <div class="row">
                                          <div class="form-group col-12">
                                             <label for="">Meal Group :</label>
                                             <select class="w-100 multiple-select-custom-field" data-placeholder="Choose anything" multiple name="meal_schedule_id[]"> 
                                             @foreach($meal_schedule as $meal_schedules) 
                                                <option value="{{$meal_schedules->id}}">{{$meal_schedules->name}}</option>
                                             @endforeach
                                             </select>
                                          </div>
                                          <div class="form-group col-12">
                                             <label for="">Tags :</label>
                                             <select class="w-100 multiple-select-custom-field" data-placeholder="Choose anything" multiple name="week_days_id[]">
                                                @foreach($tags as $tag) 
                                                <option value="{{$tag->id}}">{{$tag->name}}</option>
                                               @endforeach
                                             </select>
                                          </div>
                                          <div class="form-group col-12">
                                             <label for="">Plan Type :</label>
                                             <select class="w-100 selct_comman" data-placeholder="Choose anything" multiple name="diet_plan_type_id[]"> 
                                             @foreach($diet_plan as $diet_plans) 
                                                <option value="{{$diet_plans->id}}">{{$diet_plans->name}}</option>
                                               @endforeach 
                                             </select>
                                          </div>
                                          <div class="form-group col-12">
                                             <label for="">Department :</label>
                                             <select class="w-100 multiple-select-custom-field" data-placeholder="Choose anything" multiple name="department_id[]"> 
                                             @foreach($department as $departments) 
                                                <option value="{{$departments->id}}">{{$departments->name}}</option>
                                               @endforeach 
                                             </select>
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
                                                      <input class="d-none" type="radio" id="v3" value="none" name="check11">
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
                                       <a class="comman_btn yellow-btn add_row_btn" href="javscript:;" onclick="insRow('myTable')" value="Insert row">
                                         Add Row
                                       </a>
                                    </div>
                                 </div>
                                 <div class="row" >
                                    <div class="col-12 comman_table_design New_tabledesign">
                                       <div class="table-responsive">
                                          <table class="table mb-0" id="myTable">
                                             <thead>
                                                <tr>
                                                   <th>Ingredients</th>
                                                   <th>Qty</th>
                                                   <th>Unit</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <tr>
                                                 
                                                <td>
                                                      <select class="form-select table_input table_select adjust_lenth" aria-label="Default select example" id="fname"  name="ingredient[]">
                                                      @foreach($ingredients as $ingredient)
                                                         <option value='{{$ingredient->id}}'>{{$ingredient->name}}</option>
                                                         @endforeach
                                                     </select>
                                                   </td>
                                                
                                                   <td>
                                                      <input class="form-control table_input table_select adjust_lenth" type="number" id="fname" name="qty[]" value="">
                                                   </td>
                                                   <td>
                                                      <select class="form-select table_input table_select adjust_lenth" aria-label="Default select example" id="fname" name="unit[]">
                                                      @foreach($unit as $units)
                                                         <option value='{{$units->id}}'>{{$units->unit}}</option>
                                                         @endforeach
                                                     </select>
                                                   </td>
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
                                                <tr>
                                                   <td>
                                                      <strong>1000 cal</strong>
                                                   </td>
                                                   <td>
                                                   <input class="form-control table_input" type="hidden" value="1000" name="user_calorie1">
                                                      <input class="form-control table_input" type="text" placeholder="S" name="size1">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="50%" name="recipe_yield1">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="150" name="meal_calorie1">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="28" name="protein1">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="6" name="carb1">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="5" name="fat1">
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <strong>1200 cal</strong> 
                                                   </td>
                                                   <td>
                                                   <input class="form-control table_input" type="hidden" value="1200" name="user_calorie2">
                                                      <input class="form-control table_input" type="text" placeholder="S" name="size2"> 
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="50%" name="recipe_yield2">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="150" name="meal_calorie2">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="28"  name="protein2">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="6" name="carb2">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="5" name="fat2">
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <strong>1500 cal</strong> 
                                                   </td>
                                                   <td>
                                                   <input class="form-control table_input" type="hidden" value="1500" name="user_calorie3">
                                                      <input class="form-control table_input" type="text" placeholder="S" name="size3">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="50%" name="recipe_yield3">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="150" name="meal_calorie3">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="28" name="protein3">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="6" name="carb3">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="5" name="fat3">
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <strong>1800 cal</strong> 
                                                   </td>
                                                   <td>
                                                   <input class="form-control table_input" type="hidden" value="1800" name="user_calorie4">
                                                      <input class="form-control table_input" type="text" placeholder="L" name="size4">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="100%" name="recipe_yield4">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="200" name="meal_calorie4"> 
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="32" name="protein4">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="6" name="carb4">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="8" name="fat4">
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <strong>2000 cal</strong> 
                                                   </td>
                                                   <td>
                                                   <input class="form-control table_input" type="hidden" value="2000" name="user_calorie5">
                                                      <input class="form-control table_input" type="text" placeholder="L" name="size5">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="100%" name="recipe_yield5">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="200" name="meal_calorie5">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="32" name="protein5">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="6" name="carb5">
                                                   </td>
                                                   <td>
                                                      <input class="form-control table_input" type="text" placeholder="8" name="fat5">
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group col-6 text-end" style="margin-top: 23px;">
								 <button class="comman_btn" onclick="validate(this);">Save</button>
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
      <script>
function insRow(id) {
    var filas = document.getElementById("myTable").rows.length;
    var x = document.getElementById(id).insertRow(filas);
    var y = x.insertCell(0);
    var z = x.insertCell(1);
    var t = x.insertCell(2);
    y.insertAdjacentHTML('beforeend','<select  class="form-select table_input table_select adjust_lenth" aria-label="Default select example " name="ingredient[]" id="fname" @foreach($ingredients as $ingredient)<option value="{{$ingredient->id}}" >{{$ingredient->name}}</option>@endforeach</select>');
    z.innerHTML ='<input class="form-control table_input table_select adjust_lenth" type="text" name="qty[]" id="fname">';
    t.insertAdjacentHTML('beforeend','<select  class="form-select table_input table_select adjust_lenth" aria-label="Default select example " name="unit[]" id="fname">@foreach($unit as $units)<option value="{{$units->id}}">{{$units->unit}}</option>@endforeach</select>');
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
           
            if (flag) {
                $("#addForm").submit();
            } else {
                return false;
            }

            
        }
    </script>
   