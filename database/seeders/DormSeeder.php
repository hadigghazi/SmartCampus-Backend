<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dorm;

class DormSeeder extends Seeder
{
    public function run()
    {
        Dorm::factory(10)->create();
    }
}
