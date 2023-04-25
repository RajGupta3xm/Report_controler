
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
        <th>Unit (En)</th>
         <th>Unit (Ar)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $key=>$user)
            <tr>
            <td>{{$key+1}}</td>
            <td>{{$user->unit}}</td>
             <td>{{$user->unit_ar}}</td>
            </tr>
        @endforeach

    </tbody>
</table>
</body>
</html>



