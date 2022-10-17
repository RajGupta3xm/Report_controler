@extends('admin.layout.master')
@section('content')
      <div class="admin_main">
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
            @if(session()->has('success'))
                    <script>
                     swal('Success!', '{{ session()->get('success') }}', 'success');
                    </script>
                @else 
                @if(session()->has('error'))  
                    <script>
                     swal('Success!', '{{ session()->get('error') }}', 'success');
                    </script>
                @endif 
                @endif
               <div class="row content_management justify-content-center">
            
                  <div class="col-12 mb-4 text-end px-0"> 
                     <form  class="form-design social_media row"  method="POST" id="form1"  enctype="multipart/form-data" action="{{url('admin/social_link/update')}}">
                     @csrf
                        <div class="form-group position-relative social_icon col-md-6">
                           <i class="fab fa-facebook-f"></i>
                           <input type="text" class="form-control" id="facebook" name="facebook" value="{{$social_link->facebook_link}}">
                           <input type="hidden" class="form-control"  name="id" value="{{$social_link->id}}">
                         
                        </div>
                        <div class="form-group position-relative social_icon col-md-6">
                           <i class="fab fa-linkedin-in"></i>
                           <input type="text" class="form-control" id="linkedin"  name="linkedin" value="{{$social_link->linkedin_link}}">
                          
                        </div>
                        <div class="form-group position-relative social_icon col-md-6">
                           <i class="fab fa-instagram"></i>
                           <input type="text" class="form-control" id="instagram" name="instagram" value="{{$social_link->instagram_link}}">
                        

                        </div>
                        <div class="form-group position-relative social_icon col-md-6">
                           <i class="fab fa-twitter"></i>
                           <input type="text" class="form-control" id="twiter" name="twiter" value="{{$social_link->twiter_link}}">
                      

                        </div>
                     </form> 
                  </div> 
                
                  @foreach($content as $contents)
                  <div class="col-12 mb-5">
                     <div class="row">
                        <div class="col-md-6 d-flex align-items-stretch">
                           <div class="row content_management_box me-0">
                              <h2>{{$contents->name}}</h2>
                              <a class="edit_content_btn comman_btn "    data-container=".view_modal"   data-toggle="modal" data-target="#contact_modal{{$contents->id}}" href="javscript:;"><i class="far fa-edit me-2"></i>Edit</a>
                              <p>{{$contents->content}}</p>
                           </div>
                        </div> 
                        <div class="col-md-6 d-flex align-items-stretch">
                           <div class="row content_management_box ms-0 text-end">
                              <h2>سياسات الخصوصية</h2>
                              <a class="edit_content_btn comman_btn "    data-container=".view_modal"   data-toggle="modal" data-target="#contact_modal1{{$contents->id}}" href="javscript:;"><i class="far fa-edit me-2"></i>Edit</a>
                              <p >{{$contents->content_ar}}
                              </p>
                           </div>
                        </div> 
                     </div>
                  </div>
                   <!-- model -->
                   <div class="modal fade account_model" id="contact_modal{{$contents->id}}" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"><div class="modal-dialog modal-dialog-centered modal-lg" role="document" >
                      <div class="modal-content " style="width:135%">
                          <form id="queryForm_<?=$contents->id?>"  >
                            @csrf
                              <input name="_token" type="hidden" value="apx5h5sBuUEVxY3XmUn2gfJu2iz145ls84Uht2xQ">
                               <div class="modal-header">
                                   <h4 class="modal-title">Edit Content </h4>
                                </div>
                                <div class="modal-body">
                                   <div class="form-group">
                                      <input name="transaction_payment_id" type="hidden" value="36">
                                       <label for="account_id">{{$contents->name}}</label>
                                        <textarea type="text" rows="4" id="privacy" name="reply" class="form-control mt-200  " style="height: 140px;">{{$contents->content}}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                 <button type="button" onclick="sendReply(this,<?= $contents->id ?>)" class="btn btn-primary">Save</button>
                                 <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                               </div>
                          </form>
                        </div>
                   </div><!-- /.modal-dialog --></div> 
                   <!-- end model -->
                    <!-- model -->
                    <div class="modal fade account_model" id="contact_modal1{{$contents->id}}" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"><div class="modal-dialog modal-dialog-centered modal-lg" role="document" >
                      <div class="modal-content " style="width:135%">
                          <form id="queryForms_<?=$contents->id?>">
                            @csrf
                              <input name="_token" type="hidden" value="apx5h5sBuUEVxY3XmUn2gfJu2iz145ls84Uht2xQ">
                               <div class="modal-header">
                                   <h4 class="modal-title">Edit Content </h4>
                                </div>
                                <div class="modal-body">
                                   <div class="form-group">
                                      <input name="transaction_payment_id" type="hidden" value="36">
                                       <label for="account_id">{{$contents->name_ar}}</label>
                                        <textarea type="text" rows="4" id="privacy" name="reply_ar" class="form-control mt-200  " style="height: 140px;">{{$contents->content_ar}}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                 <button type="button" onclick="sendReply1(this,<?= $contents->id ?>)" class="btn btn-primary">Save</button>
                                 <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                               </div>
                          </form>
                        </div>
                   </div><!-- /.modal-dialog --></div> 
                   <!-- end model -->
                  
                  @endforeach
                
                  <div class="col-12 design_outter_comman shadow">
                   <form id="queryForms" >
                        @csrf
                     <div class="row comman_header justify-content-between">
                        <div class="col-auto">
                           <h2>Onboarding Screens</h2>
                        </div> 
                        <div class="col-auto">
                           <button type="button" onclick="sendQuery(this)" class="comman_btn">Save</button>
                        </div>
                     </div>
                     <div class="form-design py-5 px-1 row mx-0 align-items-end justify-content-between" action="">
                      @foreach($onboarding_screen as $key=>$onboarding_screens)

                        <div class="col-md-4" >
                           <div class="row Onboarding_box m-0"> 
                              <span class="head_spann">Onboarding {{$key+1}}</span>
                              <div class="form-group col-12">
                                 <div class="account_profile position-relative" >
                                    <div class="circle">
                                       <img id="blah<?= $key+1 ?>" class="profile-pic"  src="{{$onboarding_screens->image?$onboarding_screens->image:asset('assets/img/sidebar_bg.jpg')}}"> 
                                    </div>
                                    <div class="p-image">
                                       <i class="upload-button fas fa-camera"></i> 
                                       <input  id="upload<?= $key+1 ?>" name="images[]" multiple="true" accept="image/*" class="file-upload__input" type="file" onchange="readURL(this, <?= $key+1 ?>);" onchange="setHeightWidth(this);">
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group col-12">
                                 <label for="">Title (En)</label>
                                 <input type="text" value="{{$onboarding_screens->title}}" name="title[]" class="form-control">
                                 <input type="hidden" value="{{$onboarding_screens->id}}" name="id[]" class="form-control">
                              </div>  
                              <div class="form-group col-12 mb-0">
                                 <label for="">Title (Ar)</label>
                                
                                 <input type="text" value= "{{$onboarding_screens->title_ar}}" name="title_ar[]" class="form-control">
                              </div>  
                           </div>
                        </div>
                        @endforeach
                     </div> 
                  </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <script>
   document.getElementById('form1')
   .addEventListener('keyup', function(event) {
           if (event.code === 'Enter')
           {
               event.preventDefault();
               document.querySelector('form').submit();
               
           }
       });
