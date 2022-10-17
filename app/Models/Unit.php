<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table="dislike_units";
    protected $fillable = [
        "id",
        "unit",
        "unit_ar",

    ];

    public function ingredient(){
        return $this->hasMany(DislikeItem::class,'unit_id','id');
      }
}
