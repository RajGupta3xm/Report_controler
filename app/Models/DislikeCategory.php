<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DislikeCategory extends Model
{
   protected $table="dislike_category";
   protected $fillable = [
        'id',
        'name',
        'name_ar',
        'image',
        'status'
    ];


    function items(){
      return $this->hasMany(DislikeItem::class,'category_id','id');
    }

    public function ingredient(){
      return $this->hasMany(DislikeItem::class,'category_id','id');
    }
}
