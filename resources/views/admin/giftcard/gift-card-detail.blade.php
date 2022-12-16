@extends('admin.layout.master')
@section('content')
      <div class="admin_main"> 
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
               <div class="row gift-card-management justify-content-center">
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
                        <div class="col-12 design_outter_comman shadow mb-4">
                           <div class="row comman_header justify-content-between">
                              <div class="col-auto">
                                 <h2>Add New Gift Card 
                                 </h2>
                              </div> 
                           </div>
                           <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/giftCard_submit')}}">
                           {{ csrf_field() }}  
                              <div class="form-group col-4">
                                 <label for="">Gift Card Name (En) </label>
                                 <input type="text" class="form-control validate" value="" name="name_en" id="name">
                                 <p class="text-danger text-small" id="name_enError"></p>
                              </div>
                              <div class="form-group col-4">
                                 <label for="">Gift Card Name (Ar) </label>
                                 <input type="text" class="form-control validate" value="" name="name_ar" id="name">
                                 <p class="text-danger text-small" id="name_arError"></p>
                              </div>
                              <div class="form-group col-4 choose_file position-relative">
                                 <span>Upload Image</span>
                                 <label for="upload_video"><i class="fal fa-camera me-1"></i>Choose File</label>
                                 <input type="file" class="form-control validate" value="" name="image" id="upload_video">
                                 <p class="text-danger text-small" id="imageError"></p>
                              </div> 
                              <div class="form-group col-6 description_box">
                                 <label for="">Description (En) :</label>
                                 <textarea class="form-control validate" name="description" id=""></textarea>
                                 <p class="text-danger text-small" id="descriptionError"></p>
                              </div>
                              <div class="form-group col-6 description_box">
                                 <label for="">Description (Ar) :</label>
                                 <textarea class="form-control validate" name="description_ar" id=""></textarea>
                                 <p class="text-danger text-small" id="description_arError"></p>
                              </div>
                              <div class="col mb-0">
                                 <div class="row align-items-end">
                                    <div class="col-auto">
                                       <a class="change_value" onclick="toggleVisibility('Menu1');" href="javascript:;">Discount</a>
                                       <a class="change_value" onclick="toggleVisibility('Menu2');" href="javascript:;">Price</a>
                                    </div>
                                    <div id="Menu1" class="col form-group position-relative percentage_icons mb-0">
                                       <label for="">Discount %</label>
                                       <input class="form-control " type="text" value="" name="discount">
                                       <p class="text-danger text-small" id="discountError"></p>
                                       <div class="icon">%</div>
                                    </div>
                                    <div id="Menu2" class="form-group mb-0 col" style="display: none;">
                                       <label for="">Price</label>
                                       <input type="text" class="form-control " value="" name="price" id="price">
                                       <p class="text-danger text-small" id="priceError"></p>
                                    </div>
                                 </div>
                             </div> 
                             <div class="form-group mb-0 col-4 description_box ">
                                 <label for="">Gift Card Amount :</label>
                                 <input type="text" class="form-control" value="" name="gift_card_amount" id="">
                                 <p class="text-danger text-small" id="gift_card_amountError"></p>
                              </div>
                              <!-- <div class="col form-group position-relative percentage_icons mb-0">
                                 <label for="">Discount %</label>
                                 <input class="form-control validate" type="text" value="" name="discount">
                                 <p class="text-danger text-small" id="discountError"></p>
                                 <div class="icon">%</div>
                              </div>
                              <div class="form-group mb-0 col">
                                 <label for="">Price</label>
                                 <input type="text" class="form-control validate" value="" name="price" id="price">
                                 <p class="text-danger text-small" id="priceError"></p>
                              </div>  -->
                              <div class="form-group mb-0 col-auto">
                                 <button type="button" class="comman_btn" onclick="validate(this);">Save</button>
                              </div>
                           </form>
                        </div>
                        <div class="col-12 design_outter_comman shadow">
                           <div class="row comman_header justify-content-between">
                              <div class="col-auto">
                                 <h2>Gift Card Management</h2>
                              </div>
                              <div class="col-3">
                                  
                              </div>
                           </div>
                           <!-- <form class="form-design py-4 px-3 row align-items-end justify-content-between" action="">
                              <div class="form-group mb-0 col-5">
                                 <label for="">From</label>
                                 <input type="date" class="form-control">
                              </div>
                              <div class="form-group mb-0 col-5">
                                 <label for="">To</label>
                                 <input type="date" class="form-control">
                              </div>
                              <div class="form-group mb-0 col-auto">
                                 <button class="comman_btn">Search</button>
                              </div> 
                           </form> -->
                           <div class="row">
                              <div class="col-12 comman_table_design px-0">
                                 <div class="table-responsive">
                                    <table class="table mb-0">
                                       <thead>
                                         <tr>
                                           <th>S.No.</th>
                                           <th>Name (En)</th>
                                           <th>Name (Ar)</th>
                                           <th>Image</th>
                                           <th>Discount %</th>
                                           <th>Price</th>  
                                           <th>Gift Card Amount</th> 
                                           <th>Status</th>
                                           <th>Action</th>
                                         </tr>
                                       </thead>
                                       <tbody>
                                        @if($giftCards)
                                        @foreach($giftCards as $key=>$giftCard)
                                         <tr>
                                           <td>{{$key+1}}</td>
                                           <td>{{$giftCard->title ?? 'N/A'}}</td>
                                           <td>{{$giftCard->title_ar ?? 'N/A'}}</td>
                                           <td><img class="table_img" src="{{$giftCard->image?$giftCard->image:asset('assets/img/bg-img.jpg')}}" alt=""></td>
                                           <td>{{$giftCard->discount ?? 'N/A'}}</td> 
                                           <td>{{$giftCard->amount ?? 'N/A'}}</td>  
                                           <td>{{$giftCard->gift_card_amount ?? '-'}}</td>  
                                           <td>
                                           <!-- <form class="table_btns d-flex align-items-center"> 
                                                <div class="check_toggle">
                                                   <input type="checkbox" checked="" name="check2" id="check2" class="d-none">
                                                   <label for="check2"></label>
                                                </div>
                                             </form> -->
                                             <div class="mytoggle">
                                             <label class="switch">
                                             <input type="checkbox" onchange="changeStatus(this, '<?= $giftCard->id ?>');" <?= ( $giftCard->status == 'active' ? 'checked' : '') ?> ><span class="slider round"> </span> 
                                             </label>
                                         </div>
                                           </td>
                                           <td>
                                            <a class="comman_btn table_viewbtn delete_btn" onclick="deleteData(this,'{{$giftCard->id}}');" href="javscript:;">Delete</a>
                                           </td>
                                         </tr> 
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
         </div>
      </div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script>
        var divs = ["Menu1", "Menu2",];
         var visibleDivId = null;
         function toggleVisibility(divId) {
         if(visibleDivId === divId) {
            //visibleDivId = null;
         } else {
            visibleDivId = divId;
         }
         hideNonVisibleDivs();
         }
         function hideNonVisibleDivs() {
         var i, divId, div;
         for(i = 0; i < divs.length; i++) {
            divId = divs[i];
            div = document.getElementById(divId);
            if(visibleDivId === divId) {
               div.style.display = "block";
            } else {
               div.style.display = "none";
            }
         }
         }
     </script>
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
    @endsection

    <script>
            function validate(obj) {
            $(".text-danger").html('');
            var flag = true;
            var formData = $("#addForm").find(".validate:input").not(':input[type=button]');
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

    <script>
       function changeStatus(obj, id) {
            swal({
                title: "Are you sure?",
                text: " status will be updated",
                icon: "warning",
                buttons: ["No", "Yes"],
                dangerMode: true,
            })
                    .then((willDelete) => {
                        if (willDelete) {
                            var checked = $(obj).is(':checked');
                            if (checked == true) {
                                var status = 'active';
                            } else {
                                var status = 'inactive';
                            }
                            if (id) {
                                $.ajax({
                                    url: "<?= url('admin/giftCard/change_status') ?>",
                                    type: 'post',
                                    data: 'id=' + id + '&action=' + status + '&_token=<?= csrf_token() ?>',
                                    success: function (data) {
                                    
                                        swal({
                                           title: "Success!",
                                            text : " Status has been Updated ",
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
                        url : "<?= url('admin/giftCard-delete') ?>",
                        type : "POST",
                        data : 'id=' + id + '&_token=<?= csrf_token() ?>',
                        success: function(data){
                            swal({
                                title: "Success!",
                                text : "Gift card has been deleted \n Click OK to refresh the page",
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