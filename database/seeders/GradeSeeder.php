<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradeSeeder extends Seeder
{
    public function run()
    {
        Grade::factory()->count(10)->create();
    }
}
