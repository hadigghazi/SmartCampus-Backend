<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'credits',
        'major_id',
        'faculty_id'
    ];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function courseInstructors()
    {
        return $this->hasMany(CourseInstructor::class);
    }

    public function prerequisites()
    {
        return $this->hasMany(CoursePrerequisite::class, 'course_id');
    }

    public function prerequisiteCourses()
    {
        return $this->hasMany(CoursePrerequisite::class, 'prerequisite_course_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function courseMaterials()
    {
        return $this->hasMany(CourseMaterial::class);
    }

    public function courseDropRequests()
    {
        return $this->hasMany(CourseDropRequest::class);
    }
}
