<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campus extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'location', 'description'];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function faculties()
    {
        return $this->belongsToMany(Faculty::class, 'faculties_campuses');
    }

    public function dorms()
    {
        return $this->hasMany(Dorm::class);
    }

    public function busRoutes()
    {
        return $this->hasMany(BusRoute::class);
    }

    public function libraryBooks()
    {
        return $this->hasMany(LibraryBook::class);
    }

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }
}
