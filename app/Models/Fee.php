<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'amount_usd',
        'amount_lbp',
        'exchange_rate',
        'faculty_id',
        'credit_price_usd',
        'credit_price_lbp',
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
