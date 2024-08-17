<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'admin_type' => $this->faker->randomElement(['Super Admin', 'Admin']),
            'department_id' => Department::factory(),
        ];
    }
}
