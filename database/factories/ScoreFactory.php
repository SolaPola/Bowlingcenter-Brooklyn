<?php

namespace Database\Factories;

use App\Models\Score;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScoreFactory extends Factory
{
    protected $model = Score::class;

    public function definition(): array
    {
        return [
            'amount' => $this->faker->numberBetween(0, 300),
            'isActive' => $this->faker->boolean(90),
            'note' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
