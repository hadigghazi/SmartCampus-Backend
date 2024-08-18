<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacultyCampus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'faculties_campuses';
    
    protected $fillable = [
        'faculty_id',
        'campus_id',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
}
