<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseInstructor extends Model
{
    use SoftDeletes;

    protected $table = 'course_instructors';

    protected $fillable = [
        'course_id',
        'instructor_id',
        'semester_id',
        'capacity',
        'campus_id',
        'room_id',
        'schedule',
    ];

    protected $dates = ['deleted_at'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function registrations()
{
    return $this->hasMany(Registration::class);
}

}
