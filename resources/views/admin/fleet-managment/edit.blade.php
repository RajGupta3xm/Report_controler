<form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" action="{{url('admin/fleetarea/edit_update',$clients->id)}}" method="post" id="editForm">
    @csrf
    <div class="form-group mb-0 col" >
      <select id='selUsers'class="form-select table_input table_select adjust_lenth selUser " name="area_edit"  >
        <!-- <option value=''></option>  -->                                        
       </select>
    </div>
    <div class="form-group mb-0 col">
    @php
       $data = json_decode($clients->area,true);
       $print = preg_replace('/^([^,]*).*$/', '$1', $data['description']);
    @endphp
        <label for="">Area (En)</label>
        <input class="form-control validate google1" value="{{$print}}"  type="text" id="search_box1" >
    </div>
    <div class="form-group mb-0 col">
        <label for="">Area (Ar)</label>
        <input class="form-control validate" value="{{$clients->area_ar}}" type="text" name="area_ar_edit">
        <p class="text-danger text-small" id="area_ar_editError"></p>
    </div>
    <div class="form-group mb-0 col">
        <label for="">Driver Group</label>

        <select class="form-select form-control validate" aria-label="Default select example" name="staff_ids_edit">
            <option value="">Select Driver Group</option>
            @foreach(\App\Models\StaffMembers::wherehas('group',function ($q){
                                                           $q->where('name','=','Driver');
                                                       })->get() as $value)
                <option value="{{$value->id}}" @if($clients->staff_ids == $value->id)selected @endif>{{$value->name}}</option>
            @endforeach
        </select>
        <p class="text-danger text-small" id="staff_ids_editError"></p>
    </div>
    <div class="form-group mb-0 col">
        <label for="">Slot</label>
        <select class="form-select form-control validate" aria-label="Default select example" name="delivery_slot_id_edit">
            <option value="">Select Slot</option>
            @foreach(\App\Models\DeliverySlot::get() as $value)
                <option value="{{$value->id}}" @if($clients->delivery_slot_ids==$value->id) selected @endif>{{$value->name}}</option>
            @endforeach
        </select>
        <p class="text-danger text-small" id="delivery_slot_id_editError"></p>

    </div>
    <div class="form-group mb-0 col-auto">
        <button class="comman_btn" type="button" onclick="validate(this);">Save</button>
    </div>
</form>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
      $(document).ready(function(){
 
 // Initialize select2
 $(".selUser").select2();

 // Read selected option
 $('#but_read').click(function(){
     var username = $('#selUser option:selected').text();
     var userid = $('#selUser').val();

     $('#result').html("id : " + userid + ", name : " + username);

 });
})
    </script>
    <script>
    $('.google1').on('change',function(e){
    var id2 = document.getElementById('search_box1').value
alert(id2)
 if(id2){
    $.ajax({
 
 // Our sample url to make request 
//  url: 
// 'https://maps.googleapis.com/maps/api/place/autocomplete/json?key=AIzaSyBfnznJ2gE8vjoNP6f3pYzeRxzd-Ha5Yo8&input='+id2,

url:'https://maps.googleapis.com/maps/api/place/autocomplete/json?key=AIzaSyBMN2qx9sNSiaYyJkSFb6vSRI83oLHPIkg&input='+id2,

 // Type of Request
 type: "GET",

 // Function to call when to
 // request is ok 
 success: function (data) {
    $.each(data.predictions, function (key, value) {
        $("#selUsers").append($("<option></option>")
                    .attr("value",JSON.stringify(value))
                    .text(JSON.stringify(value))); 

            // $("#selUser").append('<option value='+JSON.stringify(value)+'>'+JSON.stringify(value)+'</option>' );  

           
        });
        console.log(JSON.stringify(value));
   
  
    //  var x = JSON.stringify(data.predictions[0].terms);
     
     console.log(data);
 },
    
 // Error handling 
 error: function (error) {
     console.log(`Error ${error}`);
 }
});
}
});


   
</script>
<script>
    function validate(obj) {
        $(".text-danger").html('');
        var flag = true;
        var formData = $("#editForm").find(".validate:input").not(':input[type=button]');
        $(formData).each(function () {
            var element = $(this);
            var val = element.val();
            var name = element.attr("name");
            if (val == "" || val == "0" || val == null) {

                $("#" + name + "Error").html("This field is required");
                flag = false;


            } else {

            }
        });

        if (flag) {
            $("#editForm").submit();
        } else {
            return false;
        }


    }
</script>
