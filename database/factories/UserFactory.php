<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->lastName,
            'last_name' => $this->faker->lastName,
            'mother_full_name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), // default password for all users
            'phone_number' => $this->faker->phoneNumber,
            'role' => $this->faker->randomElement(['Student', 'Admin', 'Instructor']),
            'status' => $this->faker->randomElement(['Pending', 'Approved', 'Rejected']),
            'date_of_birth' => $this->faker->date,
            'nationality' => $this->faker->country,
            'second_nationality' => $this->faker->country,
            'country_of_birth' => $this->faker->country,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'marital_status' => $this->faker->randomElement(['Single', 'Married', 'Divorced', 'Widowed']),
            'profile_picture' => $this->faker->imageUrl,
        ];
    }
}
