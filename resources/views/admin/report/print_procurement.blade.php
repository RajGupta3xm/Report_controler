
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
        <th>Name of Item </th>
        <th>Unit</th>
        <th>Category</th>
        <th>Department</th>
         <th>Qty</th> 
        </tr>
    </thead>
    <tbody>
    @foreach($procurements as $procurement)
                                                            @foreach($procurement->itemProcurement as $itemProcurements)
                                                            @foreach($procurement->getDepartment as $getDepartments)
                                                            <tr>
                                                               <td>{{$procurement->name}}</td>
                                                               <td>{{$procurement->unit['unit']}}</td>
                                                               <td>{{$procurement->categorys['name']}}</td>
                                                               <td>{{$getDepartments['name']}}</td>
                                                               <td>{{$itemProcurements->qtyTotal}}</td> 
                                                            </tr>
                                                            @endforeach
                                                            @endforeach
                                                            @endforeach

    </tbody>
</table>
</body>
</html>



