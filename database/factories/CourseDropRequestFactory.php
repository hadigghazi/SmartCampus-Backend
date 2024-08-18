<?php

namespace Database\Factories;

use App\Models\CourseDropRequest;
use App\Models\Student; // Reference to Student factory
use App\Models\Course; // Reference to Course factory
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseDropRequestFactory extends Factory
{
    protected $model = CourseDropRequest::class;

    public function definition()
    {
        return [
            'student_id' => 1,
            'course_id' => Course::factory(),
            'reason' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['Pending', 'Approved', 'Rejected']),
        ];
    }
}
