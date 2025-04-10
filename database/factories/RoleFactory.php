<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'userId' => User::factory(),
            'name' => fake()->randomElement(['Admin', 'Customer', 'Employee']),
            'isActive' => true,
            'note' => fake()->optional()->sentence(),
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
