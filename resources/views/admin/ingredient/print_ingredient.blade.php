
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
        <th>Ingredient Name (En)</th>
         <th>Ingredient Name (Ar)</th>
        <th>Category</th>
         <th>Group</th>
         <th>Unit</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $key=>$user)
            <tr>
            <td>{{$key+1}}</td> 
           <td>{{$user['name']?:'N/A'}}</td>
           <td>{{$user['name_ar']?:'N/A'}}</td>
           <td>{{$user->category['name']?:'N/A'}}</td>
           <td>{{$user->group['name']?:'N/A'}}</td>
           <td>{{$user->unit['unit']?:'N/A'}}</td>  
            </tr>
        @endforeach

    </tbody>
</table>
</body>
</html>



