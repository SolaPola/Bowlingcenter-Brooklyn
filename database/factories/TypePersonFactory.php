<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use App\Models\TypePerson;

class TypePersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'naam' => fake()->randomElement(['Klant', 'Gast', 'Medewerker']),
            'isActive' => true,
            'note' => fake()->optional(0.3)->sentence(),
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
