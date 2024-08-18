<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CoursePrerequisite;

class CoursePrerequisiteSeeder extends Seeder
{
    public function run()
    {
        CoursePrerequisite::factory(10)->create();
    }
}
