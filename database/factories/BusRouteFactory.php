<?php

namespace Database\Factories;

use App\Models\BusRoute;
use App\Models\Campus;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusRouteFactory extends Factory
{
    protected $model = BusRoute::class;

    public function definition()
    {
        return [
            'route_name' => $this->faker->word,
            'description' => $this->faker->text,
            'schedule' => $this->faker->text,
            'capacity' => $this->faker->numberBetween(10, 100),
            'campus_id' => Campus::inRandomOrder()->first()->id,
        ];
    }
}
