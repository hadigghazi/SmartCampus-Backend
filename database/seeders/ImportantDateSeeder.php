<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ImportantDate;

class ImportantDateSeeder extends Seeder
{
    public function run()
    {
        ImportantDate::factory()->count(10)->create();
    }
}
