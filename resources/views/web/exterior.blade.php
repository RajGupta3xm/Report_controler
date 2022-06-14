@extends('web.layout.master')
@section('content')
      <section class="home_banner mt-2">
         <div class="container-fluid">
            <div class="home_banner_img">
               <div class="container position-relative">
                  <div class="row">
                     <div class="col-12 banner_heading">
                        <h1><span></span> Vehicle Exterior Design <br> Lorem Ipsum Set</h1>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                     </div>
                     <div class="col-12 mt-3">
                        <div class="banner_tabs">
                           <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
                              <li class="nav-item" role="presentation">
                                 <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><img src="assets/img/car_icon.png" alt=""> Car & Truck</button>
                              </li>
                              <li class="nav-item" role="presentation">
                                 <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"><img src="assets/img/bike_icon.png" alt="">Motercycle</button>
                              </li>
                              <li class="nav-item" role="presentation">
                                 <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false"><img src="assets/img/semi_truck_icon.png" alt="">Semi Truck</button>
                              </li>
                              <li class="nav-item" role="presentation">
                                 <button class="nav-link" id="contact1-tab" data-bs-toggle="tab" data-bs-target="#contact1" type="button" role="tab" aria-controls="contact1" aria-selected="false"><img src="assets/img/truck_icon.png" alt="">Truck</button>
                              </li>
                           </ul>
                           <div class="tab-content" id="myTabContent">
                              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                 <div class="row mx-0">
                                    <div class="col-xl-11 data_tabs_design">
                                       <div class="row mx-md-0">
                                          <div class="col-sm ps-md-0 pe-md-1">
                                             <select class="form-select" aria-label="Default select example">
                                                <option selected>Year</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                             </select>
                                          </div>
                                          <div class="col-sm px-md-1">
                                             <select class="form-select" aria-label="Default select example">
                                                <option selected>Brand</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                             </select>
                                          </div>
                                          <div class="col-sm px-md-1">
                                             <select class="form-select" aria-label="Default select example">
                                                <option selected>Modal</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                             </select>
                                          </div>
                                          <div class="col-md-auto px-md-1">
                                             <button class="button-form" type="button">
                                             Go
                                             </button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                 <div class="row mx-0">
                                    <div class="col-xl-11 data_tabs_design">
                                       <div class="row mx-md-0">
                                          <div class="col-sm ps-md-0 pe-md-1">
                                             <select class="form-select" aria-label="Default select example">
                                                <option selected>Year</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                             </select>
                                          </div>
                                          <div class="col-sm px-md-1">
                                             <select class="form-select" aria-label="Default select example">
                                                <option selected>Brand</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                             </select>
                                          </div>
                                          <div class="col-sm px-md-1">
                                             <select class="form-select" aria-label="Default select example">
                                                <option selected>Modal</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                             </select>
                                          </div>
                                          <div class="col-md-auto px-md-1">
                                             <button class="button-form" type="button">
                                             Go
                                             </button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                 <div class="row mx-0">
                                    <div class="col-xl-11 data_tabs_design">
                                       <div class="row mx-md-0">
                                          <div class="col-sm ps-md-0 pe-md-1">
                                             <select class="form-select" aria-label="Default select example">
                                                <option selected>Year</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                             </select>
                                          </div>
                                          <div class="col-sm px-md-1">
                                             <select class="form-select" aria-label="Default select example">
                                                <option selected>Brand</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                             </select>
                                          </div>
                                          <div class="col-sm px-md-1">
                                             <select class="form-select" aria-label="Default select example">
                                                <option selected>Modal</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                             </select>
                                          </div>
                                          <div class="col-md-auto px-md-1">
                                             <button class="button-form" type="button">
                                             Go
                                             </button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="tab-pane fade" id="contact1" role="tabpanel" aria-labelledby="contact1-tab">
                                 <div class="row mx-0">
                                    <div class="col-xl-11 data_tabs_design">
                                       <div class="row mx-md-0">
                                          <div class="col-sm ps-md-0 pe-md-1">
                                             <select class="form-select" aria-label="Default select example">
                                                <option selected>Year</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                             </select>
                                          </div>
                                          <div class="col-sm px-md-1">
                                             <select class="form-select" aria-label="Default select example">
                                                <option selected>Brand</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                             </select>
                                          </div>
                                          <div class="col-sm px-md-1">
                                             <select class="form-select" aria-label="Default select example">
                                                <option selected>Modal</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                             </select>
                                          </div>
                                          <div class="col-md-auto px-md-1">
                                             <button class="button-form" type="button">
                                             Go
                                             </button>
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
      <section class="breadcrumbs py-md-3 py-2">
         <div class="container-fluid">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb mb-0">
                 <li class="breadcrumb-item"><a href="javscript:;">Home</a></li>
                 <li class="breadcrumb-item"><a href="javscript:;">All Products</a></li>
                 <li class="breadcrumb-item active" aria-current="page">Exterior</li>
               </ol>
             </nav>
         </div>
      </section>  
      <section class="exterior_accessories mb-4">
         <div class="container-fluid">
            <div class="row mx-0 bg-white position-relative product_main_inner py-4">
               <div class="col-12">
                  <div class="heading_innerpages">
                     <h2><strong>Exterior</strong> Accessories</h2>
                  </div>
               </div>
               <div class="col-12">
                  <div class="row pt-4">
                     <div class="col-12">
                        <div class="product_main_parts commansldier_btn owl-carousel"> 
                           <div class="slider_box">
                             <div class="product_parts_box">
                                <a href="product.html" class="partsproduct_img">
                                   <img src="assets/img/product_img3.png" alt="Product">
                                </a>
                                <div class="product_content mt-3 text-center">
                                              <a href="product.html">Lorem ipsum dolor.</a> 
                                </div>
                             </div>
                             <div class="product_parts_box">
                                <a href="product.html" class="partsproduct_img">
                                   <img src="assets/img/product_img4.png" alt="Product">
                                </a>
                                <div class="product_content mt-3 text-center">
                                              <a href="product.html">Lorem ipsum dolor.</a> 
                                </div>
                             </div> 
                           </div> 
                           <div class="slider_box">
                             <div class="product_parts_box">
                                <a href="product.html" class="partsproduct_img">
                                   <img src="assets/img/product_img5.png" alt="Product">
                                </a>
                                <div class="product_content mt-3 text-center">
                                              <a href="product.html">Lorem ipsum dolor.</a> 
                                </div>
                             </div>
                             <div class="product_parts_box">
                                <a href="product.html" class="partsproduct_img">
                                   <img src="assets/img/product_img6.png" alt="Product">
                                </a>
                                <div class="product_content mt-3 text-center">
                                              <a href="product.html">Lorem ipsum dolor.</a> 
                                </div>
                             </div> 
                           </div> 
                           <div class="slider_box">
                             <div class="product_parts_box">
                                <a href="product.html" class="partsproduct_img">
                                   <img src="assets/img/product_img1.png" alt="Product">
                                </a>
                                <div class="product_content mt-3 text-center">
                                              <a href="product.html">Lorem ipsum dolor.</a> 
                                </div>
                             </div>
                             <div class="product_parts_box">
                                <a href="product.html" class="partsproduct_img">
                                   <img src="assets/img/product_img2.png" alt="Product">
                                </a>
                                <div class="product_content mt-3 text-center">
                                              <a href="product.html">Lorem ipsum dolor.</a> 
                                </div>
                             </div> 
                           </div> 
                           <div class="slider_box">
                             <div class="product_parts_box">
                                <a href="product.html" class="partsproduct_img">
                                   <img src="assets/img/product_img7.png" alt="Product">
                                </a>
                                <div class="product_content mt-3 text-center">
                                              <a href="product.html">Lorem ipsum dolor.</a> 
                                </div>
                             </div>
                             <div class="product_parts_box">
                                <a href="product.html" class="partsproduct_img">
                                   <img src="assets/img/product_img8.png" alt="Product">
                                </a>
                                <div class="product_content mt-3 text-center">
                                              <a href="product.html">Lorem ipsum dolor.</a> 
                                </div>
                             </div> 
                           </div> 
                           <div class="slider_box">
                             <div class="product_parts_box">
                                <a href="product.html" class="partsproduct_img">
                                   <img src="assets/img/product_img9.png" alt="Product">
                                </a>
                                <div class="product_content mt-3 text-center">
                                              <a href="product.html">Lorem ipsum dolor.</a> 
                                </div>
                             </div>
                             <div class="product_parts_box">
                                <a href="product.html" class="partsproduct_img">
                                   <img src="assets/img/product_img10.png" alt="Product">
                                </a>
                                <div class="product_content mt-3 text-center">
                                              <a href="product.html">Lorem ipsum dolor.</a> 
                                </div>
                             </div> 
                           </div> 
                           <div class="slider_box">
                             <div class="product_parts_box">
                                <a href="product.html" class="partsproduct_img">
                                   <img src="assets/img/product_img11.png" alt="Product">
                                </a>
                                <div class="product_content mt-3 text-center">
                                              <a href="product.html">Lorem ipsum dolor.</a> 
                                </div>
                             </div>
                             <div class="product_parts_box">
                                <a href="product.html" class="partsproduct_img">
                                   <img src="assets/img/product_img12.png" alt="Product">
                                </a>
                                <div class="product_content mt-3 text-center">
                                              <a href="product.html">Lorem ipsum dolor.</a> 
                                </div>
                             </div> 
                           </div>
                           <div class="slider_box">
                             <div class="product_parts_box">
                                <a href="product.html" class="partsproduct_img">
                                   <img src="assets/img/product_img7.png" alt="Product">
                                </a>
                                <div class="product_content mt-3 text-center">
                                              <a href="product.html">Lorem ipsum dolor.</a>                                      
                                </div>
                             </div>
                             <div class="product_parts_box">
                                <a href="product.html" class="partsproduct_img">
                                   <img src="assets/img/product_img8.png" alt="Product">
                                </a>
                                <div class="product_content mt-3 text-center">
                                              <a href="product.html">Lorem ipsum dolor.</a>                                      
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
      <section class="custom_informations py-5">
         <div class="container">
            <div class="row">
               <div class="col-md-4">
                  <div class="custom_informations_box long_img mb-md-0 mb-4" style="background-image:url('assets/img/custom-wheels.png');">
                    <div class="custom_inner">
                        <h3>Custom Wheels</h3> 
                        <a class="common_btn mt-4" href="product.html">
                           Shop Now
                        </a>
                    </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="custom_informations_box short_img" style="background-image:url('assets/img/seat_cover.png');">
                    <div class="custom_inner">
                        <h3>Seat Cover</h3> 
                        <a class="common_btn mt-4" href="product.html">
                           Shop Now
                        </a>
                    </div>
                  </div>
                  <div class="custom_informations_box short_img mt-4" style="background-image:url('assets/img/suspension.png');">
                     <div class="custom_inner">
                         <h3>Suspension</h3> 
                         <a class="common_btn mt-4" href="product.html">
                            Shop Now
                         </a>
                     </div>
                   </div>
               </div>
               <div class="col-md-4">
                  <div class="custom_informations_box long_img mt-md-0 mt-4" style="background-image:url('assets/img/lightingimg.png');">
                    <div class="custom_inner">
                        <h3>Lighting</h3> 
                        <a class="common_btn mt-4" href="product.html">
                           Shop Now
                        </a>
                    </div>
                  </div>
               </div>
            </div>
         </div>
      </section>  
      <section class="product_main pb-4">
         <div class="container-fluid">
            <div class="row mx-0 bg-white position-relative product_main_inner py-4">
               <div class="col-12 pt-2">
                  <ul class="nav nav-tabs commam_tabs_design" id="myTab" role="tablist">
                     <li class="nav-item" role="presentation">
                       <button class="nav-link active" id="home1-tab" data-bs-toggle="tab" data-bs-target="#home1" type="button" role="tab" aria-controls="home1" aria-selected="true">New Arrivals</button>
                     </li>
                     <li class="nav-item" role="presentation">
                       <button class="nav-link" id="profile1-tab" data-bs-toggle="tab" data-bs-target="#profile1" type="button" role="tab" aria-controls="profile1" aria-selected="false">Best Sellers</button>
                     </li>
                     <li class="nav-item" role="presentation">
                       <button class="nav-link" id="contact3-tab" data-bs-toggle="tab" data-bs-target="#contact3" type="button" role="tab" aria-controls="contact3" aria-selected="false">Featured Products</button>
                     </li>
                  </ul>
                   <div class="tab-content" id="myTabContent">
                     <div class="tab-pane fade show active" id="home1" role="tabpanel" aria-labelledby="home1-tab"> 
                        <div class="row pt-4">
                           <div class="col-12">
                               <div class="product_main_parts commansldier_btn owl-carousel"> 
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img3.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img4.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img5.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img6.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img1.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img2.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img7.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img8.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img9.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img10.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img11.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img12.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img7.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img8.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                     <div class="tab-pane fade" id="profile1" role="tabpanel" aria-labelledby="profile1-tab">
                        <div class="row pt-4">
                           <div class="col-12">
                               <div class="product_main_parts commansldier_btn owl-carousel"> 
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img3.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img4.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img5.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img6.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img1.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img2.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img7.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img8.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img9.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img10.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img11.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img12.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img7.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img8.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                     <div class="tab-pane fade" id="contact3" role="tabpanel" aria-labelledby="contact3-tab">
                        <div class="row pt-4">
                           <div class="col-12">
                               <div class="product_main_parts commansldier_btn owl-carousel"> 
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img3.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img4.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img5.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img6.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img1.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img2.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img7.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img8.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img9.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img10.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img11.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img12.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                  <div class="slider_box">
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img7.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                                    <div class="product_parts_box">
                                       <a href="product.html" class="partsproduct_img">
                                          <img src="assets/img/product_img8.png" alt="Product">
                                       </a>
                                       <div class="product_content mt-3 text-center">
                                          <a href="product.html">Lorem ipsum dolor.</a>
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
                   </div>
               </div> 
            </div>
         </div>
      </section>    
      <section class="Featured_modal pb-4">
         <div class="container-fluid"> 
            <div class="row mx-0 bg-white position-relative product_main_inner py-4">
               <div class="col-12 pt-2">
                  <ul class="nav nav-tabs commam_tabs_design" id="myTab" role="tablist">
                     <li class="nav-item" role="presentation">
                       <button class="nav-link active" id="home2-tab" data-bs-toggle="tab" data-bs-target="#home2" type="button" role="tab" aria-controls="home2" aria-selected="true">Featured Makes</button>
                     </li>
                     <li class="nav-item" role="presentation">
                       <button class="nav-link" id="profile2-tab" data-bs-toggle="tab" data-bs-target="#profile2" type="button" role="tab" aria-controls="profile2" aria-selected="false">Featured Modals</button>
                     </li> 
                  </ul>
                   <div class="tab-content" id="myTabContent">
                     <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home2-tab"> 
                        <div class="row pt-4">
                           <div class="col-12">
                               <div class="featured_modal_slider commansldier_btn owl-carousel"> 
                                  <div class="slider_box">
                                       <a href="product.html" class="comman_flexbox">
                                          <img src="assets/img/Ford-Logo.png" alt="">
                                       </a>
                                       <a href="product.html" class="comman_flexbox">
                                          <img src="assets/img/Tata-Motors-Logo.png" alt="">
                                       </a>
                                  </div> 
                                  <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/toyota-logo.png" alt="">
                                    </a>
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/Mercedes-Benz-logo.png" alt="">
                                    </a>
                                  </div>  
                                 <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/volvo-logo.png" alt="">
                                    </a>
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/lexuslogo.png" alt="">
                                    </a>
                                 </div> 
                                 <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/Renault_logo.png" alt="">
                                    </a>
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/Kia-Logo.png" alt="">
                                    </a>
                                 </div> 
                                 <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/Jeep-Logo.png" alt="">
                                    </a>
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/Nissan-logo.png" alt="">
                                    </a>
                                 </div> 
                                 <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/honda-logo.png" alt="">
                                    </a>
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/hyundai-logo.png" alt="">
                                    </a>
                                 </div> 
                                 <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/honda-logo.png" alt="">
                                    </a>
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/hyundai-logo.png" alt="">
                                    </a>
                                 </div> 
                               </div>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile2-tab">
                        <div class="row pt-4">
                           <div class="col-12">
                               <div class="featured_modal_slider commansldier_btn owl-carousel"> 
                                  <div class="slider_box">
                                       <a href="product.html" class="comman_flexbox">
                                          <img src="assets/img/Ford-Logo.png" alt="">
                                       </a>
                                       <a href="product.html" class="comman_flexbox">
                                          <img src="assets/img/Tata-Motors-Logo.png" alt="">
                                       </a>
                                  </div> 
                                  <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/toyota-logo.png" alt="">
                                    </a>
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/Mercedes-Benz-logo.png" alt="">
                                    </a>
                                  </div>  
                                 <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/volvo-logo.png" alt="">
                                    </a>
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/lexuslogo.png" alt="">
                                    </a>
                                 </div> 
                                 <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/Renault_logo.png" alt="">
                                    </a>
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/Kia-Logo.png" alt="">
                                    </a>
                                 </div> 
                                 <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/Jeep-Logo.png" alt="">
                                    </a>
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/Nissan-logo.png" alt="">
                                    </a>
                                 </div> 
                                 <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/honda-logo.png" alt="">
                                    </a>
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/hyundai-logo.png" alt="">
                                    </a>
                                 </div> 
                                 <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/honda-logo.png" alt="">
                                    </a>
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/hyundai-logo.png" alt="">
                                    </a>
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
      <section class="Featured_brand pb-md-4">
         <div class="container-fluid"> 
            <div class="row mx-0 bg-white position-relative product_main_inner py-4">
               <div class="col-12 pt-2">
                  <ul class="nav nav-tabs commam_tabs_design" id="myTab" role="tablist">
                     <li class="nav-item" role="presentation">
                       <button class="nav-link active" id="brands-tab" data-bs-toggle="tab" data-bs-target="#brands" type="button" role="tab" aria-controls="brands" aria-selected="true">Featured Brands</button>
                     </li> 
                  </ul>
                   <div class="tab-content" id="myTabContent">
                     <div class="tab-pane fade show active" id="brands" role="tabpanel" aria-labelledby="brands-tab"> 
                        <div class="row pt-4">
                           <div class="col-12">
                               <div class="featured_modal_slider commansldier_btn owl-carousel"> 
                                  <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/yakima.png" alt="">
                                    </a>
                                  </div> 
                                  <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/Bilstein-logo.png" alt="">
                                    </a>
                                  </div> 
                                  <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/kyb.png" alt="">
                                    </a>
                                  </div> 
                                  <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/Pirelli-logo.png" alt="">
                                    </a>
                                  </div> 
                                  <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/t5q.png" alt="">
                                    </a>
                                  </div> 
                                  <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/K&N_Plain_Logo.svg.png" alt="">
                                    </a>
                                  </div> 
                                  <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/Pirelli-logo.png" alt="">
                                    </a>
                                  </div> 
                                  <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/t5q.png" alt="">
                                    </a>
                                  </div> 
                                  <div class="slider_box">
                                    <a href="product.html" class="comman_flexbox">
                                       <img src="assets/img/K&N_Plain_Logo.svg.png" alt="">
                                    </a>
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
      <section class="custom_informations py-5">
         <div class="container">
            <div class="row">
               <div class="col-lg-6">
                  <div class="custom_informations_box long_imgnew" style="background-image:url('assets/img/Custom-Wheels2.png');">
                    <div class="custom_inner">
                        <h3>Custom Wheels</h3> 
                        <a class="common_btn mt-4" href="product.html">
                           Shop Now
                        </a>
                    </div>
                  </div>
               </div>
               <div class="col-lg-3 col-md-6 mt-lg-0 mt-md-4 mt-3">
                  <div class="custom_informations_box short_imgnew" style="background-image:url('assets/img/Interior-img.png');">
                    <div class="custom_inner">
                        <h3>Interior</h3> 
                        <a class="common_btn mt-4" href="product.html">
                           Shop Now
                        </a>
                    </div>
                  </div>
                  <div class="custom_informations_box short_imgnew mt-4" style="background-image:url('assets/img/Performance-img.png');">
                     <div class="custom_inner">
                         <h3>Performance</h3> 
                         <a class="common_btn mt-4" href="product.html">
                            Shop Now
                         </a>
                     </div>
                   </div>
               </div>
               <div class="col-lg-3 col-md-6 mt-lg-0 mt-md-4 mt-3">
                  <div class="custom_informations_box short_imgnew" style="background-image:url('assets/img/Exterior-img.png');">
                    <div class="custom_inner">
                        <h3>Exterior</h3> 
                        <a class="common_btn mt-4" href="product.html">
                           Shop Now
                        </a>
                    </div>
                  </div>
                  <div class="custom_informations_box short_imgnew mt-4" style="background-image:url('assets/img/headlight2.png');">
                     <div class="custom_inner">
                         <h3>Headlight</h3> 
                         <a class="common_btn mt-4" href="product.html">
                            Shop Now
                         </a>
                     </div>
                   </div>
               </div>
               <div class="col-lg-4 col-md-6 mt-md-4 mt-3">
                  <div class="custom_informations_box short_imgnew" style="background-image:url('assets/img/Steering-img.png');">
                    <div class="custom_inner">
                        <h3>Steering</h3> 
                        <a class="common_btn mt-4" href="product.html">
                           Shop Now
                        </a>
                    </div>
                  </div> 
               </div> 
               <div class="col-lg-4 col-md-6 mt-md-4 mt-3">
                  <div class="custom_informations_box short_imgnew" style="background-image:url('assets/img/Speed-Tyres-img.png');">
                    <div class="custom_inner">
                        <h3>Speed Tyers</h3> 
                        <a class="common_btn mt-4" href="product.html">
                           Shop Now
                        </a>
                    </div>
                  </div> 
               </div> 
               <div class="col-lg-4 col-md-12 mt-md-4 mt-3">
                  <div class="custom_informations_box short_imgnew" style="background-image:url('assets/img/seat-cover-img.png');">
                    <div class="custom_inner">
                        <h3>Seat Cover</h3> 
                        <a class="common_btn mt-4" href="product.html">
                           Shop Now
                        </a>
                    </div>
                  </div> 
               </div> 
            </div>
         </div>
      </section>  
      <section class="recent_review py-md-5 py-4">
         <div class="container-fluid pb-md-4">
            <div class="row">
               <div class="col-md-12">
                  <div class=" header_comman text-center mb-lg-5 mb-md-4 mb-4">
                     <h2>Recent Review</h2> 
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="recent_review_slider owl-carousel"> 
                     <div class="recent_review_box">
                        <div class="row align-items-center content_review">
                           <div class="col-auto">
                              <span class="review_img">
                                 <img src="assets/img/Person1.png" alt="">
                              </span>
                           </div>
                           <div class="col">
                              <strong>Daisy Flower</strong>
                              <span>Ceo at Lorem</span>
                           </div>
                           <div class="col-md-auto mt-dm-0 mt-3 date_review">
                              2 Days ago
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-12 mt-md-3 mt-2 mb-2">
                              <div class="rating_box">
                                 <a href="javasript:;"><i class="fas fa-star"></i></a>
                                 <a href="javasript:;"><i class="fas fa-star"></i></a>
                                 <a href="javasript:;"><i class="fas fa-star"></i></a>
                                 <a href="javasript:;"><i class="fas fa-star"></i></a>
                                 <a href="javasript:;"><i class="fal fa-star"></i></a>
                              </div>
                           </div>
                           <div class="col-12">
                              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium pariatur sint expedita. Rem, itaque! Ullam, repellendus! Similique iure velit, libero vel sunt itaque quia adipisci aliquid porro, dolorem explicabo totam!</p>
                           </div>
                        </div>
                     </div>
                     <div class="recent_review_box">
                        <div class="row align-items-center content_review">
                           <div class="col-auto">
                              <span class="review_img">
                                 <img src="assets/img/Person1.png" alt="">
                              </span>
                           </div>
                           <div class="col">
                              <strong>Daisy Flower</strong>
                              <span>Ceo at Lorem</span>
                           </div>
                           <div class="col-md-auto mt-dm-0 mt-3 date_review">
                              2 Days ago
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-12 mt-md-3 mt-2 mb-2">
                              <div class="rating_box">
                                 <a href="javasript:;"><i class="fas fa-star"></i></a>
                                 <a href="javasript:;"><i class="fas fa-star"></i></a>
                                 <a href="javasript:;"><i class="fas fa-star"></i></a>
                                 <a href="javasript:;"><i class="fas fa-star"></i></a>
                                 <a href="javasript:;"><i class="fal fa-star"></i></a>
                              </div>
                           </div>
                           <div class="col-12">
                              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium pariatur sint expedita. Rem, itaque! Ullam, repellendus! Similique iure velit, libero vel sunt itaque quia adipisci aliquid porro, dolorem explicabo totam!</p>
                           </div>
                        </div>
                     </div>
                     <div class="recent_review_box">
                        <div class="row align-items-center content_review">
                           <div class="col-auto">
                              <span class="review_img">
                                 <img src="assets/img/Person1.png" alt="">
                              </span>
                           </div>
                           <div class="col">
                              <strong>Daisy Flower</strong>
                              <span>Ceo at Lorem</span>
                           </div>
                           <div class="col-md-auto mt-dm-0 mt-3 date_review">
                              2 Days ago
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-12 mt-md-3 mt-2 mb-2">
                              <div class="rating_box">
                                 <a href="javasript:;"><i class="fas fa-star"></i></a>
                                 <a href="javasript:;"><i class="fas fa-star"></i></a>
                                 <a href="javasript:;"><i class="fas fa-star"></i></a>
                                 <a href="javasript:;"><i class="fas fa-star"></i></a>
                                 <a href="javasript:;"><i class="fal fa-star"></i></a>
                              </div>
                           </div>
                           <div class="col-12">
                              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium pariatur sint expedita. Rem, itaque! Ullam, repellendus! Similique iure velit, libero vel sunt itaque quia adipisci aliquid porro, dolorem explicabo totam!</p>
                           </div>
                        </div>
                     </div>
                     <div class="recent_review_box">
                        <div class="row align-items-center content_review">
                           <div class="col-auto">
                              <span class="review_img">
                                 <img src="assets/img/Person1.png" alt="">
                              </span>
                           </div>
                           <div class="col">
                              <strong>Daisy Flower</strong>
                              <span>Ceo at Lorem</span>
                           </div>
                           <div class="col-md-auto mt-dm-0 mt-3 date_review">
                              2 Days ago
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-12 mt-md-3 mt-2 mb-2">
                              <div class="rating_box">
                                 <a href="javasript:;"><i class="fas fa-star"></i></a>
                                 <a href="javasript:;"><i class="fas fa-star"></i></a>
                                 <a href="javasript:;"><i class="fas fa-star"></i></a>
                                 <a href="javasript:;"><i class="fas fa-star"></i></a>
                                 <a href="javasript:;"><i class="fal fa-star"></i></a>
                              </div>
                           </div>
                           <div class="col-12">
                              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium pariatur sint expedita. Rem, itaque! Ullam, repellendus! Similique iure velit, libero vel sunt itaque quia adipisci aliquid porro, dolorem explicabo totam!</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>  

@endsection