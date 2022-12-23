@extends('admin.layout.master')
@section('content')
      <div class="admin_main">
         <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    <strong class="close" data-dismiss="alert " aria-hidden="true"></strong>
                    {{ session()->get('success') }}
                </div>
                @else 
                @if(session()->has('error'))  
                <div class="alert alert-danger">
                    <strong class="close" ></strong>
                    {{ session()->get('error') }}
                </div>
                @endif 
                @endif
               <div class="row staff-management justify-content-center">
                  <div class="col-12"> 
                     <div class="row mx-0"> 
                        <div class="col-12 text-end mb-4">
                           <a href="<?= url('admin/add_staff_group')?>" class="comman_btn">Add Staff Group</a> 
                        </div>
                        <div class="col-12 design_outter_comman shadow mb-4">
                           <div class="row comman_header justify-content-between"> 
                              <div class="col-auto">
                                 <h2>Add New Staff Member</h2>
                              </div> 
                           </div>
                           <form class="form-design py-4 px-3 help-support-form row align-items-start justify-content-between"  method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/staff_member/submit')}}">
                              @csrf
                              <div class="form-group col-4">
                                 <label for="">Staff Name</label>
                                 <input type="text" class="form-control validate" value="" name="name" id="name">
                                 <p class="text-danger text-small" id="nameError"></p>
                              </div>
                              <div class="form-group col-4 choose_file position-relative">
                                 <span>Upload Image</span>
                                 <label for="image1"><i class="fal fa-camera me-1"></i>Choose File</label>
                                 <input type="file" class="form-control validate" value="" name="image1" id="image1">
                                 <p class="text-danger text-small" id="image1Error"></p>
                              </div>
                              <div class="form-group col-4">
                                 <label for="">Staff Group</label>
                                 <select class="form-select form-control validate" name="group_id" aria-label="Default select example">
                                    <option selected>Select Group</option>
                                    @foreach($staff_group as $staff_groups)
                                    <option value="{{$staff_groups->id}}">{{$staff_groups->name}}</option>
                                  @endforeach
                                  </select>
                              </div> 
                              <div class="form-group col-6">
                                 <label for="">Staff Email</label>
                                 <input type="text" class="form-control validate" name="email" id="name">
                                 <p class="text-danger text-small" id="emailError"></p>
                              </div> 
                              <div class="form-group col-6">
                                 <label for="">Create Password</label>
                                 <input type="text" class="form-control validate" name="password" id="name">
                                 <p class="text-danger text-small" id="passwordError"></p>
                              </div> 
                              <div class="form-group col-12 Modules_check">
                                 <div class="row">
                                 <div class="col-12 mb-3 d-flex align-items-center">
                                       <div class="Modules_head">Modules: </div>
                                        <div class="form-group mb-0 Access_part d-flex align-items-center">
                                           <span>Provide Admin Access</span> 
                                           <div class="Access_part_main d-inline-flex shadow ms-3">
                                              <a id="disable"class="vaccine_name " href="javscript:;">Yes</a>
                                              <a id="not_disable" class="vaccine_names active" href="javscript:;">No</a>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                    <div class="row modules_part">
                                    <div class="col-4">
                                       <div class="row">
                                          <div class="col-12 mb-3">
                                             <div class="row">
                                                <div class="col-12 mb-1">
                                                   <strong>Users Management:</strong>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class=" d-none checkbox"  checked type="radio" id="check11"  value="1" name="check11">
                                                      <label for="check11">Viewer </label>
                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class=" d-none checkbox" type="radio" id="check12"  value="2" name="check11">
                                                      <label for="check12">Editor </label>
                                                   </div>
                                                </div>
                                                <!-- <div class="col-auto">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none" type="radio" id="check13"  value="3" name="check11">
                                                      <label for="check13">Admin </label>
                                                   </div>
                                                </div> -->
                                             </div>
                                          </div>
                                          <div class="col-12 mb-3">
                                             <div class="row">
                                                <div class="col-12 mb-1">
                                                   <strong>Order Management:</strong>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" checked type="radio" id="checkv4" value="1" name="checkv4">
                                                      <label for="checkv4">Viewer </label>
                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" type="radio" id="checkv5" value="2" name="checkv4">
                                                      <label for="checkv5">Editor </label>
                                                   </div>
                                                </div>
                                                <!-- <div class="col-auto">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none" type="radio" id="checkv6" value="3" name="checkv4">
                                                      <label for="checkv6">Admin </label>
                                                   </div>
                                                </div> -->
                                             </div>
                                          </div>
                                          <div class="col-12 mb-3">
                                             <div class="row">
                                                <div class="col-12 mb-1">
                                                   <strong>Ingredients Management:</strong>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" checked type="radio" id="checkV1" value="1" name="checki1">
                                                      <label for="checkV1">Viewer </label>
                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" type="radio" id="checkV2" value="2" name="checki1">
                                                      <label for="checkV2">Editor </label>
                                                   </div>
                                                </div>
                                                <!-- <div class="col-auto">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none" checked type="radio" id="checkV3" value="3" name="checki1">
                                                      <label for="checkV3">Admin </label>
                                                   </div>
                                                </div> -->
                                             </div>
                                          </div>
                                          <div class="col-12 mb-3">
                                             <div class="row">
                                                <div class="col-12 mb-1">
                                                   <strong>Fitness Goal Management:</strong>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" checked type="radio" id="check01" value="1" name="check01">
                                                      <label for="check01">Viewer </label>
                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" type="radio" id="check02" value="2" name="check01">
                                                      <label for="check02">Editor </label>
                                                   </div>
                                                </div>
                                                <!-- <div class="col-auto">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none" type="radio" id="check03" value="3" name="check01">
                                                      <label for="check03">Admin </label>
                                                   </div>
                                                </div> -->
                                             </div>
                                          </div>
                                          <div class="col-12 mb-3">
                                             <div class="row">
                                                <div class="col-12 mb-1">
                                                   <strong>Diet Plan Management:</strong>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" type="radio" id="checkk1" value="1" name="checkk1">
                                                      <label for="checkk1">Viewer </label>
                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" type="radio" checked id="checkk2" value="2" name="checkk1">
                                                      <label for="checkk2">Editor </label>
                                                   </div>
                                                </div>
                                                <!-- <div class="col-auto">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none" type="radio" id="checkk3" value="3" name="checkk1">
                                                      <label for="checkk3">Admin </label>
                                                   </div>
                                                </div> -->
                                             </div>
                                          </div> 
                                       </div>
                                    </div>
                                    <div class="col-4 border-end ps-4 border-start">
                                       <div class="row">
                                          <div class="col-12 mb-3">
                                             <div class="row">
                                                <div class="col-12 mb-1">
                                                   <strong>Meal Management:</strong>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" type="radio" id="v1" value="1" name="v1">
                                                      <label for="v1">Viewer </label>
                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" type="radio" checked id="v2" value="2" name="v1">
                                                      <label for="v2">Editor </label>
                                                   </div>
                                                </div>
                                                <!-- <div class="col-auto">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none" type="radio" id="v3" value="3" name="v1">
                                                      <label for="v3">Admin </label>
                                                   </div>
                                                </div> -->
                                             </div>
                                          </div> 
                                          <div class="col-12 mb-3">
                                             <div class="row">
                                                <div class="col-12 mb-1">
                                                   <strong>Meal Plan Management:</strong>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" checked type="radio" id="v4" value="1" name="v2">
                                                      <label for="v4">Viewer </label>
                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" type="radio" id="v5" value="2" name="v2">
                                                      <label for="v5">Editor </label>
                                                   </div>
                                                </div>
                                                <!-- <div class="col-auto">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none" checked type="radio" id="v6" value="3" name="v2">
                                                      <label for="v6">Admin </label>
                                                   </div>
                                                </div> -->
                                             </div>
                                          </div>  
                                          <div class="col-12 mb-3">
                                             <div class="row">
                                                <div class="col-12 mb-1">
                                                   <strong>Fleet Management:</strong>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" checked type="radio" id="v7" value="1" name="v3">
                                                      <label for="v7">Viewer </label>
                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" type="radio" id="v8" value="2" name="v3">
                                                      <label for="v8">Editor </label>
                                                   </div>
                                                </div>
                                                <!-- <div class="col-auto">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none" checked type="radio" id="v9" value="3" name="v3">
                                                      <label for="v9">Admin </label>
                                                   </div>
                                                </div> -->
                                             </div>
                                          </div>
                                          <div class="col-12 mb-3">
                                             <div class="row">
                                                <div class="col-12 mb-1">
                                                   <strong>Promo Code Management:</strong>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" checked type="radio" id="v10" value="1" name="v4">
                                                      <label for="v10">Viewer </label>
                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" type="radio" id="v11" value="2" name="v4">
                                                      <label for="v11">Editor </label>
                                                   </div>
                                                </div>
                                                <!-- <div class="col-auto">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none" checked type="radio" id="v12" value="3" name="v4">
                                                      <label for="v12">Admin </label>
                                                   </div>
                                                </div> -->
                                             </div>
                                          </div> 
                                          <div class="col-12 mb-3">
                                             <div class="row">
                                                <div class="col-12 mb-1">
                                                   <strong>Gift Card Management:</strong>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" checked type="radio" id="v13" value="1" name="v5">
                                                      <label for="v13">Viewer </label>
                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" type="radio" id="v14" value="2" name="v5">
                                                      <label for="v14">Editor </label>
                                                   </div>
                                                </div>
                                                <!-- <div class="col-auto">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none"  type="radio" id="v15" value="3" name="v5">
                                                      <label for="v15">Admin </label>
                                                   </div>
                                                </div> -->
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-4 ps-4">
                                       <div class="row">
                                          <div class="col-12 mb-3">
                                             <div class="row">
                                                <div class="col-12 mb-1">
                                                   <strong>Notification Management:</strong>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" checked type="radio" id="v16" value="1" name="v6">
                                                      <label for="v16">Viewer </label>
                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" type="radio" id="v17" value="2" name="v6">
                                                      <label for="v17">Editor </label>
                                                   </div>
                                                </div>
                                                <!-- <div class="col-auto">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none"  type="radio" id="v18" value="3" name="v6">
                                                      <label for="v18">Admin </label>
                                                   </div>
                                                </div> -->
                                             </div>
                                          </div> 
                                          <div class="col-12 mb-3">
                                             <div class="row">
                                                <div class="col-12 mb-1">
                                                   <strong>Refer and Earn:</strong>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" checked type="radio" id="v18" value="1" name="v7">
                                                      <label for="v18">Viewer </label>
                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" type="radio" id="v19" value="2" name="v7">
                                                      <label for="v19">Editor </label>
                                                   </div>
                                                </div>
                                                <!-- <div class="col-auto">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none"  type="radio" id="v20" value="3" name="v7">
                                                      <label for="v20">Admin </label>
                                                   </div>
                                                </div> -->
                                             </div>
                                          </div>
                                          <div class="col-12 mb-3">
                                             <div class="row">
                                                <div class="col-12 mb-1">
                                                   <strong>Report Management:</strong>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" checked type="radio" id="v21" value="1" name="v8">
                                                      <label for="v21">Viewer </label>
                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" type="radio" id="v22" value="2" name="v8">
                                                      <label for="v22">Editor </label>
                                                   </div>
                                                </div>
                                                <!-- <div class="col-auto">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none"  type="radio" id="v23" value="3" name="v8">
                                                      <label for="v23">Admin </label>
                                                   </div>
                                                </div> -->
                                             </div>
                                          </div> 
                                          <div class="col-12 mb-3">
                                             <div class="row">
                                                <div class="col-12 mb-1">
                                                   <strong>Content Management:</strong>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" checked type="radio" id="v27" value="1" name="v10">
                                                      <label for="v27">Viewer </label>
                                                   </div>
                                                </div>
                                                <div class="col-6">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none checkbox" type="radio" id="v28" value="2" name="v10">
                                                      <label for="v28">Editor </label>
                                                   </div>
                                                </div>
                                                <!-- <div class="col-auto">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none"  type="radio" id="v29" value="3" name="v10">
                                                      <label for="v29">Admin </label>
                                                   </div>
                                                </div> -->
                                             </div>
                                          </div>
                                          <!-- <div class="col-12 mb-3">
                                             <div class="row">
                                                <div class="col-12 mb-1">
                                                   <strong>Help & Support Management:</strong>
                                                </div>
                                                <div class="col-auto">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none" checked type="radio" id="v30" name="v11">
                                                      <label for="v30">Viewer </label>
                                                   </div>
                                                </div>
                                                <div class="col-auto">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none" type="radio" id="v31" name="v11">
                                                      <label for="v31">Editor </label>
                                                   </div>
                                                </div>
                                                <div class="col-auto">
                                                   <div class="action_filter filter_check">
                                                      <input class="d-none"  type="radio" id="v32" name="v11">
                                                      <label for="v32">Admin </label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div> -->
                                       </div>
                                    </div>
                                    </div>
                                    </div>
                                 </div> 
                              </div>
                              <div class="form-group mb-0 col-12 text-center">
                                 <button type="button" onclick="validate(this)" class="comman_btn">Save</button>
                              </div>
                           </form>
                        </div>
                        <div class="col-12 design_outter_comman shadow">
                           <div class="row comman_header justify-content-between">
                              <div class="col">
                                 <h2>Staff Management</h2>
                              </div>
                              <div class="col-3">
                                 <form class="form-design" action="">
                                    <div class="form-group mb-0 position-relative icons_set">
                                       <input type="text" class="form-control" placeholder="Search" name="name" id="name" style="margin-top: 12px;">
                                       <i class="far fa-search"></i>
                                    </div>
                                 </form>
                              </div> 
                              <div class="col-auto d-flex align-items-center">
                                 <a href="javscript:;" class="comman_btn yellow-btn me-2">Print</a> 
                                 <div class="dropdown more_filters">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                       More Filters 
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1"> 
                                       <form action=""> 
                                          <div class="form-group mb-2">
                                             <label for="">Status :</label>
                                             <select class="form-select form-control" aria-label="Default select example">
                                                <option selected="" disabled="">Status</option>
                                                <option value="1">Active</option>
                                                <option value="2">Draft</option> 
                                              </select>
                                          </div> 
                                       </form>
                                    </div>
                                  </div>
                              </div>
                           </div> 
                           <div class="row">
                              <div class="col-12 comman_table_design px-0">
                                 <div class="table-responsive">
                                    <table class="table mb-0">
                                       <thead>
                                         <tr>
                                           <th>S.No.</th>
                                           <th>Date</th>
                                           <th>Media</th>
                                           <th>Staff Name</th>
                                           <th>Email</th> 
                                           <th>Group</th> 
                                           <th>Status</th>
                                           <th>Action</th>
                                         </tr>
                                       </thead>
                                       <tbody>
                                          @foreach($staff_member as $key=>$staff_members)
                                         <tr>
                                           <td>{{$key+1}}</td> 
                                           <td>{{date('d/m/Y', strtotime($staff_members->created_at))}}</td>
                                           <td>
                                             <img class="table_img" src="{{$staff_members->image?$staff_members->image:asset('assets/img/bg-img.jpg')}}" alt="">
                                           </td>
                                           <td>{{$staff_members->name}}</td>
                                           <td>{{$staff_members->email}}</td> 
                                           <td>{{$staff_members->group['name']}}</td>  
                                           <td>
                                           <div class="mytoggle">
                                                    <label class="switch">
                                                       <input type="checkbox" onchange="changeStatus(this, '<?= $staff_members->id ?>');" <?= ( $staff_members->status == 'active' ? 'checked' : '') ?>><span class="slider"></span><span class="labels"> </span> 
                                                    </label>
                                                </div>
                                          </td>
                                          <td>
                                             <!-- <a data-bs-toggle="modal" data-bs-target="#staticBackdrop{{$staff_members->id}}" class="comman_btn table_viewbtn" href="javscript:;">Edit</a> -->
                                             <a class="comman_btn table_viewbtn " onclick="showmodal(this,'{{$staff_members->id}}');"  href="javscript:;"  data-toggle="modal"  >Edit</a> 
                                             <a class="comman_btn table_viewbtn me-1" href="activity.html">Activity</a>
                                          </td>
                                         </tr> 
                                       @endforeach
                                       </tbody>
                                     </table>
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

 <!--modals-->
