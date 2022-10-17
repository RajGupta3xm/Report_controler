<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DislikeItem extends Model
{
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



   //protected $visible = ['id', 'name'];

}
