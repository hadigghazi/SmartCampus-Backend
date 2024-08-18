<?php

namespace Database\Factories;

use App\Models\Dean;
use App\Models\Faculty;
use App\Models\Campus;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeanFactory extends Factory
{
    protected $model = Dean::class;

    public function definition()
    {
        return [
            'faculty_id' => Faculty::inRandomOrder()->first()->id,
            'campus_id' => Campus::inRandomOrder()->first()->id,
            'role_description' => $this->faker->paragraph(),
        ];
    }
}
