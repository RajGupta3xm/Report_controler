<table>
    <thead>
        <tr>
        <th>S.No.</th>
        <th>User Name</th>
        <th>Mobile Number</th>
       <th>no of referral</th>
       <th>referral used <br> for registration</th>
        <th>registration total</th>
        <th>refferal used <br> for plan purchase</th>
        <th>plan purchase total</th>
         <th>Grand total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $key1=>$user)
        <tr>
        <td>{{$key1+1}}</td>
        <td>{{$user->name}}</td>
        <td>{{$user->mobile}}</td>
        <td>{{$user['user_referral_count']}}</td>
        <td>{{$user->registration}}x{{$user->register_referral}}</td>
         <td>{{$user->registration_total}}</td>
         <td>{{$user->purchase}}x{{$user->plan_referral}}</td>
        <td>{{$user->plan_purchase_total}}</td>
         <td>{{$user->grand_total}}</td>
           </tr>
        @endforeach
    </tbody>
</table>