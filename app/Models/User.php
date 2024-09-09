<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

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
        'address',
        'emergency_contact_number'
    ];

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
