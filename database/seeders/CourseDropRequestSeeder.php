<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseDropRequest;

class CourseDropRequestSeeder extends Seeder
{
    public function run()
    {
        CourseDropRequest::factory()->count(10)->create();
    }
}
