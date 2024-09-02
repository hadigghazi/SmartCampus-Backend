<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentUsd extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'description',
        'amount_paid',
        'payment_date',
        'currency',
    ];

    protected $dates = ['deleted_at'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
