<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MajorFacultyCampus;

class MajorFacultyCampusSeeder extends Seeder
{
    public function run()
    {
        MajorFacultyCampus::factory()->count(10)->create();
    }
}
