
<header > 
  <div class="admin_main">
      <div class="admin_main_inner">
          <div class="admin_header shadow">
              <div class="row align-items-center mx-0 justify-content-between w-100">
                  <div class="col">
                     <a class="sidebar_btn" href="javscript:;"><i class="far fa-bars"></i></a>
                    </div>
                    <div class="col-auto  d-flex align-items-center">
                    <a class="change_language" href="javascript:;"><img src="{{asset('assets/img/saudi-flag.png')}}" alt="">سعودي</a>
                      <div class="dropdown Profile_dropdown">
                          <button class="btn btn-secondary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                             <img src="{{$admin_image->image?$admin_image->image:asset('assets/img/profile.png')}}" alt="">
                           </button>
                           <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                             <li><a class="dropdown-item" href="{{url('admin/edit_profile')}}">Edit Profile</a></li>
                             <li><a class="dropdown-item" href="{{url('admin/change_password')}}">Change Password</a></li>
                              <li><a class="dropdown-item" href="{{url('admin/logout')}}">Logout</a></li>
                           </ul>
                       </div>
                   </div>
               </div>
          </div>
       </div>
   </div>
</header>

