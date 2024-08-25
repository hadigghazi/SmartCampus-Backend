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
    ];

    protected $dates = ['deleted_at'];

    // Exam.php
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

// Instructor.php
public function user()
{
    return $this->belongsTo(User::class);
}

// Room.php
public function block()
{
    return $this->belongsTo(Block::class);
}

// Block.php
public function campus()
{
    return $this->belongsTo(Campus::class);
}

}
