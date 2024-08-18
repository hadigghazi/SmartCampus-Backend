<?php

namespace Database\Factories;

use App\Models\CourseMaterial;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseMaterialFactory extends Factory
{
    protected $model = CourseMaterial::class;

    public function definition()
    {
        return [
            'course_id' => Course::factory(), 
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'file_path' => $this->faker->filePath(),
            'uploaded_by' => User::factory(),
        ];
    }
}
