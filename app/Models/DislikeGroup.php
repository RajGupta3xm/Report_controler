<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DislikeGroup extends Model
{
   protected $table="dislike_group";
   protected $fillable = [
        'id',
        'name',
        'name_ar',
        'image',
        'status'
    ];

    public function group(){
        return $this->hasMany(DislikeItem::class ,'group_id','id');
    }

}
