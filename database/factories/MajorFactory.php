<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Faculty;

class MajorFactory extends Factory
{
    protected $model = \App\Models\Major::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'faculty_id' => Faculty::inRandomOrder()->first()->id,
        ];
    }
}
