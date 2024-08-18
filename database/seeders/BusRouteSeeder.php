<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusRoute;

class BusRouteSeeder extends Seeder
{
    public function run()
    {
        BusRoute::factory(10)->create();
    }
}
