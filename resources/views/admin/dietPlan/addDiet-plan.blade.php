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
               <div class="row diet-add-items justify-content-center">
                  <div class="col-12">
                     <div class="row mx-0">
                        <div class="col-12 design_outter_comman shadow mb-4">
                           <div class="row comman_header justify-content-between">
                              <div class="col">
                                 <h2>Add Diet Plan</h2>
                              </div>
                           </div>
                           <form class="form-design py-4 px-4 row align-items-start justify-content-start"  method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/diet-plan/submit')}}">
                            @csrf
                              <div class="col-md-12">
                                 <div class="row">
                                    <div class="form-group col-6">
                                       <label for=""> Title (English) :</label>
                                       <input type="text" class="form-control validate" value="" name="name" id="name" maxlength="20">
                                       <p class="text-danger text-small" id="nameError">
                                    </div> 
                                    <div class="form-group col-6">
                                       <label for=""> Title (Arabic) :</label>
                                       <input type="text" class="form-control validate" value="" name="name_ar" id="name" maxlength="20">
                                       <p class="text-danger text-small" id="name_arError">
                                    </div> 
                                    <div class="form-group col-6 textarea_height">
                                       <label for="">Description (Englsih) :</label>
                                       <textarea class="form-control validate" name="description" id="" maxlength="100"></textarea>
                                       <p class="text-danger text-small" id="descriptionError">
                                    </div>
                                    <div class="form-group col-6 textarea_height">
                                       <label for="">Description (Arabic) :</label>
                                       <textarea class="form-control validate"  name="description_ar" id="" maxlength="100"></textarea>
                                       <p class="text-danger text-small" id="description_arError">
                                    </div>
                                    <div class="form-group col-6 uploadimg_box"> <span>Media (English) :</span>
                                       <input type="file" id="uploadimg4" class="dropify validate" name="image" data-default-file="" accept="image/*">
                                       <p class="text-danger text-small" id="imageError"></p>
                                    </div>
                                    <!-- <div class="form-group col-6 uploadimg_box">
                                       <span>Media (English):</span>
                                       <input type="file" id="uploadimg" name="image" class="d-none validate">
                                       <label for="uploadimg">
                                          <div class="uploadimg_inner">
                                             <i class="fas fa-upload me-2"></i>
                                             <span>Upload File</span>
                                          </div>
                                       </label>
                                       <p class="text-danger text-small" id="imageError">
                                    </div>  -->
                                    <div class="form-group col-6 uploadimg_box"> <span>Media (Arabic) :</span>
                                       <input type="file" id="uploadimg5" class="dropify validate" name="image_ar" data-default-file="" accept="image/*">
                                       <p class="text-danger text-small" id="image_arError"></p>
                                    </div>
                                    <!-- <div class="form-group col-6 uploadimg_box">
                                       <span>Media (Arabic):</span>
                                       <input type="file" id="uploadimg1" name="image_ar" class="d-none validate">
                                       <label for="uploadimg1">
                                          <div class="uploadimg_inner">
                                             <i class="fas fa-upload me-2"></i>
                                             <span>Upload File</span>
                                          </div>
                                       </label>
                                       <p class="text-danger text-small" id="image_arError">
                                    </div>  -->
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
                                                   <input class="form-control table_input validatee" type="text" id="pname1"  onchange="autofill3(1)" name="protein_default_min" placeholder="--">
                                                   <label>%</label>
                                                   <p class="text-danger text-small" id="protein_default_minError"></p>
                                                </div>
                                             </td>
                                             <td>
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input validatee" id="pname7"  onchange="autofill3(7)" type="text" name="protein_min_divisor" placeholder="--">
                                                   <p class="text-danger text-small" id="protein_min_divisorError"></p>
                                                </div>
                                             </td>
                                             <td> 
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input validatee" id="pname2"  onchange="autofill3(2)" type="text" name="protein_default_max" placeholder="--">
                                                   <label>%</label>
                                                   <p class="text-danger text-small" id="protein_default_maxError"></p>
                                                </div>
                                             </td>
                                             <td> 
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input validatee" type="text" id="pname8"  onchange="autofill3(8)" name="protein_max_divisor" placeholder="--"> 
                                                   <p class="text-danger text-small" id="protein_max_divisorError"></p>
                                                </div>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td>
                                                Carbs
                                             </td>
                                             <td>
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input validatee" id="pname3"  onchange="autofill3(3)" type="text" name="carb_default_min" placeholder="--">
                                                   <label>%</label>
                                                   <p class="text-danger text-small" id="carb_default_minError"></p>
                                                </div>
                                             </td>
                                             <td>
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input validatee" type="text" id="pname9"  onchange="autofill3(9)" name="carb_min_divisor" placeholder="--">
                                                   <p class="text-danger text-small" id="carb_min_divisorError"></p>
                                                </div>
                                             </td>
                                             <td> 
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input validatee" id="pname4"  onchange="autofill3(4)" type="text" name="carb_default_max" placeholder="--">
                                                   <label>%</label>
                                                   <p class="text-danger text-small" id="carb_default_maxError"></p>
                                                </div>
                                             </td>
                                             <td> 
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input validatee" type="text" id="pname10"  onchange="autofill3(10)" name="carb_max_divisor" placeholder="--">
                                                   <p class="text-danger text-small" id="carb_max_divisorError"></p>
                                                </div>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td>
                                                Fat
                                             </td>
                                             <td>
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input validatee" id="pname5"  onchange="autofill3(5)" type="text" name="fat_default_min" placeholder="--">
                                                   <label>%</label>
                                                   <p class="text-danger text-small" id="fat_default_minError"></p>
                                                </div>
                                             </td>
                                             <td>
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input validatee" type="text" id="pname11"  onchange="autofill3(11)" name="fat_min_divisor" placeholder="--">
                                                   <p class="text-danger text-small" id="fat_min_divisorError"></p>
                                                </div>
                                             </td>
                                             <td> 
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input validatee" id="pname6"  onchange="autofill3(6)" type="text" name="fat_default_max" placeholder="--">
                                                   <label>%</label>
                                                   <p class="text-danger text-small" id="fat_default_maxError"></p>
                                                </div>
                                             </td>
                                             <td> 
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input validatee" type="text" id="pname12"  onchange="autofill3(12)" name="fat_max_divisor" placeholder="--">
                                                   <p class="text-danger text-small" id="fat_max_divisorError"></p>
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
                                                Min % of Calorie / <span class="editable_span" id="span7"></span>
                                             </td> 
                                             <td>
                                                Max % of Calorie / <span class="editable_span" id="span8"></span>
                                             </td> 
                                             <td>
                                                (<span id="span1" class="editable_span"> </span><span class="editable_span">%</span> of calorie / <span class="editable_span" id="span117"></span> to <span id="span2" class="editable_span"> </span><span class="editable_span">%</span> of Calorie / <span class="editable_span" id="span118"></span> )
                                             </td> 
                                          </tr> 
                                          <tr>
                                             <td>
                                                Carbs 
                                             </td> 
                                             <td>
                                                Min % of Calorie / <span class="editable_span" id="span9"></span>
                                             </td>
                                             <td>
                                                Max % of Calorie / <span class="editable_span" id="span10"></span>
                                             </td> 
                                             <td>
                                                (<span id="span3" class="editable_span"> </span><span class="editable_span">%</span> of calorie / <span class="editable_span" id="span119"></span> to <span id="span4" class="editable_span"> </span><span class="editable_span">%</span> of Calorie / <span class="editable_span" id="span1110"></span> )
                                             </td> 
                                          </tr>
                                          <tr>
                                             <td>
                                                Fat
                                             </td> 
                                             <td>
                                                Min % of Calorie / <span class="editable_span" id="span11"></span>
                                             </td> 
                                             <td>
                                                Max % of Calorie / <span class="editable_span" id="span12"></span>
                                             </td> 
                                             <td>
                                                (<span id="span5" class="editable_span"> </span><span class="editable_span">%</span> of calorie / <span class="editable_span" id="span1111"></span> to <span id="span6" class="editable_span"> </span><span class="editable_span">%</span> of Calorie / <span class="editable_span" id="span1112"></span> )
                                             </td> 
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                              <div class="form-group col-6 text-end">
                                 <button type="button" class="comman_btn" onclick="validate(this)">Save</button> 
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
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.dropify').dropify();
    </script>
      @endsection
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script>
 $(window).load(function(){
   setTimeout(function(){ $('.alert-success').fadeOut('slow') }, 5000);
});
  </script>

    <script>

function autofill3(count){
var inps = document.getElementById('pname'+ count).value;

 document.getElementById('span'+count).innerText=inps;
 document.getElementById('span11'+count).innerText=inps;

 

// var add = parseInt(number1)+parseInt(number2);
// var mul = add/2
         // console.log(key);
//   document.getElementById('field'+count).value= mul;
  
    }
</script>
    <script>
            function validate(obj) {
            $(".text-danger").html('');
            var flag = true;
            var formData = $("#addForm").find(".validate:input").not(':input[type=button]');
            var formDataa = $("#addForm").find(".validatee:input").not(':input[type=button]');
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
            $(formDataa).each(function () {
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
