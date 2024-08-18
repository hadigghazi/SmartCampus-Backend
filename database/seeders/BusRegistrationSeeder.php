<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusRegistration;

class BusRegistrationSeeder extends Seeder
{
    public function run()
    {
        $studentId = 1; 
        $busRouteId = 1; 

        BusRegistration::create([
            'student_id' => $studentId,
            'bus_route_id' => $busRouteId,
            'registration_date' => '2024-08-18',
            'status' => 'Confirmed',
        ]);
    }
}
