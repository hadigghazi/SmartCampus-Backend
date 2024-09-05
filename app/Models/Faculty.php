<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculty extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', "credit_price_usd"];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function campuses()
    {
        return $this->belongsToMany(Campus::class, 'faculties_campuses');
    }

    public function majors()
    {
        return $this->hasMany(Major::class);
    }

    public function deans()
    {
        return $this->hasMany(Dean::class);
    }
}