<div class="modal fade comman_modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
     <div class="modal-content border-0">
       <div class="modal-header">
         <h5 class="modal-title" id="staticBackdropLabel">Edit Staff</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body">
         <form class="form-design py-4 px-3 help-support-form row align-items-start justify-content-center"  id="queryForms">
         @csrf
         <input type="hidden" class="form-control"  id="id" name="id" >
            <div class="form-group col-12 text-center">
               <div class="account_profile d-inline-block position-relative">
                  <div class="circle">
                     <img class="profile-pic" src="{{$staff_members->image?$staff_members->image:asset('assets/img/profile_img1.png')}}"> 
                  </div>
                  <div class="p-image">
                     <i class="upload-button fas fa-camera"></i> 
                     <input class="file-upload" type="file" name="image3" id="file1" accept="image/*">
                  </div>
               </div>
            </div>
            <div class="form-group col-6">
               <label for="">Staff Name</label>
               <input type="text" class="form-control"  name="name" id="namee">
            </div> 
            <div class="form-group col-6">
               <label for="">Staff Group</label>
               <select class="form-select form-control" name="group_id" aria-label="Default select example">
                  @foreach($staff_group as $staff_groups)
                  <option value="{{$staff_groups->id}}"  @if($staff_members->group['id'] == $staff_groups['id'])  selected  @endif >{{$staff_groups->name}}</option>
                  @endforeach
                </select>
            </div> 
            <div class="form-group col-6">
               <label for="">Staff Email</label>
               <input type="text" class="form-control"  name="email" id="email">
            </div> 
            <div class="form-group col-6">
               <label for="">Create Password</label>
               <input type="text" class="form-control" value="" name="password" id="name">
            </div> 
            <div class="form-group col-12 Modules_check">
               <div class="row">
               <div class="col-12 mb-3 d-flex align-items-center">
                 <div class="Modules_head">Modules: </div>
                     <div class="form-group mb-0 Access_part d-flex align-items-center">
                           <span>Provide Admin Access</span> 
                           <div class="Access_part_main d-inline-flex shadow ms-3">
                              <a id="disablee"class="vaccine_names" href="javscript:;">Yes</a>
                              <a id="not_disablee" class="vaccine_namess active" href="javscript:;">No</a>
                           </div>
                      </div>
                  </div>
                  <div class="col-12">
                   <div class="row modules_partss">
                  <div class="col-4">
                     <div class="row">
                        <div class="col-12 mb-3">
                           <div class="row">
                              <div class="col-12 mb-1">
                                 <strong>Users Management:</strong>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox"  type="radio" id="check111" name="check11" value="1"  >
                                    <label for="check111">Viewer </label>
                                 </div>
                              </div>
                              <div class="col-e">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio" id="check121" name="check11" value="2"   >
                                    <label for="check121">Editor </label>
                                 </div>
                              </div>
                              <!-- <div class="col-auto">
                                 <div class="action_filter filter_check">
                                    <input class="d-none" type="radio" id="check131" name="check11" value="3"   >
                                    <label for="check131">Admin </label>
                                 </div>
                              </div> -->
                           </div>
                        </div>
                        <div class="col-12 mb-3">
                           <div class="row">
                              <div class="col-12 mb-1">
                                 <strong>Order Management:</strong>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox"  type="radio" id="checkv41" name="checkv4" value="1" >
                                    <label for="checkv41">Viewer </label>
                                 </div>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio" id="checkv51" name="checkv4" value="2" >
                                    <label for="checkv51">Editor </label>
                                 </div>
                              </div>
                              <!-- <div class="col-auto">
                                 <div class="action_filter filter_check">
                                    <input class="d-none" type="radio" id="checkv61" name="checkv4" value="3">
                                    <label for="checkv61">Admin </label>
                                 </div>
                              </div> -->
                           </div>
                        </div>
                        <div class="col-12 mb-3">
                           <div class="row">
                              <div class="col-12 mb-1">
                                 <strong>Ingredients Management:</strong>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio" id="checkV11" value="1" name="checki1"  >
                                    <label for="checkV11">Viewer </label>
                                 </div>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio" id="checkV21" value="2" name="checki1"  >
                                    <label for="checkV21">Editor </label>
                                 </div>
                              </div>
                              <!-- <div class="col-auto">
                                 <div class="action_filter filter_check">
                                    <input class="d-none"  type="radio" id="checkV31" value="3" name="checki1" >
                                    <label for="checkV31">Admin </label>
                                 </div>
                              </div> -->
                           </div>
                        </div>
                        <div class="col-12 mb-3">
                           <div class="row">
                              <div class="col-12 mb-1">
                                 <strong>Fitness Goal Management:</strong>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox"  type="radio" id="check011" name="check01" value="1">
                                    <label for="check011">Viewer </label>
                                 </div>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio" id="check021" name="check01" value="2">
                                    <label for="check021">Editor </label>
                                 </div>
                              </div>
                              <!-- <div class="col-auto">
                                 <div class="action_filter filter_check">
                                    <input class="d-none" type="radio" id="check031" name="check01" value="3" >
                                    <label for="check031">Admin </label>
                                 </div>
                              </div> -->
                           </div>
                        </div>
                        <div class="col-12 mb-3">
                           <div class="row">
                              <div class="col-12 mb-1">
                                 <strong>Diet Plan Management:</strong>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio" id="checkk11" name="checkk1" value="1">
                                    <label for="checkk11">Viewer </label>
                                 </div>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio"  id="checkk21" name="checkk1" value="2" >
                                    <label for="checkk21">Editor </label>
                                 </div>
                              </div>
                              <!-- <div class="col-auto">
                                 <div class="action_filter filter_check">
                                    <input class="d-none" type="radio" id="checkk31" name="checkk1" value="3" >
                                    <label for="checkk31">Admin </label>
                                 </div>
                              </div> -->
                           </div>
                        </div> 
                     </div>
                  </div>
                  <div class="col-4 border-end ps-4 border-start">
                     <div class="row">
                        <div class="col-12 mb-3">
                           <div class="row">
                              <div class="col-12 mb-1">
                                 <strong>Meal Management:</strong>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio" id="v111" name="v1" value="1" >
                                    <label for="v111">Viewer </label>
                                 </div>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio"  id="v211" name="v1" value="2" >
                                    <label for="v211">Editor </label>
                                 </div>
                              </div>
                              <!-- <div class="col-auto">
                                 <div class="action_filter filter_check">
                                    <input class="d-none" type="radio" id="v311" name="v1" value="3">
                                    <label for="v311">Admin </label>
                                 </div>
                              </div> -->
                           </div>
                        </div> 
                        <div class="col-12 mb-3">
                           <div class="row">
                              <div class="col-12 mb-1">
                                 <strong>Meal Plan Management:</strong>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio" id="v411" name="v2" value="1" >
                                    <label for="v411">Viewer </label>
                                 </div>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio" id="v511" name="v2" value="2" >
                                    <label for="v511">Editor </label>
                                 </div>
                              </div>
                              <!-- <div class="col-auto">
                                 <div class="action_filter filter_check">
                                    <input class="d-none"  type="radio" id="v611" name="v2" value="3">
                                    <label for="v611">Admin </label>
                                 </div>
                              </div> -->
                           </div>
                        </div>  
                        <div class="col-12 mb-3">
                           <div class="row">
                              <div class="col-12 mb-1">
                                 <strong>Fleet Management:</strong>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio" id="v711" name="v3" value="1" >
                                    <label for="v711">Viewer </label>
                                 </div>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio" id="v811" name="v3" value="2" >
                                    <label for="v811">Editor </label>
                                 </div>
                              </div>
                              <!-- <div class="col-auto">
                                 <div class="action_filter filter_check">
                                    <input class="d-none"  type="radio" id="v911" name="v3" value="3">
                                    <label for="v911">Admin </label>
                                 </div>
                              </div> -->
                           </div>
                        </div>
                        <div class="col-12 mb-3">
                           <div class="row">
                              <div class="col-12 mb-1">
                                 <strong>Promo Code Management:</strong>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio" id="v101" name="v4" value="1">
                                    <label for="v101">Viewer </label>
                                 </div>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio" id="v1111" name="v4" value="2" >
                                    <label for="v1111">Editor </label>
                                 </div>
                              </div>
                              <!-- <div class="col-auto">
                                 <div class="action_filter filter_check">
                                    <input class="d-none"  type="radio" id="v112" name="v4" value="3">
                                    <label for="v112">Admin </label>
                                 </div>
                              </div> -->
                           </div>
                        </div> 
                        <div class="col-12 mb-3">
                           <div class="row">
                              <div class="col-12 mb-1">
                                 <strong>Gift Card Management:</strong>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox"  type="radio" id="v131" name="v5" value="1">
                                    <label for="v131">Viewer </label>
                                 </div>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio" id="v141" name="v5" value="2" >
                                    <label for="v141">Editor </label>
                                 </div>
                              </div>
                              <!-- <div class="col-auto">
                                 <div class="action_filter filter_check">
                                    <input class="d-none"  type="radio" id="v151" name="v5" value="3" >
                                    <label for="v151">Admin </label>
                                 </div>
                              </div> -->
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-4 ps-4">
                     <div class="row">
                        <div class="col-12 mb-3">
                           <div class="row">
                              <div class="col-12 mb-1">
                                 <strong>Notification Management:</strong>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox"  type="radio" id="v161" name="v6" value="1" >
                                    <label for="v161">Viewer </label>
                                 </div>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio" id="v171" name="v6" value="2" >
                                    <label for="v171">Editor </label>
                                 </div>
                              </div>
                              <!-- <div class="col-auto">
                                 <div class="action_filter filter_check">
                                    <input class="d-none"  type="radio" id="v181" name="v6" value="3">
                                    <label for="v181">Admin </label>
                                 </div>
                              </div> -->
                           </div>
                        </div> 
                        <div class="col-12 mb-3">
                           <div class="row">
                              <div class="col-12 mb-1">
                                 <strong>Refer and Earn:</strong>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox"  type="radio" id="v1811" name="v7" value="1" >
                                    <label for="v1811">Viewer </label>
                                 </div>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio" id="v191" name="v7" value="2" >
                                    <label for="v191">Editor </label>
                                 </div>
                              </div>
                              <!-- <div class="col-auto">
                                 <div class="action_filter filter_check">
                                    <input class="d-none"  type="radio" id="v201" name="v7" value="3" >
                                    <label for="v201">Admin </label>
                                 </div>
                              </div> -->
                           </div>
                        </div>
                        <div class="col-12 mb-3">
                           <div class="row">
                              <div class="col-12 mb-1">
                                 <strong>Report Management:</strong>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox"  type="radio" id="v2111" name="v8" value="1">
                                    <label for="v2111">Viewer </label>
                                 </div>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio" id="v221" name="v8" value="2">
                                    <label for="v221">Editor </label>
                                 </div>
                              </div>
                              <!-- <div class="col-auto">
                                 <div class="action_filter filter_check">
                                    <input class="d-none"  type="radio" id="v231" name="v8" value="3" >
                                    <label for="v231">Admin </label>
                                 </div>
                              </div> -->
                           </div>
                        </div> 
                        <div class="col-12 mb-3">
                           <div class="row">
                              <div class="col-12 mb-1">
                                 <strong>Content Management:</strong>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox"  type="radio" id="v217" name="v10" value="1">
                                    <label for="v217">Viewer </label>
                                 </div>
                              </div>
                              <div class="col-6">
                                 <div class="action_filter filter_check">
                                    <input class="d-none checkbox" type="radio" id="v218" name="v10" value="2" >
                                    <label for="v218">Editor </label>
                                 </div>
                              </div>
                              <!-- <div class="col-auto">
                                 <div class="action_filter filter_check">
                                    <input class="d-none"  type="radio" id="v129" name="v10" value="3" >
                                    <label for="v129">Admin </label>
                                 </div>
                              </div> -->
                           </div>
                        </div>
                        <!-- <div class="col-12 mb-3">
                           <div class="row">
                              <div class="col-12 mb-1">
                                 <strong>Help & Support Management:</strong>
                              </div>
                              <div class="col-auto">
                                 <div class="action_filter filter_check">
                                    <input class="d-none" checked type="radio" id="v30" name="v11">
                                    <label for="v30">Viewer </label>
                                 </div>
                              </div>
                              <div class="col-auto">
                                 <div class="action_filter filter_check">
                                    <input class="d-none" type="radio" id="v31" name="v11">
                                    <label for="v31">Editor </label>
                                 </div>
                              </div>
                              <div class="col-auto">
                                 <div class="action_filter filter_check">
                                    <input class="d-none"  type="radio" id="v32" name="v11">
                                    <label for="v32">Admin </label>
                                 </div>
                              </div>
                           </div>
                        </div> -->
                     </div>
                  </div>
                  </div>
                  </div>
               </div> 
            </div>
            <div class="form-group mb-0 col-12 text-center">
               <button type="button" onclick="sendReply(this)" class="comman_btn">Save</button>
            </div>
         </form>
       </div> 
     </div>
   </div>
 </div>
 <!--End modals-->
 <script src="assets/vendor/jquery.min.js"></script>
      <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="assets/vendor/owl/owl.carousel.min.js"></script>
      <script src="assets/js/main.js"></script>
   
      <script> 
        $('#disablee').on('click', function (e) { 
            // $('.Access_part_main').toggleClass('access_solve'); 
            $('.vaccine_namess').removeClass('active');
            $('.vaccine_names').addClass('active');
            $('.modules_partss').addClass('disable_all');  
            var x = document.getElementsByClassName("checkbox");
            var i;
             for (i = 0; i < x.length; i++) {
               x[i].disabled = true;
          }
         }) 
      </script>
       <script> 
        $('#not_disablee').on('click', function () { 
            // $('.Access_part_main').toggleClass('access_solve');
            $('.vaccine_names').removeClass('active'); 
            $('.vaccine_namess').addClass('active');
            $('.modules_partss').removeClass('disable_all'); 
            var x = document.getElementsByClassName("checkbox");
            var i;
             for (i = 0; i < x.length; i++) {
               x[i].disabled = false;
          }
         }) 
      </script>
    <script> 
        $('#disable').on('click', function (e) { 
            // $('.Access_part_main').toggleClass('access_solve'); 
            $('.vaccine_names').removeClass('active');
            $('.vaccine_name').addClass('active');
            $('.modules_part').addClass('disable_all');  
            var x = document.getElementsByClassName("checkbox");
            var i;
             for (i = 0; i < x.length; i++) {
               x[i].disabled = true;
          }
         }) 
      </script>
       <script> 
        $('#not_disable').on('click', function () { 
            // $('.Access_part_main').toggleClass('access_solve');
            $('.vaccine_name').removeClass('active'); 
            $('.vaccine_names').addClass('active');
            $('.modules_part').removeClass('disable_all'); 
            var x = document.getElementsByClassName("checkbox");
            var i;
             for (i = 0; i < x.length; i++) {
               x[i].disabled = false;
          }
         }) 
      </script>
 @endsection

      
 <script>
   function showmodal(obj,id) {
    
      $.ajax({
        type : 'get',
        url  : "<?= url('admin/get_staff_member/data/') ?>/" + id,
        data : {'id':id},
        success:function(data){
            console.log(data);
          $('#id').val(data.id);
          $('#namee').val(data.name);
          $('#email').val(data.email);
          $('input[name^="check11"][value="'+data.user_mgmt+'"').prop('checked',true);
          $('input[name^="checkv4"][value="'+data.order_mgmt+'"').prop('checked',true);
          $('input[name^="checki1"][value="'+data.ingredient_mgmt+'"').prop('checked',true);
          $('input[name^="check01"][value="'+data.fitness_goal_mgmt+'"').prop('checked',true);
          $('input[name^="checkk1"][value="'+data.diet_plan_mgmt+'"').prop('checked',true);
          $('input[name^="v1"][value="'+data.meal_mgmt+'"').prop('checked',true);
          $('input[name^="v2"][value="'+data.meal_plan_mgmt+'"').prop('checked',true);
          $('input[name^="v3"][value="'+data.fleet_mgmt+'"').prop('checked',true);
          $('input[name^="v4"][value="'+data.promo_code_mgmt+'"').prop('checked',true);
          $('input[name^="v5"][value="'+data.gift_card_mgmt+'"').prop('checked',true);
          $('input[name^="v6"][value="'+data.notification_mgmt+'"').prop('checked',true);
          $('input[name^="v7"][value="'+data.refer_earn_mgmt+'"').prop('checked',true);
          $('input[name^="v8"][value="'+data.report_mgmt+'"').prop('checked',true);
          $('input[name^="v10"][value="'+data.content_mgmt+'"').prop('checked',true);
          $('#staticBackdrop').modal('show');
        }
      });
   }

