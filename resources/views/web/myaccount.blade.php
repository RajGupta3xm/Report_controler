@extends('web.layout.master')
@section('content')
      <section class=" breadcrumbs py-md-3 py-2">
         <div class="container-fluid">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="javscript:;">Home</a></li> 
                  <li class="breadcrumb-item active" aria-current="page">My Account</li>
               </ol>
            </nav>
         </div>
      </section>
      <section class="myaccount mb-4">
         <div class="container-fluid">
            <div class="row">
               <div class="col-12 pb-4">
                  <div class="myaccount_profile row">
                     <div class="col-auto">
                        <div class="account_profile position-relative">
                           <div class="circle">
                              <img class="profile-pic" src="{{asset('assets/web/img/profile_img1.png')}}"> 
                            </div>
                            <div class="p-image">
                               <img class="upload-button" src="{{asset('assets/web/img/Camera_icon.png')}}" alt=""> 
                               <input class="file-upload" type="file" accept="image/*"/>
                            </div>
                        </div>
                     </div>
                     <div class="col">
                        <div class="account_detailss mt-3">
                           <h2>Johny Deo</h2>
                           <span>USA</span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-12">
                  <div class="row mx-0 bg-white py-4 position-relative">
                     <div class="col-12 pt-2">
                        <ul class="nav nav-tabs commam_tabs_design" id="myTab" role="tablist">
                           <li class="nav-item" role="presentation">
                             <button class="nav-link active" id="account1-tab" data-bs-toggle="tab" data-bs-target="#account1" type="button" role="tab" aria-controls="account1" aria-selected="true">Order History</button>
                           </li>
                           <li class="nav-item" role="presentation">
                             <button class="nav-link" id="account2-tab" data-bs-toggle="tab" data-bs-target="#account2" type="button" role="tab" aria-controls="account2" aria-selected="false">ADdress Book</button>
                           </li>
                           <li class="nav-item" role="presentation">
                             <button class="nav-link" id="account3-tab" data-bs-toggle="tab" data-bs-target="#account3" type="button" role="tab" aria-controls="account3" aria-selected="false">Account Settings</button>
                           </li>
                           <li class="nav-item" role="presentation">
                              <button class="nav-link" id="account4-tab" data-bs-toggle="tab" data-bs-target="#account4" type="button" role="tab" aria-controls="account4" aria-selected="false">My Favourites</button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link" id="account5-tab" data-bs-toggle="tab" data-bs-target="#account5" type="button" role="tab" aria-controls="account5" aria-selected="false">My garage</button>
                            </li>
                        </ul>
                         <div class="tab-content" id="myTabContent">
                           <div class="tab-pane fade show active" id="account1" role="tabpanel" aria-labelledby="account1-tab"> 
                              <div class="row py-4 px-md-4 px-0 order-history">
                                 <div class="col-12">
                                    <div class="cart_table">
                                       <div class="table-responsive">
                                          <table class="table">
                                             <thead>
                                                <tr>
                                                   <th>Recent Orders <a class="filter_table" href="javscript:;"><img src="{{asset('assets/web/img/sound-module-fill.png')}}" alt=""></a></th>
                                                   <th>Quantity</th> 
                                                   <th>Total Price</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <tr>
                                                   <td>
                                                      <div class="row align-items-center flex-lg-wrap flex-md-nowrap flex-nowrap">
                                                         <div class="col-auto">
                                                            <span class="cart_product">
                                                               <img src="{{asset('assets/web/img/product_img11.png')}}" alt="">
                                                            </span>
                                                         </div>
                                                         <div class="col">
                                                            <div class="cart_content">
                                                               <h3>Blue Lorem Collection</h3>
                                                               <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Facere similique odio sed accusantium.</p>
                                                               <div class="rate_main d-flex align-items-center my-md-3 my-2">
                                                                  <div class="rating_box">
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fal fa-star"></i></a>
                                                                  </div>
                                                                  <span>(216)</span>
                                                               </div>
                                                               <span class="ordertext m-0">Ordered On: 12/12/2021</span>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <span class="quantity_text">2</span>
                                                   </td>
                                                   <td>
                                                      <span class="pricetext">$1502.00</span>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="row align-items-center flex-lg-wrap flex-md-nowrap flex-nowrap">
                                                         <div class="col-auto">
                                                            <span class="cart_product">
                                                               <img src="{{asset('assets/web/img/product_img11.png')}}" alt="">
                                                            </span>
                                                         </div>
                                                         <div class="col">
                                                            <div class="cart_content">
                                                               <h3>Blue Lorem Collection</h3>
                                                               <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Facere similique odio sed accusantium.</p>
                                                               <div class="rate_main d-flex align-items-center my-md-3 my-2">
                                                                  <div class="rating_box">
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fal fa-star"></i></a>
                                                                  </div>
                                                                  <span>(216)</span>
                                                               </div>
                                                               <span class="ordertext m-0">Ordered On: 12/12/2021</span>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <span class="quantity_text">2</span>
                                                   </td>
                                                   <td>
                                                      <span class="pricetext">$1502.00</span>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="row align-items-center flex-lg-wrap flex-md-nowrap flex-nowrap">
                                                         <div class="col-auto">
                                                            <span class="cart_product">
                                                               <img src="{{asset('assets/web/img/product_img11.png')}}" alt="">
                                                            </span>
                                                         </div>
                                                         <div class="col">
                                                            <div class="cart_content">
                                                               <h3>Blue Lorem Collection</h3>
                                                               <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Facere similique odio sed accusantium.</p>
                                                               <div class="rate_main d-flex align-items-center my-md-3 my-2">
                                                                  <div class="rating_box">
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fal fa-star"></i></a>
                                                                  </div>
                                                                  <span>(216)</span>
                                                               </div>
                                                               <span class="ordertext m-0">Ordered On: 12/12/2021</span>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <span class="quantity_text">2</span>
                                                   </td>
                                                   <td>
                                                      <span class="pricetext">$1502.00</span>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="row align-items-center flex-lg-wrap flex-md-nowrap flex-nowrap">
                                                         <div class="col-auto">
                                                            <span class="cart_product">
                                                               <img src="{{asset('assets/web/img/product_img11.png')}}" alt="">
                                                            </span>
                                                         </div>
                                                         <div class="col">
                                                            <div class="cart_content">
                                                               <h3>Blue Lorem Collection</h3>
                                                               <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Facere similique odio sed accusantium.</p>
                                                               <div class="rate_main d-flex align-items-center my-md-3 my-2">
                                                                  <div class="rating_box">
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fal fa-star"></i></a>
                                                                  </div>
                                                                  <span>(216)</span>
                                                               </div>
                                                               <span class="ordertext m-0">Ordered On: 12/12/2021</span>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <span class="quantity_text">2</span>
                                                   </td>
                                                   <td>
                                                      <span class="pricetext">$1502.00</span>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="row align-items-center flex-lg-wrap flex-md-nowrap flex-nowrap">
                                                         <div class="col-auto">
                                                            <span class="cart_product">
                                                               <img src="{{asset('assets/web/img/product_img11.png')}}" alt="">
                                                            </span>
                                                         </div>
                                                         <div class="col">
                                                            <div class="cart_content">
                                                               <h3>Blue Lorem Collection</h3>
                                                               <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Facere similique odio sed accusantium.</p>
                                                               <div class="rate_main d-flex align-items-center my-md-3 my-2">
                                                                  <div class="rating_box">
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                                     <a href="javasript:;"><i class="fal fa-star"></i></a>
                                                                  </div>
                                                                  <span>(216)</span>
                                                               </div>
                                                               <span class="ordertext m-0">Ordered On: 12/12/2021</span>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <span class="quantity_text">2</span>
                                                   </td>
                                                   <td>
                                                      <span class="pricetext">$1502.00</span>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="tab-pane fade" id="account2" role="tabpanel" aria-labelledby="account2-tab">
                              <div class="row py-2 px-lg-5 px-md-4 px-3 address_book">
                                 <div class="col-lg-9">
                                    <form class="row" action="">
                                       <div class="form-group col-12 custom_radio border-bottom py-4">
                                          <input class="d-none" checked="" type="radio" id="radio1" name="radio1">
                                          <label for="radio1">
                                             <div class="row w-100 align-items-center position-relative">
                                                <div class="col-sm">
                                                   <div class="address_data">
                                                      <h3>Kunal Chi</h3>
                                                      <p>BUsiness Bay, Clover Boy Tower, <br>Office No : 2110 Dubai - UAE</p>
                                                   </div> 
                                                </div>
                                                <div class="col-md-auto">
                                                   <a class="d-md-block d-inline-block btn_main2 mb-md-2" href="{{url('add-new-address')}}">Edit</a>
                                                   <a class="d-md-block d-inline-block btn_main" href="{{url('payment')}}">Deliver</a>
                                                </div>
                                             </div>
                                          </label>
                                       </div>
                                       <div class="form-group col-12 custom_radio border-bottom py-4">
                                          <input class="d-none" type="radio" id="radio2" name="radio1">
                                          <label for="radio2">
                                             <div class="row w-100 align-items-center position-relative">
                                                <div class="col-sm">
                                                   <div class="address_data">
                                                      <h3>Kunal Chi</h3>
                                                      <p>BUsiness Bay, Clover Boy Tower, <br>Office No : 2110 Dubai - UAE</p>
                                                   </div> 
                                                </div>
                                                <div class="col-md-auto">
                                                   <a class="d-md-block d-inline-block btn_main2 mb-md-2" href="{{url('add-new-address')}}">Edit</a>
                                                   <a class="d-md-block d-inline-block btn_main" href="{{url('payment')}}">Deliver</a>
                                                </div>
                                             </div>
                                          </label>
                                       </div>
                                       <div class="form-group col-12 custom_radio py-4">
                                          <input class="d-none" type="radio" id="radio3" name="radio1">
                                          <label for="radio3">
                                             <div class="row w-100 align-items-center position-relative">
                                                <div class="col-sm">
                                                   <div class="address_data">
                                                      <h3>Kunal Chi</h3>
                                                      <p>BUsiness Bay, Clover Boy Tower, <br>Office No : 2110 Dubai - UAE</p>
                                                   </div> 
                                                </div>
                                                <div class="col-md-auto">
                                                   <a class="d-md-block d-inline-block btn_main2 mb-md-2" href="{{url('add-new-address')}}">Edit</a>
                                                   <a class="d-md-block d-inline-block btn_main" href="{{url('payment')}}">Deliver</a>
                                                </div>
                                             </div>
                                          </label>
                                       </div> 
                                       <div class="form-group col-12 text-start custom_radio py-4">
                                          <a class="btn_main" href="{{url('add-new-address')}}">Add Address</a>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                           <div class="tab-pane fade" id="account3" role="tabpanel" aria-labelledby="account3-tab">
                              <div class="row p-lg-5 p-md-4 p-3 account_settings">
                                 <div class="col-xl-4 col-lg-6">
                                    <form class="row form_design" action="">
                                       <div class="form-group col-md-12 position-relative">
                                          <label for="">Name</label>
                                          <input class="form-control" type="text" name="name" id="name" value="Johny Deo">
                                       </div>
                                       <div class="form-group col-md-12 position-relative">
                                          <label for="">Email Address</label>
                                          <input class="form-control" type="email" name="email" id="email" value="johnydeo@gmail.com">
                                       </div>
                                       <div class="form-group col-md-12 position-relative">
                                          <label for="">Mobile Number</label>
                                          <input class="form-control" type="text" name="number" id="number" value="+91 9509164217">
                                       </div>
                                       <div class="form-group col-md-12 position-relative">
                                          <label for="">Password</label>
                                          <input id="password-field" class="form-control" type="password" name="password" id="password" value="idontknow"> 
                                          <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                       </div>
                                       <div class="form-group col-md-12 position-relative">
                                          <button class="btn_main">Save</button>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                           <div class="tab-pane fade" id="account4" role="tabpanel" aria-labelledby="account3-tab">
                              <div class="row px-lg-4 px-md-3 px-3 py-lg-5 py-md-4 py-3 my-favourites">
                                 <div class="col-12">
                                    <div class="favourites_outter">
                                       <div class="favourites_box">
                                          <div class="product_parts_box m-0">
                                             <div class="partsproduct_img">
                                                <img src="{{asset('assets/web/img/product_img3.png')}}" alt="Product">
                                                <a class="fav_btn change_btn" href="javscript:;"></a>
                                             </div>
                                             <div class="product_content mt-3 text-center">
                                                <a href="{{url('product')}}">Lorem ipsum dolor.</a>
                                                <div class="rating_box mt-2">
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fal fa-star"></i></a>
                                                </div>
                                                <div class="price">
                                                   <span>$521.00</span> <del>$751.00</del>
                                                </div> 
                                                <div class="number">
                                                   <span class="minus">-</span>
                                                   <input type="text" value="0">
                                                   <span class="plus">+</span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="favourites_box">
                                          <div class="product_parts_box m-0">
                                             <div class="partsproduct_img">
                                                <img src="{{asset('assets/web/img/product_img4.png')}}" alt="Product">
                                                <a class="fav_btn change_btn" href="javscript:;"></a>
                                             </div>
                                             <div class="product_content mt-3 text-center">
                                                <a href="{{url('product')}}">Lorem ipsum dolor.</a>
                                                <div class="rating_box mt-2">
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fal fa-star"></i></a>
                                                </div>
                                                <div class="price">
                                                   <span>$521.00</span> <del>$751.00</del>
                                                </div> 
                                                <div class="number">
                                                   <span class="minus">-</span>
                                                   <input type="text" value="0">
                                                   <span class="plus">+</span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="favourites_box">
                                          <div class="product_parts_box m-0">
                                             <div class="partsproduct_img">
                                                <img src="{{asset('assets/web/img/product_img5.png')}}" alt="Product">
                                                <a class="fav_btn change_btn" href="javscript:;"></a>
                                             </div>
                                             <div class="product_content mt-3 text-center">
                                                <a href="{{url('product')}}">Lorem ipsum dolor.</a>
                                                <div class="rating_box mt-2">
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fal fa-star"></i></a>
                                                </div>
                                                <div class="price">
                                                   <span>$521.00</span> <del>$751.00</del>
                                                </div> 
                                                <div class="number">
                                                   <span class="minus">-</span>
                                                   <input type="text" value="0">
                                                   <span class="plus">+</span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="favourites_box">
                                          <div class="product_parts_box m-0">
                                             <div class="partsproduct_img">
                                                <img src="{{asset('assets/web/img/product_img6.png')}}" alt="Product">
                                                <a class="fav_btn change_btn" href="javscript:;"></a>
                                             </div>
                                             <div class="product_content mt-3 text-center">
                                                <a href="{{url('product')}}">Lorem ipsum dolor.</a>
                                                <div class="rating_box mt-2">
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fal fa-star"></i></a>
                                                </div>
                                                <div class="price">
                                                   <span>$521.00</span> <del>$751.00</del>
                                                </div> 
                                                <div class="number">
                                                   <span class="minus">-</span>
                                                   <input type="text" value="0">
                                                   <span class="plus">+</span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="favourites_box">
                                          <div class="product_parts_box m-0">
                                             <div class="partsproduct_img">
                                                <img src="{{asset('assets/web/img/product_img7.png')}}" alt="Product">
                                                <a class="fav_btn change_btn" href="javscript:;"></a>
                                             </div>
                                             <div class="product_content mt-3 text-center">
                                                <a href="{{url('product')}}">Lorem ipsum dolor.</a>
                                                <div class="rating_box mt-2">
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fal fa-star"></i></a>
                                                </div>
                                                <div class="price">
                                                   <span>$521.00</span> <del>$751.00</del>
                                                </div> 
                                                <div class="number">
                                                   <span class="minus">-</span>
                                                   <input type="text" value="0">
                                                   <span class="plus">+</span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="favourites_box">
                                          <div class="product_parts_box m-0">
                                             <div class="partsproduct_img">
                                                <img src="{{asset('assets/web/img/product_img8.png')}}" alt="Product">
                                                <a class="fav_btn change_btn" href="javscript:;"></a>
                                             </div>
                                             <div class="product_content mt-3 text-center">
                                                <a href="{{url('product')}}">Lorem ipsum dolor.</a>
                                                <div class="rating_box mt-2">
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fal fa-star"></i></a>
                                                </div>
                                                <div class="price">
                                                   <span>$521.00</span> <del>$751.00</del>
                                                </div> 
                                                <div class="number">
                                                   <span class="minus">-</span>
                                                   <input type="text" value="0">
                                                   <span class="plus">+</span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="favourites_box">
                                          <div class="product_parts_box m-0">
                                             <div class="partsproduct_img">
                                                <img src="{{asset('assets/web/img/product_img9.png')}}" alt="Product">
                                                <a class="fav_btn change_btn" href="javscript:;"></a>
                                             </div>
                                             <div class="product_content mt-3 text-center">
                                                <a href="{{url('product')}}">Lorem ipsum dolor.</a>
                                                <div class="rating_box mt-2">
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fal fa-star"></i></a>
                                                </div>
                                                <div class="price">
                                                   <span>$521.00</span> <del>$751.00</del>
                                                </div> 
                                                <div class="number">
                                                   <span class="minus">-</span>
                                                   <input type="text" value="0">
                                                   <span class="plus">+</span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="favourites_box">
                                          <div class="product_parts_box m-0">
                                             <div class="partsproduct_img">
                                                <img src="{{asset('assets/web/img/product_img10.png')}}" alt="Product">
                                                <a class="fav_btn change_btn" href="javscript:;"></a>
                                             </div>
                                             <div class="product_content mt-3 text-center">
                                                <a href="{{url('product')}}">Lorem ipsum dolor.</a>
                                                <div class="rating_box mt-2">
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                   <a href="javasript:;"><i class="fal fa-star"></i></a>
                                                </div>
                                                <div class="price">
                                                   <span>$521.00</span> <del>$751.00</del>
                                                </div> 
                                                <div class="number">
                                                   <span class="minus">-</span>
                                                   <input type="text" value="0">
                                                   <span class="plus">+</span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="tab-pane fade" id="account5" role="tabpanel" aria-labelledby="account3-tab">
                              <div class="row px-lg-4 px-md-3 px-3 py-lg-5 py-md-4 py-3 my-garage">
                                 <div class="col-12">
                                    <div class="row">
                                       <div class="col-12 mb-4 text-end">
                                          <a class="d-inline-block btn_main2 me-md-4 me-2" href="javscript:;">Clear all</a>
                                          <a class="d-inline-block btn_main" data-bs-toggle="modal" data-bs-target="#staticBackdrop07" href="javscript:;">Add Vehicle</a>
                                       </div>
                                       <div class="col-12 mb-4">
                                          <div class="row garage_box align-items-center">
                                             <div class="col-md-auto">
                                                <div class="garage_box_img">
                                                   <img src="{{asset('assets/web/img/garage_img1.png')}}" alt="">
                                                </div>
                                             </div>
                                             <div class="col ps-lg-5 ps-md-3 ps-2">
                                                <div class="garage_content">
                                                   <h2>2020 BMW X1</h2>
                                                   <a class="d-inline-block btn_main" href="javscript:;">delete</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-12 mb-4">
                                          <div class="row garage_box align-items-center">
                                             <div class="col-md-auto">
                                                <div class="garage_box_img">
                                                   <img src="{{asset('assets/web/img/garage_img2.png')}}" alt="">
                                                </div>
                                             </div>
                                             <div class="col ps-lg-5 ps-md-3 ps-2">
                                                <div class="garage_content">
                                                   <h2>2020 BMW X1</h2>
                                                   <a class="d-inline-block btn_main" href="javscript:;">delete</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-12 mb-4">
                                          <div class="row garage_box align-items-center">
                                             <div class="col-md-auto">
                                                <div class="garage_box_img">
                                                   <img src="{{asset('assets/web/img/garage_img3.png')}}" alt="">
                                                </div>
                                             </div>
                                             <div class="col ps-lg-5 ps-md-3 ps-2">
                                                <div class="garage_content">
                                                   <h2>2020 BMW X1</h2>
                                                   <a class="d-inline-block btn_main" href="javscript:;">delete</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-12 mb-4">
                                          <div class="row garage_box align-items-center">
                                             <div class="col-md-auto">
                                                <div class="garage_box_img">
                                                   <img src="{{asset('assets/web/img/garage_img4.png')}}" alt="">
                                                </div>
                                             </div>
                                             <div class="col ps-lg-5 ps-md-3 ps-2">
                                                <div class="garage_content">
                                                   <h2>2020 BMW X1</h2>
                                                   <a class="d-inline-block btn_main" href="javscript:;">delete</a>
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
                  </div>
               </div>
            </div> 
         </div>
      </section>
@endsection