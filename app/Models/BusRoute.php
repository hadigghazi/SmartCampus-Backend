<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusRoute extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'route_name',
        'description',
        'schedule',
        'capacity',
        'campus_id',
    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
}
