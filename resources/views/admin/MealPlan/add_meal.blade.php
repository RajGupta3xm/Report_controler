@extends('admin.layout.master')
@section('content')
    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css" rel="stylesheet"/>
      <div class="admin_main">
         <div class="admin_main_inner">
             <div class="admin_panel_data height_adjust">
                 <div class="row addmeal_plann justify-content-center">
                     <div class="col-12">
                         <div class="row mx-0">
                             <div class="col-12 design_outter_comman shadow">
                                 <div class="row comman_header justify-content-between">
                                     <div class="col-auto">
                                         <h2>Add Meal Plan</h2> </div>
                                 </div>

                                     <form class="form-design py-4 px-4 row align-items-start justify-content-start" id="AddVariantsForms" action="{{url('admin/mealplan/submit')}}" enctype="multipart/form-data" method="post">
                                         @csrf
                                     <div class="col-md-12">
                                         <div class="row">
                                             <div class="form-group col-6">
                                                 <label for=""> Title (English) :</label>
                                                 <input type="text" class="form-control validate" value="" name="title" id="name" maxlength="20"> <p class="text-danger text-small" id="titleError" maxlength="20" ></p></div>
                                             <div class="form-group col-6">
                                                 <label for=""> Title (Arabic) :</label>
                                                 <input type="text" class="form-control validate" value="" name="title_ar" id="name" maxlength="20"> <p class="text-danger text-small" id="title_arError" maxlength="20"></p></div>
                                             <div class="form-group col-12 uploadimg_box"> <span>Media :</span>
                                                 <input type="file" id="uploadimg" class="validate dropify" name="images">

{{--                                                 <label for="uploadimg">--}}
{{--                                                     <div class="uploadimg_inner"> <i class="fas fa-upload me-2"></i> <span>Upload File</span> </div>--}}
{{--                                                 </label>--}}
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
                                                                             <option value="" disabled="" >Select Text</option>
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

                                     </div>
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
                                                 </tr>
                                                 </thead>
                                                 <tbody id="tbody">


                                                 </tbody>
                                             </table>
                                         </div>
                                     </div>
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

            // at least one checkbox checked...
            $('.option1').on('change',function(){
                var value=$(this).val();
                if(value=="weekly"){
                    var option2=$('.option2').find(":selected").data('id');
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
                    var option2=$('.option2').find(":selected").data('id');
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
                    }else if(option1=="month"){
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
                    if($('.meal_groups:checkbox:checked').length == 0){
                        alert('Please check meal group')
                    }else{
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
                                alert('Plan Added Successfully');
                                $('#DefaultSelection').html(data.html);
                                $('#variantsShow').css('display','block');
                                $('#tbody').append('<tr><td><div class="check_radio td_check_radio"><input type="checkbox" checked name="table2" id="table2" class="d-none"><label for="table2"></label></div></td><td>'+variant_name+'</td><td>'+diet_plan_id+'</td><td>'+meal_groups_hidden_name+'</td><td>'+ option1_value+'</td><td>'+option2_value+'</td><td>'+no_of_days+'</td><td>'+calorie_value+'</td><td>'+serving_calorie_value+'</td><td>'+delivery_price_value+'</td><td>'+plan_price_value+'</td><td>'+compare_price_value+'</td><td>'+description_value+'</td><input type="hidden" name="variant_name_hidden[]" value="'+variant_name+'"><input type="hidden" name="diet_plan_hidden[]" value="'+diet_plan+'"><input type="hidden" name="option1_hidden[]" value="'+option1_value+'"><input type="hidden" name="option2_hidden[]" value="'+option2_value+'"><input type="hidden" name="no_of_days_hidden[]" value="'+no_of_days+'"><input type="hidden" name="serving_calorie_hidden[]" value="'+serving_calorie_value+'"><input type="hidden" name="meal_groups_hidden_name[]" value="'+meal_groups_hidden_name+'"><input type="hidden" name="calorie_hidden[]" value="'+calorie_value+'"><input type="hidden" name="delivery_price_hidden[]" value="'+delivery_price_value+'"><input type="hidden" name="plan_price_hidden[]" value="'+plan_price_value+'"><input type="hidden" name="compare_price_hidden[]" value="'+compare_price_value+'"><input type="hidden" name="is_charge_vat_hidden[]" value="'+is_charge_vat+'"><input type="hidden" name="description_value_hidden[]" value="'+description_value+'"></tr>');
                            }
                        })
                    }

                }


            });

        });

    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $('.dropify').dropify();
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
            if (val == "" || val == "0" || val == null) {

                $("#" + name + "Error").html("This field is required");
                flag = false;


            } else {

            }
        });

        if (flag) {
            $("#AddVariantsForms").submit();
        } else {
            return false;
        }


    }
</script>


