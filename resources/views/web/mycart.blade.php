@extends('web.layout.master')
@section('content')
      <section class=" breadcrumbs py-md-3 py-2">
         <div class="container-fluid">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="javscript:;">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">My Cart</li>
               </ol>
            </nav>
         </div>
      </section>
      <section class="mycart mb-4">
         <div class="container-fluid">
            <div class="row mx-0 bg-white py-4 position-relative">
               <div class="col-12">
                  <div class="heading_innerpages">
                     <h2><strong>Shopping</strong> cart</h2>
                  </div>
               </div>
               <div class="col-12 px-xl-5 px-lg-4 px-md-4 px-3 pt-lg-5 pt-md-4 pt-4">
                  <div class="cart_table">
                     <div class="table-responsive">
                        <table class="table">
                           <thead>
                              <tr>
                                 <th>Product Details</th>
                                 <th>Quantity</th>
                                 <th>Price</th>
                                 <th>Total</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td>
                                    <div class="row align-items-center flex-lg-wrap flex-md-nowrap flex-wrap">
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
                                             <a class="remove_btn" href="javscript:;">Remove</a>
                                          </div>
                                       </div>
                                    </div>
                                 </td>
                                 <td>
                                    <div class="number">
                                       <span class="minus">-</span>
                                       <input type="text" value="0">
                                       <span class="plus">+</span>
                                    </div>
                                 </td>
                                 <td><span class="pricetext">$751.00</span></td>
                                 <td><span class="pricetext">$1502.00</span></td>
                              </tr>
                              <tr>
                                 <td>
                                    <div class="row align-items-center flex-lg-wrap flex-md-nowrap flex-wrap">
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
                                             <a class="remove_btn" href="javscript:;">Remove</a>
                                          </div>
                                       </div>
                                    </div>
                                 </td>
                                 <td>
                                    <div class="number">
                                       <span class="minus">-</span>
                                       <input type="text" value="0">
                                       <span class="plus">+</span>
                                    </div>
                                 </td>
                                 <td><span class="pricetext">$751.00</span></td>
                                 <td><span class="pricetext">$1502.00</span></td>
                              </tr>
                              <tr>
                                 <td>
                                    <div class="row align-items-center flex-lg-wrap flex-md-nowrap flex-wrap">
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
                                             <a class="remove_btn" href="javscript:;">Remove</a>
                                          </div>
                                       </div>
                                    </div>
                                 </td>
                                 <td>
                                    <div class="number">
                                       <span class="minus">-</span>
                                       <input type="text" value="0">
                                       <span class="plus">+</span>
                                    </div>
                                 </td>
                                 <td><span class="pricetext">$751.00</span></td>
                                 <td><span class="pricetext">$1502.00</span></td>
                              </tr>
                              <tr>
                                 <td>
                                    <div class="row align-items-center flex-nowrap">
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
                                             <a class="remove_btn" href="javscript:;">Remove</a>
                                          </div>
                                       </div>
                                    </div>
                                 </td>
                                 <td>
                                    <div class="number">
                                       <span class="minus">-</span>
                                       <input type="text" value="0">
                                       <span class="plus">+</span>
                                    </div>
                                 </td>
                                 <td><span class="pricetext">$751.00</span></td>
                                 <td><span class="pricetext">$1502.00</span></td>
                              </tr>
                              <tr>
                                 <td>
                                    <div class="row align-items-center flex-lg-wrap flex-md-nowrap flex-wrap">
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
                                             <a class="remove_btn" href="javscript:;">Remove</a>
                                          </div>
                                       </div>
                                    </div>
                                 </td>
                                 <td>
                                    <div class="number">
                                       <span class="minus">-</span>
                                       <input type="text" value="0">
                                       <span class="plus">+</span>
                                    </div>
                                 </td>
                                 <td><span class="pricetext">$751.00</span></td>
                                 <td><span class="pricetext">$1502.00</span></td>
                              </tr>
                              <tr>
                                 <td>

                                 </td>
                                 <td>
                                    
                                 </td>
                                 <td>
                                    
                                 </td>
                                 <td>
                                    <div class="row">
                                       <div class="col-12">
                                          <span class="pricetext mb-4">  Total: $6008.00</span>
                                          <a class="btn_main" href="{{url('checkout')}}">Check Out</a>
                                       </div>
                                    </div>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
@endsection