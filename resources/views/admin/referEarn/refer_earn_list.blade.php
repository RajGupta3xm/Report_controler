@extends('admin.layout.master')
@section('content')
      <div class="admin_main">
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
               <div class="row refer-and-earn justify-content-center">
                  <div class="col-12">
                     <div class="row mx-0">
                     @if(session()->has('success'))
                  <div class="alert alert-success">
                    <strong class="close" data-dismiss="alert" aria-hidden="true"></strong>
                    {{ session()->get('success') }}
                  </div>
                  @else 
                   @if(session()->has('error'))  
                  <div class="alert alert-danger">
                    <strong class="close" ></strong>
                    {{ session()->get('error') }}
                  </div>
                   @endif 
                   @endif
                   @if(Session::get('admin_logged_in')['type']=='0')
                        <div class="col-12 text-end mb-4">
                           <a class="information_box shadow" data-bs-toggle="modal" data-bs-target="#exampleModal" href="javascript:;"><i class="fas fa-info"></i></a>
                        </div>
                        @endif
                      @if(Session::get('admin_logged_in')['type']=='1')
                        @if(Session::get('staff_logged_in')['refer_earn_mgmt']!='1')
                        <div class="col-12 text-end mb-4">
                           <a class="information_box shadow" data-bs-toggle="modal" data-bs-target="#exampleModal" href="javascript:;"><i class="fas fa-info"></i></a>
                        </div>
                        @endif
                        @endif
                        @if(Session::get('admin_logged_in')['type']=='0')
                        <div class="col-12 design_outter_comman shadow mb-4">
                           <div class="row comman_header justify-content-between">
                              <div class="col">
                                 <h2>Refer and Earn</h2>
                              </div>
                              <div class="col-auto refer-earn mt-4">
                                 <form class="table_btns d-flex align-items-center">
                                    <div class="check_toggle">
                                       <input type="checkbox" checked name="check2" id="check2" class="d-none">
                                       <label for="check2"></label>
                                    </div>
                                 </form>
                              </div>
                           </div>
                           <form class="form-design py-4 my-3 px-3 row align-items-start justify-content-center form_hide_"  method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/refer_earn_submit')}}">
                           {{ csrf_field() }}  
                              <div class="col-12">
                                 <div class="row">
                                    <div class="col-6">
                                       <div class="row">
                                          <div class="form-group mb-4 col-12 checkbox_comman select_tr">
                                             <div class="row align-items-center">
                                                <div class="col-auto">
                                                   <input type="checkbox" checked="" name="v2" id="v2" class="d-none">
                                                   <label class="text-dark" for="v2"></label>
                                                </div>
                                                <div class="col ps-4">
                                                   <span class="offer_text">Enter the referral Credits for registration</span>
                                                </div>
                                                <div class="col-3 refer-boxx">
                                                <span>Sender</span>
                                                   <input class="form-control" type="text" value="{{!empty($refer_id) ? $refer_id->register_referee : '-'}}" name="register_referee" >
                                                </div>
                                                <div class="col-3 refer-boxx">
                                                <span>Receiver</span>
                                                   <input class="form-control" value="{{!empty($refer_id) ? $refer_id->register_referral : '-'}}" type="text" name="register_referral">
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group mb-4 col-12 checkbox_comman select_tr1">
                                             <div class="row align-items-center">
                                                <div class="col-auto">
                                                   <input type="checkbox" checked="" name="v3" id="v3" class="d-none">
                                                   <label class="text-dark" for="v3"></label>
                                                </div>
                                                <div class="col ps-4">
                                                   <span class="offer_text">Enter the referral Credits for Plan Purchase</span>
                                                </div>
                                                <div class="col-3 refer-boxx">
                                                <span>Sender</span>
                                                   <input class="form-control" type="text" name="plan_purchase_referee"  value="{{!empty($refer_id) ? $refer_id->plan_purchase_referee : '-'}}">
                                                </div>
                                                <div class="col-3 refer-boxx">
                                                <span>Receiver</span>
                                                   <input class="form-control" type="text" name="plan_purchase_referral" value="{{!empty($refer_id) ? $refer_id->plan_purchase_referral : '-'}}">
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group mb-4 col-12 textarea_height"> 
                                             <label for="">How it Works (En) :</label>
                                             <textarea class="form-control text-start n1" name="how_it_work_en" id="textareacheck"  >{{$refer_id->how_it_work_en}}
                                             </textarea>  
                                             <p class="text-danger text-small" id="errorShow1"></p>
                                          </div>
                                          <div class="form-group mb-4 col-12 textarea_height"> 
                                             <label for="">How it Works (Ar) :</label>
                                             <textarea class="form-control text-start" name="how_it_work_ar" id="textareacheck1" >{{$refer_id->how_it_work_ar}}
                                             </textarea>  
                                             <p class="text-danger text-small" id="errorShow2"></p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-6 mt-4">
                                       <div class="row">
                                          <div class="form-group mb-4 col-12 checkbox_comman select_tr2">
                                             <div class="row align-items-center">
                                                <div class="col-auto">
                                                   <input type="checkbox" checked="" name="v3" id="v4" class="d-none">
                                                   <label class="text-dark" for="v4"></label>
                                                </div>
                                                <div class="col ps-4">
                                                   <span class="offer_text">Number of referral per user.</span>
                                                </div>
                                                <div class="col-3">
                                                   <input class="form-control" type="text" name="referral_per_user" value="{{!empty($refer_id) ? $refer_id->referral_per_user : '-'}}" >
                                                   <input class="form-control" type="hidden" name="id" value="{{$refer_id->id}}">
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group mb-4 col-12 checkbox_comman opacity-0">
                                             <div class="row align-items-center">
                                                <div class="col-auto">
                                                   <input type="checkbox" checked="" name="v3" id="v3" class="d-none">
                                                   <label class="text-dark" for="v3"></label>
                                                </div>
                                                <div class="col ps-4">
                                                   <span class="offer_text">Enter the referral Credits for Plan Purchase</span>
                                                </div>
                                                <div class="col-3">
                                                   <input class="form-control" type="text" >
                                                </div>
                                                <div class="col-3">
                                                   <input class="form-control" type="text" >
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group mb-4 col-12 textarea_height mt-4 pt-1"> 
                                             <label for="">Message body on sharing (En) :</label>
                                             <textarea class="form-control text-start" name="message_body_en" id="textareacheck3" >{{$refer_id->message_body_en}}
                                             </textarea>  
                                             <p class="text-danger text-small" id="errorShow3"></p>
                                          </div>
                                          <div class="form-group mb-4 col-12 textarea_height "> 
                                             <label for="">Message body on sharing (Ar) :</label>
                                             <textarea class="form-control text-start" name="message_body_ar" id="textareacheck4" >{{$refer_id->message_body_ar}}
                                             </textarea>  
                                             <p class="text-danger text-small" id="errorShow4"></p>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group mb-0 col-6 text-center d-flex align-items-center justify-content-center">
                                 <div class="row">
                                    <div class="col-auto">
                                       <button type="button" class="comman_btn" onclick="validate(this);">Save & Apply</button>
                                    </div>
                                    <div class="col-6">
                                       <input type="date"  name="start_date" class="form-control w-20 validatee">
                                       <p class="text-danger text-small" id="start_dateError"></p>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                        @endif
                        @if(Session::get('admin_logged_in')['type']=='1')
                        @if(Session::get('staff_logged_in')['refer_earn_mgmt']!='1')
                        <div class="col-12 design_outter_comman shadow mb-4">
                           <div class="row comman_header justify-content-between">
                              <div class="col">
                                 <h2>Refer and Earn</h2>
                              </div>
                              <div class="col-auto refer-earn mt-4">
                                 <form class="table_btns d-flex align-items-center">
                                    <div class="check_toggle">
                                       <input type="checkbox" checked name="check2" id="check2" class="d-none">
                                       <label for="check2"></label>
                                    </div>
                                 </form>
                              </div>
                           </div>
                           <form class="form-design py-4 my-3 px-3 row align-items-start justify-content-center form_hide_"  method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/refer_earn_submit')}}">
                           {{ csrf_field() }}  
                              <div class="col-12">
                                 <div class="row">
                                    <div class="col-6">
                                       <div class="row">
                                          <div class="form-group mb-4 col-12 checkbox_comman select_tr">
                                             <div class="row align-items-center">
                                                <div class="col-auto">
                                                   <input type="checkbox" checked="" name="v2" id="v2" class="d-none">
                                                   <label class="text-dark" for="v2"></label>
                                                </div>
                                                <div class="col ps-4">
                                                   <span class="offer_text">Enter the referral Credits for registration</span>
                                                </div>
                                                <div class="col-3 refer-boxx">
                                                <span>Sender</span>
                                                   <input class="form-control" type="text" name="register_referee" >
                                                </div>
                                                <div class="col-3 refer-boxx">
                                                <span>Receiver</span>
                                                   <input class="form-control" type="text" name="register_referral">
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group mb-4 col-12 checkbox_comman select_tr1">
                                             <div class="row align-items-center">
                                                <div class="col-auto">
                                                   <input type="checkbox" checked="" name="v3" id="v3" class="d-none">
                                                   <label class="text-dark" for="v3"></label>
                                                </div>
                                                <div class="col ps-4">
                                                   <span class="offer_text">Enter the referral Credits for Plan Purchase</span>
                                                </div>
                                                <div class="col-3 refer-boxx">
                                                <span>Sender</span>
                                                   <input class="form-control" type="text" name="plan_purchase_referee">
                                                </div>
                                                <div class="col-3 refer-boxx">
                                                <span>Receiver</span>
                                                   <input class="form-control" type="text" name="plan_purchase_referral">
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group mb-4 col-12 textarea_height"> 
                                             <label for="">How it Works (En) :</label>
                                             <textarea class="form-control text-start" name="how_it_work_en" id="">
                                             </textarea>  
                                          </div>
                                          <div class="form-group mb-4 col-12 textarea_height"> 
                                             <label for="">How it Works (Ar) :</label>
                                             <textarea class="form-control text-start" name="how_it_work_ar" id="">
                                             </textarea>  
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-6 mt-4">
                                       <div class="row">
                                          <div class="form-group mb-4 col-12 checkbox_comman select_tr2">
                                             <div class="row align-items-center">
                                                <div class="col-auto">
                                                   <input type="checkbox" checked="" name="v3" id="v4" class="d-none">
                                                   <label class="text-dark" for="v4"></label>
                                                </div>
                                                <div class="col ps-4">
                                                   <span class="offer_text">Number of referral per user.</span>
                                                </div>
                                                <div class="col-3">
                                                   <input class="form-control" type="text" name="referral_per_user">
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group mb-4 col-12 checkbox_comman opacity-0">
                                             <div class="row align-items-center">
                                                <div class="col-auto">
                                                   <input type="checkbox" checked="" name="v3" id="v3" class="d-none">
                                                   <label class="text-dark" for="v3"></label>
                                                </div>
                                                <div class="col ps-4">
                                                   <span class="offer_text">Enter the referral Credits for Plan Purchase</span>
                                                </div>
                                                <div class="col-3">
                                                   <input class="form-control" type="text">
                                                </div>
                                                <div class="col-3">
                                                   <input class="form-control" type="text">
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group mb-4 col-12 textarea_height mt-4 pt-1"> 
                                             <label for="">Message body on sharing (En) :</label>
                                             <textarea class="form-control text-start" name="message_body_en" id="">
                                             </textarea>  
                                          </div>
                                          <div class="form-group mb-4 col-12 textarea_height "> 
                                             <label for="">Message body on sharing (Ar) :</label>
                                             <textarea class="form-control text-start" name="message_body_ar" id="">
                                             </textarea>  
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group mb-0 col-6 text-center d-flex align-items-center justify-content-center">
                                 <div class="row">
                                    <div class="col-auto">
                                       <button type="button" class="comman_btn" onclick="validate(this);">Save & Apply</button>
                                    </div>
                                    <div class="col-6">
                                       <input type="date" name="start_date" class="form-control w-20">
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                        @endif
                        @endif
                        <div class="col-12 design_outter_comman shadow">
                           <div class="row comman_header justify-content-between">
                              <div class="col-auto">
                                 <h2>History Table</h2>
                              </div>
                              @if(Session::get('admin_logged_in')['type']=='0')
                              <div class="col-auto">
                              <a href="{{url('admin/export/refer_list')}}"  class="comman_btn">Export to Excel</a>
                                 <!-- <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="comman_btn">Export to Excel</button> -->
                              </div>
                              @endif
                              @if(Session::get('admin_logged_in')['type']=='1')
                              @if(Session::get('staff_logged_in')['refer_earn_mgmt']!='1')
                              <div class="col-auto">
                              <a href="{{url('admin/export/refer_list')}}"  class="comman_btn">Export to Excel</a>
                                 <!-- <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="comman_btn">Export to Excel</button> -->
                              </div>
                              @endif
                              @endif
                           </div>
                           <div class="row">
                              <div class="col-12 comman_table_design px-0">
                                 <div class="table-responsive">
                                    <table class="table mb-0">
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
                                          @foreach($refer as $key=>$user_refer)
                                          <tr>
                                             <td>{{$key+1}}</td>
                                             <td>{{$user_refer->name}}</td>
                                             <td>{{$user_refer->mobile}}</td>
                                             <td>{{$user_refer['user_referral_count']}}</td>
                                             <td>{{$user_refer->registration}}x{{$user_refer->register_referral}}</td>
                                             <td>{{$user_refer->registration_total}}</td>
                                             <td>{{$user_refer->purchase}}x{{$user_refer->plan_referral}}</td>
                                             <td>{{$user_refer->plan_purchase_total}}</td>
                                             <td>{{$user_refer->grand_total}}</td>
                                          </tr>
                                          @endforeach
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
         </div>
      </div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script>
          $(window).load(function(){
   setTimeout(function(){ $('.alert-danger').fadeOut('slow') }, 3000);
});
  </script>
   <script>
 $(window).load(function(){
   setTimeout(function(){ $('.alert-success').fadeOut('slow') }, 3000);
});
      </script>
      <script>
    $('.select_tr input:checkbox').change(function() {
  $(this).closest('.select_tr').find('input:not([type=checkbox])').prop("disabled", !this.checked);
});
  </script>
     <script>
    $('.select_tr1 input:checkbox').change(function() {
  $(this).closest('.select_tr1').find('input:not([type=checkbox])').prop("disabled", !this.checked);
});
  </script>
     <script>
    $('.select_tr2 input:checkbox').change(function() {
  $(this).closest('.select_tr2').find('input:not([type=checkbox])').prop("disabled", !this.checked);
});
  </script>
      @endsection
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <script src="assets/vendor/jquery.min.js"></script>
      <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
      <script src="assets/vendor/owl/owl.carousel.min.js"></script>
      <script src="assets/js/main.js"></script>
      <script>
         $( '.selct_comman' ).select2( {
            theme: "bootstrap-5", 
         });
      </script>
  
 
