<table>
    <thead>
        <tr>
        <th>S.No.</th>
         <th>Items</th>
         <th>Meal Group</th>
          <th>Plan Type</th>
           <th>Rating</th> 
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $key=>$user)
        <tr>
        <td>{{$key+1}}</td>
        <td>{{$user->name}}</td> 
        <td>{{$user->meal_group->pluck('name')->implode(',  ')}}</td>
        <td>{{$user->diet_plan->pluck('name')->implode(', ')}}</td>
         <td>{{$user->rating['rating']??'0'}}</td> 
         <td>{{$user->status}}</td>
           </tr>
        @endforeach
    </tbody>
</table>