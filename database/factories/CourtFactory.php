<?php

namespace Database\Factories;

use App\Models\Court;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourtFactory extends Factory
{
    protected $model = Court::class;

    public function definition(): array
    {
        return [
            'number' => $this->faker->unique()->numberBetween(1, 20),
            'isActive' => $this->faker->boolean(90),
            'note' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
