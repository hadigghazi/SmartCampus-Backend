<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Semester extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'start_date', 'end_date', 'is_current'];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function courseInstructors()
    {
        return $this->hasMany(CourseInstructor::class);
    }
}
