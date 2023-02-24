<form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" action="{{url('admin/mealplanvariants/edit_update',$clients->id)}}" method="post">
    @csrf
    <div class="row">
        <div class="col-6 pb-4">
            <div class="form-group-row">
                <label for="">VARIANT Name</label>
                <input class="form-control" type="text" name="variant_name" id="variant_name" value="{{$clients->variant_name}}">
            </div>
        </div>
        <div class="col-6 pb-4">
            <div class="form-group-row">
                <label for="">DIET PLAN</label>
                <select class="form-select" aria-label="Default select example" data-placeholder="Please Select Slot" name="diet_plan">
                    @foreach(\App\Models\DietPlanType::get() as $value)
                        <option value="{{$value->id}}" @if($clients->diet_plan_id == $value->id) selected @endif>{{$value->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-6 pb-4">
            <div class="form-group-row">
                <label for="">MEAL GROUP</label>
               @php $devices = explode(",", $clients->meal_group_name); @endphp
                <select class="form-select multiple-select-custom-field" aria-label="Default select example" data-placeholder="Please Select Slot" multiple name="staff_ids[]">
                    @foreach(\App\Models\MealSchedules::get() as $value)
                        <option value="{{$value->name}}"@if(is_array($devices))@if(in_array($value->name,$devices)) selected @endif @endif>{{$value->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-6 pb-4">
            <div class="form-group-row">
                <label for="">OPTION 1</label>
                <select class="form-select option1" aria-label="Default select example" name="option1" id="option1_value">
                    <option value="">Select Text</option>
                    <option value="weekly" @if($clients->option1 == "weekly") selected @endif>Weekly</option>
                    <option value="monthly" @if($clients->option1 == "monthly") selected @endif>Monthly</option>
                </select>
            </div>
        </div>
        <div class="col-6 pb-4">
            <div class="form-group-row">
                <label for="">OPTION 2</label>
                <select class="form-select option2" aria-label="Default select example" name="option2" id="option2_value">
                    <option value="">Select Text</option>
                    <option value="weekend" data-id="With Weekend" @if($clients->option2 == "weekend") selected @endif>With Weekend</option>
                    <option value="withoutweekend" data-id="Without Weekend" @if($clients->option2 == "withoutweekend") selected @endif>Without Weekend</option>
                </select>
            </div>
        </div>
        <div class="col-6 pb-4">
            <div class="form-group-row">
                <label for="">NO.OF DAYS</label>
                <input class="form-control serving_calorie" type="text" name="no_of_days" id="no_of_days" value="{{$clients->no_days}}">
            </div>
        </div>
        <div class="col-6 pb-4">
            <div class="form-group-row">
                <label for="">CALORIE</label>
                <select class="form-select" aria-label="Default select example" name="calorie" id="calorie_value">
                    <option value="">Select Text</option>
                    <option value="1000" @if($clients->calorie == "1000") selected @endif>1000 cal</option>
                    <option value="1200" @if($clients->calorie == "1200") selected @endif>1200 cal</option>
                    <option value="1500" @if($clients->calorie == "1500") selected @endif>1500 cal</option>
                    <option value="1800" @if($clients->calorie == "1800") selected @endif>1800 cal</option>
                    <option value="2000" @if($clients->calorie == "2000") selected @endif>2000 cal</option>
                </select>
            </div>
        </div>
        <div class="col-6 pb-4">
            <div class="form-group-row">
                <label for="">SERVING CALORIE</label>
                <input class="form-control" type="text" name="serving_calorie" id="serving_calorie_value" value="{{$clients->serving_calorie}}" >
            </div>
        </div>
        <div class="col-6 pb-4">
            <div class="form-group-row">
                <label for="">DELIVERY PRICE</label>
                <input class="form-control " type="text" name="delivery_price" id="delivery_price_value" value="{{$clients->delivery_price}}">
            </div>
        </div>
        <div class="col-6 pb-4">
            <div class="form-group-row">
                <label for="">PLAN ENTER PRICE</label>
                <input class="form-control " type="text" name="plan_price" id="plan_price_value" value="{{$clients->plan_price}}">
            </div>
        </div>
        <div class="col-6 pb-4">
            <div class="form-group-row">
                <label for="">COMPARE PRICE</label>
                <input class="form-control " type="text" name="compare_price" id="compare_price_value" value="{{$clients->compare_price}}">
            </div>
        </div>
        <div class="col-6 pb-4">
            <div class="form-group-row">
                <label for="">DESCRIPTION</label>
                <input class="form-control" type="text" placeholder="ENTER YOUR CUSTOM TEXT" name="description" id="description_value" value="{{$clients->custom_text}}">
            </div>
        </div>
        <div class="col-6 pb-4">
            <div class="form-group-row-auto">
                <button class="comman_btn">Save</button>
            </div>
        </div>
    </div>
</form>
