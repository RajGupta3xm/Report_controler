<div class="col-12 comman_table_design mb-4 New_tabledesign">
    <div class="row mx-0">
        <div class="col-12 default_meal_selection border">
            <div class="row comman_header mx-0 justify-content-between rounded-top">
                <div class="col">
                    <h2>Default Meal Selection</h2>
                </div>
            </div>
            <div class="row mx-0">
                <div class="col-12 px-0 text-center">
                    <nav>
                        <div class="mealoutter_tabs nav nav-tabs border-0 justify-content-center shadow d-inline-flex" id="nav-tab" role="tablist">
                            @foreach($dates as $key=> $date)
                                <button class="nav-link @if($key==0)active @endif" id="nav-home-tab{{$key}}" data-bs-toggle="tab" data-bs-target="#nav-home{{$key}}" type="button" role="tab" aria-controls="nav-home" aria-selected="true" data-value="{{$date}}">
                                    {{\Carbon\Carbon::parse($date)->format('d-F')}}</button>
                            @endforeach
                        </div>
                    </nav>
                    <div class="tab-content mt-4" id="nav-tabContent">
                        @foreach($dates as $key=> $date)
                      
                        <div class="tab-pane fade @if($key==0)active show @endif" id="nav-home{{$key}}" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="row meal_innerpart justify-content-center">
                                <div class="col-12 text-center">
                                    <nav>
                                        <div class="nav nav-tabs justify-content-center mid_tabsdesign border-0" id="nav-tab" role="tablist">
                                            @foreach(\App\Models\DietPlanType::get() as $key1=>$value)
                                                <button class="nav-link @if($key1 == 0)active @endif shadow border-0" id="vj1" data-bs-toggle="tab" data-bs-target="#vj1{{$key}}{{$key1}}" type="button" role="tab" aria-controls="vj1-tab" aria-selected="false">{{$value->name}}</button>
                                            @endforeach
                                        </div>
                                    </nav>
                                    <div class="tab-content mt-4 pt-2" id="nav-tabContent">
                                        @foreach(\App\Models\DietPlanType::get() as $key2=>$value)
                                            <div class="tab-pane fade @if($key2 == 0)active show @endif" id="vj1{{$key}}{{$key2}}" role="tabpanel" aria-labelledby="vj1-tab">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <ul class="nav nav-tabs mealinner_tabs d-inline-flex justify-content-center rounded-pill shadow overflow-hidden" id="myTab" role="tablist">
                                                            @foreach($meal_groups as $key1=> $group)
                                                                @php
                                                                    $schedule=\App\Models\MealSchedules::where('id',$group)->first();
                                                                @endphp
                                                                <li class="nav-item" role="presentation">
                                                                    <button class="nav-link @if($key1==0)active @endif" id="home-tab" data-bs-toggle="tab" data-bs-target="#home{{$key}}{{$key2}}{{$schedule->id}}" type="button" role="tab" aria-controls="home" aria-selected="true" data-value="{{$schedule->id}}">
                                                                        {{$schedule->name}}</button>
                                                                </li>
                                                                <input type="hidden" name="meal_group_name[]" value="{{$schedule->id}}">
                                                            @endforeach
                                                        </ul>
                                                        <div class="tab-content mt-4" id="myTabContent">
                                                            @foreach($meal_groups as $key3=> $group)


                                                                @php
                                                                    $day = \Carbon\Carbon::parse($date)->format('l');
                                                                        $schedule=\App\Models\MealSchedules::where('id',$group)->first();
                                                                        $meals_id=\App\Models\MealGroupSchedule::where('meal_schedule_id',$schedule->id)->pluck('meal_id')->toArray();
                                                                        $meals=\App\Models\MealDietPlan::with('meal_items')->whereIn('meal_id',$meals_id)->where('diet_plan_type_id',$value->id)->get();
                                                                      
                                                                       
                                                                @endphp
                                                                <div class="tab-pane fade @if($key3==0)active show @endif" id="home{{$key}}{{$key2}}{{$schedule->id}}" role="tabpanel" aria-labelledby="home-tab{{$key}}{{$key2}}{{$schedule->id}}">
                                                                    <div class="row">
                                                                        <div class="col-12 comman_table_design New_tabledesign">
                                                                            <div class="table-responsive">
                                                                                <table class="table mb-0">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th>Item Name</th>
                                                                                        <th>Meal Group</th>
                                                                                        <th>Default Selection</th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    @foreach($meals as $key3=> $meal)

                                                                                        @if(isset($meal->meal_items->name))
                                                                                            <tr>
                                                                                                <td>{{$meal->meal_items->name??null}}</td>
                                                                                                <td>{{$schedule->name}}</td>
                                                                                                <td>
                                                                                                    <div class="check_radio td_check_radio">
                                                                                                        <input type="checkbox" name="selectionvariant[{{$date}}][{{$schedule->name}}][{{$meal->meal_id}}]" id="t{{$key}}{{$key2}}{{$key3}}{{$schedule->id}}" class="d-none defaultSelection" data-id="1">
                                                                                                        <label for="t{{$key}}{{$key2}}{{$key3}}{{$schedule->id}}"></label>
                                                                                                    </div>
                                                                                                </td>
                                                                                                <input type="hidden" name="plan_date[]" value="{{$date}}">
                                                                                                <input type="hidden" name="meals[]" value="{{$meal->meal_id}}">
                                                                                                <input type="hidden" name="meals_schedule_id[]" value="{{$schedule->id}}">
                                                                                            </tr>
                                                                                        @endif
                                                                                    @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--<div class="col-12 comman_table_design mb-4 New_tabledesign">--}}
{{--    <div class="row mx-0">--}}
{{--        <div class="col-12 default_meal_selection border">--}}
{{--            <div class="row comman_header justify-content-between rounded-top">--}}
{{--                <div class="col">--}}
{{--                    <h2>Default Meal Selection</h2>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row mx-0">--}}
{{--                <div class="col-12 px-0 text-center" id="main">--}}
{{--                    <nav>--}}
{{--                        <div class="mealoutter_tabs nav nav-tabs border-0 justify-content-center shadow d-inline-flex" id="nav-tab" role="tablist">--}}
{{--                            @foreach($dates as $key=> $date)--}}
{{--                                <button class="nav-link @if($key==0)active @endif" id="nav-home-tab{{$key}}" data-bs-toggle="tab" data-bs-target="#nav-home{{$key}}" type="button" role="tab" aria-controls="nav-home" aria-selected="true" data-value="{{$date}}">--}}
{{--                                    {{\Carbon\Carbon::parse($date)->format('d-F')}}</button>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </nav>--}}
{{--                    <div class="tab-content mt-4" id="nav-tabContent">--}}
{{--                        @foreach($dates as $key=> $date)--}}
{{--                        <div class="tab-pane fade @if($key==0)active show @endif" id="nav-home{{$key}}" role="tabpanel" aria-labelledby="nav-home-tab{{$key}}">--}}
{{--                            <div class="row meal_innerpart">--}}
{{--                                <div class="col-12 text-center">--}}
{{--                                    <ul class="nav nav-tabs mealinner_tabs d-inline-flex justify-content-center rounded-pill shadow overflow-hidden" id="myTab" role="tablist">--}}
{{--                                        @foreach($meal_groups as $key1=> $group)--}}
{{--                                            @php--}}
{{--                                                $schedule=\App\Models\MealSchedules::where('id',$group)->first();--}}
{{--                                            @endphp--}}
{{--                                            <li class="nav-item" role="presentation">--}}
{{--                                                <button class="nav-link @if($key1==0)active @endif" id="home-tab{{$key}}{{$schedule->id}}" data-bs-toggle="tab" data-bs-target="#home{{$key}}{{$schedule->id}}" type="button" role="tab" aria-controls="home" aria-selected="true" data-value="{{$schedule->id}}">--}}
{{--                                                    {{$schedule->name}}</button>--}}
{{--                                            </li>--}}
{{--                                            <input type="hidden" name="meal_group_name[]" value="{{$schedule->id}}">--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                    <div class="tab-content mt-4" id="myTabContent">--}}
{{--                                        @foreach($meal_groups as $key2=> $group)--}}
{{--                                            @php--}}
{{--                                                $schedule=\App\Models\MealSchedules::where('id',$group)->first();--}}
{{--                                                $meals=\App\Models\MealGroupSchedule::where('meal_schedule_id',$schedule->id)->get();--}}
{{--                                            @endphp--}}
{{--                                            <div class="tab-pane fade @if($key2==0)active show @endif" id="home{{$key}}{{$schedule->id}}" role="tabpanel" aria-labelledby="home-tab{{$key}}{{$schedule->id}}">--}}
{{--                                                <div class="row">--}}
{{--                                                    <div class="col-12 comman_table_design New_tabledesign">--}}
{{--                                                        <div class="table-responsive">--}}
{{--                                                            <table class="table mb-0">--}}
{{--                                                                <thead>--}}
{{--                                                                <tr>--}}
{{--                                                                    <th>Item Name</th>--}}
{{--                                                                    <th>Meal Group</th>--}}
{{--                                                                    <th>Default Selection</th>--}}
{{--                                                                </tr>--}}
{{--                                                                </thead>--}}
{{--                                                                <tbody>--}}
{{--                                                                @foreach($meals as $key3=> $meal)--}}
{{--                                                                    @if(isset($meal->meal_items->name))--}}
{{--                                                                    <tr>--}}
{{--                                                                        <td>{{$meal->meal_items->name??null}}</td>--}}
{{--                                                                        <td>{{$schedule->name}}</td>--}}
{{--                                                                        <td>--}}
{{--                                                                            <div class="check_radio td_check_radio">--}}
{{--                                                                                <input type="checkbox" name="selectionvariant[{{$date}}][{{$schedule->name}}][{{$meal->meal_id}}]" id="t{{$key}}{{$key2}}{{$key3}}{{$schedule->id}}" class="d-none defaultSelection" data-id="1">--}}
{{--                                                                                <label for="t{{$key}}{{$key2}}{{$key3}}{{$schedule->id}}"></label>--}}
{{--                                                                            </div>--}}
{{--                                                                        </td>--}}
{{--                                                                        <input type="hidden" name="plan_date[]" value="{{$date}}">--}}
{{--                                                                        <input type="hidden" name="meals[]" value="{{$meal->meal_id}}">--}}
{{--                                                                        <input type="hidden" name="meals_schedule_id[]" value="{{$schedule->id}}">--}}
{{--                                                                    </tr>--}}
{{--                                                                    @endif--}}
{{--                                                                @endforeach--}}
{{--                                                                </tbody>--}}
{{--                                                            </table>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
