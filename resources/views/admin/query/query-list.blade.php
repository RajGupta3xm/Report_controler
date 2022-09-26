@extends('admin.layout.master')
@section('content')
<div class="admin_main">
   <div class="admin_main_inner">
      <div class="admin_panel_data height_adjust">
         <div class="row help-support-management justify-content-center">
            <div class="col-12 text-end mb-4 pe-0">
               <a href="see-staff.html" class="comman_btn">See Staff</a> 
            </div>
            <div class="col-12 design_outter_comman shadow">
               <div class="row comman_header justify-content-between">
                  <div class="col-auto">
                     <h2>Help & Support</h2>
                  </div>
               </div>
               <form class="form-design py-4 help-support-form row mx-3 align-items-end justify-content-between flex-nowrap" method="post"  action="{{route('admin.query.filter')}}">
                  @csrf
                  <div class="form-group mb-0 col-5">
                        <label for="">From</label>
                        <input type="date" onchange="$('#start_date').attr('min', $(this).val());" max="<?= date('Y-m-d') ?>"  value="{{isset($start_date)?$start_date:''}}"  name="start_date" class="form-control">
                    </div>
                    <div class="form-group mb-0 col-5">
                        <label for="">To</label>
                        <input type="date" id="start_date" name="end_date" max="<?= date('Y-m-d') ?>" value="{{isset($end_date)?$end_date:''}}" class="form-control">
                    </div>
                    <div class="form-group mb-0 col-auto">
                       <button class="comman_btn" onclick="filterList(this)";>Search</button>
                    </div> 
                    <div class="col-md-12 col-xs-12">
                        <p id="formError" class="text-danger"></p>
                    </div>
                </form>
               <div class="row">
                  <div class="col-12 comman_table_design px-0">
                     <div class="table-responsive">
                        <table class="table mb-0">
                           <thead>
                              <tr>
                                 <th>S.No.</th>
                                 <th>Media</th>
                                 <th>User Name</th>
                                 <th>E-mail</th>
                                 <th>Subject</th>
                                 <th>Description</th>
                                 <th>Date</th>
                                 <th>Status</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                            @if($queries)
                            @foreach($queries as $key=>$query)
                              <tr>
                                 <td>{{$key+1}}</td>
                                 <td>
                                    <img class="table_img" src="{{asset('assets/img/bg-img.jpg')}}" alt="">
                                 </td>
                                 <td>{{$query->name}}</td>
                                 <td>{{$query->email}}</td>
                                 <td>{{$query->subject}}</td>
                                 <td>{{$query->message}}</td>
                                 <td>{{date('F d,Y',strtotime($query->created_at))}}</td>
                                   <td>
                                        <div class="">
                                            <label class="toggle">
                                             <input type="checkbox" onchange="changeStatus(this, '<?= $query->id ?>');" <?= ( $query->status == '1' ? 'checked' : '') ?>><span class="slider"></span><span class="labels" data-on="Closed" data-off="Open"> </span> 
                                            </label>
                                        </div>
                                     </td>
                                  <td>
                                    <a data-bs-toggle="modal" data-bs-target="#staticBackdrop{{$query->id}}" class="comman_btn table_viewbtn" href="javscript:;">View</a>
                                    <a class="comman_btn table_viewbtn delete_btn" onclick="deleteData(this,'{{$query->id}}');" href="javscript:;">Delete</a>
                                  
                                 </td>
                              </tr>
   <!-- Chat Modal -->
