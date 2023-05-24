
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
        <th>Label </th>
        <th>Name of Meal </th>
        <th>Diet Plan</th>
        <th>Category</th>
        <th>Department</th>
        <th>XS</th>
        <th>s</th> 
         <th>m</th>  
         <th>l</th>  
         <th>xl</th>  
         <th>Total</th>
        </tr>
    </thead>
    <tbody>
    @foreach($getSubscription as $key=>$getSubscriptions)                                              
       <tr>
            <td>
                 <!-- <a href="{{ route('download-pdf') }}" class="btn btn-primary">Download PDF</a> -->
                <a class="pdf_icon" href="{{ route('download-pdf') }}"><i class="fas fa-file-pdf"></i></a>
            </td>
            <td>{{$getSubscriptions->name}}</td>
            <td>{{$getSubscriptions->dietPlan['name']}}</td>
            <td>{{$getSubscriptions->MealSchedule['name']}}</td>
            <td>{{$getSubscriptions->department['name']}}</td>
            <td>{{$getSubscriptions->xs+$countUserCaloriexs}}</td>
            <td>{{$getSubscriptions->s+$countUserCalorieS}}</td>
            <td>{{$getSubscriptions->medium+$countUserCalorieMedium}}</td>
            <td>{{$getSubscriptions->l+$countUserCaloriel}}</td>
            <td>{{$getSubscriptions->xl+$countUserCaloriexl}}</td>
             <td>{{$getSubscriptions->xs+$countUserCaloriexs+$getSubscriptions->s+$countUserCalorieS+$getSubscriptions->medium+$countUserCalorieMedium+$getSubscriptions->l+$countUserCaloriel+$getSubscriptions->xl+$countUserCaloriexl}}</td>
           </tr>
         @endforeach

    </tbody>
</table>
</body>
</html>



