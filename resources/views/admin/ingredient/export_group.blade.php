<table>
    <thead>
        <tr>
        <th>name</th>
        <th>name_ar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $key=>$user)
        <tr>
         <td>{{$user->name}}</td>
         <td>{{$user->name_ar}}</td>
           </tr>
        @endforeach
    </tbody>
</table>