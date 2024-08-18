<?php

namespace Database\Factories;

use App\Models\FacultyCampus;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacultyCampusFactory extends Factory
{
    protected $model = FacultyCampus::class;

    public function definition()
    {
        return [
            'faculty_id' => \App\Models\Faculty::inRandomOrder()->first()->id,
            'campus_id' => \App\Models\Campus::inRandomOrder()->first()->id,
        ];
    }
}
