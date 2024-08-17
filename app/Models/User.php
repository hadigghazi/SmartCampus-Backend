<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'mother_full_name', 'email', 
        'password', 'phone_number', 'role', 'status', 'date_of_birth', 
        'nationality', 'second_nationality', 'country_of_birth', 'gender', 
        'marital_status', 'profile_picture'
    ];

    protected $hidden = ['password'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
