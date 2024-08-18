<?php

namespace Database\Factories;

use App\Models\LibraryBook;
use App\Models\Campus; // Reference to Campus factory
use Illuminate\Database\Eloquent\Factories\Factory;

class LibraryBookFactory extends Factory
{
    protected $model = LibraryBook::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'author' => $this->faker->name(),
            'isbn' => $this->faker->isbn13(),
            'copies' => $this->faker->numberBetween(1, 100),
            'publication_year' => $this->faker->year(),
            'campus_id' => Campus::factory(), // Reference the Campus factory
        ];
    }
}
