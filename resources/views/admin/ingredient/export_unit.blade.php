<table>
    <thead>
        <tr>
        <th>unit</th>
        <th>unit_ar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $key=>$user)
        <tr>
        <td>{{$user->unit}}</td>
         <td>{{$user->unit_ar}}</td>
           </tr>
        @endforeach
    </tbody>
</table>