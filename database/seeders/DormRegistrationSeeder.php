<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DormRegistration;

class DormRegistrationSeeder extends Seeder
{
    public function run()
    {
        DormRegistration::factory()->count(10)->create();
    }
}
