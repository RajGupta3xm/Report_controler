
<form class="form-design filter_check" action="{{url('admin/fleetdriver/submit')}}" method="post">
    @csrf
<div class="row p-4 mx-0 driver_management">
    <div class="col-12 mb-4">
        <form class="form-design filter_check" action="">
            <div class="check_toggle d-flex">
                <span>Filter : </span>
                <input type="checkbox" name="check1" id="check1" class="d-none">
                <label class="onclk" for="check1"></label>
            </div>
        </form>
    </div>
    <div class="col-12 px-0 inner_design_comman rounded border text-center">
        @php
        $date = \Carbon\Carbon::now();
        $dates[]=$date->format('d-M-Y');
        for ($i = 0; $i < 7; $i++) {
        $dates[] = $date->addDay()->format('d-M-Y');
        }
        @endphp
        <nav>
            <div class="nav nav-tabs border-0 justify-content-center shadow d-inline-flex" id="nav-tab" role="tablist">
                @foreach($dates as $key1=> $date)
                    <button class="nav-link @if($key1 == 0)active @endif" id="nav-home1-tab{{$key1}}" data-bs-toggle="tab" data-bs-target="#nav-home1{{$key1}}" type="button" role="tab" aria-controls="nav-home1" aria-selected="true">
                        {{$date}}</button>
                @endforeach
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            @foreach($dates as $key1=> $date)
            <div class="tab-pane fade @if($key1 == 0) show active @endif" id="nav-home1{{$key1}}" role="tabpanel" aria-labelledby="nav-home1-tab">
                <div class="row mx-0">
                    <div class="col-12 comman_table_design border bg-white px-0 search_show_tables">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                <tr>
                                    <th>user Id<br>
                                        <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text">
                                    </th>
                                    <th>User Name<br>
                                        <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text">
                                    </th>
                                    <th>Driver name<br>
                                        <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text">
                                    </th>
                                    <th>Time Slot<br>
                                        <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text">
                                    </th>
                                    <th>Area<br>
                                        <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text">
                                    </th>
                                    <th>Street<br>
                                        <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text">
                                    </th>
                                    <th>Priority<br>
                                        <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text">
                                    </th>
                                    <th>Status<br>
                                        <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text">
                                    </th>
                                    <th>Remark<br>
                                        <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text">
                                    </th>
                                    <th>View<br>
                                        <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text">
                                    </th>
                                    <th>Notes<br>
                                        <input class="form-control th_input mt-2 shadow-none" placeholder="search" type="text">
                                    </th>
                                </tr>
                                </thead>
                                @php
                                    $date=\Carbon\Carbon::parse($date)->format('Y-m-d');
                                    $orders=\App\Models\Order::wheredate('created_at',$date)->get();
                                @endphp
                                @if(count($orders) > 0)
                                @foreach($orders as $order)
                                        @php
                                            $driver=\App\Models\FleetDriver::where('order_id',$order->id)->first();
                                        @endphp
                                        <tbody>
                                        <tr>
                                            <td>{{$order->user->id??null}}</td>
                                            <td>{{$order->user->name??null}}</td>
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-select slot_select" aria-label="Default select example" name="driver[{{$order->id}}]" style="width:180px !important;">
                                                        @foreach(\App\Models\StaffMembers::wherehas('group',function ($q){
                                                            $q->where('name','=','Driver');
                                                        })->get() as $value)
                                                            <option value="{{$value->id}}" @if(isset($driver->staff_member_id) && $driver->staff_member_id == $value->id) selected @endif>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-select select_tabls" aria-label="Default select example" name="deliveryslot[{{$order->id}}]" style="width:180px !important;">
                                                        @foreach(\App\Models\DeliverySlot::get() as $value)
                                                            <option value="{{$value->id}}"  @if(isset($driver->delivery_slot_id) && $driver->delivery_slot_id == $value->id) selected @endif>{{$value->start_time}}-{{$value->end_time}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>{{$order->user->user_address->area??null}}</td>
                                            <td>{{$order->user->user_address->street??null}}</td>
                                            <td>


                                                    <div class="form-group">
                                                        <select class="form-select select_tabls" aria-label="Default select example" name="priority[{{$order->id}}]" style="width:180px !important;">
                                                            <option value="2" @if(isset($driver->priority) && $driver->priority == 2) selected @endif>Expedite</option>
                                                            <option value="1" @if(isset($driver->priority) && $driver->priority == 1) selected @endif >Normal</option>
                                                        </select>
                                                    </div>

                                            </td>
                                            <td>{{$order->status??null}}</td>
                                            <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                            <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                            <td>Delivery to Neighbour 45645454</td>
                                        </tr>

                                        </tbody>
                                @endforeach

                                @endif
                            </table>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="count_total">
                            Total Count : <span>{{count($orders)}}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
    <div class="col-12 py-4 mt-4">
        <div class="row justify-content-center">
            <div class="col-auto">
                <a href="javscript:;" class="comman_btn">View On Map</a>
            </div>
            <div class="col-auto">
                <button type="submit" class="comman_btn">Update</button>
            </div>
            <div class="col-auto">
                <a href="javscript:;" class="comman_btn yellow-btn">Print</a>
            </div>
            <div class="col-auto">
                <a href="javscript:;" class="comman_btn">Export Excel</a>
            </div>
        </div>
    </div>
</div>
</form>
