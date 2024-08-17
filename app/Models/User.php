<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'mother_full_name',
        'email',
        'password',
        'phone_number',
        'role',
        'status',
        'date_of_birth',
        'nationality',
        'second_nationality',
        'country_of_birth',
        'gender',
        'marital_status',
        'profile_picture',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];
}
