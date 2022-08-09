<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
class QueryReply extends Model
{
    use HasApiTokens;
    protected $table='query_reply';
    protected $fillable = [
    	'query_id',
    	'user_type',
		'reply',


   	];

	   public static  function  query(){
        return $this->belongsTo(Query::class,'id','query_id');
    }


}
