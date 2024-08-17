<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'government_id' => $this->faker->word,
            'civil_status_number' => $this->faker->word,
            'passport_number' => $this->faker->word,
            'visa_status' => $this->faker->word,
            'native_language' => $this->faker->word,
            'secondary_language' => $this->faker->word,
            'current_semester_id' => \App\Models\Semester::factory(),
            'additional_info' => $this->faker->text,
            'transportation' => $this->faker->boolean,
            'dorm_residency' => $this->faker->boolean,
            'emergency_contact_id' => \App\Models\Contact::factory(),
        ];
    }
}
