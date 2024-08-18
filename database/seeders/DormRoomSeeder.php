<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DormRoom;

class DormRoomSeeder extends Seeder
{
    public function run()
    {
        DormRoom::factory(10)->create();
    }
}
