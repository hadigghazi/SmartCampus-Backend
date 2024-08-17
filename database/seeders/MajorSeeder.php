<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Major;

class MajorSeeder extends Seeder
{
    public function run()
    {
        Major::factory()->count(10)->create(); 
    }
}
