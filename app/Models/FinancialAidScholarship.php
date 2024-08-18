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
        'type',
        'amount_usd',
        'amount_lbp',
        'description',
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
