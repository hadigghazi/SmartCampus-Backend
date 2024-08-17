<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Block;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition()
    {
        return [
            'number' => $this->faker->word,
            'block_id' => Block::factory(),
            'capacity' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->sentence,
        ];
    }
}
