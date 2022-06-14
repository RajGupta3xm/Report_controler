@extends('web.layout.master')
@section('content')

      <section class="breadcrumbs py-md-3 py-2">
         <div class="container-fluid">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="javscript:;">Home</a></li>
                  <li class="breadcrumb-item"><a href="javscript:;">All Products</a></li>
                  <li class="breadcrumb-item"><a href="javscript:;">Interior Accessories</a></li>
                  <li class="breadcrumb-item active" aria-current="page">BMW XI</li>
               </ol>
            </nav>
         </div>
      </section>
      <section class="Product_single_page mb-4">
         <div class="container-fluid"> 
            <div class="row mx-0 bg-white p-xl-5 p-lg-4 p-md-4 p-3 position-relative">
               <div class="col-lg-6 px-md-3 px-0">
                  <div class="product_show">
                     <div id="carouselExampleIndicators" class="carousel" data-bs-touch="false" data-bs-interval="false" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"><img src="assets/img/product_img11.png" alt=""></button>
                          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"><img src="assets/img/product_img12.png" alt=""></button>
                          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"><img src="assets/img/product_img10.png" alt=""></button>
                          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"><img src="assets/img/product_img9.png" alt=""></button>
                        </div>
                        <div class="carousel-inner">
                           <div class="carousel-item active">
                              <div class="productimg_show">
                                 <img src="assets/img/product_img11.png" class="d-block" alt="...">
                              </div>
                           </div>
                           <div class="carousel-item">
                              <div class="productimg_show">
                                 <img src="assets/img/product_img12.png" class="d-block" alt="...">
                              </div>
                           </div>
                           <div class="carousel-item">
                              <div class="productimg_show">
                                 <img src="assets/img/product_img10.png" class="d-block" alt="...">
                              </div> 
                           </div>
                           <div class="carousel-item">
                              <div class="productimg_show">
                                 <img src="assets/img/product_img9.png" class="d-block" alt="...">
                              </div> 
                           </div>
                        </div> 
                      </div>
                  </div>
               </div>
               <div class="col-lg-6 mt-lg-0 px-md-3 px-0 mt-md-5 mt-4">
                  <div class="product_details_main ps-lg-5">
                     <div class="row align-items-start">
                        <div class="col">
                           <div class="product_details_text">
                              <div class="row border-bottom pb-4">
                                 <div class="col-12">
                                    <h2>Blue Lorem Collection</h2>
                                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Unde quaerat excepturi iste? Nisi quidem repudiandae.</p>
                                    <div class="ratee_part d-flex align-items-center mt-3">
                                       <div class="rating_box">
                                          <a href="javasript:;"><i class="fas fa-star"></i></a>
                                          <a href="javasript:;"><i class="fas fa-star"></i></a>
                                          <a href="javasript:;"><i class="fas fa-star"></i></a>
                                          <a href="javasript:;"><i class="fas fa-star"></i></a>
                                          <a href="javasript:;"><i class="fal fa-star"></i></a>
                                       </div>
                                       <span>(216)</span>
                                    </div>
                                 </div> 
                                 <div class="col-12 pricee_part my-3">
                                    <strong>$521.00</strong> <del>$751.00</del>
                                    <span>Save 10%</span>
                                 </div>
                                 <div class="col-12 quantity_box d-md-flex align-items-center mt-md-3">
                                    <div class="number me-md-4 mb-md-0 mb-3">
                                       <span class="minus">-</span>
                                       <input type="text" value="0">
                                       <span class="plus">+</span>
                                    </div>
                                    <a class="d-inline-block btn_main" href="checkout.html">Buy Now</a>
                                 </div>
                              </div> 
                              <div class="row offers_box pt-4">
                                 <div class="col-12 offers_head mb-2">
                                    <strong>(4) Offers | Applicable on cart</strong>
                                 </div>
                                 <div class="col-12">
                                    <div class="row offers_box_main">
                                       <div class="col-12">
                                          <div class="row align-items-start">
                                             <div class="col-auto py-2">
                                                <span class="offer_icon">
                                                   <img src="assets/img/offers.png" alt="">
                                                </span>
                                             </div>
                                             <div class="col px-md-0 ps-0 pe-1 border-bottom py-2">
                                                <p>Get 25% Cashback Using Dhani One Freedom card T&C. Lorem ipsem dolar</p>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-12">
                                          <div class="row align-items-start">
                                             <div class="col-auto py-2">
                                                <span class="offer_icon">
                                                   <img src="assets/img/offers.png" alt="">
                                                </span>
                                             </div>
                                             <div class="col px-md-0 ps-0 pe-1 border-bottom py-2">
                                                <p>Get 25% Cashback Using Dhani One Freedom card T&C. Lorem ipsem dolar</p>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-12">
                                          <div class="row align-items-start">
                                             <div class="col-auto py-2">
                                                <span class="offer_icon">
                                                   <img src="assets/img/offers.png" alt="">
                                                </span>
                                             </div>
                                             <div class="col px-md-0 ps-0 pe-1 border-bottom py-2">
                                                <p>Get 25% Cashback Using Dhani One Freedom card T&C. Lorem ipsem dolar</p>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-12">
                                          <div class="row align-items-start">
                                             <div class="col-auto py-2">
                                                <span class="offer_icon">
                                                   <img src="assets/img/offers.png" alt="">
                                                </span>
                                             </div>
                                             <div class="col px-0 border-0 py-2">
                                                <p>Get 25% Cashback Using Dhani One Freedom card T&C. Lorem ipsem dolar</p>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-auto product_details_btns">
                           <a class="fav_btn" href="javscript:;"></a>
                           <a class="ms-md-3 ms-1" href="javscript:;"><img src="assets/img/share.png" alt=""></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div> 
         </div>
      </section>  
      <section class="Productsingle_details pb-4">
         <div class="container-fluid">
            <div class="row mx-0 bg-white position-relative product_main_inner py-4">
               <div class="col-12 pt-2">
                  <ul class="nav nav-tabs commam_tabs_design" id="myTab" role="tablist">
                     <li class="nav-item" role="presentation">
                       <button class="nav-link active" id="features-tab" data-bs-toggle="tab" data-bs-target="#features" type="button" role="tab" aria-controls="features" aria-selected="true">Features & Details</button>
                     </li>
                     <li class="nav-item" role="presentation">
                       <button class="nav-link" id="rating-tab" data-bs-toggle="tab" data-bs-target="#rating" type="button" role="tab" aria-controls="rating" aria-selected="false">Rating & Review</button>
                     </li>
                     <li class="nav-item" role="presentation">
                       <button class="nav-link" id="qa-tab" data-bs-toggle="tab" data-bs-target="#qa" type="button" role="tab" aria-controls="qa" aria-selected="false">Questions & Answers</button>
                     </li>
                  </ul> 
                   <div class="tab-content" id="myTabContent">
                     <div class="tab-pane fade show active" id="features" role="tabpanel" aria-labelledby="features-tab"> 
                        <div class="row p-lg-5 p-md-4 p-2">
                           <div class="col-lg-10">
                              <div class="featured-details">
                                 <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                      <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                         <span class="btns_collapes position-relative"></span> Highlight
                                        </button>
                                      </h2>
                                      <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                             <ul class="featured-ul">
                                                <li><p>Lorem ipsum</p></li>
                                                <li><p>Lorem ipsum</p></li>
                                                <li><p>Lorem ipsum</p></li>
                                                <li><p>Lorem ipsum</p></li>
                                                <li><p>Lorem ipsum</p></li>
                                                <li><p>Lorem ipsum</p></li>
                                                <li><p>Lorem ipsum</p></li>
                                             </ul>
                                        </div>
                                      </div>
                                    </div> 
                                    <div class="accordion-item">
                                       <h2 class="accordion-header" id="headingtwo">
                                         <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo">
                                          <span class="btns_collapes position-relative"></span> Description
                                         </button>
                                       </h2>
                                       <div id="collapsetwo" class="accordion-collapse collapse show" aria-labelledby="headingtwo" data-bs-parent="#accordionExample">
                                         <div class="accordion-body">
                                             <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Pariatur omnis aliquid aliquam eos magnam neque corporis? Quisquam distinctio dolorum adipisci qui quia ea consequatur. Tempore cumque  Lorem ipsum dolor, sit amet consectetur adipisicing elit. Pariatur omnis aliquid aliquam eos magnam neque corporis? Quisquam distinctio dolorum adipisci qui quia ea consequatur. Tempore cumque commodi numquam ad iste!</p>
                                             <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Pariatur omnis aliquid aliquam eos magnam neque corporis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Pariatur omnis aliquid aliquam eos magnam neque corporis Quisquam distinctio dolorum adipisci qui quia ea consequatur. Tempore cumque commodi numquam ad iste!</p>
                                         </div>
                                       </div>
                                     </div> 
                                  </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="rating" role="tabpanel" aria-labelledby="rating-tab">
                        <div class="row p-lg-5 p-md-4 p-2">
                           <div class="col-12 mb-4 pb-2">
                              <div class="row ratingbox_main">
                                 <div class="col-md-4">
                                    <div class="ratingbox_main_left">
                                       <h3>3.9<span>/5</span></h3>
                                       <div class="rating_box mb-md-3 mb-2">
                                          <a href="javasript:;"><i class="fas fa-star"></i></a>
                                          <a href="javasript:;"><i class="fas fa-star"></i></a>
                                          <a href="javasript:;"><i class="fas fa-star"></i></a>
                                          <a href="javasript:;"><i class="fas fa-star"></i></a>
                                          <a href="javasript:;"><i class="fal fa-star"></i></a>
                                       </div>
                                       <p>18376 Ratings & 29 Reviews</p> 
                                       <a class="all_review" href="jacvascript:;">View All Review</a>
                                    </div>
                                 </div>
                                 <div class="col-md-8">
                                    <div class="rating_progress ps-md-3">
                                       <div class="row align-items-center mb-2">
                                          <div class="col-auto">
                                             <span class="text_wtihstart">5 <i class="fas fa-star"></i></span>
                                          </div>
                                          <div class="col-md-4 col p-0">
                                             <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 100%; background-color: #009043;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                              </div>
                                          </div>
                                          <div class="col-auto">
                                             <span class="rating_number">1500</span>
                                          </div>
                                       </div>
                                       <div class="row align-items-center mb-2">
                                          <div class="col-auto">
                                             <span class="text_wtihstart">4 <i class="fas fa-star"></i></span>
                                          </div>
                                          <div class="col-md-4 col p-0">
                                             <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 50%; background-color: #009043;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                              </div>
                                          </div>
                                          <div class="col-auto">
                                             <span class="rating_number">638</span>
                                          </div>
                                       </div>
                                       <div class="row align-items-center mb-2">
                                          <div class="col-auto">
                                             <span class="text_wtihstart">3 <i class="fas fa-star"></i></span>
                                          </div>
                                          <div class="col-md-4 col p-0">
                                             <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 75%; background-color: #009043;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                              </div>
                                          </div>
                                          <div class="col-auto">
                                             <span class="rating_number">247</span>
                                          </div>
                                       </div>
                                       <div class="row align-items-center mb-2">
                                          <div class="col-auto">
                                             <span class="text_wtihstart">2 <i class="fas fa-star"></i></span>
                                          </div>
                                          <div class="col-md-4 col p-0">
                                             <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 20%; background-color: #ff9a00;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                              </div>
                                          </div>
                                          <div class="col-auto">
                                             <span class="rating_number">122</span>
                                          </div>
                                       </div>
                                       <div class="row align-items-center mb-2">
                                          <div class="col-auto">
                                             <span class="text_wtihstart">1 <i class="fas fa-star"></i></span>
                                          </div>
                                          <div class="col-md-4 col p-0">
                                             <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 33%; background-color: #ff0000;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                                              </div>
                                          </div>
                                          <div class="col-auto">
                                             <span class="rating_number">226</span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-12">
                              <div class="customer_review_main">
                                 <div class="row customer_review_head border-bottom pb-3">
                                    <div class="col-sm mb-md-0 mb-2 review_head_left">
                                       <span>1-10 of 29 Reviews</span>
                                       <h3>Customer Reviews</h3>
                                    </div>
                                    <div class="col-md-auto d-flex flex-md-nowrap flex-wrap align-items-center">
                                       <div class="sort_by mb-md-0 mb-2 me-md-3">
                                          <span>Sort By: </span>
                                          <a href="javscript:;">Most Helpful</a>
                                          <a href="javscript:;">Most Recent</a>
                                       </div>
                                       <div class="filter_by d-flex align-items-center">
                                          <span>Filter By: </span>
                                          <select class="form-select" aria-label="Default select example">
                                             <option selected="">All Star</option>
                                             <option value="1">50</option>
                                             <option value="2">100</option>
                                             <option value="3">1000</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-12">
                                       <div class="row review_show_box">
                                          <div class="col-md-auto py-md-4 mt-md-0 mt-3">
                                             <div class="review_profile">
                                                <img src="assets/img/Person1.png" alt="">
                                             </div>
                                          </div>
                                          <div class="col-sm py-md-4 pt-3 pb-4 border-bottom">
                                             <div class="rating_box">
                                                <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                <a href="javasript:;"><i class="fal fa-star"></i></a>
                                             </div>
                                             <strong>Good Quality</strong>
                                             <span>By Bhupendra on Dec 23, 2021</span>
                                             <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Id eius iusto ducimus commodi quisquam placeat quas asperiores assumenda, magnam itaque dignissimos. Eaque, ipsa optio? Voluptatibus officiis quod aliquam repellat labore?</p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-12">
                                       <div class="row review_show_box">
                                          <div class="col-md-auto py-md-4 mt-md-0 mt-3">
                                             <div class="review_profile">
                                                <img src="assets/img/Person1.png" alt="">
                                             </div>
                                          </div>
                                          <div class="col-sm py-md-4 pt-3 pb-4 border-bottom">
                                             <div class="rating_box">
                                                <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                <a href="javasript:;"><i class="fal fa-star"></i></a>
                                             </div>
                                             <strong>Good Quality</strong>
                                             <span>By Bhupendra on Dec 23, 2021</span>
                                             <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Id eius iusto ducimus commodi quisquam placeat quas asperiores assumenda, magnam itaque dignissimos. Eaque, ipsa optio? Voluptatibus officiis quod aliquam repellat labore?</p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-12">
                                       <div class="row review_show_box">
                                          <div class="col-md-auto py-md-4 mt-md-0 mt-3">
                                             <div class="review_profile">
                                                <img src="assets/img/Person1.png" alt="">
                                             </div>
                                          </div>
                                          <div class="col-sm py-md-4 pt-3 pb-4 border-bottom">
                                             <div class="rating_box">
                                                <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                <a href="javasript:;"><i class="fal fa-star"></i></a>
                                             </div>
                                             <strong>Good Quality</strong>
                                             <span>By Bhupendra on Dec 23, 2021</span>
                                             <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Id eius iusto ducimus commodi quisquam placeat quas asperiores assumenda, magnam itaque dignissimos. Eaque, ipsa optio? Voluptatibus officiis quod aliquam repellat labore?</p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-12">
                                       <div class="row review_show_box">
                                          <div class="col-md-auto py-md-4 mt-md-0 mt-3">
                                             <div class="review_profile">
                                                <img src="assets/img/Person1.png" alt="">
                                             </div>
                                          </div>
                                          <div class="col py-4">
                                             <div class="rating_box">
                                                <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                <a href="javasript:;"><i class="fas fa-star"></i></a>
                                                <a href="javasript:;"><i class="fal fa-star"></i></a>
                                             </div>
                                             <strong>Good Quality</strong>
                                             <span>By Bhupendra on Dec 23, 2021</span>
                                             <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Id eius iusto ducimus commodi quisquam placeat quas asperiores assumenda, magnam itaque dignissimos. Eaque, ipsa optio? Voluptatibus officiis quod aliquam repellat labore?</p>
                                          </div>
                                       </div>
                                    </div>
                                    
                                    <div class="col-12">
                                       <div class="row review_show_box"> 
                                          <div class="col py-4">
                                             <a class="d-inline-block btn_main" href="javscript:;">See More</a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="qa" role="tabpanel" aria-labelledby="qa-tab">
                        <div class="row p-lg-5 p-md-4 p-3">
                           <div class="col-lg-10">
                              <div class="question_answer">
                                  <div class="row">
                                    <div class="col-12 question_answer_box mb-4 pb-2">
                                       <div class="row mb-2 align-items-center">
                                          <div class="col-auto">
                                             <span class="que_tag">Q: </span>
                                          </div>
                                          <div class="col ps-0">
                                             <h3>Dose power automatically cut lorem ipsum dolar set?</h3>
                                          </div>
                                       </div>
                                       <div class="row">
                                       <div class="col-auto">
                                          <span class="que_tag mt-1">A: </span>
                                       </div>
                                       <div class="col ps-0">
                                          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis commodi, deserunt quasi ullam quibusdam fugiat vero est eum blanditiis explicabo magnam quidem nam assumenda molestias? Numquam rem culpa harum reprehenderit!</p>
                                       </div>
                                    </div>
                                    </div>
                                    <div class="col-12 question_answer_box mb-4 pb-2">
                                       <div class="row mb-2 align-items-center">
                                          <div class="col-auto">
                                             <span class="que_tag">Q: </span>
                                          </div>
                                          <div class="col ps-0">
                                             <h3>Dose power automatically cut lorem ipsum dolar set?</h3>
                                          </div>
                                       </div>
                                       <div class="row">
                                         <div class="col-auto">
                                            <span class="que_tag mt-1">A: </span>
                                         </div>
                                         <div class="col ps-0">
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis commodi, deserunt quasi ullam quibusdam fugiat vero est eum blanditiis explicabo magnam quidem nam assumenda molestias? Numquam rem culpa harum reprehenderit!</p>
                                         </div>
                                      </div>
                                    </div>
                                    <div class="col-12 question_answer_box mb-4 pb-2">
                                       <div class="row mb-2 align-items-center">
                                          <div class="col-auto">
                                             <span class="que_tag">Q: </span>
                                          </div>
                                          <div class="col ps-0">
                                             <h3>Dose power automatically cut lorem ipsum dolar set?</h3>
                                          </div>
                                       </div>
                                       <div class="row">
                                         <div class="col-auto">
                                            <span class="que_tag mt-1">A: </span>
                                         </div>
                                         <div class="col ps-0">
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis commodi, deserunt quasi ullam quibusdam fugiat vero est eum blanditiis explicabo magnam quidem nam assumenda molestias? Numquam rem culpa harum reprehenderit!</p>
                                         </div>
                                      </div>
                                    </div>
                                    <div class="col-12 question_answer_box mb-4 pb-2">
                                       <div class="row mb-2 align-items-center">
                                          <div class="col-auto">
                                             <span class="que_tag">Q: </span>
                                          </div>
                                          <div class="col ps-0">
                                             <h3>Dose power automatically cut lorem ipsum dolar set?</h3>
                                          </div>
                                       </div>
                                       <div class="row">
                                         <div class="col-auto">
                                            <span class="que_tag mt-1">A: </span>
                                         </div>
                                         <div class="col ps-0">
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis commodi, deserunt quasi ullam quibusdam fugiat vero est eum blanditiis explicabo magnam quidem nam assumenda molestias? Numquam rem culpa harum reprehenderit!</p>
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
      <section class="product_main pb-md-4">
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

@endsection