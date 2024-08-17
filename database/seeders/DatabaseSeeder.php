<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([ CampusSeeder::class,
        FacultySeeder::class, 
        DepartmentSeeder::class, 
        CenterSeeder::class, 
        MajorSeeder::class, 
        BlockSeeder::class, 
        RoomSeeder::class,
        CourseSeeder::class,
        SemesterSeeder::class,
        UserSeeder::class,
        StudentSeeder::class
    ]);
    }
}
