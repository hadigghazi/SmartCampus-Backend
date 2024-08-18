<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dean;

class DeanSeeder extends Seeder
{
    public function run()
    {
        Dean::factory()->count(10)->create();
    }
}
