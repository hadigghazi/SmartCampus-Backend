<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
            'published_date' => $this->faker->date(),
            'author_id' => $this->faker->numberBetween(1, 100),
            'visibility' => $this->faker->word(),
            'category' => $this->faker->word(),
        ];
    }
}
