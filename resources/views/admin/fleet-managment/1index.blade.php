@extends('admin.layout.master')

@section('content')

    <div class="admin_main">
        <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
                <div class="row area-slot-management justify-content-center">
                    <div class="col-12">
                        <div class="row mx-0">
                            <div class="col-12 design_outter_comman shadow">
                                <div class="row">
                                    <div class="col-12 px-0 comman_tabs">
                                        <nav>
                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                <button class="nav-link active w-50" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Setup</button>
                                                <button class="nav-link w-50" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Driver Management</button>
                                            </div>
                                        </nav>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <div class="row p-4 mx-0">
                                                    <div class="col-12 inner_design_comman border mb-4">
                                                        <div class="row comman_header justify-content-between">
                                                            <div class="col-auto">
                                                                <h2>Add New Area</h2>
                                                            </div>
                                                        </div>
                                                        <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" action="{{url('admin/area/submit')}}" method="post">
                                                            @csrf
                                                            <div class="form-group mb-0 col">
                                                                <label for="">Area (En)</label>
                                                                <input class="form-control" value="lorem" type="text" name="area">
                                                            </div>
                                                            <div class="form-group mb-0 col">
                                                                <label for="">Area (Ar)</label>
                                                                <input class="form-control" value=" عربى" type="text" name="area_ar">
                                                            </div>
                                                            <div class="form-group mb-0 col">
                                                                <label for="">Slot</label>

                                                                <select class="form-select multiple-select-custom-field" aria-label="Default select example" data-placeholder="Please Select Slot" multiple name="delivery_slot_id[]">
                                                                    @foreach(\App\Models\DeliverySlot::get() as $value)
                                                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group mb-0 col-auto">
                                                                <button class="comman_btn" type="submit">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-12 inner_design_comman border">
                                                        <div class="row comman_header justify-content-between">
                                                            <div class="col-auto">
                                                                <h2>Fleet Management</h2>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 comman_table_design px-0">
                                                                <div class="table-responsive">
                                                                    <table class="table mb-0">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>S.No.</th>
                                                                            <th>Area (En)</th>
                                                                            <th>Area (Ar)</th>
                                                                            <th>driver group</th>
                                                                            <th>Slot</th>
                                                                            <th>Status</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @foreach($area as $key=>$area)

                                                                            {{-- {{dd(json_decode($area->delivery_slot_ids))}}--}}
                                                                            <tr>
                                                                                <td>{{$key+1}}</td>
                                                                                <td>{{$area->area}}</td>
                                                                                <td>{{$area->area_ar}}</td>
                                                                                <td>
                                                                                    <form action="">
                                                                                        <div class="form-group">
                                                                                            <select class="form-select multiple-select-custom-field" aria-label="Default select example" multiple="multiple" data-placeholder="Please Select Driver">
                                                                                                @foreach(\App\Models\StaffMembers::get() as $value)
                                                                                                    <option value="{{$value->id}}"  @if(is_array(json_decode($area->staff_ids)))@if(in_array($value->id,json_decode($area->staff_ids))) selected @endif @endif>{{$value->name}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </form>
                                                                                </td>
                                                                                <td>
                                                                                    <form action="">
                                                                                        <div class="form-group multiple_select_design">
                                                                                            <select class="form-select multiple-select-custom-field" aria-label="Default select example" data-placeholder="Please Select Slot" multiple>
                                                                                                @foreach(\App\Models\DeliverySlot::get() as $value)
                                                                                                    <option value="{{$value->id}}"  @if(is_array(json_decode($area->delivery_slot_ids)))@if(in_array($value->id,json_decode($area->delivery_slot_ids))) selected @endif @endif>{{$value->name}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </form>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="mytoggle">
                                                                                        <label class="switch">
                                                                                            <input type="checkbox" onchange="changeStatus(this, '<?= $area->id ?>');" <?= ( $area->status == 'active' ? 'checked' : '') ?>><span class="slider"></span><span class="labels"> </span>
                                                                                        </label>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <a class="comman_btn table_viewbtn showEdit" data-id="{{$area->id}}" data-bs-toggle="modal" data-bs-target="#staticBackdrop" href="javscript:;" >Edit</a>
                                                                                </td>
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
                                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
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
                                                        <nav>
                                                            <div class="nav nav-tabs border-0 justify-content-center shadow d-inline-flex" id="nav-tab" role="tablist">
                                                                <button class="nav-link active" id="nav-home1-tab" data-bs-toggle="tab" data-bs-target="#nav-home1" type="button" role="tab" aria-controls="nav-home1" aria-selected="true">2-Dec-2022</button>

                                                                <button class="nav-link" id="nav-profile1-tab" data-bs-toggle="tab" data-bs-target="#nav-profile1" type="button" role="tab" aria-controls="nav-profile1" aria-selected="false">3-Dec-2022</button>

                                                                <button class="nav-link" id="nav-contact1-tab" data-bs-toggle="tab" data-bs-target="#nav-contact1" type="button" role="tab" aria-controls="nav-contact1" aria-selected="false">4-Dec-2022</button>

                                                                <button class="nav-link" id="nav-contact2-tab" data-bs-toggle="tab" data-bs-target="#nav-contact2" type="button" role="tab" aria-controls="nav-contact2" aria-selected="false">5-Dec-2022</button>

                                                                <button class="nav-link" id="nav-contact3-tab" data-bs-toggle="tab" data-bs-target="#nav-contact3" type="button" role="tab" aria-controls="nav-contact3" aria-selected="false">6-Dec-2022</button>

                                                                <button class="nav-link" id="nav-contact4-tab" data-bs-toggle="tab" data-bs-target="#nav-contact4" type="button" role="tab" aria-controls="nav-contact4" aria-selected="false">7-Dec-2022</button>

                                                                <button class="nav-link" id="nav-contact5-tab" data-bs-toggle="tab" data-bs-target="#nav-contact5" type="button" role="tab" aria-controls="nav-contact5" aria-selected="false">8-Dec-2022</button>
                                                            </div>
                                                        </nav>
                                                        <div class="tab-content" id="nav-tabContent">
                                                            <div class="tab-pane fade show active" id="nav-home1" role="tabpanel" aria-labelledby="nav-home1-tab">
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
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Delivered [6.00am]</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option selected="" value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >Expedite</option>
                                                                                                    <option selected="" value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Pending</td>
                                                                                    <td>-</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option selected="" value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>7th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Delivered [10.00am]</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >Expedite</option>
                                                                                                    <option selected="" value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Pending</td>
                                                                                    <td>-</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option selected="" value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>10th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Cancelled</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="count_total">
                                                                            Total Count : <span>5</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="nav-profile1" role="tabpanel" aria-labelledby="nav-profile1-tab">
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
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Delivered [6.00am]</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option selected="" value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >Expedite</option>
                                                                                                    <option selected="" value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Pending</td>
                                                                                    <td>-</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option selected="" value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>7th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Delivered [10.00am]</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >Expedite</option>
                                                                                                    <option selected="" value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Pending</td>
                                                                                    <td>-</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option selected="" value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>10th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Cancelled</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="count_total">
                                                                            Total Count : <span>5</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="nav-contact1" role="tabpanel" aria-labelledby="nav-contact1-tab">
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
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Delivered [6.00am]</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option selected="" value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >Expedite</option>
                                                                                                    <option selected="" value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Pending</td>
                                                                                    <td>-</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option selected="" value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>7th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Delivered [10.00am]</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >Expedite</option>
                                                                                                    <option selected="" value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Pending</td>
                                                                                    <td>-</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option selected="" value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>10th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Cancelled</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="count_total">
                                                                            Total Count : <span>5</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="nav-contact2" role="tabpanel" aria-labelledby="nav-contact2-tab">
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
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Delivered [6.00am]</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option selected="" value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >Expedite</option>
                                                                                                    <option selected="" value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Pending</td>
                                                                                    <td>-</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option selected="" value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>7th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Delivered [10.00am]</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >Expedite</option>
                                                                                                    <option selected="" value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Pending</td>
                                                                                    <td>-</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option selected="" value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>10th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Cancelled</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="count_total">
                                                                            Total Count : <span>5</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="nav-contact3" role="tabpanel" aria-labelledby="nav-contact3-tab">
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
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Delivered [6.00am]</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option selected="" value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >Expedite</option>
                                                                                                    <option selected="" value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Pending</td>
                                                                                    <td>-</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option selected="" value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>7th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Delivered [10.00am]</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >Expedite</option>
                                                                                                    <option selected="" value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Pending</td>
                                                                                    <td>-</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option selected="" value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>10th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Cancelled</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="count_total">
                                                                            Total Count : <span>5</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="nav-contact4" role="tabpanel" aria-labelledby="nav-contact4-tab">
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
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Delivered [6.00am]</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option selected="" value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >Expedite</option>
                                                                                                    <option selected="" value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Pending</td>
                                                                                    <td>-</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option selected="" value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>7th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Delivered [10.00am]</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >Expedite</option>
                                                                                                    <option selected="" value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Pending</td>
                                                                                    <td>-</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option selected="" value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>10th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Cancelled</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="count_total">
                                                                            Total Count : <span>5</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="nav-contact5" role="tabpanel" aria-labelledby="nav-contact5-tab">
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
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Delivered [6.00am]</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option selected="" value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >Expedite</option>
                                                                                                    <option selected="" value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Pending</td>
                                                                                    <td>-</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option selected="" value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>7th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Delivered [10.00am]</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>5th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >Expedite</option>
                                                                                                    <option selected="" value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Pending</td>
                                                                                    <td>-</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>53443</td>
                                                                                    <td>John</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select slot_select" aria-label="Default select example">
                                                                                                    <option selected="">abc</option>
                                                                                                    <option value="1">efg</option>
                                                                                                    <option value="2">jkl</option>
                                                                                                    <option value="2">mno</option>
                                                                                                    <option value="2">pqr</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option >6AM-10AM</option>
                                                                                                    <option value="1">12PM-4PM</option>
                                                                                                    <option selected="" value="2">5PM-7PM</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>olaya</td>
                                                                                    <td>10th street</td>
                                                                                    <td>
                                                                                        <form action="">
                                                                                            <div class="form-group">
                                                                                                <select class="form-select select_tabls" aria-label="Default select example">
                                                                                                    <option selected="">Expedite</option>
                                                                                                    <option value="1">Normal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </form>
                                                                                    </td>
                                                                                    <td>Cancelled</td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="far fa-file"></i></a></td>
                                                                                    <td><a class="map_pin" href="javscript:;"><i class="fas fa-map-marker-alt"></i></a></td>
                                                                                    <td>Delivery to Neighbour 45645454</td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="count_total">
                                                                            Total Count : <span>5</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 py-4 mt-4">
                                                        <div class="row justify-content-center">
                                                            <div class="col-auto">
                                                                <a href="javscript:;" class="comman_btn">View On Map</a>
                                                            </div>
                                                            <div class="col-auto">
                                                                <a href="javscript:;" class="comman_btn">Update</a>
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
    <div class="modal fade comman_modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit New Area</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="smallBody">

                </div>
            </div>
        </div>
    </div>

@endsection
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();

    });
    $(document).on('click','.showEdit',function(){

        var tour_id= $(this).data('id');

        $.ajax({
            url:'{{ url("admin/area/edit") }}',
            method:'post',
            data: {
                tour_id:tour_id,
            },
            dataType:'json',
            type: "post",
            cache: false,
            success:function(data)
            {
                $('#staticBackdrop').modal("show");
                $('#smallBody').html(data.html).show();
                $( '.multiple-select-custom-field' ).select2( {
                    theme: "bootstrap-5",
                    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                    placeholder: $( this ).data( 'placeholder' ),
                    closeOnSelect: false,
                    tags: true
                } );
            }
        })


    });
    function changeStatus(obj, id) {
        swal({
            title: "Are you sure?",
            text: " status will be closed",
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
                            url: "<?= url('admin/area/change_status') ?>",
                            type: 'post',
                            data: 'id=' + id + '&action=' + status + '&_token=<?= csrf_token() ?>',
                            success: function (data) {

                                swal({
                                    title: "Success!",
                                    text : "Status has been Updated ",
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
