<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AIInstructorInteraction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ai_instructor_interactions';

    protected $fillable = [
        'user_id',
        'question',
        'answer',
    ];

    protected $dates = ['deleted_at'];
}
