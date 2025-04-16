<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Court;

class CourtFactory extends Factory
{
    public function definition(): array
    {
        return [
            'number' => fake()->unique()->numberBetween(1, 20),
            'isActive' => true,
            'note' => fake()->optional()->sentence(),
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
