<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    protected $table='query';
    protected $fillable=['user_id','name','email','subject','message','last_reply_id','ticket_id','type','status'];

    public function queryreply(){
        return $this->hasMany(QueryReply::class);
    }
}


