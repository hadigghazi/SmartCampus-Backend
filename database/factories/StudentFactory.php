<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use App\Models\Semester;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'government_id' => $this->faker->bothify('??#####'),
            'civil_status_number' => $this->faker->bothify('??#####'),
            'passport_number' => $this->faker->bothify('??#####'),
            'visa_status' => $this->faker->word(),
            'native_language' => $this->faker->word(),
            'secondary_language' => $this->faker->word(),
            'current_semester_id' => Semester::factory(),
            'additional_info' => $this->faker->paragraph(),
            'transportation' => $this->faker->boolean(),
            'dorm_residency' => $this->faker->boolean(),
            'emergency_contact_id' => Contact::factory(),
        ];
    }
}