</script>
 <script>
    
function sendReply(obj) {

var flag = true;
let  formData = new FormData($("#queryForms")[0]);
formData.append('_token', "{{ csrf_token() }}");
var id = $('#id').val();
if (flag) {
    $.ajax({
        url: "<?= url('admin/edit_staff_member/update/') ?>/" + id,
        type: 'POST',
        //data: $("#carForm").serialize(),
        enctype: 'multipart/form-data',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {
            swal({
                title: "Details Updated!",
                text: data.message,
                icon: "success",
                buttons: false,
            });
            setTimeout(function() {
                location.reload();
            }, 2000);
        }
    });
}
}               
</script>
 

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script>
 $(window).load(function(){
   setTimeout(function(){ $('.alert-danger').fadeOut('slow') }, 3000);
});
  </script>
   <script>
 $(window).load(function(){
   setTimeout(function(){ $('.alert-success').fadeOut('slow') }, 3000);
});
  </script>
 <script>
            function validate(obj) {
            $(".text-danger").html('');
            var flag = true;
            var formData = $("#addForm").find(".validate:input").not(':input[type=button]');
            $(formData).each(function () {
                var element = $(this);
                var val = element.val();
                var name = element.attr("name");
                if (val == "" || val == "0" || val == null) {
                    
                $("#" + name + "Error").html("This field is required");
                flag = false;
                    
                    
                } else {

                }
            });
           
            if (flag) {
                $("#addForm").submit();
            } else {
                return false;
            }

            
        }
    </script>
    <script>
       function changeStatus(obj, id) {
            swal({
                title: "Are you sure?",
                text: " status will be closed",
                icon: "warning",
                buttons: ["No", "Yes"],
                dangerMode: true,
            })
                    .then((willDelete) => {
                        if (willDelete) {
                            var checked = $(obj).is(':checked');
                            if (checked == true) {
                                var status = 'active';
                            } else {
                                var status = 'inactive';
                            }
                            if (id) {
                                $.ajax({
                                    url: "<?= url('admin/staff_member/change_status') ?>",
                                    type: 'post',
                                    data: 'id=' + id + '&action=' + status + '&_token=<?= csrf_token() ?>',
                                    success: function (data) {
                                    
                                        swal({
                                           title: "Success!",
                                            text : "Status has been Updated ",
                                            icon : "success",
                                        })
                                    }
                                });
                            } else {
                                var data = {message: "Something went wrong"};
                                errorOccured(data);
                            }
                        } else {
                            var checked = $(obj).is(':checked');
                            if (checked == true) {
                                $(obj).prop('checked', false);
                            } else {
                                $(obj).prop('checked', true);
                            }
                            return false;
                        }
                    });
        }
    </script>
 