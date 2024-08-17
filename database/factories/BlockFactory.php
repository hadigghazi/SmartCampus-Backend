<?php

namespace Database\Factories;

use App\Models\Block;
use App\Models\Campus;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlockFactory extends Factory
{
    protected $model = Block::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'campus_id' => Campus::factory(), 
            'description' => $this->faker->paragraph,
        ];
    }
}
