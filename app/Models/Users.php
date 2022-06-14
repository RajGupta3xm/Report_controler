<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Model {

    use HasApiTokens,
        Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'country_code',
        'mobile',
        'country',
        'password',
        'device_token',
        'device_type',
        'remember_token',
        'status',
    ];
    protected $primaryKey = 'id';
    protected $hidden = [
        'password',
    ];
    public $timestamps = true;

}