<div class="modal fade reply_modal refer_modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Refer & Earn</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row p-4">
               <div class="col-12">
                  <div class="row">
                     <div class="col-md-6 d-flex align-items-stretch tt">
                        <div class="border row content_management_box me-0">
                           <h2>{{$refer_contents[0]->type}}</h2>
                           <a class="edit_content_btn comman_btn" id="edit" href="javscript:;"><i class="far fa-edit me-2"></i>Edit</a>
                           <input type="hidden" id="id1" value="{{$refer_contents[0]->id}}">
                           <p  class="text-infoo" >{{$refer_contents[0]->content}}</p>
                        </div>
                     </div>
                     <div class="col-md-6 d-flex align-items-stretch ttar">
                        <div class="border row content_management_box ms-0 text-end">
                           <h2>{{$refer_contents[1]->type}}</h2>
                           <a class="edit_content_btn comman_btn" id="edit1" href="javscript:;"><i class="far fa-edit me-2"></i>Edit</a>
                           <input type="hidden" id="id2" value="{{$refer_contents[1]->id}}">
                           <p class="text-info1" >{{$refer_contents[1]->content}}
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Modal -->
<div class="modal fade reply_modal Import_export" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0">
         <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Export Excel</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body py-4">
            <form class="Import_export_form px-4" action="">
               <div class="form-group row mb-4">
                  <div class="col-12 mb-3 Export_head"> <label for="">Exports :</label> </div>
                  <div class="col-12">
                     <div class="comman_radio mb-2"> <input class="d-none" type="radio" id="radio1" name="radio1"> <label for="radio1">All Items</label> </div>
                     <div class="comman_radio mb-2"> <input class="d-none" type="radio" checked id="radio2" name="radio2"> <label for="radio2">Selected 50+ Items</label> </div>
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-12 mb-3 Export_head"> <label for="">Exports As :</label> </div>
                  <div class="col-12">
                     <div class="comman_radio mb-2"> <input class="d-none" type="radio" checked id="radio2" name="radio2"> <label for="radio2">Excel (In Proper Format)</label> </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<script>
   $('#edit').click(function() {
 var text = $('.text-infoo').text();
 var id2 = document.getElementById('id1').value
 var input = $(' <div class="border row content_management_box me-0"> <h2> Terms & Condition </h2>  <a class="edit_content_btn comman_btn" onclick="sendQuery(this,'+id2+')"  href="javscript:;"><i class="far fa-save me-2"></i> Save </a><textarea  type="text" id="message" rows="12" class="form-control mt-400">' + text + '</textarea></div>')
 $('.tt').text('').append(input);
});


