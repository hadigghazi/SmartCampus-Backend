<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LibraryBook extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
         'isbn', 'title', 'author', 'description', 'publication_year',
        'copies', 'campus_id', 'pages'
    ];

    protected $dates = ['deleted_at'];
}
