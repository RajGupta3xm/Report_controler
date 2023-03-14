<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailNotification extends Model
{
    protected $table = "email_notifications";
    protected $fillable = [
        "identifier",
        "description",

    ];
}
