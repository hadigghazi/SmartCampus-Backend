<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fee;

class FeeSeeder extends Seeder
{
    public function run()
    {
        Fee::factory()->count(10)->create();
    }
}
