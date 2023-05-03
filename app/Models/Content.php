<?php

namespace App\Models;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;

class Content extends Model
{
   protected $table = "contents";
   protected $fillable = ['id','name','content','content_ar','status'];

   public static function fetchtremsData($data){
    $lang = (($request->hasHeader('X-localization')) ? $request->header('X-localization') : 'en');
    if($lang == 'ar'){ 
      return self::select('content_ar')->where('name',$data)->first();
    }else{
        return self::select('content')->where('name',$data)->first();
    }
  }

  public function getContentAttribute($value)
  {
      if(\Session::get('locale') == 'ar') {
          // dd('dd');
          return $this->description_ar;
      }
      return $value;
  }
}
