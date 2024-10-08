<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dean extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'faculty_id',
        'campus_id',
        'role_description',
    ];

    protected $dates = ['deleted_at'];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
