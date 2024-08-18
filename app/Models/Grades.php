<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grades extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        '80'
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function registrations()
    {
        return $this->belongsTo(Registrations::class, 'id');
    }
}
