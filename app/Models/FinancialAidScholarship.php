<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialAidScholarship extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'amount',
        'type',
        'effective_date',
    ];

    protected $dates = ['deleted_at'];
}
