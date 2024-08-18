<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseMaterial;

class CourseMaterialSeeder extends Seeder
{
    public function run()
    {
        CourseMaterial::factory()->count(10)->create();
    }
}
