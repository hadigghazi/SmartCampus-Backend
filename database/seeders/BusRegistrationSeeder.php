<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusRegistration;

class BusRegistrationSeeder extends Seeder
{
    public function run()
    {
        BusRegistration::factory()->count(10)->create();
    }
}
