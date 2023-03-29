<form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" action="{{url('admin/draftOrder/edit_update',$clients->id)}}" method="post" id="editForm">
    @csrf
               <div class="form-group col-6">
                  <label for="">Meal Plan Name</label>
                  <input type="hidden" class="form-control validate" value="{{$clients->user_id}}" name="user_id" id="name">
                  <input type="hidden" class="form-control validate" value="{{$clients->plan_id}}" name="plan_id" id="name">
                  <input type="hidden" class="form-control validate" value="{{$clients->variant_id}}" name="variant_id" id="name">
                  <input type="text" class="form-control validate" value="{{$clients->plan_name}}" name="plan_name" id="name">
               </div>
             
               <div class="form-group col-6">
                  <label for="">Diet Plan Type</label>
                  <input type="text" class="form-control validate" value="{{$dietPlans->name}}" name="diet_plan_name" id="name">
               </div>
               <div class="form-group col-6">
                  <label for="">Date</label>
                  <input type="text" class="form-control validate" value="{{$clients->cancel_or_delivery_date}}" name="addOn_date" id="name">
               </div>
               <div class="form-group col-6">
                  <label for="">Time Slot</label> 
                  <select class="form-control form-select" aria-label="Default select example" name="time_slot">
                     <option selected>{{$clients->delivery_slot->name}} ({{$clients->delivery_slot->start_time}}- {{$clients->delivery_slot->end_time}})</option>
                     <option value="1">Afternoon (12 Noon - 04 PM)</option>
                     <option value="1">Evening (05 PM - 07 PM)</option>
                  </select>
               </div>
               <div class="form-group mb-0  mt-3 text-center col-12">
               <button class="comman_btn" type="button" onclick="validate(this);">update</button>
               </div>
            </form>


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