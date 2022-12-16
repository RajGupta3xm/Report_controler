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
                <div class="row ingredients_management justify-content-center">
                    <div class="col-12">
                        <div class="row mx-0">
                            <div class="col-12 text-end mb-4 pe-0"> <a href="javscript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="comman_btn me-2">Export Excel</a> <a href="javscript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop1" class="comman_btn me-2">Import Excel</a> <a href="javscript:;" class="comman_btn yellow-btn me-2">Print</a> </div>
                            <div class="col-12 design_outter_comman shadow">
                                <div class="row">
                                    <div class="col-12 px-0 comman_tabs">
                                        <nav>
                                            <div class="nav nav-tabs" id="nav-tab" role="tablist"> <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Ingredients</button> <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Groups</button> <button class="nav-link" id="nav-profile2-tab" data-bs-toggle="tab" data-bs-target="#nav-profile2" type="button" role="tab" aria-controls="nav-profile2" aria-selected="false">Categories</button> <button class="nav-link" id="nav-profile1-tab" data-bs-toggle="tab" data-bs-target="#nav-profile1" type="button" role="tab" aria-controls="nav-profile1" aria-selected="false">Unit</button> </div>
                                        </nav>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <div class="row p-4 mx-0">
                                                    <div class="col-12 mb-4 inner_design_comman border">
                                                        <div class="row comman_header justify-content-between">
                                                            <div class="col-auto">
                                                                <h2>Add New Ingredient</h2>
                                                            </div>
                                                        </div>
                                                        <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between"  method="POST" id="addForm3" enctype="multipart/form-data" action="{{url('admin/ingredient/submit')}}">
                                                            @csrf
                                                            <div class="form-group col-4"> 
                                                                <label for="">Ingredient Name (En)</label> 
                                                                <input type="text" class="form-control validate" value="" name="name" id="name"> 
                                                                <p class="text-danger text-small" id="nameError"></p> 
                                                            </div>
                                                              <div class="form-group col-4">
                                                                 <label for="">Ingredient Name (Ar)</label> <input type="text" class="form-control validate" value="" name="name_ar" id="name"><p class="text-danger text-small" id="name_arError"></p>
                                                              </div>
                                                                <div class="form-group col-4"> 
                                                                <label for="">Group</label>
                                                                <select class="form-select form-control " name="group_id" aria-label="Default select example">
                                                                    <option selected>Select Group</option>
                                                                    @foreach($group as $groups)
                                                                    <option value="{{$groups->id}}">{{$groups->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group mb-0 col"> 
                                                                <label for="">Category</label>
                                                                <select class="form-select form-control validate" name="category_id" aria-label="Default select example">
                                                                    <option selected>Select Category</option>
                                                                    @foreach($category as $categories) 
                                                                    <option value="{{$categories->id}}">{{$categories->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                              
                                                            </div>
                                                            <div class="form-group mb-0 col"> 
                                                                <label for="">Unit</label> 
                                                                <select class="form-select form-control validate" name="unit_id" aria-label="Default select example">
                                                                    <option selected>Select Unit</option>
                                                                    @foreach($unit as $units) 
                                                                    <option value="{{$units->id}}">{{$units->unit}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group mb-0 col-auto"> <button type="button" onclick="validate3(this)" class="comman_btn">Save</button> </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-12 mb-4 inner_design_comman border">
                                                        <div class="row comman_header justify-content-start">
                                                            <div class="col">
                                                                <h2>Ingredients Management</h2>
                                                            </div>
                                                            <div class="col-3">
                                                                <form class="form-design" action="">
                                                                   <div class="form-group mb-0 position-relative icons_set">
                                                                      <input type="text" class="form-control" placeholder="Search" name="name" id="name"  style="margin-top: 12px;">
                                                                      <i class="far fa-search"></i>
                                                                   </div>
                                                                </form>
                                                             </div>
                                                            <div class="col-auto text-end">
                                                                <div class="dropdown more_filters"> <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"> Filters </button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                                        <form action="">
                                                                            <div class="form-group mb-2"> <label for="">Status :</label> <select class="form-select form-control" aria-label="Default select example">
                                                                                    <option selected="" disabled="">Status</option>
                                                                                    <option value="1">Active</option>
                                                                                    <option value="2">Draft</option>
                                                                                </select> </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 comman_table_design bg-white px-0">
                                                                <div class="table-responsive">
                                                                    <table class="table mb-0">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>S.No.</th>  
                                                                                <th>Ingredient Name (En)</th>
                                                                                <th>Ingredient Name (Ar)</th>
                                                                                <th>Category</th>
                                                                                <th>Group</th>
                                                                                <th>Unit</th>
                                                                                <th>Status</th>
                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($ingredient as $key=>$ingredients)
                                                                            <tr>
                                                                                <td>{{$key+1}}</td> 
                                                                                <td>{{$ingredients['name']?:'N/A'}}</td>
                                                                                <td>{{$ingredients['name_ar']?:'N/A'}}</td>
                                                                                <td>{{$ingredients->category['name']?:'N/A'}}</td>
                                                                                <td>{{$ingredients->group['name']?:'N/A'}}</td>
                                                                                <td>{{$ingredients->unit['unit']?:'N/A'}}</td>
                                                                                <td>
                                                                                <div class="mytoggle">
                                                                                   <label class="switch">
                                                                                     <input type="checkbox" onchange="changeStatus1(this, '<?= $ingredients->id ?>');" <?= ( $ingredients->status == 'active' ? 'checked' : '') ?>><span class="slider"></span><span class="labels"> </span> 
                                                                                    </label>
                                                                                </div>
                                                                                </td>
                                                                                <td> 
                                                                                    <!-- <a class="comman_btn table_viewbtn" href="javscript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop07">Edit</a>  -->
                                                                                    <a class="comman_btn table_viewbtn" href="javscript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop07{{$ingredients->id}}">Edit</a> 
                                                                                    <a class="comman_btn table_viewbtn delete_btn" onclick="deleteData1(this,'{{$ingredients->id}}');" href="javscript:;">Delete</a> 
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
                                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                <div class="row p-4 mx-0">
                                                    <div class="col-12 mb-4 inner_design_comman border">
                                                        <div class="row comman_header justify-content-between">
                                                            <div class="col-auto">
                                                                <h2>Add New Group</h2>
                                                            </div>
                                                        </div>
                                                        <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between"  method="POST" id="addForm2" enctype="multipart/form-data" action="{{url('admin/group/submit')}}">
                                                            @csrf
                                                            <div class="form-group mb-0 col"> <label for="">Group Name (En)</label> <input type="text" class="form-control validate" value="" name="group" ><p class="text-danger text-small" id="groupError"></p> </div>
                                                            <div class="form-group mb-0 col"> <label for="">Group Name (Ar)</label> <input type="text" class="form-control validate" value="" name="group_ar" ><p class="text-danger text-small" id="group_arError"></p> </div>
                                                            <div class="form-group mb-0 col choose_file position-relative"> <span>Upload Image</span> <label for="upload_video"><i class="fal fa-camera me-1"></i>Choose File</label> <input type="file" class="form-control validate" value="" name="images1" id="upload_video"><p class="text-danger text-small" id="imageError"></p> </div>
                                                            <div class="form-group mb-0 col-auto"> <button type="button" onclick="validate2(this)" class="comman_btn">Save</button> </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-12 mb-4 inner_design_comman border">
                                                        <div class="row comman_header justify-content-start">
                                                            <div class="col">
                                                                <h2>Groups Management</h2>
                                                            </div>
                                                            <div class="col-3">
                                                                <form class="form-design" action="">
                                                                   <div class="form-group mb-0 position-relative icons_set">
                                                                      <input type="text" class="form-control" placeholder="Search" name="name" id="name"  style="margin-top: 12px;">
                                                                      <i class="far fa-search"></i>
                                                                   </div>
                                                                </form>
                                                             </div>
                                                            <div class="col-auto text-end">
                                                                <div class="dropdown more_filters"> <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"> Filters </button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                                        <form action="">
                                                                            <div class="form-group mb-2"> <label for="">Status :</label> <select class="form-select form-control" aria-label="Default select example">
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
                                                            <div class="col-12 comman_table_design bg-white px-0">
                                                                <div class="table-responsive">
                                                                    <table class="table mb-0">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>S.No.</th> 
                                                                                <th>Media</th>
                                                                                <th>Group Name (En)</th>
                                                                                <th>Group Name (Ar)</th>
                                                                                <th>Status</th>
                                                                                <th>Action</th> 
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($group as $key=>$groups)
                                                                            <tr>
                                                                                <td>{{$key+1}}</td>
                                                                                <td> <img class="table_img" src="{{$groups->image?$groups->image:assets/img/bg-img.jpg}}" alt=""> </td>
                                                                                <td>{{$groups->name}}</td>
                                                                                <td>{{$groups->name_ar}}</td>
                                                                                <td>
                                                                                <div class="mytoggle">
                                                                                   <label class="switch">
                                                                                     <input type="checkbox" onchange="changeStatus(this, '<?= $groups->id ?>');" <?= ( $groups->status == 'active' ? 'checked' : '') ?>><span class="slider"></span><span class="labels"> </span> 
                                                                                    </label>
                                                                                </div>
                                                                                </td>
                                                                                <td> 
                                                                                    <a class="comman_btn table_viewbtn " onclick="showmodal(this,'{{$groups->id}}');"  href="javscript:;"  data-toggle="modal"  >Edit</a> 
                                                                                    <!-- <a class="comman_btn table_viewbtn delete_btn" href="javscript:;">Delete</a> -->
                                                                                    <a class="comman_btn table_viewbtn delete_btn" onclick="deleteData(this,'{{$groups->id}}');" href="javscript:;">Delete</a>
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
                                            <div class="tab-pane fade" id="nav-profile2" role="tabpanel" aria-labelledby="nav-profile2-tab">
                                                <div class="row p-4 mx-0">
                                                    <div class="col-12 mb-4 inner_design_comman border">
                                                        <div class="row comman_header justify-content-between">
                                                            <div class="col-auto">
                                                                <h2>Categories</h2>
                                                            </div>
                                                        </div>
                                                        <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between"  method="POST" id="addForms" enctype="multipart/form-data" action="{{url('admin/category/submit')}}">
                                                            @csrf
															<div class="form-group mb-0 col">
																<label for="">Ingredient Categories (En)</label>
																<input type="text" class="form-control validate" value="" name="category" > <p class="text-danger text-small" id="categoryError"></p> </div>
															<div class="form-group mb-0 col">
																<label for="">Ingredient Categories (Ar)</label>
																<input type="text" class="form-control validate" value="" name="category_ar" >  <p class="text-danger text-small" id="category_arError"></p></div>
															<div class="form-group mb-0 col-auto">
																<button type="button" onclick="validate1(this);" class="comman_btn" >Create</button>
															</div>
														</form>
                                                    </div>
                                                    <div class="col-12 mb-4 inner_design_comman border">
                              <div class="row comman_header justify-content-start">
                                <div class="col">
                                  <h2>Categories</h2>
                                </div>
                                <div class="col-3">
                                  <form class="form-design" action="">
                                    <div class="form-group mb-0 position-relative icons_set">
                                      <input type="text" class="form-control" placeholder="Search" name="name" id="name">
                                      <i class="far fa-search"></i>
                                    </div>
                                  </form>
                                </div>
                                <div class="col-auto text-end">
                                  <div class="dropdown more_filters">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"> Filters </button>
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
                                <div class="col-12 comman_table_design bg-white px-0">
                                  <div class="table-responsive">
                                    <table class="table mb-0">
                                      <thead>
                                        <tr>
                                          <th>S.No.</th>
                                          <th>Categories (En)</th>
                                          <th>Categories (Ar)</th>
                                          <th>Status</th>
                                          <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      @foreach($category as $key=>$categories)
                                        <tr>
                                          <td>{{$key+1}}</td>
                                          <td>{{$categories->name}}</td>
                                          <td>{{$categories->name_ar}}</td>
                                          <td>
                                               <div class="mytoggle">
                                                  <label class="switch">
                                                     <input type="checkbox" onchange="changeStatus2(this, '<?= $categories->id ?>');" <?= ($categories->status == 'active' ? 'checked' : '') ?>><span class="slider"></span><span class="labels"> </span> 
                                                   </label>
                                                </div>
                                          </td>
                                          <td>
                                            <!-- <a class="comman_btn table_viewbtn" href="javscript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop09">Edit</a> -->
                                            <a class="comman_btn table_viewbtn " onclick="showmodal1(this,'{{$categories->id}}');"  href="javscript:;"  data-toggle="modal"  >Edit</a> 
                                            <a class="comman_btn table_viewbtn delete_btn" onclick="deleteCategoryData(this,'{{$categories->id}}');" href="javscript:;">Delete</a>
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
                                            <div class="tab-pane fade" id="nav-profile1" role="tabpanel" aria-labelledby="nav-profile1-tab">
                                                <div class="row p-4 mx-0">
                                                    <div class="col-12 mb-4 inner_design_comman border">
                                                        <div class="row comman_header justify-content-between">
                                                            <div class="col-auto">
                                                                <h2>Unit</h2>
                                                            </div>
                                                        </div>
                                                        <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between"  method="POST" id="addForm" enctype="multipart/form-data" action="{{url('admin/unit_submit')}}">
                                                        {{ csrf_field() }} 
                                                            <div class="form-group mb-0 col ">
                                                                 <label for="">Ingredient Unit (En)</label>
                                                                  <input type="text" class="form-control validate" value="" name="name" id="name">
                                                                   <p class="text-danger text-small" id="nameError"></p>
                                                            </div>
                                                            <div class="form-group mb-0 col "> 
                                                                <label for="">Ingredient Unit (Ar)</label> 
                                                                <input type="text" class="form-control validate" value="" name="name_ar" id="name">
                                                                 <p class="text-danger text-small" id="name_arError"></p>
                                                             </div>
                                                            <div class="form-group mb-0 col-auto">
                                                                 <button type="button" onclick="validate(this);" class="comman_btn" >Create</button> 
                                                                </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-12 mb-4 inner_design_comman border">
                                <div class="row comman_header justify-content-start">
                                  <div class="col">
                                    <h2>Unit</h2>
                                  </div>
                                  <div class="col-3">
                                    <form class="form-design" action="">
                                      <div class="form-group mb-0 position-relative icons_set">
                                        <input type="text" class="form-control" placeholder="Search" name="name" id="name">
                                        <i class="far fa-search"></i>
                                      </div>
                                    </form>
                                  </div>
                                  <div class="col-auto text-end">
                                    <div class="dropdown more_filters">
                                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"> Filters </button>
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
                                  <div class="col-12 comman_table_design bg-white px-0">
                                    <div class="table-responsive">
                                      <table class="table mb-0">
                                        <thead>
                                          <tr>
                                            <th>S.No.</th>
                                            <th>Unit (En)</th>
                                            <th>Unit (Ar)</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($unit as $key=>$units)
                                          <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$units->unit}}</td>
                                            <td>{{$units->unit_ar}}</td>
                                            <td>
                                            <div class="mytoggle">
                                                  <label class="switch">
                                                     <input type="checkbox" onchange="changeStatus3(this, '<?= $units->id ?>');" <?= ($units->status == 'active' ? 'checked' : '') ?>><span class="slider"></span><span class="labels"> </span> 
                                                   </label>
                                                </div>
                                            </td>
                                            <td>
                                              <!-- <a class="comman_btn table_viewbtn" href="javscript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop10">Edit</a> -->
                                              <a class="comman_btn table_viewbtn " onclick="showunitmodal(this,'{{$units->id}}');"  href="javscript:;"  data-toggle="modal"  >Edit</a> 
                                              <a class="comman_btn table_viewbtn delete_btn" onclick="deleteUnitData(this,'{{$units->id}}');" href="javscript:;">Delete</a>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Category modal -->
<div class="modal fade comman_modal" id="staticBackdrop09" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Edit Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" id="categoryForm"> 
          @csrf
          <input type="hidden" class="form-control"  id="id" name="id" >
            <div class="form-group col-4"> 
                <label for="">Category Name (En)</label> 
                <input type="text" class="form-control" value="" id="category_name" name="category_name" > 
            </div>
            <div class="form-group col-4"> 
                <label for="">Category Name (Ar)</label> 
                <input type="text" class="form-control" value="" id="category_name_ar" name="category_name_ar" > 
            </div>
             <div class="form-group mb-0 col-auto">
                <button type="button" class="comman_btn" onclick="updateCategory(this);" >Save</button>
             </div>
          </form>
        </div> 
      </div>
    </div>
</div>
    <!-- End category modal -->

        <!-- Unit modal -->
<div class="modal fade comman_modal" id="staticBackdrop010" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Edit Unit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" id="unitForm"> 
          @csrf
          <input type="hidden" class="form-control"  id="ids" name="id" >
            <div class="form-group col-4"> 
                <label for="">Unit Name (En)</label> 
                <input type="text" class="form-control" value="" id="unit_name" name="unit_name" > 
            </div>
            <div class="form-group col-4"> 
                <label for="">Unit Name (Ar)</label> 
                <input type="text" class="form-control" value="" id="unit_name_ar" name="unit_name_ar" > 
            </div>
             <div class="form-group mb-0 col-auto">
                <button type="button" class="comman_btn" onclick="updateUnit(this);" >Save</button>
             </div>
          </form>
        </div> 
      </div>
    </div>
</div>
    <!-- End unit modal -->

  <!--modal-->
 
  <div class="modal fade comman_modal" id="staticBackdrop08" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Edit Group</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" id="carForm"> 
         @csrf
         <input type="hidden" class="form-control"  id="id" name="id" >
            <div class="form-group mb-0 col"> <label for="">Group Name (En)</label> <input type="text" class="form-control"  id="group_name" name="group_name" > </div>
            <div class="form-group mb-0 col"> <label for="">Group Name (Ar)</label> <input type="text" class="form-control"  id="group_name_ar" name="group_name_ar" > </div>
           <div class="form-group mb-0 col choose_file position-relative"> <span>Upload Image</span> <label for="image1"><i class="fal fa-camera me-1"></i>Choose File</label> <input type="file" class="form-control" id="image1"  name="images" ></div>
            <div class="form-group mb-0 col-auto"> <button type="button"  onclick="updateCar(this);" name="submit-form"   class="comman_btn">Save</button> </div>
          </form>
        </div> 
      </div>
    </div>
</div>

<!--modal-->
 <!-- Modal -->
<div class="modal fade reply_modal Import_export" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Export Excel</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <form class="Import_export_form px-4" action="">
                    <div class="form-group row mb-4">
                        <div class="col-12 mb-3 Export_head"> <label for="">Exports :</label> </div>
                        <div class="col-12">
                            <div class="comman_radio mb-2"> <input class="d-none" type="radio" id="radio1" name="radio1"> <label for="radio1">All Items</label> </div>
                            <div class="comman_radio mb-2"> <input class="d-none" type="radio" checked id="radio2" name="radio2"> <label for="radio2">Selected 50+ Items</label> </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 mb-3 Export_head"> <label for="">Exports As :</label> </div>
                        <div class="col-12">
                            <div class="comman_radio mb-2"> <input class="d-none" type="radio" checked id="radio2" name="radio2"> <label for="radio2">Excel (In Proper Format)</label> </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 
<!-- Modal -->
<div class="modal fade reply_modal Import_export" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Import Excel</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <form class="Import_export_form px-4" action="">
                    <div class="form-group row mb-4">
                        <div class="col-12 mb-3 Export_head"> <label for="">Import :</label> </div>
                        <div class="col-12">
                            <div class="comman_radio mb-2"> <input class="d-none" type="radio" id="radio1" name="radio1"> <label for="radio1">All Items</label> </div>
                            <div class="comman_radio mb-2"> <input class="d-none" type="radio" checked id="radio2" name="radio2"> <label for="radio2">Selected 50+ Items</label> </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 mb-3 Export_head"> <label for="">Import As :</label> </div>
                        <div class="col-12">
                            <div class="comman_radio mb-2"> <input class="d-none" type="radio" checked id="radio2" name="radio2"> <label for="radio2">Excel (In Proper Format)</label> </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 
@foreach($ingredient as $key=>$ingredients)
<div class="modal fade comman_modal" id="staticBackdrop07{{$ingredients->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Edit Ingredient</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="form-design py-4 px-3 help-support-form row align-items-end justify-content-between" id="queryForm1_<?=$ingredients->id?>"> 
            <div class="form-group col-4"> 
                <label for="">Ingredient Name (En)</label> 
                <input type="text" class="form-control" value="{{$ingredients->name}}" name="name" > 
            </div>
            <div class="form-group col-4">
                 <label for="">Ingredient Name (Ar)</label> <input type="text" class="form-control" value="{{$ingredients->name_ar}}" name="name_ar" > </div>
                <div class="form-group col-4"> 
                <label for="">Group</label>
                <select class="form-select form-control" name="group_id" aria-label="Default select example"> 
                    @foreach($group as $groups)
                    <option  value="{{$groups->id}}"  @if($ingredients->group['id'] == $groups['id'])  selected  @endif >{{$groups['name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-0 col"> 
                <label for="">Category</label> 
                <select class="form-select form-control" name="category_id"  aria-label="Default select example">
                    @foreach($category as $categories)
                    <option  value="{{$categories->id}}" @if($ingredients->category['id'] == $categories['id'])  selected  @endif>{{$categories['name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-0 col"> 
                <label for="">Unit</label> 
                <select class="form-select form-control" name="unit_id"  aria-label="Default select example">
                 @foreach($unit as $units)
                    <option  value="{{$units->id}}" @if($ingredients->unit['id'] == $units['id'])  selected  @endif>{{$units['unit']}}</option>
                    @endforeach
                </select>
            </div>
             <div class="form-group mb-0 col-auto">
                <button type="button" class="comman_btn" onclick="sendReply1(this,<?= $ingredients->id ?>)" >Save</button>
             </div>
          </form>
        </div> 
      </div>
    </div>
</div>
@endforeach
@endsection
<script>
   function showmodal(obj,id) {
    
      $.ajax({
        type : 'get',
        url  : "<?= url('admin/get_group/data/') ?>/" + id,
        data : {'id':id},
        success:function(data){
            console.log(data);
          $('#id').val(data.id);
          $('#group_name').val(data.name);
          $('#group_name_ar').val(data.name_ar);
          $('#staticBackdrop08').modal('show');
        }
      });
   }

</script>
<script>
   function showmodal1(obj,id) {
    
      $.ajax({
        type : 'get',
        url  : "<?= url('admin/get_category/data/') ?>/" + id,
        data : {'id':id},
        success:function(data){
            console.log(data);
          $('#id').val(data.id);
          $('#category_name').val(data.name);
          $('#category_name_ar').val(data.name_ar);
          $('#staticBackdrop09').modal('show');
        }
      });
   }

</script>
<script>
   function showunitmodal(obj,id) {
    
      $.ajax({
        type : 'get',
        url  : "<?= url('admin/get_unit/data/') ?>/" + id,
        data : {'id':id},
        success:function(data){
            console.log(data);
          $('#ids').val(data.id);
          $('#unit_name').val(data.unit);
          $('#unit_name_ar').val(data.unit_ar);
          $('#staticBackdrop010').modal('show');
        }
      });
   }

</script>
<script>
    
function updateCar(obj) {
    
var flag = true;
let  formData = new FormData($("#carForm")[0]);
formData.append('_token', "{{ csrf_token() }}");
var id = $('#id').val();
if (flag) {
    $.ajax({
        // _token: _token,
        url: "<?= url('admin/edit_group/update/') ?>/" + id,
        type: 'POST',
        enctype: 'multipart/form-data',
        // data: $("#carForm_"+id).serialize() + '&_token=<?= csrf_token() ?>',
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

<script>
    
function updateUnit(obj) {
    
var flag = true;
let  formData = new FormData($("#unitForm")[0]);
formData.append('_token', "{{ csrf_token() }}");
var id = $('#ids').val();
if (flag) {
    $.ajax({
        // _token: _token,
        url: "<?= url('admin/edit_unit/update/') ?>/" + id,
        type: 'POST',
        enctype: 'multipart/form-data',
        // data: $("#carForm_"+id).serialize() + '&_token=<?= csrf_token() ?>',
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

<script>
    
function updateCategory(obj) {
    
var flag = true;
let  formData = new FormData($("#categoryForm")[0]);
formData.append('_token', "{{ csrf_token() }}");
var id = $('#id').val();
if (flag) {
    $.ajax({
        // _token: _token,
        url: "<?= url('admin/edit_category/update/') ?>/" + id,
        type: 'POST',
        enctype: 'multipart/form-data',
        // data: $("#carForm_"+id).serialize() + '&_token=<?= csrf_token() ?>',
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

<script>
            function validate3(obj) {
            $(".text-danger").html('');
            var flag = true;
            var formData = $("#addForm3").find(".validate:input").not(':input[type=button]');
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
                $("#addForm3").submit();
            } else {
                return false;
            }

            
        }
    </script>
    <script>
      function deleteData1(obj, id){
            //var csrf_token=$('meta[name="csrf_token"]').attr('content');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this record!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url : "<?= url('admin/ingredient-delete') ?>",
                        type : "POST",
                        data : 'id=' + id + '&_token=<?= csrf_token() ?>',
                        success: function(data){
                            swal({
                                title: "Success!",
                                text : "Ingredient has been deleted \n Click OK to refresh the page",
                                icon : "success",
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error : function(){
                            swal({
                                title: 'Opps...',
                                text : data.message,
                                type : 'error',
                                timer : '1500'
                            })
                        }
                    })
                } else {
                swal("Your  file is safe!");
                }
            });
        }
        
</script>

<script>
      function deleteData(obj, id){
            //var csrf_token=$('meta[name="csrf_token"]').attr('content');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this record!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url : "<?= url('admin/group-delete') ?>",
                        type : "POST",
                        data : 'id=' + id + '&_token=<?= csrf_token() ?>',
                        success: function(data){
                            swal({
                                title: "Success!",
                                text : "Group has been deleted \n Click OK to refresh the page",
                                icon : "success",
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error : function(){
                            swal({
                                title: 'Opps...',
                                text : data.message,
                                type : 'error',
                                timer : '1500'
                            })
                        }
                    })
                } else {
                swal("Your  file is safe!");
                }
            });
        }
        
</script>

<script>
      function deleteCategoryData(obj, id){
            //var csrf_token=$('meta[name="csrf_token"]').attr('content');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this record!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url : "<?= url('admin/category-delete') ?>",
                        type : "POST",
                        data : 'id=' + id + '&_token=<?= csrf_token() ?>',
                        success: function(data){
                            swal({
                                title: "Success!",
                                text : "Category has been deleted \n Click OK to refresh the page",
                                icon : "success",
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error : function(){
                            swal({
                                title: 'Opps...',
                                text : data.message,
                                type : 'error',
                                timer : '1500'
                            })
                        }
                    })
                } else {
                swal("Your  file is safe!");
                }
            });
        }
        
</script>

<script>
  function sendReply1(obj, id) {
            if (id) {

                if (id) {
                    $.ajax({
                        url: "<?= url('admin/edit_ingredient/update/') ?>/" + id,
                        type: 'post',
                        data: $("#queryForm1_"+id).serialize()+ '&_token=<?= csrf_token() ?>',
                      
                        success: function (data) {
                            swal({
                                title: "Success!",
                                text : "Your content has been updated ",
                                icon : "success",
                                buttons: false,
                             });
                             setTimeout(function () {
                                 location.reload();
                                }, 2000);
                        }
                    });
                } else {
                    $("#error").html("Message field is required");
                }
            } else {
                var data = {message: "Something went wrong"};
                errorOccured(data);
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
            function validate1(obj) {
            $(".text-danger").html('');
            var flag = true;
            var formData = $("#addForms").find(".validate:input").not(':input[type=button]');
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
                $("#addForms").submit();
            } else {
                return false;
            }

            
        }
    </script>
        <script>
            function validate2(obj) {
            $(".text-danger").html('');
            var flag = true;
            var formData = $("#addForm2").find(".validate:input").not(':input[type=button]');
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
                $("#addForm2").submit();
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
                                    url: "<?= url('admin/group/change_status') ?>",
                                    type: 'post',
                                    data: 'id=' + id + '&action=' + status + '&_token=<?= csrf_token() ?>',
                                    success: function (data) {
                                    
                                        swal({
                                           title: "Success!",
                                            text : "Group Status has been Updated ",
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
    <script>
       function changeStatus1(obj, id) {
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
                                    url: "<?= url('admin/ingredient/change_status') ?>",
                                    type: 'post',
                                    data: 'id=' + id + '&action=' + status + '&_token=<?= csrf_token() ?>',
                                    success: function (data) {
                                    
                                        swal({
                                           title: "Success!",
                                            text : "Ingredient Status has been Updated ",
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

<script>
       function changeStatus2(obj, id) {
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
                                    url: "<?= url('admin/category/change_status') ?>",
                                    type: 'post',
                                    data: 'id=' + id + '&action=' + status + '&_token=<?= csrf_token() ?>',
                                    success: function (data) {
                                    
                                        swal({
                                           title: "Success!",
                                            text : "category Status has been Updated ",
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

<script>
       function changeStatus3(obj, id) {
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
                                    url: "<?= url('admin/unit/change_status') ?>",
                                    type: 'post',
                                    data: 'id=' + id + '&action=' + status + '&_token=<?= csrf_token() ?>',
                                    success: function (data) {
                                    
                                        swal({
                                           title: "Success!",
                                            text : "Unit Status has been Updated ",
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

<script>
      function deleteUnitData(obj, id){
            //var csrf_token=$('meta[name="csrf_token"]').attr('content');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this record!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url : "<?= url('admin/unit-delete') ?>",
                        type : "POST",
                        data : 'id=' + id + '&_token=<?= csrf_token() ?>',
                        success: function(data){
                            swal({
                                title: "Success!",
                                text : "Ingredient has been deleted \n Click OK to refresh the page",
                                icon : "success",
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error : function(){
                            swal({
                                title: 'Opps...',
                                text : data.message,
                                type : 'error',
                                timer : '1500'
                            })
                        }
                    })
                } else {
                swal("Your  file is safe!");
                }
            });
        }
        
</script>    