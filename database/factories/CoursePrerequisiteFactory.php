<?php

namespace Database\Factories;

use App\Models\CoursePrerequisite;
use Illuminate\Database\Eloquent\Factories\Factory;

class CoursePrerequisiteFactory extends Factory
{
    protected $model = CoursePrerequisite::class;

    public function definition()
    {
        return [
            'course_id' => \App\Models\Course::inRandomOrder()->first()->id,
            'prerequisite_course_id' => \App\Models\Course::inRandomOrder()->first()->id,
        ];
    }
}