<div class="modal fade reply_modal" id="staticBackdrop{{$query->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0">
         <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Ticket ID : {{$query->ticket_id}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body py-4">
            <div class="chatpart_main">
               <div class="row mx-0" id="messages_<?=$query->id ?>">
                  <div class="col-12 user_chat mb-3">
                     <div class="row">
                        <div class="col text-end">
                           <div class="user_chat_box">
                           {{$query->message}} 
                           </div>
                           <span class="time_chat">{{date('M d',strtotime($query->created_at))}}, {{date('h:m',strtotime($query->created_at))}} pm</span>
                        </div>
                     </div>
                  </div>
                  @foreach($query->queryreply as $reply)
               @if($reply->user_type=='admin')
                  <div class="col-12 admin_chat mb-3">
                     <div class="row">
                        <div class="col text-start">
                           <div class="admin_chat_box">
                           {{$reply->reply}}
                           </div>
                           <span class="time_chat">{{date('M d',strtotime($reply->created_at))}}, {{date('h:m',strtotime($reply->created_at))}} </span>
                        </div>
                     </div>
                  </div>
                  @else
                  <div class="col-12 user_chat mb-3">
                  <div class="row">
                     <div class="col text-end">
                        <div class="user_chat_box">
                        {{$reply->reply}} 
                        </div>
                        <span class="time_chat">{{date('M d',strtotime($reply->created_at))}}, {{date('h:m',strtotime($reply->created_at))}} </span>
                     </div>
                  </div>
               </div>
               @endif
               @endforeach
               </div>
            </div>
         </div>

         <div class="modal-footer">
            <form class="message_send row mx-0 w-100" id="queryForm_<?=$query->id?>">
            @csrf
               <div class="form-group col">
                  <input type="text" class="form-control" name="reply" placeholder="Type a Message...." style="border-radius: 50px; height: 50px; font-size: 14px;padding: 11px 18px;box-shadow: unset;border: 0;">
               </div>
               <div class="form-group col-auto ps-0">
                  <button class="send_btn"  onclick="sendReply(this,<?=$query->id?>)" type="button"><i class="fab fa-telegram-plane"></i></button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<!--End chat model-->
                              @endforeach
                              @endif
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade Update_modal" id="staticBackdrop12" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-body p-4">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="row">
               <div class="col-12 Update_modal_content py-4">
                  <h2>Update</h2>
                  <p>Are you sure, Want to update this?</p>
                  <a class="comman_btn mx-2" href="javscript:;">Yes</a>
                  <a class="comman_btn mx-2 bg-red" href="javscript:;">NO</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
<script>
         setInterval( sendReply, 1000 );
          function sendReply(obj,id) {
 
                                        
                                      
                                        if (id) {
                                            $.ajax({
                                                url: '<?= url('admin/query/reply') ?>',
                                                type: 'POST',
                                                data: $("#queryForm_"+id).serialize()+'&id='+id,
                                                success: function(data){
                                                   if ( data.status == true ) { 
                                                    console.log(data.data)

                                                    var html = ' <div class="col-12 admin_chat mb-3  "  >' +
                                                              '   <div class="row " >' +
                                                               '<div class="col text-start ">' +
                                                             ' <div class="admin_chat_box reply " >' +
                                                                data.data.reply+
                                                              '  </div>' +
                                                              ' <span class="time_chat">'+data.data.created_at +'</span>' +
                                                              '</div>'+
                                                              '</div>'+
                                                              '</div>';
                                                             $("#messages_"+data.data.query_id).append(html);
         
                                                   
                                                    // Display Modal
                                                    $('#staticBackdrop'+data.data.query_id).modal('show');
        
                                                   }
                                                   
                                               
               
                                        },
                                    error : function(){
                                      swal({
                                           title: 'Opps...',
                                         text : data.message,
                                        type : 'error',
                                       timer : '1500'
                            })
                        }
                                            });
                                        }
                                        else {
              
                }
                                    }
    </script>
<script>
       function changeStatus(obj, id) {
            swal({
                title: "Are you sure?",
                text: " status will be closed",
                icon: "warning",
                buttons: ["No", "Yes"],
                dangerMode: true,
            })
                    .then((willDelete) => {
                        if (willDelete) {
                            var checked = $(obj).is(':checked');
                            if (checked == true) {
                                var status = '1';
                            } else {
                                var status = '0';
                            }
                            if (id) {
                                $.ajax({
                                    url: "<?= url('admin/query/change_status') ?>",
                                    type: 'post',
                                    data: 'id=' + id + '&action=' + status + '&_token=<?= csrf_token() ?>',
                                    success: function (data) {
                                    
                                        swal({
                                           title: "Success!",
                                            text : "User Status has been Updated ",
                                            icon : "success",
                                        })
                                    }
                                });
                            } else {
                                var data = {message: "Something went wrong"};
                                errorOccured(data);
                            }
                        } else {
                            var checked = $(obj).is(':checked');
                            if (checked == true) {
                                $(obj).prop('checked', false);
                            } else {
                                $(obj).prop('checked', true);
                            }
                            return false;
                        }
                    });
        }
    </script>

<script>
      function deleteData(obj, id){
            //var csrf_token=$('meta[name="csrf_token"]').attr('content');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this record!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url : "<?= url('admin/query-delete') ?>",
                        type : "POST",
                        data : 'id=' + id + '&_token=<?= csrf_token() ?>',
                        success: function(data){
                            swal({
                                title: "Success!",
                                text : "Query has been deleted \n Click OK to refresh the page",
                                icon : "success",
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error : function(){
                            swal({
                                title: 'Opps...',
                                text : data.message,
                                type : 'error',
                                timer : '1500'
                            })
                        }
                    })
                } else {
                swal("Your  file is safe!");
                }
            });
        }
        
</script>
<script>
       function filterList(obj){
        if ($(':input[name=start_date]').val() == '' && $(':input[name=end_date]').val() == ''){
        $("#formError").html('Select filter attribute');
        } else{

        if ($(':input[name=start_date]').val() != '' && $(':input[name=end_date]').val() != ''){
        $('form').submit();
        } else{
        if ($(':input[name=start_date]').val() != ''){
        $("#formError").html('End date is required');
        } else if ($(':input[name=end_date]').val() != ''){
        $("#formError").html('Start date is required');
        } else{
        $("#formError").html('Select filter attribute');
        }
        }
        }

        }
    
 </script>