</script>
<script>
$('#edit1').click(function() {
 var text = $('.text-info1').text();
 var id2 = document.getElementById('id2').value
 var input = $(' <div class="border row content_management_box ms-0 text-end" style="width: 100%;"><h2> معلومات عنا </h2><a class="edit_content_btn comman_btn" onclick="sendQuery(this,'+id2+')" href="javscript:;"><i class="far fa-save me-2"></i> Save </a><textarea  type="text" id="message" rows="12" class="form-control mt-400">' + text + '</textarea></div>')
 $('.ttar').text('').append(input);
});
</script>
<script>
   function sendQuery(obj,id) {
alert(id);
var flag = true;
var message = $('textarea#message').val();
if (flag) {
    $.ajax({
        url: "<?= url('admin/refer_earn/update_content/') ?>/" +id,
        type: 'POST',
        data:   '&action=' + message + '&_token=<?= csrf_token() ?>',
        success: function(data) {
            swal({
                title: "Details Updated!",
                text: data.message,
                icon: "success",
                buttons: false,
            });
            setTimeout(function() {
                location.reload();
            }, 2000);
        }
    });
}
}               
</script>
<script>
            function validate(obj) {
            if($("#textareacheck").val().trim().length < 1)
               {
                document.getElementById("errorShow1").innerHTML="This field is required";
                return; 
                }
                if($("#textareacheck1").val().trim().length < 1)
               {
                document.getElementById("errorShow2").innerHTML="This field is required";
                return; 
                }
                if($("#textareacheck3").val().trim().length < 1)
               {
                document.getElementById("errorShow3").innerHTML="This field is required";
                return; 
                }
                if($("#textareacheck4").val().trim().length < 1)
               {
                document.getElementById("errorShow4").innerHTML="This field is required";
                return; 
                }
  
            $(".text-danger").html('');
            var flag = true;
            var formData = $("#addForm").find(".validatee").not(':input[type=button]');
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
                $("#addForm").submit();
            } else {
                return false;
            }

            
        }
    </script>
   