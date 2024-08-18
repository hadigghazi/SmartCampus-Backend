<?php

namespace Database\Factories;

use App\Models\AcademicCalendar;
use Illuminate\Database\Eloquent\Factories\Factory;

class AcademicCalendarFactory extends Factory
{
    protected $model = AcademicCalendar::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->text,
            'date' => $this->faker->date(),
            'end_date' => $this->faker->optional()->date(),
            'type' => $this->faker->randomElement(['Deadline', 'Event', 'Holiday', 'Other']),
        ];
    }
}
