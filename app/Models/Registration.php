<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'course_id',
        'instructor_id',
        'semester_id',
        'status',
    ];

    protected $dates = ['deleted_at'];

    public function courseInstructor()
    {
        return $this->belongsTo(CourseInstructor::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function grade()
{
    return $this->hasOne(Grade::class, 'registration_id');
}

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

}
