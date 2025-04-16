<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Score;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'personId' => Person::factory(),
            'scoreId' => Score::factory(),
            'membershipType' => fake()->randomElement(['Basic', 'Premium', 'VIP']),
            'isActive' => true,
            'note' => fake()->optional()->sentence(),
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
