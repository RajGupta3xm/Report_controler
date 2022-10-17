<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffGroup extends Model
{
    protected $table='staff_group';
    protected $fillable = [
    	'id',
    	'name',
    	'name_ar',
    	'image',
    	'status',
    	

   	];

	public $timestamps = true;
	
	public function group(){
		return $this->belongsTo(StaffMembers::class);
	}
}