@extends('admin.layout.master')
@section('content')
      <div class="admin_main">
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
               <div class="row promo-code-management justify-content-center">
                  <div class="col-12"> 
                     <div class="row mx-0"> 
                     @if(session()->has('success'))
                <div class="alert alert-success">
                    <strong class="close" data-dismiss="alert" aria-hidden="true"></strong>
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
                   @if(Session::get('admin_logged_in')['type']=='0')
                        <div class="col-12 design_outter_comman overflow-visible shadow mb-4">
                           <div class="row comman_header justify-content-between">
                              <div class="col-auto">
                                 <h2>Add New Promo Code</h2>
                              </div> 
                           </div>
                           <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/promoCode_submit')}}">  
                           {{ csrf_field() }}  
                              <div class="form-group col-6">
                                 <label for="">Promo Code</label>
                                 <input type="text" class="form-control validate" value="" name="promo_name" id="name">
                                 <p class="text-danger text-small" id="promo_nameError"></p>
                              </div>
                              <div class="form-group col-6 choose_file position-relative">
                                 <span>Upload Image</span>
                                 <label for="upload_video"><i class="fal fa-camera me-1"></i>Choose File</label>
                                 <input type="file" class="form-control validate" value="" name="image" id="upload_video">
                                 <p class="text-danger text-small" id="imageError"></p>
                              </div>
                              <div class="form-group col-6">
                                 <div class="row align-items-end">
                                    <div class="col-auto">
                                       <a class="change_value" onclick="toggleVisibility('Menu1');" href="javascript:;">Discount</a>
                                       <a class="change_value" onclick="toggleVisibility('Menu2');" href="javascript:;">Price</a>
                                    </div>
                                    <div id="Menu1" class="col form-group position-relative percentage_icons mb-0">
                                       <label for="">Discount %</label>
                                       <input class="form-control" type="text" value="" name="discount">
                                       <div class="icon">%</div>
                                    </div>
                                    <div id="Menu2" class="form-group mb-0 col" style="display: none;">
                                       <label for="">Price</label>
                                       <input type="text" class="form-control" value="" name="price" id="name">
                                    </div>
                                 </div>
                             </div> 
                              <div class="form-group col-3">
                                 <label for="">Valid From</label>
                                 <input type="datetime-local" id="dateInput" class="form-control validate" name="valid_from" >
                                 <p class="text-danger text-small" id="valid_fromError"></p>
                              </div>
                              <div class="form-group col-3">
                                 <label for="">Valid Till</label>
                                 <input type="datetime-local" class="form-control validate"  name="valid_till">
                                 <p class="text-danger text-small" id="valid_tillError"></p>
                              </div>
                              <div class="form-group col-3 position-relative">
                                 <label for="">Select Meal Plan</label>  
                                 <div class="custom_dropdown">
                                    <input class="form-control open_select" type="text" placeholder="Select Meal">
                                    <i class="far fa-angle-down arrow_set"></i>
                                    <div class="custom_dropdown_inner">
                                       <div class="searchbar">
                                          <input class="form-control" type="text" placeholder="Search">
                                       </div>
                                       <div class="custom_dropdown_checkbox">
                                          <div class="accordion" id="accordionExample">
                                          @foreach($plan as $key=>$plans)
                                             <div class="accordion-item mt-2">
                                               <h2 class="accordion-header" id="headingOne_<?=$key?>">
                                                 <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_<?=$key?>" aria-expanded="true" aria-controls="collapseOne_<?=$key?>">
                                                    <div class="form-group d-flex align-items-center mb-0">
                                                       <input type="checkbox" id="q{{$key}}" name="plan_id[{{$plans->id}}]">
                                                       <label class="mb-0 ms-2" for="q{{$key}}">{{$plans->name}}</label>
                                                    </div>
                                                 </button>
                                               </h2>
                                               <div id="collapseOne_<?=$key?>" class="accordion-collapse collapse " aria-labelledby="headingOne_<?=$key?>" data-bs-parent="#accordionExample">
                                                 <div class="accordion-body">
                                                 @foreach($plans->variant as $k=>$variants)
                                                   <div class="form-group d-flex align-items-center mb-1">
                                                      <input type="checkbox" id="v{{$k}}" name="variant_id[{{$variants->id}}]">
                                                      <label class="mb-0 ms-2" for="v{{$k}}">{{$variants->variant_name}}</label>
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
                              <div class="form-group col-6 setup_pricing maximum_discount">
                                 <span for="">Maximum Discount Uses</span>
                                 <div class="row">
                                    <div class="col-12 mb-2 d-flex select_tr">
                                       <div class="check_radio">
                                          <input type="checkbox" checked="" name="v2" id="y2" class="d-none">
                                          <label for="y2">Limit number of times this Discount can be used in total</label>
                                       </div> 
                                       <input class="form-control width_manage" type="text" id="" name="maximum_discount_uses">
                                    </div>
                                    <div class="col-12">
                                       <div class="check_radio">
                                          <input type="checkbox" name="v4" id="t4" value="1" class="d-none">
                                          <label for="t4">Limit to one use per customer</label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group mb-0 col-12 text-center">
                              <button type="button" class="comman_btn" onclick="validate(this);">Save</button>
                              </div>
                           </form>
                        </div>
                        @endif
                      @if(Session::get('admin_logged_in')['type']=='1')
                         @if(Session::get('staff_logged_in')['promo_code_mgmt']!='1')
                        <div class="col-12 design_outter_comman shadow mb-4">
                           <div class="row comman_header justify-content-between">
                              <div class="col-auto">
                                 <h2>Add New Promo Code</h2>
                              </div> 
                           </div>
                           <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/promoCode_submit')}}">  
                           {{ csrf_field() }}  
                              <div class="form-group col-6">
                                 <label for="">Promo Code</label>
                                 <input type="text" class="form-control validate" value="" name="promo_name" id="name">
                                 <p class="text-danger text-small" id="promo_nameError"></p>
                              </div>
                              <div class="form-group col-6 choose_file position-relative">
                                 <span>Upload Image</span>
                                 <label for="upload_video"><i class="fal fa-camera me-1"></i>Choose File</label>
                                 <input type="file" class="form-control validate" value="" name="image" id="upload_video">
                                 <p class="text-danger text-small" id="imageError"></p>
                              </div>
                              <div class="form-group col-6">
                                 <div class="row align-items-end">
                                    <div class="col-auto">
                                       <a class="change_value" onclick="toggleVisibility('Menu1');" href="javascript:;">Discount</a>
                                       <a class="change_value" onclick="toggleVisibility('Menu2');" href="javascript:;">Price</a>
                                    </div>
                                    <div id="Menu1" class="col form-group position-relative percentage_icons mb-0">
                                       <label for="">Discount %</label>
                                       <input class="form-control" type="text" value="" name="discount">
                                       <div class="icon">%</div>
                                    </div>
                                    <div id="Menu2" class="form-group mb-0 col" style="display: none;">
                                       <label for="">Price</label>
                                       <input type="text" class="form-control" value="" name="price" id="name">
                                    </div>
                                 </div>
                             </div> 
                              <div class="form-group col-3">
                                 <label for="">Valid From</label>
                                 <input type="datetime-local" class="form-control validate" name="valid_from">
                                 <p class="text-danger text-small" id="valid_fromError"></p>
                              </div>
                              <div class="form-group col-3">
                                 <label for="">Valid Till</label>
                                 <input type="datetime-local" class="form-control validate"  name="valid_till">
                                 <p class="text-danger text-small" id="valid_tillError"></p>
                              </div>
                            
                              <div class="form-group col-6 setup_pricing maximum_discount">
                                 <span for="">Maximum Discount Uses</span>
                                 <div class="row">
                                    <div class="col-12 mb-2 d-flex select_tr">
                                       <div class="check_radio">
                                          <input type="checkbox" checked="" name="v2" id="v2" class="d-none">
                                          <label for="v2">Limit number of times this Discount can be used in total</label>
                                       </div> 
                                       <input class="form-control width_manage" type="text" id="" name="maximum_discount_uses">
                                    </div>
                                    <div class="col-12">
                                       <div class="check_radio">
                                          <input type="checkbox" name="v4" id="v4" value="1" class="d-none">
                                          <label for="v4">Limit to one use per customer</label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group mb-0 col-12 text-center">
                              <button type="button" class="comman_btn" onclick="validate(this);">Save</button>
                              </div>
                           </form>
                        </div>
                        @endif
                        @endif
                        <div class="col-12 design_outter_comman shadow">
                           <div class="row comman_header justify-content-between">
                              <div class="col-auto">
                                 <h2>Promo Code Management</h2>
                              </div>
                              <div class="col-4 d-flex align-items-center">
                              <a href="javscript:;"  class="comman_btn yellow-btn me-0" onclick="printPromoList()">print</a> 
                              <a href="<?= url('admin/promo-code-management') ?>" class="comman_btn me-2">Reset</a>
                                 <!-- <form class="form-design" action="">
                                    <div class="form-group mb-0 position-relative icons_set">
                                       <input type="text" class="form-control" placeholder="Search" name="name" id="name">
                                       <i class="far fa-search"></i>
                                    </div>
                                 </form> -->
                              </div>
                           </div>
                           <form method="post" class="form-design py-4 px-3 row align-items-end justify-content-between" action="{{route('admin.user.filter')}}">
                              @csrf
                              <div class="form-group mb-0 col-5">
                                 <label for="">From</label>
                                 <input type="datetime-local" onchange="$('#start_date').attr('min', $(this).val());" max="<?= date('Y-m-d') ?>"  value="{{isset($start_date)?$start_date:''}}"  name="start_date" class="form-control">
                              </div>
                              <div class="form-group mb-0 col-5">
                                 <label for="">To</label>
                                 <input type="datetime-local" id="start_date" name="end_date" max="<?= date('Y-m-d') ?>" value="{{isset($end_date)?$end_date:''}}" class="form-control">
                              </div> 
                              <div class="form-group mb-0 col-auto">
                                 <button  href="#filter" onclick="filterList(this)"; class="comman_btn">Search</button>
                              </div> 
                           </form>
                           <div class="row">
                              <div class="col-12 comman_table_design px-0">
                                 <div class="table-responsive">
                                    <table class="table mb-0" id="example1">
                                       <thead>
                                         <tr>
                                           <!-- <th>
                                             <form class="table_btns d-flex align-items-center justify-content-center"> 
                                                <div class="check_radio">
                                                   <input type="checkbox" name="table1" id="table1" class="d-none">
                                                   <label for="table1"></label>
                                                </div>
                                             </form>
                                          </th> -->
                                          <th>Promo Code</th>
                                          <th>Image</th>
                                          <th>Discount %</th>
                                          <th>Price</th>
                                          <th>Meal Plan</th>
                                          <th>Valid From</th> 
                                          <th>Valid Till</th>
                                          <th>NO. OF CODE USED</th>
                                          <th>Total Value</th>
                                          @if(Session::get('admin_logged_in')['type']=='0')
                                          <th>Status</th>
                                          <th>Action</th>
                                          @endif
                                          @if(Session::get('admin_logged_in')['type']=='1')
                                           @if(Session::get('staff_logged_in')['promo_code_mgmt']!='1')
                                          <th>Status</th>
                                          <th>Action</th>
                                          @endif
                                          @endif
                                         </tr>
                                       </thead>
                                       <tbody>
                                        @foreach($promoCode as $promoCodes)
                                     
                                         <tr>
                                           <!-- <td>
                                             <form class="table_btns d-flex align-items-center justify-content-center"> 
                                                <div class="check_radio td_check_radio">
                                                   <input type="checkbox" checked name="table2" id="table2" class="d-none">
                                                   <label for="table2"></label>
                                                </div>
                                             </form>
                                           </td> -->
                                           
                                           <td>{{$promoCodes->name ?? 'N/A'}}</td>
                                           <td><img class="table_img" src="{{$promoCodes->image?$promoCodes->image:asset('assets/img/bg-img.jpg')}}" alt=""></td>
                                           <td>{{$promoCodes->discount ?? 'N/A'}}</td>
                                           <td>{{$promoCodes->price ?? 'N/A'}}</td>
                                           <td>{{$promoCodes->promoCodeDietPlan['plan']['name']}}</td>
                                           <td> 
                                             {{date('d/m/Y', strtotime($promoCodes->start_date))}}
                                             <br>
                                             {{date('g:i A', strtotime($promoCodes->start_date))}}
                                           </td> 
                                           <td>
                                           {{date('d/m/Y', strtotime($promoCodes->end_date))}}
                                             <br>
                                             {{date('g:i A', strtotime($promoCodes->end_date))}}
                                          </td> 
                                      
                                           <td>{{$promoCodes->promo_code_used_count}}</td>
                                      
                                           <td>{{$promoCodes->totalValue}}</td>
                                           @if(Session::get('admin_logged_in')['type']=='0')
                                           <td>
                                           <div class="mytoggle">
                                             <label class="switch">
                                             <input type="checkbox" onchange="changeStatus(this, '<?= $promoCodes->id ?>');" <?= ( $promoCodes->status == 'active' ? 'checked' : '') ?> ><span class="slider round"> </span> 
                                             </label>
                                          </div>
                                           </td>
                                           <td>
                                           <a class="comman_btn table_viewbtn delete_btn" onclick="deleteData(this,'{{$promoCodes->id}}');" href="javscript:;">Delete</a>
                                           </td>
                                           @endif
                                           @if(Session::get('admin_logged_in')['type']=='1')
                                           @if(Session::get('staff_logged_in')['promo_code_mgmt']!='1')
                                           <td>
                                           <div class="mytoggle">
                                             <label class="switch">
                                             <input type="checkbox" onchange="changeStatus(this, '<?= $promoCodes->id ?>');" <?= ( $promoCodes->status == 'active' ? 'checked' : '') ?> ><span class="slider round"> </span> 
                                             </label>
                                          </div>
                                           </td>
                                           <td>
                                           <a class="comman_btn table_viewbtn delete_btn" onclick="deleteData(this,'{{$promoCodes->id}}');" href="javscript:;">Delete</a>
                                           </td>
                                           @endif
                                           @endif
                                         </tr> 
                                         @endforeach
                                    
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
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="assets/vendor/jquery.min.js"></script>
      <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> 
      <script src="assets/vendor/owl/owl.carousel.min.js"></script>  
      <script src="{{asset('assets/js/comboTreePlugin.js')}}" type="text/javascript"></script> 
      <script src="assets/js/main.js"></script>
      <script>
 var today = new Date().toISOString().slice(0, 16);
