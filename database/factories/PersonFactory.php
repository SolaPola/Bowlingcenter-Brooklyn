<?php

namespace Database\Factories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    protected $model = Person::class;

    public function definition(): array
    {
        return [
            'firstName' => $this->faker->firstName(),
            'infix' => $this->faker->boolean(50) ? $this->faker->word() : null,
            'lastName' => $this->faker->lastName(),
            'isActive' => $this->faker->boolean(90),
            'note' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
