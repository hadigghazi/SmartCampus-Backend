<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusRegistration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'bus_route_id',
        'registration_date',
        'status',
    ];

    protected $dates = ['deleted_at'];
}
