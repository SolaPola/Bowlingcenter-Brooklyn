<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Score;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'personId' => Person::factory(),
            'scoreId' => Score::factory(),
            'membershipType' => $this->faker->randomElement(['Standard', 'Premium', 'VIP']),
            'isActive' => $this->faker->boolean(80), // 80% chance of being active
            'note' => $this->faker->optional(0.3)->sentence(),
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
