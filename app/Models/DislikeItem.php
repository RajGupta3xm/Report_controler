<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DislikeItem extends Model
{

   protected $table="dislike_items";
   protected $fillable = [
        'id',
        'group_id',
        'category_id',
        'unit_id',
        'name',
        'name_ar',
        'status'
    ];

    public function group(){
      return $this->belongsTo(DislikeGroup::class);
  }

  public function category(){
   return $this->belongsTo(DislikeCategory::class);
}

public function unit(){
   return $this->belongsTo(Unit::class);
}

public function units(){
   return $this->belongsTo(DislikeUnit::class,'unit_id','id');
}
public function categorys(){
   return $this->belongsTo(DislikeCategory::class,'category_id','id');
}




   //protected $visible = ['id', 'name'];

}
