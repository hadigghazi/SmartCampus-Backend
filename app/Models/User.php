<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'mother_full_name', 
        'email', 'password', 'phone_number', 'role', 'status', 
        'date_of_birth', 'nationality', 'second_nationality', 
        'country_of_birth', 'gender', 'marital_status', 'profile_picture'
    ];

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function instructor()
    {
        return $this->hasOne(Instructor::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function contact()
    {
        return $this->hasOne(Contact::class);
    }

    public function news()
    {
        return $this->hasMany(News::class, 'author_id');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'author_id');
    }
}
