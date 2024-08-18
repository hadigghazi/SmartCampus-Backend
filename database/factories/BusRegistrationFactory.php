<?php

namespace Database\Factories;

use App\Models\BusRegistration;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusRegistrationFactory extends Factory
{
    protected $model = BusRegistration::class;

    public function definition()
    {
        return [
            'student_id' => $this->faker->numberBetween(1, 100),
            'bus_route_id' => $this->faker->numberBetween(1, 2),
            'registration_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['Pending', 'Confirmed', 'Canceled']),
        ];
    }
}
