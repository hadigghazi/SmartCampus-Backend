<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseMaterial extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_instructor_id',
        'title',
        'description',
        'file_path',
        'file_name',
        'uploaded_by',
    ];

    protected $dates = ['deleted_at'];

    public function instructor()
    {
        return $this->belongsTo(CourseInstructor::class, 'course_instructor_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
