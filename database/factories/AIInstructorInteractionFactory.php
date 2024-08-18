<?php

namespace Database\Factories;

use App\Models\AIInstructorInteraction;
use Illuminate\Database\Eloquent\Factories\Factory;

class AIInstructorInteractionFactory extends Factory
{
    protected $model = AIInstructorInteraction::class;

    public function definition()
    {
        return [
            'user_id' => 1,
            'question' => $this->faker->sentence(),
            'answer' => $this->faker->paragraph(),
        ];
    }
}
