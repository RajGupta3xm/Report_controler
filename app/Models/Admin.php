<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Admin extends Model
{
    use HasApiTokens;
    protected $table='admin';
    protected $fillable = [
    	'name',
    	'staff_member_id',
    	'email',
		'image',
		'type',
    	'password'
   	];

   	protected $hidden =[
		'password', 'remember_token'
	];
	
	public $timestamps = true;
}
