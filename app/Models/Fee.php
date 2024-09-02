<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'course_id',
        'description',
        'amount_usd',
        'amount_lbp',
    ];

    protected $dates = ['deleted_at'];
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
