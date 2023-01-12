<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrodcastNotification extends Model
{
    protected $table='brodcast_notifications';

    protected $fillable = [
        'notification_label',
        'date_time',
        'image',
        'description',
        'status'
   	];

	public $timestamps = true;
}
