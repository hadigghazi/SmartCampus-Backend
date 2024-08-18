<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoursePrerequisite extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'prerequisite_course_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function prerequisiteCourse()
    {
        return $this->belongsTo(Course::class, 'prerequisite_course_id');
    }
}
