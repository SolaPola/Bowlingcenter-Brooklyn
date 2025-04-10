<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Timeslot;
use App\Models\Court;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customerId' => Customer::factory(),
            'timeslotId' => Timeslot::factory(),
            'courtId' => Court::factory(),
            'date' => fake()->date(),
            'minutes' => fake()->numberBetween(30, 120),
            'status' => fake()->randomElement(['In behandeling', 'Betaald', 'geannuleerd']),
            'numberOfPeople' => fake()->numberBetween(1, 6),
            'isActive' => true,
            'note' => fake()->optional()->sentence(),
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
