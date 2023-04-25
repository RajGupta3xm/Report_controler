
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
        <th>Promo Code</th>
         <th>Image</th>
         <th>Discount %</th>
         <th>Meal Plan</th>
         <th>Valid From</th> 
         <th>Valid Till</th>
          <th>NO. OF CODE USED</th>
         <th>Total Value</th>
        </tr>
    </thead>
    <tbody>
     @foreach ($users as $key=>$promoCodes)
            <tr>
            <td>{{$promoCodes->name ?? 'N/A'}}</td>
           <td><img class="table_img" src="{{$promoCodes->image?$promoCodes->image:asset('assets/img/bg-img.jpg')}}" alt="" style="width:10%;height:10%;"></td>
           <td>{{$promoCodes->discount ?? 'N/A'}}</td>
            <td>Low Carb</td>
            <td> 
             {{date('d/m/Y', strtotime($promoCodes->start_date))}}
             <br>
            {{date('g:i A', strtotime($promoCodes->start_date))}}
              </td> 
              <td>
              {{date('d/m/Y', strtotime($promoCodes->end_date))}}
                <br>
                {{date('g:i A', strtotime($promoCodes->end_date))}}
               </td>                        
              <td>{{$promoCodes->promo_code_used_count}}</td>                      
            <td>2323</td>
            </tr>
          @endforeach
    </tbody>
</table>
</body>
</html>



