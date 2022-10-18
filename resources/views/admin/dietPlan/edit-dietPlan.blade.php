@extends('admin.layout.master')
@section('content')
      <div class="admin_main">
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
               <div class="row diet-add-items justify-content-center">
                  <div class="col-12">
                     <div class="row mx-0">
                        <div class="col-12 design_outter_comman shadow mb-4">
                           <div class="row comman_header justify-content-between">
                              <div class="col">
                                 <h2>Edit Diet Plan</h2>
                              </div>
                           </div>
                           <form class="form-design py-4 px-4 row align-items-start justify-content-start"  method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/dietPlan/edit_update',[base64_encode($edit_dietPlan->id)])}}" >
                              @csrf
                              <div class="col-md-12">
                                 <div class="row">
                                    <div class="form-group col-6">
                                       <label for=""> Title (English) :</label>
                                       <input type="text" class="form-control"  value="{{$edit_dietPlan->name}}" name="name" id="name">
                                    </div> 
                                    <div class="form-group col-6">
                                       <label for=""> Title (Arabic) :</label>
                                       <input type="text" class="form-control"  value="{{$edit_dietPlan->name_ar}}"  name="name_ar" id="name">
                                    </div>  
                                    <div class="form-group col-6 textarea_height">
                                       <label for="">Description (Englsih) :</label>
                                       <textarea class="form-control" name="description" id=""  > {{$edit_dietPlan->description}}</textarea>
                                    </div>
                                    <div class="form-group col-6 textarea_height">
                                       <label for="">Description (Arabic) :</label>
                                       <textarea class="form-control" name="description_ar" id=""> {{$edit_dietPlan->description}}</textarea>
                                    </div>
                                    <div class="form-group col-6 uploadimg_box">
                                       <span>Media (English):</span>
                                       <input type="file" id="uploadimg" name="image" class="d-none">
                                       <label for="uploadimg">
                                          <div class="uploadimg_inner">
                                             <i class="fas fa-upload me-2"></i>
                                             <span>Upload File</span>
                                          </div>
                                       </label>
                                    </div> 
                                    <div class="form-group col-6 uploadimg_box">
                                       <span>Media (Arabic):</span>
                                       <input type="file" id="uploadimg" name="image_ar" class="d-none">
                                       <label for="uploadimg">
                                          <div class="uploadimg_inner">
                                             <i class="fas fa-upload me-2"></i>
                                             <span>Upload File</span>
                                          </div>
                                       </label>
                                    </div> 
                                 </div>
                              </div>  
                              <div class="col-12 comman_table_design New_tabledesign mb-4">
                                 <div class="table-responsive border rounded">
                                    <table class="table mb-0">
                                       <thead>
                                          <tr>
                                             <th>Macros</th>
                                             <th>Default (Min)</th>
                                             <th>Divisor of minimum</th>
                                             <th>Default (Max)</th> 
                                             <th>Divisor of Maximum</th> 
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <tr>
                                             <td>
                                                Protein
                                             </td>
                                             <td>
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input" type="text" id="pname1" onchange="autofill3(1)" name="protein_default_min" value="{{$edit_dietPlan->protein_default_min}}">
                                                   <label>%</label>
                                                </div>
                                             </td>
                                             <td>
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input" type="text" id="pname7"  onchange="autofill3(7)" name="protein_min_divisor" value="{{$edit_dietPlan->protein_min_divisor}}">
                                                    
                                                </div>
                                             </td>
                                             <td> 
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input" type="text" id="pname2"  onchange="autofill3(2)" name="protein_default_max" value="{{$edit_dietPlan->protein_default_max}}">
                                                   <label>%</label>
                                                </div>
                                             </td>
                                             <td> 
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input" type="text" id="pname8"  onchange="autofill3(8)" name="protein_max_divisor" value="{{$edit_dietPlan->protein_max_divisor}}"> 
                                                </div>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td>
                                                Carbs
                                             </td>
                                             <td>
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input" type="text" id="pname3"  onchange="autofill3(3)" name="carb_default_min" value="{{$edit_dietPlan->carb_default_min}}">
                                                   <label>%</label>
                                                </div>
                                             </td>
                                             <td>
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input" type="text" id="pname9"  onchange="autofill3(9)" name="carb_min_divisor" value="{{$edit_dietPlan->carb_min_divisor}}">
                                                   
                                                </div>
                                             </td>
                                             <td> 
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input" type="text" id="pname4"  onchange="autofill3(4)" name="carb_default_max" value="{{$edit_dietPlan->carb_default_max}}">
                                                   <label>%</label>
                                                </div>
                                             </td>
                                             <td> 
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input" type="text" id="pname10"  onchange="autofill3(10)" name="carb_max_divisor" value="{{$edit_dietPlan->carb_max_divisor}}">
                                                   
                                                </div>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td>
                                                Fat
                                             </td>
                                             <td>
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input" type="text" id="pname5"  onchange="autofill3(5)" name="fat_default_min" value="{{$edit_dietPlan->fat_default_min}}">
                                                   <label>%</label>
                                                </div>
                                             </td>
                                             <td>
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input" type="text" id="pname11" onchange="autofill3(11)" name="fat_min_divisor" value="{{$edit_dietPlan->fat_min_divisor}}">
                                                    
                                                </div>
                                             </td>
                                             <td> 
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input" type="text" id="pname6"  onchange="autofill3(6)" name="fat_default_max" value="{{$edit_dietPlan->fat_default_max}}">
                                                   <label>%</label>
                                                </div>
                                             </td>
                                             <td> 
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input" type="text" id="pname12"  onchange="autofill3(12)" name="fat_max_divisor" value="{{$edit_dietPlan->fat_max_divisor}}">
                                                    
                                                </div>
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div> 
                              <div class="col-12 comman_table_design mb-4">
                                 <div class="row mx-0 comman_header justify-content-between rounded-top">
                                    <div class="col">
                                       <h2>Equation applied on Target calories for Balance Diet Plan users</h2>
                                    </div> 
                                 </div>
                                 <div class="table-responsive border rounded-bottom">
                                    <table class="table mb-0"> 
                                       <thead>
                                          <tr>
                                             <th>Macros</th>
                                             <th>MINIMUM Value</th>
                                             <th>MAXIMUM Value</th>  
                                             <th>Formula</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <tr>
                                             <td>
                                                Protein
                                             </td> 
                                             <td>
                                                Minimum value % of Calorie / <span class="editable_span"  id="span7">{{$edit_dietPlan->protein_min_divisor}}</span>
                                             </td> 
                                             <td>
                                                Maximum value % of Calorie / <span class="editable_span"  id="span8">{{$edit_dietPlan->protein_max_divisor}}</span>
                                             </td> 
                                             <td>
                                                (<span class="editable_span" id="span1">{{$edit_dietPlan->protein_default_min}}</span><span class="editable_span">%</span> of calorie / <span class="editable_span" id="span117"></span> to <span id="span2" class="editable_span"> {{$edit_dietPlan->protein_default_max}}</span><span class="editable_span">%</span> of Calorie / <span class="editable_span" id="span118"></span> )
                                             </td> 
                                          </tr> 
                                          <tr>
                                             <td>
                                                Carbs 
                                             </td> 
                                             <td>
                                                Minimum value % of Calorie / <span class="editable_span" id="span9">{{$edit_dietPlan->carb_min_divisor}}</span>
                                             </td>
                                             <td>
                                                Maximum value % of Calorie / <span class="editable_span" id="span10">{{$edit_dietPlan->carb_max_divisor}}</span>
                                             </td> 
                                             <td>
                                             (<span id="span3" class="editable_span"> {{$edit_dietPlan->carb_default_min}}</span><span class="editable_span">%</span> of calorie / <span class="editable_span" id="span119"></span> to <span id="span4" class="editable_span"> {{$edit_dietPlan->carb_default_max}}</span><span class="editable_span">%</span> of Calorie / <span class="editable_span" id="span1110"></span> )
                                             </td> 
                                          </tr>
                                          <tr>
                                             <td>
                                                Fat
                                             </td> 
                                             <td>
                                                Minimum value % of Calorie / <span class="editable_span" id="span11">{{$edit_dietPlan->fat_min_divisor}}</span>
                                             </td> 
                                             <td>
                                                Maximum value % of Calorie / <span class="editable_span" id="span12">{{$edit_dietPlan->fat_max_divisor}}</span>
                                             </td> 
                                             <td>
                                                (<span id="span5" class="editable_span">{{$edit_dietPlan->fat_default_min}} </span><span class="editable_span">%</span> of calorie / <span class="editable_span" id="span1111"></span> to <span id="span6" class="editable_span"> {{$edit_dietPlan->fat_default_max}}</span><span class="editable_span">%</span> of Calorie / <span class="editable_span" id="span1112"></span> )
                                             </td> 
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                              <div class="form-group col-6 text-end">
                                 <button type="button" onclick="validate(this);" class="comman_btn">Save</button> 
                              </div> 
                              <div class="form-group col-6 text-start">  
                                 <button class="comman_btn bg-red">Close</button>
                              </div> 
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div> 
 @endsection

 <script>

function autofill3(count){
var inps = document.getElementById('pname'+ count).value;

 document.getElementById('span'+count).innerText=inps;
 document.getElementById('span11'+count).innerText=inps;
  
    }
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