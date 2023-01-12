<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopUpNotification extends Model
{
    protected $table='popup_notifications';

    protected $fillable = [
    	'notification_label',
    	'date_time',
        'image',
        'description',
        'status'
   	];

	public $timestamps = true;
}
