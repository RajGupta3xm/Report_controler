<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use HasApiTokens,
        Notifiable;

    protected $fillable = [
        'name',
        'email',
        'image',
        'referral_code',
        'country_code',
        'mobile',
        'country',
        'device_token',
        'device_type',
        'remember_token',
        'is_otp_verified',
        'mobile_verified_at',
        'push_notification',
        'lang',
        'status',
    ];
    protected $primaryKey = 'id';
    protected $hidden = [
        'password',
    ];
    public $timestamps = true;

    public function user_referral(){
        return $this->belongsTo(ReferAndEarnUsed::class,'id','referral_id');
    }
    public function refers(){
        return $this->belongsTo(ReferAndEarnUsed::class,'id','referral_id');
    }

    public function registration_count(){
        return $this->belongsTo(ReferAndEarnUsed::class,'id','referral_id');
    }

    public function subscription(){
        return $this->hasMany(Subscription::class);
    }

    public function user_address(){
        return $this->belongsTo(UserAddress::class,'id','user_id')->where('day_selection_status','=', 'active');
    }

    
}
