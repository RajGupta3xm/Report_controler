
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
      <th>Date/Time</th>
        <th>User Name</th>  
        <th>Order ID</th>
        <th>Diet Plan Type</th>
        <th>Plan Name</th>
        <th>Variant Name</th>
        <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $key1=>$user)
        @foreach($user->plans as $key3=>$variant)
            <tr>
            <td>{{$key1+1}}</td>
             <td>{{date('d/m/Y',strtotime($user->created_at))}}<br>{{date('h:i A',strtotime($user->created_at))}}</td>
            <td>{{$user->name}}</td>
             <td>#{{$user->order_id}}</td>
              <td>{{$variant->dietPlans['name']}}</td>
               <td>{{$variant->plan['name']}}</td>
             <td>{{$variant->variant_name}}</td>
             <td>{{$variant->plan_price}} SR</td>  
            </tr>
        @endforeach
        @endforeach

    </tbody>
</table>
</body>
</html>



