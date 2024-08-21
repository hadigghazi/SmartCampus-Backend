<?php

namespace Database\Factories;

use App\Models\MajorFacultyCampus;
use App\Models\Major;
use App\Models\FacultyCampus;
use Illuminate\Database\Eloquent\Factories\Factory;

class MajorFacultyCampusFactory extends Factory
{
    protected $model = MajorFacultyCampus::class;

    public function definition()
    {
        return [
            'major_id' => Major::factory(),
            'faculty_campus_id' => FacultyCampus::factory(),
        ];
    }
}
