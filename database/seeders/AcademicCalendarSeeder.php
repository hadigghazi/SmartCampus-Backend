<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicCalendar;

class AcademicCalendarSeeder extends Seeder
{
    public function run()
    {
        AcademicCalendar::factory()->count(10)->create();
    }
}