document.getElementsByName("valid_from")[0].min = today;
     </script>
     <script>
 var today = new Date().toISOString().slice(0, 16);
document.getElementsByName("valid_till")[0].min = today;
     </script>
      <script>
         $('.open_select').click(function(e) {
             $('.custom_dropdown').toggleClass('show');
             $(this).parent().toggleClass('active');
         });  

         $(document).ready(function() {
            $('#select-all').click(function() {
                  var checked = this.checked;
                  $('#collapsefive input[type="checkbox"]').each(function() {
                  this.checked = checked;
               });
            }) 
         });


     </script> 
   
       <!-- multiple Checkbox slider  -->
       <script type="text/javascript">
var subcategory =<?= \GuzzleHttp\json_encode($plan)?>;
var result = category.map(e => {
    e.subCategories = subcategory.filter(a => a.meal_plan_id == e.id);
    return e;
   })
   $(category).each(function(k,g){
   console.log(g.name);
   var SampleJSONData = [{ 
            id: 09,
            title: g.name,
               subs: [{
                  id: 10,
                  title: 'variant 1'
               }
                  
               ] 
        
         }];

        
      
 
         var comboTree1, comboTree2;
         jQuery(document).ready(function($) { 
            comboTree3 = $('#justAnInputBox1').comboTree({
               source: SampleJSONData,
               isMultiple: true,
               cascadeSelect: true,
               collapse: false
            });
        
         });
   })

     
      </script>
      <!-- multiple Checkbox slider  -->
      <script>
      //     function getSubcategory(obj) {
      //       var id = $(obj).val();
      //       $("#AddContainer").empty();
      //    $.ajax({
      //   type : 'get',
      //   url  : "<?= url('admin/get_subcategory/') ?>/" + id,
      //   data : {'id':id},
      //   success:function(data){
      //       console.log(data);
      //        $(data).each(function (i,v) {
      //          alert(v.variant_name);
      //          $('.select-ajax').append('<option  value='+ v.variant_name +' > '+v.variant_name+ '</option>');
      //       });
      //   }
      // });
      //   }
