<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = "email_notifications";
    protected $fillable = [
        "identifier",
        "description",

    ];
}
