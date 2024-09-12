<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseEvaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'teaching_number',
        'teaching',
        'coursecontent_number',
        'coursecontent',
        'examination_number',
        'examination',
        'labwork_number',
        'labwork',
        'library_facilities_number',
        'library_facilities',
        'extracurricular_number',
        'extracurricular',
        'course_instructor_id',
    ];

    public function courseInstructor()
    {
        return $this->belongsTo(CourseInstructor::class);
    }
}
