
<header class="header_main">
         <div class="container-fluid">
            <div class="row align-items-center header_main_inner mx-0">
               <div class="col text-md-start text-center">
                  <a class="header_logo" href="{{url('home')}}"><img src="{{asset('assets/web/img/autoparts_logo.png')}}" alt=""> </a>
               </div>
               <div class="col-xl-6 order-xl-0 order-lg-2 order-md-2 order-2 mt-xl-0 mt-lg-3 mt-md-0 mt-0">
                  <div class="header_search d-lg-block d-md-none d-none">
                     <form class="row" action="">
                        <div class="col-md-7 pe-0">
                           <div class="form-group">
                              <input type="text" id="search" name="search" class="form-control rounded-start" placeholder="Search by make, model, Year Product type....">
                           </div>
                        </div>
                        <div class="col-md-3 px-0">
                           <div class="form-group">
                              <select class="form-select border-start" aria-label="Default select example">
                                 <option selected>All Categories</option>
                                 <option value="1">One</option>
                                 <option value="2">Two</option>
                                 <option value="3">Three</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-xl-auto col-lg-2 col-md-2 col-2 ps-0">
                           <div class="form-group">
                              <button type="search" class="Btn-design rounded-end"><i class="fal fa-search"></i></button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="col-md-auto">
                  <div class="header_right text-end">
                     <div class="row align-items-center">
                        <div class="col-auto">
                           <div class="mygrage_dropdown comman_dropdown">
                              <div class="dropdown">
                                 <button class="btn btn-secondary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                 <img src="{{asset('assets/web/img/garage.png')}}" alt=""> <span>My Garage</span>
                                 </button>
                                 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <div class="row mx-0">
                                       <div class="col-12 border-bottom pb-2">
                                          <strong class="drop_header">My Garage</strong>
                                       </div>
                                       <div class="col-12 pt-3">
                                          <div class="garage_box row pb-2 align-items-center">
                                             <a href="javascript:;" class="col p-0">
                                             <span>2020 BMW Xl</span>
                                             <label> <img src="{{asset('assets/web/img/arrow.png')}}" alt=""> </label>
                                             </a>
                                             <a class="col-auto delete pe-0" href="javascript:;"><img src="{{asset('assets/web/img/delete-bin-line.png')}}" alt=""></a>
                                          </div>
                                          <div class="garage_box row pb-2 align-items-center">
                                             <a href="javascript:;" class="col p-0">
                                             <span>2020 BMW Xl</span>
                                             <label> <img src="{{asset('assets/web/img/arrow.png')}}" alt=""> </label>
                                             </a>
                                             <a class="col-auto delete pe-0" href="javascript:;"><img src="{{asset('assets/web/img/delete-bin-line.png')}}" alt=""></a>
                                          </div>
                                          <div class="garage_box row pb-2 align-items-center">
                                             <a href="javascript:;" class="col p-0">
                                             <span>2020 BMW Xl</span>
                                             <label> <img src="{{asset('assets/web/img/arrow.png')}}" alt=""> </label>
                                             </a>
                                             <a class="col-auto delete pe-0" href="javascript:;"><img src="{{asset('assets/web/img/delete-bin-line.png')}}" alt=""></a>
                                          </div>
                                       </div>
                                       <div class="col-12 pt-5 px-0">
                                          <div class="row garage_btn">
                                             <div class="col-6 pe-2">
                                                <a class="clear_btn" href="javscript:;">
                                                Clear All
                                                </a>
                                             </div>
                                             <div class="col-6 ps-2">
                                                <a data-bs-toggle="modal" data-bs-target="#staticBackdrop07" href="javscript:;">
                                                Add Vehicle
                                                </a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-auto">
                            <a class="cart_btn_header" href="{{url('mycart')}}"><img src="{{asset('assets/web/img/cart.png')}}" alt=""> <span>4</span></a>
                        </div>
                        <div class="col-auto">
                           <div class="myaccount_dropdown comman_dropdown">
                              <div class="dropdown">
                                 <button class="btn btn-secondary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                 <strong> My Account <img src="{{asset('assets/web/img/dropdown-white.png')}}" alt="">
                                 <span>Hello, Sign in</span></strong>
                                 </button>
                                 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <div class="myaccount_inner">
                                       <div class="myaccount_top mb-3">
                                          <strong class="drop_header">My Account</strong>
                                          <span class="profile_img">
                                          <img src="{{asset('assets/web/img/usser.png')}}" alt="">
                                          </span> 
                                          <!-- this name show after login  -->
                                          <!-- <div class="after_login">
                                             <a class="usernamee mb-2" href="javscript:;">Mohd. Nadeem</a>
                                             <a class="Login_btn" href="javscript:;">Logout</a>
                                             </div> -->
                                          <!-- this name show after login  -->  
                                          <a class="Login_btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop1" href="javscript:;">Login</a>
                                       </div>
                                       <div class="myaccount_bottom">
                                          <p>Don't have an account? <a data-bs-toggle="modal" data-bs-target="#staticBackdrop" href="javscript:;">Sign Up</a></p>
                                          <div class="row myaccount_icons mx-0 mt-3">
                                             <div class="col-auto">
                                                <a data-bs-toggle="modal" data-bs-target="#staticBackdrop" href="javscript:;"><img src="{{asset('assets/web/img/userr.png')}}" alt=""></a>
                                             </div>
                                             <div class="col-auto">
                                                <a href="javscript:;"><img src="{{asset('assets/web/img/checkk.png')}}" alt=""></a>
                                             </div>
                                             <div class="col-auto">
                                                <a href="javscript:;"><img src="{{asset('assets/web/img/fav.png')}}" alt=""></a>
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
            <div class="row header_menus mx-0">
               <div class="col">
                  <div class="header_menus_left">
                     <div class="row">
                        <div class="col-auto px-0">
                           <div class="mega_menus">
                              <a class="category_btn" href="javascript:;"><img src="{{asset('assets/web/img/categories.png')}}" alt=""> Categories</a>   
                              <div class="categories_main"> 
                                 <div class="accordion" id="accordionExample">
                                    <div class="accordion-item mb-3">
                                      <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                          Categories 1
                                        </button>
                                      </h2>
                                      <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                           <ul class="category_list">
                                             <li><a href="javscript:;">Categories 1</a></li>
                                             <li><a href="javscript:;">Categories 2</a></li>
                                             <li><a href="javscript:;">Categories 3</a></li>
                                             <li><a href="javscript:;">Categories 4</a></li>
                                             <li><a href="javscript:;">Categories 5</a></li>
                                             <li><a href="javscript:;">Categories 6</a></li>
                                           </ul>
                                        </div>
                                      </div>
                                    </div> 
                                    <div class="accordion-item mb-3">
                                       <h2 class="accordion-header" id="headingtwo">
                                         <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo">
                                           Categories 1
                                         </button>
                                       </h2>
                                       <div id="collapsetwo" class="accordion-collapse collapse" aria-labelledby="headingtwo" data-bs-parent="#accordionExample">
                                         <div class="accordion-body">
                                            <ul class="category_list">
                                              <li><a href="javscript:;">Categories 1</a></li>
                                              <li><a href="javscript:;">Categories 2</a></li>
                                              <li><a href="javscript:;">Categories 3</a></li>
                                              <li><a href="javscript:;">Categories 4</a></li>
                                              <li><a href="javscript:;">Categories 5</a></li>
                                              <li><a href="javscript:;">Categories 6</a></li>
                                            </ul>
                                         </div>
                                       </div>
                                    </div> 
                                    <div class="accordion-item mb-3">
                                       <h2 class="accordion-header" id="headingthree">
                                         <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethree" aria-expanded="true" aria-controls="collapsethree">
                                           Categories 1
                                         </button>
                                       </h2>
                                       <div id="collapsethree" class="accordion-collapse collapse" aria-labelledby="headingthree" data-bs-parent="#accordionExample">
                                         <div class="accordion-body">
                                            <ul class="category_list">
                                              <li><a href="javscript:;">Categories 1</a></li>
                                              <li><a href="javscript:;">Categories 2</a></li>
                                              <li><a href="javscript:;">Categories 3</a></li>
                                              <li><a href="javscript:;">Categories 4</a></li>
                                              <li><a href="javscript:;">Categories 5</a></li>
                                              <li><a href="javscript:;">Categories 6</a></li>
                                            </ul>
                                         </div>
                                       </div>
                                    </div>
                                    <div class="accordion-item mb-3">
                                       <h2 class="accordion-header" id="headingfour">
                                         <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefour" aria-expanded="true" aria-controls="collapsefour">
                                           Categories 1
                                         </button>
                                       </h2>
                                       <div id="collapsefour" class="accordion-collapse collapse" aria-labelledby="headingfour" data-bs-parent="#accordionExample">
                                         <div class="accordion-body">
                                            <ul class="category_list">
                                              <li><a href="javscript:;">Categories 1</a></li>
                                              <li><a href="javscript:;">Categories 2</a></li>
                                              <li><a href="javscript:;">Categories 3</a></li>
                                              <li><a href="javscript:;">Categories 4</a></li>
                                              <li><a href="javscript:;">Categories 5</a></li>
                                              <li><a href="javscript:;">Categories 6</a></li>
                                            </ul>
                                         </div>
                                       </div>
                                    </div>
                                    <div class="accordion-item mb-3">
                                       <h2 class="accordion-header" id="headingfive">
                                         <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefive" aria-expanded="true" aria-controls="collapsefive">
                                           Categories 1
                                         </button>
                                       </h2>
                                       <div id="collapsefive" class="accordion-collapse collapse" aria-labelledby="headingfive" data-bs-parent="#accordionExample">
                                         <div class="accordion-body">
                                            <ul class="category_list">
                                              <li><a href="javscript:;">Categories 1</a></li>
                                              <li><a href="javscript:;">Categories 2</a></li>
                                              <li><a href="javscript:;">Categories 3</a></li>
                                              <li><a href="javscript:;">Categories 4</a></li>
                                              <li><a href="javscript:;">Categories 5</a></li>
                                              <li><a href="javscript:;">Categories 6</a></li>
                                            </ul>
                                         </div>
                                       </div>
                                    </div>
                                  </div>
                              </div>
                           </div>
                        </div>
                        <div class="col">
                           <div class="menus">
                              <div class="header_search d-lg-none d-md-block d-block mb-md-3 mb-2">
                                 <form class="row" action="">
                                    <div class="col-md-8 mb-md-3 mb-2">
                                       <div class="form-group">
                                          <input type="text" id="search" name="search" class="form-control" placeholder="Search by make, model, Year Product type....">
                                       </div>
                                    </div>
                                    <div class="col-md-4 col mb-md-3 mb-2 ps-md-0 pe-md-3 pe-0">
                                       <div class="form-group">
                                          <select class="form-select border-start" aria-label="Default select example">
                                             <option selected>All Categories</option>
                                             <option value="1">One</option>
                                             <option value="2">Two</option>
                                             <option value="3">Three</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-12 col-3 mb-md-3 mb-2">
                                       <div class="form-group">
                                          <button type="search" class="Btn-design"><i class="fal fa-search"></i></button>
                                       </div>
                                    </div>
                                 </form>
                              </div>
                              <ul class="list-unstyled mb-0">
                                 <li>
                                     <a href="{{url('interior')}}">Interior</a>
                                 </li>
                                 <li>
                                    <a href="{{url('exterior')}}">Exterior</a>
                                 </li>
                                 <li>
                                     <a href="{{url('performance')}}">Performance</a>
                                 </li>
                                 <li>
                                    <a href="{{url('lighting')}}">Lighting</a>
                                 </li>
                                 <li>
                                    <a href="{{url('wheels')}}">Wheels</a>
                                 </li>
                                 <li>
                                    <a href="{{url('parts')}}">Parts</a>
                                 </li>
                                 <li class="d-lg-none d-md-block d-block">
                                    <a href="javscript:;">Help Center</a>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-auto">
                  <a class="help_center d-lg-block d-md-none d-none" href="javascript:;">Help Center</a>
                  <a class="mobile_menu_btn d-lg-none d-md-block d-block" href="javascript:;"><i class="far fa-bars"></i></a>
               </div>
            </div>
         </div>
      </header> 