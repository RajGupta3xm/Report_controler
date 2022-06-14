<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
    	'user_id',
        'parent_post_id',
    	'video_privacy',
    	'video_type',
    	'category_id',
    	'title',
    	'description',
    	'thumbnail',
    	'video',
        'tags',
	'status'
   	];
	public $timestamps = true;


    public function createdbyUser(){
        return $this->belongsTo('App\Models\Users' , 'user_id','id');
    }

    public function postDetail($query,$post){

    }
}
