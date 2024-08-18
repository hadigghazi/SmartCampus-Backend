<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AIInstructorInteraction;

class AIInstructorInteractionSeeder extends Seeder
{
    public function run()
    {
        AIInstructorInteraction::factory()->count(10)->create();
    }
}
