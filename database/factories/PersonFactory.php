<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Person;

class PersonFactory extends Factory
{
    private static $index = 0;

    private static $people = [
        [
            'firstName' => 'Bert',
            'infix' => 'van',
            'lastName' => 'Linge',
            'isActive' => true,
            'note' => 'Contactpersoon Venco',
            'createdAt' => '2024-11-22 00:00:00',
            'updatedAt' => '2024-11-22 00:00:00',
        ],
        [
            'firstName' => 'Jasper',
            'infix' => 'del',
            'lastName' => 'Monte',
            'isActive' => true,
            'note' => 'Contactpersoon Astra Sweets',
            'createdAt' => '2024-11-22 00:00:00',
            'updatedAt' => '2024-11-22 00:00:00',
        ]
    ];

    public function definition(): array
    {
        // If we've used all predefined people, start generating random ones
        if (self::$index >= count(self::$people)) {
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
        
        $person = self::$people[self::$index];
        self::$index++;
        return $person;
    }
}
