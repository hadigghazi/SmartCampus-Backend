<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'country',
        'area',
        'city',
        'street',
        'building_floor',
        'special_instruction',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
