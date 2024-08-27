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
        'current_semester_id',
        'additional_info',
        'transportation',
        'dorm_residency',
        'emergency_contact_id',
        'major_id'
    ];

    protected $attributes = [
        'passport_number' => '',
        'visa_status' => '',
        'additional_info' => null,
        'current_semester_id' => null,
    ];

    public function user()
    {
    return $this->belongsTo(User::class, 'user_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'current_semester_id');
    }

    public function emergencyContact()
    {
        return $this->belongsTo(Contact::class, 'emergency_contact_id');
    }
}
