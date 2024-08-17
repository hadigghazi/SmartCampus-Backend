<?php
namespace Database\Factories;

use App\Models\Center;
use Illuminate\Database\Eloquent\Factories\Factory;

class CenterFactory extends Factory
{
    protected $model = Center::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'vision' => $this->faker->paragraph,
            'mission' => $this->faker->paragraph,
            'overview' => $this->faker->paragraph,
        ];
    }
}
