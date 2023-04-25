
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
        <th>S.No.</th>
        <th>Media</th>
        <th>Items</th>
         <th>Meal Group</th>
         <th>Plan Type</th>
         <th>Rating</th> 
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $key=>$user)
            <tr>
            <td>{{$key+1}}</td>
            <td><img class="table_img" src="{{$user->image}}" alt=" " style="width:10%;height:10%;"></td>
            <td>{{$user->name}}</td> 
            <td>{{$user->meal_group->pluck('name')->implode(',  ')}}</td>
            <td>{{$user->diet_plan->pluck('name')->implode(', ')}}</td>
            <td>{{$user->rating['rating']??'0'}}</td> 
            </tr>
        @endforeach

    </tbody>
</table>
</body>
</html>



