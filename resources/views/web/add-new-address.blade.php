@extends('web.layout.master')
@section('content')
      <section class="breadcrumbs py-md-3 py-2">
         <div class="container-fluid">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="javscript:;">Home</a></li>
                  <li class="breadcrumb-item"><a href="javscript:;">My Cart</a></li>
                  <li class="breadcrumb-item"><a href="javscript:;">Checkout</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Add New Address</li>
               </ol>
            </nav>
         </div>
      </section>
      <section class="add-address mb-4">
         <div class="container-fluid">
            <div class="row">
               <div class="col-xl-9 col-lg-10 col-md-12">
                  <div class="row mx-0 bg-white py-4 position-relative">
                     <div class="col-12">
                        <div class="heading_innerpages">
                           <h2><strong>Add</strong> Address</h2>
                        </div>
                     <div class="col-12 px-lg-5 px-md-4 px-3 py-md-4 py-3">
                        <form class="row form_design pt-3" action="">
                           <div class="form-group col-md-6">
                              <label for="">Your Country</label>
                              <select class="form-select" aria-label="Default select example">
                                 <option selected="">India</option>
                                 <option value="1">50</option>
                                 <option value="2">100</option>
                                 <option value="3">1000</option>
                              </select>
                           </div>
                           <div class="form-group col-md-6">
                              <label for="">Full Name</label>
                              <input class="form-control" type="text" name="name" id="name" placeholder="Name">
                           </div>
                           <div class="form-group col-md-6">
                              <label for="">Mobile Number</label>
                              <input class="form-control" type="number" name="number" id="number" placeholder="000-000-0000">
                           </div>
                           <div class="form-group col-md-6">
                              <label for="">Pincode</label>
                              <input class="form-control" type="number" name="number" id="number" placeholder="11052">
                           </div>
                           <div class="form-group col-md-12">
                              <label for="">Address</label>
                              <input class="form-control" type="text" name="address" id="address" placeholder="Flat No./House No./Building Name">
                           </div>
                           <div class="form-group col-md-4">
                              <label for="">Landmark</label>
                              <input class="form-control" type="text" name="address" id="address" placeholder="Near SDM Office..">
                           </div>
                           <div class="form-group col-md-4">
                              <label for="">City</label>
                              <input class="form-control" type="text" name="address" id="address" placeholder="Makrana">
                           </div>
                           <div class="form-group col-md-4">
                              <label for="">State</label>
                              <input class="form-control" type="text" name="address" id="address" placeholder="Rajasthan">
                           </div>
                           <div class="form-group col-md-12 mt-4">
                              <a class="btn_main2 me-md-4 me-2" href="javascript:;">Cancel</a>
                              <a class="btn_main" href="payment.html">Use This Address</a>
                           </div>
                        </form>
                     </div> 
                  </div>
               </div>
            </div> 
         </div>
      </section>
@endsection
