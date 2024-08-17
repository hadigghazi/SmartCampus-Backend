<?php

namespace Database\Factories;

use App\Models\Campus;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampusFactory extends Factory
{
    protected $model = Campus::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'location' => $this->faker->address(),
            'description' => $this->faker->optional()->paragraph(),
        ];
    }
}
