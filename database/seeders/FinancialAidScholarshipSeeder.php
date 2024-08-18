<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinancialAidScholarship;

class FinancialAidScholarshipSeeder extends Seeder
{
    public function run()
    {
        FinancialAidScholarship::factory()->count(10)->create();
    }
}