// function getSubcategory(obj) {
// var category = $(obj).val();
// var newCategoryArray = category.map(v => {
//   var sub = [];
//   subcategory.forEach(i => {
//    console.log(v);
//     if(i.meal_plan_id == v){
//       sub.push(i);
//     }
//   })
//   v.subcategory = sub;
//  console.log(sub);
// });
// }
// const result = category.map(e => {
//     e.subCategories = subcategory.filter(a => a.meal_plan_id == e);
//     console.log(e);
// })


// }
function getSubcategory(obj) {

// var result = category.map(e => {
//     e.category = subcategory.filter(a => a.meal_plan_id == e.id);
//     return e;
// })
// $(result).each(function(k,g){

//       console.log(g.category);

// })



}
    </script>
<!-- <script>

function getSubcategory(obj) {
   $("#AddContainer").empty();
   // $('.select-ajax option').remove();
   // document.getElementById("AddContainer").options.length = 0;
   // $('#AddContainer').find('option:not(:selected)').remove();
   var brand_id = $(obj).val();
   var result = Object.entries(brand_id);
   $(result).each(function (i, v) {
         alert(i.v);
      $(variant).each(function (j, val) {
         // if (val.id == v) {


         //    }
            });
            });
   // var ingredientId =$('#selUser').find('option:selected').val();
   //  $(allList).each(function (a, plan_variant) {
   //             if (ingredientId == plan_variant.meal_plan_id) {
   //                $.each(plan_variant, function (key, value) {
   //                if(key=='id'){
   //                alert(value);
   //                  $('.select-ajax').append('<option  value='+ value +' > '+value+ '</option>');
   //                }
   //             })
   //              } 
   //          });

}
</script> -->
      <script>
       function filterList(obj){
        if ($(':input[name=start_date]').val() == '' && $(':input[name=end_date]').val() == ''){
        $("#formError").html('Select filter attribute');
        } else{

        if ($(':input[name=start_date]').val() != '' && $(':input[name=end_date]').val() != ''){
        $('form').submit();
        } else{
        if ($(':input[name=start_date]').val() != ''){
        $("#formError").html('End date is required');
        } else if ($(':input[name=end_date]').val() != ''){
        $("#formError").html('Start date is required');
        } else{
        $("#formError").html('Select filter attribute');
        }
        }
        }

        }
    
 </script>
 
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
   <script>
    $('.select_tr input:checkbox').change(function() {
  $(this).closest('.select_tr').find('input:not([type=checkbox])').prop("disabled", !this.checked);
  $(this).closest('.select_tr').find('input:not([type=checkbox])').val('');
});
  </script>
   @endsection

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

<script>
       function changeStatus(obj, id) {
            swal({
                title: "Are you sure?",
                text: " status will be updated",
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
                                var status = 'inactive';
                            }
                            if (id) {
                                $.ajax({
                                    url: "<?= url('admin/promoCode/change_status') ?>",
                                    type: 'post',
                                    data: 'id=' + id + '&action=' + status + '&_token=<?= csrf_token() ?>',
                                    success: function (data) {
                                    
                                        swal({
                                           title: "Success!",
                                            text : " Status has been Updated ",
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
      function deleteData(obj, id){
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
                        url : "<?= url('admin/promoCode-delete') ?>",
                        type : "POST",
                        data : 'id=' + id + '&_token=<?= csrf_token() ?>',
                        success: function(data){
                            swal({
                                title: "Success!",
                                text : "Promo code has been deleted \n Click OK to refresh the page",
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
<script>
    function printPromoList() {
        var printWindow = window.open('{{ route("promos.print") }}', 'PrintWindow', 'height=500,width=800');
        printWindow.print();
    }

</script>