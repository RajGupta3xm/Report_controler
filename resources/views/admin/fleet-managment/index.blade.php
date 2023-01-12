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
                                            @php
                                                $session=Session::get('driver');
                                            @endphp
                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                <button class="nav-link @if(!isset($session))active @endif w-50" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Setup</button>
                                                <button class="nav-link @if(isset($session))active @endif w-50" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Driver Management</button>
                                            </div>
                                        </nav>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade @if(!isset($session))show active @endif" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <div class="row p-4 mx-0">
                                                    <div class="col-12 inner_design_comman border mb-4">
                                                        <div class="row comman_header justify-content-between">
                                                            <div class="col-auto">
                                                                <h2>Add New Area</h2>
                                                            </div>
                                                        </div>
                                                        <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" action="{{url('admin/fleetarea/submit')}}" method="post" id="addForm">
                                                            @csrf
                                                            <div class="form-group mb-0 col">
                                                                <label for="">Area (En)</label>
                                                                <input class="form-control validate" value="lorem" type="text" name="area">
                                                                <p class="text-danger text-small" id="areaError"></p>
                                                            </div>
                                                            <div class="form-group mb-0 col">
                                                                <label for="">Area (Ar)</label>
                                                                <input class="form-control validate" value=" عربى" type="text" name="area_ar">
                                                                <p class="text-danger text-small" id="area_arError"></p>
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
                                                                <button class="comman_btn" type="button" onclick="validate(this);">Save</button>
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
                                                                            <tr>
                                                                                <td>{{$key+1}}</td>
                                                                                <td>{{$area->area}}</td>
                                                                                <td>{{$area->area_ar}}</td>
                                                                                <td>
                                                                                    <form action="">
                                                                                        <div class="form-group">
                                                                                            <select class="form-select multiple-select-custom-field driverselection" aria-label="Default select example" multiple="multiple" data-placeholder="Please Select Driver" data-id="{{$area->id}}">
                                                                                                @foreach(\App\Models\StaffMembers::wherehas('group',function ($q){
                                                                                                            $q->where('name','=','Driver');
                                                                                                        })->get() as $value)
                                                                                                    <option value="{{$value->id}}"  @if(is_array(json_decode($area->staff_ids)))@if(in_array($value->id,json_decode($area->staff_ids))) selected @endif @endif>{{$value->name}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </form>
                                                                                </td>
                                                                                <td>
                                                                                    <form action="">
                                                                                        <div class="form-group multiple_select_design">
                                                                                            <select class="form-select multiple-select-custom-field deliveryslot" aria-label="Default select example" data-placeholder="Please Select Slot" multiple data-id="{{$area->id}}">
                                                                                                @foreach(\App\Models\DeliverySlot::get() as $value)
                                                                                                    <option value="{{$value->id}}"  @if(is_array(json_decode($area->delivery_slot_ids)))@if(in_array($value->id,json_decode($area->delivery_slot_ids))) selected @endif @endif>{{$value->name}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </form>
                                                                                </td>
                                                                                <td>

                                                                                    <form class="table_btns d-flex align-items-center">
                                                                                        <div class="check_toggle">
                                                                                            <input type="checkbox" name="check0" id="check0" class="d-none" onchange="changeStatus(this, '<?= $area->id ?>');" <?= ( $area->status == 'active' ? 'checked' : '') ?>>
                                                                                            <label for="check0"></label>
                                                                                        </div>
                                                                                    </form>
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
                                            <div class="tab-pane fade @if(isset($session))show active @endif" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                @include('admin.fleet-managment.driver-managment')
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
        // $(document).on('change','.driverselection',function(){
        //     alert('here');
        //     var tour_id= $(this).data('id');
        //
        //     var select_button_text = $(this).find('option:selected')
        //         .toArray().map(item => item.value);
        //     //Added with the EDIT
        //     var value = option.val();//to get content of "value" attrib
        //     console.log(select_button_text);
        // });
    });
    $(document).on('click','.showEdit',function(){

        var tour_id= $(this).data('id');

        $.ajax({
            url:'{{ url("admin/fleetarea/edit") }}',
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

    $('.driverselection').on("select2:select", function(e) {
        console.log($(this).val());
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
                            url: "<?= url('admin/fleetarea/change_status') ?>",
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
<script>
    function validate(obj) {
        $(".text-danger").html('');
        var flag = true;
        var formData = $("#addForm").find(".validate:input").not(':input[type=button]');
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
            $("#addForm").submit();
        } else {
            return false;
        }


    }
</script>
