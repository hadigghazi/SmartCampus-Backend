<?php

namespace Database\Factories;

use App\Models\CourseInstructor;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Semester;
use App\Models\Campus;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseInstructorFactory extends Factory
{
    protected $model = CourseInstructor::class;

    public function definition()
    {
        return [
            'course_id' => Course::inRandomOrder()->first()->id,
            'instructor_id' => Instructor::inRandomOrder()->first()->id,
            'semester_id' => Semester::inRandomOrder()->first()->id,
            'capacity' => $this->faker->numberBetween(10, 50),
            'campus_id' => Campus::inRandomOrder()->first()->id,
            'room_id' => Room::inRandomOrder()->first()->id,
            'schedule' => $this->faker->word() . ' ' . $this->faker->time(),
        ];
    }
}
