<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MajorFacultyCampus extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'major_id',
        'faculty_campus_id',
    ];

    protected $dates = ['deleted_at'];
}
