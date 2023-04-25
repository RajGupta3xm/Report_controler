
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
        <th>Date</th>
         <th>Media</th>
         <th>Staff Name</th>
         <th>Email</th> 
         <th>Group</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $key=>$user)
            <tr>
            <td>{{$key+1}}</td> 
             <td>{{date('d/m/Y', strtotime($user->created_at))}}</td>
              <td>
              <img class="table_img" src="{{$user->admin?$user->admin['image']:asset('assets/img/bg-img.jpg')}}" alt="" style="width:10%;height:10%;">
             </td>
             <td>{{$user->name}}</td>
            <td>{{$user->email}}</td> 
              <td>{{$user->group['name']}}</td> 
            </tr>
        @endforeach

    </tbody>
</table>
</body>
</html>



