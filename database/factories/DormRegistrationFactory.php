<?php

namespace Database\Factories;

use App\Models\DormRegistration;
use Illuminate\Database\Eloquent\Factories\Factory;

class DormRegistrationFactory extends Factory
{
    protected $model = DormRegistration::class;

    public function definition()
    {
        return [
            'student_id' => \App\Models\Student::factory(),
            'dorm_room_id' => \App\Models\DormRoom::factory(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->optional()->date(),
            'status' => $this->faker->randomElement(['Pending', 'Confirmed', 'Canceled']),
        ];
    }
}
