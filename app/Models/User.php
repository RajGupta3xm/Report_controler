<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Model {

    use HasApiTokens,
        Notifiable;

    protected $fillable = [
        'name',
        'email',
        'image',
        'country_code',
        'mobile',
        'country',
        'device_token',
        'device_type',
        'remember_token',
        'is_otp_verified',
        'mobile_verified_at',
        'push_notification',
        'status',
    ];
    protected $primaryKey = 'id';
    protected $hidden = [
        'password',
    ];
    public $timestamps = true;

}
