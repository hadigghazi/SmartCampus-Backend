<?php

namespace Database\Factories;

use App\Models\CourseMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseMaterialFactory extends Factory
{
    protected $model = CourseMaterial::class;

    public function definition()
    {
        return [
            'course_id' => $this->faker->numberBetween(1, 100),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'file_path' => $this->faker->filePath(),
            'uploaded_by' => $this->faker->numberBetween(1, 100),
        ];
    }
}
