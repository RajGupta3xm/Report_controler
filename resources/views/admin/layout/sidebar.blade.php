<aside>
   <div class="admin_main">
      <div class="siderbar_section">
         <div class="siderbar_inner">
            <div class="sidebar_logo">
               <a href="javscript:;"><img src="{{asset('assets/img/logo.png')}}" alt="Logo"> </a>
            </div>
            <diV class="sidebar_menus">
               <ul class="list-unstyled ps-1 m-0">
                  <li><a class="<?= Request::segment(2) == 'dashboard' || Request::segment(2) == 'change_password' || Request::segment(2) == 'edit_profile' || Request::segment(2) == 'dashboard' ? 'active' : ''; ?>" href="{{url('admin/dashboard')}}"  ><i class="fal fa-home"></i>Dashboard</a></li>
                  <li><a class="<?= Request::segment(2) == 'user-management' || Request::segment(2) == 'user-details' ? 'active' : ''; ?>" href="{{url('admin/user-management')}}" ><i class="fal fa-user"></i>Users Management</a></li>
                  <!-- <li><a class="" href="order-management.html"><i class="fal fa-box-full"></i>Order Management</a></li> -->
                  <li><a class="<?= Request::segment(2) == 'ingredient-management' || Request::segment(2) == 'content-edit' ? 'active' : ''; ?>" href="{{url('admin/ingredient-management')}}" ><i class="fal fa-utensils-alt"></i>Ingredients Management</a></li>
                  <li><a class="<?= Request::segment(2) == 'fitnessGoal-management' || Request::segment(2) == 'content-edit' ? 'active' : ''; ?>" href="{{url('admin/fitnessGoal-management')}}" ><i class="far fa-walking"></i>Fitness Goal Management</a></li>
                  <li><a class="<?= Request::segment(2) == 'dietPlan-management' || Request::segment(2) == 'add-diet-plan' || Request::segment(2) == 'edit-dietPlan' ? 'active' : ''; ?>" href="{{url('admin/dietPlan-management')}}" ><i class="far fa-salad"></i>Diet Plan Management</a></li>
                  <!-- <li><a class="" href="meal-management.html"><i class="fal fa-pizza-slice"></i>Meal Management</a></li>
                  <li><a class="" href="meal-plan-management.html"><i class="fal fa-lightbulb-on"></i>Meal Plan Management</a></li> -->
                  <li><a class="<?= Request::segment(2) == 'staff-management' || Request::segment(2) == 'add_staff_group' ? 'active' : ''; ?>" href="{{url('admin/staff-management')}}" ><i class="fal fa-clipboard-user"></i>Staff Management</a></li>
                  <!-- <li><a class="" href="fleet-management.html"><i class="fal fa-layer-group"></i>Fleet Management</a></li> -->
                  <li><a class="<?= Request::segment(2) == 'promo-code-management' ? 'active' : ''; ?>" href="{{url('admin/promo-code-management')}}" ><i class="fal fa-badge-percent"></i>Promo Code Management</a></li>
                  <li><a class="<?= Request::segment(2) == 'gift-card-management' || Request::segment(2) == '' ? 'active' : ''; ?>" href="{{url('admin/gift-card-management')}}" ><i class="fad fa-gift-card"></i>Gift Card Management</a></li>
                  <li><a class="<?= Request::segment(2) == 'refer-earn-management' ? 'active' : ''; ?>" href="{{url('admin/refer-earn-management')}}" ><i class="fad fa-coins"></i>Refer & Earn</a></li>
                  <!-- <li><a class="" href="notification-management.html"><i class="far fa-bell"></i>Notification Management</a></li>
                  <li><a class="" href="refer-and-earn.html"><i class="fad fa-coins"></i>Refer & Earn</a></li>
                  <li><a class="" href="report-management.html"><i class="far fa-file-spreadsheet"></i>Report Management</a></li> -->
                  <li><a class="<?= Request::segment(2) == 'content-management' || Request::segment(2) == 'content-edit' ? 'active' : ''; ?>" href="{{url('admin/content-management')}}" ><i class="fal fa-user-edit"></i>Content Management</a></li>
                  <li><a class="<?= Request::segment(2) == 'support-management' || Request::segment(2) == '/query/filter' ? 'active' : ''; ?>" href="{{url('admin/support-management')}}" href="help-support.html"><i class="fal fa-hands-heart"></i>Help & Support <span class="alert_box">{{$query_count}}</span></a></li>
               </ul>
            </diV>
         </div>
      </div>
   </div>
</aside>


<!-- <aside >
<div class="admin_main">
<div class="siderbar_section">
            <div class="siderbar_inner">
               <div class="sidebar_logo">
                  <a href="javscript:;"><img src="{{asset('assets/img/logo.png')}}" alt="Logo"> </a>
               </div>
               <diV class="sidebar_menus mt-4">
                  <ul class="list-unstyled ps-1 m-0">
                     <li><a class="<?= Request::segment(2) == 'dashboard' || Request::segment(2) == 'user-details' || Request::segment(2) == 'pet-details' || Request::segment(2) == 'dashboard' ? 'active' : ''; ?>" href="{{url('admin/dashboard')}}"><i class="fas fa-home me-3"></i>Dashboard</a></li>
                     <li><a class="<?= Request::segment(2) == 'user-management' || Request::segment(2) == 'user-detail'|| Request::segment(2) == 'pet-detail' ? 'active' : ''; ?>" href="{{url('admin/user-management')}}"><i class="fas fa-user me-3"></i>User Management</a></li>
                     <li><a class="<?= Request::segment(2) == 'training-management' || Request::segment(2) == 'upload-request' ? 'active' : ''; ?>" href="{{url('admin/training-management')}}"><i class="fas fa-video me-3"></i>Training Videos</a></li>
                     <li><a class="<?= Request::segment(2) == 'content-management' || Request::segment(2) == 'content-edit' ? 'active' : ''; ?>" href="{{url('admin/content-management')}}"><i class="fab fa-telegram-plane me-3"></i>Content Management</a></li>
                     <li><a class="<?= Request::segment(2) == 'support-management' || Request::segment(2) == '/query/filter' ? 'active' : ''; ?>" href="{{url('admin/support-management')}}"><i class="fas fa-user-headset me-3"></i>Help & Support</a></li>
                     <li><a  href="{{url('/admin/logout')}}"><i class="fas fa-sign-out-alt me-3"></i>Logout</a></li>
                  </ul>
               </diV>
            </div>
         </div>
         <div>
</aside> -->