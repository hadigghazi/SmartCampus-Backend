<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'student_id' => \App\Models\Student::inRandomOrder()->first()->id,
            'description' => $this->faker->text(),
            'amount_usd' => $this->faker->randomFloat(2, 0, 1000),
            'amount_lbp' => $this->faker->randomFloat(2, 0, 1000),
            'exchange_rate' => $this->faker->randomFloat(4, 1, 100),
            'payment_date' => $this->faker->date(),
        ];
    }
}
