<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentSetting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'exchange_rate',
        'lbp_percentage',
        'registration_fee_usd',
        'effective_date',
    ];

    protected $dates = ['deleted_at'];
}
