<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LibraryBook;

class LibraryBookSeeder extends Seeder
{
    public function run()
    {
        LibraryBook::factory()->count(10)->create();
    }
}
