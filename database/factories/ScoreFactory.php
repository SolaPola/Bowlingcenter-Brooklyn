<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Score;

class ScoreFactory extends Factory
{
    public function definition(): array
    {
        

        return [
            'amount' => fake()->numberBetween(0, 100),
            'isActive' => true,
            'note' => fake()->optional()->sentence(),
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
