@extends('web.layout.master')
@section('content')
      <section class="make_payment py-4">
         <div class="container-fluid">
            <div class="row">
               <div class="col-xl-9 col-lg-10 col-md-12">
                  <div class="row mx-0 bg-white py-4 position-relative">
                     <div class="col-12">
                        <div class="heading_innerpages">
                           <h2><strong>Payment</strong></h2>
                           <a class="d-inline-block btn_main add_card" href="add-new-card.html">Add New Card</a>
                        </div>
                     </div>
                     <div class="col-12 px-lg-5 px-md-4 px-3 py-md-4 py-3">
                        <form class="row form_design Payment_form" action="">
                           <div class="form-group col-12 m-0 border-bottom py-4">
                              <div class="row py-md-2">
                                 <div class="col-12 custom_radio">
                                    <input class="d-none" checked="" type="radio" id="radio1" name="radio1">
                                    <label for="radio1">HDFC BANK</label>
                                    <div class="row px-md-5 mt-md-3 mt-2">
                                       <div class="px-md-1 px-3 col-md-6 position-relative mb-md-0 mb-2 cardnumber_input">
                                          <input class="form-control" type="text" id="number" name="number" placeholder="0000 0000 0000 6159">
                                          <img class="card_img" src="assets/img/Visa.png" alt="">
                                       </div>
                                       <div class="px-md-1 px-3 position-relative cardname_input">
                                          <input class="form-control text-center px-3" type="text" id="name" name="name" placeholder="Amit Rajora">
                                       </div>
                                       <div class="px-md-1 px-3 col position-relative cardnumber_input">
                                          <input class="form-control text-center px-3" type="text" id="name" name="name" placeholder="12/2023">
                                       </div>
                                       <div class="px-md-1 px-3 col position-relative cardnumber_input">
                                          <input class="form-control text-center px-3" type="text" id="cvv" name="cvv" placeholder="Enter CVV">
                                       </div>
                                    </div>
                                 </div> 
                              </div>
                           </div>  
                           <div class="form-group col-12 m-0 border-bottom py-4">
                              <div class="row py-md-2">
                                 <div class="col-12 custom_radio">
                                    <input class="d-none" type="radio" id="radio2" name="radio1">
                                    <label for="radio2">ICICI BANK</label>
                                    <div class="row px-md-5 mt-md-3 mt-2">
                                       <div class="px-md-1 px-3 col-md-6 position-relative mb-md-0 mb-2 cardnumber_input">
                                          <input class="form-control" type="text" id="number" name="number" placeholder="0000 0000 0000 6159">
                                          <img class="card_img" src="assets/img/Mastercard.png" alt="">
                                       </div>
                                       <div class="px-md-1 px-3 position-relative cardname_input">
                                          <input class="form-control text-center px-3" type="text" id="name" name="name" placeholder="Amit Rajora">
                                       </div>
                                       <div class="px-md-1 px-3 col position-relative cardnumber_input">
                                          <input class="form-control text-center px-3" type="text" id="name" name="name" placeholder="12/2023">
                                       </div>
                                       <div class="px-md-1 px-3 col position-relative cardnumber_input"> 
                                          <!-- Blank Div For Manage Space  -->
                                       </div>
                                    </div>
                                 </div> 
                              </div>
                           </div>  
                           <div class="form-group col-12 m-0 border-bottom py-4">
                              <div class="row py-md-2">
                                 <div class="col-12 custom_radio">
                                    <input class="d-none" type="radio" id="radio3" name="radio1">
                                    <label for="radio3">AXIS BANK</label>
                                    <div class="row px-md-5 mt-md-3 mt-2">
                                       <div class="px-md-1 px-3 col-md-6 position-relative mb-md-0 mb-2 cardnumber_input">
                                          <input class="form-control" type="text" id="number" name="number" placeholder="0000 0000 0000 6159">
                                          <img class="card_img" src="assets/img/Mastercard.png" alt="">
                                       </div>
                                       <div class="px-md-1 px-3 position-relative cardname_input">
                                          <input class="form-control text-center px-3" type="text" id="name" name="name" placeholder="Amit Rajora">
                                       </div>
                                       <div class="px-md-1 px-3 col position-relative cardnumber_input">
                                          <input class="form-control text-center px-3" type="text" id="name" name="name" placeholder="12/2023">
                                       </div>
                                       <div class="px-md-1 px-3 col position-relative cardnumber_input"> 
                                          <!-- Blank Div For Manage Space  -->
                                       </div>
                                    </div>
                                 </div>  
                              </div>
                           </div>  
                           <div class="form-group col-12 m-0 border-bottom py-4">
                              <div class="row py-md-2">
                                 <div class="col-12 custom_radio">
                                    <input class="d-none" type="radio" id="radio4" name="radio1">
                                    <label for="radio4"></label>
                                    <div class="row ps-5 pe-md-4 me-md-1">
                                       <div class="px-md-1 ps-0 pe-3 col-md-10 position-relative">
                                          <input class="form-control" type="text" id="number" name="number" placeholder="Other UPI IDs/Net Banking"> 
                                       </div>  
                                    </div>
                                 </div>  
                              </div>
                           </div> 
                           <div class="form-group col-12 m-0 border-bottom py-4">
                              <div class="row py-md-2">
                                 <div class="col-12 custom_radio">
                                    <input class="d-none" type="radio" id="radio5" name="radio1">
                                    <label for="radio5"></label>
                                    <div class="row ps-5 pe-md-4 me-md-1">
                                       <div class="px-md-1 ps-0 pe-3 col-md-10 position-relative">
                                          <input class="form-control" type="text" id="number" name="number" placeholder="Pay On Delivery"> 
                                       </div>  
                                    </div>
                                 </div>  
                              </div>
                           </div> 
                           <div class="form-group col-12 m-0 py-4"> 
                              <div class="row ps-md-5 promo_code pe-md-4 me-md-1">
                                 <div class="col-12 mb-2">
                                    <label for="">Add Gift Card or Promo Code</label>
                                 </div>
                                 <div class="px-md-1 col-md-6 col position-relative mb-md-0 mb-2">
                                    <input class="form-control" type="text" id="number" name="number" placeholder="Enter Code"> 
                                 </div>  
                                 <div class="px-md-1 ps-0 ms-md-4 ms-2 col-auto position-relative">
                                    <button type="submit" class="btn_main2">Apply</button>
                                 </div>  
                              </div> 
                           </div> 
                           <div class="form-group col-12 m-0 pt-md-4"> 
                              <div class="row ps-md-5 ps-2 promo_code pe-md-4 me-md-1"> 
                                 <div class="px-md-1 px-3 col-auto position-relative">
                                    <button type="submit" class="btn_main">Continue</button>
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