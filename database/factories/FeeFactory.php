<?php

namespace Database\Factories;

use App\Models\Fee;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeeFactory extends Factory
{
    protected $model = Fee::class;

    public function definition()
    {
        return [
            'description' => $this->faker->text(),
            'amount_usd' => $this->faker->randomFloat(2, 0, 1000),
            'amount_lbp' => $this->faker->randomFloat(2, 0, 1000),
            'exchange_rate' => $this->faker->randomFloat(4, 1, 100),
            'faculty_id' => \App\Models\Faculty::inRandomOrder()->first()->id,
            'credit_price_usd' => $this->faker->randomFloat(2, 0, 1000),
            'credit_price_lbp' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}
