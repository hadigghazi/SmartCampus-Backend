<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FacultyCampus;

class FacultyCampusSeeder extends Seeder
{
    public function run()
    {
        FacultyCampus::factory(10)->create();
    }
}
