<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'campus_id'];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function instructors()
    {
        return $this->hasMany(Instructor::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
