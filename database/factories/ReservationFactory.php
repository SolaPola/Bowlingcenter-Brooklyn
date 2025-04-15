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
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }

    public function staticReservations(): array
    {
        return [
            [
                'customerId' => 1,
                'timeslotId' => 3,
                'courtId' => 3,
                'date' => '2025-04-30',
                'minutes' => 73,
                'status' => 'Betaald',
                'numberOfPeople' => 3,
                'isActive' => true,
                'note' => null,
                'createdAt' => '2025-04-15 08:20:16.000000',
                'updatedAt' => '2025-04-15 08:20:16.000000',
            ],
            [
                'customerId' => 2,
                'timeslotId' => 2,
                'courtId' => 8,
                'date' => '2025-05-16',
                'minutes' => 110,
                'status' => 'geannuleerd',
                'numberOfPeople' => 5,
                'isActive' => true,
                'note' => null,
                'createdAt' => '2025-04-15 08:20:16.000000',
                'updatedAt' => '2025-04-15 08:20:16.000000',
            ],
            // ...add the remaining records here...
            [
                'customerId' => 16,
                'timeslotId' => 7,
                'courtId' => 2,
                'date' => '2025-04-02',
                'minutes' => 64,
                'status' => 'Betaald',
                'numberOfPeople' => 1,
                'isActive' => true,
                'note' => null,
                'createdAt' => '2025-04-15 08:20:17.000000',
                'updatedAt' => '2025-04-15 08:20:17.000000',
            ],
        ];
    }
}
