@extends('web.layout.master')
@section('content')
      <section class="home_banner mt-2 product_banner">
         <div class="container-fluid">
            <div class="home_banner_img">
            </div>
         </div>
      </section>
      <section class="breadcrumbs py-md-3 py-2">
         <div class="container-fluid">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="javscript:;">Home</a></li>
                  <li class="breadcrumb-item"><a href="javscript:;">All Product</a></li>
                  <li class="breadcrumb-item"><a href="javscript:;">Interior Accessories</a></li>
                  <li class="breadcrumb-item active" aria-current="page">BMW XI</li>
               </ol>
            </nav>
         </div>
      </section>
      <section class="product_single">
         <div class="container-fluid">
            <div class="row mx-0 bg-white py-4 position-relative">
               <div class="col-12">
                  <div class="heading_innerpages">
                     <h2>Filter</h2>
                  </div>
               </div>
               <div class="col-12">
                  <div class="row product_single_main">
                     <div class="col-md-3 pe-lg-0 width_adjust">
                        <form class="product_single_left">
                           <div class="accordion" id="accordionExample1">
                              <div class="accordion-item filter_design">
                                 <h2 class="accordion-header" id="heading1">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                    Price Range
                                    </button>
                                 </h2>
                                 <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#accordionExample1">
                                    <div class="accordion-body px-0 pt-4 pb-0">
                                       <div class="row range_box">
                                          <div class="col-12">
                                             <div class="range-slide">
                                                <div class="slide">
                                                   <div class="line" id="line" style="left: 0%; right: 0%;"></div>
                                                   <span class="thumb" id="thumbMin" style="left: 0%;"></span>
                                                   <span class="thumb" id="thumbMax" style="left: 100%;"></span>
                                                </div>
                                                <input id="rangeMin" type="range" max="100" min="10" step="5" value="0">
                                                <input id="rangeMax" type="range" max="100" min="10" step="5" value="100">
                                             </div>
                                             <div class="display">
                                                <span id="min">10</span>
                                                <span id="max">100</span>
                                             </div>
                                          </div>
                                          <div class="col-12 mt-3">
                                             <div class="row align-items-center">
                                                <div class="col form-group">
                                                   <select class="form-select select_design" aria-label="Default select example">
                                                      <option selected>Min</option>
                                                      <option value="1">50</option>
                                                      <option value="2">100</option>
                                                      <option value="3">1000</option>
                                                   </select>
                                                </div>
                                                <div class="col-auto">
                                                   <span class="center_text">to</span>
                                                </div>
                                                <div class="col form-group">
                                                   <select class="form-select select_design" aria-label="Default select example">
                                                      <option selected>Max</option>
                                                      <option value="1">500</option>
                                                      <option value="2">1000</option>
                                                      <option value="3">10000</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="accordion-item filter_design">
                                 <h2 class="accordion-header" id="heading2">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                                    Ratings
                                    </button>
                                 </h2>
                                 <div id="collapse2" class="accordion-collapse collapse show" aria-labelledby="heading2" data-bs-parent="#accordionExample1">
                                    <div class="accordion-body px-0 pt-3 pb-0">
                                       <div class="row rating_box">
                                          <div class="col-12 form-group checkbox_design">
                                             <input class="d-none" type="checkbox" id="check1" name="check1">
                                             <label for="check1"> 4 <a href="javasript:;"><i class="fas fa-star"></i></a> & UP</label>
                                          </div>
                                          <div class="col-12 form-group checkbox_design">
                                             <input class="d-none" type="checkbox" id="check2" name="check2">
                                             <label for="check2"> 3 <a href="javasript:;"><i class="fas fa-star"></i></a> & UP</label>
                                          </div>
                                          <div class="col-12 form-group checkbox_design">
                                             <input class="d-none" type="checkbox" id="check3" name="check3">
                                             <label for="check3"> 2 <a href="javasript:;"><i class="fas fa-star"></i></a> & UP</label>
                                          </div>
                                          <div class="col-12 form-group checkbox_design">
                                             <input class="d-none" type="checkbox" id="check4" name="check4">
                                             <label for="check4"> 1 <a href="javasript:;"><i class="fas fa-star"></i></a> & UP</label>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="accordion-item filter_design">
                                 <h2 class="accordion-header" id="heading3">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                                    Product Brands
                                    </button>
                                 </h2>
                                 <div id="collapse3" class="accordion-collapse collapse show" aria-labelledby="heading3" data-bs-parent="#accordionExample1">
                                    <div class="accordion-body px-0 pt-3 pb-0">
                                       <div class="row">
                                          <div class="col-12 form-group checkbox_design">
                                             <input class="d-none" type="checkbox" id="check5" name="check5">
                                             <label for="check5"> Acdelco</label>
                                          </div>
                                          <div class="col-12 form-group checkbox_design">
                                             <input class="d-none" type="checkbox" id="check6" name="check6">
                                             <label for="check6"> All American Bilet</label>
                                          </div>
                                          <div class="col-12 form-group checkbox_design">
                                             <input class="d-none" type="checkbox" id="check7" name="check7">
                                             <label for="check7"> Amirican Shifter</label>
                                          </div>
                                          <div class="col-12 form-group checkbox_design">
                                             <input class="d-none" type="checkbox" id="check8" name="check8">
                                             <label for="check8"> Bulter Built</label>
                                          </div>
                                          <div class="col-12 form-group checkbox_design">
                                             <input class="d-none" type="checkbox" id="check9" name="check9">
                                             <label for="check9"> Acdelco</label>
                                          </div>
                                          <div class="col-12 form-group checkbox_design">
                                             <input class="d-none" type="checkbox" id="check10" name="check10">
                                             <label for="check10"> All American Bilet</label>
                                          </div>
                                          <div class="col-12 form-group checkbox_design">
                                             <input class="d-none" type="checkbox" id="check11" name="check11">
                                             <label for="check11"> Amirican Shifter</label>
                                          </div>
                                          <div class="col-12 form-group checkbox_design">
                                             <input class="d-none" type="checkbox" id="check12" name="check12">
                                             <label for="check12"> Acdelco</label>
                                          </div>
                                          <div class="col-12 form-group checkbox_design">
                                             <input class="d-none" type="checkbox" id="check13" name="check13">
                                             <label for="check13"> All American Bilet</label>
                                          </div>
                                          <div class="col-12 form-group checkbox_design">
                                             <input class="d-none" type="checkbox" id="check14" name="check14">
                                             <label for="check14"> Amirican Shifter</label>
                                          </div>
                                          <div class="col-12 mt-3">
                                             <a class="more_btn" href="javscript:;">54 More</a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="accordion-item filter_design">
                                 <h2 class="accordion-header" id="heading4">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                                    Vehicle Performance
                                    </button>
                                 </h2>
                                 <div id="collapse4" class="accordion-collapse collapse show" aria-labelledby="heading4" data-bs-parent="#accordionExample1">
                                    <div class="accordion-body px-0 pt-3 pb-0">
                                       <div class="row">
                                          <div class="col-12">
                                             <div class="row align-items-center">
                                                <div class="col-sm form-group mb-md-0 mb-2">
                                                   <select class="form-select select_design" aria-label="Default select example">
                                                      <option selected>Year</option>
                                                      <option value="1">50</option>
                                                      <option value="2">100</option>
                                                      <option value="3">1000</option>
                                                   </select>
                                                </div>
                                                <div class="col-sm px-md-0 form-group mb-md-0 mb-2">
                                                   <select class="form-select select_design" aria-label="Default select example">
                                                      <option selected>Brand</option>
                                                      <option value="1">50</option>
                                                      <option value="2">100</option>
                                                      <option value="3">1000</option>
                                                   </select>
                                                </div>
                                                <div class="col-sm form-group mb-md-0">
                                                   <select class="form-select select_design" aria-label="Default select example">
                                                      <option selected>Model</option>
                                                      <option value="1">500</option>
                                                      <option value="2">1000</option>
                                                      <option value="3">10000</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row mx-0 pt-4 pb-5">
                              <div class="col-6">
                                 <a class="d-block btn_main2" href="javscript:;">Clear All</a> 
                              </div>
                              <div class="col-6"> 
                                 <a class="d-block btn_main" href="javscript:;">Apply</a>
                              </div>
                           </div>
                        </form>
                     </div>
                     <div class="col width_adjust_right">
                        <div class="product_single_right py-md-4 px-md-4">
                           <div class="product_single_slider commansldier_btn owl-carousel">
                              <div class="slider_box">
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img3.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img4.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img3.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                              <div class="slider_box">
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img5.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img6.png')}}" alt="Product"> 
                                       <a class="fav_btn" href="javscript:;"></a>
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
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img3.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                              <div class="slider_box">
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img1.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img2.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img3.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                              <div class="slider_box">
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img7.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img8.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img3.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                              <div class="slider_box">
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img9.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img10.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img3.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                              <div class="slider_box">
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img11.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img12.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img3.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                              <div class="slider_box">
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img7.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img8.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                                 <div class="product_parts_box">
                                    <div class="partsproduct_img">
                                       <img src="{{asset('assets/web/img/product_img3.png')}}" alt="Product">
                                       <a class="fav_btn" href="javscript:;"></a>
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
                                 <img src="{{asset('assets/web/img/Person1.png')}}" alt="">
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
                                 <img src="{{asset('assets/web/img/Person1.png')}}" alt="">
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
                                 <img src="{{asset('assets/web/img/Person1.png')}}" alt="">
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
                                 <img src="{{asset('assets/web/img/Person1.png')}}" alt="">
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