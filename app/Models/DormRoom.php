<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class DormRoom extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'dorm_id',
        'room_number',
        'capacity',
        'available_beds',
        'floor',
        'description',
    ];

    protected $dates = ['deleted_at'];

    public function dorm()
    {
        return $this->belongsTo(Dorm::class);
    }
}
