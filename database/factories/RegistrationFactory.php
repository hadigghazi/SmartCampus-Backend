<?php

namespace Database\Factories;

use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegistrationFactory extends Factory
{
    protected $model = Registration::class;

    public function definition()
    {
        return [
            'student_id' => \App\Models\Student::inRandomOrder()->first()->id,
            'course_id' => \App\Models\Course::inRandomOrder()->first()->id,
            'instructor_id' => \App\Models\Instructor::inRandomOrder()->first()->id,
            'semester_id' => \App\Models\Semester::inRandomOrder()->first()->id,
            'status' => ->faker->randomElement(['Registered', 'Completed', 'Failed']),
        ];
    }
}
