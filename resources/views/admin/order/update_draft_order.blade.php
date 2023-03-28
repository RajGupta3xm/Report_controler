<form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" action="{{url('admin/draftOrder/edit_update',$clients->id)}}" method="post" id="editForm">
    @csrf
               <div class="form-group col-6">
                  <label for="">Meal Plan Name</label>
                  <input type="text" class="form-control" value="{{$clients->id}}" name="name" id="name">
               </div>
             
               <div class="form-group col-6">
                  <label for="">Diet Plan Type</label>
                  <input type="text" class="form-control" value="{{$dietPlans->name}}" name="name" id="name">
               </div>
               <div class="form-group col-6">
                  <label for="">Date</label>
                  <input type="text" class="form-control" value="{{$clients->cancel_or_delivery_date}}" name="name" id="name">
               </div>
               <div class="form-group col-6">
                  <label for="">Time Slot</label> 
                  <select class="form-control form-select" aria-label="Default select example">
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