</script>
<script>
         function readURL(input,count) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah'+count)
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
      </script>
@endsection
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>



<script>
    
 function sendQuery(obj) {

var flag = true;
let _token = $('input[name=_token]').val();
var myForm = $("#queryForms")[0];
var formData = new FormData(myForm);
if (flag) {
    $.ajax({
        _token: _token,
        url: '<?= url('admin/onboarding/updateOnboarding/') ?>',
        type: 'POST',
        //data: $("#carForm").serialize(),
        enctype: 'multipart/form-data',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
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
  function sendReply(obj, id) {
	if (id) {

		if (id) {
			$.ajax({
				url: "<?= url('admin/content/update/') ?>/" + id,
				type: 'post',
				data: $("#queryForm_" + id).serialize() + '&_token=<?= csrf_token() ?>',

				success: function(data) {
					swal({
						title: "Success!",
						text: "Your content has been updated",
						icon: "success",
                  buttons: false,
					});
					setTimeout(function() {
						location.reload();
					}, 2000);
				}
			});
		} else {
			$("#error").html("Message field is required");
		}
	} else {
		var data = {
			message: "Something went wrong"
		};
		errorOccured(data);
	}
}
</script>

<script>
  function sendReply1(obj, id) {
            if (id) {

                if (id) {
                    $.ajax({
                        url: "<?= url('admin/content/updates/') ?>/" + id,
                        type: 'post',
                        data: $("#queryForms_"+id).serialize() + '&_token=<?= csrf_token() ?>',
                      
                        success: function (data) {
                            swal({
                                title: "Success!",
                                text : "Your content has been updated \n Click OK to refresh the page",
                                icon : "success",
                             }).then(function() {
                                location.reload();
                            });
                        }
                    });
                } else {
                    $("#error").html("Message field is required");
                }
            } else {
                var data = {message: "Something went wrong"};
                errorOccured(data);
            }
        }
</script>