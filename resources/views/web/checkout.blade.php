@extends('web.layout.master')
@section('content')
      <section class="breadcrumbs py-md-3 py-2">
         <div class="container-fluid">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="javscript:;">Home</a></li>
                  <li class="breadcrumb-item"><a href="javscript:;">My Cart</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Checkout</li>
               </ol>
            </nav>
         </div>
      </section>
      <section class="checkout mb-4">
         <div class="container-fluid">
            <div class="row">
               <div class="col-xl-9 col-lg-10 col-md-12">
                  <div class="row mx-0 bg-white py-4 position-relative">
                     <div class="col-12">
                        <div class="heading_innerpages">
                           <h2><strong>Address</strong></h2>
                        </div>
                     </div>
                     <div class="col-12 px-md-5 pt-md-4">
                        <form class="row" action="">
                           <div class="form-group col-12 custom_radio border-bottom pe-md-5 py-4">
                              <input class="d-none" checked type="radio" id="radio1" name="radio1">
                              <label for="radio1">
                                 <div class="row w-100 align-items-center position-relative py-md-3">
                                    <div class="col-sm">
                                       <div class="address_data">
                                          <h3>Kunal Chi</h3>
                                          <p>BUsiness Bay, Clover Boy Tower, <br>Office No : 2110 Dubai - UAE</p>
                                       </div> 
                                    </div>
                                    <div class="col-md-auto btn_show">
                                       <a class="d-md-block d-inline-block btn_main2 mb-md-2" href="add-new-address.html">Edit</a>
                                       <a class="d-md-block d-inline-block btn_main" href="payment.html">Deliver</a>
                                    </div>
                                 </div>
                              </label>
                           </div>
                           <div class="form-group col-12 custom_radio border-bottom pe-md-5 py-4">
                              <input class="d-none" type="radio" id="radio2" name="radio1">
                              <label for="radio2">
                                 <div class="row w-100 align-items-center position-relative py-md-3">
                                    <div class="col-sm">
                                       <div class="address_data">
                                          <h3>Kunal Chi</h3>
                                          <p>BUsiness Bay, Clover Boy Tower, <br>Office No : 2110 Dubai - UAE</p>
                                       </div> 
                                    </div>
                                    <div class="col-md-auto btn_show">
                                       <a class="d-md-block d-inline-block btn_main2 mb-md-2" href="add-new-address.html">Edit</a>
                                       <a class="d-md-block d-inline-block btn_main" href="payment.html">Deliver</a>
                                    </div>
                                 </div>
                              </label>
                           </div>
                           <div class="form-group col-12 custom_radio pe-md-5 py-4">
                              <input class="d-none" type="radio" id="radio3" name="radio1">
                              <label for="radio3">
                                 <div class="row w-100 align-items-center position-relative py-md-3">
                                    <div class="col-sm">
                                       <div class="address_data">
                                          <h3>Kunal Chi</h3>
                                          <p>BUsiness Bay, Clover Boy Tower, <br>Office No : 2110 Dubai - UAE</p>
                                       </div> 
                                    </div>
                                    <div class="col-md-auto btn_show">
                                       <a class="d-md-block d-inline-block btn_main2 mb-md-2" href="add-new-address.html">Edit</a>
                                       <a class="d-md-block d-inline-block btn_main" href="payment.html">Deliver</a>
                                    </div>
                                 </div>
                              </label>
                           </div> 
                           <div class="form-group col-12 text-end custom_radio pe-5 py-4">
                              <a class="btn_main" href="add-new-address.html">Add Address</a>
                           </div>
                        </form>
                     </div> 
                  </div>
               </div>
            </div>
           
         </div>
      </section>
@endsection
