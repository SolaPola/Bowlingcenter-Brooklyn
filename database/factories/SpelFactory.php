<?php

namespace Database\Factories;

use App\Models\Spel;
use App\Models\Person;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Spel>
 */
class SpelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Spel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Simplified approach - get the first records if they exist
        $personId = Person::exists() ? Person::first()->id : Person::factory()->create()->id;
        $reservationId = Reservation::exists() ? Reservation::first()->id : Reservation::factory()->create()->id;

        return [
            'personId' => $personId,
            'reservationId' => $reservationId,
            'isActive' => true,
            'note' => null, // Simplify by using null instead of optional sentence
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
