<?php

namespace Database\Factories;

use App\Models\FinancialAidScholarship;
use Illuminate\Database\Eloquent\Factories\Factory;

class FinancialAidScholarshipFactory extends Factory
{
    protected $model = FinancialAidScholarship::class;

    public function definition()
    {
        return [
            'student_id' => \App\Models\Student::inRandomOrder()->first()->id,
            'type' => $this->faker->word(),
            'amount_usd' => $this->faker->randomFloat(2, 0, 1000),
            'amount_lbp' => $this->faker->randomFloat(2, 0, 1000),
            'description' => $this->faker->text(),
        ];
    }
}
