<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditTransaction extends Model
{
    protected $table="credit_transactions";
    protected $fillable = [
        "user_id",
        "transaction_type",
        "credit_type",
        "balance_amount",
        "amount",


    ];
}
