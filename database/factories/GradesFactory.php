<?php

namespace Database\Factories;

use App\Models\Grades;
use Illuminate\Database\Eloquent\Factories\Factory;

class GradesFactory extends Factory
{
    protected $model = Grades::class;

    public function definition()
    {
        return [
            '80' => $this->faker->,
        ];
    }
}
