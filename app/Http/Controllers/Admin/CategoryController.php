<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Response;
use Session;
use App\Http\Requests\UsersRequest as StoreRequest;
use App\Http\Requests\UsersRequest as UpdateRequest;
use App\Http\Controllers\CrudOverrideController;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class CategoryController extends Controller {

    private $URI_PLACEHOLDER;
    private $jsondata;
    private $redirect;
    protected $message;
    protected $status;
    private $prefix;

    public function __construct() {
        $this->middleware('admin');
        // dd('aaaa');
        $this->jsondata = [];
        $this->message = false;
        $this->redirect = false;
        $this->status = false;
        $this->prefix = \DB::getTablePrefix();
        $this->URI_PLACEHOLDER = \Config::get('constants.URI_PLACEHOLDER');
    }

    public function index() {
        if (!Auth::guard('admin')->check()) {
            return redirect()->intended('admin/login');
        } else {
            $category = Category::where('status', '<>', '2')->orderBy('id', 'DESC')->get();
            $data['categories'] = $category;
            return view('admin.category.category_list')->with($data);
        }
    }

    public function store(Request $request) {
        $insert_arr = [
            'name' => ucwords($request->input('category_name'))
        ];


        $add = Category::create($insert_arr);
        if ($add) {
            return redirect('admin/category-management')->with('success', 'Category added succesfully');
        } else {
            
        }
        return back()->withInput()->with('error', 'Error while adding category');
    }

    public function change_category_status(Request $request) {
        $id = $request->input('id');
        $status = $request->input('action');
        $update = Category::find($id)->update(['status' => $status]);
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
        }
    }

    public function delete_category(Request $request) {
        $id = $request->input('id');
        $update = Category::find($id)->update(['status' => '2']);
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Category deleted successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while deleting category']);
        }
    }

    public function edit(Request $request, $id = null) {
        $id = base64_decode($id);
        $category = Category::find($id);
        if ($category) {
            $data['category'] = $category;
            return view('admin.category.edit_category')->with($data);
        } else {
            return redirect('admin/category-management')->with('error', 'Category not found');
        }
    }

    public function update(Request $request, $id = null) {
        $id = base64_decode($id);
        $insert_arr = [
            'name' => ucwords($request->input('category_name'))
        ];
        $update = Category::where('id', $id)->update($insert_arr);
        if ($update) {
            return redirect('admin/category-management')->with('success', 'Category Updated Succesfully');
        }
        return back()->withInput()->with('error', 'Error while updating Category');
    }

}
