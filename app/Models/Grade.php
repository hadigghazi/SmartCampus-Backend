<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'registration_id',
        'grade',
        'letter_grade',
        'gpa',
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
