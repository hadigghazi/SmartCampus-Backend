<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grades;

class GradesSeeder extends Seeder
{
    public function run()
    {
        Grades::factory()->count(10)->create();
    }
}
