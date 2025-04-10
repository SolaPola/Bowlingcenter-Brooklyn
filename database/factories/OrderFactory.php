<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'reservationId' => Reservation::factory(),
            'orderNumber' => fake()->unique()->randomNumber(5),
            'orderDate' => fake()->date(),
            'isActive' => true,
            'note' => fake()->optional()->sentence(),
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
