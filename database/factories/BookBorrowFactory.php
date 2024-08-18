<?php

namespace Database\Factories;

use App\Models\BookBorrow;
use App\Models\Student; // Reference to Student factory
use App\Models\LibraryBook; // Reference to LibraryBook factory
use Illuminate\Database\Eloquent\Factories\Factory;

class BookBorrowFactory extends Factory
{
    protected $model = BookBorrow::class;

    public function definition()
    {
        return [
            'student_id' => Student::factory(),
            'book_id' => LibraryBook::factory(),
            'due_date' => $this->faker->date(),
            'return_date' => $this->faker->optional()->date(),
            'status' => $this->faker->randomElement(['Borrowed', 'Returned', 'Overdue']),
            'notes' => $this->faker->optional()->paragraph(),
        ];
    }
}
