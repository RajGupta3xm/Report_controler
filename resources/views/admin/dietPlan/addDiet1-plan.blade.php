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
                                       <input type="text" class="form-control validate" value="" name="name" id="name">
                                       <p class="text-danger text-small" id="nameError">
                                    </div> 
                                    <div class="form-group col-6">
                                       <label for=""> Title (Arabic) :</label>
                                       <input type="text" class="form-control validate" value="" name="name_ar" id="name">
                                       <p class="text-danger text-small" id="name_arError">
                                    </div> 
                                    <div class="form-group col-6 textarea_height">
                                       <label for="">Description (Englsih) :</label>
                                       <textarea class="form-control validate" name="description" id=""></textarea>
                                       <p class="text-danger text-small" id="descriptionError">
                                    </div>
                                    <div class="form-group col-6 textarea_height">
                                       <label for="">Description (Arabic) :</label>
                                       <textarea class="form-control validate" name="description_ar" id=""></textarea>
                                       <p class="text-danger text-small" id="description_arError">
                                    </div>
                                    <div class="form-group col-6 uploadimg_box">
                                       <span>Media (English):</span>
                                       <input type="file" id="uploadimg" name="image" class="d-none validate">
                                       <label for="uploadimg">
                                          <div class="uploadimg_inner">
                                             <i class="fas fa-upload me-2"></i>
                                             <span>Upload File</span>
                                          </div>
                                       </label>
                                       <p class="text-danger text-small" id="imageError">
                                    </div> 
                                    <div class="form-group col-6 uploadimg_box">
                                       <span>Media (Arabic):</span>
                                       <input type="file" id="uploadimg1" name="image_ar" class="d-none validate">
                                       <label for="uploadimg1">
                                          <div class="uploadimg_inner">
                                             <i class="fas fa-upload me-2"></i>
                                             <span>Upload File</span>
                                          </div>
                                       </label>
                                       <p class="text-danger text-small" id="image_arError">
                                    </div> 
                                 </div>
                              </div>  
                              <div class="col-12 comman_table_design New_tabledesign mb-4">
                                 <div class="table-responsive border rounded">
                                    <table class="table mb-0">
                                       <thead>
                                          <tr>
                                             <th>Macros</th>
                                             <th>Default</th>
                                             <th>Actual</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <tr>
                                             <td>
                                                Protein
                                             </td>
                                             <td>
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input" type="text" id="pname1"  onchange="autofill3(1)"  name="default_protein" placeholder="20-35">
                                                   <label>%</label>
                                                </div>
                                             </td>
                                             <td> 
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input" type="text" id='field1' name="actual_protein" readonly="true" placeholder="27.50">
                                                   <label>%</label>
                                                </div>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td>
                                                Carbs
                                             </td>
                                             <td>
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input" id="pname2"  onchange="autofill3(2)"  type="text" name="default_carb" placeholder="40-55">
                                                   <label>%</label>
                                                </div>
                                             </td>
                                             <td>
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input" type="text" id='field2' name="actual_carb" readonly="true" placeholder="47.50">
                                                   <label>%</label>
                                                </div>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td>
                                                Fat
                                             </td>
                                             <td>
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input" id="pname3"   onchange="autofill3(3)"  type="text" name="default_fat" placeholder="20-30">
                                                   <label>%</label>
                                                </div>
                                             </td>
                                             <td>
                                                <div class="form-group position-relative percentage_box mb-0">
                                                   <input class="form-control table_input" type="text" id='field3' name="actual_fat" readonly="true" placeholder="25">
                                                   <label>%</label>
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
                                    <div class="col-auto">
                                       <a class="edit_tables" onclick="testVariable()"  href="javscript:;">
                                          <i class="far fa-edit"></i>
                                       </a>
                                    </div>
                                 </div>
                                 <div class="table-responsive border rounded-bottom">
                                    <table class="table mb-0" id="bar"> 
                                       <tbody>
                                          <tr>
                                             <td>
                                                Protein Actual
                                             </td> 
                                             <td>
  
                                                Actual % of Calorie / <span id="demo1" class="editable_span">4</span><input id="total1" type="hidden" name="total1" value="">
                                             </td> 
                                             <td>
                                                (Normal ranges <span id="span1" class="editable_span"> </span><span class="editable_span">% </span> of calorie / <span class="editable_span">4</span> to <span id="span11" class="editable_span"> </span> <span class="editable_span">%</span> of Calorie / <span class="editable_span">4</span> )
                                             </td> 
                                          </tr> 
                                          <tr>
                                             <td>
                                                Carbs Actual 
                                             </td> 
                                             <td>
                                                Actual % of Calorie / <span id="demo2" class="editable_span">4</span><input id="total2" type="hidden" name="total2" value="">
                                             </td> 
                                             <td>
                                                (Normal ranges <span id="span2" class="editable_span"></span><span class="editable_span">% </span> of calorie / <span class="editable_span">4</span> to <span id="span12" class="editable_span"></span><span class="editable_span">% </span> of Calorie / <span class="editable_span">4</span> )
                                             </td> 
                                          </tr>
                                          <tr>
                                             <td>
                                                Fat Actual
                                             </td> 
                                             <td>
                                                Actual % of Calorie / <span id="demo3" class="editable_span">9</span><input id="total3" type="hidden" name="total3" value="">
                                             </td> 
                                             <td>
                                                (Normal ranges <span id="span3" class="editable_span"></span><span class="editable_span">% </span> of calorie / <span class="editable_span">9</span> to <span id="span13" class="editable_span"></span><span class="editable_span">% </span> of Calorie / <span class="editable_span">9</span> )
                                             </td> 
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                              <div class="form-group col-6 text-end">
                                 <button type="button"  onclick="validate(this)" class="comman_btn">Save</button> 
                              </div> 
                              <div class="form-group col-6 text-start">  
                                 <button  class="comman_btn bg-red">Close</button>
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
          function testVariable() {
            alert('ff');
        // $('#demo1').html("<span >"  + 
        // [text here]+ "</span>");
        var data1 = document.getElementById('demo1').innerText;
        var data2 = document.getElementById('demo2').innerText;
        var data3 = document.getElementById('demo3').innerText;
        $("#demo1").replaceWith('<input type="text" value='+data1+' style="width: 8%;" ></input>') 
        $("#demo2").replaceWith('<input type="text" value='+data2+' style="width: 8%;" ></input>') 
        $("#demo3").replaceWith('<input type="text" value='+data3+' style="width: 8%;" ></input>') 
     
        }
</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script>
 $(window).load(function(){
   setTimeout(function(){ $('.alert-success').fadeOut('slow') }, 5000);
});
  </script>
<script>
window.onload = function() {
 
 var span1 = document.getElementById('demo1');
 var span2 = document.getElementById('demo2');
 var span3 = document.getElementById('demo3');
 var data1 = span1.innerText;
 var data2 = span2.innerText;
 var data3 = span3.innerText;
 document.getElementById('total1').value= data1;
 document.getElementById('total2').value= data2;
 document.getElementById('total3').value= data3;

};
       
</script>

    <script>

function autofill3(count){
var inps = document.getElementById('pname'+ count).value;
//  var data = inps.replace(inps[1], '+');
var data = inps.split('-');
 var number1 = data[0];
 var number2 = data[1];
 document.getElementById('span'+count).innerText=number1;
 document.getElementById('span1'+count).innerText=number2;

var add = parseInt(number1)+parseInt(number2);
var mul = add/2
         // console.log(key);
  document.getElementById('field'+count).value= mul;
  







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
