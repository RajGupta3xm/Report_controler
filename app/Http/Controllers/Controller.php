<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    protected $status = false;
    protected $errors = [];
    protected $data = [];
    protected $error = '';
    protected $message = '';
    protected $status_code = 200;

    protected function populateResponse($used_validator = true) {
        if ($this->status == false) {
            if ($used_validator) {
                $this->error = $this->message->first();
                $this->errors = $this->message;
            } else {
                $this->error = $this->message;
            }
            $this->message = "";
        }

        return response()->json([
                    'status' => $this->status,
                    'status_code' => $this->status_code,
                    'data' => $this->data,
                    'error' => $this->error,
                    'errors' => $this->errors,
                    'message' => $this->message
        ]);
    }

    public function uploadfile($path, $file) {
        $fullName = $file->getClientOriginalName();
        $stringName = $this->my_random_string(explode('.', $fullName)[0]);
        $fileName = $stringName . time() . '.' . (($file->getClientOriginalExtension() == 'jpg' || $file->getClientOriginalExtension() == 'jpeg') ? 'png' : $file->getClientOriginalExtension());
        $destinationPath = public_path('/public' . $path);
        $check = $file->move(base_path() . '/public' . $path, $fileName);
        $return = $check ? $fileName : false;
        // $imageName = time().'.'.$filename;
        // $return = $file->move(
        // base_path() . '/public/'.$path, $imageName);
        $url = url($path);
        $image = $url . '/' . $fileName;
        return $image;
    }

    public function my_random_string($char) {
        return uniqid('diety');
    }

    public function authfail() {
        $this->message = 'Authentication Failed';
        $this->status_code = 301;
        return response()->json([
                    'status' => $this->status,
                    'status_code' => $this->status_code,
                    'data' => $this->data,
                    'error' => $this->error,
                    'errors' => $this->errors,
                    'message' => $this->message
        ]);
    }


    public function index(){
        return view('landingpage');
    }

    public function about(){
        return view('about');
    }

    public function terms_condition(){
        return view('terms_condition');
    }

    public function privacy_policy(){
        return view('privacy_policy');
    }

}
