<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Major;
use App\Models\Faculty;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        return [
            'code' => $this->faker->bothify('???-###'),
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'credits' => $this->faker->numberBetween(1, 5),
            'major_id' => Major::inRandomOrder()->first()->id,
            'faculty_id' => Faculty::inRandomOrder()->first()->id,
        ];
    }
}
