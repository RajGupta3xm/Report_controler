<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionOrder extends Model
{
    // use HasApiTokens;
    
        protected $table='subscription_orders';
    
        protected $fillable = [
            "id",
            "user_id",
            'subscription_id',
            'txn_id',
            'amount',
            'payment_status',

        ];

  
}
