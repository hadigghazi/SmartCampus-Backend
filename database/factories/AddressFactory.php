<?php
namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'country' => $this->faker->country,
            'area' => $this->faker->streetSuffix,
            'city' => $this->faker->city,
            'street' => $this->faker->streetAddress,
            'building_floor' => $this->faker->secondaryAddress,
            'special_instruction' => $this->faker->sentence,
        ];
    }
}
