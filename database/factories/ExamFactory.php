<?php

namespace Database\Factories;

use App\Models\Exam;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamFactory extends Factory
{
    protected $model = Exam::class;

    public function definition()
    {
        return [
            'course_id' => \App\Models\Course::inRandomOrder()->first()->id,
            'instructor_id' => \App\Models\Instructor::inRandomOrder()->first()->id,
            'date' => $this->faker->date(),
            'time' => $this->faker->time(),
            'duration' => $this->faker->numberBetween(60, 180),
            'campus_id' => \App\Models\Campus::inRandomOrder()->first()->id,
            'room_id' => \App\Models\Room::inRandomOrder()->first()->id,
        ];
    }
}
