<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Dorm extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'capacity',
        'available_rooms',
        'campus_id',
        'address',
    ];

    protected $dates = ['deleted_at'];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
}
