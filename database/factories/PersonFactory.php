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
            'firstName' => 'Mazin',
            'infix' => null,
            'lastName' => 'Jamil',
            'nickname' => 'Mazin',
            'isAdult' => true,
            'isActive' => true,
            'note' => null,
            'createdAt' => '2024-01-01 00:00:00',
            'updatedAt' => '2024-01-01 00:00:00',
        ],
        [
            'firstName' => 'Arjan',
            'infix' => 'de',
            'lastName' => 'Ruijter',
            'nickname' => 'Arjan',
            'isAdult' => true,
            'isActive' => true,
            'note' => null,
            'createdAt' => '2024-01-01 00:00:00',
            'updatedAt' => '2024-01-01 00:00:00',
        ],
        [
            'firstName' => 'Hans',
            'infix' => null,
            'lastName' => 'Odijk',
            'nickname' => 'Hans',
            'isAdult' => true,
            'isActive' => true,
            'note' => null,
            'createdAt' => '2024-01-01 00:00:00',
            'updatedAt' => '2024-01-01 00:00:00',
        ],
        [
            'firstName' => 'Dennis',
            'infix' => 'van',
            'lastName' => 'Wakeren',
            'nickname' => 'Dennis',
            'isAdult' => true,
            'isActive' => true,
            'note' => null,
            'createdAt' => '2024-01-01 00:00:00',
            'updatedAt' => '2024-01-01 00:00:00',
        ],
        [
            'firstName' => 'Wilco',
            'infix' => 'Van de',
            'lastName' => 'Grift',
            'nickname' => 'Wilco',
            'isAdult' => true,
            'isActive' => true,
            'note' => null,
            'createdAt' => '2024-01-01 00:00:00',
            'updatedAt' => '2024-01-01 00:00:00',
        ],
        [
            'firstName' => 'Tom',
            'infix' => null,
            'lastName' => 'Sanders',
            'nickname' => 'Tom',
            'isAdult' => false,
            'isActive' => true,
            'note' => null,
            'createdAt' => '2024-01-01 00:00:00',
            'updatedAt' => '2024-01-01 00:00:00',
        ],
        [
            'firstName' => 'Andrew',
            'infix' => null,
            'lastName' => 'Sanders',
            'nickname' => 'Andrew',
            'isAdult' => false,
            'isActive' => true,
            'note' => null,
            'createdAt' => '2024-01-01 00:00:00',
            'updatedAt' => '2024-01-01 00:00:00',
        ],
        [
            'firstName' => 'Julian',
            'infix' => null,
            'lastName' => 'Kaldenheuvel',
            'nickname' => 'Julian',
            'isAdult' => true,
            'isActive' => true,
            'note' => null,
            'createdAt' => '2024-01-01 00:00:00',
            'updatedAt' => '2024-01-01 00:00:00',
        ],
    ];

    public function definition(): array
    {
        // If we've used all predefined people, start generating random ones
        if (self::$index >= count(self::$people)) {
            return [
                'firstName' => fake()->firstName(),
                'infix' => fake()->optional()->word(),
                'lastName' => fake()->lastName(),
                'nickname' => fake()->optional()->firstName(),
                'isAdult' => fake()->boolean(70), // 70% chance of being an adult
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
