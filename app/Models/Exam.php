<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'instructor_id',
        'date',
        'time',
        'duration',
        'campus_id',
        'room_id',
        'semester_id',
        'course_instructor_id',
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

public function room()
{
    return $this->belongsTo(Room::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

public function block()
{
    return $this->belongsTo(Block::class);
}

public function campus()
{
    return $this->belongsTo(Campus::class);
}

public function semester()
{
    return $this->belongsTo(Semester::class);
}

public function courseInstructor()
{
    return $this->belongsTo(CourseInstructor::class);
}


}
