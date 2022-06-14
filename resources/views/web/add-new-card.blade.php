@extends('web.layout.master')
@section('content')
   
      <section class="addnew_card py-4">
         <div class="container-fluid">
            <div class="row">
               <div class="col-xl-9 col-lg-10 col-md-12">
                  <div class="row mx-0 bg-white py-4 position-relative">
                     <div class="col-12">
                        <div class="heading_innerpages">
                           <h2><strong>Add</strong> New Card</h2> 
                        </div> 
                     </div>
                     <div class="col-12 px-lg-5 px-md-4 px-3 py-lg-5 py-md-4 py-3">
                        <form class="row form_design add_cardform" action="">
                            <div class="col-md-4">
                               <div class="addcard_img">
                                  <img src="assets/img/Card.png" alt="">
                               </div>
                            </div>
                            <div class="col-md-5 mt-md-0 mt-4">
                               <div class="row form-group mb-4">
                                  <div class="col-12 mb-2">
                                    <label for="">Card Number</label>
                                  </div>
                                  <div class="col-12 position-relative cardnumber_input pe-md-1"> 
                                    <input class="form-control" type="text" id="number" name="number" placeholder="0000 0000 0000 6159">
                                    <img class="card_img" src="assets/img/Visa.png" alt="">
                                 </div>
                               </div> 
                               <div class="row form-group mb-4">
                                 <div class="col-12 mb-2">
                                   <label for="">Card Holder Name</label>
                                 </div>
                                 <div class="col-12 pe-md-1"> 
                                   <input class="form-control" type="text" id="name" name="name" placeholder="Card Holder Name"> 
                                </div>
                               </div> 
                               <div class="row form-group mb-4">
                                    <div class="col-12 mb-2">
                                    <label for="">Expiry Date</label>
                                    </div>
                                    <div class="col-lg-4 col-md-5 col-5 pe-md-1"> 
                                    <input class="form-control" type="text" id="name" name="name" placeholder="00/0000"> 
                                    </div>
                               </div>  
                               <div class="row form-group mb-0"> 
                                 <div class="col-4 pe-md-1"> 
                                    <a href="javscript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop5"  class="btn_main">Continue</a> 
                                 </div>
                               </div> 
                            </div>
                        </form>
                     </div> 
                  </div>
               </div>
            </div>
         </div>
      </section>
@endsection
      