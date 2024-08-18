<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookBorrow;

class BookBorrowSeeder extends Seeder
{
    public function run()
    {
        BookBorrow::factory()->count(10)->create();
    }
}
