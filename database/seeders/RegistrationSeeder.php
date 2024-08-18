<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Registration;

class RegistrationSeeder extends Seeder
{
    public function run()
    {
         = [
            // Add sample data here
        ];

        foreach ($items as $item) {
            Registration::create($item);
        }
    }
}
