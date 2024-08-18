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
        StudentSeeder::class,
        ContactSeeder::class,
        AdminSeeder::class,
        InstructorSeeder::class,
        AddressSeeder::class,
        FacultyCampusSeeder::class,
        CourseInstructorSeeder::class,
        DormSeeder::class,
        DormRoomSeeder::class,
        BusRouteSeeder::class,
        ExamSeeder::class,
        RegistrationSeeder::class,
        AssignmentSeeder::class,
        GradeSeeder::class,
        PaymentSeeder::class,
        FeeSeeder::class,
        FinancialAidScholarshipSeeder::class,
        ImportantDateSeeder::class,
        DormRegistrationSeeder::class,
        BusRegistrationSeeder::class,
        NewsSeeder::class
    ]);
    }
}
