<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseInstructor;

class CourseInstructorSeeder extends Seeder
{
    public function run()
    {
        CourseInstructor::factory()->count(10)->create();
    }
}
