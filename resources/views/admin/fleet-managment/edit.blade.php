<form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" action="{{url('admin/fleetarea/edit_update',$clients->id)}}" method="post" id="editForm">
    @csrf
    <div class="form-group mb-0 col">
        <label for="">Area (En)</label>
        <input class="form-control validate" value="{{$clients->area}}" type="text"  name="area_edit">
        <p class="text-danger text-small" id="area_editError"></p>
    </div>
    <div class="form-group mb-0 col">
        <label for="">Area (Ar)</label>
        <input class="form-control validate" value="{{$clients->area_ar}}" type="text" name="area_ar_edit">
        <p class="text-danger text-small" id="area_ar_editError"></p>
    </div>
    <div class="form-group mb-0 col">
        <label for="">Driver Group</label>

        <select class="form-select form-control validate" aria-label="Default select example" name="staff_ids_edit">
            <option value="">Select Driver Group</option>
            @foreach(\App\Models\StaffMembers::wherehas('group',function ($q){
                                                           $q->where('name','=','Driver');
                                                       })->get() as $value)
                <option value="{{$value->id}}" @if($clients->staff_ids == $value->id)selected @endif>{{$value->name}}</option>
            @endforeach
        </select>
        <p class="text-danger text-small" id="staff_ids_editError"></p>
    </div>
    <div class="form-group mb-0 col">
        <label for="">Slot</label>
        <select class="form-select form-control validate" aria-label="Default select example" name="delivery_slot_id_edit">
            <option value="">Select Slot</option>
            @foreach(\App\Models\DeliverySlot::get() as $value)
                <option value="{{$value->id}}" @if($clients->delivery_slot_ids==$value->id) selected @endif>{{$value->name}}</option>
            @endforeach
        </select>
        <p class="text-danger text-small" id="delivery_slot_id_editError"></p>

    </div>
    <div class="form-group mb-0 col-auto">
        <button class="comman_btn" type="button" onclick="validate(this);">Save</button>
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
