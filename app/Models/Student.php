<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'government_id',
        'civil_status_number',
        'passport_number',
        'visa_status',
        'native_language',
        'secondary_language',
        'additional_info',
        'transportation',
        'dorm_residency',
        'major_id'
    ];

    protected $attributes = [
        'passport_number' => '',
        'visa_status' => '',
        'additional_info' => null,
    ];

    public function user()
    {
    return $this->belongsTo(User::class, 'user_id');
    }

    public function emergencyContact()
    {
        return $this->belongsTo(Contact::class, 'emergency_contact_id');
    }
}
