@extends('admin.layout.master')
@section('content')
      <div class="admin_main">
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
               <div class="row report-management justify-content-center">
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
                        <div class="col-12 design_outter_comman shadow">
                           <div class="row comman_header justify-content-between">
                              <div class="col-auto">
                                 <h2>Draft Order Edit</h2>
                              </div> 
                              <div class="col-auto Package_expiree">
                                 <h2>Package Will Expire On : <span>{{\Carbon\Carbon::parse($subscription_detail->end_date)->format('d/m/Y')}}</span></h2>
                              </div> 
                           </div>
                           <div class="row">
                              <div class="col-12 px-3 py-4">
                                 <div class="row draftorder_edit">
                                    <div class="col-4 border-end draftorder_heading mb-4 justify-content-center text-center d-flex align-items-center">
                                       <h2>Diet Plan Type :</h2> <span>{{$dietPlans->name}}</span>
                                    </div>
                                    <div class="col-4 border-end draftorder_heading mb-4 justify-content-center text-center d-flex align-items-center">
                                       <h2>Meal Plan Type :</h2> <span>{{$clients->plan_name}}</span>
                                    </div>
                                    <div class="col-4 draftorder_heading mb-4 justify-content-center text-center d-flex align-items-center">
                                       <h2>Package Info :</h2> <span>With Weekend</span>
                                    </div>
                                    <div class="col-12 draftorder_heading justify-content-start text-start d-flex align-items-center mb-4">
                                       <div class="row bg-light rounded border w-100 py-4 px-4 mx-0">
                                          <div class="col-12 mb-3">
                                             <h2>Default Meals :</h2> 
                                          </div>
                                          <div class="col-3">
                                             <div class="Default_Meals_box">
                                                @foreach($category as $key=>$categories)
                                                @if($key == 0)
                                                <h3>{{$categories->meal_group->name}}</h3>
                                                @endif
                                                @endforeach
                                                 <ul>
                                                 @foreach($category as $key=>$categories)
                                                 @foreach($categories['meal_group']['meals'] as $v=>$meal)
                                                 @if($key == 0)
                                                   <li>{{$meal->name}}</li>
                                                   @endif
                                                   @endforeach
                                                   @endforeach
                                                 </ul>
                                             </div>
                                          </div>
                                          <div class="col-3">
                                             <div class="Default_Meals_box">
                                             @foreach($category as $key=>$categories)
                                                @if($key == 1)
                                                <h3>{{$categories->meal_group->name}}</h3>
                                                @endif
                                                @endforeach
                                                <ul>
                                                @foreach($category as $key=>$categories)
                                                 @foreach($categories['meal_group']['meals'] as $v=>$meal)
                                                 @if($key == 1)
                                                   <li>{{$meal->name}}</li>
                                                   @endif
                                                   @endforeach
                                                   @endforeach
                                                 </ul>
                                             </div>
                                          </div>
                                          <div class="col-3">
                                             <div class="Default_Meals_box">
                                             @foreach($category as $key=>$categories)
                                                @if($key == 2)
                                                <h3>{{$categories->meal_group->name}}</h3>
                                                @endif
                                                @endforeach
                                                <ul>
                                                @foreach($category as $key=>$categories)
                                                 @foreach($categories['meal_group']['meals'] as $v=>$meal)
                                                 @if($key == 2)
                                                   <li>{{$meal->name}}</li>
                                                   @endif
                                                   @endforeach
                                                   @endforeach
                                                 </ul>
                                             </div>
                                          </div>
                                          <div class="col-3">
                                             <div class="Default_Meals_box">
                                             @foreach($category as $key=>$categories)
                                                @if($key == 3)
                                                <h3>{{$categories->meal_group->name}}</h3>
                                                @endif
                                                @endforeach
                                                <ul>
                                                @foreach($category as $key=>$categories)
                                                 @foreach($categories['meal_group']['meals'] as $v=>$meal)
                                                 @if($key == 3)
                                                   <li>{{$meal->name}}</li>
                                                   @endif
                                                   @endforeach
                                                   @endforeach
                                                 </ul>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div>
                                    <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" action="{{url('admin/draftOrder/edit_update',$clients->id)}}" method="post" id="editForm">
                                    @csrf
                                    <div class="col-6">
                                          <div class="form-group">
                                          <input type="hidden" class="form-control validate" value="{{$clients->user_id}}" name="user_id" id="name">
                                          <input type="hidden" class="form-control validate" value="{{$clients->plan_id}}" name="plan_id" id="name">
                                            <input type="hidden" class="form-control validate" value="{{$clients->variant_id}}" name="variant_id" id="name">
                                             <label for="">Date</label> 
                                             <input class="form-control" type="date" name="addOn_date">
                                          </div>
                                    </div>
                                    <div class="col-6"> 
                                          <div class="form-group">
                                             <label for="">Time Slot</label> 
                                             <input type="text" class="form-control" value="{{$clients->delivery_slot->name}} &nbsp; ({{$clients->delivery_slot->start_time}} - {{$clients->delivery_slot->end_time}})" readonly="true" name="name" id="name">
                                          </div>
                                    </div>
                                    <div class="col-12 text-center">
                                    <button class="comman_btn" type="button" onclick="validate(this);">update</button>
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
@endsection  
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script src="assets/vendor/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> 
<script src="assets/vendor/owl/owl.carousel.min.js"></script>  
<script src="{{asset('assets/js/comboTreePlugin.js')}}" type="text/javascript"></script> 
<script src="assets/js/main.js"></script>
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
    function validate(obj) {
        $(".text-danger").html('');
        var flag = true;
        var formData = $("#editForm").find(".validate:input").not(':input[type=button]');
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
            $("#editForm").submit();
        } else {
            return false;
        }


    }
</script>