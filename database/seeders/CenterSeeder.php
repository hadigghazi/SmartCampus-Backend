<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Center;

class CenterSeeder extends Seeder
{
    public function run()
    {
        Center::factory()->count(10)->create(); // Adjust count as needed
    }
}
