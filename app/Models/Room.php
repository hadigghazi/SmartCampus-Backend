<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'number',
        'block_id',
        'capacity',
        'description'
    ];

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function courseInstructors()
    {
        return $this->hasMany(CourseInstructor::class);
    }
}
