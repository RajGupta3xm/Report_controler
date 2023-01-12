<form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" action="{{url('admin/fleetarea/edit_update',$clients->id)}}" method="post">
    @csrf
    <div class="form-group mb-0 col">
        <label for="">Area (En)</label>
        <input class="form-control" value="{{$clients->area}}" type="text"  name="area">
    </div>
    <div class="form-group mb-0 col">
        <label for="">Area (Ar)</label>
        <input class="form-control" value="{{$clients->area_ar}}" type="text" name="area_ar">
    </div>
    <div class="form-group mb-0 col">
        <label for="">Driver Group</label>
        <select class="form-select multiple-select-custom-field" aria-label="Default select example" data-placeholder="Please Select Slot" multiple name="staff_ids[]">
            @foreach(\App\Models\StaffMembers::wherehas('group',function ($q){
                                                            $q->where('name','=','Driver');
                                                        })->get() as $value)
                <option value="{{$value->id}}"@if(is_array(json_decode($clients->staff_ids)))@if(in_array($value->id,json_decode($clients->staff_ids))) selected @endif @endif>{{$value->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group mb-0 col">
        <label for="">Slot</label>
        <select class="form-select multiple-select-custom-field" aria-label="Default select example" data-placeholder="Please Select Slot" multiple name="delivery_slot_id[]">
            @foreach(\App\Models\DeliverySlot::get() as $value)
                <option value="{{$value->id}}" @if(is_array(json_decode($clients->delivery_slot_ids)))@if(in_array($value->id,json_decode($clients->delivery_slot_ids))) selected @endif @endif>{{$value->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group mb-0 col-auto">
        <button class="comman_btn">Save</button>
    </div>
</form>
