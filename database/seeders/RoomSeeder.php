<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;


class RoomSeeder extends Seeder
{
    public function run()
{
    Room::factory(10)->create(); 
}
}
