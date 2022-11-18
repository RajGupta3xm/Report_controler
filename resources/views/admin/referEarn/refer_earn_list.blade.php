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
                        <div class="col-12 text-end mb-4">
                           <a class="information_box shadow" data-bs-toggle="modal" data-bs-target="#exampleModal" href="javascript:;"><i class="fas fa-info"></i></a>
                        </div>
                        <div class="col-12 design_outter_comman shadow mb-4">
                           <div class="row comman_header justify-content-between">
                              <div class="col">
                                 <h2>Refer and Earn</h2>
                              </div>
                              <div class="col-auto refer-earn">
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
                                                <div class="col-3">
                                                   <input class="form-control" type="text" name="register_referee" >
                                                </div>
                                                <div class="col-3">
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
                                                <div class="col-3">
                                                   <input class="form-control" type="text" name="plan_purchase_referee">
                                                </div>
                                                <div class="col-3">
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
                                    <div class="col-6">
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
                                          <div class="form-group mb-4 col-12 textarea_height"> 
                                             <label for="">Message body on sharing (En) :</label>
                                             <textarea class="form-control text-start" name="message_body_en" id="">
                                             </textarea>  
                                          </div>
                                          <div class="form-group mb-4 col-12 textarea_height"> 
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
                        <div class="col-12 design_outter_comman shadow">
                           <div class="row comman_header justify-content-between">
                              <div class="col-auto">
                                 <h2>History Table</h2>
                              </div>
                              <div class="col-auto">
                                 <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="comman_btn">Export to Excel</button>
                              </div>
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
                                          <tr>
                                             <td>1</td>
                                             <td>Ajay Sharma</td>
                                             <td>7367835675</td>
                                             <td>6</td>
                                             <td>3x50</td>
                                             <td>150</td>
                                             <td>3x50</td>
                                             <td>150</td>
                                             <td>300</td>
                                          </tr>
                                          <tr>
                                             <td>2</td>
                                             <td>Vijay Sharma</td>
                                             <td>7367835675</td>
                                             <td>7</td>
                                             <td>2x50</td>
                                             <td>100</td>
                                             <td>5x50</td>
                                             <td>250</td>
                                             <td>350</td>
                                          </tr>
                                          <tr>
                                             <td>3</td>
                                             <td>Modh. Aarif</td>
                                             <td>7367835675</td>
                                             <td>8</td>
                                             <td>3x50</td>
                                             <td>150</td>
                                             <td>5x50</td>
                                             <td>250</td>
                                             <td>400</td>
                                          </tr>
                                          <tr>
                                             <td>4</td>
                                             <td>Vijay Sharma</td>
                                             <td>7367835675</td>
                                             <td>9</td>
                                             <td>5x50</td>
                                             <td>250</td>
                                             <td>4x50</td>
                                             <td>200</td>
                                             <td>450</td>
                                          </tr>
                                          <tr>
                                             <td>5</td>
                                             <td>Modh. Aarif</td>
                                             <td>7367835675</td>
                                             <td>10</td>
                                             <td>4x50</td>
                                             <td>200</td>
                                             <td>6x50</td>
                                             <td>300</td>
                                             <td>500</td>
                                          </tr>
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
                     <div class="col-md-6 d-flex align-items-stretch">
                        <div class="border row content_management_box me-0">
                           <h2>Terms & Condition</h2>
                           <a class="edit_content_btn comman_btn" href="javscript:;"><i class="far fa-edit me-2"></i>Edit</a>
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar sic tempor. Sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin sodales pulvinar sic tempor. Sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                        </div>
                     </div>
                     <div class="col-md-6 d-flex align-items-stretch">
                        <div class="border row content_management_box ms-0 text-end">
                           <h2>معلومات عنا</h2>
                           <a class="edit_content_btn comman_btn" href="javscript:;"><i class="far fa-edit me-2"></i>Edit</a>
                           <p>لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار  النشوة وتمجيد الألم نشأت  بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي. 
                              و سأعرض مثال حي لهذا، من منا لم يتحمل جهد بدني شاق إلا من أجل الحصول على ميزة أو فائدة؟ ولكن من لديه الحق أن ينتقد شخص ما أراد أن يشعر بالسعادة التي لا تشوبها عواقب أليمة أو آخر أراد أن يتجنب الألم الذي ربما تنجم عنه بعض المتعة 
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