<?php

namespace Database\Factories;

use App\Models\Dorm;
use App\Models\Campus;
use Illuminate\Database\Eloquent\Factories\Factory;

class DormFactory extends Factory
{
    protected $model = Dorm::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->text(),
            'capacity' => $this->faker->numberBetween(50, 500),
            'available_rooms' => $this->faker->numberBetween(1, 100),
            'campus_id' => Campus::inRandomOrder()->first()->id,
            'address' => $this->faker->address(),
        ];
    }
}
