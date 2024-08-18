<?php

namespace Database\Factories;

use App\Models\Submission;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubmissionFactory extends Factory
{
    protected $model = Submission::class;

    public function definition()
    {
        return [
            'assignment_id' => \App\Models\Assignment::inRandomOrder()->first()->id,
            'student_id' => \App\Models\Student::inRandomOrder()->first()->id,
            'file_path' => $this->faker->filePath(),
            'submission_date' => $this->faker->date(),
            'grade' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
