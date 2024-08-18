<?php

namespace Database\Factories;

use App\Models\DormRoom;
use App\Models\Dorm;
use Illuminate\Database\Eloquent\Factories\Factory;

class DormRoomFactory extends Factory
{
    protected $model = DormRoom::class;

    public function definition()
    {
        return [
            'dorm_id' => Dorm::inRandomOrder()->first()->id, 
            'room_number' => $this->faker->word,
            'capacity' => $this->faker->numberBetween(1, 10), 
            'available_beds' => $this->faker->numberBetween(0, 10), 
            'floor' => $this->faker->numberBetween(1, 10), 
            'description' => $this->faker->text, 
        ];
    }
}
