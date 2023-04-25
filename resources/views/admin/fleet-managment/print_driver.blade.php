
<!-- user list view -->
<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    <style>
        /* table style */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        th, td {
            text-align: left;
            padding: 8px;
        }
        
        th {
            background-color: #ddd;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<table class="table mb-0" >
    <thead>
        <tr>
        <th> user Id </th>
         <th> User Name </th>
          <th>Driver name </th>
          <th>Time Slot</th>
           <th> Area </th>
            <th>Priority</th>
            <th>Status</th> 
            <th>Note</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $key=>$order)
        @php
            $driver=\App\Models\FleetDriver::where('order_id',$order->id)->first();
          @endphp
            <tr>
            <td>{{$driver->user->id??null}}</td>
             <td>{{$order->user->name??null}}</td>
              <td>
                @foreach(\App\Models\StaffMembers::wherehas('group',function ($q){
                $q->where('name','=','Driver');
                  })->get() as $value)
                  @if($driver->staff_member_id == $value->id)
                {{$value->name}}
                 @endif
                  @endforeach
                 </td>
                 <td>
                   @foreach(\App\Models\DeliverySlot::get() as $value)
                   @if($driver->delivery_slot_id == $value->id)
                     {{$value->start_time}}-{{$value->end_time}}
                      @endif
                    @endforeach
                     </td>
                     <td>{{$order->user->user_address->area??null}}</td>
                     <!-- <td>{{$order->user->user_address->street??null}}</td> -->
                     
                     @if($driver->priority == 2)
                     <td>Expedite</td>
                     @else
                     <td>Normal</td>
                     @endif
                    <td>{{$order->status??null}}</td> 
                    <td>Delivery to Neighbour 45645454</td>
            </tr>
        @endforeach

    </tbody>
</table>
</body>
</html>



