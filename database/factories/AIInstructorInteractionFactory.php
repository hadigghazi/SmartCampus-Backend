<?php

namespace Database\Factories;

use App\Models\AIInstructorInteraction;
use App\Models\User; // Reference to User factory
use Illuminate\Database\Eloquent\Factories\Factory;

class AIInstructorInteractionFactory extends Factory
{
    protected $model = AIInstructorInteraction::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'question' => $this->faker->sentence(),
            'answer' => $this->faker->paragraph(),
        ];
    }
}
