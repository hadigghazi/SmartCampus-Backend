<?php

namespace Database\Factories;

use App\Models\Dean;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeanFactory extends Factory
{
    protected $model = Dean::class;

    public function definition()
    {
        return [
            'faculty_id' => $this->faker->numberBetween(1, 100),
            'campus_id' => $this->faker->numberBetween(1, 100),
            'role_description' => $this->faker->paragraph(),
        ];
    }
}
