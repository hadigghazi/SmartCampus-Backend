<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'description',
        'amount_usd',
        'amount_lbp',
        'exchange_rate',
        'payment_date',
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
