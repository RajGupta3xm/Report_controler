<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use OwenIt\Auditing\Contracts\Auditable;



class AppNotification extends Model /*implements Auditable*/
{
    // use \OwenIt\Auditing\Auditable;
     //This Model is used for Bill of ladings invoices.
    protected $fillable =   [
        'user_id',
        'body',
        'type',
        'status',
        'result'
        
    ];
    protected $casts = [
    	'body' => 'array',
    ];

}
