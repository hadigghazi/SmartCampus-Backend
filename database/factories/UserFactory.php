<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->optional()->firstName,
            'last_name' => $this->faker->lastName,
            'mother_full_name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'phone_number' => $this->faker->phoneNumber,
            'role' => $this->faker->randomElement(['Student', 'Admin', 'Instructor']),
            'status' => $this->faker->randomElement(['Pending', 'Approved', 'Rejected']),
            'date_of_birth' => $this->faker->date(),
            'nationality' => $this->faker->country,
            'second_nationality' => $this->faker->optional()->country,
            'country_of_birth' => $this->faker->country,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'marital_status' => $this->faker->randomElement(['Single', 'Married', 'Divorced', 'Widowed']),
            'profile_picture' => $this->faker->imageUrl(),
        ];
    }
}
