
<form class="form-design filter_check" action="{{url('admin/fleetdriver/submit')}}" method="post">
    @csrf
<div class="row p-4 mx-0 driver_management">
    <!-- <div class="col-12 mb-4">
        <form class="form-design filter_check" action="">
            <div class="check_toggle d-flex">
                <span>Filter : </span>
                <input type="checkbox" name="check1" id="check1" class="d-none">
                <label class="onclk" for="check1"></label>
            </div>
        </form>
    </div> -->
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
                      
                            <table class="table mb-0" id="example2">
                                <thead>
                                <tr>
                                    <th>
                                      
                                        user Id 
                                    </th>
                                    <th>
                                        User Name
                                       
                                    </th>
                                    <th>
                                        Driver name
                                     
                                    </th>
                                    <th>
                                        Time Slot
                                    </th>
                                    <th>
                                        Area
                                    </th>
                                    <th>
                                        Priority
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Remark
                                    </th>
                                    <th>
                                        View
                                    </th>
                                    <th>
                                        Note
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
                                            <td>{{$driver->user->id??null}}</td>
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
                                            <!-- <td>{{$order->user->user_address->street??null}}</td> -->
                                            <td>

                                                    <div class="form-group">
                                                        <select class="form-select select_tabls" aria-label="Default select example" name="priority[{{$order->id}}]" style="width:180px !important;">
                                                            <option value="2" @if(isset($driver->priority) && $driver->priority == 2) selected @endif>Expedite</option>
                                                            <option value="1" @if(isset($driver->priority) && $driver->priority == 1) selected @endif >Normal</option>
                                                        </select>
                                                    </div>

                                            </td>
                                            <td>{{$order->status??null}}</td>
                                            <td>
                                            <a class="map_pin"  data-container=".view_modal"   data-toggle="modal" data-target="#contact_modal{{$order->id}}" href="javscript:;"><i class="far fa-file"></i></a>
                                                <!-- <a class="map_pin" href="javscript:;" data-toggle="modal" data-target="#myModal"><i class="far fa-file"></i></a> -->
                                            </td>
                                          <!-- Map -->
                                         @php 
                                         $admin_id = App\Models\StaffMembers::where('id',$driver->staff_member_id)->first();
                                         @endphp
                                          
                                            <td> <a class="map_pin" href="javscript:;"   onclick="updateDriverLocation(this, '{{$admin_id->admin_id}}');"><i class="fas fa-map-marker-alt"></i></a></td>
                                            <!-- end map -->
                                         
                                            <td>Delivery to Neighbour 45645454</td>
                                        </tr>
                                        </tbody>
                                          <!-- model -->
                   <div class="modal fade account_model" id="contact_modal{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"><div class="modal-dialog modal-dialog-centered modal-lg" role="document" >
                      <div class="modal-content " style="width:135%">
                          <form id="queryForm_<?=$order->id?>"  >
                            @csrf
                              <input name="_token" type="hidden" value="apx5h5sBuUEVxY3XmUn2gfJu2iz145ls84Uht2xQ">
                               <div class="modal-header">
                                   <h4 class="modal-title">Edit Content </h4>
                                </div>
                                <div class="modal-body">
                                   <div class="form-group">
                                      <input  id="input_id"  type="hidden" name="order_id" value="{{$order->id}}">
                                       <label for="account_id">Remark</label>
                                        <textarea type="text"   rows="4" id="privacy" name="reply" class="form-control mt-200" style="height: 140px;"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                 <button type="button" onclick="sendReply(this,<?= $order->id ?>)" class="btn btn-primary">Save</button>
                                 <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                               </div>
                          </form>
                        </div>
                   </div><!-- /.modal-dialog --></div> 
                   <!-- end model -->
                                @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                    <!-- <div class="col-12">
                        <div class="count_total">
                            Total Count : <span>{{count($orders)}}</span>
                        </div>
                    </div> -->
                </div>
            </div>
        
            @endforeach
        </div>
    </div>
    <div class="col-12 py-4 mt-4">
        <div class="row justify-content-center">
            <div class="col-auto">
                <a href="{{url('admin/allDriver/location',['date'=> '2023-04-10'])}}"  class="comman_btn">View On Map</a>
            </div>
            <div class="col-auto">
                <button type="submit" class="comman_btn">Update</button>
            </div>
            <div class="col-auto">
                <a href="javscript:;" class="comman_btn yellow-btn">Print</a>
            </div>
            <div class="col-auto">
            <a href="{{url('admin/export/driver_list')}}"  class="comman_btn">Export to Excel</a>
            </div>
        </div>
    </div>
</div>
</form>
<div class="container">
<div id="map" style="width:100%;height:300px;">

</div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>

<script type="text/javascript"
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMN2qx9sNSiaYyJkSFb6vSRI83oLHPIkg&libraries=places&callback=initialize">
  </script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAVD0ngfhOFs5rnww7UFyz9rN6UznOIZ1U&callback=initMap" async defer></script> -->

<script>
 var map;
var marker;

// In your JavaScript file
function updateDriverLocation(obj,admin_id) {
    var id = admin_id;

  $.ajax({
    url  : "<?= url('admin/drivers/location/') ?>/" + id,
    type: 'GET',
    success: function(data) {
      var latlng = new google.maps.LatLng(data.latitude, data.longitude);
      marker.setPosition(latlng);
      map.setCenter(latlng);
    },
    error: function() {
      console.log('Failed to get driver location.');
    }
  });

  // In your JavaScript file
  const map = new google.maps.Map(document.getElementById("map"), {
  zoom: 15,
  center: { lat: 27.1766701, lng: 78.00807449999999 }, // San Francisco, CA (default center)
});



//   var marker = new google.maps.Marker({
//   map: map,
// });
// marker.addListener("click", () => {
//   map.setZoom(15);
//   map.setCenter(marker.getPosition());
// });

const marker = new google.maps.Marker({
      position: {lat: 27.1766701, lng: 78.00807449999999},
      map: map,
      title: 'Driver Location'
    }); 
}


</script>






<style>
    .dataTables_length {
    text-align: left;
}
</style>
<style>
    .dataTables_info {
    text-align: left;
}
</style>
<script>
  function sendReply(obj, id) {
  alert(id)
	if (id) {
   
		if (id) {
     
			$.ajax({
				url: "<?= url('admin/fleet/update/') ?>/" + id,
				type: 'post',
				data: $("#queryForm_" + id).serialize() + '&_token=<?= csrf_token() ?>',

				success: function(data) {
					swal({
						title: "Success!",
						text: "Your content has been updated",
						icon: "success",
                  buttons: false,
					});
					setTimeout(function() {
						location.reload();
					}, 2000);
				}
			});
		} else {
			$("#error").html("Message field is required");
		}
	} else {
		var data = {
			message: "Something went wrong"
		};
		errorOccured(data);
	}
}
</script>
</script>
