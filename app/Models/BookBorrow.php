<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookBorrow extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'book_id',
        'due_date',
        'return_date',
        'status',
        'notes',
    ];

    protected $dates = ['due_date', 'return_date', 'deleted_at'];
}
