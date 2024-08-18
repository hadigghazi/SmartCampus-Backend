<?php

namespace Database\Factories;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Factories\Factory;

class GradeFactory extends Factory
{
    protected $model = Grade::class;

    public function definition()
    {
        return [
            'registration_id' => \App\Models\Registration::inRandomOrder()->first()->id,
            'grade' => $this->faker->randomFloat(2, 0, 100),
            'letter_grade' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'F']),
            'gpa' => $this->faker->randomFloat(2, 0, 4),
        ];
    }
}
