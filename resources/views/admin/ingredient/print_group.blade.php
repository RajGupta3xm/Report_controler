
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
        <th>Group Name (En)</th>
        <th>Group Name (Ar)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $key=>$user)
            <tr>
            <td>{{$key+1}}</td>
          @if($user->image)
          <td > <img class="table_img" src="{{$user->image?$user->image:assets/img/bg-img.jpg}}" alt="" style="width:10%;height:10%;"> </td>
           @else
          <td> </td>
           @endif
          <td>{{$user->name}}</td>
             <td>{{$user->name_ar}}</td> 
            </tr>
        @endforeach

    </tbody>
</table>
</body>
</html>



