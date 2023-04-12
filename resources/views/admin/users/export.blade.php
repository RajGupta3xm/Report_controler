<table>
    <thead>
        <tr>
        <th>S.No.</th>
       <th>User Id</th>
       <th>User Name</th>
       <th>Mobile Number</th>
        <th>Email</th>
       <th>Registration Date</th>
        <th>Total Orders</th> 
        <th>Total Spent</th> 
        <th>Delivery Location 1</th> 
        <th>Delivery Location 2</th> 
        </tr>
    </thead>
    <tbody>
        @foreach($users as $key=>$user)
        <tr>
        <td>{{$key+1}}</td>
        <td>{{$user->id}}</td>
        <td>{{$user->name}}</td>
       <td>{{$user->country_code}}{{$user->mobile}}</td>
       <td>{{$user->email}}</td>
       <td>{{date('d/m/Y',strtotime($user->created_at))}}</td>
        @php
         $totalOrder=\App\Models\Order::where('user_id',$user->id)->count();                                     
         @endphp
         <td>{{$totalOrder}}</td> 
         <td>22</td> 
        @forelse ($user->TotalOrder->take(2) as $k=>$order)
         <td>{{$order->area}}</td>
        @empty
        <td>-</td>
        <td>-</td>
         @endforelse
          @if($user->delivery_status == 'terminted')
          <td> 
          Expired
          </td> 
           @else
          <td> 
        {{$user->delivery_status}}
          </td> 
           @endif
           </tr>
        @endforeach
    </tbody>
</table>