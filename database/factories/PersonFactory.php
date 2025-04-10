<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    public function definition(): array
    {
        return [
            'firstName' => fake()->firstName(),
            'infix' => fake()->optional()->word(),
            'lastName' => fake()->lastName(),
            'isActive' => true,
            'note' => fake()->optional()->sentence(),
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
