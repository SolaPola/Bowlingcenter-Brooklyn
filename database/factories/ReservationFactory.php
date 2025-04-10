<?php

namespace Database\Factories;

use App\Models\Court;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Timeslot;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition(): array
    {
        return [
            'customerId' => Customer::factory(),
            'timeslotId' => Timeslot::factory(),
            'courtId' => Court::factory(),
            'date' => $this->faker->dateTimeBetween('now', '+2 months')->format('Y-m-d'),
            'minutes' => $this->faker->randomElement([30, 60, 90, 120]),
            'status' => $this->faker->randomElement(['Pending', 'Confirmed', 'Completed', 'Cancelled']),
            'numberOfPeople' => $this->faker->numberBetween(1, 8),
            'isActive' => $this->faker->boolean(90),
            'note' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
